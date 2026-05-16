// Order Submission & Payment Logic (PHP API Version)
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const game = urlParams.get('game') || 'Tech Purchase';
    const productData = urlParams.get('product') || 'Selected Item|₱ ---.--';
    const userid = urlParams.get('userid') || '';
    const zoneid = urlParams.get('zoneid') || '';
    const qty = parseInt(urlParams.get('qty')) || 1;
    const [itemName, itemPriceStr] = productData.split('|');
    const itemPrice = parseFloat(itemPriceStr.replace('₱', '').replace(',', '')) || 0;
    const totalPrice = itemPrice * qty;

    // UI Toggling Logic
    const overlay = document.getElementById('payment-overlay');
    const panels = document.querySelectorAll('.payment-panel');

    function showPanel(method) {
        hidePanels();
        overlay.classList.add('active');
        const panelId = method.toLowerCase().includes('gcash') ? 'gcash-panel' :
                        method.toLowerCase().includes('maya') ? 'maya-panel' :
                        method.toLowerCase().includes('otc') ? 'otc-panel' : 
                        method.toLowerCase().includes('counter') ? 'otc-panel' : null;
        
        if (panelId) {
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.add('active');
                // Force update order ID display in the panel
                if (window.currentOrderId) {
                    panel.querySelectorAll('.current-ref-display').forEach(el => {
                        el.innerText = window.currentOrderId;
                    });
                }
                console.log(`Panel ${panelId} is now active.`);
            }
        }
    }

    function hidePanels() {
        overlay.classList.remove('active');
        panels.forEach(p => p.classList.remove('active'));
        document.getElementById('maint-panel')?.classList.remove('active');
    }

    // Attach to labels
    document.querySelectorAll('.payment-grid label').forEach(label => {
        label.addEventListener('click', (e) => {
            const methodCard = label.querySelector('.method-card');
            const method = label.querySelector('span').innerText.trim();
            
            console.log(`Selecting method: ${method}`);
            
            // UI Highlight
            document.querySelectorAll('.method-card').forEach(mc => mc.classList.remove('active'));
            if (methodCard) methodCard.classList.add('active');
            
            showPanel(method);
            if (!method.toLowerCase().includes('counter')) {
                createOrderOnServer(method);
            }
        });
    });

    // Close buttons and overlay click
    document.querySelectorAll('.close-btn, .close-maint').forEach(btn => {
        btn.addEventListener('click', hidePanels);
    });
    overlay.addEventListener('click', hidePanels);

    // Maint Panel Toggle
    document.querySelector('.maintenance-link')?.addEventListener('click', (e) => {
        e.preventDefault();
        overlay.classList.add('active');
        document.getElementById('maint-panel')?.classList.add('active');
    });

    // OTC Proceed Button
    const otcBtn = document.getElementById('otc-proceed-btn');
    if (otcBtn) {
        otcBtn.addEventListener('click', () => {
            createOrderOnServer('Over the Counter');
            otcBtn.style.display = 'none';
            document.getElementById('otc-waiting').style.display = 'block';
        });
    }

    const createOrderOnServer = (method) => {
        if (window.orderCreated) return;
        window.orderCreated = true;

        const orderId = 'TN-' + Math.random().toString(36).substr(2, 9).toUpperCase();
        const orderData = {
            id: orderId,
            game: game,
            item: itemName,
            price: itemPrice,
            qty: qty,
            total: totalPrice,
            method: method,
            userid: userid,
            zoneid: zoneid
        };

        // POST to PHP API
        fetch('../api/crud/api_orders.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        })
        .then(res => res.text())
        .then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error("JSON Parse Error. Raw response:", text);
                throw e;
            }
        })
        .then(data => {
            if (data.success) {
                window.currentOrderId = orderId;
                // Update all ID displays
                document.querySelectorAll('.current-ref-display').forEach(el => {
                    el.innerText = orderId;
                    el.style.display = 'inline-block';
                });
                console.log("Order created successfully:", orderId);
                startPolling(orderId);
            } else {
                console.error("Order error:", data.error);
                alert("Order Submission Failed. Check Console.");
                window.orderCreated = false;
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            window.orderCreated = false;
        });
    };

    const startPolling = (orderId) => {
        const poll = setInterval(() => {
            fetch(`../api/crud/api_orders.php?id=${orderId}`)
                .then(res => res.text())
                .then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error("Polling JSON Error. Raw response:", text);
                        throw e;
                    }
                })
                .then(order => {
                    if (order && order.status === 'Confirmed') {
                        clearInterval(poll);
                        window.location.href = `success.php?orderId=${orderId}`;
                    }
                });
        }, 3000); // Updated to 3 seconds
    };
});

function submitReference(inputId, btn) {
    console.log("Submit button clicked for " + inputId);
    const orderId = window.currentOrderId;
    const refInput = document.getElementById(inputId);
    const msgEl = document.getElementById(inputId + '-msg');
    const refValue = refInput.value.trim();

    if (!orderId) {
        alert("Please wait — your order is still being created. Please select a payment method first.");
        return;
    }

    if (!refValue) {
        msgEl.style.color = '#ff4444';
        msgEl.innerText = "Please enter a reference number.";
        return;
    }

    // Visual feedback: Sending...
    const originalText = btn.innerText;
    btn.innerText = "Sending...";
    btn.disabled = true;
    msgEl.style.color = '#0050FF';
    msgEl.innerText = "Updating reference...";

    fetch('../api/update_ref.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id: orderId,
            payment_ref: refValue
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            msgEl.style.color = '#28a745';
            msgEl.innerText = "✓ Reference Updated! Verifying...";
            
            // Pulse animation for the input
            refInput.classList.add('pulse-success');
            setTimeout(() => refInput.classList.remove('pulse-success'), 1000);

            // Success Feedback: Gray button and new text
            btn.style.background = '#888';
            btn.style.borderColor = '#888';
            btn.innerText = "Reference Updated (Click to Update)";
            btn.disabled = false; // Allow re-submit/update
            
            refInput.style.background = '#fff'; // Keep it white for easier updating
        } else {
            msgEl.style.color = '#ff4444';
            msgEl.innerText = "Error: " + (data.error || "Submission failed");
            btn.innerText = originalText;
            btn.disabled = false;
        }
    })
    .catch(err => {
        console.error("Reference submission error:", err);
        msgEl.style.color = '#ff4444';
        msgEl.innerText = "Network error. Please try again.";
        btn.innerText = originalText;
        btn.disabled = false;
    });
}
