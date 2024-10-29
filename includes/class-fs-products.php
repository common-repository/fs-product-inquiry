<?php 

defined('ABSPATH') || exit;

/**
 * Main FSPI Product Class.
 *
 * @class FSPIProduct
 */ 
 
class FSPIProduct extends FSPIProductSetting{
	/**
	 * FSPIProduct Constructor.
	 */
	function __construct() {
		add_action( 'init', array($this,'fspi_products'));
		if(!shortcode_exists( 'fspi-show-products-list' ) ) {
			add_shortcode( 'fspi-show-products-list', array($this,'fspi_show_products_list') );
		}
		add_action( 'add_meta_boxes', array($this,'fspi_product_meta_fields'));
		add_action( 'save_post', array($this,'fspi_save_product_meta_data'));
		add_filter( 'template_include', array($this,'fspi_show_product_detail'), 1 );
		add_filter('taxonomy_template', array($this,'fspi_taxonomy_template'));
		add_action('init',array($this,'fspi_register_session'));

		add_action( 'comment_form_logged_in_after', array($this,'fspi_comment_rating_rating_field') );
		add_action( 'comment_form_after_fields', array($this,'fspi_comment_rating_rating_field') );
		add_action( 'wp_enqueue_scripts', array($this,'fspi_comment_rating_styles') );
		add_action( 'comment_post', array($this,'fspi_comment_rating_save_comment_rating') );
		add_filter( 'comment_text', array($this,'fspi_comment_rating_display_rating'));
		add_action( 'wp_ajax_nopriv_fspi_get_inquiry_attribute', array($this,'fspi_get_inquiry_attribute' ));
		add_action( 'wp_ajax_fspi_get_inquiry_attribute', array($this,'fspi_get_inquiry_attribute') );
		add_action( 'wp_ajax_nopriv_fspi_ck_loopul', array($this,'fspi_ck_loopul' ));
		add_action( 'wp_ajax_fspi_ck_loopul', array($this,'fspi_ck_loopul') );
	}
	
	/*
	* Get Inquiry form Attribute fields function
	*/
	function fspi_get_inquiry_attribute_fs($product_id){
		$parents = get_the_terms( $product_id, 'attributes' );
        $categories = $parents;
        $fields = '';
        if(!empty($parents)){
	        foreach( $parents as $parent ): 
	          if($parent->parent == 0){  
	          	$fields .= '<div class="fspi-inquiry-form-setting">
					<label class="fspi-form-lable">'.$parent->name.': </label>
					<div class="fspi-form-input">
						<select name="'.$parent->name.'" >
							<option value="'.$parent->name.'"> Select '.$parent->name.'</option>';
				            foreach( $categories as $category ):
				                if( $parent->term_id == $category->parent ):
				                    $fields .='<option value="'.$category->name.'">'.$category->name.'</option>';
				                endif;
				            endforeach;
	           			$fields .= '</select>
					</div>
				</div>';
	          } 
	        endforeach; 
	    }
        return $fields;
	}

	/*
	* Get Inquiry form Attribute fields By ajax
	*/
	function fspi_get_inquiry_attribute(){
		echo $this->fspi_get_inquiry_attribute_fs($_POST['product_id']);
		wp_die();
	}
	

	function fspi_comment_rating_styles() {
		//wp_register_style( 'fspi-comment-rating-styles', FSPI_BASE_URL.'/assets/public/css/fspi-comment-rating.css');
		wp_enqueue_style( 'dashicons' );
		//wp_enqueue_style( 'fspi-comment-rating-styles' );
	}

	function fspi_comment_rating_save_comment_rating( $comment_id ) {
		if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
		$rating = intval( $_POST['rating'] );
		add_comment_meta( $comment_id, 'rating', $rating );
	}

