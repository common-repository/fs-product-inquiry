<?php 
defined('ABSPATH') || exit; 
?>
<div class="fspi-setting-email">
	<div class="fspi-form-group">
		<label class="fspi-form-lable"><?= __('Product price','fspi') ?>: </label>
		<div class="fspi-form-input">
			<input type="number" name="_fs_product_price" 
			value="<?php echo esc_attr( $product_price ); ?>" required/>
		</div>
	</div>
	<div class="fspi-form-group">
		<label class="fspi-form-lable"><?= __('Product selling price','fspi') ?>: </label>
		<div class="fspi-form-input">
			<input type="number" name="_fs_product_selling_price" 
			value="<?php echo esc_attr( $product_selling_price ); ?>" required/>
		</div>
	</div>
	<div class="fspi-form-group">
		<label class="fspi-form-lable"><?= __('Short description','fspi') ?>: </label>
		<div class="fspi-form-input">
			<textarea name="_fs_short_description" rows="3" required><?php echo esc_attr( $short_description ); ?></textarea>
		</div>
	</div>
</div>
