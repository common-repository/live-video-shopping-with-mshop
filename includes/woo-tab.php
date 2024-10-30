<?php
class WC_Settings_Tab_Mshop
{

    public static function init()
    {
        add_filter('woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50);
        add_action('woocommerce_settings_tabs_mshop', __CLASS__ . '::settings_tab');
        add_action('woocommerce_update_options_mshop', __CLASS__ . '::update_settings');
        //add custom type
        add_action('woocommerce_admin_field_custom_type', __CLASS__ . '::output_custom_type', 10, 1);
    }

    public static function output_custom_type($value)
    {
        //you can output the custom type in any format you'd like
        $option_value = (array) WC_Admin_Settings::get_option($value['id']);
        $description = WC_Admin_Settings::get_field_description($value);
        $phoneno = '';
        $supplier_id = 0;
        $phoneno = get_option( 'mshop_register_phone_no')?get_option( 'mshop_register_phone_no'):'';
        $supplier_id = get_option( 'mshop_register_supplier_id')? get_option( 'mshop_register_supplier_id'):0;
       require_once( plugin_dir_path(__DIR__) . 'templates/mshop-register-verify-form.php');
    }

/*
 * Add a new settings tab to the WooCommerce settings tabs array.
 *
 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
 */
    public static function add_settings_tab($settings_tabs)
    {
        $settings_tabs['mshop'] = __('mShop', 'mshop');
        return $settings_tabs;
    }

/*
 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
 *
 * @uses woocommerce_admin_fields()
 * @uses self::get_settings()
 */
    public static function settings_tab()
    {
        woocommerce_admin_fields(self::get_settings());
    }

/*
 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
 *
 * @uses woocommerce_update_options()
 * @uses self::get_settings()
 */
    public static function update_settings()
    {
        woocommerce_update_options(self::get_settings());
    }

/*
 * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
 *
 * @return array Array of settings for @see woocommerce_admin_fields() function.
 */
    public static function get_settings()
    {

        $settings = array(
            'section_title' => array(
                'name' => __('mShop Settings', 'mshop'),
                'type' => 'title',
                'desc' => '',
                'id' => 'wc_settings_tab_mshop_section_title'
            ),
            /* 'description' => array(
            'name' => __( 'Description', 'woocommerce-settings-tab-mshop' ),
            'type' => 'textarea',
            'desc' => __( 'This is a paragraph describing the setting.', 'woocommerce-settings-tab-mshop' ),
            'id'   => 'wc_settings_tab_mshop_description'
            ),
             */
            'custome_type' => array(
                'name' => __('mShop activation steps', 'mshop'),
                'type' => 'custom_type',
                'desc' => 'abc',
                'id' => 'wc_settings_tab_mshop_custom_type'
            ),
            /*
            'mshop_supplier_phone' => array(
                'name' => __('', 'mshop'),
                'type' => 'text',
                //'css' => 'display:none;',
                'class' => 'supplier_phone',
                //'desc' => __( 'This is some helper text', 'woocommerce-settings-tab-mshop' ),
                'id' => 'wc_settings_tab_mshop_supplier_phone'
            ),
            'mshop_supplier_id' => array(
                'name' => __('', 'mshop'),
                'type' => 'text',
               // 'css' => 'display:none;',
                'class' => 'supplier_id',
                //'desc' => __( 'This is some helper text', 'woocommerce-settings-tab-mshop' ),
                'id' => 'wc_settings_tab_mshop_supplier_id'
            ),
            */
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'wc_settings_tab_mshop_section_end'
            )
        );
        return apply_filters('wc_settings_tab_mshop_settings', $settings);
    }

}

WC_Settings_Tab_Mshop::init();
