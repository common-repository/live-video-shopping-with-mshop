<?php
/*
Plugin Name: Live Video Shopping with MShop
Plugin URI: https://mShop.live/
description:  mShop is a Live video Shopping Platform where buyers and supplier get connected over a Video calls. It offers customers in-personalize shopping experience live with their favorite stores hassle-free. The video commerce made it easy to get the delivery from any corner of the word. Go live with mShop in just few minutes - digital store.
Version: 1.0
Author: Asti Infotech
Author URI: https://rndexperts.com/
Text Domain : mshop
License: GPL2
 */
if (!defined('ABSPATH')) {
    exit;
}

class Mshop
{

    /**
     *
     *
     * @since 0.1.0
     * @var string
     */
    public $version = '1.0';

    /*
     * construct function
     *
     * @since 0.1.0
     */
    public function __construct()
    {
        if (defined('DOING_CRON') and DOING_CRON) {
            return;
        }
        if ($this->is_wc_active()) {
            $this->includes();
            //$this->settings->init();
            register_activation_hook(
                __FILE__,
                array($this, 'wc_active_activate')
            );
            add_action(
                'plugins_loaded',
                array($this, 'plugin_init')
            );
            add_action(
                'admin_menu',
                array($this, 'user_clicks_insight_admin_menu')
            );
        } else {
            add_action(
                'admin_menu',
                array($this, 'my_admin_menu')
            );
            register_activation_hook(
                __FILE__,
                array($this, 'jwe_activate')
            );
        }
        add_action(
            'activated_plugin',
            array($this, 'function_activation_redirect'),
            10,
            2
        );
        /* Add a custom setting tab to Woocommerce > Settings section */
        add_filter(
            'woocommerce_settings_tabs_array',
            array($this, 'add_settings_tab')
        );
        // The setting tab content
        add_action(
            'woocommerce_settings_mshop',
            array($this, 'display_customer_list_tab_content')
        );

        add_shortcode(
            'Live_Shopping',
            array($this, 'mshop_custom_shortcode')
        );
        add_action(
            'woocommerce_after_add_to_cart_button',
            array($this, 'mshop_after_add_to_cart_btn'),
            10,
            2
        );
        add_action(
            "wp_ajax_register_guest_user_frontend",
            array($this, "register_guest_user_frontend")
        );
        add_action(
            "wp_ajax_nopriv_register_guest_user_frontend",
            array($this, "register_guest_user_frontend")
        );
        add_action(
            "wp_ajax_register_user_and_shop",
            array($this, "register_user_and_shop")
        );
        add_action(
            "wp_ajax_nopriv_register_user_and_shop",
            array($this, "register_user_and_shop")
        );
        add_action(
            "wp_ajax_verify_registered_mobile",
            array($this, "verify_registered_mobile_number")
        );
        add_action(
            "wp_ajax_nopriv_verify_registered_mobile",
            array($this, "verify_registered_mobile_number")
        );
    }

    /**
     * Include plugin file.
     *
     * @since 0.1.0
     *
     */
    public function includes()
    {
        // require_once $this->get_plugin_path() . '/includes/woo-tab.php';
    }

    public function my_admin_menu()
    {
        add_menu_page(
            __('Mshop setting', 'mshop'),
            __('Mshop setting', 'mshop'),
            'manage_options',
            'mshop-setting-page',
            array($this, 'notices_menu_callback')
        );
    }

    public function notices_menu_callback()
    {
        $message = __('mShop requires WooCommerce 3.0 or a newer version', 'mshop');
        echo "<div class='error'><p>".esc_html($message)."</p></div>";
        echo '<div class="error">';
        echo '<p>';
        printf(__('Please install and activate %sWooCommerce%s in order to use the mShop plugin', 'mshop'), '<a href="' . admin_url('plugin-install.php?tab=search&s=WooCommerce&plugin-search-input=Search+Plugins') . '">', '</a>');
        echo '</p>';
        echo '</div>';
    }

    public function user_clicks_insight_admin_menu()
    {
        add_menu_page(
            __('Mshop', 'mshop'),
            __('Mshop', 'mshop'),
            'manage_options',
            'mshop-users-insights',
            array($this, 'user_clicks_insight_admin_menu_callback')
        );
        add_submenu_page(
            'mshop-users-insights',
            __('users clicks List', 'mshop'),
            __('users clicks List', 'mshop'),
            'manage_options',
            'mshop-users-insights',
            array($this, 'user_clicks_insight_admin_menu_callback')
        );
    }

