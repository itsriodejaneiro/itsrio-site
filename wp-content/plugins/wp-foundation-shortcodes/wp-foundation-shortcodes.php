<?php
/*
        Plugin Name: WP Foundation Shortcodes 
        Version: 0.8.5
        Plugin URI: http://foundation_plugin.tadam.co.il
        Description: WP Foundation Shortcodes plugin add <a href="http://foundation.zurb.com/docs/">Foundation framework styles</a> to your theme by wordpress editor shortcode buttons. Requires a theme built with <a href="http://foundation.zurb.com/">Foundation 5</a>.
        Author: Adam Pery
        Author URI: http://foundation.tadam.co.il/about/
        Text Domain: wp-foundation-shortcodes
        Domain Path: languages/
        License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE
*/

/*
 *	This plugin idea based on "Cherry plugin": http://www.cherryframework.com/update/meet-the-cherry-plugin-bare-functionalities-no-strings-attached/
 *	Most of JS files used in "Foundation Plugin" remain without changes.
 *	All PHP code rewritten
*/

if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

/* DEFINES*/
if ( !function_exists( 'get_plugin_data' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$plugin_data = get_plugin_data(plugin_dir_path(__FILE__).'wp-foundation-shortcodes.php');
global $wpdb;

//Foundation plugin constant variables
define('WP_FOUNDATION_SHORTCODES_DIR', plugin_dir_path(__FILE__));
define('WP_FOUNDATION_SHORTCODES_URL', plugin_dir_url(__FILE__));
define('WP_FOUNDATION_SHORTCODES_DOMAIN', $plugin_data['TextDomain']);
define('WP_FOUNDATION_SHORTCODES_DOMAIN_DIR', $plugin_data['DomainPath']);
define('WP_FOUNDATION_SHORTCODES_VERSION', $plugin_data['Version']);
define('WP_FOUNDATION_SHORTCODES_NAME', $plugin_data['Name']);
define('WP_FOUNDATION_SHORTCODES_SLUG', plugin_basename( __FILE__ ));
define('WP_FOUNDATION_SHORTCODES_DB', $wpdb->prefix.WP_FOUNDATION_SHORTCODES_DOMAIN);


// Don't allow the plugin to be loaded directly
if ( ! function_exists( 'add_action' ) ) {
        _e( 'Please enable this plugin from your wp-admin.', 'wp-foundation-shortcodes' );
        exit;
}

/* REQUIRES */
include_once (WP_FOUNDATION_SHORTCODES_DIR.'class.foundation_plugin.php');
include_once (WP_FOUNDATION_SHORTCODES_DIR.'class.foundation_shortcodes.php');
include_once (WP_FOUNDATION_SHORTCODES_DIR.'class.foundation_plugable.php');

/* LOADINGS */
add_action('plugins_loaded', array('WP_Foundation_shortcodes', 'settings'), 0);
/* INIT */
if(is_admin()){
	include_once (WP_FOUNDATION_SHORTCODES_DIR.'class.foundation_plugin_admin.php');
	include_once (WP_FOUNDATION_SHORTCODES_DIR.'class.foundation_TinyMCE_shortcodes.php');
	$wp_foundation_shortcodes_admin = new WP_Foundation_shortcodes_admin();
}
else{
	$wp_foundation_shortcodes = new WP_Foundation_shortcodes();
}


