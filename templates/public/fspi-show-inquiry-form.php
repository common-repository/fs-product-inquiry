<?php 
defined('ABSPATH') || exit;
?>
<div class="fspi-inquiry-form" style="max-width:100%">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3><?= __('Inquiry Form','fspi') ?></h3>
			</div>
			<div class="col-md-12">
				<?php 
				$fspi_ck_val = 1;//get_option('_fspi_check_val');
				if($fspi_ck_val){
				?>
				<form action="" method="post">
					<input type="hidden" name="_fs_product_id" value="<?php if(!empty($_POST['_fs_product_id'])){echo $_POST['_fs_product_id'];} ?>">
					<?php echo do_shortcode('[fspi-inquiry-form]'); ?>
					<div class="fspi_add_attributes_fields"></div>
					<?php if(!empty($attribute_fields)){echo $attribute_fields;} ?>
					<div class="fspi-inquiry-form-setting">
						<button type="submit"><?= __('Submit Inquiry','fspi') ?></button>
					</div>
				</form>
			<?php }else{
				echo '<p style="color:red">'.__("Your License key is not valid, Please use valid license key.","fspi").'</p>';
			} ?>
			</div>
		</div>
	</div>
</div>