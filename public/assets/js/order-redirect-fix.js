/**
 * EMERGENCY FIX: Force order success redirect
 *
 * This script intercepts the checkout form submission and ensures
 * proper redirect to the success page after order placement.
 *
 * Add this to your checkout.blade.php before </body>
 */

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Order redirect fix loaded');

    // Find the checkout form
    const checkoutForm = document.querySelector('form[action*="submit-order"]');

    if (!checkoutForm) {
        console.warn('⚠️ Checkout form not found');
        return;
    }

    console.log('✅ Checkout form found:', checkoutForm.action);

    // Store original submit handler
    const originalSubmit = checkoutForm.onsubmit;

    // Override form submission
    checkoutForm.addEventListener('submit', function(e) {
        console.log('📤 Form submitted');

        // Let validation run first
        if (originalSubmit) {
            const validationResult = originalSubmit.call(this, e);
            if (validationResult === false) {
                console.log('❌ Form validation failed');
                return false;
            }
        }

        // Prevent default AJAX behavior
        e.preventDefault();

        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing Order...';
        }

        // Get form data
        const formData = new FormData(this);

        console.log('📡 Sending order data...');

        // Submit with fetch to get proper response
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            redirect: 'follow'
        })
        .then(response => {
            console.log('📥 Response received:', response.status);

            if (response.redirected) {
                console.log('🔄 Following redirect to:', response.url);
                window.location.href = response.url;
                return;
            }

            return response.json();
        })
        .then(data => {
            if (!data) return; // Already redirected

            console.log('📊 Response data:', data);

            if (data.success && data.redirect_url) {
                console.log('✅ Order successful! Redirecting to:', data.redirect_url);
                window.location.href = data.redirect_url;
            } else if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else if (data.order_number) {
                // Construct redirect URL manually
                const successUrl = window.location.origin + '/order-success/' + data.order_number;
                console.log('✅ Redirecting to:', successUrl);
                window.location.href = successUrl;
            } else {
                console.error('❌ No redirect URL in response');
                alert('Order placed but redirect failed. Please check "My Orders"');
            }
        })
        .catch(error => {
            console.error('❌ Error:', error);
            alert('An error occurred while processing your order. Please check "My Orders" to verify.');

            // Re-enable button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Place Order';
            }
        });

        return false;
    }, true); // Use capture phase

    console.log('✅ Order redirect handler attached');
});
