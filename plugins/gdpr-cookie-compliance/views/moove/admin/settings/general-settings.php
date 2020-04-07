<?php
/**
 * General Settings Doc Comment
 *
 * @category  Views
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$gdpr_default_content = new Moove_GDPR_Content();
$option_name          = $gdpr_default_content->moove_gdpr_get_option_name();
$gdpr_options         = get_option( $option_name );
$wpml_lang            = $gdpr_default_content->moove_gdpr_get_wpml_lang();
$gdpr_options         = is_array( $gdpr_options ) ? $gdpr_options : array();
if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
	$nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
		die( 'Security check' );
	else :
		if ( is_array( $_POST ) ) :

			if ( isset( $_POST['moove_gdpr_modal_powered_by_disable'] ) ) :
				$value = intval( $_POST['moove_gdpr_modal_powered_by_disable'] );
			else :
				$value = 0;
			endif;

			if ( isset( $_POST[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) ) :
				if ( 0 === strlen( trim( sanitize_text_field( wp_unslash( $_POST[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) ) ) ) ) :
					$value = 1;
				else :
					$value = 0;
				endif;
			endif;


			$gdpr_options['moove_gdpr_modal_powered_by_disable'] = $value;
			update_option( $option_name, $gdpr_options );
			$gdpr_options = get_option( $option_name );
			foreach ( $_POST as $form_key => $form_value ) :
				if ( 'moove_gdpr_info_bar_content' === $form_key ) :
					$value                                  = wpautop( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang === $form_key ) :
					$value                     = wpautop( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_floating_button_enable' !== $form_key && 'moove_gdpr_modal_powered_by_disable' !== $form_key ) :
					$value                     = sanitize_text_field( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				endif;
			endforeach;
		endif;
		do_action( 'gdpr_cookie_filter_settings' );
		?>
		<script>
			jQuery('#moove-gdpr-setting-error-settings_updated').show();
		</script>
		<?php
	endif;
endif;

/**
 * Reset Settings
 */
if ( isset( $_POST ) && isset( $_POST['moove_gdpr_reset_nonce'] ) ) :
	$nonce = sanitize_key( $_POST['moove_gdpr_reset_nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_reset_nonce_field' ) ) :
		die( 'Security check' );
	else :
		if ( isset( $_POST['gdpr_reset_settings'] ) && intval( $_POST['gdpr_reset_settings'] )  === 1 ) :
			$gdpr_content 	= new Moove_GDPR_Content();
			$option_name 		= $gdpr_content->moove_gdpr_get_option_name();
			$option_key     = $gdpr_content->moove_gdpr_get_key_name();
			update_option( $option_name, array() );
			gdpr_delete_option();
			if ( function_exists( 'update_site_option' ) ) :
				delete_site_option( $option_key );
			else :
				delete_option( $option_key );
			endif;
			$gdpr_options         = get_option( $option_name );
			$gdpr_options         = is_array( $gdpr_options ) ? $gdpr_options : array();
		endif;
	endif;
