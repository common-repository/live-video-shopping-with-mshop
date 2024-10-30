<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="mshop_register">
    <div class="mshop-left">
        <div id="mshop_main">
            <div id="m_shop_url_section">
                <h2>mShop verification </h2>
                <label for="fname">Enter Registered Mobile No. with mShop</label>
                <input type="text" id="ms_phone" name="ms_phone" value="<?php echo esc_attr($phoneno);?>"
                    placeholder="Enter Registered Mobile No.">

                <p id="phone_feedback" class="error"></p>
                <label for="supplier_id">Enter Supplier ID(if any)</label>
                <input type="number" id="supplier_id" name="supplier_id" value="<?php echo esc_attr($supplier_id);?>"
                    placeholder="Supplier ID">

                <p id="supplier_id_feedback" class="error"></p>
                <input id="url_verify" type="button" value="verify">
                <input class="button" id="regbtn" type="button" value="Sign Up">
                <p id="account_feedback" class=""></p>

            </div>
            <div id="registration" style="display:none;">
                <div class="container">
                    <h2>mShop Registration </h2>
                    <button class="btn" type="button" id="back_btn">Back </button>
                    <p id="head" class="error"></p> <!-- This Segment Displays The Validation Rule -->
                    <div class="supplier_sec">
                        <h3>Supplier Details </h3>
                        <label for="sup_name">Supplier Name *</label>
                        <input type="text" id="name" name="sup_name" placeholder=" Supplier Name"><br>
                        <p id="p1" class="error"></p>
                        <label for="sup_email_id"> Supplier Mail ID *</label>
                        <input type="text" id="sup_email_id" name="sup_email_id" placeholder="Supplier Mail ID"><br>
                        <p id="p7" class="error"></p>

                        <label for="sup_short_name"> Short Name *</label>
                        <input type="text" id="sup_short_name" name="sup_short_name"
                            placeholder="Supplier Short Name"><br>
                        <p id="p5" class="error"></p>
                        <label for="user_login_password"> Supplier Login Password *</label>
                        <input type="password" id="user_login_password" name="user_login_password"
                            placeholder="Password"><br>
                        <p id="p66" class="error"></p>
                        <label for="sup_mobile_number"> Supplier Mobile No *</label>
                        <input type="text" id="sup_mobile_number" name="sup_mobile_number"
                            placeholder="Suplier Mobile No"><br>
                        <p id="p9" class="error"></p>
                        <label for="sup_pan_no"> Supplier PAN No</label>
                        <input type="text" id="sup_pan_no" name="sup_pan_no" placeholder="Supplier PAN No"><br>
                        <p id="p11" class="error"></p>

                    </div>
                    <div class="shop_sec">
                        <h3>Shop Details </h3>
                        <label for="sname">Shop Name *</label>
                        <input type="text" id="sname" name="sname" placeholder="Shop Name"><br>
                        <p id="p3" class="error"></p>


                        <label for="sup_ll_number"> Shop Landline Number</label>
                        <input type="text" id="sup_ll_number" name="sup_ll_number"
                            placeholder="Shop Landline Number"><br>
                        <p id="p8" class="error"></p>


                        <label for="sup_gst_no"> Shop GST No</label>
                        <input type="text" id="sup_gst_no" name="sup_gst_no" placeholder="Shop GST No"><br>
                        <p id="p10" class="error"></p>

                        <label for="sup_registration_year"> Shop Registration Year *</label>
                        <input type="text" id="sup_registration_year" name="sup_registration_year"
                            placeholder="Supplier Registration Year"><br>
                        <p id="p6" class="error"></p>
                    </div>
                    <div class="sub-outer">
                        <input id="register_submit" type="button" value="send">
                        <p id="new_reg_sec_feedback" class=""></p>
                    </div>
                </div>


            </div>
            <div class="mshop-right">
                <div id="mintro" class="mshop_intro_sec">
                    <h4>Important Information:</h4>

                    <ol type="1">
                        <li>To Register on the mShop <a id="regbtn">click here</a> <a href="https://www.mshop.live/"
                                target="_blank">or on Sign Up</a> </li>
                        <li>Once registered successfully on mShop platform you will receive an email from portal with
                            your Shop URL and application URL, registered login credentials. </li>
                        <li>Choose your subscription plan</li>
                        <li>Please login on browser with received login credentials, to cater to all your client calls
                        </li>
                        <li>Please update the bank details for the payment settlement against the purchase.</li>
                        <li>For mshop account verification, please enter the registered credential to input area and
                            click verify.</li>
                        <li>Once verification is completed, you are all set to use mShop features</li>
                        <li>To use mShop – button, anywhere on the website use this Shortcode <b> [Live_Shopping] </b> –
                            preferable add on website to landing page and beside “add to cart” </li>

                        <li>You can reach out to Customer help desk for any help and support at <a
                                href="https://www.mshop.live/" target="_blank">https://www.mshop.live/ </a>
                            You can write you us @ Enquiry@mshop.live and</li>
                    </ol>


                    <address>
                        <p> contact number: Enquiry@mshop.live</p>
                        <p> +91 7899360460 </p>
                        <p> +91 6363739121
                        </p>
                    </address>

                    <p> We welcome all your feedback and suggestions. </p>
                </div>
            </div>
        </div>

    </div>
</div>



<div class="overlay">
    <div class="overlay-img">
        <img src="<?php echo plugin_dir_url(__DIR__) . 'img/1.gif' ?>">
    </div>
</div>