<?php
/**
 * Moove_License_Manager File Doc Comment
 *
 * @category Moove_License_Manager
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Moove_License_Manager Class Doc Comment
 *
 * @category Class
 * @package  Moove_License_Manager
 * @author   Gaspar Nemes
 */
class Moove_GDPR_License_Manager {
	/**
	 * Construct function
	 */
	public function __construct() {

	}

	/**
	 * Licence validation
	 *
	 * @param string $license_key Licence key.
	 * @param string $type Type.
	 * @param string $action Action.
	 */
	public function validate_license( $license_key = false, $type, $action ) {
		$content       = new Moove_GDPR_Content();
		$license_token = $content->get_license_token();
		$curl          = curl_init();
		$request_url	 = MOOVE_SHOP_URL . "/wp-json/license-manager/v1/validate_licence/?license_key=$license_key&license_token=$license_token&license_type=$type&license_action=$action";
		
		$response = wp_remote_get( 
			$request_url,
			 array(
        'timeout'     => 40,
        'httpversion' => '1.1',
    	)
		);

		if ( ! isset( $response['body'] ) || ! json_decode( $response['body'], true ) ) {
			$error = $response;
			return array(
				'valid'   => false,
				'message' => array(
					'Our Activation Server appears to be temporarily unavailable, please try again later or <a href="mailto:plugins@mooveagency.com" class="error_admin_link">contact support</a>.',
				),
			);
		} else {
			return json_decode( $response['body'], true );
		}
	}

	/**
	 * Plugin add-on slug
	 */
	public function get_add_on_plugin_slug() {
		$slug = false;
		if ( function_exists( 'moove_gdpr_addon_get_plugin_dir' ) ) :
			$slug = str_replace( WP_PLUGIN_URL . '/', '', moove_gdpr_addon_get_plugin_dir() ) . '/moove-gdpr-addon.php';
		else :
			if ( ! function_exists( 'get_plugins' ) ) :
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			endif;
			$all_plugins = get_plugins();
			if ( is_array( $all_plugins ) ) :
				foreach ( $all_plugins as $plugin_slug => $plugin_details ) :
					if ( isset( $plugin_details['TextDomain'] ) && 'gdpr-cookie-compliance-addon' === $plugin_details['TextDomain'] && is_plugin_active( $plugin_slug ) ) :
						$slug = $plugin_slug;
					endif;
				endforeach;
			endif;
			$slug = $slug ? $slug : 'gdpr-cookie-compliance-addon/moove-gdpr-addon.php';
		endif;
		return $slug;
	}

	/**
	 * Add-on download actions
	 *
	 * @param string $license_key Licence key.
	 * @param string $action Action.
	 */
	public function get_premium_add_on( $license_key = false, $action = 'check' ) {
		$validate_license = $this->validate_license( $license_key, 'gdpr', $action );
		if ( $validate_license && isset( $validate_license['valid'] ) && true === $validate_license['valid'] ) :
			$plugin_token     = isset( $validate_license['data'] ) && isset( $validate_license['data']['download_token'] ) && $validate_license['data']['download_token'] ? $validate_license['data']['download_token'] : false;
			$is_valid_license = true;
			if ( $plugin_token && 'activate' === $action ) :
				$plugin_slug = $this->get_add_on_plugin_slug();
				add_filter( 'upgrader_source_selection', array( &$this, 'upgrader_source_selection' ), 10, 4 );
				if ( $plugin_slug ) :
					if ( $this->is_plugin_installed( $plugin_slug ) ) {
						$this->upgrade_plugin( $plugin_slug );
						$installed = true;
					} else {
						$installed = $this->install_plugin( $plugin_token );
					}
					if ( ! is_wp_error( $installed ) && $installed ) {
						$activate = activate_plugin( $plugin_slug );
					}
				endif;
				remove_filter( 'upgrader_source_selection', array( &$this, 'upgrader_source_selection' ), 10, 4 );
			endif;
		endif;
		return $validate_license;
	}

	/**
	 * Rename the plugin folder
	 *
	 * @param string $source Source.
	 * @param string $remote_source Remote Source.
	 * @param object $upgrader Upgrader.
	 * @param string $hook_extra Extra hooks.
	 */
	public function upgrader_source_selection( $source, $remote_source, $upgrader, $hook_extra = null ) {
		global $wp_filesystem;
		$plugin      = isset( $hook_extra['plugin'] ) ? $hook_extra['plugin'] : false;
		$plugin_slug = $this->get_add_on_plugin_slug();
		$temp_slug   = basename( trailingslashit( $source ) );
		$plugin_slug = explode( '/', $plugin_slug );
		$plugin_slug = isset( $plugin_slug[0] ) && $plugin_slug[0] ? $plugin_slug[0] : 'gdpr-cookie-compliance-addon';
		if ( $temp_slug !== $plugin_slug ) :
			$new_source = trailingslashit( $remote_source );
			$new_source = str_replace( $temp_slug, $plugin_slug, $new_source );
			$wp_filesystem->move( $source, $new_source );
			return trailingslashit( $new_source );
		endif;
		return $source;
	}

	/**
	 * Plugin deactivate
	 *
	 * @param string $license_key Licence key.
	 */
	public function premium_deactivate( $license_key = false ) {
		$validate_license = $this->validate_license( $license_key, 'gdpr', 'deactivate' );
		if ( $validate_license && isset( $validate_license['valid'] ) && true === $validate_license['valid'] ) :
			$plugin_slug = $this->get_add_on_plugin_slug();
			if ( $plugin_slug ) :
				if ( $this->is_plugin_installed( $plugin_slug ) ) :
					deactivate_plugins( plugin_basename( $plugin_slug ) );
					$deactivated = true;
				endif;
			endif;
		endif;
		return $validate_license;
	}

	/**
	 * Plugin installed
	 *
	 * @param string $slug Slug.
	 */
	public function is_plugin_installed( $slug = false ) {
		if ( function_exists( 'moove_gdpr_addon_get_plugin_dir' ) ) :
			return true;
		endif;
		if ( $slug ) :
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins();
			if ( ! empty( $all_plugins[ $slug ] ) ) :
				return true;
			else :
				return false;
			endif;
		endif;
		return false;
	}

	/**
	 * Plugin install
	 *
	 * @param string $plugin_token Plugin token.
	 */
	public function install_plugin( $plugin_token ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();
		$upgrader  = new Plugin_Upgrader();
		$installed = $upgrader->install( $plugin_token );
		return $installed;
	}

	/**
	 * Upgrade plugin
	 *
	 * @param string $plugin_slug Plugin slug.
	 */
	public function upgrade_plugin( $plugin_slug ) {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		wp_cache_flush();
		$upgrader = new Plugin_Upgrader();
		$upgraded = $upgrader->upgrade( $plugin_slug );
		return $upgraded;
	}


}
new Moove_GDPR_License_Manager();
