<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('WP_Foundation_shortcodes') ) {

class WP_Foundation_shortcodes{

	public function  __construct(){
		add_action('init', array($this, 'init'), 0);
	}
	
	public static function settings(){

		load_plugin_textdomain( WP_FOUNDATION_SHORTCODES_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/'.WP_FOUNDATION_SHORTCODES_DOMAIN_DIR);
	}
	
	public static function init(){
		//load js and css files
		if (get_option('enable-fontawesome')):
	                wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(),  '4.6.3', 'all' ) ;
        	        wp_enqueue_style( 'font-awesome' );
		endif;

                // main plugin css
                wp_register_style( 'wp-foundation-shortcodes', WP_FOUNDATION_SHORTCODES_URL.'stylesheets/app.css', array(),  WP_FOUNDATION_SHORTCODES_VERSION, 'all' ) ;
                wp_enqueue_style( 'wp-foundation-shortcodes' );

                // Google map API
                if (get_option('enable-google-map')) :
                        wp_register_script( 'google-map-api', 'https://maps.googleapis.com/maps/api/js', array(), '2015-09', true );
                        wp_enqueue_script( 'google-map-api' );
                endif;

                // Slick slider
                if (get_option('enable-slick-slider')) :
                        wp_register_style( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.css', array(),  '1.5.8', 'all' ) ;
                        wp_enqueue_style( 'slick-slider' );
                        wp_register_style( 'slick-slider-theme', '//cdn.jsdelivr.net/jquery.slick/1.5.8/slick-theme.css', array(),  '1.5.8', 'all' ) ;
                        wp_enqueue_style( 'slick-slider-theme' );

                        wp_register_script( 'slick-slider', '//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js', array('jquery'), '1.5.8', true );
                        wp_enqueue_script( 'slick-slider' );
                endif;

		// main plugin js
		wp_register_script( 'wp-foundation-shortcodes',  WP_FOUNDATION_SHORTCODES_URL.'js/app.js', array('jquery'), WP_FOUNDATION_SHORTCODES_VERSION, true );
		wp_enqueue_script( 'wp-foundation-shortcodes' );

		//shortcodes
		$foundation_plugin_shortcodes = new WP_Foundation_shortcodes_shortcodes();

		// allow shortcodes in widgets
		add_filter('widget_text', 'do_shortcode');
	}
}

}
