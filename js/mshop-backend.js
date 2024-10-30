jQuery(document).ready(function ($) {
	
    $(document).on('click', '#regbtn', function (e) {
        e.preventDefault();
        $("#registration").show();
        $("#mintro").hide();
        $("#m_shop_url_section").hide();
    });
    $(document).on('click', '#back_btn', function (e) {
        e.preventDefault();
        $("#registration").hide();
        $("#mintro").show();
        $("#m_shop_url_section").show();
    });

    $(document).on('click', '#url_verify', function (e) {
        e.preventDefault();
        var contact_regex11 = /^[789]\d{9}$/;
        var phone = $('#ms_phone').val();
        var supplier_id = $('#supplier_id').val();
        if (phone.match(contact_regex11) || phone.length == 10) {
            $('#phone_feedback').html('');
            $('#account_feedback').html('');
			
            $.ajax({
                type: "POST",
                url: mShopAjax.ajaxurl,
                dataType: "json",
                data: {
                    action: "verify_registered_mobile",
                    phone,
                    supplier_id
                },
				beforeSend: function () {	 
                $('.overlay').show();	 					
                },
                success: function (result) {
                    console.log('result',result);
                    if (result.status) {
                        $('#account_feedback')
						.addClass('success')
						.removeClass('error')
						.html(result.message);
                    } else {
                        $('#account_feedback')
						.addClass('error')
						.removeClass('success')
						.html(result.message);
                    }
					$('.overlay').hide();
                },
                error: function (result) {
                }
            });
        } else {
            $('#phone_feedback').text("*Please enter a valid 10 digits mobile number *");
        }
    });

    $(document).on('click', '#register_submit', function (e) {
        e.preventDefault();
        // Initializing Variables With Form Element Values
        var firstname = $('#name').val();
        var userloginpassword = $('#user_login_password').val();
        var shopname = $('#sname').val();
        var shortname = $('#sup_short_name').val();
        var ShopRegistrationYear = $('#sup_registration_year').val();
        var Suppliermailid = $('#sup_email_id').val();
        var Shoplandlineno = $('#sup_ll_number').val();
        var Suppliermobileno = $('#sup_mobile_number').val();
        var Shopgstno = $('#sup_gst_no').val();
        var Supplierpanno = $('#sup_pan_no').val();
        // Initializing Variables With Regular Expressions
        var name_regex = /^[a-zA-Z]+[\-'\s]?[a-zA-Z ]+$/;
        var shopname_regex = /^[0-9a-zA-Z]+$/;
        var shortname_regex = /^[a-zA-Z]+[\-'\s]?[a-zA-Z ]+$/;
        var ShopRegistrationYear_regex = /^[0-9]\d{3}$/;
        var Suppliermailid_regex = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
        var Shoplandlineno_regex = /^[0-9]\d{9}$/;
        var Suppliermobileno_regex = /^[0-9]\d{9}$/;
        var Shopgstno_regex = /^[0-9a-zA-Z]+$/;
        var Supplierpanno_regex = /^[0-9a-zA-Z]+$/;
        // To Check Empty Form Fields.
        if (firstname.length == 0) {
            $('#head').text("* All fields are mandatory *"); // This Segment Displays The Validation Rule For All Fields
            $("#name").focus();
            return false;
        }
        // Validating Name Field.
        else if (!firstname.match(name_regex) || firstname.length == 0) {
            $('#p1').text("* For your name please use alphabets only *"); // This Segment Displays The Validation Rule For Name
            $("#name").focus();
            return false;
        }
        // Validating Supplier Mail Id Field.
        else if (!Suppliermailid.match(Suppliermailid_regex) || Suppliermailid.length == 0) {
            $('#p7').text("* For Supplier Mail Id please use a  valid email address*"); // This Segment Displays The Validation Rule For Supplier Mail Id
            $("#sup_email_id").focus();
            $('#p1').text('');
            return false;
        }

        // Validating shortname Field.
        else if (!shortname.match(shortname_regex) || shortname.length == 0) {
            $('#p5').text("* For your shortname please use alphabets and numbersonly *"); // This Segment Displays The Validation Rule For short Name
            $("#sup_short_name").focus();
            $('#p7').text('');
            return false;
        }
        // Validating shortname Field.
        else if (userloginpassword.length < 6) {
            $('#p66').text("* For your password please enter password with minimuim length of 6 *"); // This Segment Displays The Validation Rule For short Name
            $("#userloginpassword").focus();
            $('#p5').text('');
            return false;
        }
        // Validating supplier mobile number Field.
        else if (!Suppliermobileno.match(Suppliermobileno_regex) || Suppliermobileno.length == 0) {
            $('#p9').text("* For Supplier mobile number please use numbers only*"); // This Segment Displays The Validation Rule For supplier mobile number
            $("#sup_mobile_number").focus();
            $('#p66').text('');
            return false;
        }
        // Validating supplier pan number Field.
        else if (!Supplierpanno.match(Supplierpanno_regex) && Supplierpanno.length > 0) {

            $('#p11').text("* For Supplier PAN number please use numbers only*"); // This Segment Displays The Validation Rule For supplier pan number
            $("#sup_pan_no").focus();
            return false;
        }
        // Validating ShopName Field.
        else if (!shopname.match(shopname_regex) || shopname.length == 0) {
            $('#p3').text("* For your Shop name please use alphabets and numbersonly *"); // This Segment Displays The Validation Rule For Shop Name
            $("#sname").focus();
            $('#p9').text('');
            return false;
        }
        // Validating shop landline number Field.
        else if (!Shoplandlineno.match(Shoplandlineno_regex) && Shoplandlineno.length > 0) {

            $('#p8').text("* For Shop landline no please use numbers only*"); // This Segment Displays The Validation Rule For shop_landline_number
            $("#sup_ll_number").focus();
            return false;
        }
        // Validating shop gst number  Field.
        else if (!Shopgstno.match(Shopgstno_regex) && Shopgstno.length > 0) {
            $('#p10').text("* For Shop GST no please use numbers only*"); // This Segment Displays The Validation Rule For shop gst number
            $("#sup_gst_no").focus();
            return false;
        }
        // Validating Shop Registration Year Field.
        else if (!ShopRegistrationYear.match(ShopRegistrationYear_regex) || ShopRegistrationYear.length == 0) {
            $('#p6').text("* For Shop Registration Year please use numbersonly *"); // This Segment Displays The Validation Rule For  Shop Registration Year
            $("#sup_registration_year").focus();
            $('#p3').text('');
            return false;
        }
        else {
            $('#p6').text('');
            var data = $('#mainform').serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            if (data) {
                $.extend(data, {
                    action: 'register_user_and_shop',
                });
            }
			
            $.ajax({
                type: 'POST',
                url: mShopAjax.ajaxurl,
                data: data,
                dataType: 'json',
                beforeSend: function () {
					 $('.overlay').show();
                },
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        $('#new_reg_sec_feedback')
						.addClass('success')
						.removeClass('error')
						.text(response.message);
                    }else{
						 $('#new_reg_sec_feedback')
						 .addClass('error')
						 .removeClass('success')
						 .text(response.message);
					}
                   
                    $('.overlay').hide();
					
                }
            });
        }
    });
});


