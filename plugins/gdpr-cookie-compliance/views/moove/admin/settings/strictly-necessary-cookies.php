<?php
/**
 * Strictly Necessary Cookies Doc Comment
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
			$value = 1;
			if ( isset( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] ) ) :
				$value = intval( $_POST['moove_gdpr_strictly_necessary_cookies_functionality'] );
		endif;

			$gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] = $value;
			update_option( $option_name, $gdpr_options );
			$gdpr_options = get_option( $option_name );
			foreach ( $_POST as $form_key => $form_value ) :
				if ( 'moove_gdpr_strict_necessary_cookies_tab_content' === $form_key ) :
					$value                                  = wp_unslash( $form_value );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_modal_strictly_secondary_notice' === $form_key ) :
					$value                                  = wpautop( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_strictly_necessary_cookies_warning' === $form_key ) :
					$value                                  = wp_unslash( $form_value );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_strictly_necessary_cookies_functionality' !== $form_key ) :
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
?>
<?php
$nav_label = isset( $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_tab_title' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_tab_title' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_tab_title' . $wpml_lang ] : __( 'Strictly Necessary Cookies', 'gdpr-cookie-compliance' );
?>
<h2><?php echo esc_attr( $nav_label ); ?></h2>
<hr />
<form action="<?php echo esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=strictly-necessary-cookies' ) ); ?>" method="post" id="moove_gdpr_tab_strictly_necessary_cookies">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_strictly_necessary_cookies_functionality"><?php esc_html_e( 'Choose functionality', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td data-fsm="<?php echo isset( $gdpr_options['moove_gdpr_full_screen_enable'] ) && 1 === intval( $gdpr_options['moove_gdpr_full_screen_enable'] ) ? 'true' : 'false'; ?>">

					<input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="1" id="moove_gdpr_strictly_necessary_cookies_functionality_1" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 1 ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_1"><?php esc_html_e( 'Optional (user selects their preferences)', 'gdpr-cookie-compliance' ); ?></label> <span class="separator"></span><br /><br />

					<input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="2" id="moove_gdpr_strictly_necessary_cookies_functionality_2" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 2 ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_2"><?php esc_html_e( 'Always enabled (user cannot disable it but can see the content)', 'gdpr-cookie-compliance' ); ?></label><br /><br />

					<input name="moove_gdpr_strictly_necessary_cookies_functionality" type="radio" value="3" id="moove_gdpr_strictly_necessary_cookies_functionality_3" <?php echo isset( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? ( intval( $gdpr_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) === 3 ? 'checked' : '' ) : ''; ?> class="on-off"> <label for="moove_gdpr_strictly_necessary_cookies_functionality_3"><?php esc_html_e( 'Always enabled and content hidden from user', 'gdpr-cookie-compliance' ); ?></label><br /><br />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_strictly_necessary_cookies_tab_title">
						<?php esc_html_e( 'Tab Title', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
				<td>
					<input name="moove_gdpr_strictly_necessary_cookies_tab_title<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_strictly_necessary_cookies_tab_title" value="<?php echo esc_attr( $nav_label ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row" colspan="2" style="padding-bottom: 0;">
					<label for="moove_gdpr_strict_necessary_cookies_tab_content">
						<?php esc_html_e( 'Tab Content', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
			</tr>
			<tr class="moove_gdpr_table_form_holder">
				<td colspan="2" scope="row" style="padding-left: 0;">
					<?php
						$content = isset( $gdpr_options[ 'moove_gdpr_strict_necessary_cookies_tab_content' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_strict_necessary_cookies_tab_content' . $wpml_lang ] ? wp_unslash( $gdpr_options[ 'moove_gdpr_strict_necessary_cookies_tab_content' . $wpml_lang ] ) : false;
					if ( ! $content ) :
						$content = $gdpr_default_content->moove_gdpr_get_strict_necessary_content();
						endif;

						$settings = array(
							'media_buttons' => false,
							'editor_height' => 150,
						);
						wp_editor( $content, 'moove_gdpr_strict_necessary_cookies_tab_content', $settings );
						?>
				</td>
			</tr>

			<tr>
				<th scope="row" style="padding-bottom: 0;" colspan="2">
					<label for="moove_gdpr_strictly_necessary_cookies_warning">
						<?php esc_html_e( 'Tab Warning Message', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
			</tr>
			<tr>
				<td style="padding-top: 10px; padding-left: 0;"  colspan="2">
					<?php
						$content  = isset( $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_warning' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_warning' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_strictly_necessary_cookies_warning' . $wpml_lang ] : $gdpr_default_content->moove_gdpr_get_strict_necessary_warning();
						$settings = array(
							'media_buttons' => false,
							'editor_height' => 100,
						);
						wp_editor( $content, 'moove_gdpr_strictly_necessary_cookies_warning', $settings );
						?>
					<p class="description"><?php esc_html_e( 'This warning message will be displayed when user disables the Strictly Necessary Cookies.', 'gdpr-cookie-compliance' ); ?></p>
				</td>
			</tr>

			<tr>
				<th scope="row" style="padding-bottom: 0;" colspan="2">
					<label for="moove_gdpr_modal_strictly_secondary_notice">
						<?php esc_html_e( 'Strictly necessary required message.', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
			</tr>
			<tr>
				<td colspan="2" style="padding-left: 0;">
					<?php
						$content  = isset( $gdpr_options[ 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_modal_strictly_secondary_notice' . $wpml_lang ] : $gdpr_default_content->moove_gdpr_get_secondary_notice();
						$settings = array(
							'media_buttons' => false,
							'editor_height' => 100,
						);
						wp_editor( $content, 'moove_gdpr_modal_strictly_secondary_notice', $settings );
						?>
					<p class="description">
						<?php esc_html_e( 'This warning message will be displayed if the Strictly necessary cookies are not enabled and the user try to enable the "Third Party" or "Additional cookies"', 'gdpr-cookie-compliance' ); ?>
					</p>
				</td>
			</tr>

		</tbody>
	</table>

	<?php do_action( 'gdpr_settings_screen_extension', 'strictly' ); ?>
	
	<br />
	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>
</form>
<div class="gdpr-admin-popup gdpr-admin-popup-fsm-settings" style="display: none;">
	<span class="gdpr-popup-overlay"></span>
	<div class="gdpr-popup-content">
		<div class="gdpr-popup-content-header">
			<a href="#" class="gdpr-popup-close"><span class="dashicons dashicons-no-alt"></span></a>
		</div>
		<!--  .gdpr-popup-content-header -->
		<div class="gdpr-popup-content-content">
			<h4><strong><?php esc_html_e( 'This option is not available in Full Screen Mode', 'gdpr-cookie-compliance' ); ?> </strong></h4>

			<p class="description"><strong><?php esc_html_e( 'Please note that Full Screen Mode feature requires the Strictly Necessary Cookies to be always enabled (otherwise the Cookie Banner would be displayed at every visit).', 'gdpr-cookie-compliance' ); ?></strong></p> <br /><br />
					<!--  .description -->

			<a href="<?php echo admin_url( 'admin.php?page=moove-gdpr&amp;tab=full-screen-mode'); ?>" class="button button-primary button-deactivate-confirm">
				<?php esc_html_e( 'Disable the Full Screen Mode', 'gdpr-cookie-compliance' ); ?>
			</a>
		</div>
		<!--  .gdpr-popup-content-content -->    
	</div>
	<!--  .gdpr-popup-content -->
</div>
<!--  .gdpr-admin-popup -->

