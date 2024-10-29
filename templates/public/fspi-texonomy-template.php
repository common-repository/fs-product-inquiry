<?php

defined('ABSPATH') || exit;
 /*
 * Template Name: FSPI Texonomy Template
 */
 
get_header(); 
?>
<div class="fspi-product-list-page" >
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header class="entry-header">
					<h1 class="entry-title"><?= __('Category','fspi') ?></h1>
				</header>
			</div>
		</div>
		<div class="row">
			<?= !empty($_POST['fspi_msg']) ? sanitize_text_field($_POST['fspi_msg']) : ''; ?>
		</div>
	    <div class="row">
	    	<!-- The Modal -->
            <div class="modal" id="fspi-model">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <!-- Modal body -->
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <?php include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php'; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- close model -->
	    	<div class="col-md-3">
	    		<div class="list-group">
	    			<?php
	    			 $args = array(
					               'taxonomy' => 'fspi-category',
					               'orderby' => 'name',
					               'order'   => 'ASC'
					           );

					   $cats = get_categories($args);
					   foreach($cats as $cat) {
					?>
					      <a href="<?php echo get_category_link( $cat->term_id ) ?>" class="list-group-item list-group-item-action">
					           <?php echo $cat->name; ?>
					      </a>
					<?php
					   }
	    			?>
				  <!--<a href="#" class="list-group-item list-group-item-action list-group-item-primary">This is a primary list group item</a>-->
				</div>
	    	</div>
	    	<div class="col-md-9">
	    		<div class="row">
			    	<?php if(!empty($loop->posts)){
			    		foreach ($loop->posts as $key => $product) { ?>
			    			<div class="col-md-4 col-sm-6">
				    			<div class="product-grid8">
					                <div class="product-image8">
					                    <a href="<?= get_permalink( $product->ID ) ?>">
						                        <img class="pic-1" src="<?php 
							                        if(has_post_thumbnail($product->ID)){
							                        	echo wp_get_attachment_url( get_post_thumbnail_id($product->ID), 'thumbnail' );
							                        }else{
							                        	echo FSPI_BASE_URL.'assets/public/img/product.png';
							                        }
						                        ?>">
						                        <img class="pic-2" src="<?php
							                        if(has_post_thumbnail($product->ID)){
							                        	echo wp_get_attachment_url( get_post_thumbnail_id($product->ID), 'thumbnail' );
							                        }else{
							                        	echo FSPI_BASE_URL.'assets/public/img/product.png';
							                        }
						                        ?>">
					                    </a>
					                </div>
					                <div class="product-content">
					                    <div class="price"><?= get_option("_fspi_product_currency") ?> <?= get_post_meta($product->ID,'_fs_product_selling_price',true); ?>
					                        <span><?= get_option("_fspi_product_currency") ?> <?= get_post_meta($product->ID,'_fs_product_price',true); ?></span>
					                    </div>
					                    <span class="product-shipping"><?php 
							                $categories = get_the_terms( $product->ID, 'fspi-category' );    

											$count = count($categories);
						                    $i = 1;
						                    if(!empty($categories)){
							                    foreach ($categories as $category) {
							                    	if($count == $i){
							                    		echo $category->name;
							                    	}else{
							                    		echo $category->name.', ';
							                    	}
							                     	$i++;
							                    } 
							                }else{
							                	echo 'No Category';
							                }
					                    ?></span>
					                    <h3 class="title"><a href="<?= get_permalink( $product->ID ) ?>"><?= $product->post_title; ?></a></h3>
					                    <?php  if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){?>
				                        <button class="all-deals" style="width: 100%" onclick="javascript:fspiCK('<?= $product->ID ?>')"><?php echo esc_html('Inquiry', 'fspi'); ?> <div class="fspi-loader fspi-loader-<?= $product->ID ?>" style="display: none;"></div></button>
				                        <?php
				                      }else{
				                      ?>
					                    <form action="" method="post">
					                    	<input type="hidden" name="_fs_product_id" value="<?= $product->ID ?>">
					                    	<button class="all-deals" style="width: 100%"><?php echo esc_html('Inquiry', 'fspi'); ?></button>
					                    </form>
					                <?php } ?>
					                </div>
					            </div>
					        </div>
			        <?php }
			    	} ?>
			    </div>
	    	</div>
	    </div>
	    <div class="row">
	    	<?php  
	    		if(!empty($loop->posts)){
		    		$pagination = paginate_links( 
	                    array(
	                        'format' => '?paged=%#%',
	                        'current' => max( 1, get_query_var( 'paged' ) ),
	                        'total' => $loop->max_num_pages
	                        ) 
	                );
	                echo $pagination;
	            }
            ?>
	    </div>
	</div>

</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>