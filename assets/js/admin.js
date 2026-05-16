/**
 * admin.js - Centralized administrative logic for Tech Noblade.
 * Handles dashboard analytics, order processing, inventory management, and repair tracking.
 */
function refreshData(e) {
    console.log('Refreshing all data...');
    loadAnalytics();
    loadOrdersFromServer();
    loadRepairsFromServer();
    loadProductsFromServer();
    loadReferencesTable();
    loadFeedbackFromServer();
    
    const btn = e?.currentTarget;
    if (btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = "Refreshing...";
        btn.disabled = true;
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 1000);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Authentication is primarily managed server-side via session validation.

    loadAnalytics();
    loadOrdersFromServer();
    loadProductsFromServer();
    loadRepairsFromServer();
    loadReferencesTable();
    loadFeedbackFromServer();

    // Initialize default report
    loadReport('month');

    // Attach save button listener for product modal
    const savePBtn = document.getElementById('save-p-btn');
    if (savePBtn) {
        savePBtn.onclick = saveProductChanges;
    }

    // Auto-refresh data every 30 seconds
    setInterval(() => {
        loadAnalytics();
        loadOrdersFromServer();
        loadRepairsFromServer();
        loadReferencesTable();
        loadFeedbackFromServer();
    }, 30000);
});

function loadAnalytics() {
    fetch('../api/crud/api_stats.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('stat-revenue').innerHTML = '&#8369;' + data.total_revenue.toLocaleString();
            document.getElementById('stat-pending').innerText = data.pending_orders;
            document.getElementById('stat-repairs').innerText = data.active_repairs;
            document.getElementById('stat-low-stock').innerText = data.low_stock_count;
            
            const lowStockCard = document.getElementById('card-low-stock');
            if(data.low_stock_count > 0) lowStockCard.classList.add('alert');
            else lowStockCard.classList.remove('alert');

            const tbody = document.getElementById('recent-activity-body');
            if (tbody) {
                tbody.innerHTML = '';
                if (data.recent_activity.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center">No recent activity</td></tr>';
                } else {
                    data.recent_activity.forEach(act => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `<td><strong>${act.type}</strong></td><td>${act.game}</td><td>${act.item}</td><td>${new Date(act.timestamp).toLocaleString()}</td>`;
                        tbody.appendChild(tr);
                    });
                }
            }
        })
        .catch(err => console.error("Error loading stats:", err));
}

function showTab(tabId) {
    console.log('Showing tab:', tabId);
    // Set global state for CSS targeting
    document.body.setAttribute('data-active-tab', tabId);

    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.cp-nav-item').forEach(t => t.classList.remove('active'));
    
    const targetSection = document.getElementById(tabId + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
        const titleEl = document.getElementById('page-title');
        if (titleEl) {
            titleEl.innerText = {
                'overview': 'Dashboard Overview',
                'orders': 'Orders Management',
                'references': 'Payment Reference Hub',
                'inventory': 'Inventory Management',
                'repairs': 'Repair Service Requests',
                'reports': 'System Performance Reports',
                'feedback': 'User Feedback'
            }[tabId] || 'Admin Panel';
        }

        // Update Nav Link Status
        document.querySelectorAll('.cp-nav-item').forEach(item => {
            if(item.getAttribute('onclick')?.includes(tabId)) item.classList.add('active');
        });

        // Trigger data loads
        if (tabId === 'overview') loadAnalytics();
        if (tabId === 'orders') loadOrdersFromServer();
        if (tabId === 'references') loadReferencesTable();
        if (tabId === 'repairs') loadRepairsFromServer();
        if (tabId === 'inventory') loadProductsFromServer();
        if (tabId === 'reports') loadReport(document.getElementById('report-period')?.value || 'month');
        if (tabId === 'feedback') loadFeedbackFromServer();
    }
}

