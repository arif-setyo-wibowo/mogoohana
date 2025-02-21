// Comprehensive Cart Management Functionality
if (!window.CartManager) {
    class CartManager {
        constructor() {
            this.updateQuantity = this.updateQuantity.bind(this);
            this.removeCartItem = this.removeCartItem.bind(this);
            this.removeCartItemDropdown = this.removeCartItemDropdown.bind(this);
            this.updateCartTotal = this.updateCartTotal.bind(this);
            this.updateCartDropdown = this.updateCartDropdown.bind(this);
            this.addToCart = this.addToCart.bind(this);
            this.setupQuantityControls = this.setupQuantityControls.bind(this);
            this.setupClearCart = this.setupClearCart.bind(this);
            this.init = this.init.bind(this);
            
            // Flag to track if we're currently processing an add to cart request
            this.isAddingToCart = false;
        }

        updateQuantity(cartId, newQuantity, quantityInput, cartRow) {
            fetch(`/shop-cart/${cartId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update quantity input
                    quantityInput.value = newQuantity;
                    quantityInput.setAttribute('data-prev-quantity', newQuantity);
                    
                    // Update subtotal
                    const priceCell = cartRow.querySelector('[data-title="Price"]');
                    const subtotalCell = cartRow.querySelector('[data-title="Total"]');
                    
                    if (priceCell && subtotalCell) {
                        const unitPrice = parseFloat(priceCell.textContent.replace('$', '').replace(',', ''));
                        const newSubtotal = (unitPrice * newQuantity);
                        subtotalCell.textContent = `$${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    }
                    
                    // Update cart total
                    this.updateCartTotal();
                    
                    // Update cart dropdown
                    this.updateCartDropdown();
                } else {
                    // Revert quantity if update fails
                    quantityInput.value = quantityInput.getAttribute('data-prev-quantity');
                    console.error(data.message);
                }
            })
            .catch(error => {
                // Revert quantity on network error
                quantityInput.value = quantityInput.getAttribute('data-prev-quantity');
                console.error('Error:', error);
            });
        }

        removeCartItem(element) {
            const cartRow = element.closest('tr');
            const cartId = cartRow.getAttribute('data-cart-id');

            Swal.fire({
                title: 'Remove Product from Cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/shop-cart/${cartId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            cartRow.remove();
                            
                            this.updateCartDropdown();

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Network Error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                }
            });
        }

        removeCartItemDropdown(element) {
            const cartId = element.getAttribute('data-cart-id');

            fetch(`/shop-cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart dropdown
                    this.updateCartDropdown();

                    Swal.fire({
                        icon: 'success',
                        title: 'Removed from Cart',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Remove',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        }

        updateCartTotal() {
            let total = 0;
            const cartRows = document.querySelectorAll('tr[data-cart-id]');
            
            cartRows.forEach(row => {
                const subtotalCell = row.querySelector('[data-title="Total"]');
                if (subtotalCell) {
                    const subtotal = parseFloat(subtotalCell.textContent.replace('$', '').replace(',', ''));
                    if (!isNaN(subtotal)) {
                        total += subtotal;
                    }
                }
            });

            // Update total in the cart summary
            const cartTotalAmount = document.querySelector('.cart_total_amount');
            if (cartTotalAmount) {
                cartTotalAmount.innerHTML = `<strong>$${total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>`;
            }
        }

        updateCartDropdown() {
            fetch('/cart/get-cart-data', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update cart count with unique items count
                const cartCountElements = document.querySelectorAll('.cart_count');
                const uniqueItemsCount = data.cartItems ? data.cartItems.length : 0;
                cartCountElements.forEach(element => {
                    element.textContent = uniqueItemsCount;
                });

                // Update cart dropdown content
                const cartDropdownElements = document.querySelectorAll('.cartku');
                cartDropdownElements.forEach(dropdown => {
                    if (data.cartItems && data.cartItems.length > 0) {
                        // Create cart items HTML
                        const cartItemsHtml = data.cartItems.map(item => `
                            <li>
                                <a href="/shop-detail/${item.produk.slug}">
                                    <img alt="${item.produk.nama_produk}" 
                                         src="/storage/${item.produk.foto}">
                                    ${item.produk.nama_produk.substring(0, 18)}
                                </a>
                                <span class="cart_quantity"> ${item.quantity} x 
                                    <span class="cart_amount">
                                        <span class="price_symbole">$</span>
                                    </span>${item.produk.harga.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 })}
                                </span>
                            </li>
                        `).join('');

                        // Create cart footer HTML
                        const cartFooterHtml = `
                            <div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span class="price_symbole">$</span></span>${data.cartTotal.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 })}</p>
                                <p class="cart_buttons">
                                    <a href="/shop-cart" class="btn btn-fill-line view-cart">View Cart</a>
                                    <a href="/shop-checkout" class="btn btn-fill-out checkout">Checkout</a>
                                </p>
                            </div>
                        `;

                        // Update dropdown content
                        dropdown.innerHTML = `
                            <ul class="cart_list">
                                ${cartItemsHtml}
                            </ul>
                            ${cartFooterHtml}
                        `;
                    } else {
                        // Empty cart
                        dropdown.innerHTML = `
                            <p class="text-center">Your cart is empty</p>
                        `;
                    }
                });
            })
            .catch(error => {
                console.error('Error updating cart dropdown:', error);
            });
        }

        addToCart(productId, quantity = 1) {
            // Prevent multiple simultaneous requests
            if (this.isAddingToCart) {
                return;
            }
            
            this.isAddingToCart = true;
            
            fetch('/cart/store', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    produk_id: productId,
                    quantity: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Failed to add product to cart');
                    }).catch(() => {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.updateCartDropdown();
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Complete error details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000
                });
            })
            .finally(() => {
                setTimeout(() => {
                    this.isAddingToCart = false;
                }, 500); // Add a small delay before allowing next request
            });
        }

        setupQuantityControls() {
            const cartRows = document.querySelectorAll('tr[data-cart-id]');
            
            cartRows.forEach(cartRow => {
                const quantityInput = cartRow.querySelector('.qty');
                const qtyDownBtn = cartRow.querySelector('.minus');
                const qtyUpBtn = cartRow.querySelector('.plus');
                const cartId = cartRow.getAttribute('data-cart-id');
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                
                // Store initial quantity as previous quantity
                quantityInput.setAttribute('data-prev-quantity', quantityInput.value);
                
                if (qtyDownBtn) {
                    qtyDownBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        let currentQuantity = parseInt(quantityInput.value);
                        
                        if (currentQuantity > 1) {
                            const newQuantity = currentQuantity - 1;
                            this.updateQuantity(cartId, newQuantity, quantityInput, cartRow);
                        }
                    });
                }
                
                if (qtyUpBtn) {
                    qtyUpBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        let currentQuantity = parseInt(quantityInput.value);
                        
                        if (currentQuantity < maxQuantity) {
                            const newQuantity = currentQuantity + 1;
                            this.updateQuantity(cartId, newQuantity, quantityInput, cartRow);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Maximum Stock Reached',
                                text: `You can only order up to ${maxQuantity} items`,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        }

        setupClearCart() {
            const clearCartBtn = document.querySelector('.clear-cart-btn');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Clear Cart?',
                        text: 'Are you sure you want to clear the cart?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Clear',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('/shop-cart/clear', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove all cart rows
                                    const cartTableBody = document.querySelector('tbody');
                                    if (cartTableBody) {
                                        cartTableBody.innerHTML = `
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <p class="my-5">Your cart is empty</p>
                                                </td>
                                            </tr>
                                        `;
                                    }

                                    // Update cart dropdown and total
                                    this.updateCartDropdown();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: data.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Network Error',
                                    text: 'Unable to clear cart. Please try again.',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            });
                        }
                    });
                }.bind(this));
            }
        }

        init() {
            this.setupQuantityControls();
            this.setupClearCart();
            
            // Remove any existing click handlers
            document.querySelectorAll('.add-to-cart-link').forEach(link => {
                link.removeEventListener('click', this.addToCartHandler);
            });

            // Use event delegation with a named handler
            this.addToCartHandler = (e) => {
                const addToCartLink = e.target.matches('.add-to-cart-link') ? e.target : e.target.closest('.add-to-cart-link');
                if (addToCartLink) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    try {
                        const produk_id = addToCartLink.dataset.produk_id;
                        const quantity = addToCartLink.dataset.quantity || 1;

                        if (!produk_id) {
                            throw new Error('Product ID not found');
                        }

                        this.addToCart(produk_id, parseInt(quantity));
                    } catch (error) {
                        console.error('Error in add to cart handler:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Unable to add product to cart',
                        });
                    }
                }
            };

            // Add the click handler using event delegation
            document.addEventListener('click', this.addToCartHandler);
        }
    }

    window.CartManager = CartManager;
}

// Global function for removing cart item
function removeCartItem(element) {
    const cartRow = element.closest('tr');
    const cartId = cartRow.getAttribute('data-cart-id');

    Swal.fire({
        title: 'Remove Product from Cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/shop-cart/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartRow.remove();
                    
                    // Update cart total and dropdown
                    const cartManager = new CartManager();
                    cartManager.updateCartDropdown();
                    cartManager.updateCartTotal();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        }
    });
}

// Initialize cart manager only once
if (!window.cartManagerInstance) {
    window.cartManagerInstance = new CartManager();
    window.cartManagerInstance.init();
}
