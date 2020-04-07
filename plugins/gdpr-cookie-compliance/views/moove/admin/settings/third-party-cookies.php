<?php
/**
 * Third Party Cookies Doc Comment
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
$empty_scripts        = false;
if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
	$nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
	if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
		die( 'Security check' );
	else :
		if ( is_array( $_POST ) ) :
			if ( isset( $_POST['moove_gdpr_third_party_cookies_enable'] ) ) :
				$value = 1;
			else :
				$value = 0;
			endif;

			$gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] = 0;
			if ( isset( $_POST['moove_gdpr_third_party_cookies_enable_first_visit'] ) ) :
				$gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] = 1;
			endif;
			update_option( $option_name, $gdpr_options );


			$gdpr_options['moove_gdpr_third_party_cookies_enable'] = $value;
			update_option( $option_name, $gdpr_options );
			$gdpr_options = get_option( $option_name );

			foreach ( $_POST as $form_key => $form_value ) :

				if ( 'moove_gdpr_performance_cookies_tab_content' === $form_key ) :
					$value                                  = wp_unslash( $form_value );
					$gdpr_options[ $form_key . $wpml_lang ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_third_party_header_scripts' === $form_key || 'moove_gdpr_third_party_body_scripts' === $form_key || 'moove_gdpr_third_party_footer_scripts' === $form_key ) :
					$value                     = wp_unslash( $form_value );
					$gdpr_options[ $form_key ] = maybe_serialize( $value );
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				elseif ( 'moove_gdpr_third_party_cookies_enable' !== $form_key && 'moove_gdpr_third_party_cookies_enable_first_visit' !== $form_key ) :
					$value                     = sanitize_text_field( wp_unslash( $form_value ) );
					$gdpr_options[ $form_key ] = $value;
					update_option( $option_name, $gdpr_options );
					$gdpr_options = get_option( $option_name );
				endif;
			endforeach;
			do_action( 'gdpr_ps_check_language_extensions', $empty_scripts, $_POST, 'third_party' );
			do_action( 'gdpr_cookie_filter_settings' );
		endif;

		$gdpr_options = get_option( $option_name );
		?>

		<script>
			jQuery('#moove-gdpr-setting-error-settings_scripts_empty').hide();
			jQuery('#moove-gdpr-setting-error-settings_updated').show();
		</script>
		<?php
	endif;
endif;

$nav_label = isset( $gdpr_options[ 'moove_gdpr_performance_cookies_tab_title' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_performance_cookies_tab_title' . $wpml_lang ] ? $gdpr_options[ 'moove_gdpr_performance_cookies_tab_title' . $wpml_lang ] : __( '3rd Party Cookies', 'gdpr-cookie-compliance' );
?>
<h2><?php echo esc_attr( $nav_label ); ?></h2>
<hr />
<form action="<?php echo esc_url( admin_url( 'admin.php?page=moove-gdpr&tab=third-party-cookies' ) ); ?>" method="post" id="moove_gdpr_tab_third_party_cookies">
	<?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
	<table class="form-table <?php echo $empty_scripts ? 'moove-gdpr-form-error' : ''; ?>">
		<tbody>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_third_party_cookies_enable">
						<?php esc_html_e( 'Turn', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
				<td>
					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_third_party_cookies_enable" id="moove_gdpr_third_party_cookies_enable" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) === 1 ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) ? 'checked' : '' ) ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'On', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Off', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="moove_gdpr_third_party_cookies_enable_first_visit"><?php esc_html_e( 'Default status', 'gdpr-cookie-compliance' ); ?></label>
					<p class="description"><?php esc_html_e( 'by default cookies should be', 'gdpr-cookie-compliance' ); ?>:</p>
					<!--  .description -->
				</th>
				<td style="vertical-align: top; padding-top: 20px">
					<!-- GDPR Rounded switch -->
					<label class="gdpr-checkbox-toggle">
						<input type="checkbox" name="moove_gdpr_third_party_cookies_enable_first_visit" id="moove_gdpr_third_party_cookies_enable_first_visit" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) === 1 ? 'checked' : ( ! isset( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? 'checked' : '' ) ) : ''; ?> >
						<span class="gdpr-checkbox-slider" data-enable="<?php esc_html_e( 'Enabled', 'gdpr-cookie-compliance' ); ?>" data-disable="<?php esc_html_e( 'Disabled', 'gdpr-cookie-compliance' ); ?>"></span>
					</label>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="moove_gdpr_performance_cookies_tab_title">
						<?php esc_html_e( 'Tab Title', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
				<td>
					<input name="moove_gdpr_performance_cookies_tab_title<?php echo esc_attr( $wpml_lang ); ?>" type="text" id="moove_gdpr_performance_cookies_tab_title" value="<?php echo esc_attr( $nav_label ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row" colspan="2" style="padding-bottom: 0;">
					<label for="moove_gdpr_performance_cookies_tab_content">
						<?php esc_html_e( 'Tab Content', 'gdpr-cookie-compliance' ); ?>
					</label>
				</th>
			</tr>
			<tr class="moove_gdpr_table_form_holder">
				<th colspan="2" scope="row">
					<?php
						$content = isset( $gdpr_options[ 'moove_gdpr_performance_cookies_tab_content' . $wpml_lang ] ) && $gdpr_options[ 'moove_gdpr_performance_cookies_tab_content' . $wpml_lang ] ? wp_unslash( $gdpr_options[ 'moove_gdpr_performance_cookies_tab_content' . $wpml_lang ] ) : false;
						if ( ! $content ) :
							$content = $gdpr_default_content->moove_gdpr_get_third_party_content();
						endif;

						$settings = array(
							'media_buttons' => false,
							'editor_height' => 150,
						);
						wp_editor( $content, 'moove_gdpr_performance_cookies_tab_content', $settings );
					?>
				</th>
			</tr>
		</tbody>
	</table>

	<div class="gdpr-script-tab-content">
		<hr />
		<h3><?php esc_html_e( 'Paste your codes and snippets below. They will be added to all pages if user enables these cookies.', 'gdpr-cookie-compliance' ); ?></h3>
		<div class="alert script-error" style="display: none;"><?php esc_html_e( 'Please fill out at least one of these fields:', 'gdpr-cookie-compliance' ); ?></div>

		<div class="gdpr-tab-code-section-nav">
			<ul>
				<li>
					<a href="#third_party_head" class="gdpr-active">
						<?php esc_html_e( 'Head Section', 'gdpr-cookie-compliance' ); ?>
					</a>
				</li>
				<li>
					<a href="#third_party_body">
						<?php esc_html_e( 'Body Section', 'gdpr-cookie-compliance' ); ?>
					</a>
				</li>
				<li>
					<a href="#third_party_footer">
						<?php esc_html_e( 'Footer Section', 'gdpr-cookie-compliance' ); ?>
					</a>
				</li>
				<?php do_action( 'gdpr_tab_code_section_nav_extension', 'third_party' ); ?>
			</ul>
		</div>
		<!--  .gdpr-tab-code-section-nav -->
		<div class="gdpr-script-tabs-main-cnt">

			<div class="gdpr-tab-code-section gdpr-active" id="third_party_head">
				<h4 for="moove_gdpr_third_party_header_scripts"><?php esc_html_e( 'Add scripts that you would like to be inserted to the HEAD section of your pages when user accepts these cookies', 'gdpr-cookie-compliance' ); ?></h4>
				<table>
					<tbody>
						<tr class="moove_gdpr_third_party_header_scripts">
							<td scope="row" colspan="2" style="padding: 20px 0;">
								<?php
								$content = isset( $gdpr_options['moove_gdpr_third_party_header_scripts'] ) && $gdpr_options['moove_gdpr_third_party_header_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_header_scripts'] ) : '';
								?>
								<textarea name="moove_gdpr_third_party_header_scripts" id="moove_gdpr_third_party_header_scripts" class="large-text code" rows="13"><?php apply_filters( 'gdpr_cc_keephtml', $content, true ); ?></textarea>
								<div class="gdpr-code"></div>
								<!--  .gdpr-code -->
								<p class="description" id="moove_gdpr_third_party_header_scripts-description">
									<?php esc_html_e( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'gdpr-cookie-compliance' ); ?>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!--  .gdpr-tab-code-section -->

			<div class="gdpr-tab-code-section" id="third_party_body">
				<h4 for="moove_gdpr_third_party_header_scripts"><?php esc_html_e( 'Add scripts that you would like to be inserted to the BODY section of your pages when user accepts these cookies', 'gdpr-cookie-compliance' ); ?></h4>
				<table>
					<tbody>                   
						<tr class="moove_gdpr_third_party_body_scripts">
							<td scope="row" colspan="2" style="padding: 20px 0;">
								<?php
									$content = isset( $gdpr_options['moove_gdpr_third_party_body_scripts'] ) && $gdpr_options['moove_gdpr_third_party_body_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_body_scripts'] ) : '';
								?>
								<textarea name="moove_gdpr_third_party_body_scripts" id="moove_gdpr_third_party_body_scripts" class="large-text code" rows="13"><?php apply_filters( 'gdpr_cc_keephtml', $content, true ); ?></textarea>
								<div class="gdpr-code"></div>
								<!--  .gdpr-code -->
								<p class="description" id="moove_gdpr_third_party_body_scripts-description">
									<?php esc_html_e( 'For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.', 'gdpr-cookie-compliance' ); ?>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!--  .gdpr-tab-code-section -->

			<div class="gdpr-tab-code-section" id="third_party_footer">
				<h4 for="moove_gdpr_third_party_header_scripts"><?php esc_html_e( 'Add scripts that you would like to be inserted to the FOOTER section of your pages when user accepts these cookies', 'gdpr-cookie-compliance' ); ?></h4>
				<table>
					<tbody>
						<tr class="moove_gdpr_third_party_footer_scripts">
							<td scope="row" colspan="2" style="padding: 20px 0;">
								<?php
									$content = isset( $gdpr_options['moove_gdpr_third_party_footer_scripts'] ) && $gdpr_options['moove_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_footer_scripts'] ) : '';
								?>
								<textarea name="moove_gdpr_third_party_footer_scripts" id="moove_gdpr_third_party_footer_scripts" class="large-text code" rows="13"><?php apply_filters( 'gdpr_cc_keephtml', $content, true ); ?></textarea>
								<div class="gdpr-code"></div>
								<!--  .gdpr-code -->
								<p class="description" id="moove_gdpr_third_party_footer_scripts-description">
									<?php esc_html_e( 'For example, you can use it for Google Analytics script or any other 3rd party code snippets.', 'gdpr-cookie-compliance' ); ?>
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!--  .gdpr-tab-code-section -->

			<?php do_action( 'gdpr_tab_code_section_content_extension', 'third_party' ); ?>
		</div>
		<!--  .gdpr-script-tabs-main-cnt -->
	</div>
	<!--  .gdpr-script-tab-content -->

	<?php do_action( 'gdpr_settings_screen_extension', 'thirdparty' ); ?>

	<br />
	<hr />
	<br />
	<button type="submit" class="button button-primary">
		<?php esc_html_e( 'Save changes', 'gdpr-cookie-compliance' ); ?>
	</button>
	<script type="text/javascript">
		window.onload = function() {
			jQuery('.gdpr-tab-section-cnt textarea.code').each(function(){
				if (typeof CodeMirror === "function") {
					var element = jQuery(this).closest('tr').find('.gdpr-code')[0];
					var id = jQuery(this).attr('id');

					jQuery(this).css({
						'opacity'   : '0',
						'height'    : '0',
					});
					var  editor = CodeMirror( element, {
						mode: "text/html",
						lineWrapping: true,
						lineNumbers: true,
						value: document.getElementById(id).value
					});
					editor.on('change',function(cMirror){
					// get value right from instance
					document.getElementById(id).innerHTML = cMirror.getValue();
				});
			} else {
				jQuery('.gdpr-code').hide();
			}
		});
	};
	</script>
</form>