    public function user_clicks_insight_admin_menu_callback()
    {
        $file = $this->get_plugin_path() . '/assets/json_files/mshop_clicks_insight.json';
        $jsonData = json_decode(file_get_contents($file), true);
        if (empty($jsonData)) {
            $jsonData = [];
        }
        require_once $this->get_plugin_path() . '/templates/mshop-users-click-list.php';
    }

    public function function_activation_redirect()
    {
        if (is_admin() && get_option('mshop_activation_redirect') == 'mshop') {
            // Make sure we don't redirect again after this one
            delete_option('mshop_activation_redirect');
            wp_safe_redirect(admin_url('admin.php?page=mshop-setting-page'));
            exit;
        }
        if (is_admin() && get_option('mshop_wc_active') == 'mshop') {
            // Make sure we don't redirect again after this one
            delete_option('mshop_wc_active');
            wp_safe_redirect(admin_url('admin.php?page=wc-settings&tab=mshop'));
            exit;
        }
    }

    public function wc_active_activate()
    {
        add_option('mshop_wc_active', 'mshop');
    }

    public function jwe_activate()
    {
        add_option('mshop_activation_redirect', 'mshop');
    }

    /**
     * plugin file dir hooks
     *
     * @since 0.1.0
     *
     */
    public function plugin_dir_url()
    {
        return plugin_dir_url(__FILE__);
    }

    /**
     * Gets the absolute plugin path without a trailing slash, e.g.
     * /path/to/wp-content/plugins/plugin-directory.
     *
     * @since 0.1.0
     * @return string plugin path
     */
    public function get_plugin_path()
    {
        if (isset($this->plugin_path)) {
            return $this->plugin_path;
        }
        $this->plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
        return $this->plugin_path;
    }

    /**
     * init hooks
     *
     * @since 0.1.0
     *
     */
    public function plugin_init()
    {
        //callback on activate plugin
        //register_activation_hook(__FILE__, array($this, 'on_activation'));
        //hooks for frontend
        add_action(
            'wp_enqueue_scripts',
            array($this, 'wc_rnd_frontend_enqueue'),
            10,
            2
        );
        //load javascript in admin
        add_action(
            'admin_enqueue_scripts',
            array($this, 'wc_esrc_enqueue')
        );
    }

    public function on_activation()
    {
        //WC_Geolocation::update_database();
    }

    /**
     * Add plugin action links.
     *
     * Add a link to the settings page on the plugins.php page.
     *
     * @since 0.1.0
     *
     * @param  array  $links List of existing plugin action links.
     * @return array         List of modified plugin action links.
     */
    public function my_plugin_action_links($links)
    {
        $links = array_merge(array(
            '<a href="' . esc_url(admin_url('admin.php?page=wc-settings&tab=mshop')) . '">' . __('mShop', 'mshop') . '</a>'
        ), $links);
        return $links;
    }

    /**
     * Check if WC is active
     *
     * @access private
     * @since  1.0.0
     * @return bool
     */
    private function is_wc_active()
    {
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }
        if (is_plugin_active('woocommerce/woocommerce.php')) {
            $is_active = true;
        } else {
            $is_active = false;
        }

