<?php
/**
 * Plugin Boxes Doc Comment
 *
 * @category  Views
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$gdpr_controller = new Moove_GDPR_Controller();
$plugin_details  = $gdpr_controller->get_gdpr_plugin_details( 'gdpr-cookie-compliance' );
?>
<div class="moove-plugins-info-boxes">

	<?php ob_start(); ?>
	<div class="m-plugin-box m-plugin-box-highlighted">
		<div class="box-header">
			<h4>Premium Add-On</h4>
		</div>
		<!--  .box-header -->
		<div class="box-content">
			<div class="gdpr-faq-forum-content">
				<p><span class="gdpr-chevron-left">&#8250;</span> Includes full-screen layout</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Export & import settings</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> WordPress Multisite extension</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Accept cookies on scroll</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Consent Analytics</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Display cookie banner for EU visitors</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Language specific scripts</p>
			</div>
			<!-- gdpr-faq-forum-content -->
			<hr />
			<strong>Buy Now for only <span>£49</span></strong>
			<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank" class="plugin-buy-now-btn">Buy Now</a>

		</div>
		<!--  .box-content -->
	</div>
	<!--  .m-plugin-box -->
	<?php
		$content = apply_filters( 'gdpr_cookie_compliance_premium_section', ob_get_clean() );
		apply_filters( 'gdpr_cc_keephtml', $content, true );
		$support_class = apply_filters( 'gdpr_support_sidebar_class', '' );
	?>
	<div class="m-plugin-box m-plugin-box-support <?php echo esc_attr( $support_class ); ?>">
		<div class="box-header">
			<h4>Need Support or New Feature?</h4>
		</div>
		<!--  .box-header -->
		<div class="box-content">
			<?php
			$faq_link   = apply_filters( 'gdpr_cookie_compliance_faq_section_link', 'https://wordpress.org/plugins/gdpr-cookie-compliance/#faq-header' );
			$forum_link = apply_filters( 'gdpr_cookie_compliance_forum_section_link', 'https://support.mooveagency.com/forum/gdpr-cookie-compliance/' );
			?>
			<div class="gdpr-faq-forum-content">
				<p><span class="gdpr-chevron-left">&#8250;</span> Check the <a href="<?php esc_url( admin_url( 'admin.php?page=moove-gdpr&amp;tab=help' ) ); ?>">Help section</a> to find out more about Hooks, Filters & Shortcodes available</p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Find answers to your questions in the <a href="<?php echo esc_url( $faq_link ); ?>" target="_blank">FAQ section</a></p>
				<p><span class="gdpr-chevron-left">&#8250;</span> Create a new support ticket or request new features in our <a href="<?php echo esc_url( $forum_link ); ?>" target="_blank">Support Forum</a></p>
			</div>
			<!--  .gdpr-faq-forum-content -->
			<span class="gdpr-review-container" >
				<a href="<?php echo esc_url( $forum_link ); ?>#new-post" target="_blank" class="gdpr-review-bnt ">Create a new support ticket</a>
			</span>
		</div>
		<!--  .box-content -->
	</div>
	<!--  .m-plugin-box -->

	<div class="m-plugin-box">
		<div class="box-header">
			<h4>Find this plugin useful?</h4>
		</div>
		<!--  .box-header -->
		<div class="box-content">

			<p>You can help other users find it too by <a href="https://wordpress.org/support/plugin/gdpr-cookie-compliance/reviews/?rate=5#new-post" target="_blank">rating this plugin</a>.</p>
			<?php if ( $plugin_details ) : ?>
				<hr />
				<div class="plugin-stats">
					<div class="plugin-download-ainstalls-cnt">
						<div class="plugin-downloads">
							Downloads: <strong><?php echo number_format( $plugin_details->downloaded, 0, '', ',' ); ?></strong>
						</div>
						<!--  .plugin-downloads -->
						<div class="plugin-active-installs">
							Active installations: <strong><?php echo number_format( $plugin_details->active_installs, 0, '', ',' ); ?>+</strong>
						</div>
						<!--  .plugin-downloads -->
					</div>
					<!--  .plugin-download-ainstalls-cnt -->

					<div class="plugin-rating">
						<a href="https://wordpress.org/support/plugin/gdpr-cookie-compliance/reviews/" target="_blank">
							<span class="plugin-stars">
								<?php
									$rating_val = $plugin_details->rating * 5 / 100;
								if ( $rating_val > 0 ) :
									$args   = array(
										'rating' => $rating_val,
										'number' => $plugin_details->num_ratings,
										'echo'   => false,
									);
									$rating = wp_star_rating( $args );
									endif;
								if ( $rating ) :
									apply_filters( 'gdpr_cc_keephtml', $rating, true );
									endif;
								?>
							</span>
						</a>
					</div>
					<!--  .plugin-rating -->
				</div>
				<!--  .plugin-stats -->
			<?php endif; ?>
		</div>
		<!--  .box-content -->
	</div>
	<!--  .m-plugin-box -->
</div>
<!--  .moove-plugins-info-boxes -->
