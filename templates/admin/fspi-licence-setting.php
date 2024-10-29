<?php 
defined('ABSPATH') || exit;
?>
<h3><?= __( 'Licence Setting', 'fspi' ) ?></h3>
<div class="fspi-setting">
	<?php if(!empty($setting_message[0])){ ?>
		<div id="message" class="updated notice notice-success is-dismissible">
			<p><?= __($setting_message[0],'fspi') ?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?= __('Dismiss this notice.','fspi') ?></span></button>
		</div>
	<?php } ?>
	<?php if(!empty($setting_message) && empty($setting_message[1])){ ?>
		<div id="message" class="notice notice-error">
			<p><?= __('Only first 5 Products are allowed to send enquiry, To allow more products please purchase our plan <a href="https://www.fudugo.com/products/" target="_blank">Click Here</a>','fspi')?></p>
		</div>
	<?php } ?>
	<div class="fspi-setting-email"> 
		<form action="#" method="post">
			<h4><?= __('To get Licence key Please click <a href="https://www.fudugo.com/products/" target="_blank">Here</a>','fspi') ?></h4>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Email','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="email" name="_fspi_licence_email" 
					value="<?= !empty($licence_setting)?$licence_setting['email']:''; ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Licence Key','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_licence_key" 
					value="<?= !empty($licence_setting)?$licence_setting['license_key']:''; ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"></label>
				<div class="fspi-form-input">
					<input type="submit" name="fspi_licence_setting" class="button button-primary" value="Submit">
				</div>
			</div>
		</form>
	</div>
</div>