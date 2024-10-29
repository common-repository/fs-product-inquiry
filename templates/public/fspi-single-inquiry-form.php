<?php

defined('ABSPATH') || exit;

 /*
 * Template Name: FSPI Single Inquiry Form
 */
 
get_header(); 
?>
<div class="fspi-product-detail">
    <div id="fspi-product-detail-content" >
        <div class="container">
            <div class="row">
            	<div class="col-md-12">
            		<?= !empty($_POST['fspi_msg'])?sanitize_text_field($_POST['fspi_msg']):''; ?>
            		<?php
                    if(!empty($_POST['ckval'])){
                        if(!empty($_POST['attr'])){
                            $attribute_fields = sanitize_text_field($_POST['attr']);
                        }
                        include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php'; 
                    }else{
                        echo '<i style="color:red">Your License is not valid, Please activate valid License</i>';
                    }
                    ?>
            	</div>
            </div>
        </div>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>