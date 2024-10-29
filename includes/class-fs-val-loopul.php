<?php 

defined('ABSPATH') || exit;

/**
 * Main FS val Class.
 *
 * @class FSValLoopul
 */ 
 
final class FSValLoopul extends FSPIProductSetting{
   /**
	 * FSValLoopul Constructor.
	 */
	public function __construct() {
		//add_action('init',array($this,'fspi_create_inquiry_page'));
	}


	public function fspi_create_inquiry_page(){
		//update_option('_fspi_check_val',$this->fspi_ck('check')); 
		
	}

}

new FSValLoopul();