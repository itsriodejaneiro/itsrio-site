<?php
/**
 * Moove_Controller File Doc Comment
 *
 * @category Moove_Controller
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Moove_Controller Class Doc Comment
 *
 * @category Class
 * @package  Moove_Controller
 * @author   Gaspar Nemes
 */
class Moove_GDPR_Controller {
	/**
	 * Construct function
	 */
	public function __construct() {
		
	}

	/**
	 * Custom Editor CSS added to GDPR plugin WYSIWYG editors
	 *
	 * @return void
	 */
	public static function moove_gdpr_add_editor_styles() {
		add_editor_style( moove_gdpr_get_plugin_directory_url() . 'dist/styles/custom-editor-style.css' );
	}

	/**
	 * Checking if database exists
	 *
	 * @return bool
	 */
	public static function moove_gdpr_check_database() {
		$has_database = get_option( 'gdpr_cc_has_database' ) ? true : false;
		return $has_database;
	}

	/**
	 * JavaScript localization script
	 */
	public static function moove_gdpr_localize_scripts() {
		$content_cnt = new Moove_GDPR_Content();
		echo json_encode( $content_cnt->moove_gdpr_get_localize_scripts() );
		die();
	}

	/**
	 * Reading plugin statistics from WordPress.org
	 * - star rating
	 * - downloads & active installations
	 *
	 * @param string $plugin_slug Plugin slug.
	 */
	public function get_gdpr_plugin_details( $plugin_slug = '' ) {
		$plugin_return   = false;
		$wp_repo_plugins = '';
		$wp_response     = '';
		$wp_version      = get_bloginfo( 'version' );
		$transient       = get_transient( 'plugin_info_' . $plugin_slug );
		if ( $transient ) :
			$plugin_return = $transient;
		else :
			if ( $plugin_slug && $wp_version > 3.8 ) :
				$args        = array(
					'author' => 'MooveAgency',
					'fields' => array(
						'downloaded'      => true,
						'active_installs' => true,
						'ratings'         => true,
					),
				);
				$wp_response = wp_remote_post(
					'http://api.wordpress.org/plugins/info/1.0/',
					array(
						'body' => array(
							'action'  => 'query_plugins',
							'request' => serialize( (object) $args ),
						),
					)
				);
				if ( ! is_wp_error( $wp_response ) ) :
					$wp_repo_response = unserialize( wp_remote_retrieve_body( $wp_response ) );
					$wp_repo_plugins  = $wp_repo_response->plugins;
				endif;
				if ( $wp_repo_plugins ) :
					foreach ( $wp_repo_plugins as $plugin_details ) :
						if ( $plugin_slug === $plugin_details->slug ) :
							$plugin_return = $plugin_details;
							set_transient( 'plugin_info_' . $plugin_slug, $plugin_return, 12 * HOUR_IN_SECONDS );
						endif;
					endforeach;
				endif;
			endif;

		endif;
		return $plugin_return;
	}

	/**
	 * CSS minification for inlined CSS styles
	 *
	 * @param  string $input Inlined styles.
	 * @return string        Minified styles.
	 */
	public function moove_gdpr_minify_css( $input ) {
		if ( trim( $input ) === '' ) {
			return $input;
		}
		return preg_replace(
			array(
				// Remove comment(s).
				'#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
				// Remove unused white-space(s).
				'#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
				// Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`.
				'#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
				// Replace `:0 0 0 0` with `:0`.
				'#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
				// Replace `background-position:0` with `background-position:0 0`.
				'#(background-position):0(?=[;\}])#si',
				// Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space.
				'#(?<=[\s:,\-])0+\.(\d+)#s',
				// Minify string value.
				'#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
				'#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
				// Minify HEX color code.
				'#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
				// Replace `(border|outline):none` with `(border|outline):0`.
				'#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
				// Remove empty selector(s).
				'#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s',
			),
			array(
				'$1',
				'$1$2$3$4$5$6$7',
				'$1',
				':0',
				'$1:0 0',
				'.$1',
				'$1$3',
				'$1$2$4$5',
				'$1$2$3',
				'$1:0',
				'$1$2',
			),
			$input
		);
	}

