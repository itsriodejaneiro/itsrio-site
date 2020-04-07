<?php
/**
 * Moove_GDPR_Content File Doc Comment
 *
 * @category Moove_GDPR_Content
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


/**
 * Moove_GDPR_Content Class Doc Comment
 *
 * @category Class
 * @package  Moove_Controller
 * @author   Gaspar Nemes
 */
class Moove_GDPR_Content {

	/**
	 * Construct
	 */
	public function __construct() {

	}

	/**
	 * Privacy Overview Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_privacy_overview_content() {
		$_content = '<p>' . __( 'This website uses cookies so that we can provide you with the best user experience possible. Cookie information is stored in your browser and performs functions such as recognising you when you return to our website and helping our team to understand which sections of the website you find most interesting and useful.', 'gdpr-cookie-compliance' ) . '</p>';
		return $_content;
	}

	/**
	 * JavaScript localize extension
	 */
	public static function moove_gdpr_get_localize_scripts() {
		$loc_data      = array();
		$gdpr_loc_data = apply_filters( 'gdpr_extend_loc_data', $loc_data );
		return $gdpr_loc_data;
	}

	/**
	 * Strict Necessary Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_strict_necessary_content() {
		$_content = '<p>' . __( 'Strictly Necessary Cookie should be enabled at all times so that we can save your preferences for cookie settings.', 'gdpr-cookie-compliance' ) . '</p>';
		return $_content;
	}

	/**
	 * Strict Necessary Warning Message
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_strict_necessary_warning() {
		$_content          = '';
		$options_name      = $this->moove_gdpr_get_option_name();
		$gdpr_options      = get_option( $options_name );
		$wpml_lang_options = $this->moove_gdpr_get_wpml_lang();

		if ( ! isset( $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_warning' . $wpml_lang_options ] ) ) :
			$_content = __( 'If you disable this cookie, we will not be able to save your preferences. This means that every time you visit this website you will need to enable or disable cookies again.', 'gdpr-cookie-compliance' );
		endif;
		return $_content;
	}

	/**
	 * Advanced Cookies Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_advanced_cookies_content() {
		$_content = '<p>' . __( 'This website uses the following additional cookies:</p><p>(List the cookies that you are using on the website here.)', 'gdpr-cookie-compliance' ) . '</p>';
		return $_content;
	}

	/**
	 * Third Party Cookies Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_third_party_content() {
		$_content  = '<p>' . __( 'This website uses Google Analytics to collect anonymous information such as the number of visitors to the site, and the most popular pages.', 'gdpr-cookie-compliance' );
		$_content .= '<p>' . __( 'Keeping this cookie enabled helps us to improve our website.', 'gdpr-cookie-compliance' ) . '</p>';
		return $_content;
	}

	/**
	 * Cookie Policy Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_get_cookie_policy_content() {
		$privacy_policy_page = get_option( 'wp_page_for_privacy_policy' );
		$privacy_policy_link = $privacy_policy_page ? esc_url( get_permalink( $privacy_policy_page ) ) : false;
		$privacy_policy_link = $privacy_policy_link ? $privacy_policy_link : '#';

		$_content = '<p>' . sprintf( __( 'More information about our [privacy_link]Cookie Policy[/privacy_link]', 'gdpr-cookie-compliance' ), $privacy_policy_link ) . '</p>';
		$_content = str_replace( '[privacy_link]', '<a href="' . $privacy_policy_link . '" target="_blank">', $_content );
		$_content = str_replace( '[/privacy_link]', '</a>', $_content );

		return $_content;
	}

	/**
	 * Cookie Policy Tab Content
	 *
	 * @return string Filtered Content
	 */
	public function moove_gdpr_ifb_content() {
		$_content  = '<h2>' . __( 'Sorry,<br /> the content is blocked!', 'gdpr-cookie-compliance' );
		$_content .= '<p>' . __( 'To unlock, please enable the cookies!', 'gdpr-cookie-compliance' );
		$_content .= '<br><br>';
		$_content .= __( '[accept]Accept[/accept] [setting]Adjust your settings[/setting]', 'gdpr-cookie-compliance' );
		return $_content;
	}



