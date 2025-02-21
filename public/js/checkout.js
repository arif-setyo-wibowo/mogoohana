document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const couponForm = document.getElementById('coupon-form');
    const couponCodeInput = document.getElementById('coupon-code');
    const totalPurchaseInput = document.getElementById('total-purchase-input');
    const discountElement = document.getElementById('discount');
    const totalElement = document.getElementById('total');
    const appliedCouponCodeInput = document.getElementById('applied_coupon_code');

    // Flag to track if coupon has been applied
    let couponApplied = false;
    let originalTotal = parseFloat(totalPurchaseInput.value);

    function formatCurrency(number) {
        return number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Only proceed if we're on the checkout page with these elements
    if (couponForm && couponCodeInput && totalPurchaseInput && discountElement && totalElement) {
        couponForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (couponApplied) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'A coupon has already been applied to this order',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            }

            const couponCode = couponCodeInput.value;
            const totalPurchase = originalTotal; // Always use original total for calculation

            fetch('/validate-coupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    coupon_code: couponCode,
                    total_purchase: totalPurchase
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    // Update discount and total display
                    const discountAmount = parseFloat(data.discount_amount);
                    const newTotal = totalPurchase - discountAmount;
                    
                    discountElement.textContent = `$${formatCurrency(discountAmount)}`;
                    totalElement.textContent = `$${formatCurrency(newTotal)}`;
                    totalPurchaseInput.value = newTotal.toFixed(2);
                    
                    // Set the coupon code in the hidden input
                    if (appliedCouponCodeInput) {
                        appliedCouponCodeInput.value = couponCode;
                    }

                    // Mark coupon as applied
                    couponApplied = true;
                    couponForm.querySelector('button[type="submit"]').disabled = true;
                    couponCodeInput.disabled = true;

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Coupon applied successfully!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    // Reset values if coupon is invalid
                    discountElement.textContent = '$0.00';
                    totalElement.textContent = `$${formatCurrency(totalPurchase)}`;
                    totalPurchaseInput.value = totalPurchase.toFixed(2);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
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
                    title: 'Error',
                    text: 'An error occurred while validating the coupon',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        });
    }
});
