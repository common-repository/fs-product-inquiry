<?php 

defined('ABSPATH') || exit;
/**
 * Main FSPI Product Setting  Class.
 *
 * @class FSPIAction
 */
 
class FSPIAction extends FSPIAlert{ 
	function fspi_kya_app_loopul_budhu_hai(){
		$license_data = get_option('_fspi_license_settings');
		if(!empty($license_data)){
			if($license_data['is_license_verify'] == TRUE){
				$result = FALSE;
			}else{
				$result = TRUE;
			}
		}else{
			$result = TRUE;
		}
		return $result;
	}

	function fspi_kiti_loopul_gudhu_ahe(){
		$license_data = get_option('_fspi_license_settings');
		if(!empty($license_data)){
			if($license_data['is_license_verify'] == TRUE){
				$res = array();
			}else{
				$the_query = new WP_Query(array('post_type' => 'fspi-products'));
				if(!empty($the_query->found_posts)){
					if($the_query->found_posts < 5){
						$res = array();
					}else{
						$res = array( 'create_posts' => 'do_not_allow');
					}
				}else{
					$res = array();
				}
			}
		}else{
			$the_query = new WP_Query(array('post_type' => 'fspi-products'));
			if(!empty($the_query->found_posts)){
				if($the_query->found_posts < 5){
					$res = array();
				}else{
					$res = array( 'create_posts' => 'do_not_allow');
				}
			}else{
				$res = array();
			}
		}
		return $res;
	}
}
new FSPIAction();