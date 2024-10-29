<?php 

defined('ABSPATH') || exit;
/**
 * Main FSPI Product Setting  Class.
 *
 * @class FSPIProductSetting
 */
 
class FSPIProductSetting extends FSPIAction{
	/**
	 * FSPISetting Constructor.
	 */
	public function __construct() {
		
	}

	/**
	 * Send Mail Function 
	 * @param fs_to_email, fs_subject, fs_body_text, fs_to_name
	 */
	function fspi_send_mail($fs_to_email,$fs_subject,$fs_body_text,$fs_to_name = ''){
		$fs_header_text = !empty(get_option('_fspi_email_heading_text'))?get_option('_fspi_email_heading_text'):'Product Inquiry';
		$fs_footer_text = !empty(get_option('_fspi_email_footer_text'))?get_option('_fspi_email_footer_text'):'FSPI';
		$fs_from_name = !empty(get_option('_fspi_email_from'))?get_option('_fspi_email_from'):'FSPI';
		$fs_from_email = !empty(get_option('_fspi_email_from_address'))?get_option('_fspi_email_from_address'):'fspi@gmail.com';
		$fs_headers = array(
			'Content-Type: text/html; charset=UTF-8'
		);
		/* $fs_body = 'Hello '.$fs_to_name.',<br>
					<h2>'.$fs_header_text.'</h2>
					<p>'.$fs_body_text.'</p>
					<p>
						Regards,<br>
						'.$fs_footer_text.'
					</p>'; */
		$fs_body = '<table style="width:500px;border:1px solid #ccc;border-collapse:collapse;">
						<tr>
							<th style="background-color:#e0e0e0;padding:30px;border:1px solid #ccc;"><h2>'.$fs_header_text.'</h2></th>
						</tr>
						<tr>
							<td style="padding:30px;border:1px solid #ccc;">
								<p><b>Hello '.$fs_to_name.'<b>,</p>
								<p>'.$fs_body_text.'</p>
							</td>
						</tr>
						<tr>
							<td style="padding:30px;border:1px solid #ccc;">
								<p>
									Regards,<br>
									'.$fs_footer_text.'
								</p>
							</td>
						</tr>
					</table>';		
		wp_mail($fs_to_email, $fs_subject, $fs_body, $fs_headers );
	}

	function fspi_report_mail($fs_email,$fs_name){
		/*
		* Send customer mail
		*/
		$fs_subject = !empty(get_option('_fspi_customer_email_sub'))?get_option('_fspi_customer_email_sub'):'Product Inquiry Status';

		$fs_body = !empty(get_option('_fspi_customer_email_body_text'))?get_option('_fspi_customer_email_body_text'):'Your Product Inquiry Submitted successfully.';

		$this->fspi_send_mail($fs_email,$fs_subject,$fs_body, $fs_name);

		/*
		* Send Admin mail
		*/
		$fs_admin_email = !empty(get_option('_fspi_email_admin'))?get_option('_fspi_email_admin'):'';

		$fs_admin_subject = !empty(get_option('_fspi_admin_email_sub'))?get_option('_fspi_admin_email_sub'):'New Product Inquiry Submitted';

		$fs_admin_body = !empty(get_option('_fspi_admin_email_body_text'))?get_option('_fspi_admin_email_body_text'):'New Product Inquiry Submitted successfully.';

		$this->fspi_send_mail($fs_admin_email,$fs_admin_subject,$fs_admin_body);
	}

	function fspi_ck($check_val=''){
		$url = get_option('_fspi_server_url');
		if(!empty($url)){
			$license_data = get_option('_fspi_license_settings');
			if(!empty($license_data)){
				if($this->fspi_kya_app_loopul_budhu_hai()){ 
					$server_url = $url.'wp-json/';
					$licence = $license_data['license_key'];
				    $email = $license_data['email'];
					$args = array(
						'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
					    'body'        => json_encode(array('lkey' => $licence,'email' => $email,'check_val'=>$check_val,'plug'=>'fspi')),
					    'method'      => 'POST',
					    'data_format' => 'body'
					);
					$url = $server_url.'license/verify';    
					$response = wp_remote_post($url,$args);
					if (!is_wp_error($response)) {
						$response = $response['body'];
						$result = json_decode($response);
						if($result->code == 200) {
						    $result = TRUE;
						}else{
							$result = FALSE;
						}
					}else{
						$result = FALSE;
					}
				}else{
					$result = TRUE;
				}
			}else{
			    $the_query = new WP_Query(array('post_type' => 'fspi-products'));
				if(!empty($the_query->found_posts)){
					if($the_query->found_posts <= 5){
						$result = TRUE;
					}else{
						$result = FALSE;
					}
				}else{
					$result = TRUE;
				}
			}
		}else{
			$result = FALSE;
		}
		return $result;
	}


	function do_active($license,$email){
		$url = get_option('_fspi_server_url');
		if(!empty($url)){
			$server_url = $url.'wp-json/';
			$server = $_SERVER['SERVER_NAME'];
			$args = array(
				'headers'     => array('Content-Type' => 'application/json; charset=utf-8'),
			    'body'        => json_encode(array('lkey' => trim($license),'email' => trim($email), 'server' => $server)),
			    'method'      => 'POST',
			    'data_format' => 'body'
			);
			
		    $url = $server_url.'license/activate'; 
			$response = wp_remote_post($url,$args);
			
			if (!is_wp_error($response)) {
				$response = $response['body'];
				$result = json_decode($response);

				if($result->code == 200) {
				    $arr = array("email" => $email, "license_key" => $license, "domain" => $_SERVER['SERVER_NAME'], "is_license_verify" => $result->license_verify, "ip_address" => $_SERVER['REMOTE_ADDR']);
				    update_option('_fspi_license_settings',$arr);
				    $result = array($result->message,$result->license_verify);
				}else{
				    $result = array($result->message,FALSE);
				}
			}else{
				$result = array("Something went wrong,Please try again.",FALSE);
			}
		}else{
			$result = array("Something went wrong,Please Deactivate and Activate plugin and try again.",FALSE);
		}
		return $result;
	}


}

new FSPIProductSetting();