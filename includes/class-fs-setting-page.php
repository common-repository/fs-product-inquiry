<?php 

defined('ABSPATH') || exit;

/**
 * Main FSPI Setting Page Class.
 *
 * @class FSPISetting
 */
 
class FSPISetting extends FSPIProductSetting{
	/**
	 * FSPISetting Constructor.
	 */
	public function __construct() {
		add_action( 'fspi_settings_tab', array($this,'fspi_setting_tabs'), 1 );
		add_action( 'fspi_settings_content', array($this,'fspi_setting_tab_content' ));
		if(!shortcode_exists( 'fspi-inquiry-form' ) ) {
			add_shortcode( 'fspi-inquiry-form', array($this,'fspi_display_inquiry_form') );
		}
	}

	/*
	* Create FSPI Setting Page tabs
	*/
	function fspi_setting_tabs(){
		global $fspi_active_tab; ?>
		<a class="nav-tab <?php echo $fspi_active_tab == 'general' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=fspi-setting&tab=general' ); ?>"><?= __( 'General', 'fspi' ); ?> </a>
		<a class="nav-tab <?php echo $fspi_active_tab == 'inquiry-form' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=fspi-setting&tab=inquiry-form' ); ?>"><?= __( 'Inquiry Form', 'fspi' ); ?> </a>
		<a class="nav-tab <?php echo $fspi_active_tab == 'email' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=fspi-setting&tab=email' ); ?>"><?= __( 'Email', 'fspi' ); ?> </a>
		<a class="nav-tab <?php echo $fspi_active_tab == 'licence' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=fspi-setting&tab=licence' ); ?>"><?= __( 'Licence', 'fspi' ); ?> </a>
		<?php
	}

 	/*
	* Create FSPI Setting Page tabs content
	*/
	function fspi_setting_tab_content() {
		global $fspi_active_tab;

		if(!empty($_POST['field_id'])){
			$fields = get_option('_fspi_inquiry_form_fields');
			$new_fields_array = [];
			foreach ($fields as $field) {
				if($field['id'] != $_POST['field_id']){
					$new_fields_array[] = $field;
				}
			}
			if(update_option('_fspi_inquiry_form_fields',$new_fields_array)){
				$setting_message = esc_html('Data deleted successfully.', 'fspi');
			}else{
				$setting_message = esc_html('Something went wrong, Please try again.', 'fspi');
			}
		}
		if(!empty($_GET['page'])){
			if($_GET['page'] == 'fspi-setting'){
				wp_register_style( 'fspi-setting', FSPI_BASE_URL.'assets/admin/css/fspi-setting.css' );
				wp_enqueue_style( 'fspi-setting' );
			}
		}

		if ( $fspi_active_tab == 'general' || ''){
			if(!empty($_POST['fspi_general_setting'])){
				unset($_POST['fspi_general_setting']);
				if(!empty($_POST['_fspi_product_currency'])){
					update_option('_fspi_product_currency',sanitize_text_field($_POST['_fspi_product_currency']));
				}
				if(!empty($_POST['_fspi_inquiry_form_open_in_popup'])) {
					update_option('_fspi_inquiry_form_open_in_popup',sanitize_text_field($_POST['_fspi_inquiry_form_open_in_popup']));
				}else{
					delete_option('_fspi_inquiry_form_open_in_popup');
				}
				$setting_message = esc_html('Data updated successfully.', 'fspi');
			}
			wp_register_script('fspi-product-currency-js', FSPI_BASE_URL.'assets/public/js/fs-product-currency.js');
			wp_enqueue_script('fspi-product-currency-js');
			include FSPI_BASE_DIR.'templates/admin/fspi-general-setting.php';
		}

		if ($fspi_active_tab == 'inquiry-form' ){ 
			echo '<h3>'.__( 'Inquiry Form', 'fspi' ).'</h3>';
			if(!empty($_POST['fspi_inquiry_form_submit'])){
				unset($_POST['fspi_inquiry_form_submit']);
				$inquiry_form_fields = get_option('_fspi_inquiry_form_fields');
				if(!empty($inquiry_form_fields)){
					$_POST['id'] = count($inquiry_form_fields)+1;
					$inquiry_form_fields[] = sanitize_text_field($_POST);
				}else{
					$_POST['id'] = 1;
					$inquiry_form_fields = [];
					$inquiry_form_fields[] = sanitize_text_field($_POST);
				}
				if(update_option('_fspi_inquiry_form_fields',$inquiry_form_fields)){
					$setting_message = esc_html('New field added successfully.', 'fspi');
				}else{
					$setting_message = esc_html('Something went wrong, Please try again.', 'fspi');
				}
			}
			include FSPI_BASE_DIR.'templates/admin/fspi-settings.php';
		}
		if ($fspi_active_tab == 'email' ){
			if(!empty($_POST['fspi_email_setting'])){
				unset($_POST['fspi_email_setting']);
				foreach ($_POST as $key => $value) {
					update_option($key,trim(sanitize_text_field($value)));
				}
				$setting_message = esc_html('Data updated successfully.', 'fspi');
			}
			include FSPI_BASE_DIR.'templates/admin/fspi-email-setting.php';
		}
		if ($fspi_active_tab == 'licence' ){
			if(!empty($_POST['fspi_licence_setting'])){
				unset($_POST['fspi_licence_setting']);
				if(!empty($_POST['_fspi_licence_key']) && !empty($_POST['_fspi_licence_email'])){ 
					$licence = trim(sanitize_text_field($_POST['_fspi_licence_key']));
					$email = trim(sanitize_text_field($_POST['_fspi_licence_email']));
					$setting_message = $this->do_active($licence,$email);
				}
			}
			$licence_setting = get_option('_fspi_license_settings');
			include FSPI_BASE_DIR.'templates/admin/fspi-licence-setting.php';
		}
	}

	function fspi_sort_multi_dimessional_array($a,$b) 
	{
	    return ($a["_fs_field_position"] <= $b["_fs_field_position"]) ? -1 : 1;
	}
  
	/*
	* Define shortcode to display Inquiry form fields
	*/
	function fspi_display_inquiry_form(){
		global $wp;
		$fields = get_option('_fspi_inquiry_form_fields');
		if(!empty($fields)){
			usort($fields, array($this,"fspi_sort_multi_dimessional_array"));
			foreach ($fields as $field) { ?>
				<div class="fspi-inquiry-form-setting">
					<label class="fspi-form-lable"><?= __($field['_fs_field_title'],'fspi') ?>: </label>
					<div class="fspi-form-input">
						<input type="<?= $field['_fs_field_type'] ?>" name="_fs_<?= str_replace(' ','_',strtolower(trim($field['_fs_field_title']))) ?>" placeholder="<?= $field['_fs_field_placeholder'] ?>" <?php if(!empty($field['_fs_field_is_required'])){echo 'required';}else{echo '';} ?> >
					</div>
					<?php if(is_admin() && $field['id'] != 1 && $field['id'] != 2){ ?>
					<div class="fspi-form-input-delete">
						<form action="" method="post">
							<input type="hidden" name="field_id" value="<?= $field['id'] ?>">
							<button type="submit" onclick="return confirm('Are you sure you want to delete? ')"><span class="dashicons dashicons-trash"></span></button>
						</form>
					</div>
				<?php } ?>
				</div>
			<?php }
		}
	}


}

new FSPISetting();