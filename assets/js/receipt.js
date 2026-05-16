// Receipt Display Logic (PHP API Version)
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('orderId');

    if (!orderId) {
        alert("Verification Error: No Order ID found.");
        window.location.href = '../index.php';
        return;
    }

    // --- Set initial walker position immediately so GIF starts at the left edge ---
    const walkerInit = document.getElementById('walking-anim');
    const progressInit = document.getElementById('status-progress');
    if (walkerInit) walkerInit.style.left = '0%';
    if (progressInit) progressInit.style.width = '0%';

    // Fetch Order from Server
    fetch(`../api/crud/api_orders.php?id=${orderId}`)
        .then(res => res.json())
        .then(order => {
            if (!order || order.error) {
                alert("Order not found or database error!");
                return;
            }
            updateReceiptUI(order);
            updateTrackerStatus(order.status);
            startStatusPolling(orderId);
        });

    function updateReceiptUI(order) {
        document.getElementById('game-name').innerText = order.game;
        document.getElementById('item-amount').innerText = `${order.qty}x ${order.item}`;
        document.getElementById('item-price').innerText = `\u20b1${parseFloat(order.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        document.getElementById('total-paid').innerText = `\u20b1${parseFloat(order.total).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        document.getElementById('payment-method').innerText = order.method.toUpperCase();
        document.getElementById('ref-no').innerText = order.order_id;

        const date = new Date(order.timestamp);
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('datetime').innerText = date.toLocaleDateString('en-US', options).replace(',', ' |');

        if (order.userid) {
            document.getElementById('user-details-row').style.display = 'flex';
            let detailString = order.userid;
            if (order.zoneid) detailString += ` (${order.zoneid})`;
            document.getElementById('display-userid').innerText = detailString;
        }
    }

    function updateTrackerStatus(rawStatus) {
        const status = (rawStatus || 'pending').toLowerCase();
        const progress = document.getElementById('status-progress');
        const statusText = document.getElementById('status-text');
        const walker = document.getElementById('walking-anim');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');

        if (status === 'pending' || status === 'verifying') {
            // Step 1 active — Order Placed / Verifying
            if (walker) walker.style.left = '0%';
            if (progress) progress.style.width = '0%';
            if (statusText) statusText.innerText = 'Order received. Verifying details...';
            if (step1) step1.classList.add('active');

        } else if (status === 'processing') {
            // Step 2 active
            if (walker) walker.style.left = '50%';
            if (progress) progress.style.width = '50%';
            if (statusText) statusText.innerText = 'Processing your top-up...';
            if (step1) { step1.classList.remove('active'); step1.classList.add('completed'); }
            if (step2) step2.classList.add('active');

        } else if (status === 'confirmed' || status === 'completed') {
            // Step 3 — all done
            if (walker) walker.style.left = '100%';
            if (progress) progress.style.width = '100%';
            if (statusText) {
                statusText.innerText = 'Top-Up Delivered Successfully!';
                statusText.style.color = '#28a745';
            }
            if (step1) { step1.classList.remove('active'); step1.classList.add('completed'); }
            if (step2) { step2.classList.remove('active'); step2.classList.add('completed'); }
            if (step3) step3.classList.add('active', 'completed');
            const receiptBox = document.querySelector('.receipt-box');
            if (receiptBox) receiptBox.style.borderColor = '#28a745';
        }
    }

    function startStatusPolling(orderId) {
        const polling = setInterval(() => {
            fetch(`../api/crud/api_orders.php?id=${orderId}`)
                .then(res => res.json())
                .then(currentOrder => {
                    if (!currentOrder || currentOrder.error) return;
                    updateTrackerStatus(currentOrder.status);

                    const status = (currentOrder.status || '').toLowerCase();
                    if (status === 'confirmed' || status === 'completed') {
                        clearInterval(polling);
                    }
                })
                .catch(() => { }); // silently ignore network errors during polling
        }, 3000);
    }
});
