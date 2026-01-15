/**
 * Fix for checkout form submission and redirect
 * Add this script to checkout.blade.php before closing </body> tag
 */

$(document).ready(function() {
    console.log('🔧 Checkout redirect fix loaded');
    
    // Override form submit to handle redirect properly
    $('.checkoutform').off('submit').on('submit', function(e) {
        var form = $(this);
        var actionUrl = form.attr('action');
        var method = form.attr('method') || 'POST';
        
        console.log('📝 Form submitting to:', actionUrl);
        
        // Validate required fields
        var name = $('input[name="customer_name"]').val();
        var phone = $('input[name="customer_phone"]').val();
        
        if(!name || name.trim() === '') {
            alert('Please enter your name');
            e.preventDefault();
            return false;
        }
        
        if(!phone || phone.trim() === '') {
            alert('Please enter your phone number');
            e.preventDefault();
            return false;
        }
        
        // Show loader
        $('#preloader').show();
        $('#place-order-btn').prop('disabled', true);
        $('#place-order-btn .btn-text').hide();
        $('#place-order-btn .btn-loader').removeClass('d-none');
        
        // Use AJAX to get response and then manually redirect
        e.preventDefault();
        
        $.ajax({
            url: actionUrl,
            type: method,
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                console.log('✅ Order response:', response);
                
                if(response.success && response.redirect) {
                    console.log('🔄 Redirecting to:', response.redirect);
                    window.location.href = response.redirect;
                } else if(response.error) {
                    alert(response.error);
                    $('#preloader').hide();
                    $('#place-order-btn').prop('disabled', false);
                    $('#place-order-btn .btn-text').show();
                    $('#place-order-btn .btn-loader').addClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ Order submission error:', error);
                console.error('Response:', xhr.responseText);
                
                alert('An error occurred. Please try again.');
                $('#preloader').hide();
                $('#place-order-btn').prop('disabled', false);
                $('#place-order-btn .btn-text').show();
                $('#place-order-btn .btn-loader').addClass('d-none');
            }
        });
        
        return false;
    });
});