function loadOrdersFromServer() {
    fetch('../api/crud/api_orders.php')
        .then(res => res.json())
        .then(orders => {
            const tbody = document.getElementById('orders-body');
            const pendingCount = document.getElementById('pending-count');
            if (!tbody) return;
            
            tbody.innerHTML = '';
            let pending = 0;
            
            orders.sort((a,b) => b.id - a.id).forEach(order => {
                if (order.status === 'Processing') pending++;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td data-label="Order ID" class="font-weight-bold">#${order.order_id}</td>
                    <td data-label="Game">${order.game}</td>
                    <td data-label="Item">${order.qty}x ${order.item}</td>
                    <td data-label="Total">&#8369;${parseFloat(order.total).toLocaleString()}</td>
                    <td data-label="Payment Ref" class="word-break-all"><code class="ref-badge-alt">${order.payment_ref || '---'}</code></td>
                    <td data-label="Status"><span class="status-badge status-${order.status.toLowerCase()}">${order.status}</span></td>
                    <td data-label="" class="white-space-nowrap">
                        ${order.status === 'Processing' ? `<button class="btn btn-small btn-confirm" onclick="confirmOrderOnServer('${order.order_id}')">Confirm</button>` : ''}
                        <button class="btn btn-small btn-delete" onclick="if(confirm('Delete this order?')) deleteOrderFromServer('${order.order_id}')">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
            if (pendingCount) pendingCount.innerText = pending;
        });
}

function loadReferencesTable() {
    const tbody = document.getElementById('references-tab-body');
    if (!tbody) return;

    fetch('../api/crud/api_orders.php')
        .then(res => res.json())
        .then(orders => {
            const refs = orders.filter(o => o.payment_ref && o.payment_ref !== '---');
            if (refs.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No reference numbers submitted yet.</td></tr>';
                return;
            }
            tbody.innerHTML = '';
            refs.forEach(order => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td data-label="Order ID" class="font-weight-bold">#${order.order_id}</td>
                    <td data-label="Method">${order.method || 'N/A'}</td>
                    <td data-label="Reference" class="word-break-all"><strong class="color-tech-blue">${order.payment_ref}</strong></td>
                    <td data-label="Amount">&#8369;${parseFloat(order.total).toLocaleString()}</td>
                    <td data-label="Status"><span class="status-badge status-${order.status.toLowerCase()}">${order.status}</span></td>
                    <td data-label="Date" class="fs-0-85 color-666">${new Date(order.timestamp).toLocaleString()}</td>
                `;
                tbody.appendChild(tr);
            });
        });
}

function confirmOrderOnServer(orderId) {
    fetch('../api/crud/api_orders.php', {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: orderId, status: 'Confirmed' })
    }).then(() => { refreshData(); });
}

function deleteOrderFromServer(orderId) {
    fetch(`../api/crud/api_orders.php?id=${orderId}`, { method: 'DELETE' })
        .then(() => { refreshData(); })
        .catch(err => console.error('Delete order failed:', err));
}

function loadProductsFromServer() {
    // Preserve which game groups are currently open
    const openGroups = new Set();
    document.querySelectorAll('.game-group.open .group-header span').forEach(el => {
        openGroups.add(el.textContent.split(' (')[0]);
    });

    fetch('../api/crud/api_products.php')
        .then(res => res.json())
        .then(items => {
            const container = document.getElementById('products-container');
            if (!container) return;
            container.innerHTML = '';
            const groups = {};
            items.forEach(item => {
                if(!groups[item.game]) groups[item.game] = [];
                groups[item.game].push(item);
            });
            for(const game in groups) {
                const groupDiv = document.createElement('div');
                groupDiv.className = 'game-group';
                // Restore open state
                if (openGroups.has(game)) groupDiv.classList.add('open');
                
                groupDiv.innerHTML = `
                    <div class="group-header" onclick="this.parentElement.classList.toggle('open')"><span>${game} <small style="opacity:0.5; margin-left:8px;">(${groups[game].length} Tiers)</small></span><span class="group-chevron">&#9660;</span></div>
                    <div class="group-content">
                        <div class="p-10 flex flex-column gap-10">
                            ${groups[game].map(item => `
                                <div class="inventory-item-row">
                                    <div class="item-info">
                                        <h4>${item.item_name}</h4>
                                        <p>Price: <span class="color-tech-blue font-weight-700">&#8369;${parseFloat(item.price).toLocaleString()}</span></p>
                                    </div>
                                    <div class="item-actions">
                                        <div class="flex align-center gap-10 bg-f8f9fa p-8 br-12 border-1-eee">
                                            <button class="adjust-btn-premium" onclick="event.stopPropagation(); quickAdjustStock(${item.id}, -1, this)">-</button>
                                            <span id="stock-badge-${item.id}" class="status-badge ${item.stock < 10 ? 'status-low' : 'status-confirmed'} font-mono">${item.stock}</span>
                                            <button class="adjust-btn-premium" onclick="event.stopPropagation(); quickAdjustStock(${item.id}, 1, this)">+</button>
                                        </div>
                                        <div class="flex gap-8">
                                            <button class="btn btn-small btn-edit-premium" onclick="editProduct(${item.id}, '${item.game.replace(/'/g, "\\'")}', '${item.item_name.replace(/'/g, "\\'")}', ${item.price}, ${item.stock})">Edit</button>
                                            <button class="btn btn-small btn-delete-premium" onclick="if(confirm('Delete this item?')) deleteProductOnServer(${item.id})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                container.appendChild(groupDiv);
            }
        });
}

/**
 * Performs a near-instantaneous stock adjustment with optimistic UI updates.
 * Sends the absolute new stock value to the server to maintain consistency.
 */
function quickAdjustStock(id, change, btnEl) {
    const badge = document.getElementById('stock-badge-' + id);
    if (!badge) return;

    const current = parseInt(badge.textContent) || 0;
    const newVal = Math.max(0, current + change);
    
    // UI Feedback
    badge.textContent = newVal;
    badge.className = 'status-badge ' + (newVal < 10 ? 'status-low' : 'status-confirmed');
    
    // Server partial update
    fetch('../api/crud/api_products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, stock: newVal })
    }).catch(err => {
        console.error('Stock Update Error:', err);
        // Rollback on error
        badge.textContent = current;
    });
}

function editProduct(id, game, item, price, stock) {
    document.getElementById('modal-title').innerText = "Edit Price Option";
    document.getElementById('p-id').value = id;
    document.getElementById('p-game').value = game;
    document.getElementById('p-name').value = item;
    document.getElementById('p-price').value = price;
    document.getElementById('p-stock').value = stock;
    document.getElementById('product-modal').style.display = 'flex';
}

function closeProductModal() { document.getElementById('product-modal').style.display = 'none'; }

function saveProductChanges() {
    const id = document.getElementById('p-id').value;
    const game = document.getElementById('p-game').value;
    const item = document.getElementById('p-name').value;
    const price = document.getElementById('p-price').value;
    const stock = document.getElementById('p-stock').value;

    fetch('../api/crud/api_products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, game, item_name: item, price, stock })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            closeProductModal();
            loadProductsFromServer();
            loadAnalytics();
        } else {
            alert("Error: " + data.error);
        }
    });
}

function loadRepairsFromServer() {
    fetch('../api/crud/api_services.php')
        .then(res => res.json())
        .then(services => {
            const tbody = document.getElementById('repairs-body');
            if (!tbody) return;
            tbody.innerHTML = '';
            services.forEach(s => {
                const tr = document.createElement('tr');
                const stRaw = s.status || 'pending';
                const st = stRaw.toLowerCase();
                const isCompleted = st === 'completed';
                const isVerifying = st === 'verifying' || st === 'processing';
                
                tr.innerHTML = `
                    <td data-label="Ref ID"><code>${s.reference_id}</code></td>
                    <td data-label="Customer">${s.customer_name}<br><small>${s.contact}</small></td>
                    <td data-label="Device">${s.device}</td>
                    <td data-label="Shipping" class="text-capitalize">${s.shipping}</td>
                    <td data-label="Status"><span class="status-badge ${isCompleted ? 'status-badge-completed' : (isVerifying ? 'status-badge-verifying' : 'status-badge-pending')} text-uppercase">${stRaw}</span></td>
                    <td data-label="">
                        <button onclick="viewRepairDetails(${s.id})" class="btn btn-small btn-edit">View Details</button>
                        <button onclick="if(confirm('Delete this record?')) deleteRepair(${s.id})" class="btn btn-small btn-delete">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
}

// Add state for repair detailing
let currentRepair = null;

function viewRepairDetails(id) {
    fetch('../api/crud/api_services.php')
        .then(res => res.json())
        .then(services => {
            const s = services.find(x => x.id == id);
            if (!s) return;
            currentRepair = s;
            
            // Shared modal instance management for repair details
            let modal = document.getElementById('repair-detail-modal');
            if(!modal) {
                modal = document.createElement('div');
                modal.id = 'repair-detail-modal';
                modal.className = "modal-overlay-custom";
                document.body.appendChild(modal);
            }
            
            modal.innerHTML = `
                <div class="admin-card admin-card-modal">
                    <div class="flex-between-center mb-20">
                        <h2 class="m-0">Repair Details</h2>
                        <span onclick="this.closest('#repair-detail-modal').style.display='none'" class="pointer fs-1-5">&times;</span>
                    </div>
                    
                    <div class="detail-grid-2">
                        <div>
                            <p><strong>Reference ID:</strong><br><code>${s.reference_id}</code></p>
                            <p><strong>Customer:</strong><br>${s.customer_name}</p>
                            <p><strong>Contact:</strong><br>${s.contact}</p>
                        </div>
                        <div>
                            <p><strong>Device:</strong><br>${s.device}</p>
                            <p><strong>Shipping:</strong><br><span class="text-capitalize">${s.shipping}</span></p>
                            <p><strong>Appointment:</strong><br>${s.schedule_date || 'N/A'} at ${s.schedule_time || 'N/A'}</p>
                        </div>
                    </div>
                    
                    <div class="mb-20 fs-0-9">
                        <p><strong>Issue:</strong><br><span class="color-666">${s.issue}</span></p>
                        <p><strong>Address:</strong><br><span class="color-666">${s.pickup_address || 'N/A'}</span></p>
                        <p><strong>Admin Notes:</strong><br><span class="color-666">${s.notes || 'N/A'}</span></p>
                    </div>
                    
                    <hr class="hr-light">
                    
                    <div class="form-group mb-15">
                        <label>Repair Status</label>
                        <select id="r-status" class="stock-input w-full text-left">
                            <option value="pending" ${s.status?.toLowerCase() === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="verifying" ${s.status?.toLowerCase() === 'verifying' ? 'selected' : ''}>Verifying</option>
                            <option value="completed" ${s.status?.toLowerCase() === 'completed' ? 'selected' : ''}>Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-group mb-15">
                        <label>Diagnostic Quote (PHP)</label>
                        <input type="number" id="r-quote" class="stock-input w-full text-left" value="${s.diagnostic_quote || ''}" placeholder="Enter estimated price">
                    </div>
 
                    <div class="flex gap-10 mt-20">
                        <button class="btn btn-primary flex-2" onclick="saveRepairChanges(${s.id})">Update Request</button>
                        <button class="btn btn-cancel flex-1" onclick="this.closest('#repair-detail-modal').style.display='none'">Cancel</button>
                    </div>
                </div>
            `;
            modal.style.display = 'flex';
        });
}

function saveRepairChanges(id) {
    const status = document.getElementById('r-status').value;
    const quote = document.getElementById('r-quote').value;
    
    fetch('../api/crud/api_services.php', {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            id: id, 
            status: status,
            diagnostic_quote: quote,
            quote_status: 'approved' // Auto-approve for now when admin sets it
        })
    }).then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('repair-detail-modal').style.display = 'none';
            loadRepairsFromServer();
        } else {
            alert("Error: " + data.error);
        }
    });
}

function deleteRepair(id) {
    fetch(`../api/crud/api_services.php?id=${id}`, { method: 'DELETE' })
        .then(() => loadRepairsFromServer());
}

// Bottom nav active state sync
function setActiveNav(btn) {
    document.querySelectorAll('.bnav-item').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// Feedback APIs
function loadFeedbackFromServer() {
    fetch('../api/crud/api_feedback.php')
        .then(res => res.json())
        .then(feedbacks => {
            const tbody = document.getElementById('feedback-body');
            if(!tbody) return;
            tbody.innerHTML = '';
            if(feedbacks.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center">No feedback available.</td></tr>';
                return;
            }
            feedbacks.forEach(f => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td data-label="Name" class="font-weight-600">${f.name}</td>
                    <td data-label="Email">${f.email}</td>
                    <td data-label="Topic"><span class="status-badge b-1-eee color-tech-blue">${f.topic || 'General'}</span></td>
                    <td data-label="Message"><div class="max-w-250 fs-0-85 overflow-auto white-space-normal">${f.message}</div></td>
                    <td data-label="Date" class="fs-0-8">${new Date(f.created_at).toLocaleString()}</td>
                    <td data-label="">
                        <button onclick="if(confirm('Delete this feedback?')) deleteFeedback(${f.id})" class="btn btn-small btn-delete">Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }).catch(err => console.error("Feedback Load Error:", err));
}

function deleteFeedback(id) {
    console.log('Attempting to delete feedback ID:', id);
    fetch('../api/crud/api_feedback.php?id=' + id, { method: 'DELETE' })
        .then(res => {
            console.log('Delete response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('Delete data response:', data);
            if(data.success) {
                loadFeedbackFromServer();
            } else {
                alert('Could not delete feedback: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(err => {
            console.error('Delete feedback fetch error:', err);
            alert('A network error occurred while deleting feedback.');
        });
}

function highlightLowStock() {
    showTab('inventory');
    // Optional: blink the inventory header
    const invHeader = document.getElementById('inventory-section')?.querySelector('h2');
    if(invHeader) {
        invHeader.style.color = '#ff4757';
        setTimeout(() => invHeader.style.color = '', 2000);
    }
}

/**
 * Analytical Reporting Logic
 */
function loadReport(period) {
    const tbody = document.getElementById('report-body');
    if(!tbody) return;
    
    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Analyzing data...</td></tr>';
    
    fetch(`../api/crud/api_reports.php?period=${period}`)
        .then(res => res.json())
        .then(data => {
            // Update Overview Cards
            document.getElementById('rep-revenue').innerHTML = '&#8369;' + data.overview.revenue.toLocaleString();
            document.getElementById('rep-orders').innerText = data.overview.orders;
            document.getElementById('rep-repairs').innerText = data.overview.repairs_completed + ' / ' + data.overview.repairs_total;
            document.getElementById('rep-game').innerText = data.overview.top_game;

            // Update Breakdown Table
            tbody.innerHTML = '';
            if (data.sales_breakdown.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center">No data found for this period.</td></tr>';
                return;
            }

            data.sales_breakdown.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td data-label="ID">#${row.order_id}</td>
                    <td data-label="Game">${row.game}</td>
                    <td data-label="Item">${row.item}</td>
                    <td data-label="Total">&#8369;${parseFloat(row.total).toLocaleString()}</td>
                    <td data-label="Date">${new Date(row.timestamp).toLocaleDateString()}</td>
                `;
                tbody.appendChild(tr);
            });
        }).catch(err => {
            console.error("Report Error:", err);
            tbody.innerHTML = '<tr><td colspan="5" class="text-center color-red">Failed to load report data.</td></tr>';
        });
}


function deleteProductOnServer(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;
    
    fetch('../api/crud/api_products.php?id=' + id, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadProductsFromServer();
            loadAnalytics();
        } else {
            alert('Delete failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(err => console.error('Error deleting product:', err));
}







function showAddProductModal() {
    document.getElementById('modal-title').innerText = "Add New Item";
    document.getElementById('p-id').value = "";
    document.getElementById('p-game').value = "";
    document.getElementById('p-name').value = "";
    document.getElementById('p-price').value = "";
    document.getElementById('p-stock').value = "0";
    document.getElementById('product-modal').style.display = 'flex';
}

