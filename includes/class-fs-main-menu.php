<?php 

defined('ABSPATH') || exit;

/**
 * Main FSPI Main Menu Class. 
 *
 * @class FSPIMenu
 */
class FSPIMenu{ 
	/**
	 * FSPIMenu Constructor.
	 */
	function __construct() {
		add_action( 'admin_menu', array($this,'fspi_main_menu'));
		add_action( 'init', array($this,'fspi_inquiry_menu') );
		add_action( 'add_meta_boxes', array($this,'fspi_inquiry_meta_fields'));
	}

	/*
	* Define Inquiry menu
	*/
	function fspi_inquiry_menu() {
		register_post_type( 'fspi-inquiry',
		array(
			   'labels' => array(
			   'name' => __( 'FS Inquiries' ),
			   'singular_name' => __( 'FS Inquiries' )
			  ),
			  'capability_type' => 'post',
			  'capabilities' => array(
			    'create_posts' => 'do_not_allow', 
			  ),
			  'map_meta_cap' => true,
			  'create_posts' => false,
			  'public' => true,
			  'has_archive' => false,
			  'menu_icon' => 'dashicons-megaphone',
			 // 'show_in_menu' => false,
			  'rewrite' => array('slug' => 'fspi-inquiry'),
			  'supports' => array('title'),
			  'menu_position' => 50
		   )
		);
	}
	
	/*
	* Manage FSPI Setting Page
	*/
	function fspi_admin_settings_page(){
		global $fspi_active_tab;
		$fspi_active_tab = isset( $_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general'; 
		$license_data = get_option('_fspi_license_settings');
		?>
		<div class="fspi-main-setting">
			<h2><?= __('FSPI Settings','fspi') ?></h2>
			<?php if(empty($license_data['is_license_verify'])){ ?>
			<div id="message" class="notice notice-error is-dismissible">
				<p><?= __('Only first 5 Products are allowed to send enquiry, To allow more products please purchase our plan <a href="https://www.fudugo.com/products/" target="_blank">Click Here</a>','fspi')?></p>
			</div>
			<?php } ?>
			<div id="message" class="updated notice notice-success is-dismissible">
				<p><?= __('Use this <b>[fspi-show-products-list]</b> Shortcode to Show Inquiry Products.','fspi'); ?></p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html('Dismiss this notice.', 'fspi'); ?></span></button>
			</div>
			<div id="message" class="updated notice notice-success is-dismissible">
				<p><?= __('To add products, Activate License key, To get Lisence please click <a href="https://www.fudugo.com/products/" target="_blank">Here</a>','fspi'); ?></p>
				<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html('Dismiss this notice.', 'fspi'); ?></span></button>
			</div>
			<h2 class="nav-tab-wrapper">
			<?php do_action('fspi_settings_tab'); ?>
			</h2>
			<?php do_action('fspi_settings_content'); ?>
		</div>
		<?php
	}

	/**
	 * FSPI custom post meta main menu
	 */
	function fspi_main_menu() {
	    /*
	    * Add admin setting sub-menu
	    */
	    // add_submenu_page( 'fs-product-inquiry', 'FS Inquiry', 'FS Inquiries', 'manage_options', 'edit.php?post_type=fspi-inquiry', NULL );

	    add_submenu_page( 
	        'edit.php?post_type=fspi-inquiry', 'Setting', 'Setting', 'manage_options', admin_url('options-general.php?page=fspi-setting')
	    );

	    add_options_page('FS Setting', 'FS Settings', 'manage_options', 'fspi-setting', array($this,'fspi_admin_settings_page'));
	}

	/*
	* Add main page template
	*/
	function fs_product_inquiry(){//fspi-inquiry
		wp_redirect('edit.php?post_type=fspi-inquiry');
		//include FSPI_BASE_DIR.'templates/admin/fspi-product-inquiry.php';
	}

	/*
	* Add setting page template
	*/
	function fspi_setting(){
	      $url = admin_url('options-general.php?page=fspi-setting');
	      if ( wp_redirect( $url ) ) {
		    exit;
		}
	}

	/*
	* Define meta boxes in Inquiry Detail
	*/
	function fspi_inquiry_meta_fields(){
		add_meta_box( 'Inquiry fields','Inquiry fields', array($this,'fspi_define_inquiry_fields_temp'), 'fspi-inquiry', 'advanced', 'high', null );
	}

	/*
	* Define Inquiry metaboxes fields
	*/
	function fspi_define_inquiry_fields_temp($post){
		if(get_post_type() == 'fspi-inquiry'){
			if(is_admin()){
				wp_register_style( 'fspi-form-css', FSPI_BASE_URL.'assets/admin/css/fspi-form.css' );
				wp_enqueue_style( 'fspi-form-css' );
				$fields = get_post_meta(get_the_ID());

				foreach ($fields as $key => $field) {
					if($key == '_fs_product_id'){
						echo '<div class="fspi-form-group">
								<h3>'.get_the_title($field[0]).'</h3>
							</div>';
					}else if($key != '_edit_lock'){
						$name = str_replace("_"," ",str_replace("_fs_"," ",$key));
						echo '<div class="fspi-form-group">
							<label class="fspi-form-lable"> '.$name.': </label>
							<div class="fspi-form-input">
								<input type="text" name=" '.$key.'" 
								value=" '.$field[0].'" required readonly/>
							</div>
						</div>';
					}
				}

			}
		}

	}

}
new FSPIMenu();