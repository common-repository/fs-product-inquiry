<?php 
defined('ABSPATH') || exit;
?>
<h3><?= __( 'Email', 'fspi' ) ?></h3>
<div class="fspi-setting">
	<?php if(!empty($setting_message)){ ?>
		<div id="message" class="updated notice notice-success is-dismissible">
			<p><?= $setting_message ?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?= __('Dismiss this notice.','fspi') ?></span></button>
		</div>
	<?php } ?>
	<div class="fspi-setting-email">
		<form action="#" method="post">
			<h4><?= __('Email Sender Options Setting','fspi') ?></h4>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('From name','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_email_from" 
					value="<?= get_option('_fspi_email_from') ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('From address','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_email_from_address" 
					value="<?= get_option('_fspi_email_from_address') ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Admin Email','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_email_admin" 
					value="<?= get_option('_fspi_email_admin') ?>" />
				</div>
			</div>
			<h4><?= __('Email template','fspi') ?></h4>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Email Heading Text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_email_heading_text"  value="<?= get_option('_fspi_email_heading_text') ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Customer Email Subject Text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_customer_email_sub"  value="<?= get_option('_fspi_customer_email_sub') ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Admin Email Subject Text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fspi_admin_email_sub"  value="<?= get_option('_fspi_admin_email_sub') ?>" />
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Footer text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<textarea name="_fspi_email_footer_text" rows="2"><?= get_option('_fspi_email_footer_text') ?></textarea>
				</div>
			</div>
			<h4><?= __('Email body text','fspi') ?></h4>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Customer email body text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<textarea name="_fspi_customer_email_body_text" rows="2"><?= get_option('_fspi_customer_email_body_text') ?></textarea>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Admin email body text','fspi') ?>: </label>
				<div class="fspi-form-input">
					<textarea name="_fspi_admin_email_body_text" rows="2"><?= get_option('_fspi_admin_email_body_text') ?></textarea>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"></label>
				<div class="fspi-form-input">
					<input type="submit" name="fspi_email_setting" class="button button-primary" value="Submit">
				</div>
			</div>
		</form>
	</div>
</div>