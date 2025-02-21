// Comprehensive Cart Management Functionality

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
                
                // Update subtotal (not unit price)
                const subtotalElement = cartRow.querySelector('.price.subtotal h4');
                const unitPrice = parseFloat(cartRow.querySelector('.price.unit-price h4').textContent.replace('$', '').trim());
                const newSubtotal = (unitPrice * newQuantity);
                subtotalElement.textContent = `$${newSubtotal.toFixed(2)}`;
                
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
        const cartTotalElement = document.querySelector('.cart-total');
        
        if (cartTotalElement) {
            const cartItems = document.querySelectorAll('tr[data-cart-id]');
            let calculatedTotal = 0;

            cartItems.forEach(item => {
                const unitPriceEl = item.querySelector('.price.unit-price h4');
                const quantityEl = item.querySelector('.qty-val');

                if (unitPriceEl && quantityEl) {
                    const unitPrice = parseFloat(unitPriceEl.textContent.replace('$', '').trim());
                    const quantity = parseInt(quantityEl.value);

                    if (!isNaN(unitPrice) && !isNaN(quantity)) {
                        calculatedTotal += unitPrice * quantity;
                    }
                }
            });

            // Update total element
            cartTotalElement.textContent = `$${calculatedTotal.toFixed(2)}`;
        }
    }

    updateCartDropdown() {
        fetch('/cart/dropdown', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update cart count elements
            const cartCountElements = document.querySelectorAll('.pro-count');
            cartCountElements.forEach(element => {
                element.textContent = data.cartItemCount;
                element.classList.remove('blue', 'white');
                element.classList.add(data.cartItemCount > 0 ? 'blue' : 'white');
            });

            // Update cart dropdown content
            const cartDropdownElements = document.querySelectorAll('.cartku');
            cartDropdownElements.forEach(dropdown => {
                if (data.cartItems.length > 0) {
                    // Create cart items HTML
                    const cartItemsHtml = data.cartItems.map(item => `
                        <li>
                            <div class="shopping-cart-img">
                                <a href="/shop-detail/${item.produk.id}">
                                    <img alt="${item.produk.nama_produk}" 
                                         src="/storage/${item.produk.foto}" />
                                </a>
                            </div>
                            <div class="shopping-cart-title">
                                <h4>
                                    <a href="/shop-detail/${item.produk.id}">
                                        ${item.produk.nama_produk.substring(0, 18)}
                                    </a>
                                </h4>
                                <h4>
                                    $${item.produk.harga.toFixed(2)}
                                    <span> X ${item.quantity}</span>
                                </h4>
                            </div>
                        </li>
                    `).join('');

                    // Create cart footer HTML
                    const cartFooterHtml = `
                        <div class="shopping-cart-footer">
                            <div class="shopping-cart-total">
                                <h4>Total <span>$${data.cartTotal.toFixed(2)}</span></h4>
                            </div>
                            <div class="shopping-cart-button">
                                <a href="/shop-cart" class="outline">View cart</a>
                                <a href="/shop-checkout">Checkout</a>
                            </div>
                        </div>
                    `;

                    // Update dropdown content
                    dropdown.innerHTML = `
                        <ul>
                            ${cartItemsHtml}
                        </ul>
                        ${cartFooterHtml}
                    `;
                } else {
                    // Empty cart
                    dropdown.innerHTML = `
                        <div class="text-center p-3">
                            <p>Your cart is empty</p>
                        </div>
                    `;
                }
            });

            // Update cart total on the page if exists
            this.updateCartTotal();
        })
        .catch(error => {
            console.error('Error updating cart dropdown:', error);
        });
    }

    addToCart(productId, quantity = 1) {
        fetch('/cart/store', {
            method: 'POST',
            credentials: 'same-origin', // Important for cookies and CSRF
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
            // Check if response is OK
            if (!response.ok) {
                // Try to parse error response
                return response.json().then(errorData => {
                    console.error('Error response:', errorData);
                    throw new Error(errorData.message || 'Failed to add product to cart');
                }).catch(() => {
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            
            // Parse JSON response
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update cart dropdown
                this.updateCartDropdown();

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                // Show error notification
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
            
            // More detailed error handling
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
        });
    }

    setupQuantityControls() {
        const cartRows = document.querySelectorAll('tr[data-cart-id]');
        
        cartRows.forEach(cartRow => {
            const quantityInput = cartRow.querySelector('.qty-val');
            const qtyDownBtn = cartRow.querySelector('.qty-down');
            const qtyUpBtn = cartRow.querySelector('.qty-up');
            const cartId = cartRow.getAttribute('data-cart-id');
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));
            
            // Store initial quantity as previous quantity
            quantityInput.setAttribute('data-prev-quantity', quantityInput.value);
            
            qtyDownBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let currentQuantity = parseInt(quantityInput.value);
                
                if (currentQuantity > 1) {
                    const newQuantity = currentQuantity - 1;
                    this.updateQuantity(cartId, newQuantity, quantityInput, cartRow);
                }
            });
            
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
        const self = this; // Capture the correct context

        // Add to cart links and buttons
        const addToCartLinks = document.querySelectorAll('.add-to-cart-link');
        addToCartLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                try {
                    // Get product ID and quantity from data attributes
                    const produk_id = this.getAttribute('data-produk_id');
                    const quantityEl = this.closest('.detail-extralink')?.querySelector('.qty-val');
                    const quantity = this.getAttribute('data-quantity') || 
                                     (quantityEl ? quantityEl.value : 1);

                    // Validate inputs
                    if (!produk_id) {
                        throw new Error('Product ID not found');
                    }

                    // Add to cart using the class method
                    self.addToCart(produk_id, quantity);
                } catch (error) {
                    console.error('Error in add to cart handler:', error);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Unable to add product to cart',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });

        // Setup quantity controls and cart management
        this.setupQuantityControls();
        this.setupClearCart();
        this.updateCartTotal();
        this.updateCartDropdown();
    }
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

document.addEventListener('DOMContentLoaded', function() {
    const cartManager = new CartManager();
    cartManager.init();
});
