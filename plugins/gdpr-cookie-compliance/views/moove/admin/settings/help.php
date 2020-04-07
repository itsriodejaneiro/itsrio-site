<?php
/**
 * Help Doc Comment
 *
 * @category  Views
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

?>
<h2><?php esc_html_e( 'Help, Hooks, Filters & Shortcodes', 'gdpr-cookie-compliance' ); ?></h2>
<hr />
<ul class="gdpr-disable-posts-nav moove-clearfix">
	<li></li>
	<li><a href="#gdpr_cbm_faq" class="gdpr-help-tab-toggle active"><?php esc_html_e( 'FAQ', 'gdpr-cookie-compliance' ); ?></a></li>
	<li><a href="#gdpr_cbm_dh" class="gdpr-help-tab-toggle"><?php esc_html_e( 'Default Hooks', 'gdpr-cookie-compliance' ); ?></a></li>
	<li><a href="#gdpr_cbm_ph" class="gdpr-help-tab-toggle"><?php esc_html_e( 'Premium Hooks', 'gdpr-cookie-compliance' ); ?></a></li>
	<li><a href="#gdpr_cbm_ps" class="gdpr-help-tab-toggle"><?php esc_html_e( 'Premium Shortcodes', 'gdpr-cookie-compliance' ); ?></a></li>
</ul>

<div class="gdpr-help-content-cnt">
	<div id="gdpr_cbm_faq" class="gdpr-help-content-block help-block-open">
		<div class="gdpr-faq-toggle gdpr-faq-open">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'How do I setup your plugin?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content">
				<p><?php esc_html_e( 'You can setup the plugin in the WordPress CMS -> GDPR Cookie Compliance. You can setup the branding, and other elements.', 'gdpr-cookie-compliance' ); ?></p>
				<p><?php esc_html_e( 'To add Google Analytics, you can enable the “3rd Party Cookies” tab but selecting the “Turn” radio value to “ON”. At the bottom of the “3rd Party Cookies” tab you’ll find 3 sections to add scripts – choose the section that is appropriate for your script.', 'gdpr-cookie-compliance' ); ?></p>
				<p><?php esc_html_e( 'For Google Analytics, we recommend using the ‘Footer’ section.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'How can I link to the pop-up settings screen?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'You can use the following link to display the modal window:', 'gdpr-cookie-compliance' ); ?></p>
				<p><?php esc_html_e( '[Relative Path – RECOMMENDED]', 'gdpr-cookie-compliance' ); ?></p>
				<code>/#gdpr_cookie_modal</code>

				<p><?php esc_html_e( '[Absolute Path]', 'gdpr-cookie-compliance' ); ?></p>
				<code><?php echo esc_url( home_url() ); ?>/#gdpr_cookie_modal</code><br /><br />
				<code><?php echo esc_url( home_url() ); ?>/your-internal-page/#gdpr_cookie_modal</code>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Pasted code is not visible when view-source page is viewed.', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'Our plugin loads the script with JavaScript, and that’s why you can’t find it in the view-source page. You can use the developer console in Chrome browser (Inspect Element feature) and find the scripts.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Can I use custom code or hooks with your plugin?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'Yes. We have implemented hooks that allow you to implement custom scripts, for some examples see the list of pre-defined hooks here:', 'gdpr-cookie-compliance' ); ?> <a href="#gdpr_cbm_dh" class="gdpr-help-tab-toggle"><?php esc_html_e( 'Default Hooks', 'gdpr-cookie-compliance' ); ?></a></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Does the plugin support sub domains?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'Unfortunately not, sub domains are treated as separate domains by browsers and we’re unable to change the cookies stored by another domain. If your multi site setup use sub domain version, each sub site will be recognised as a separate domain by the browser and will create cookies for each sub domain.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Does this plugin block all cookies?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'No. This plugin only restricts cookies for scripts that you have setup in the Settings. If you want to block all cookies, you have to add all scripts that use cookies into the Settings of this plugin.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Once I add scripts to this plugin, should I delete them from the website’s code?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'Yes. Once you setup the plugin, you should delete the scripts you uploaded to the plugin from your website’s code to ensure that your scripts are not loaded twice.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Does this plugin stop all cookies from being stored?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'This plugin is just a template and needs to be setup by your developer in order to work properly. Once setup fully, it will prevent scripts that store cookies from being loaded on users computers until consent is given.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Does this plugin guarantee that I will comply with GDPR law?', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><?php esc_html_e( 'Unfortunately no. This plugin is just a template and needs to be setup by your developer in order to work properly.', 'gdpr-cookie-compliance' ); ?></p>
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		
	</div>
	<!-- #gdpr_cbm_faq  -->

	<div id="gdpr_cbm_dh" class="gdpr-help-content-block">
		<p><?php esc_html_e( 'Here you can find the default hooks & custom scripts available in our plugin.', 'gdpr-cookie-compliance' ); ?></p>
		<p><strong><?php esc_html_e( 'Please note that these are just examples - some bespoke development work may be required to customise these code snippets to your specific requirements.' ); ?></strong></p>

		<div class="gdpr-faq-toggle gdpr-faq-open">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom 3RD-PARTY script by php – HEAD', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content">
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_header_assets','moove_gdpr_third_party_header_assets');
				function moove_gdpr_third_party_header_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-head");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( esc_attr( uniqid( strtotime( 'now' ) ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom 3RD-PARTY script by php – BODY', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_body_assets','moove_gdpr_third_party_body_assets');
				function moove_gdpr_third_party_body_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-body");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom 3RD-PARTY script by php – FOOTER', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_third_party_footer_assets','moove_gdpr_third_party_footer_assets');
				function moove_gdpr_third_party_footer_assets( $scripts ) {
					$scripts .= '<script>console.log("third-party-footer");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom ADVANCED-PARTY script by php – HEAD', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_header_assets','moove_gdpr_advanced_cookies_header_assets');
				function moove_gdpr_advanced_cookies_header_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-head");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom ADVANCED-PARTY script by php – BODY', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_body_assets','moove_gdpr_advanced_cookies_body_assets');
				function moove_gdpr_advanced_cookies_body_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-body");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'HOOK to GDPR custom ADVANCED-PARTY script by php – FOOTER', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_advanced_cookies_footer_assets','moove_gdpr_advanced_cookies_footer_assets');
				function moove_gdpr_advanced_cookies_footer_assets( $scripts ) {
					$scripts .= '<script>console.log("advanced-footer");</script>';
					return $scripts;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Enable Force Reload', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->
		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'PHP Cookie checker', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				if ( function_exists( 'gdpr_cookie_is_accepted' ) ) {
					/* supported types: 'strict', 'thirdparty', 'advanced' */
					if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) {
						echo "GDPR third party ENABLED content";
					} else {
						echo "GDPR third party RESTRICTED content";
					}
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Extend Styles', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('moove_gdpr_inline_styles','gdpr_cookie_css_extension',10,3);
				function gdpr_cookie_css_extension( $styles, $primary, $secondary ) {
					$styles .= '#main-header { z-index: 999; }';
					$styles .= '#top-header { z-index: 1000 }';
					$styles .= '.lity {z-index: 99999999;}';
					return $styles;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Custom css for buttons', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action('gdpr_custom_button_styles','gdpr_custom_button_styles',10,1);
				function gdpr_custom_button_styles( $css ) {
				  $css = 'border-radius: 5px;';
				  return $css;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		

		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Disable Monster Insights based on cookie selected', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'init', 'toggle_monster_insights_based_on_moove' );
				function toggle_monster_insights_based_on_moove() {
					if ( function_exists( gdpr_cookie_is_accepted ) && function_exists('monsterinsights_get_ua')) {
						if ( gdpr_cookie_is_accepted('thirdparty') ) {
							setCookie( 'ga-disable-'.monsterinsights_get_ua(), 'false' );
						} else {
							setCookie( 'ga-disable-'.monsterinsights_get_ua(), 'true' );
						}
					}
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Define CDN URL for Lity library', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'gdpr_cdn_url', 'gdpr_cdn_url', 10, 1 );
				function gdpr_cdn_url( $plugin_url ) {
					$cdn_url = 'https://yourcdnurl.com';
					return str_replace( trailingslashit( site_url() ) , trailingslashit( $cdn_url ), $plugin_url );
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Define custom cookie attribute (SameSite)', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				// <?php esc_html_e( 'Default value: SameSite=Lax', 'gdpr-cookie-compliance' ); ?> <br />
				add_action('gdpr_cookie_custom_attributes',function(){
					return 'SameSite=None; Secure';
				});
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Read cookie values with JavaScript', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_action( 'wp_footer', 'gdpr_js_extension', 1000 );
				function gdpr_js_extension() {
					<script>
						jQuery(document).ready(function(){
							var cookies_object = jQuery(this).moove_gdpr_read_cookies();
							if ( typeof cookies_object === 'object' ) {
								console.log(cookies_object);						
							}
						});
					</script>
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Compatibility with Pixel Your Site plugin', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter( 'pys_disable_by_gdpr', 'gdpr_cookie_compliance_pys' );
				function gdpr_cookie_compliance_pys() {
					if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
						$disable_pys = gdpr_cookie_is_accepted( 'thirdparty' ) ? false : true;
						return $disable_pys;
					endif;
					return true;
				}
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Hook for WooCommerce Facebook Pixel plugin', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter('facebook_for_woocommerce_integration_pixel_enabled', 'gdpr_cookie_facebook_wc', 20);
				function gdpr_cookie_facebook_wc() {
					$enable_fb_wc = true;
					if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
						$enable_fb_wc = gdpr_cookie_is_accepted( 'thirdparty' );
					endif;
					return $enable_fb_wc;
				}
				add_action( 'gdpr_force_reload', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Disable Script Caching', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
				function gdpr_prevent_script_cache() {
					return array();
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Prevent ajax script injection', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><strong><?php esc_html_e( 'Note', 'gdpr-cookie-compliance' ); ?>:</strong> <?php esc_html_e( 'By default, our plugin uses AJAX script injection to function properly, however, this may sometimes cause high server load. For that reason, you can disable the AJAX script and enable static script injection using the following hook. Please note you will also need to purge all caches for the hook to start working.', 'gdpr-cookie-compliance' ); ?></p>
				<?php ob_start(); ?>
				add_action( 'gdpr_cc_prevent_ajax_script_inject', '__return_true' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	
		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Custom Tracking Code on language sites (WPML, qTranslate, WP Multilang, Polylang)', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				// The SCRIPT caching should be disabled if you have separate scripts / site!
				add_filter('gdpr_cookie_script_cache','gdpr_prevent_script_cache');
				function gdpr_prevent_script_cache() {
					return array();
				}
				// Force reload required because of PHP functions
				add_action( 'gdpr_force_reload', '__return_true' );

				// Custom Scripts based on front-end language
				add_action('wp_head', 'my_gdpr_script_inject' );
				function my_gdpr_script_inject() {
					// PHP Cookie checker, replace the 'thirdparty' to 'advanced' if you need to load the scripts for "Advanced cookies"
					if ( function_exists( 'gdpr_cookie_is_accepted' ) && gdpr_cookie_is_accepted( 'thirdparty' ) ) :
						$gdpr_default_content 	= new Moove_GDPR_Content();
						$wpml_lang      		= $gdpr_default_content->moove_gdpr_get_wpml_lang();
						// Variable named $wpml_lang returns the localization string
						if ( $wpml_lang === 'fr' ) : 
							// Custom Script to FR site only
							echo "<script>console.log('French - Custom Script Added');</script>";
						elseif( $wpml_lang === 'en' ) :
							// Custom Script to EN site only
							echo "<script>console.log('English - Custom Script Added');</script>";
						endif;
					endif;
				}
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	
	
		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Disable comments until cookies are not accepted', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<?php ob_start(); ?>
				
				// Force reload required because of PHP functions
				add_action( 'gdpr_force_reload', '__return_true' );
				

				// Custom Scripts based on front-end language
				add_action('comments_open', function( $comments_open ){
					if ( function_exists( 'gdpr_cookie_is_accepted' ) ) :
					  // supported types: 'strict', 'thirdparty', 'advanced' 
					  if ( gdpr_cookie_is_accepted( 'thirdparty' ) ) :
				      return $comments_open;
				    else :
				    	return false;
				    endif;
				  endif;
					return $comments_open;
				});
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'Prevent loading Lity Lightbox by JavaScript', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><strong><?php esc_html_e( 'Note', 'gdpr-cookie-compliance' ); ?>:</strong> <?php esc_html_e( 'By default our plugin first checks (using JavaScript) if the Lity lightbox is defined and used by your theme or any of the active plugins. If the lightbox is not loaded our plugin will load the lightbox from the plugin folder by JavaScript.', 'gdpr-cookie-compliance' ); ?></p>
				<p><?php esc_html_e( 'You can use the following filter to prevent this JavaScript checking feature and enqueue the lightbox assets using PHP.', 'gdpr-cookie-compliance' ); ?> </p>
				<hr />
				<?php ob_start(); ?>
				add_action( 'gdpr_enqueue_lity_nojs', '__return_false' );
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	

		<div class="gdpr-faq-toggle">
			<div class="gdpr-faq-accordion-header">
				<h3><?php esc_html_e( 'GDPR Cookie Compliance Settings Page - Permissions', 'gdpr-cookie-compliance' ); ?></h3>
			</div>
			<div class="gdpr-faq-accordion-content" >
				<p><strong><?php esc_html_e( 'Note', 'gdpr-cookie-compliance' ); ?>:</strong> <?php esc_html_e( 'Default capability: manage_options', 'gdpr-cookie-compliance' ); ?></p>
				<hr />
				<?php ob_start(); ?>
				add_action( 'gdpr_options_page_cap', function( $capability = 'manage_options' ){
					return 'edit_posts';
				});
				<?php $code = trim( ob_get_clean() ); ?>
				<textarea id="<?php echo esc_attr( uniqid( strtotime( 'now' ) ) ); ?>"><?php apply_filters( 'gdpr_cc_keephtml', $code, true ); ?></textarea>
				<div class="gdpr-code"></div><!--  .gdpr-code -->
			</div>
			<!--  .gdpr-faq-accordion-content -->
		</div>
		<!--  .gdpr-faq-toggle -->	


		

	</div>
	<!-- #gdpr_cbm_faq  -->

	<div id="gdpr_cbm_ph" class="gdpr-help-content-block">
		<?php do_action( 'gdpr_tab_cbm_ph' ); ?>
	</div>
	<!-- #gdpr_cbm_ph  -->

	<div id="gdpr_cbm_ps" class="gdpr-help-content-block">
		<?php do_action( 'gdpr_tab_cbm_ps' ); ?>
	</div>
	<!-- #gdpr_cbm_ph  -->

</div>
<!--  .gdpr-help-content-cnt -->

<script type="text/javascript">
	window.onload = function() {
		if (typeof CodeMirror !== "undefined") {
			CodeMirror.defineExtension("autoFormatRange", function (from, to) {
			var cm = this;
			var outer = cm.getMode(), text = cm.getRange(from, to).split("\n");
			var state = CodeMirror.copyState(outer, cm.getTokenAt(from).state);
			var tabSize = cm.getOption("tabSize");

			var out = "", lines = 0, atSol = from.ch == 0;
			function newline() {
				out += "\n";
				atSol = true;
				++lines;
			}

			for (var i = 0; i < text.length; ++i) {
				var stream = new CodeMirror.StringStream(text[i], tabSize);
				while (!stream.eol()) {
					var inner = CodeMirror.innerMode(outer, state);
					var style = outer.token(stream, state), cur = stream.current();
					stream.start = stream.pos;
					if (!atSol || /\S/.test(cur)) {
						out += cur;
						atSol = false;
					}
					if (!atSol && inner.mode.newlineAfterToken &&
						inner.mode.newlineAfterToken(style, cur, stream.string.slice(stream.pos) || text[i+1] || "", inner.state))
						newline();
				}
				if (!stream.pos && outer.blankLine) outer.blankLine(state);
				if (!atSol) newline();
			}

			cm.operation(function () {
				cm.replaceRange(out, from, to);
				for (var cur = from.line + 1, end = from.line + lines; cur <= end; ++cur)
					cm.indentLine(cur, "smart");
			});
			});

			// Applies automatic mode-aware indentation to the specified range
			CodeMirror.defineExtension("autoIndentRange", function (from, to) {
				var cmInstance = this;
				this.operation(function () {
					for (var i = from.line; i <= to.line; i++) {
						cmInstance.indentLine(i, "smart");
					}
				});
			});
			function GDPR_CodeMirror() {
				jQuery('.gdpr-faq-accordion-content textarea').each(function(){
			var element = jQuery(this).closest('.gdpr-faq-accordion-content').find('.gdpr-code')[0];
			var id = jQuery(this).attr('id');

			jQuery(this).css({
				'opacity'   : '0',
				'height'    : '0',
			});
			var  editor = CodeMirror( element, {
				mode: "javascript",
				lineWrapping: true,
				lineNumbers: false,
				readOnly: true,
				value: document.getElementById(id).value
			});
			var totalLines = editor.lineCount();  
					editor.autoFormatRange({line:0, ch:0}, {line:totalLines});
			});
			}
			jQuery(document).ready(function(){
				GDPR_CodeMirror();
				
				jQuery('.gdpr-faq-toggle:not(.gdpr-faq-open)').find('.gdpr-faq-accordion-content').hide();
				jQuery('.gdpr-help-content-block:not(.help-block-open)').hide();
			});
		}
	};
</script>
<style>
	.CodeMirror {
		height: auto;
		border: none !important;
	}
</style>
