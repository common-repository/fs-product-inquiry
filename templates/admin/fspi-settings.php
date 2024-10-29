<?php 
defined('ABSPATH') || exit;
?>
<div class="fspi-setting">
	<?php if(!empty($setting_message)){ ?>
		<div id="message" class="updated notice notice-success is-dismissible">
			<p><?= $setting_message ?></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?= __('Dismiss this notice.','fspi') ?></span></button>
		</div>
	<?php } ?>
	<div class="fspi-inquiry-form">
		<h4><?= __('Add New Field','fspi')?></h4>
		<form action="#" method="post">
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Title Name','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fs_field_title" required>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Placeholder Name','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="text" name="_fs_field_placeholder" required>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Field Position','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="number" name="_fs_field_position" min="1" required>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Is Required','fspi') ?>: </label>
				<div class="fspi-form-input">
					<input type="checkbox" name="_fs_field_is_required" value="true">
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"><?= __('Feild Type','fspi') ?>: </label>
				<div class="fspi-form-input">
					<div class="fspi-radio-fields">
						<label><?= __('Text','fspi') ?>: </label>
						<input type="radio" name="_fs_field_type" value="text" required>
					</div>
					<div class="fspi-radio-fields">
						<label><?= __('Number','fspi') ?>: </label>
						<input type="radio" name="_fs_field_type" value="number" required>
					</div>
					<div class="fspi-radio-fields">
						<label><?= __('Email','fspi') ?>: </label>
						<input type="radio" name="_fs_field_type" value="email" required>
					</div>
				</div>
			</div>
			<div class="fspi-form-group">
				<label class="fspi-form-lable"></label>
				<div class="fspi-form-input">
					<input type="submit" name="fspi_inquiry_form_submit" class="button button-primary" value="Submit">
				</div>
			</div>
		</form>
	</div>
	<div class="fspi-inquiry-form-detail">
		<h4><?= __('Inquiry Form View','fspi') ?></h4>
		<?php 
			echo do_shortcode('[fspi-inquiry-form]');
		?>
	</div>
</div>