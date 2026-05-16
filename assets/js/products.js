// Product & Stock Management Logic (PHP API Version)
document.addEventListener('DOMContentLoaded', () => {
    const gameName = document.querySelector('input[name="game"]')?.value;
    const stockDisplay = document.getElementById('stock-count');
    const qtyInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('qty-minus');
    const increaseBtn = document.getElementById('qty-plus');

    // Fetch Stock from Server
    const loadStockFromServer = () => {
        // Initial setup from DOM (sync immediately)
        const initialRadio = document.querySelector('.price-radio:checked');
        if (initialRadio && stockDisplay) {
            const skuStock = parseInt(initialRadio.getAttribute('data-stock')) || 0;
            stockDisplay.textContent = skuStock;
            window.currentStock = skuStock;
            checkSubmitButton(skuStock);
        }

        fetch('../api/crud/api_products.php')
            .then(res => res.json())
            .then(data => {
                if (gameName && stockDisplay) {
                    const checkedRadio = document.querySelector('.price-radio:checked');
                    if (checkedRadio) {
                        const skuStock = parseInt(checkedRadio.getAttribute('data-stock')) || 0;
                        stockDisplay.textContent = skuStock;
                        window.currentStock = skuStock;
                        checkSubmitButton(skuStock);
                    }
                }
            });
    };

    if (gameName) loadStockFromServer();

    // Sync stock-count and window.currentStock when a price is selected
    document.querySelectorAll('.price-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const skuStock = parseInt(this.getAttribute('data-stock')) || 0;
            if (stockDisplay) stockDisplay.textContent = skuStock;
            window.currentStock = skuStock;
            if (qtyInput) qtyInput.value = 1; // Reset qty to 1 on item change
            console.log(`Stock updated to ${window.currentStock} for selected item.`);
            checkSubmitButton(skuStock);
        });
    });

    function checkSubmitButton(stock) {
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            if (stock === 0) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Out of Stock";
                submitBtn.style.opacity = "0.5";
                submitBtn.style.cursor = "not-allowed";
                submitBtn.style.background = "#ccc";
                submitBtn.style.border = "none";
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = "Proceed to Payment";
                submitBtn.style.opacity = "1";
                submitBtn.style.cursor = "pointer";
                submitBtn.style.background = "#0050FF";
            }
        }
    }

    // Quantity selector logic
    if (qtyInput && decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val > 1) qtyInput.value = val - 1;
        });

        increaseBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            const maxStock = window.currentStock || 0;
            if (val < maxStock) {
                qtyInput.value = val + 1;
            } else {
                alert(`Only ${maxStock} units available in stock.`);
            }
        });

        qtyInput.addEventListener('change', () => {
            let val = parseInt(qtyInput.value);
            const maxStock = window.currentStock || 0;
            if (val < 1) qtyInput.value = 1;
            if (val > maxStock) {
                qtyInput.value = maxStock;
                alert(`Stock limit reached. Max available: ${maxStock}`);
            }
        });
    }

    // Auth Hook for Product Checkout
    const productForm = document.querySelector('form[action="payment.php"]');
    if (productForm) {
        let authVerified = false;
        productForm.addEventListener('submit', function(e) {
            if (authVerified) return;
            
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('button[type="submit"]');
            if(btn && btn.disabled) return;
            
            fetch('../api/api_check_auth.php')
                .then(res => res.json())
                .then(data => {
                    if (data.logged_in) {
                        authVerified = true;
                        form.submit();
                    } else {
                        const modal = document.getElementById('auth-required-modal');
                        if (modal) modal.classList.remove('hidden');
                    }
                })
                .catch(err => alert("Network error. Please try again later."));
        });
    }
});
