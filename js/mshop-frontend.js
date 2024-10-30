jQuery(document).ready(function($) {

    $(document).on('click', '#speak_to_us', function(e) {
        e.preventDefault();
        var login_status = $(this).attr('data-login_status');
        var product_link = $(this).attr('data-product_link');
        var phone = $(this).attr('data-phone_no');
        var mshop_link = $(this).attr('href');
        var supplier_id = $(this).attr('data-supplier_id');
        if (login_status == '1') {

            $.ajax({
                type: "POST",
                url: ajax_object.front_ajax_url,
                dataType: "json",
                data: {
                    action: "register_guest_user_frontend",
                    phone,
                    supplier_id,
                    product_link
                },
                success: function(result) {
                    console.log('result', result);
                    if (result.status) {
                        window.location.href = mshop_link;
                    } else {
                        window.location.href = mshop_link;
                    }
                },
                error: function(result) {
                    console.log('result', result);
                }
            });
        } else {
            alert('Please Login first to speak to us');
        }
    });


});