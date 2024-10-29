<?php 
defined('ABSPATH') || exit;
?>
<h3><?= __( 'General Setting', 'fspi' ) ?></h3>
<div class="fspi-setting">
	<?php if(!empty($setting_message)){ ?>
		<div id="message" class="updated notice notice-success is-dismissible">
			<p><?= $setting_message ?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?= __('Dismiss this notice.','fspi') ?></span></button>
		</div>
	<?php } ?>
	<div class="fspi-general-setting">
		<h4><?= __('Enquiry page setting','fspi') ?></h4>
		<form action="#" method="post">
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Enquiry form open in the popup model','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="checkbox" name="_fspi_inquiry_form_open_in_popup" value="true" 
					<?php 
					if(get_option('_fspi_inquiry_form_open_in_popup')==TRUE){
						echo 'checked';
					} ?>>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Select Currency','fspi') ?>: </label>
				<div class="fspi-form-input">
					<select name="_fspi_product_currency" id="_fspi_product_currency">
						<option value=""><?= __('-- Select Currency --','fspi') ?></option>
					</select>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"></label>
				<div class="fspi-form-input">
					<input type="submit" name="fspi_general_setting" class="button button-primary" value="Submit">
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	var fs_selected_currency = '<?= get_option("_fspi_product_currency") ?>';
</script>