	function fspi_comment_rating_display_rating( $comment_text ){
		if(get_post_type( get_the_ID() ) == 'fspi-products'){
			if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
				$stars = '<p class="stars">';
				for ( $i = 1; $i <= $rating; $i++ ) {
					$stars .= '<span class="dashicons dashicons-star-filled"></span>';
				}
				$stars .= '</p>';
				$comment_text = $comment_text . $stars;
				return $comment_text;
			} else {
				return $comment_text;
			}
		}
	}

	function fspi_comment_rating_rating_field() {
		if(get_post_type( get_the_ID() ) == 'fspi-products'){
			?>
			<label for="rating"><?php echo esc_html('Rating', 'fspi'); ?> <span class="required">*</span></label>
			<fieldset class="comments-rating">
				<span class="rating-container">
					<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
						<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
					<?php endfor; ?>
					<input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
				</span>
			</fieldset>
			<?php
		}
	}

	/*
	* register session
	*/
	function fspi_register_session(){
	    if( !session_id() )
	        session_start();
	}

	/*
	* Add Custom post product menu
	*/
	function fspi_products(){
		$labels = array(
			'name' => __('FS Product', 'fspi'),
			'singular_name' => __('fspi-product', 'fspi'),
			'add_new' => __('Add New Product', 'fspi'),
			'add_new_item' => __('Add New Product','fspi'),
			'edit_item' => __('Edit Product','fspi'),
			'new_item' => __('New Product','fspi'),
			'view_item' => __('View Product','fspi'),
			'search_items' => __('Search Product','fspi'),
			'not_found' =>  __('Nothing found','fspi'),
			'not_found_in_trash' => __('Nothing found in Trash','fspi'),
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'capabilities' => $this->fspi_kiti_loopul_gudhu_ahe(),
			'hierarchical' => true,
			'menu_position' => 49,
			'supports' => array('title','comments','editor','thumbnail'),
			'menu_icon' => 'dashicons-archive',
			'menu_position' => 51
		); 
		register_post_type( 'fspi-products' , $args );

		// Add new taxonomy
		$labels = array(
		    'name' => _x( 'Attributes', 'fspi' ),
		    'singular_name' => _x( 'Attributes', 'fspi' ),
		    'search_items' =>  __( 'Search Attributes', 'fspi' ),
		    'popular_items' => __( 'Popular Attributes', 'fspi' ),
		    'all_items' => __( 'All Attributes', 'fspi' ),
		    'parent_item' => null,
		    'parent_item_colon' => null,
		    'edit_item' => __( 'Edit Attributes', 'fspi' ), 
		    'update_item' => __( 'Update Attributes', 'fspi' ),
		    'add_new_item' => __( 'Add New Attributes', 'fspi' ),
		    'new_item_name' => __( 'New Attributes Name', 'fspi' ),
		    'separate_items_with_commas' => __( 'Separate Attributes with commas', 'fspi' ),
		    'add_or_remove_items' => __( 'Add or remove Attributes', 'fspi' ),
		    'choose_from_most_used' => null,
		    'menu_name' => __( 'Attributes', 'fspi' ),
		); 

		register_taxonomy('attributes','fspi-products',array(
		    'hierarchical' => true,
		    'labels' => $labels,
		    'show_ui' => true,
		    'update_count_callback' => '_update_post_term_count',
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'attributes' ),
		));

		register_taxonomy(  
		    'fspi-category',  
		    'fspi-products',  
		    array(  
		        'hierarchical' => true,  
		        'label' => 'Category',  
		        'query_var' => true, 
		        'public' => true,
		        'has_archive' => true 
		    )  
		);  
	}

	/*
	* Define meta boxes in add-product
	*/
	function fspi_product_meta_fields(){
		add_meta_box( 'Product fields','Product fields', array($this,'fspi_define_meta_fields'), 'fspi-products', 'advanced', 'high', null );
	}

	/*
	* Define metaboxes fields
	*/
	function fspi_define_meta_fields($post){
		$short_description = get_post_meta( $post->ID, '_fs_short_description', true );
		$product_price = get_post_meta( $post->ID, '_fs_product_price', true );
		$product_selling_price = get_post_meta( $post->ID, '_fs_product_selling_price', true );
		if(get_post_type() == 'fspi-products'){
			wp_register_style( 'fspi-form-css', FSPI_BASE_URL.'assets/admin/css/fspi-form.css' );
			wp_enqueue_style( 'fspi-form-css' );
		}
		include FSPI_BASE_DIR . '/templates/admin/fspi-product-meta-fields.php';
	}

	/*
	* Update meta fields
	*/
	function fspi_save_product_meta_data( $post_id ) {
		 $post_type = get_post_type($post_id);
	    if ( "fspi-products" != $post_type ) return;
	    if(!empty($_POST['_fs_short_description'])){
	    	$short_description = sanitize_text_field( $_POST['_fs_short_description']);
	    	update_post_meta($post_id, '_fs_short_description', trim($short_description));
	    }
	    if(!empty($_POST['_fs_product_price'])){
			$product_price = sanitize_text_field( $_POST['_fs_product_price']);
			update_post_meta($post_id, '_fs_product_price', trim($product_price));
		}
		if(!empty($_POST['_fs_product_selling_price'])){
			$product_selling_price = sanitize_text_field( $_POST['_fs_product_selling_price']);
			update_post_meta($post_id, '_fs_product_selling_price', trim($product_selling_price));
		}
	}

	/*
	* Update wp_query for product search
	*/
	function fspi_post_title_filter($where, $wp_query) {
	    if ( $search_term = $wp_query->get( 'fs_search_post_title' ) ) {
	    	global $wpdb;
	        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $search_term ) . '%\'';
	    }
	    return $where;
	}

	/*
	* Define function to show product list
	*/
	function fs_get_all_products(){
		/*
		* Add filter to update wp_query for product search
		*/
		// if ( ! wp_script_is( 'jquery', 'enqueued' )) {
	 //        wp_deregister_script('jquery');
		// 	wp_enqueue_script('jquery', FSPI_BASE_URL.'assets/public/js/jquery.min.js', array(), null, true);
		// }

		wp_enqueue_script('jquery');

		add_filter( 'posts_where', array($this,'fspi_post_title_filter'), 10, 2 );
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$product_name = !empty($_POST['product_name'])?trim(sanitize_text_field($_POST['product_name'])):'';
		$args = array( 'post_type' => 'fspi-products', 'posts_per_page' => 9, 'paged' => $paged, 'fs_search_post_title' => $product_name);
		$loop = new WP_Query($args);
		/*
		* Remove filter to update wp_query for product search
		*/
		remove_filter( 'posts_where', array($this,'fspi_post_title_filter'), 10 );
		include FSPI_BASE_DIR.'/templates/public/fspi-show-product-list.php';
	}

	/*
	* Define short code to display product list
	*/
	function fspi_show_products_list(){
		if(!is_admin()){
			ob_start();
			/*
			* Load Scripts and Style
			*/
			wp_register_style( 'fspi-shop-page-css', FSPI_BASE_URL.'assets/public/css/fspi-shop-page.css' );
			wp_enqueue_style( 'fspi-shop-page-css' );

			wp_register_style( 'fspi-bootstrap-css', FSPI_BASE_URL.'assets/public/bootstrap/css/bootstrap.min.css' );
			wp_enqueue_style( 'fspi-bootstrap-css' );

			wp_enqueue_script('jquery');

			wp_register_script('fspi-bootstrap-js', FSPI_BASE_URL.'assets/public/bootstrap/js/bootstrap.min.js');
			wp_enqueue_script('fspi-bootstrap-js');

			wp_register_style( 'fspi-inquiry-form-css', FSPI_BASE_URL.'assets/public/css/fspi-inquiry-form.css' );
			wp_enqueue_style( 'fspi-inquiry-form-css' );

			wp_register_script('fspi-inquiry-form-js', FSPI_BASE_URL.'assets/public/js/fs-inquiry.js');
			wp_enqueue_script('fspi-inquiry-form-js');

			wp_localize_script('fspi-inquiry-form-js','ajax_obj',array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajax_nonce' => wp_create_nonce('any_value_here')));

			if(empty($_POST['_fs_product_id'])){
				$this->fs_get_all_products();
			}else{
				if(!empty($_POST['_fs_name']) && !empty($_POST['_fs_email'])){
					$fs_name = trim(sanitize_text_field($_POST['_fs_name']));
					$fs_email = trim(sanitize_email($_POST['_fs_email']));
					if(!empty($this->fspi_ck())){
						$fspi_arr = array(
							'post_author' => 1,
							'post_title' => $fs_name,
							'post_type' => 'fspi-inquiry',
							'post_status' => 'publish',
							'post_date' => date('Y-m-d h:i:s')
						);
						$fspi_inquiry_id = wp_insert_post($fspi_arr);
						foreach ($_POST as $key => $value) {
							add_post_meta($fspi_inquiry_id, trim(sanitize_text_field($key)), trim(sanitize_text_field($value)));
						}
						if(!empty($fspi_inquiry_id)){
							$this->fspi_report_mail($fs_email,$fs_name);
							$this->fspiSuccess(esc_html__('Enquiry send successfully, Thank you!', 'fspi'));
						}else{
							$this->fspiError(esc_html__('Something went wrong.', 'fspi'));
						} 
					}
				}
				if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){
					$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
					$this->fs_get_all_products();
				}else{
					$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
					if(!empty($_POST['fspi_msg'])){
						$this->fs_get_all_products();
					}else{
						if($this->fspi_ck()){
							$attribute_fields = $this->fspi_get_inquiry_attribute_fs($_POST['_fs_product_id']);
							include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php';
						}else{
							$the_query = new WP_Query(array('post_type' => 'fspi-products'));
							if(!empty($the_query->found_posts)){
								if($the_query->found_posts > 5){
									echo '<i style="color:red">Your License is not valid, Please activate valid License</i>';
								}else{
									$attribute_fields = $this->fspi_get_inquiry_attribute_fs($_POST['_fs_product_id']);
									include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php';
								}
							}
						}
					}
				}
			}
			$output_string = ob_get_contents();
			ob_end_clean();
			return $output_string;
		}
	}

	function fspi_ck_m_frm($fspi_stat,$fspi_mess){
        if($fspi_stat){
        	$fspi_form = '<p>'.$fspi_mess.'</p><form action="" method="post">
                        <input type="hidden" name="_fs_product_id" value="<?= get_the_ID() ?>">
                        <button class="all-deals" style="width: 100%">'.esc_html('Inquiry', 'fspi').'</button>
                      </form>';
        }else{
        	$fspi_form = '<p>'.$fspi_mess.'</p>';
        }
        unset($_SESSION['fspi_message']);
		$_SESSION['fspi-field'] = $fspi_form;
	}

	/*
	* FSPI check loopul 
	*/
	function fspi_ck_loopul(){
		echo $this->fspi_ck();
		wp_die();
	}

	/*
	* Define Product Detail in single.php
	*/
	function fspi_show_product_detail( $template_path ) {
	    if ( get_post_type() == 'fspi-products' ) {
	        if ( is_single() ) {
	  //       if ( ! wp_script_is( 'jquery', 'enqueued' )) {
		 //        wp_deregister_script('jquery');
			// 	wp_enqueue_script('jquery', FSPI_BASE_URL.'assets/public/js/jquery.min.js', array(), null, true);
			// }

	        wp_enqueue_script('jquery');

	        wp_register_style( 'fspi-bootstrap-css', FSPI_BASE_URL.'assets/public/bootstrap/css/bootstrap.min.css' );
			wp_enqueue_style( 'fspi-bootstrap-css' );

			//wp_register_script('fspi-bootstrap-js', FSPI_BASE_URL.'assets/public/bootstrap/js/bootstrap.min.js');
			//wp_enqueue_script('fspi-bootstrap-js','',array(),'',true);
			wp_enqueue_script('fspi-bootstrap-js',FSPI_BASE_URL.'assets/public/bootstrap/js/bootstrap.min.js',array(),null,true);

			wp_register_style( 'fspi-inquiry-form-css', FSPI_BASE_URL.'assets/public/css/fspi-inquiry-form.css' );
			wp_enqueue_style( 'fspi-inquiry-form-css');

			wp_register_script('fspi-inquiry-form-js', FSPI_BASE_URL.'assets/public/js/fs-inquiry.js');
			wp_enqueue_script('fspi-inquiry-form-js');

			wp_localize_script('fspi-inquiry-form-js','ajax_obj',array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajax_nonce' => wp_create_nonce('any_value_here')));

	        	if(empty($_POST['_fs_product_id'])){
	        		wp_register_style( 'fspi-shop-page-css', FSPI_BASE_URL.'assets/public/css/fspi-shop-page.css' );
					wp_enqueue_style( 'fspi-shop-page-css' );
		            $template_path = FSPI_BASE_DIR . '/templates/public/fspi-single-product.php';
	        	}else{
					if(!empty($_POST['_fs_name']) && !empty($_POST['_fs_email'])){
						if(!empty($this->fspi_ck())){
							$fs_name = trim(sanitize_text_field($_POST['_fs_name']));
							$fs_email = trim(sanitize_email($_POST['_fs_email']));
							$fspi_arr = array(
								'post_author' => 1,
								'post_title' => $fs_name,
								'post_type' => 'fspi-inquiry',
								'post_status' => 'publish',
								'post_date' => date('Y-m-d h:i:s')
							);
							$fspi_inquiry_id = wp_insert_post($fspi_arr);
							foreach ($_POST as $key => $value) {
								add_post_meta($fspi_inquiry_id, trim(sanitize_text_field($key)), trim(sanitize_text_field($value)));
							}
							if(!empty($fspi_inquiry_id)){
								$this->fspi_report_mail($fs_email,$fs_name);

								$this->fspiSuccess(esc_html__('Enquiry send successfully, Thank you!', 'fspi'));
							}else{
								$this->fspiError(esc_html__('Something went wrong.', 'fspi'));
							} 
						}
					}
					
					if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){
						wp_register_style( 'fspi-shop-page-css', FSPI_BASE_URL.'assets/public/css/fspi-shop-page.css' );
						wp_enqueue_style( 'fspi-shop-page-css' );
						$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
			            $template_path = FSPI_BASE_DIR . '/templates/public/fspi-single-product.php';
					}else{
						$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
						if(!empty($_POST['fspi_msg'])){
							wp_deregister_script('jquery');
							// wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), '3.2.1');

							wp_enqueue_script('jquery');

							wp_register_style( 'fspi-shop-page-css', FSPI_BASE_URL.'assets/public/css/fspi-shop-page.css' );
							wp_enqueue_style( 'fspi-shop-page-css' );
				            $template_path = FSPI_BASE_DIR . '/templates/public/fspi-single-product.php';
						}else{
							$_POST['ckval'] = $this->fspi_ck();
							$_POST['attr'] = $this->fspi_get_inquiry_attribute_fs($_POST['_fs_product_id']);
							$template_path = FSPI_BASE_DIR . '/templates/public/fspi-single-inquiry-form.php';
						}
					}
	        	}
	        }
	    }
	    return $template_path;
	}

	/*
	* Define get texonomy products
	*/
	function fspi_get_texonomy_products(){
		wp_register_style( 'fspi-shop-page-css', FSPI_BASE_URL.'assets/public/css/fspi-shop-page.css' );
		wp_enqueue_style( 'fspi-shop-page-css' );

		$args = array( 'post_type' => 'fspi-products', 'posts_per_page' => 9,'tax_query' => array(
	        array (
	            'taxonomy' => 'fspi-category',
	            'field' => 'term_id',
	            'terms' => get_queried_object_id(),
	        )
	    ));
		$loop = new WP_Query($args);
		include FSPI_BASE_DIR . '/templates/public/fspi-texonomy-template.php';
	}

	/*
	* Define texonomy category template
	*/
	function fspi_taxonomy_template(){
		if(is_tax('fspi-category')){
			wp_register_style( 'fspi-bootstrap-css', FSPI_BASE_URL.'assets/public/bootstrap/css/bootstrap.min.css' );
			wp_enqueue_style( 'fspi-bootstrap-css' );

			wp_enqueue_script('jquery');

			wp_register_script('fspi-bootstrap-js', FSPI_BASE_URL.'assets/public/bootstrap/js/bootstrap.min.js');
			wp_enqueue_script('fspi-bootstrap-js','',array(),false,true);

			wp_register_style( 'fspi-inquiry-form-css', FSPI_BASE_URL.'assets/public/css/fspi-inquiry-form.css' );
			wp_enqueue_style( 'fspi-inquiry-form-css' );

			wp_register_script('fspi-inquiry-form-js', FSPI_BASE_URL.'assets/public/js/fs-inquiry.js');
			wp_enqueue_script('fspi-inquiry-form-js');

			wp_localize_script('fspi-inquiry-form-js','ajax_obj',array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajax_nonce' => wp_create_nonce('any_value_here')));

			if(empty($_POST['_fs_product_id'])){
				$this->fspi_get_texonomy_products();
			}else{
				if(!empty($_POST['_fs_name']) && !empty($_POST['_fs_email'])){
					if(!empty($this->fspi_ck())){
						$fs_name = trim(sanitize_text_field($_POST['_fs_name']));
						$fs_email = trim(sanitize_email($_POST['_fs_email']));
						$fspi_arr = array(
							'post_author' => 1,
							'post_title' => esc_html__($fs_name, 'fspi'),
							'post_type' => 'fspi-inquiry',
							'post_status' => 'publish',
							'post_date' => date('Y-m-d h:i:s')
						);
						$fspi_inquiry_id = wp_insert_post($fspi_arr);
						foreach ($_POST as $key => $value) {
							add_post_meta($fspi_inquiry_id, trim(sanitize_text_field($key)), trim(sanitize_text_field($value)));
						}
						if(!empty($fspi_inquiry_id)){
							$this->fspi_report_mail($fs_email,$fs_name);

							$this->fspiSuccess(esc_html__('Enquiry send successfully, Thank you!', 'fspi'));
						}else{
							$this->fspiError(esc_html__('Something went wrong.', 'fspi'));
						} 
					}
				}
				if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){
					$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
					$this->fspi_get_texonomy_products();
				}else{
					$_POST['fspi_msg'] = $this->fspiGetAlertMSG();
					if(!empty($_POST['fspi_msg'])){
						$this->fspi_get_texonomy_products();
					}else{
						$attribute_fields = $this->fspi_get_inquiry_attribute_fs($_POST['_fs_product_id']);
						include FSPI_BASE_DIR . '/templates/public/fspi-texonomy-inquiry-form.php';
					}
				}
			}
			exit;
		}
	}



}

new FSPIProduct();