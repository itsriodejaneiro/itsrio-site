<?php
/**
 * Moove_GDPR_Actions File Doc Comment
 *
 * @category  Moove_GDPR_Actions
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif; // Exit if accessed directly.

/**
 * Moove_GDPR_Actions Class Doc Comment
 *
 * @category Class
 * @package  Moove_GDPR_Actions
 * @author   Gaspar Nemes
 */
class Moove_GDPR_Actions {

	/**
	 * Global variable used in localization
	 *
	 * @var $gdpr_loc_data Localization variable
	 */
	public $gdpr_loc_data;
	/**
	 * Construct
	 */
	public function __construct() {
		$this->moove_register_scripts();
		$this->moove_register_ajax_actions();
		add_action( 'gdpr_cookie_filter_settings', array( &$this, 'gdpr_remove_cached_scripts' ) );
		add_action( 'gdpr_settings_tab_nav_extensions', array( &$this, 'gdpr_settings_tab_nav_extensions' ), 10, 1 );
		add_action( 'gdpr_check_extensions', array( &$this, 'gdpr_check_extensions' ), 10, 2 );
		add_action( 'gdpr_premium_section_ads', array( &$this, 'gdpr_premium_section_ads' ) );
		add_action( 'gdpr_tab_cbm_ph', array( &$this, 'gdpr_premium_section_ads' ) );
		add_action( 'gdpr_tab_cbm_ps', array( &$this, 'gdpr_premium_section_ads' ) );
		add_action( 'gdpr_get_alertbox', array( 'Moove_GDPR_Content', 'gdpr_get_alertbox' ), 10, 3 );
		add_action( 'gdpr_licence_input_field', array( 'Moove_GDPR_Content', 'gdpr_licence_input_field' ), 10, 2 );
		add_action( 'gdpr_licence_action_button', array( 'Moove_GDPR_Content', 'gdpr_licence_action_button' ), 10, 2 );
		add_action( 'gdpr_premium_update_alert', array( 'Moove_GDPR_Content', 'gdpr_premium_update_alert' ) );
		add_action( 'gdpr_cdn_url', array( &$this, 'gdpr_cdn_base_url' ), 10, 1 );
		add_action( 'gdpr_info_bar_button_extensions', array( &$this, 'gdpr_info_add_reject_button_extensions' ) );
		add_action( 'gdpr_support_sidebar_class', array( &$this, 'gdpr_support_sidebar_class' ), 10, 1 );
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_key           = $gdpr_default_content->moove_gdpr_get_key_name();
		$gdpr_key             = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );

		add_action( 'admin_enqueue_scripts', array( &$this, 'gdpr_thirdparty_admin_scripts' ) );
		
		add_action( 'gdpr_cc_keephtml', array( &$this, 'gdpr_cc_keephtml' ), 10, 2 );

		add_action( 'wp_footer', array( 'Moove_GDPR_Controller', 'moove_gdpr_cookie_popup_modal' ), 99 );
		add_action( 'wp_head', array( 'Moove_GDPR_Controller', 'moove_gdpr_cc_styles' ), 99 );

		add_action( 'admin_init', array( 'Moove_GDPR_Controller', 'moove_gdpr_add_editor_styles' ) );
		add_action( 'wp_footer', array( 'Moove_GDPR_Controller', 'moove_gdpr_cookie_popup_info' ) );
		add_action( 'moove_gdpr_inline_styles', array( &$this, 'gdpr_custom_button_styles' ), 20, 3 );


		// Get Option hook
		add_action( 'option_' . $gdpr_default_content->moove_gdpr_get_option_name(), array( &$this, 'gdpr_get_options' ), 99, 1 );

		// Update Option Hook
		add_action( 'update_option_' . $gdpr_default_content->moove_gdpr_get_option_name(), array( &$this, 'gdpr_update_options' ), 99, 3 );

