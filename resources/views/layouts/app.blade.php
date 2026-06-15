{{-- resources/views/layouts/app.blade.php --}}
<!-- Ajoutez ce code après la navbar ou dans le header -->

<div class="cart-preview" id="cartPreview" style="display: none;">
    <div class="cart-preview-header">
        <h5><i class="fas fa-shopping-cart"></i> Mon panier</h5>
        <button class="close-cart-preview" onclick="toggleCartPreview()">&times;</button>
    </div>
    <div class="cart-preview-body" id="cartPreviewBody">
        <div class="text-center py-4">
            <i class="fas fa-cart-shopping fa-3x text-muted mb-2"></i>
            <p class="text-muted">Votre panier est vide</p>
        </div>
    </div>
    <div class="cart-preview-footer">
        <div class="cart-preview-total">
            <span>Total</span>
            <strong id="cartPreviewTotal">0 FC</strong>
        </div>
       <a href="/client/commande/panier" class="btn-checkout-cart">
            <i class="fas fa-credit-card me-2"></i> Commander
        </a>
    </div>
</div>

<style>
.cart-preview {
    position: fixed;
    top: 80px;
    right: 20px;
    width: 380px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    z-index: 10000;
    overflow: hidden;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cart-preview-header {
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-cart-preview {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.cart-preview-body {
    max-height: 400px;
    overflow-y: auto;
    padding: 15px;
}

.cart-preview-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}

.cart-preview-item-img {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.cart-preview-item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-preview-item-info {
    flex: 1;
}

.cart-preview-item-name {
    font-weight: 600;
    margin-bottom: 5px;
}

.cart-preview-item-price {
    font-size: 12px;
    color: #f39c12;
}

.cart-preview-item-quantity {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
}

.cart-preview-item-quantity button {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #e2e8f0;
    background: white;
    cursor: pointer;
}

.cart-preview-footer {
    padding: 15px 20px;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
}

.cart-preview-total {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 16px;
    font-weight: 700;
}

.btn-checkout-cart {
    display: block;
    width: 100%;
    text-align: center;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 10px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-checkout-cart:hover {
    transform: translateY(-2px);
    color: white;
}

.cart-floating {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    z-index: 9999;
    transition: all 0.3s;
}

.cart-floating:hover {
    transform: scale(1.1);
}

.cart-floating i {
    font-size: 24px;
    color: white;
}

.cart-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ef4444;
    color: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}
</style>

<script>
function toggleCartPreview() {
    const preview = document.getElementById('cartPreview');
    if (preview.style.display === 'none') {
        loadCartPreview();
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

function loadCartPreview() {
    fetch('{{ route("cart.items") }}')
        .then(response => response.json())
        .then(data => {
            const body = document.getElementById('cartPreviewBody');
            const totalSpan = document.getElementById('cartPreviewTotal');
            
            if (!data.items || data.items.length === 0) {
                body.innerHTML = '<div class="text-center py-4"><i class="fas fa-cart-shopping fa-3x text-muted mb-2"></i><p class="text-muted">Votre panier est vide</p></div>';
                totalSpan.innerHTML = '0 FC';
                return;
            }
            
            let html = '';
            let total = 0;
            data.items.forEach(item => {
                total += item.prix * item.quantite;
                html += `
                    <div class="cart-preview-item">
                        <div class="cart-preview-item-img">
                            ${item.image ? `<img src="/storage/${item.image}">` : '<i class="fas fa-utensils fa-2x text-muted"></i>'}
                        </div>
                        <div class="cart-preview-item-info">
                            <div class="cart-preview-item-name">${item.nom}</div>
                            <div class="cart-preview-item-price">${item.prix.toLocaleString()} FC</div>
                            <div class="cart-preview-item-quantity">
                                <button onclick="updateCartItem(${item.id}, ${item.quantite - 1})">-</button>
                                <span>${item.quantite}</span>
                                <button onclick="updateCartItem(${item.id}, ${item.quantite + 1})">+</button>
                                <button onclick="removeCartItem(${item.id})" style="background:#fee2e2; color:#dc2626;">×</button>
                            </div>
                        </div>
                    </div>
                `;
            });
            body.innerHTML = html;
            totalSpan.innerHTML = total.toLocaleString() + ' FC';
        });
}

function updateCartItem(menuId, newQty) {
    if (newQty <= 0) {
        removeCartItem(menuId);
        return;
    }
    
    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ menu_id: menuId, quantite: newQty })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            loadCartPreview();
        }
    });
}

function removeCartItem(menuId) {
    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ menu_id: menuId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            loadCartPreview();
            if (document.getElementById('cartItemsList')) {
                loadCart();
            }
        }
    });
}

function updateCartCount() {
    fetch('{{ route("cart.count") }}')
        .then(response => response.json())
        .then(data => {
            const cartCounts = document.querySelectorAll('.cart-count');
            cartCounts.forEach(el => el.textContent = data.count || 0);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
</script>