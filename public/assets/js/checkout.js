document.addEventListener('DOMContentLoaded', function () {
    const paymentMethodSelect = document.querySelector('#payment_method');
    const paymentDetailsContainer = document.querySelector('#payment-details');
    const paymentDetails = document.querySelectorAll('.payment-detail');
    const checkoutForm = document.querySelector('form');
    const submitButton = document.querySelector('#checkout-submit-btn');

    // Initially hide submit button and payment details
    submitButton.style.display = 'none';
    paymentDetailsContainer.style.display = 'none';
    paymentDetails.forEach(detail => {
        detail.style.display = 'none';
    });

    // File input name and validation handling
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function (event) {
            const file = event.target.files[0];
            let fileName = file ? file.name : "Choose file...";
            this.nextElementSibling.innerText = fileName;

            // Validate file
            if (file) {
                // Check file type (must be an image)
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please upload a valid image (JPEG, PNG, JPG)');
                    this.value = ''; // Clear the file input
                    this.nextElementSibling.innerText = "Choose file...";
                    return;
                }

                // Check file size (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('File size must not exceed 5MB');
                    this.value = ''; // Clear the file input
                    this.nextElementSibling.innerText = "Choose file...";
                    return;
                }
            }

            // Validate payment method and file
            validatePaymentAndFile();
        });
    });

    // Add event listener to payment method select
    paymentMethodSelect.addEventListener('change', function () {
        const selectedPaymentMethod = paymentMethodSelect.value;

        // Hide all payment details and submit button
        paymentDetails.forEach(detail => {
            detail.style.display = 'none';
        });
        submitButton.style.display = 'none';

        // Show/hide payment details container
        if (selectedPaymentMethod) {
            paymentDetailsContainer.style.display = 'block';

            // Show selected payment details
            const selectedPaymentDetail = document.querySelector(
                `#${selectedPaymentMethod}-details`);
            if (selectedPaymentDetail) {
                selectedPaymentDetail.style.display = 'block';
            }

            // Enable corresponding file input
            const correspondingFileInput = document.querySelector(
                `#${selectedPaymentMethod}-details input[name="bukti_pembayaran_${selectedPaymentMethod.toLowerCase()}"]`
                );
            if (correspondingFileInput) {
                correspondingFileInput.disabled = false;
            }
        } else {
            paymentDetailsContainer.style.display = 'none';
        }
    });

    // Function to validate payment method and file
    function validatePaymentAndFile() {
        const selectedPaymentMethod = paymentMethodSelect.value;

        if (!selectedPaymentMethod) {
            submitButton.style.display = 'none';
            return;
        }

        const correspondingFileInput = document.querySelector(
            `#${selectedPaymentMethod}-details input[name="bukti_pembayaran_${selectedPaymentMethod.toLowerCase()}"]`
            );

        if (correspondingFileInput && correspondingFileInput.files.length > 0) {
            submitButton.style.display = 'block';
        } else {
            submitButton.style.display = 'none';
        }
    }

    const couponCodeInput = document.querySelector('#coupon-code');
    const applyCouponButton = document.querySelector('#apply-coupon-btn');
    const couponMessage = document.querySelector('#coupon-message');

    applyCouponButton.addEventListener('click', function () {
        const couponCode = couponCodeInput.value.trim();
        
        // Validate coupon code input
        if (!couponCode) {
            return; // Simply stop execution if no coupon code
        }

        // Determine total purchase amount
        const totalPurchaseInput = document.querySelector('input[name="total_purchase"]');
        const totalPurchase = totalPurchaseInput ? parseFloat(totalPurchaseInput.value) : 0;

        // Prepare request data
        const requestData = {
            coupon_code: couponCode,
            total_purchase: totalPurchase
        };

        // Perform fetch request with CSRF token
        fetch('/validate-coupon', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            // Ensure response is OK
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response
            if (data.valid) {
                // Success toast
                Swal.fire({
                    icon: 'success',
                    title: 'Coupon Applied!',
                    text: `Coupon "${couponCode}" has been successfully applied.`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                // Update discount and total
                const discountElement = document.getElementById('discount');
                const totalElement = document.getElementById('total');
                const subtotalElement = document.getElementById('subtotal');

                if (discountElement) {
                    discountElement.textContent = '$' + data.discount_amount.toFixed(2);
                }

                if (totalElement && subtotalElement) {
                    // Remove quotes, dollar sign, and commas before parsing
                    const subtotalText = subtotalElement.textContent.replace(/["$,]/g, '').trim();
                    const subtotal = parseFloat(subtotalText);
                    const newTotal = Math.max(0, subtotal - data.discount_amount);
                    totalElement.textContent = '$' + newTotal.toFixed(2);
                }
            } else {
                // Error toast
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Coupon',
                    text: data.message || 'The coupon code you entered is not valid.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch(error => {
            // Catch and log any errors
            console.error('Coupon validation error:', error);
            
            // Error toast
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while applying the coupon.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    });
});
