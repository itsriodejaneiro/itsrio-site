<?php
/**
 * Floating Button Doc Comment
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
	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['moove_gdpr_nonce'] ) ), 'moove_gdpr_nonce_field' ) ) :
		die( 'Security check' );
	else :
		if ( is_array( $_POST ) ) :
			if ( isset( $_POST['moove_gdpr_floating_button_enable'] ) ) :
				$value = 1;
			else :
				$value = 0;
			endif;
			$gdpr_options['moove_gdpr_floating_button_enable'] = $value;

			if ( isset( $_POST['moove_gdpr_floating_mobile'] ) ) :
				$value = 1;
			else :
				$value = 0;
			endif;
			$gdpr_options['moove_gdpr_floating_mobile'] = $value;

			update_option( $option_name, $gdpr_options );
			$gdpr_options = get_option( $option_name );

			foreach ( $_POST as $form_key => $form_value ) :
				if ( 'moove_gdpr_floating_button_enable' !== $form_key && 'moove_gdpr_floating_mobile' !== $form_key ) :
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
<form action="<?php esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=floating_button' ) ); ?>" method="post" id="moove_gdpr_tab_floating_button">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<h2><?php esc_html_e( 'Floating Button', 'gdpr-cookie-compliance' ); ?></h2>
	<hr />

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_floating_button_enable"><?php esc_html_e( 'Floating Button', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_floating_button_enable" id="moove_gdpr_floating_button_enable" <?php echo isset( $gdpr_options['moove_gdpr_floating_button_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_floating_button_enable'] ) === 1 ? 'checked' : '' ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'Enabled', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Disabled', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>

				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_button_label"><?php esc_html_e( 'Button - Hover Label', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_floating_button_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_floating_button_label" value="<?php echo isset( $gdpr_options[ 'moove_gdpr_floating_button_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_floating_button_label' . $wpml_lang ] ? esc_attr( $gdpr_options[ 'moove_gdpr_floating_button_label' . $wpml_lang ] ) : esc_attr__( 'Change cookie settings', 'gdpr-cookie-compliance' ); ?>" class="regular-text">
				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_button_position"><?php esc_html_e( 'Button - Custom Position (CSS)', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_floating_button_position" type="text" id="moove_gdpr_floating_button_position" value="<?php echo isset( $gdpr_options['moove_gdpr_floating_button_position'] ) && $gdpr_options['moove_gdpr_floating_button_position'] ? esc_attr( $gdpr_options['moove_gdpr_floating_button_position'] ) : 'bottom: 20px; left: 20px;'; ?>" class="regular-text">
					<p class="description" id="moove_gdpr_floating_button_position-description">
						<?php
							$content = __( 'You can align the position eg.: <strong>top: 20px; right: 20px;</strong>', 'gdpr-cookie-compliance' );
							apply_filters( 'gdpr_cc_keephtml', $content, true );
						?>
						</p>
				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_mobile"><?php esc_html_e( 'Visibility on mobile', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle gdpr-checkbox-inverted">
						<input type="checkbox" name="moove_gdpr_floating_mobile" id="moove_gdpr_floating_mobile" <?php echo isset( $gdpr_options['moove_gdpr_floating_mobile'] ) ? ( intval( $gdpr_options['moove_gdpr_floating_mobile'] ) === 1 ? 'checked' : '' ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'Visible', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Hidden', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>

				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_button_background_colour"><?php esc_html_e( 'Button - Background Colour', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<div class="iris-colorpicker-group-cnt">
						<?php $color = isset( $gdpr_options['moove_gdpr_floating_button_background_colour'] ) && $gdpr_options['moove_gdpr_floating_button_background_colour'] ? $gdpr_options['moove_gdpr_floating_button_background_colour'] : '373737'; ?>
						<input class="iris-colorpicker regular-text" type="text" name="moove_gdpr_floating_button_background_colour" value="<?php echo esc_attr( $color ); ?>" style="background-color: <?php echo esc_attr( $color ); ?>;" >
						<span class="iris-selectbtn"><?php esc_html_e( 'Select', 'gdpr-cookie-compliance' ); ?></span>
					</div>
				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_button_hover_background_colour"><?php esc_html_e( 'Button - Hover Background Colour', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<div class="iris-colorpicker-group-cnt">
						<?php
						$color = isset( $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] ) && $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] ? $gdpr_options['moove_gdpr_floating_button_hover_background_colour'] : '000000';
						?>
						<input class="iris-colorpicker regular-text" type="text" name="moove_gdpr_floating_button_hover_background_colour" value="<?php echo esc_attr( $color ); ?>" style="background-color: <?php echo esc_attr( $color ); ?>;" >
						<span class="iris-selectbtn"><?php esc_html_e( 'Select', 'gdpr-cookie-compliance' ); ?></span>
					</div>
				</td>
			</tr>

			<tr class="gdpr-conditional-field" data-dependency="#moove_gdpr_floating_button_enable">
				<th scope="row">
					<label for="moove_gdpr_floating_button_font_colour"><?php esc_html_e( 'Button - Font Colour', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<div class="iris-colorpicker-group-cnt">
						<?php $color = isset( $gdpr_options['moove_gdpr_floating_button_font_colour'] ) && $gdpr_options['moove_gdpr_floating_button_font_colour'] ? $gdpr_options['moove_gdpr_floating_button_font_colour'] : 'ffffff'; ?>
						<input class="iris-colorpicker regular-text" type="text" name="moove_gdpr_floating_button_font_colour" value="<?php echo esc_attr( $color ); ?>" style="background-color: <?php echo esc_attr( $color ); ?>;" >
						<span class="iris-selectbtn"><?php esc_html_e( 'Select', 'gdpr-cookie-compliance' ); ?></span>
					</div>
				</td>
			</tr>

			<?php do_action( 'gdpr_cc_floating_button_settings' ); ?>

		</tbody>
	</table>

	<br />
	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>
	<?php do_action( 'gdpr_cc_floating_button_settings' ); ?>
</form>
