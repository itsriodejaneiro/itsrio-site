<?php
/**
 * Banner Settings File Doc Comment
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
			$restricted_keys = array(
				'moove_gdpr_floating_button_enable',
				'moove_gdpr_infobar_visibility',
				'moove_gdpr_reject_button_enable',
				'moove_gdpr_colour_scheme',
			);
			// Cookie Banner Visibility.
			$moove_gdpr_infobar_visibility = 'hidden';
			if ( isset( $_POST['moove_gdpr_infobar_visibility'] ) ) :
				$moove_gdpr_infobar_visibility = 'visible';
			endif;
			$gdpr_options['moove_gdpr_infobar_visibility'] = $moove_gdpr_infobar_visibility;

			// Cookie Banner Reject Button.
			$moove_gdpr_reject_enable = '0';
			if ( isset( $_POST['moove_gdpr_reject_button_enable'] ) ) :
				$moove_gdpr_reject_enable = '1';
			endif;
			$gdpr_options['moove_gdpr_reject_button_enable'] = $moove_gdpr_reject_enable;

			// Cookie Banner Colour Scheme.
			$moove_gdpr_colour_scheme = '2';
			
			if ( isset( $_POST['moove_gdpr_colour_scheme'] ) ) :
				$moove_gdpr_colour_scheme = '1';
			endif;
			$gdpr_options['moove_gdpr_colour_scheme'] = $moove_gdpr_colour_scheme;

			update_option( $option_name, $gdpr_options );

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
				elseif ( ! in_array( $form_key, $restricted_keys ) ) :
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
<form action="<?php echo esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=banner-settings' ) ); ?>" method="post" id="moove_gdpr_tab_banner_settings">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<h2><?php esc_html_e( 'Cookie Banner Settings', 'gdpr-cookie-compliance' ); ?></h2>
	<hr />

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_infobar_visibility"><?php esc_html_e( 'Turn', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_infobar_visibility" <?php echo isset( $gdpr_options['moove_gdpr_infobar_visibility'] ) ? ( 'visible' === $gdpr_options['moove_gdpr_infobar_visibility'] ? 'checked' : '' ) : 'checked'; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'On', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Off', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>
					<?php do_action( 'gdpr_cc_moove_gdpr_infobar_visibility_settings' ); ?>
				</td>
			</tr>
			<tr>
				<th scope="row" colspan="2" style="padding-bottom: 0;">
					<label for="moove_gdpr_info_bar_content"><?php esc_html_e( 'Cookie Banner Content', 'gdpr-cookie-compliance' ); ?></label>
				</th>
			</tr>
			<tr class="moove_gdpr_table_form_holder">
				<th colspan="2" scope="row">
					<?php
					$content = isset( $gdpr_options[ 'moove_gdpr_info_bar_content' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_info_bar_content' . $wpml_lang ] ? maybe_unserialize( $gdpr_options[ 'moove_gdpr_info_bar_content' . $wpml_lang ] ) : false;
					if ( ! $content ) :
						$_content = __( '<p>We are using cookies to give you the best experience on our website.</p><p>You can find out more about which cookies we are using or switch them off in [setting]settings[/setting].</p>', 'gdpr-cookie-compliance' );
						$content  = $_content;
					endif;
					?>
					<?php
					$settings = array(
						'media_buttons' => false,
						'editor_height' => 150,
						'teeny'         => false,
					);
					wp_editor( $content, 'moove_gdpr_info_bar_content', $settings );
					?>
					<p class="description">
					<?php
						$content = __( 'You can use the following shortcut to link the Cookie Settings Screen:<br><span><strong>[setting]</strong>settings<strong>[/setting]</strong></span>', 'gdpr-cookie-compliance' );
						apply_filters( 'gdpr_cc_keephtml', $content, true );
					?>
					</p>
				</th>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_infobar_accept_button_label"><?php esc_html_e( 'Accept - Button Label', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_infobar_accept_button_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_infobar_accept_button_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_infobar_accept_button_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_infobar_accept_button_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_infobar_accept_button_label' . $wpml_lang ] ) : esc_attr__( 'Accept', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_reject_button_enable"><?php esc_html_e( 'Reject button', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>

					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_reject_button_enable" id="moove_gdpr_reject_button_enable" <?php echo isset( $gdpr_options['moove_gdpr_reject_button_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_reject_button_enable'] ) === 1 ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_reject_button_enable'] ) ? 'checked' : '' ) ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'Enabled', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Disabled', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>
					<p class="description" id="moove_gdpr_reject_button_enable-description" ><?php esc_html_e( "If it's enabled, the Cookie Banner will be extended with a button that allows users to reject all cookies.", 'gdpr-cookie-compliance' ); ?></p>
					<!--  .description -->
				</td>
			</tr>
			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_reject_button_enable">
				<th scope="row">
					<label for="moove_gdpr_infobar_reject_button_label"><?php esc_html_e( 'Reject - Button Label', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_infobar_reject_button_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_infobar_reject_button_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_infobar_reject_button_label' . $wpml_lang ] ) : esc_attr__( 'Reject', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_infobar_position"><?php esc_html_e( 'Cookie Banner position', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_infobar_position" type="radio" value="top" id="moove_gdpr_infobar_position_top" <?php echo isset( $gdpr_options['moove_gdpr_infobar_position'] ) ? ( 'top' === $gdpr_options['moove_gdpr_infobar_position'] ? 'checked' : '' ) : ''; ?> class="on-top"> <label for="moove_gdpr_infobar_position_top"><?php esc_html_e( 'Top', 'gdpr-cookie-compliance' ); ?></label> 
					<span class="separator"></span>

					<input name="moove_gdpr_infobar_position" type="radio" value="bottom" id="moove_gdpr_infobar_position_bottom" <?php echo isset( $gdpr_options['moove_gdpr_infobar_position'] ) ? ( 'bottom' === $gdpr_options['moove_gdpr_infobar_position'] ? 'checked' : '' ) : 'checked'; ?> class="on-off"> <label for="moove_gdpr_infobar_position_bottom"><?php esc_html_e( 'Bottom', 'gdpr-cookie-compliance' ); ?></label>

					<?php do_action( 'gdpr_cc_moove_gdpr_infobar_position_settings' ); ?>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_colour_scheme"><?php esc_html_e( 'Colour scheme', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<label class="gdpr-checkbox-toggle gdpr-color-scheme-toggle">
						<input type="checkbox" name="moove_gdpr_colour_scheme" <?php echo isset( $gdpr_options['moove_gdpr_colour_scheme'] ) ? ( 1 === intval( $gdpr_options['moove_gdpr_colour_scheme'] ) ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_colour_scheme'] ) ? 'checked' : '' ) ) : 'checked'; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'Dark', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Light', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>                   
				</td>
			</tr>

			<?php do_action( 'gdpr_cc_infobar_settings' ); ?>

		</tbody>
	</table>

	<br />
	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>
	<?php do_action( 'gdpr_cc_banner_buttons_settings' ); ?>
</form>