	/**
	 * Get option name
	 */
	public function moove_gdpr_get_option_name() {
		return 'moove_gdpr_plugin_settings';
	}

	/**
	 * Get option name
	 */
	public function moove_gdpr_get_key_name() {
		return 'moove_gdpr_plugin_key';
	}

	/**
	 * Get strict secondary notice
	 */
	public function moove_gdpr_get_secondary_notice() {
		$_content          = '';
		$options_name      = $this->moove_gdpr_get_option_name();
		$gdpr_options      = get_option( $options_name );
		$wpml_lang_options = $this->moove_gdpr_get_wpml_lang();
		if ( ! isset( $gdpr_options[ 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang_options ] ) ) :
			$_content = __( 'Please enable Strictly Necessary Cookies first so that we can save your preferences!', 'gdpr-cookie-compliance' );
		endif;
		return $_content;
	}

	/**
	 * Get WMPL language code
	 */
	public function moove_gdpr_get_wpml_lang() {
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$language_code = ICL_LANGUAGE_CODE;
			if ( ICL_LANGUAGE_CODE === 'all' ) :
				if ( function_exists( 'pll_default_language' ) ) :
					$language_code = pll_default_language();
				elseif ( class_exists( 'SitePress' ) ) :
					global $sitepress;
					$language_code = $sitepress->get_default_language();
				endif;
			endif;
			return '_' . $language_code;
		} elseif ( isset( $GLOBALS['q_config']['language'] ) ) {
			return $GLOBALS['q_config']['language'];
		} elseif ( function_exists( 'wpm_get_user_language' ) ) {
			return wpm_get_user_language();
		}
		return '';
	}

	/**
	 * Licence token
	 */
	public function get_license_token() {
		$license_token = function_exists( 'network_site_url' ) ? network_site_url( '/' ) : home_url( '/' );
		return $license_token;
	}

	/**
	 * PHP Cookie Checker, available from version 1.3.0
	 */
	public function gdpr_get_php_cookies() {
		$cookies_accepted = array(
			'strict'     => false,
			'thirdparty' => false,
			'advanced'   => false,
		);
		if ( isset( $_COOKIE['moove_gdpr_popup'] ) ) :
			$cookies         = sanitize_text_field( wp_unslash( $_COOKIE['moove_gdpr_popup'] ) );
			$cookies_decoded = json_decode( wp_unslash( $cookies ), true );
			if ( $cookies_decoded && is_array( $cookies_decoded ) && ! empty( $cookies_decoded ) ) :
				$cookies_accepted = array(
					'strict'     => isset( $cookies_decoded['strict'] ) && intval( $cookies_decoded['strict'] ) === 1 ? true : false,
					'thirdparty' => isset( $cookies_decoded['thirdparty'] ) && intval( $cookies_decoded['thirdparty'] ) === 1 ? true : false,
					'advanced'   => isset( $cookies_decoded['advanced'] ) && intval( $cookies_decoded['advanced'] ) === 1 ? true : false,
				);
		endif;
	else :
		$options_name      = $this->moove_gdpr_get_option_name();
		$gdpr_options      = get_option( $options_name );
		$wpml_lang_options = $this->moove_gdpr_get_wpml_lang();

		$strictly_functionality = isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;
		$thirdparty_default     = isset( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) && intval( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? intval( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) : 0;
		$advanced_default       = isset( $gdpr_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) && intval( $gdpr_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) ? intval( $gdpr_options['moove_gdpr_advanced_cookies_enable_first_visit'] ) : 0;

		if ( 1 === $strictly_functionality ) :
			if ( 1 === $thirdparty_default || 1 === $advanced_default ) :
				$strict_default = 1;
			else :
				$strict_default = 0;
			endif;
		else :
			$strict_default = 1;
		endif;

		$cookies_accepted = array(
			'strict'     => $strict_default,
			'thirdparty' => $thirdparty_default,
			'advanced'   => $advanced_default,
		);

	endif;
	return $cookies_accepted;
	}

	/**
	 * GDPR Licence action button
	 *
	 * @param array  $response Response.
	 * @param string $gdpr_key GDPR Key.
	 */
	public static function gdpr_licence_action_button( $response, $gdpr_key ) {
		$type = isset( $response['type'] ) ? $response['type'] : false;
		if ( 'expired' === $type || 'activated' === $type || 'max_activation_reached' === $type ) :
			?>
			<button type="submit" name="gdpr_activate_license" class="button button-primary button-inverse">
				<?php esc_html_e( 'Activate', 'gdpr-cookie-compliance' ); ?>
			</button>
			<?php
		elseif ( 'invalid' === $type ) :
			?>
			<button type="submit" name="gdpr_activate_license" class="button button-primary button-inverse">
				<?php esc_html_e( 'Activate', 'gdpr-cookie-compliance' ); ?>
			</button>
			<?php
		else :
			?>
			<button type="submit" name="gdpr_activate_license" class="button button-primary button-inverse">
				<?php esc_html_e( 'Activate', 'gdpr-cookie-compliance' ); ?>
			</button>
			<br /><br />
			<hr />
			<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Buy licence', 'gdpr-cookie-compliance' ); ?></h4>
			<p>
				<?php
				$store_link = __( 'You can buy licences from our [store_link]online store[/store_link].', 'gdpr-cookie-compliance' );
				$store_link = str_replace( '[store_link]', '<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="gdpr_admin_link">', $store_link );
				$store_link = str_replace( '[/store_link]', '</a>', $store_link );
				apply_filters( 'gdpr_cc_keephtml', $store_link, true );
				?>
			</p>
			<p>
				<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="button button-primary">Buy Now</a>
			</p>
			<br />
			<hr />
			<?php
		endif;
	}

	/**
	 * Licence input key
	 *
	 * @param array  $response Response.
	 * @param string $gdpr_key GDPR Key.
	 */
	public static function gdpr_licence_input_field( $response, $gdpr_key ) {
		$type = isset( $response['type'] ) ? $response['type'] : false;
		if ( 'expired' === $type ) :
			// LICENSE EXPIRED.
			?>
			<tr>
				<th scope="row" style="padding: 0 0 10px 0;">
					<hr />
					<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Renew your licence', 'gdpr-cookie-compliance' ); ?></h4>
					<p><?php esc_html_e( 'Your licence has expired. You will not receive the latest updates and features unless you renew your licence.', 'gdpr-cookie-compliance' ); ?></p>
					<a href="<?php echo esc_attr( MOOVE_SHOP_URL ); ?>?renew=<?php echo esc_attr( $response['key'] ); ?>" class="button button-primary">Renew Licence</a>
					<br /><br />
					<hr />

					<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Enter new licence key', 'gdpr-cookie-compliance' ); ?></h4>
				</th>
			</tr>
			<tr>
				<td style="padding: 0;">
					<input name="moove_gdpr_license_key" required min="35" type="text" id="moove_gdpr_license_key" value="" class="regular-text">
				</td>
			</tr>
			<?php
		elseif ( 'activated' === $type || 'max_activation_reached' === $type ) :
			// LICENSE ACTIVATED.
			?>
			<tr>
				<th scope="row" style="padding: 0 0 10px 0;">
					<hr />
					<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Buy more licences', 'gdpr-cookie-compliance' ); ?></h4>
					<p>
						<?php
						$store_link = __( 'You can buy more licences from our [store_link]online store[/store_link].', 'gdpr-cookie-compliance' );
						$store_link = str_replace( '[store_link]', '<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="gdpr_admin_link">', $store_link );
						$store_link = str_replace( '[/store_link]', '</a>', $store_link );
						apply_filters( 'gdpr_cc_keephtml', $store_link, true );
						?>
					</p>
					<p>
						<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="button button-primary">
							Buy Now
						</a>
					</p>
					<br />
					<hr />
					<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Enter new licence key', 'gdpr-cookie-compliance' ); ?></h4>
				</th>
			</tr>
			<tr>
				<td style="padding: 0;">
					<input name="moove_gdpr_license_key" required min="35" type="text" id="moove_gdpr_license_key" value="" class="regular-text">
				</td>
			</tr>
			<?php
		elseif ( 'invalid' === $type ) :
			?>
			<tr>
				<th scope="row" style="padding: 0 0 10px 0;">
					<hr />
					<h4 style="margin-bottom: 0;"><?php esc_html_e( 'Buy licence', 'gdpr-cookie-compliance' ); ?></h4>
					<p>
						<?php
						$store_link = __( 'You can buy licences from our [store_link]online store[/store_link].', 'gdpr-cookie-compliance' );
						$store_link = str_replace( '[store_link]', '<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="gdpr_admin_link">', $store_link );
						$store_link = str_replace( '[/store_link]', '</a>', $store_link );
						apply_filters( 'gdpr_cc_keephtml', $store_link, true );
						?>
					</p>
					<p>
						<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="button button-primary">Buy Now</a>
					</p>
					<br />
					<hr />
				</th>
			</tr>
			<tr>
				<th scope="row" style="padding: 0 0 10px 0;">
					<label><?php esc_html_e( 'Enter your licence key:', 'gdpr-cookie-compliance' ); ?></label>
				</th>
			</tr>
			<tr>
				<td style="padding: 0;">
					<input name="moove_gdpr_license_key" required min="35" type="text" id="moove_gdpr_license_key" value="" class="regular-text">
				</td>
			</tr>
			<?php
		else :
			?>
			<tr>
				<th scope="row" style="padding: 0 0 10px 0;">
					<label><?php esc_html_e( 'Enter licence key:', 'gdpr-cookie-compliance' ); ?></label>
				</th>
			</tr>
			<tr>
				<td style="padding: 0;">
					<input name="moove_gdpr_license_key" required min="35" type="text" id="moove_gdpr_license_key" value="" class="regular-text">
				</td>
			</tr>
			<?php
		endif;
	}

	/**
	 * GDPR Alert Box
	 *
	 * @param string $type Type.
	 * @param array  $response Response.
	 * @param string $gdpr_key GDPR Key.
	 */
	public static function gdpr_get_alertbox( $type, $response, $gdpr_key ) {
		if ( 'error' === $type ) :
			$messages = isset( $response['message'] ) && is_array( $response['message'] ) ? implode( '</p><p>', $response['message'] ) : '';
			if ( $response['type'] === 'inactive' ) :
				$gdpr_default_content = new Moove_GDPR_Content();
				$option_key           = $gdpr_default_content->moove_gdpr_get_key_name();
				$gdpr_key             = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
				if ( function_exists( 'update_site_option' ) ) :
					update_site_option(
						$option_key,
						array(
							'key'          => $response['key'],
							'deactivation' => strtotime( 'now' ),
						)
					);
				else :
					update_option(
						$option_key,
						array(
							'key'          => $response['key'],
							'deactivation' => strtotime( 'now' ),
						)
					);
				endif;
				$gdpr_key = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
			endif;
			?>
			<div class="gdpr-admin-alert gdpr-admin-alert-error">
				<div class="gdpr-alert-content">        
					<p>License key: <strong><?php echo esc_attr( isset( $response['key'] ) ? $response['key'] : $gdpr_key['key'] ); ?></strong></p>
					<p><?php apply_filters( 'gdpr_cc_keephtml', $messages, true ); ?></p>
				</div>
				<span class="dashicons dashicons-dismiss"></span>
			</div>
			<!--  .gdpr-admin-alert gdpr-admin-alert-success -->
			<?php
		else :
			$messages = isset( $response['message'] ) && is_array( $response['message'] ) ? implode( '</p><p>', $response['message'] ) : '';
			?>
			<div class="gdpr-admin-alert gdpr-admin-alert-success">    
				<div class="gdpr-alert-content">         
					<p>License key: <strong><?php echo esc_attr( isset( $response['key'] ) ? $response['key'] : $gdpr_key['key'] ); ?></strong></p>
					<p><?php apply_filters( 'gdpr_cc_keephtml', $messages, true ); ?></p>
				</div>
				<span class="dashicons dashicons-yes-alt"></span>
			</div>
			<!--  .gdpr-admin-alert gdpr-admin-alert-success -->
			<?php
		endif;
		do_action( 'gdpr_plugin_updater_notice' );
	}

	/**
	 * GDPR Update Alert
	 *
	 * @return void
	 */
	public static function gdpr_premium_update_alert() {

		$plugins     = get_site_transient( 'update_plugins' );
		$lm          = new Moove_GDPR_License_Manager();
		$plugin_slug = $lm->get_add_on_plugin_slug();

		if ( isset( $plugins->response[ $plugin_slug ] ) && is_plugin_active( $plugin_slug ) ) :
			$version = $plugins->response[ $plugin_slug ]->new_version;

			$current_user = wp_get_current_user();
			$user_id      = isset( $current_user->ID ) ? $current_user->ID : 0;
			$dismiss      = get_option( 'gdpr_hide_update_notice_' . $user_id );

			if ( isset( $plugins->response[ $plugin_slug ]->package ) && ! $plugins->response[ $plugin_slug ]->package ) :
				$gdpr_default_content = new Moove_GDPR_Content();
				$option_key           = $gdpr_default_content->moove_gdpr_get_key_name();
				$gdpr_key             = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
				$license_key          = isset( $gdpr_key['key'] ) ? sanitize_text_field( $gdpr_key['key'] ) : false;
				$renew_link           = MOOVE_SHOP_URL . '?renew=' . $license_key;
				$license_manager      = admin_url( 'admin.php' ) . '?page=moove-gdpr&amp;tab=licence';
				$purchase_link        = 'https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/';
				$notice_text          = '';
				if ( $license_key && isset( $gdpr_key['activation'] ) ) :
					// Expired.
					$notice_text = 'Update is not available until you <a href="' . $renew_link . '" target="_blank">renew your licence</a>. You can also update your licence key in the <a href="' . $license_manager . '">Licence Manager</a>.';
				elseif ( $license_key && isset( $gdpr_key['deactivation'] ) ) :
					// Deactivated.
					$notice_text = 'Update is not available until you <a href="' . $purchase_link . '" target="_blank">purchase a licence</a>. You can also update your licence key in the <a href="' . $license_manager . '">Licence Manager</a>.';
				elseif ( ! $license_key ) :
					// No license key installed.
					$notice_text = 'Update is not available until you <a href="' . $purchase_link . '" target="_blank">purchase a licence</a>. You can also update your licence key in the <a href="' . $license_manager . '">Licence Manager</a>.';
				endif;
				?>
			<div class="gdpr-cookie-alert gdpr-cookie-update-alert" style="display: inline-block;">
				<h4>
					<?php esc_html_e( 'There is a new version of GDPR Cookie Compliance - Premium Add-On.', 'gdpr-cookie-compliance' ); ?></h4>
				<p><?php apply_filters( 'gdpr_cc_keephtml', $notice_text, true ); ?></p>
			</div>
			<!--  .gdpr-cookie-alert -->
				<?php
		endif;
	endif;
	}
}
new Moove_GDPR_Content();
