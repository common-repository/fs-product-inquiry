<?php 

defined('ABSPATH') || exit;

/**
 * Main FS Product Inquiry Class.
 *
 * @class FSProductInquiry
 */ 
 
final class FSProductInquiry{
	/**
	 * The single instance of the class.
	 *
	 * @var FSProductInquiry
	 */
	protected static $_instance = null;

	/**
	 * Main FSProductInquiry Instance.
	 *
	 * Ensures only one instance of FSProductInquiry is loaded or can be loaded.
	 * @see FSPI()
	 * @return FSProductInquiry - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * FSProductInquiry Constructor.
	 */
	public function __construct() {
		$this->includes();
	}

	/**
	 * Includes all essential files.
	 */
	public function includes(){
		include FSPI_BASE_DIR . 'includes/class-fs-alert.php';
		include FSPI_BASE_DIR . 'includes/class-fs-action.php';
		include FSPI_BASE_DIR . 'includes/class-fs-product-setting.php';
		include FSPI_BASE_DIR . 'includes/class-fs-val-loopul.php';
		include FSPI_BASE_DIR . 'includes/class-fs-main-menu.php';
		include FSPI_BASE_DIR . 'includes/class-fs-setting-page.php';
		include FSPI_BASE_DIR . 'includes/class-fs-products.php';
	}

	
}