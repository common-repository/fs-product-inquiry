<?php 
/**
 * Plugin Name: FS Product Inquiry
 * Description: This Plugin is used for product enquiry.
 * Version: 1.1.1
 * Author: Fudugo Team
 * Author URI: https://fudugo.com
 * Text Domain: FSPI
 * Tested up to: 5.5.1
 *
 * @package FS Product Inquiry
 */

defined('ABSPATH') || exit;

if(!defined('FSPI_BASE_URL')){
    define('FSPI_BASE_URL', plugin_dir_url(__FILE__));
}

if(!defined('FSPI_BASE_DIR')){
	define('FSPI_BASE_DIR', plugin_dir_path(__FILE__));	
}

/**
* Load Main Menu Class
*/
if ( ! class_exists( 'FSProductInquiry', false ) ) {
    include FSPI_BASE_DIR. '/includes/class-fs-product-inquiry.php';
} 

/**
 * Define FSPI Default Values.
 */
if(!function_exists('fspi_plugin_activated')){
    function fspi_plugin_activated(){
        $field = array(
            array(
                'id'                    => 1,
                '_fs_field_title'       => 'Name',
                '_fs_field_type'        => 'text',
                '_fs_field_placeholder' => 'Enter Your Name',
                '_fs_field_position'    => 1,
                '_fs_field_is_required' => true
            ),
            array(
                'id'                    => 2,
                '_fs_field_title'       => 'Email',
                '_fs_field_type'        => 'email',
                '_fs_field_placeholder' => 'Enter Your Email',
                '_fs_field_position'    => 2,
                '_fs_field_is_required' => true
            )
        );
        $inquiry_form_fields = $field;
        update_option('_fspi_inquiry_form_fields',$inquiry_form_fields);
        update_option( '_fspi_server_url', 'https://www.fudugo.com/' );

        if (!get_page_by_title('FSPI Product Inquiry')) {
            $PageGuid = site_url() . "/fspi-product-inquiry";
            $fspi_inquiry_page  = array( 
                    'post_title'     => esc_html__( 'FSPI Product Inquiry', 'fspi' ),
                    'post_type'      => 'page',
                    'post_name'      => 'fspi-product-inquiry',
                    'post_content'   => '[fspi-show-products-list]',
                    'post_status'    => 'publish',
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_author'    => 1,
                    'menu_order'     => 0,
                    'guid'           => $PageGuid 
                );
            $PageID = wp_insert_post( $fspi_inquiry_page, FALSE );
        }
    }
}
register_activation_hook( __FILE__, "fspi_plugin_activated");

/**
 * Returns the main instance of FSPI.
 * @return FSProductInquiry
 */
function FSPI() { 
    return FSProductInquiry::instance();
}

// Global for backwards compatibility.
$GLOBALS['FSProductInquiry'] = FSPI();
