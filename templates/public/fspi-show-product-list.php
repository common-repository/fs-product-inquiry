<?php 
defined('ABSPATH') || exit;
?>
<div class="fspi-product-list-page" >
	<div class="container">
		<div class="row">
			<div class="col-md-12">
    			<?= !empty($_POST['fspi_msg']) ? sanitize_text_field($_POST['fspi_msg']) : '' ; ?>
    		</div>
    		<div class="col-md-12">
			    <div class="fs-search-product">
			    	<form class="form-inline" method="POST" action="" id="productSearchForm">
			    		<input type="text" name="product_name" class="form-control" id="inputSearch" placeholder="Search by Product Name" value="<?php if(!empty($_POST['product_name'])){echo sanitize_text_field($_POST['product_name']); } ?>">
					    
					    <button type="submit" class="btn btn-default mb-2 set-color" style="margin-right: 5px;color: #fff;"><?php echo esc_html('Search', 'fspi'); ?></button>
					    <button type="button" onclick="javascript:resetSearchProduct()" class="btn btn-default mb-2" style="color: #fff;"><?php echo esc_html('Reset', 'fspi'); ?></button>
					</form>
			    </div>
			</div>
		</div>
	</div>
	<div class="container">
	    <div class="row">
	    	<!-- The Modal -->
			<div class="modal fspi-model" id="fspi-model">
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

			<?php
			$args = array(
			               'taxonomy' => 'fspi-category',
			               'orderby' => 'name',
			               'order'   => 'ASC'
			           );
		   $cats = get_categories($args);
		   if($cats) {
		   ?>
	    	<div class="col-md-3">
	    		<div class="list-group">
	    			<?php
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
			<?php
			}
			?>

	    	
	    	<div class="col-md-9">
	    		<div class="row">
			    	<?php if(!empty($loop->posts)){
			    		foreach ($loop->posts as $key => $product) { ?>
			    			<div class="col-md-4 col-sm-6">
				    			<div class="product-grid8 product-box-b">
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
						                    $i = 1;
						                    if(!empty($categories)){
						                    	$count = count($categories);
							                    foreach ($categories as $category) {
							                    	if($count == $i){
							                    		echo esc_html($category->name, 'fspi');
							                    	}else{
							                    		echo esc_html($category->name, 'fspi').', ';
							                    	}
							                     	$i++;
							                    } 
							                }else{
							                	echo esc_html('No Category', 'fspi');
							                }
					                    ?></span>
					                    <h3 class="title"><a href="<?= get_permalink( $product->ID ) ?>"><?= esc_html($product->post_title, 'fspi'); ?></a></h3>
					                    <?php
					                    if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){?>
					                    	<button class="all-deals" style="width: 100%" onclick="javascript:fspiCK('<?= $product->ID ?>')"><?php echo esc_html('Inquiry', 'fspi'); ?> <div class="fspi-loader fspi-loader-<?= $product->ID ?>" style="display: none;"></div></button>
					                    	<?php
					                    }else{
					                    ?>
					                    <form action="" method="post">
					                    	<input type="hidden" name="_fs_product_id" value="<?= $product->ID ?>">
					                    	<button class="all-deals" style="width: 100%"><?php echo esc_html('Inquiry', 'fspi'); ?> </button>
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