		// Update Option Hook
		add_action( 'delete_option_' . $gdpr_default_content->moove_gdpr_get_option_name(), array( &$this, 'gdpr_delete_options' ), 99, 1 );


		if ( $gdpr_key && ! isset( $gdpr_key['deactivation'] ) ) :
			do_action( 'gdpr_plugin_loaded' );
		endif;
	}

	/**
	 * Enqueue a script in the WordPress admin, excluding GDPR Settings page.
	 *
	 * @param int $hook Hook suffix for the current admin page.
	 */
	function gdpr_thirdparty_admin_scripts( $hook ) {
    if ( 'toplevel_page_moove-gdpr' !== $hook ) :
       return;
    endif;
    wp_enqueue_script( 'gdpr_colorpicker_script', esc_url( moove_gdpr_get_plugin_directory_url() ) . 'dist/scripts/colorpicker.js', array(), MOOVE_GDPR_VERSION );
    wp_enqueue_script( 'gdpr_codemirror_script', esc_url( moove_gdpr_get_plugin_directory_url() ) . 'dist/scripts/codemirror.js', array(), MOOVE_GDPR_VERSION );
	}

	/**
	 * Using custom database instead default WordPress options
	 * @param array $option_data Option data.
	 */
	public static function gdpr_get_options( $option_data ) {
		$gdpr_controller 	= new Moove_GDPR_Controller();
		$database_options	= gdpr_get_options();
		if ( $database_options && ! empty( $database_options ) ) :
			$option_data = $database_options;
		else :
			if ( is_array( $option_data ) ) :
				foreach ( $option_data as $option_key => $option_value ) :
					gdpr_update_field( $option_key, serialize( $option_value ) );
				endforeach;
			endif;
		endif;
		 			
		return $option_data;
	}

	/**
	 * Using custom database instead default WordPress options
	 * @param mixed $old_value Old Value.
	 * @param mixed $new_value New Value.bx-loading
	 * @param string $option Option.
	 */
	public static function gdpr_update_options( $old_value, $new_value, $option ) {
		if ( is_array( $new_value ) && ! empty( $new_value ) ) :
			foreach ( $new_value as $option_key => $option_value ) :
				gdpr_update_field( $option_key, serialize( $option_value ) );
			endforeach;
		endif;
	}

	/**
	 * Using custom database instead default WordPress options
	 * @param mixed $old_value Old Value.
	 * @param mixed $new_value New Value.bx-loading
	 * @param string $option Option.
	 */
	public static function gdpr_delete_options( $option ) {
		gdpr_delete_option();
		return $option;
	}

	/**
	 * Extra class for admin sidebar widgets
	 *
	 * @param string $class Class name.
	 * @return string $class
	 */
	public function gdpr_support_sidebar_class( $class ) {
		if ( class_exists( 'Moove_GDPR_Addon_View' ) ) :
			$class = 'm-plugin-box-highlighted';
		endif;
		return $class;
	}

	public static function gdpr_custom_button_styles( $styles, $primary, $secondary ) {
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$gdpr_options         = get_option( $option_name );
		$css 						= '';
		if ( isset( $gdpr_options['moove_gdpr_button_style'] ) && $gdpr_options['moove_gdpr_button_style'] !== 'rounded' ) :
			$css 	= apply_filters( 'gdpr_custom_button_styles', 'border-radius: 0;' );
		else :
			$css 	= apply_filters( 'gdpr_custom_button_styles', '' );
		endif;
		if ( $css ) :
			$styles .= '#moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a.mgbutton, #moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button.mgbutton, #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder a.mgbutton, #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder button.mgbutton, .gdpr-shr-button { ' . $css . ' }';
		endif;
	  return $styles;
	}

	/**
	 * Sanitize filter allowing html tags and styles with attributes
	 *
	 * @param string  $content Content.
	 * @param boolean $echo Option echo the value or return.
	 */
	public function gdpr_cc_keephtml( $content, $echo = false ) {
		if ( $echo ) :
			echo $content;
		else :
			return $content;
		endif;
	}

	/**
	 * Reject button extension, will be listed next to the Accept button if it's enabled in the CMS
	 */
	public function gdpr_info_add_reject_button_extensions() {
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$modal_options        = get_option( $option_name );
		$wpml_lang            = $gdpr_default_content->moove_gdpr_get_wpml_lang();
		if ( isset( $modal_options['moove_gdpr_reject_button_enable'] ) && intval( $modal_options['moove_gdpr_reject_button_enable'] ) === 1 ) :
			$button_label = isset( $modal_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] ) && $modal_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] ? $modal_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] : __( 'Reject', 'gdpr-cookie-compliance' );
			?>
		<button class="mgbutton moove-gdpr-infobar-reject-btn"><?php echo esc_attr( $button_label ); ?></button>
			<?php
	endif;
	}

	/**
	 * CDN base URL for lity lightbox
	 *
	 * @param string $plugin_url Plugin URL.
	 */
	public function gdpr_cdn_base_url( $plugin_url ) {
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$modal_options        = get_option( $option_name );

		if ( isset( $modal_options['moove_gdpr_cdn_url'] ) && $modal_options['moove_gdpr_cdn_url'] ) :
			$cdn_url    = esc_url_raw( $modal_options['moove_gdpr_cdn_url'] );
			$plugin_url = str_replace( trailingslashit( site_url() ), trailingslashit( $cdn_url ), $plugin_url );
		endif;

		return $plugin_url;

	}

	/**
	 * Lock screen of premium tabs, visible in the free version
	 */
	public function gdpr_premium_section_ads() {

		if ( class_exists( 'Moove_GDPR_Addon_View' ) ) :
			wp_verify_nonce( 'gdpr_nonce', 'gdpr_cookie_compliance_nonce' );
			$slug         		= isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : false;
			$licence_manager 	= new Moove_GDPR_License_Manager();
			$add_on_slug 			= $licence_manager->get_add_on_plugin_slug();
			$view_path				= $add_on_slug ? WP_PLUGIN_DIR . '/' . plugin_dir_path( $add_on_slug ) . '/views/moove/admin/settings/' . $slug .'.php' : false;

			$view_content 		= $slug && $view_path ? file_exists( $view_path ) : false;

			if ( ! $view_content && $slug && 'help' !== $slug ) :
				?>
				<div class="gdpr-locked-section">
					<span>
						<i class="dashicons dashicons-lock"></i>
						<h4>This feature is not supported in this version of the Premium Add-on.</h4>
						<p><strong><a href="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>?page=moove-gdpr&amp;tab=licence" class="gdpr_admin_link">Activate your licence</a> to download the latest version of the Premium Add-on.</strong></p>
						<p class="gdpr_license_info">Don’t have a valid licence key yet? <br><a href="<?php echo esc_url( MOOVE_SHOP_URL ); ?>/my-account" target="_blank" class="gdpr_admin_link">Login to your account</a> to generate the key or <a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" class="gdpr_admin_link" target="_blank">buy a new licence here</a>.</p>
						<br />

						<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="plugin-buy-now-btn">Buy Now</a>
					</span>

				</div>
				<!--  .gdpr-locked-section -->
				<?php
			endif;
		else :
			?>
			<div class="gdpr-locked-section">
				<span>
					<i class="dashicons dashicons-lock"></i>
					<h4>This feature is part of the Premium Add-on</h4>
					<?php
					$gdpr_default_content = new Moove_GDPR_Content();
					$option_key           = $gdpr_default_content->moove_gdpr_get_key_name();
					$gdpr_key             = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
					?>
					<?php if ( isset( $gdpr_key['deactivation'] ) || $gdpr_key['activation'] ) : ?>
						<p><strong><a href="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>?page=moove-gdpr&amp;tab=licence" class="gdpr_admin_link">Activate your licence</a> or <a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" class="gdpr_admin_link" target="_blank">buy a new licence here</a></strong></p>
						<?php else : ?>
							<p><strong>Do you have a licence key? <br />Insert your license key to the "<a href="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>?page=moove-gdpr&amp;tab=licence" class="gdpr_admin_link">Licence Manager</a>" and activate it.</strong></p>

						<?php endif; ?>
						<br />

						<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="plugin-buy-now-btn">Buy Now</a>
					</span>

				</div>
				<!--  .gdpr-locked-section -->
				<?php
			endif;
	}

	/**
	 * Checking for Premium Add-on installed and activated
	 *
	 * @param string $content Content.
	 * @param string $slug Slug.
	 */
	public function gdpr_check_extensions( $content, $slug ) {
		$return = $content;
		if ( class_exists( 'Moove_GDPR_Addon_View' ) ) :
			$licence_manager 	= new Moove_GDPR_License_Manager();
			$add_on_slug 			= $licence_manager->get_add_on_plugin_slug();
			$view_path				= $add_on_slug ? WP_PLUGIN_DIR . '/' . plugin_dir_path( $add_on_slug ) . '/views/moove/admin/settings/' . $slug .'.php' : false;
			$view_content 		= $slug && $view_path ? file_exists( $view_path ) : false;
			if ( ! $view_content ) :
				$return = $return;
			else :
				$return = '';
			endif;
		endif;
		return $return;
	}

	/**
	 * Clearing AJAX transient cache
	 */
	public function gdpr_remove_cached_scripts() {
		$transient_key = 'gdpr_cookie_cache';
		delete_transient( $transient_key );
	}

	/**
	 * Register Front-end / Back-end scripts
	 *
	 * @return void
	 */
	public function moove_register_scripts() {
		if ( is_admin() ) :
			add_action( 'admin_enqueue_scripts', array( &$this, 'moove_gdpr_admin_scripts' ) );
		else :
			add_action( 'wp_enqueue_scripts', array( &$this, 'moove_frontend_gdpr_scripts' ), 999 );
		endif;
	}

	/**
	 * Register global variables to head, AJAX, Form validation messages
	 *
	 * @param  string $ascript The registered script handle you are attaching the data for.
	 * @return void
	 */
	public function moove_localize_script( $ascript ) {
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$modal_options        = get_option( $option_name );
		$force_reload         = apply_filters( 'gdpr_force_reload', false );
		$force_reload         = $force_reload ? 'true' : 'false';
		$geo_location_enabled = isset( $modal_options['moove_gdpr_geolocation_eu'] ) && intval( $modal_options['moove_gdpr_geolocation_eu'] ) === 1 ? 'true' : 'false';

		// By using this filter, you can force the plugin to load the lity lightbox using PHP instead of JavaScript.
		$load_lity = apply_filters( 'gdpr_enqueue_lity_nojs', true );
		$load_lity = $load_lity ? 'true' : 'false';

		$cookie_expiration 		= isset( $modal_options['moove_gdpr_consent_expiration'] ) && intval( $modal_options['moove_gdpr_consent_expiration'] ) >= 0 ? intval( $modal_options['moove_gdpr_consent_expiration'] ) : 365;

		$loc_data            = array(
			'ajaxurl'         	=> admin_url( 'admin-ajax.php' ),
			'post_id'         	=> get_the_ID(),
			'plugin_dir'      	=> apply_filters( 'gdpr_cdn_url', plugins_url( basename( dirname( __FILE__ ) ) ) ),
			'is_page'         	=> is_page(),
			'strict_init'     	=> isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1,
			'enabled_default' 	=> array(
				'third_party' => isset( $modal_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) && intval( $modal_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? intval( $modal_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) : 0,
				'advanced'    => isset( $modal_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) && intval( $modal_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) ? intval( $modal_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) : 0,
			),
			'geo_location'    	=> $geo_location_enabled,
			'force_reload'    	=> $force_reload,
			'is_single'       	=> is_single(),
			'current_user'    	=> get_current_user_id(),
			'load_lity'       	=> $load_lity,
			'cookie_expiration' => apply_filters( 'gdpr_cookie_expiration_days', $cookie_expiration ),
		);

		$ajax_script_handler = apply_filters( 'gdpr_cc_prevent_ajax_script_inject', false );

		if ( $ajax_script_handler ) :
			$gdpr_controller = new Moove_GDPR_Controller();
			$loc_data['scripts_defined'] = $gdpr_controller->moove_gdpr_get_static_scripts();
		endif;


		$cookie_attributes 	= apply_filters( 'gdpr_cookie_custom_attributes', false );
		if ( $cookie_attributes ) :
			$loc_data['cookie_attributes'] = $cookie_attributes;
		endif;

		$this->gdpr_loc_data = apply_filters( 'gdpr_extend_loc_data', $loc_data );
		wp_localize_script( $ascript, 'moove_frontend_gdpr_scripts', $this->gdpr_loc_data );

	}

	/**
	 * Registe FRONT-END Javascripts and Styles
	 *
	 * @return void
	 */
	public function moove_frontend_gdpr_scripts() {

		$load_lity = apply_filters( 'gdpr_enqueue_lity_nojs', true );
		if ( ! $load_lity ) :
			wp_enqueue_style( 'moove_gdpr_lity', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/styles/lity.css', '', MOOVE_GDPR_VERSION );
			wp_enqueue_script( 'moove_gdpr_lity', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/scripts/lity.js', array( 'jquery' ), MOOVE_GDPR_VERSION, true );
		endif;

		wp_enqueue_script( 'moove_gdpr_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/scripts/main.js', array( 'jquery' ), MOOVE_GDPR_VERSION, true );

		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$modal_options        = get_option( $option_name );
		$wpml_lang            = $gdpr_default_content->moove_gdpr_get_wpml_lang();
		$css_file             = 'gdpr-main.css';
		if ( isset( $modal_options['moove_gdpr_plugin_font_type'] ) ) :
			if ( '1' === $modal_options['moove_gdpr_plugin_font_type'] ) :
				$css_file = 'gdpr-main.css';
			elseif ( '2' === $modal_options['moove_gdpr_plugin_font_type'] ) :
				$css_file = 'gdpr-main-nf.css';
			else :
				$css_file = isset( $modal_options['moove_gdpr_plugin_font_family'] ) && $modal_options['moove_gdpr_plugin_font_family'] && false === strpos( strtolower( $modal_options['moove_gdpr_plugin_font_family'] ), 'nunito' ) ? 'gdpr-main-nf.css' : 'gdpr-main.css';
			endif;
		endif;
		wp_enqueue_style( 'moove_gdpr_frontend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/styles/' . $css_file, '', MOOVE_GDPR_VERSION );
		$this->moove_localize_script( 'moove_gdpr_frontend' );
	}

	/**
	 * Registe BACK-END Javascripts and Styles
	 *
	 * @return void
	 */
	public static function moove_gdpr_admin_scripts() {
		wp_enqueue_script( 'moove_gdpr_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/scripts/admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-draggable' ), MOOVE_GDPR_VERSION, false );
		wp_enqueue_style( 'moove_gdpr_backend', plugins_url( basename( dirname( __FILE__ ) ) ) . '/dist/styles/admin.css', '', MOOVE_GDPR_VERSION );
	}

	/**
	 * Register AJAX actions for the plugin
	 */
	public function moove_register_ajax_actions() {
		add_action( 'wp_ajax_moove_gdpr_get_scripts', array( 'Moove_GDPR_Controller', 'moove_gdpr_get_scripts' ) );
		add_action( 'wp_ajax_nopriv_moove_gdpr_get_scripts', array( 'Moove_GDPR_Controller', 'moove_gdpr_get_scripts' ) );

		add_action( 'wp_ajax_moove_gdpr_localize_scripts', array( 'Moove_GDPR_Controller', 'moove_gdpr_localize_scripts' ) );
		add_action( 'wp_ajax_nopriv_moove_gdpr_localize_scripts', array( 'Moove_GDPR_Controller', 'moove_gdpr_localize_scripts' ) );

		add_action( 'wp_ajax_moove_gdpr_remove_php_cookies', array( 'Moove_GDPR_Controller', 'moove_gdpr_remove_php_cookies' ) );
		add_action( 'wp_ajax_nopriv_moove_gdpr_remove_php_cookies', array( 'Moove_GDPR_Controller', 'moove_gdpr_remove_php_cookies' ) );

		add_action( 'wp_ajax_moove_hide_language_notice', array( 'Moove_GDPR_Controller', 'moove_hide_language_notice' ) );

		add_action( 'wp_ajax_moove_hide_update_notice', array( 'Moove_GDPR_Updater', 'moove_hide_update_notice' ) );
	}

	/**
	 * GDPR Modal Footer Branding
	 */
	public function moove_gdpr_footer_branding_content() {
		$gdpr_default_content = new Moove_GDPR_Content();
		$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
		$modal_options        = get_option( $option_name );
		$wpml_lang            = $gdpr_default_content->moove_gdpr_get_wpml_lang();
		$powered_label        = ( isset( $modal_options[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) && $modal_options[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) ? $modal_options[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] : 'Powered by';
		ob_start();
		?>

		<a href="https://wordpress.org/plugins/gdpr-cookie-compliance" target="_blank" rel="noopener" class='moove-gdpr-branding'><?php echo esc_attr( $powered_label ); ?>&nbsp;<span> <?php esc_attr_e( 'GDPR Cookie Compliance', 'gdpr-cookie-compliance' ); ?></span></a>
		<?php
		return ob_get_clean();
	}

	/**
	 * GDPR Cookie Compliance - Admin Tabs - Routing & views
	 *
	 * @param string $active_tab Active tab.
	 */
	public function gdpr_settings_tab_nav_extensions( $active_tab ) {
		$tab_data = array(
			array(
				'name' => __( 'Export/Import Settings', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'export-import',
			),
			array(
				'name' => __( 'Multisite Settings', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'multisite-settings',
			),
			array(
				'name' => __( 'Accept on Scroll / Hide timer', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'accept-on-scroll',
			),
			array(
				'name' => __( 'Full-screen / Cookiewall', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'full-screen-mode',
			),
			array(
				'name' => __( 'Analytics', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'stats',
			),
			array(
				'name' => __( 'Geo Location', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'geo-location',
			),
			array(
				'name' => __( 'Hide Cookie Banner', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'cookie-banner-manager',
			),
			array(
				'name' => __( 'Iframe Blocker', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'iframe-blocker',
			),
			array(
				'name' => __( 'Cookie Declaration', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'cookie-declaration',
			),
			array(
				'name' => __( 'Consent Log', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'consent-log',
			),
			array(
				'name' => __( 'Renew Consent', 'gdpr-cookie-compliance-addon' ),
				'slug' => 'renew-consent',
			),
		);
		foreach ( $tab_data as $tab ) :
			ob_start();
			?>
			<a href="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>?page=moove-gdpr&amp;tab=<?php echo esc_attr( $tab['slug'] ); ?>" class="gdpr-cc-addon nav-tab gdpr-cc-disabled <?php echo $active_tab === $tab['slug'] ? 'nav-tab-active' : ''; ?>">
				<?php echo esc_attr( $tab['name'] ); ?>
			</a>
			<?php
			$content = ob_get_clean();
			$content = apply_filters( 'gdpr_check_extensions', $content, $tab['slug'] );
			apply_filters( 'gdpr_cc_keephtml', $content, true );
		endforeach;
	}

}
new Moove_GDPR_Actions();

