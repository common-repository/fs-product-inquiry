<?php

defined('ABSPATH') || exit;

 /*
 * Template Name: FSPI Texonomy Inquiry Form
 */
 
get_header(); 
?>
<div class="fspi-product-list-page" >
	<div class="container">
	    <div class="row">
	    	<div class="col-md-12">
	    		<?php if(!empty($_SESSION['fspi_message'])){ 
            		echo '<div style="padding: 5px 30px;">'.sanitize_text_field($_SESSION['fspi_message']).'</div>'; 
            		unset($_SESSION['fspi_message']);
            	 } ?>
        		<?php 
        		if($this->fspi_ck()){
        			include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php'; 
        		}else{
						echo '<i style="color:red">Your License is not valid, Please activate valid License</i>';
				}
        		?>
	    	</div>
	    </div>
	</div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>