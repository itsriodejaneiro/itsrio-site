<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('WP_Foundation_shortcodes_admin') ) {

class WP_Foundation_shortcodes_admin{

	public static $donate_link;
	public static $wordpress_plugin_page;
	public static $demo_link;

	function __construct(){
		add_action('init', array($this, 'init'), 0);	
		add_action('admin_menu', array($this, 'register_menu_page'));

		add_filter( 'plugin_action_links_' . WP_FOUNDATION_SHORTCODES_SLUG, array( $this, 'add_action_link' ), 10, 2 );
		
		self::$donate_link = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!" /></a>';
		self::$wordpress_plugin_page = '<a href="https://wordpress.org/plugins/wp-foundation-shortcodes/">'.__('Wordpress Plugin Page', 'wp-foundation-shortcodes').'</a>';
		self::$demo_link = '<a href="http://foundation.tadam.co.il/">'.__('Full Documantation & Demo','wp-foundation-shortcodes').'</a>';
	}
	
	public static function init(){
		// load styles

		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );

		$wp_foundation_shortcodes_tinymce = new WP_Foundation_TinyMCE_Shortcodes();	
	}

	public static function register_menu_page(){
		$admin_page = add_menu_page( __('WP Foundation Shortcodes', 'wp-foundation-shortcodes'), __('WP Foundation', 'wp-foundation-shortcodes'), 'manage_options', 'wpfoundation_dashboard', array(__CLASS__, 'load_page'), plugins_url('/images/icon-20x20.png', __FILE__), '99.1' );
		/**
                 * Filter: 'wpfoundation_shortcodes_manage_options_capability' - Allow changing the capability users need to view the settings pages
                 *
                 * @api string unsigned The capability
                 */
                $manage_options_cap = apply_filters( 'wpfoundation_shortcodes_manage_options_capability', 'manage_options' );
		
		//call register settings function
		add_action('admin_init', array(__CLASS__, 'register_settings' )); //call register settings function
	}

	public static function load_page() {
		$page = filter_input( INPUT_GET, 'page' );
		switch ( $page ) {
			case 'wpseo_dashboard':
                        default:
                                require_once( WP_FOUNDATION_SHORTCODES_DIR . 'admin/pages/dashboard.php' );
                                break;
                }
	}

	public static function register_settings() {
		register_setting( 'wp-foundation-shortcodes-options', 'enable-google-map' );
		register_setting( 'wp-foundation-shortcodes-options', 'enable-slick-slider' );
		register_setting( 'wp-foundation-shortcodes-options', 'enable-fontawesome' );
 	}

	public static function plugin_row_meta($input, $file){
		if ( WP_FOUNDATION_SHORTCODES_SLUG != $file ) {
                        return $input;
                }
                $links = array(
			self::$wordpress_plugin_page,
			self::$demo_link,
			self::$donate_link,
                );


                $input = array_merge( $input, $links );

                return $input;
	}

	/**
         * Add a link to the settings page to the plugins list
         *
         * @staticvar string $this_plugin holds the directory & filename for the plugin
         *
         * @param array  $links array of links for the plugins, adapted when the current plugin is found.
         * @param string $file  the filename for the current plugin, which the filter loops through.
         *
         * @return array $links
         */
        function add_action_link( $links, $file ) {
                if ( WP_FOUNDATION_SHORTCODES_SLUG === $file ) {
                        $settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=wpfoundation_dashboard' ) ) . '">' . __( 'Settings', 'wp-foundation-shortcodes' ) . '</a>';
                        array_unshift( $links, $settings_link );
                }
                return $links;
        }

}

}
