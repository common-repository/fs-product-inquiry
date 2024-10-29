<?php 

defined('ABSPATH') || exit;

/**
 * Main FSPI Show alert messages.
 *
 * @class FSPIAlert
 */
 
class FSPIAlert{ 
	function fspiError($message){
		$_SESSION['fspi_message'] = '<div class="fspi-alert"><i style="color:red">'.__($message,'fspi').'</i></div>';
	}

	function fspiSuccess($message){
		$_SESSION['fspi_message'] = '<div class="fspi-alert"><i style="color:green">'.__($message,'fspi').'</i></div>';
	}

	function fspiGetAlertMSG(){
		$msg = !empty($_SESSION['fspi_message'])?sanitize_text_field($_SESSION['fspi_message']):'';
		unset($_SESSION['fspi_message']);
		return $msg;
	}
}

new FSPIAlert();