endif;
?>
<form action="<?php esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=general-settings' ) ); ?>" method="post" id="moove_gdpr_tab_general_settings">
	<h2><?php esc_html_e( 'Cookie Settings Screen - General Setup', 'gdpr-cookie-compliance' ); ?></h2>
	<hr />
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_plugin_layout"><?php esc_html_e( 'Choose your layout', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_plugin_layout" type="radio" value="v1" id="moove_gdpr_plugin_layout_v1" <?php echo isset( $gdpr_options['moove_gdpr_plugin_layout'] ) ? ( 'v1' === $gdpr_options['moove_gdpr_plugin_layout'] ? 'checked' : '' ) : 'checked'; ?> class="on-off">
					<label for="moove_gdpr_plugin_layout_v1">
						<?php esc_html_e( 'Tabs layout', 'gdpr-cookie-compliance' ); ?>
					</label> 
					<span class="separator"></span>

					<input name="moove_gdpr_plugin_layout" type="radio" value="v2" id="moove_gdpr_plugin_layout_v2" <?php echo isset( $gdpr_options['moove_gdpr_plugin_layout'] ) ? ( 'v2' === $gdpr_options['moove_gdpr_plugin_layout'] ? 'checked' : '' ) : ''; ?> class="on-off">
					<label for="moove_gdpr_plugin_layout_v2">
						<?php esc_html_e( 'One page layout', 'gdpr-cookie-compliance' ); ?>
					</label>
					<?php do_action( 'gdpr_cc_moove_gdpr_plugin_layout_settings' ); ?>

				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_modal_save_button_label"><?php esc_html_e( 'Save Settings - Button Label', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_modal_save_button_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_modal_save_button_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_modal_save_button_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_modal_save_button_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_modal_save_button_label' . $wpml_lang ] ) : esc_html__( 'Save Changes', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_modal_allow_button_label"><?php esc_html_e( 'Enable All - Button Label', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_modal_allow_button_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_modal_allow_button_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_modal_allow_button_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_modal_allow_button_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_modal_allow_button_label' . $wpml_lang ] ) : esc_html__( 'Enable All', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_modal_enabled_checkbox_label">
						<?php esc_html_e( 'Checkbox Labels', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
				<td>
					<table >
						<tr>
							<td style="padding: 0;">
								<input name="moove_gdpr_modal_enabled_checkbox_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_modal_enabled_checkbox_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_modal_enabled_checkbox_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_modal_enabled_checkbox_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_modal_enabled_checkbox_label' . $wpml_lang ] ) : esc_html__( 'Enabled', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
							</td>
							<td style="padding: 0;">
								<input name="moove_gdpr_modal_disabled_checkbox_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_modal_disabled_checkbox_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_modal_disabled_checkbox_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_modal_disabled_checkbox_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_modal_disabled_checkbox_label' . $wpml_lang ] ) : esc_html__( 'Disabled', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
							</td>
						</tr>
					</table>
					<br />
					
				</td>

			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_consent_expiration"><?php esc_html_e( 'Consent expiry', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
				
					<span style="margin-right: 5px;">Consent expires after</span>
					<input name="moove_gdpr_consent_expiration" min="0" step="1" type="number" id="moove_gdpr_consent_expiration" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_consent_expiration' ] ) && intval( $gdpr_options[ 'moove_gdpr_consent_expiration' ] ) >= 0 ? esc_attr( $gdpr_options[ 'moove_gdpr_consent_expiration' ] ) : '365'; ?>" style="width: 80px;">
					<span style="margin-left: 5px;">days.</span>
				
					<p class="description">
						<?php esc_html_e( '(Enter 0 if you want the consent to expire at the end of the current browsing session.)', 'gdpr-cookie-compliance' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label><?php esc_html_e( 'Powered by GDPR', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<span class="powered-by-label">
						<label for="">Default label:</label>
						<input name="moove_gdpr_modal_powered_by_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_modal_powered_by_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) ? esc_attr( $gdpr_options[ 'moove_gdpr_modal_powered_by_label' . $wpml_lang ] ) : 'Powered by'; ?>" class="regular-text">
					</span>

					<input name="moove_gdpr_modal_powered_by_disable" type="hidden" <?php echo isset( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) ? ( intval( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) === 1 ? 'checked' : '' ) : ''; ?> id="moove_gdpr_modal_powered_by_disable" value="<?php echo isset( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) ? ( intval( $gdpr_options['moove_gdpr_modal_powered_by_disable'] ) === 1 ? '1' : '0' ) : '0'; ?>">
				</td>
			</tr>
			<?php do_action( 'gdpr_cc_general_modal_settings' ); ?>
		</tbody>
	</table>

	<br />
	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>

	<button type="button" class="button button-primary button-reset-settings"><?php esc_html_e( 'Reset Settings', 'gdpr-cookie-compliance' ); ?></button>

	<?php do_action( 'gdpr_cc_general_buttons_settings' ); ?>
</form>

<div class="gdpr-admin-popup gdpr-admin-popup-reset-settings" style="display: none;">
	<span class="gdpr-popup-overlay"></span>
	<div class="gdpr-popup-content">
		<div class="gdpr-popup-content-header">
			<a href="#" class="gdpr-popup-close"><span class="dashicons dashicons-no-alt"></span></a>
		</div>
		<!--  .gdpr-popup-content-header -->
		<div class="gdpr-popup-content-content">
			<form action="<?php esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=general-settings' ) ); ?>" method="post">
				<?php wp_nonce_field( 'moove_gdpr_reset_nonce_field', 'moove_gdpr_reset_nonce' ); ?>
				<h4><strong><?php esc_html_e( 'Please confirm that you would like to reset the plugin settings to the default state', 'gdpr-cookie-compliance' ); ?> </strong></h4><p><strong><?php esc_html_e( 'This action will remove all of your custom modifications and settings', 'gdpr-cookie-compliance' ); ?></strong></p>
				<input type="hidden" value="1" name="gdpr_reset_settings" />
				<button class="button button-primary button-reset-settings-confirm" type="submit">
					<?php esc_html_e( 'Reset plugin to default state', 'gdpr-cookie-compliance' ); ?>
				</button>
			</form>
		</div>
		<!--  .gdpr-popup-content-content -->    
	</div>
	<!--  .gdpr-popup-content -->
</div>
<!--  .gdpr-admin-popup -->
