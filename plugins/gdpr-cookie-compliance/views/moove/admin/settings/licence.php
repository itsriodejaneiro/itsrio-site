<?php
/**
 * Licence Manager Comment
 *
 * @category  Views
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<h2><?php esc_html_e( 'Licence Manager', 'gdpr-cookie-compliance' ); ?></h2>
<hr />
<?php
$gdpr_default_content = new Moove_GDPR_Content();
$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
$gdpr_options         = get_option( $option_name );
$gdpr_options         = is_array( $gdpr_options ) ? $gdpr_options : array();
$option_key           = $gdpr_default_content->moove_gdpr_get_key_name();
$gdpr_key             = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
?>
<form action="<?php echo esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=licence' ) ); ?>" method="post" id="moove_gdpr_license_settings" data-key="<?php echo $gdpr_key && isset( $gdpr_key['key'] ) && isset( $gdpr_key['activation'] ) ? esc_attr( $gdpr_key['key'] ) : ''; ?>">
	<table class="form-table">
		<tbody>
			<tr>
				<td colspan="2" class="gdpr_license_log_alert" style="padding: 0;">
					<?php
					$is_valid_license = false;
					wp_verify_nonce( 'gdpr_nonce', 'gdpr_cookie_compliance_nonce' );
					if ( isset( $_POST['moove_gdpr_license_key'] ) && isset( $_POST['gdpr_activate_license'] ) ) :
						$license_key = sanitize_text_field( wp_unslash( $_POST['moove_gdpr_license_key'] ) );
						if ( $license_key ) :
							$license_manager  = new Moove_GDPR_License_Manager();
							$is_valid_license = $license_manager->get_premium_add_on( $license_key, 'activate' );
							if ( $is_valid_license && isset( $is_valid_license['valid'] ) && true === $is_valid_license['valid'] ) :
								if ( function_exists( 'update_site_option' ) ) :
									update_site_option(
										$option_key,
										array(
											'key'        => $is_valid_license['key'],
											'activation' => $is_valid_license['data']['today'],
										)
									);
								else :
									update_option(
										$option_key,
										array(
											'key'        => $is_valid_license['key'],
											'activation' => $is_valid_license['data']['today'],
										)
									);
								endif;
								// VALID.
								$gdpr_key = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
								$messages = isset( $is_valid_license['message'] ) && is_array( $is_valid_license['message'] ) ? implode( '<br>', $is_valid_license['message'] ) : '';
								do_action( 'gdpr_get_alertbox', 'success', $is_valid_license, $license_key );
							else :
								// INVALID.
								do_action( 'gdpr_get_alertbox', 'error', $is_valid_license, $license_key );
							endif;
						endif;
					elseif ( isset( $_POST['moove_gdpr_license_key'] ) && isset( $_POST['gdpr_deactivate_license'] ) ) :
						$license_key = sanitize_text_field( wp_unslash( $_POST['moove_gdpr_license_key'] ) );
						if ( $license_key ) :
							$license_manager  = new Moove_GDPR_License_Manager();
							$is_valid_license = $license_manager->premium_deactivate( $license_key );
							if ( function_exists( 'update_site_option' ) ) :
								update_site_option(
									$option_key,
									array(
										'key'          => $license_key,
										'deactivation' => strtotime( 'now' ),
									)
								);
							else :
								update_option(
									$option_key,
									array(
										'key'          => $license_key,
										'deactivation' => strtotime( 'now' ),
									)
								);
							endif;
							$gdpr_key = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );

							if ( $is_valid_license && isset( $is_valid_license['valid'] ) && true === $is_valid_license['valid'] ) :
								// VALID.
								do_action( 'gdpr_get_alertbox', 'success', $is_valid_license, $license_key );
							else :
								// INVALID.
								do_action( 'gdpr_get_alertbox', 'error', $is_valid_license, $license_key );
							endif;
						endif;
					elseif ( $gdpr_key && isset( $gdpr_key['key'] ) && isset( $gdpr_key['activation'] ) ) :
						$license_manager  = new Moove_GDPR_License_Manager();
						$is_valid_license = $license_manager->get_premium_add_on( $gdpr_key['key'], 'check' );
						$gdpr_key         = function_exists( 'get_site_option' ) ? get_site_option( $option_key ) : get_option( $option_key );
						if ( $is_valid_license && isset( $is_valid_license['valid'] ) && true === $is_valid_license['valid'] ) :
							// VALID.
							do_action( 'gdpr_get_alertbox', 'success', $is_valid_license, $gdpr_key );
						else :
							// INVALID.
							do_action( 'gdpr_get_alertbox', 'error', $is_valid_license, $gdpr_key );
						endif;
					endif;
					?>
				</td>
			</tr>
			<?php do_action( 'gdpr_licence_input_field', $is_valid_license, $gdpr_key ); ?>
		</tbody>
	</table>
	<br />
	<?php do_action( 'gdpr_licence_action_button', $is_valid_license, $gdpr_key ); ?>
	<br />
	<?php do_action( 'gdpr_cc_general_buttons_settings' ); ?>
</form>
<div class="gdpr-admin-popup gdpr-admin-popup-deactivate" style="display: none;">
	<span class="gdpr-popup-overlay"></span>
	<div class="gdpr-popup-content">
		<div class="gdpr-popup-content-header">
			<a href="#" class="gdpr-popup-close"><span class="dashicons dashicons-no-alt"></span></a>
		</div>
		<!--  .gdpr-popup-content-header -->
		<div class="gdpr-popup-content-content">
			<h4><strong><?php esc_html_e( 'Please confirm that you would like to de-activate this licence.', 'gdpr-cookie-compliance' ); ?> </strong></h4><p><strong><?php esc_html_e( 'This action will remove all of the premium features from your website.', 'gdpr-cookie-compliance' ); ?></strong></p>
			<button class="button button-primary button-deactivate-confirm">
				<?php esc_html_e( 'Deactivate Licence', 'gdpr-cookie-compliance' ); ?>
			</button>
		</div>
		<!--  .gdpr-popup-content-content -->    
	</div>
	<!--  .gdpr-popup-content -->
</div>
<!--  .gdpr-admin-popup -->
