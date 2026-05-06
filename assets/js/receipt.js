// Receipt Display Logic (PHP API Version)
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('orderId');
    
    if (!orderId) {
        alert("Verification Error: No Order ID found.");
        window.location.href = '../index.php';
        return;
    }

    // Fetch Order from Server
    fetch(`../api/api_orders.php?id=${orderId}`)
        .then(res => res.json())
        .then(order => {
            if (!order || order.error) {
                alert("Order not found or database error!");
                return;
            }
            updateReceiptUI(order);
            startStatusPolling(orderId);
        });

    function updateReceiptUI(order) {
        document.getElementById('game-name').innerText = order.game;
        document.getElementById('item-amount').innerText = `${order.qty}x ${order.item}`;
        document.getElementById('item-price').innerText = `₱${parseFloat(order.price).toLocaleString()}`;
        document.getElementById('total-paid').innerText = `₱${parseFloat(order.total).toLocaleString()}`;
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

    function startStatusPolling(orderId) {
        const progress = document.getElementById('status-progress');
        const statusText = document.getElementById('status-text');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');

        const polling = setInterval(() => {
            fetch(`../api/api_orders.php?id=${orderId}`)
                .then(res => res.json())
                .then(currentOrder => {
                    const status = currentOrder.status.toLowerCase();
                    const walker = document.getElementById('walking-anim');
                    
                    if (status === 'processing') {
                        if (walker) walker.style.left = '50%';
                        if (progress) progress.style.width = '50%';
                        if (statusText) statusText.innerText = 'Technician is processing your request...';
                        step1.classList.add('completed');
                        step2.classList.add('active');
                    } else if (status === 'confirmed' || status === 'completed') {
                        if (walker) walker.style.left = '100%';
                        if (progress) progress.style.width = '100%';
                        if (statusText) {
                            statusText.innerText = 'Order Completed Successfully!';
                            statusText.style.color = '#28a745';
                        }
                        step1.classList.add('completed');
                        step2.classList.add('completed');
                        step3.classList.add('active', 'completed');
                        document.querySelector('.receipt-box').style.borderColor = '#28a745';
                        clearInterval(polling);
                    }
                });
        }, 3000);
    }
});
