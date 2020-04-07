<?php
/**
 * Cookie Banner Manager Doc Comment
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
			if ( isset( $_POST['moove_gdpr_cookie_policy_enable'] ) ) :
				$value = 1;
			else :
				$value = 0;
			endif;
			$gdpr_options['moove_gdpr_cookie_policy_enable'] = $value;
			update_option( $option_name, $gdpr_options );
			$gdpr_options = get_option( $option_name );
			foreach ( $_POST as $form_key => $form_value ) :
				if ( 'moove_gdpr_cookies_policy_tab_content' === $form_key ) :
					$value                                  = wp_unslash( $form_value );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_cookie_policy_enable' !== $form_key ) :
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
$nav_label = isset( $gdpr_options[ 'moove_gdpr_cookie_policy_tab_nav_label' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_cookie_policy_tab_nav_label' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_cookie_policy_tab_nav_label' . $wpml_lang ] : __( 'Cookie Policy', 'gdpr-cookie-compliance' );
?>
<h2><?php echo esc_attr( $nav_label ); ?></h2>
<hr />
<form action="<?php echo esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=cookie-policy' ) ); ?>" method="post" id="moove_gdpr_tab_cookie_policy">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_cookie_policy_enable"><?php esc_html_e( 'Turn', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>

					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_cookie_policy_enable" id="moove_gdpr_cookie_policy_enable" <?php echo isset( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) === 1 ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_cookie_policy_enable'] ) ? 'checked' : '' ) ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'On', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Off', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>

				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_cookie_policy_tab_nav_label"><?php esc_html_e( 'Tab Title', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_cookie_policy_tab_nav_label<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_cookie_policy_tab_nav_label" value="<?php echo esc_attr( $nav_label ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row" colspan="2" style="padding-bottom: 0;">
					<label for="moove_gdpr_cookies_policy_tab_content"><?php esc_html_e( 'Tab Content', 'gdpr-cookie-compliance' ); ?></label>
				</th>
			</tr>
			<tr class="moove_gdpr_table_form_holder">
				<th colspan="2" scope="row">
					<?php
					$content = isset( $gdpr_options[ 'moove_gdpr_cookies_policy_tab_content' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_cookies_policy_tab_content' . $wpml_lang ] ? wp_unslash( $gdpr_options[ 'moove_gdpr_cookies_policy_tab_content' . $wpml_lang ] ) : false;
					if ( ! $content ) :
						$_content = $gdpr_default_content->moove_gdpr_get_cookie_policy_content();
						$content  = $_content;
					endif;
					?>
					<?php
					$settings = array(
						'media_buttons' => false,
						'editor_height' => 150,
					);
					wp_editor( $content, 'moove_gdpr_cookies_policy_tab_content', $settings );
					?>
				</th>
			</tr>

		</tbody>
	</table>

	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>
</form>