	/**
	 * Inline styles based on the colours selected in the options page
	 *
	 * @param string $primary_colour Primary Color.
	 * @param string $secondary_colour Secondary Color.
	 * @param string $button_bg Button Background Color.
	 * @param string $button_hover_bg Button Hover Background Color.
	 * @param string $button_font Button Font Color.
	 * @param string $font_family Font Family.
	 */
	public function get_minified_styles( $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font, $font_family ) {
		ob_start();
		?>
		#moove_gdpr_cookie_modal,
		#moove_gdpr_cookie_info_bar,
		.gdpr_cookie_settings_shortcode_content {
			font-family: <?php echo $font_family; ?>;
		}
		#moove_gdpr_save_popup_settings_button {
			background-color: <?php echo esc_attr( $button_bg ); ?>;
			color: <?php echo esc_attr( $button_font ); ?>;
		}
		#moove_gdpr_save_popup_settings_button:hover {
			background-color: <?php echo esc_attr( $button_hover_bg ); ?>;
		}

		#moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a.mgbutton,
		#moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button.mgbutton {
			background-color: <?php echo esc_attr( $primary_colour ); ?>;
		}
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder a.mgbutton,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder button.mgbutton,
		.gdpr_cookie_settings_shortcode_content .gdpr-shr-button.button-green {
			background-color: <?php echo esc_attr( $primary_colour ); ?>;
			border-color: <?php echo esc_attr( $primary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder a.mgbutton:hover,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder button.mgbutton:hover,
		.gdpr_cookie_settings_shortcode_content .gdpr-shr-button.button-green:hover {
			background-color: #fff;
			color: <?php echo esc_attr( $primary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close i, 
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close span.gdpr-icon {
		background-color: <?php echo esc_attr( $primary_colour ); ?>;
		border: 1px solid <?php echo esc_attr( $primary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close i:hover, 
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close span.gdpr-icon:hover {
			color: <?php echo esc_attr( $primary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected a span.gdpr-icon, 
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected button span.gdpr-icon {
			color: inherit;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li:hover a, 
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li:hover button {
		color: <?php echo esc_attr( $secondary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li a span.gdpr-icon, 
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li button span.gdpr-icon {
			color: inherit;
		}

		#moove_gdpr_cookie_modal .gdpr-acc-link {
			line-height: 0;
			font-size: 0;
			color: transparent;
			position: absolute;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close:hover i,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li a,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li button,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li button i,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li a i,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-tab-main .moove-gdpr-tab-main-content a:hover,
		#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a.mgbutton:hover,
		#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button.mgbutton:hover,
		#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a:hover,
		#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button:hover,
		#moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content span.change-settings-button:hover {
		color: <?php echo esc_attr( $primary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected a,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected button {
			color: <?php echo esc_attr( $secondary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected a i,
		#moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected button i {
			color: <?php echo esc_attr( $secondary_colour ); ?>;
		}

		#moove_gdpr_cookie_modal.lity-hide {
			display: none;
		}

		<?php
		$input           = apply_filters( 'moove_gdpr_inline_styles', ob_get_clean(), $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font );
		$gdpr_controller = new Moove_GDPR_Controller();
		return $gdpr_controller->moove_gdpr_minify_css( $input );
	}

	/**
	 * GDPR Styles added to head
	 *
	 * @return void
	 */
	public static function moove_gdpr_cc_styles() {
		// CUSTOM CSS STYLED.
		$content = gdpr_get_module( 'branding-styles' );
		apply_filters( 'gdpr_cc_keephtml', $content, true );
	}

	/**
	 * GDPR Modal Main content
	 *
	 * @return void
	 */
	public static function moove_gdpr_cookie_popup_modal() {

		// FLOATING BUTTON.
		$content = gdpr_get_module( 'floating-button' );
		apply_filters( 'gdpr_cc_keephtml', $content, true );

		// MODAL CONTENT.
		$content = gdpr_get_module( 'modal-base' );
		apply_filters( 'gdpr_cc_keephtml', $content, true );
	}

	/**
	 * GDPR Cookie info bar with settings icon
	 *
	 * @return void
	 */
	public static function moove_gdpr_cookie_popup_info() {
		$content = gdpr_get_module( 'infobar-base' );
		apply_filters( 'gdpr_cc_keephtml', $content, true );
	}

	public static function moove_gdpr_get_static_scripts() {
		$strict     = true;
		$thirdparty = true;
		$advanced   = true;

		$transient_key = 'gdpr_cookie_cache';
		$transient     = apply_filters( 'gdpr_cookie_script_cache', get_transient( $transient_key ) );
		$transient 		 = false;
		if ( ! empty( $transient ) ) :
			$transient_from_cache = json_decode( $transient, true );
		else :
			$gdpr_default_content = new Moove_GDPR_Content();
			$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
			$modal_options        = get_option( $option_name );

			$cache_array = array(
				'thirdparty' => array(
					'header' => '',
					'body'   => '',
					'footer' => '',
				),
				'advanced'   => array(
					'header' => '',
					'body'   => '',
					'footer' => '',
				),
			);

			// THIRD PARTY - SCRIPT CACHE.
			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_header_scripts'] ) && $modal_options['moove_gdpr_third_party_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_header_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_header_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['header'] .= ob_get_clean();

			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_body_scripts'] ) && $modal_options['moove_gdpr_third_party_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_body_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_body_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['body'] .= ob_get_clean();

			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_footer_scripts'] ) && $modal_options['moove_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_footer_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_footer_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['footer'] .= ob_get_clean();

			// ADVANCED - SCRIPT CACHE.
			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_header_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['header'] .= ob_get_clean();

			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_body_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['body'] .= ob_get_clean();

			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_footer_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['footer'] .= ob_get_clean();

			$cache_json = json_encode( $cache_array, true );

			set_transient( $transient_key, $cache_json, 86400 );
			$transient_from_cache = $cache_array;
		endif;

		$scripts_array = array(
			'cache'  => ! empty( $transient ),
			'header' => '',
			'body'   => '',
			'footer' => '',
		);

		if ( true === $strict ) :
			$transient_from_cache = apply_filters( 'gdpr_lss_extension', $transient_from_cache );
			if ( $thirdparty ) :
				if ( isset( $transient_from_cache['thirdparty'] ) ) :
					$scripts_array['thirdparty']['header'] = $transient_from_cache['thirdparty']['header'];
					$scripts_array['thirdparty']['body']   = $transient_from_cache['thirdparty']['body'];
					$scripts_array['thirdparty']['footer'] = $transient_from_cache['thirdparty']['footer'];
				endif;
			endif;

			if ( $advanced ) :
				if ( isset( $transient_from_cache['advanced'] ) ) :
					$scripts_array['advanced']['header'] = $transient_from_cache['advanced']['header'];
					$scripts_array['advanced']['body']   = $transient_from_cache['advanced']['body'];
					$scripts_array['advanced']['footer'] = $transient_from_cache['advanced']['footer'];
				endif;
			endif;
		endif;
		return json_encode( $scripts_array, true );
	}

	/**
	 * AJAX function to display the allowed scripts from the plugin settings page
	 *
	 * @return void
	 */
	public static function moove_gdpr_get_scripts() {
		wp_verify_nonce( 'gdpr_nonce', 'gdpr_cookie_compliance_nonce' );
		$strict     = isset( $_POST['strict'] ) && intval( $_POST['strict'] ) && 1 === intval( $_POST['strict'] ) ? true : false;
		$thirdparty = isset( $_POST['thirdparty'] ) && intval( $_POST['thirdparty'] ) && 1 === intval( $_POST['thirdparty'] ) ? true : false;
		$advanced   = isset( $_POST['advanced'] ) && intval( $_POST['advanced'] ) && 1 === intval( $_POST['advanced'] ) ? true : false;

		$transient_key = 'gdpr_cookie_cache';
		$transient     = apply_filters( 'gdpr_cookie_script_cache', get_transient( $transient_key ) );

		if ( ! empty( $transient ) ) :
			$transient_from_cache = json_decode( $transient, true );
		else :
			$gdpr_default_content = new Moove_GDPR_Content();
			$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
			$modal_options        = get_option( $option_name );

			$cache_array = array(
				'thirdparty' => array(
					'header' => '',
					'body'   => '',
					'footer' => '',
				),
				'advanced'   => array(
					'header' => '',
					'body'   => '',
					'footer' => '',
				),
			);

			// THIRD PARTY - SCRIPT CACHE.
			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_header_scripts'] ) && $modal_options['moove_gdpr_third_party_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_header_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_header_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['header'] .= ob_get_clean();

			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_body_scripts'] ) && $modal_options['moove_gdpr_third_party_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_body_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_body_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['body'] .= ob_get_clean();

			ob_start();
			$third_party_scripts = isset( $modal_options['moove_gdpr_third_party_footer_scripts'] ) && $modal_options['moove_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_footer_scripts'] ) : '';
			$third_party_scripts = apply_filters( 'moove_gdpr_third_party_footer_assets', $third_party_scripts );
			apply_filters( 'gdpr_cc_keephtml', $third_party_scripts, true );
			$cache_array['thirdparty']['footer'] .= ob_get_clean();

			// ADVANCED - SCRIPT CACHE.
			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_header_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['header'] .= ob_get_clean();

			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_body_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['body'] .= ob_get_clean();

			ob_start();
			$advanced_scripts = isset( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) : '';
			$advanced_scripts = apply_filters( 'moove_gdpr_advanced_cookies_footer_assets', $advanced_scripts );
			apply_filters( 'gdpr_cc_keephtml', $advanced_scripts, true );
			$cache_array['advanced']['footer'] .= ob_get_clean();

			$cache_json = json_encode( $cache_array, true );

			set_transient( $transient_key, $cache_json, 86400 );
			$transient_from_cache = $cache_array;
		endif;

		$scripts_array = array(
			'cache'  => ! empty( $transient ),
			'header' => '',
			'body'   => '',
			'footer' => '',
		);

		if ( true === $strict ) :
			$transient_from_cache = apply_filters( 'gdpr_lss_extension', $transient_from_cache );
			if ( $thirdparty ) :
				if ( isset( $transient_from_cache['thirdparty'] ) ) :
					$scripts_array['header'] .= $transient_from_cache['thirdparty']['header'];
					$scripts_array['body']   .= $transient_from_cache['thirdparty']['body'];
					$scripts_array['footer'] .= $transient_from_cache['thirdparty']['footer'];
				endif;
			endif;

			if ( $advanced ) :
				if ( isset( $transient_from_cache['advanced'] ) ) :
					$scripts_array['header'] .= $transient_from_cache['advanced']['header'];
					$scripts_array['body']   .= $transient_from_cache['advanced']['body'];
					$scripts_array['footer'] .= $transient_from_cache['advanced']['footer'];
				endif;
			endif;
		else :
			if ( isset( $_SERVER['HTTP_COOKIE'] ) ) {
				$cookies = explode( ';', sanitize_text_field( wp_unslash( $_SERVER['HTTP_COOKIE'] ) ) );
				foreach ( $cookies as $cookie ) {
					$parts = explode( '=', $cookie );
					$name  = trim( $parts[0] );
					setcookie( $name, '', time() - 1000 );
					setcookie( $name, '', time() - 1000, '/' );
				}
			}
		endif;
		echo json_encode( $scripts_array );
		die();
	}

	/**
	 * Removing all the cookies including www and non-www domains
	 */
	public static function moove_gdpr_remove_php_cookies() {
		$urlparts = wp_parse_url( site_url( '/' ) );
		$domain   = preg_replace( '/www\./i', '', $urlparts['host'] );
		if ( isset( $_COOKIE ) && is_array( $_COOKIE ) && $domain ) :
			foreach ( $_COOKIE as $key => $value ) {

				if ( 'language' === $key || 'currency' === $key ) {
					setcookie( $key, null, -1, '/', 'www.' . $domain );
				} elseif ( '_ga' === $key || '_gid' === $key || '_gat' === $key ) {
					setcookie( $key, null, -1, '/', '.' . $domain );
				} else {
					foreach ( $_COOKIE as $key => $value ) {
						unset( $_COOKIE[ $key ] );
						if ( 'language' === $key || 'currency' === $key ) {
							setcookie( $key, null, -1, '/', 'www.' . $domain );
						} elseif ( '_ga' === $key || '_gid' === $key || '_gat' === $key ) {
							setcookie( $key, null, -1, '/', '.' . $domain );
						} else {
							setcookie( $key, null, -1, '/' );
						}
					}
				}
			}
		endif;
	}

	/**
	 * Language notice hide
	 */
	public static function moove_hide_language_notice() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_key( wp_unslash( $_POST['nonce'] ) ) : false;
		if ( wp_verify_nonce( $nonce, 'gdpr_hide_language_nonce' ) ) :
			wp_verify_nonce( 'gdpr_nonce', 'gdpr_cookie_compliance_nonce' );
			$user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : false;
			if ( $user_id ) :
				$gdpr_default_content = new Moove_GDPR_Content();
				$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
				$modal_options        = get_option( $option_name );
				$modal_options[ 'gdpr_hide_language_notice_' . $user_id ] = 1;
				update_option( $option_name, $modal_options );
			endif;
		endif;
	}

}
new Moove_GDPR_Controller();
