<?php
/**
 * Privacy Overview Doc Comment
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
			foreach ( $_POST as $form_key => $form_value ) :
				if ( 'moove_gdpr_privacy_overview_tab_content' === $form_key ) :
					$value                                  = wp_unslash( $form_value );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				else :
					$value                     = sanitize_text_field( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				endif;
			endforeach;
		endif;
		?>
		<script>
			jQuery('#moove-gdpr-setting-error-settings_updated').show();
		</script>
		<?php
	endif;
	do_action( 'gdpr_cookie_filter_settings' );
endif;
?>
<?php
$nav_label = isset( $gdpr_options[ 'moove_gdpr_privacy_overview_tab_title' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_privacy_overview_tab_title' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_privacy_overview_tab_title' . $wpml_lang ] : __( 'Privacy Overview', 'gdpr-cookie-compliance' );
?>

<h2><?php echo esc_attr( $nav_label ); ?></h2>
<hr />
<form action="<?php esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=privacy-overview' ) ); ?>" method="post" id="moove_gdpr_tab_privacy_overview">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_privacy_overview_tab_title"><?php esc_html_e( 'Tab Title', 'gdpr-cookie-compliance' ); ?></label>
				</th>
				<td>
					<input name="moove_gdpr_privacy_overview_tab_title<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_privacy_overview_tab_title" value="<?php echo esc_attr( $nav_label ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row" colspan="2" style="padding-bottom: 0;">
					<label for="moove_gdpr_privacy_overview_tab_content"><?php esc_html_e( 'Tab Content', 'gdpr-cookie-compliance' ); ?></label>
				</th>
			</tr>
			<tr class="moove_gdpr_table_form_holder">
				<th colspan="2" scope="row">
					<?php
					$content = isset( $gdpr_options[ 'moove_gdpr_privacy_overview_tab_content' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_privacy_overview_tab_content' . $wpml_lang ] ? wp_unslash( $gdpr_options[ 'moove_gdpr_privacy_overview_tab_content' . $wpml_lang ] ) : false;
					if ( ! $content ) :
						$content = $gdpr_default_content->moove_gdpr_get_privacy_overview_content();
					endif;
					?>
					<?php
					$settings = array(
						'media_buttons' => false,
						'editor_height' => 150,
					);
					wp_editor( $content, 'moove_gdpr_privacy_overview_tab_content', $settings );
					?>
				</th>
			</tr>
		</tbody>
	</table>

	<hr />
	<br />
	<button type="submit" class="button button-primary"><?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?></button>
</form>