        // Do the WC active check
        if (false === $is_active) {
            /* add_action('admin_notices', array($this, 'notice_activate_wc')); */
        }
        return $is_active;
    }

    /**
     * Display WC active notice
     *
     * @access public
     * @since  1.0.0
     */
    public function notice_activate_wc()
    {
        echo '<div class="error">';
        echo '<p>';
        printf(__('Please install and activate %sWooCommerce%s for mShop', 'mshop'), '<a href="' .esc_url(admin_url('plugin-install.php?tab=search&s=WooCommerce&plugin-search-input=Search+Plugins')). '">', '</a>');
        echo '</p>';
        echo '</div>';
    }

    /**
     * WOOCOMMERCE_VERSION admin notice
     *
     * @since 0.1.0
     */
    public function admin_error_notice()
    {
        $message = __(' mShop requires WooCommerce 3.0 or newer', 'mshop');
        echo "<div class='error'><p>".esc_html($message)."</p></div>";
    }

    /*
     * Add admin javascript
     *
     * @since 0.1.0
     */
    public function wc_esrc_enqueue()
    {
        $page = isset($_GET["page"]) ? sanitize_text_field($_GET["page"]) : "";
        // Add condition for css & js include for admin page
        if ($page != ('mshop-setting-page' || 'wc-settings&tab=mshop' || 'mshop-users-insights')) {
            return;
        }

        wp_register_style(
            'mshop-bootstrap',
            plugins_url('css/bootstrap.min.css', __FILE__)
        );
        wp_enqueue_style('mshop-bootstrap');
        wp_register_script(
            'mshop-bootstrap',
            plugins_url('js/bootstrap.min.js', __FILE__),
            array('jquery'),
            $this->version
        );
        wp_enqueue_script(
            'mshop-bootstrap'
        );
        wp_register_style(
            'datatables-admin',
            plugins_url('assets/datatables/css/datatables.min.css', __FILE__)
        );
        wp_enqueue_style('datatables-admin');
        wp_register_script(
            'datatables-admin',
            plugins_url('assets/datatables/js/datatables.min.js', __FILE__),
            array('jquery','mshop-bootstrap'),
            $this->version
        );
        wp_enqueue_script('datatables-admin');
        
        wp_register_style(
            'mshop-admin',
            plugins_url('css/mshop-backend.css', __FILE__)
        );
        wp_enqueue_style('mshop-admin');
        wp_register_script(
            'mshop-admin',
            plugins_url('js/mshop-backend.js', __FILE__),
            array('jquery','datatables-admin'),
            $this->version
        );
        wp_enqueue_script('mshop-admin');
        // localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily
        wp_localize_script(
            'mshop-admin',
            'mShopAjax',
            array('ajaxurl' => admin_url('admin-ajax.php'))
        );
    }

    /*
     * Add frontend css
     *
     * @since 0.1.0
     */
    public function wc_rnd_frontend_enqueue()
    {
        wp_enqueue_script(
            'mshop-frontend',
            plugin_dir_url(__FILE__) . 'js/mshop-frontend.js',
            array('jquery'),
            $this->version
        );
        wp_localize_script(
            'mshop-frontend',
            'ajax_object',
            array('front_ajax_url' => admin_url('admin-ajax.php')
            )
        );
        wp_enqueue_style(
            'mshop-frontend',
            plugin_dir_url(__FILE__) . 'css/mshop-frontend.css',
            array(),
            $this->version
        );
    }

    /** Create mshop url **/
    /**
     * @param string $content
     *
     * @return [type]
     */
    public function mshop_custom_shortcode($content = '')
    {
        ob_start();
        $user = [];
        $phoneno = '';
        $url = '#';
        $login_url = esc_url(wp_login_url(get_permalink()));
        if (get_option('mshop_register_phone_no')) {
            $product_link ='';
            if (is_product()) {
                global $product;
                $product_link = get_permalink($product->id);
            }
            

            $phoneno = get_option('mshop_register_phone_no') ? get_option('mshop_register_phone_no') : '';
            $supplier_id = get_option('mshop_register_supplier_id') ? get_option('mshop_register_supplier_id') : 0;
            $url = 'https://on.mshop.live/' . $phoneno;
            if (is_user_logged_in()) {
                echo '<button href="' . esc_attr($url) . '"   data-product_link="'. esc_attr($product_link).'"  data-phone_no="' . esc_attr($phoneno) . '" data-supplier_id="' . esc_attr($supplier_id) . '" data-login_link="" data-login_status="1" class="button" id="speak_to_us">Speak to us</button>';
            } else {
                echo '<button href="' . esc_attr($url) . '" data-product_link=""  data-phone_no="" data-supplier_id="" data-login_link="' . esc_attr($login_url) . '" data-login_status="0" class="button" id="speak_to_us">Speak to us</button>';
            }
        }
        return ob_get_clean();
    }

    /*** add button after addtocart**/
    public function mshop_after_add_to_cart_btn()
    {
        echo do_shortcode('[Live_Shopping]');
    }

    /** Verify registered mobile number and supplier with mshop**/

    /**
     * @return [type]
     */
    public function verify_registered_mobile_number()
    {
        $response = ['status' => 0, 'message' => '', 'supplier' => ''];
        if (isset($_POST['phone'])) {
            $supplier_id = $_POST['supplier_id'] ?sanitize_text_field($_POST['supplier_id']): 0;
            $url = 'https://services.mshop.live/checkSupplierBeforeQueueV3/' . sanitize_text_field($_POST['phone']) . '/' . $supplier_id;
            $res = $this->callRestApi("POST", $url);
            if (!empty($res)) {
                if ($res['supplier'] !== null) {
                    $supplier_id = $res['supplier']['id'] ? $res['supplier']['id']: 0;
                    update_option('mshop_register_phone_no', sanitize_text_field($_POST['phone']));
                    update_option('mshop_register_supplier_id', $supplier_id);
                    $message = 'Your Account is verified sucessfully.';
                    $response = ['status' => 1, 'message' => $message, 'supplier' => $res['supplier'], 'res' => $res];
                } else {
                    update_option('mshop_register_phone_no', '');
                    update_option('mshop_register_supplier_id', '');
                    $message = 'Please enter the registered login credentials with mshop. Please check the number you entered or buy the <a href="https://www.mshop.live/">mShop Subscription </a>';
                    $response = ['status' => 0, 'message' => $message, 'supplier' => '', 'res' => $res];
                }
            }
        }
        echo json_encode($response);
        die();
    }

    /* Register shop and user in single api to  mshop **/

    /**
     * @return [type]
     */
    public function register_user_and_shop()
    {
        $response = ['status' => 0, 'message' => '', 'phone' => '', 'supplier_id' => '', 'supplier' => ''];
        $phoneno = get_option('mshop_register_phone_no') ? get_option('mshop_register_phone_no') : '';
        $supplier_id = get_option('mshop_register_supplier_id') ? get_option('mshop_register_supplier_id') : 0;
        $data = [];
        $body ='';
        if (isset($_POST['sup_mobile_number'])) {
            $requestData =[];
            $sup_name = sanitize_text_field($_POST['sup_name']);
            $sup_mobile_number = sanitize_text_field($_POST['sup_mobile_number']);
            $sup_email_id = sanitize_email($_POST['sup_email_id']);
            $user_login_password = sanitize_text_field($_POST['user_login_password']);
            $ms_phone = sanitize_text_field($_POST['ms_phone']);
            $sup_short_name = sanitize_text_field($_POST['sup_short_name']);
            $sup_pan_no = sanitize_text_field($_POST['sup_pan_no']);
            $sup_ll_number = sanitize_text_field($_POST['sup_ll_number']);
            $sup_gst_no = sanitize_text_field($_POST['sup_gst_no']);
            $sup_registration_year = sanitize_text_field($_POST['sup_registration_year']);
            $sname = sanitize_text_field($_POST['sname']);
            $sup_ll_number = sanitize_text_field($_POST['sup_ll_number']);
            $requestData['sup_name'] = $sup_name;
            $requestData['sup_mobile_number'] = $sup_mobile_number;
            $requestData['sup_email_id'] = $sup_email_id;
            $requestData['user_login_password'] = $user_login_password;
            $requestData['ms_phone'] = $ms_phone;
            $requestData['sup_short_name'] = $sup_short_name;
            $requestData['sname'] = $sname;
            $requestData['sup_pan_no'] = $sup_pan_no;
            $requestData['sup_ll_number'] = $sup_ll_number;
            $requestData['sup_gst_no'] = $sup_gst_no;
            $requestData['sup_registration_year'] = $sup_registration_year;
            $requestData['user_login_name'] = $sup_mobile_number;
            $requestData['sup_custom_url'] = "";
            $requestData['sup_shop_url'] = "";
            $requestData['sup_coie_no'] = "";
            $requestData['created_by'] = "woocommerce";
            $url = 'https://services.mshop.live/insertSupplierDetails';
            $res = $this->callRestApi("POST", $url, json_encode($requestData));
            if (!empty($res)) {
                if ($res['id']) {
                    $to = $email;
                    $subject = 'mShop New Registration';
                    require_once $this->get_plugin_path() . '/templates/emails/new-register.php';
                    $headers = array('Content-Type: text/html; charset=UTF-8');
                    $headers[] = 'From: mShop <Enquiry@mshop.live>';
                    if (wp_mail($to, $subject, $body, $headers)) {
                    }
                    $message = $res['message'] ?: 'Shop is registerd sucessfully.';
                    //update_option('mshop_register_phone_no', $phone);
                    //update_option('mshop_register_supplier_id', $res['id']);
                    $response = ['status' => 1, 'phone' => $phone, 'supplier_id' => $res['id'], 'message' => $message, 'data' => $requestData, 'res' => $res];
                } else {
                    $message = $res['message'] ?: 'Some error has occured.';
                    $response = ['status' => 0, 'phone' => '', 'supplier_id' => '', 'message' => $message, 'supplier' => '', 'res' => $res];
                }
            }
        }
        echo json_encode($response);
        die();
    }

    /**
     * register guest user api call to  mshop
     *
     * @return [type]
     */
    public function register_guest_user_frontend()
    {
        $response = ['status' => 0, 'message' => ''];
        $data = [];
        if (isset($_POST['phone'])) {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $user = (array) $current_user;
                $UserData = get_user_meta($user['data']->ID);
                $data['name'] = $user['data']->display_name;
                $data['email'] = $user['data']->user_email;
                $data['address'] = isset($UserData['billing_address_1'][0])?$UserData['billing_address_1'][0]:'';
                $data['phoneNumber'] = isset($UserData['billing_phone'][0])?$UserData['billing_phone'][0]:'';
            }
            $supplier_id = $_POST['supplier_id']?sanitize_text_field($_POST['supplier_id']): 0;
            $data['sup_id'] = $supplier_id;
            $url = 'https://services.mshop.live/insertGuestUserdetails/V2';
            $res = $this->callFormRestApi("POST", $url, $data);
            if (!empty($res)) {
                $res = (array) json_decode($res);
                $response = ['status' => 0, 'message' => '', 'user' => $user];
                if (!empty($res['id'])) {
                    $message = $res['message'] ?: 'User is saved sucessfully.';
                    update_option('mshop_register_phone_no', sanitize_text_field($_POST['phone']));
                    $response = ['status' => 1, 'message' => $message, 'user' => $user['data'], 'res' => $res];
                } else {
                    $message = $res['message'] ?: 'User is not saved.';
                    $response = ['status' => 0, 'message' => $message, 'data' => $data, 'user' => $user['data'], 'res' => $res];
                }
            }
            if (isset($_POST['product_link'])) {
                $data['product_link'] = $_POST['product_link']?sanitize_url($_POST['product_link']):'';
            }
            if (isset($data['sup_id'])) {
                unset($data['sup_id']);
            }
            $save_clicks_arr =[];
            $file = $this->get_plugin_path() . '/assets/json_files/mshop_clicks_insight.json';
            $jsonData = json_decode(file_get_contents($file), true);
            if (!empty($jsonData)) {
                $jsonData[] =$data;
            } else {
                $jsonData = [];
                $jsonData[] =$data;
            }
            if (file_put_contents($file, json_encode($jsonData))) {
            }
        }
        echo json_encode($response);
        die();
    }

    /**
     *  Wp remote rest api in using application/json
     * @param mixed $method
     * @param mixed $url
     * @param bool $data
     *
     * @return [type]
     */
    public function callRestApi($method, $url, $data = false)
    {
        switch ($method) {
            case "POST":
                $options = [
                    'body'        => $data,
                    'headers'     => [
                        'Content-Type' => 'application/json',
                    ],
                    'data_format' => 'body',
                ];
                $response = wp_remote_post($url, $options);
                break;
            case "PUT":
                $options = [
                    'body'        => $data,
                    'headers'     => [
                        'Content-Type' => 'application/json',
                    ],
                    'method' => 'PUT',
                ];
                $response = wp_remote_request($url, $options);
                break;
            default:
            $args = array(
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            );
                $response =wp_remote_get($url, $args);
        }

        if (is_array($response) && is_wp_error($response)) {
            $message = __('Sorry We are not Verify APi Key, Please try again.', 'mshop');
        } else {
            $result = json_decode($response['body'], true);
            error_log($response['body']);
        }
        return $result;
    }

   

    /**
     * add mshop tab to woocommerce settings
     *
     * @param mixed $settings_tabs
     *
     * @return [type]
     */
    public function add_settings_tab($settings_tabs)
    {
        $settings_tabs['mshop'] = __('mShop', 'mshop');
        return $settings_tabs;
    }

    /**
     * add contents to mshop custom tab
     *
     * @return [type]
     */
    public function display_customer_list_tab_content()
    {
        $phoneno = get_option('mshop_register_phone_no') ? get_option('mshop_register_phone_no') : '';
        $supplier_id = get_option('mshop_register_supplier_id') ? get_option('mshop_register_supplier_id') : 0;
        require_once plugin_dir_path(__FILE__) . 'templates/mshop-register-verify-form.php';
    }
}

$pbvwp = new Mshop();
