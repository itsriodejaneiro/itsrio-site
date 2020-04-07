<?php
/**
 * GDPR_View File Doc Comment
 *
 * @category GDPR_View
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * GDPR_View Class Doc Comment
 *
 * @category Class
 * @package  GDPR_View
 * @author   Gaspar Nemes
 */
class GDPR_View {
	/**
	 * Load and update view
	 *
	 * Parameters:
	 *
	 * @param string $view // the view to load, dot used as directory separator, no file extension given.
	 * @param mixed  $content // The data to display in the view (could be anything, even an object).
	 */
	public static function load( $view, $content ) {
		$view_file_origin = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'views';
		$view_name        = str_replace( '.', DIRECTORY_SEPARATOR, $view ) . '.php';
		if ( file_exists( $view_file_origin . DIRECTORY_SEPARATOR . $view_name ) ) :
			ob_start();
			include $view_file_origin . DIRECTORY_SEPARATOR . $view_name;
			return ob_get_clean();
		endif;
	}
}
