<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}
?>
<div class="wrap wp-foundation-shortcodes-admin-page">
	<h2 id="wp-foundation-shortcodes-title"><?php _e('WP Foundation Shortcodes', 'wp-foundation-shortcodes');?></h2>

	<h3>1. <?php _e('Follow us, and do not miss anything!', 'wp-foundation-shortcodes') ?></h3>
	<!-- Facebook like button -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/<?php echo get_locale();?>/sdk.js#xfbml=1&version=v2.4&appId=100591450050015";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div class="fb-like" data-href="https://www.facebook.com/wp.foundation.shortcodes" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>


	<h3>2. <?php _e('We love stars', 'wp-foundation-shortcodes') ?></h3>
	<p><figure><img src="<?php echo WP_FOUNDATION_SHORTCODES_URL;?>images/stars.png" alt="5 stars" width="134" height="28"></figure></p>
	<p><?php echo sprintf( __('Please write %s review %s', 'wp-foundation-shortcodes'), '<a href="https://wordpress.org/support/view/plugin-reviews/wp-foundation-shortcodes" target="_blank">', '</a>');?></p>

	<h3>3. <?php _e('Please help us to continue develop this free wordpress plug-in', 'wp-foundation-shortcodes') ?></h3>
	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GX2LMF9946LEE" target="_blank"><img src="<?php echo WP_FOUNDATION_SHORTCODES_URL;?>images/paypal_donate_button217x50.png" width="217" height="50" alt="paypal donate button"></a>

	<hr>

	<form method="post" action="<?php echo admin_url('options.php');?>">
                <?php settings_fields( 'wp-foundation-shortcodes-options' ); ?>
                <?php do_settings_sections( 'wp-foundation-shortcodes-options' ); ?>
                <table class="form-table">
                <tr>
                        <th scope="row"><label for="enable-google-map"><?php _e('Enable Google Map', 'wp-foundation-shortcodes')?></label></th>
                        <?php
                                $checked = (get_option('enable-google-map')) ? 'checked="checked"' : '' ;
                        ?>
                        <td><input type="checkbox" id="enable-google-map" name="enable-google-map" value="true" <?php echo $checked;?>></td>
                </tr>
                <tr>
                        <th scope="row"><label for="enable-slick-slider"><?php _e('Enable Slick Slider', 'wp-foundation-shortcodes')?></label></th>
                        <?php
                                $checked = (get_option('enable-slick-slider')) ? 'checked="checked"' : '' ;
                        ?>
                        <td><input type="checkbox" id="enable-slick-slider" name="enable-slick-slider" value="true" <?php echo $checked;?>></td>
                </tr>
		<tr>
                        <th scope="row"><label for="enable-fontawesome"><?php _e('Enable Font Awesome', 'wp-foundation-shortcodes')?></label></th>
                        <?php
                                $checked = (get_option('enable-fontawesome')) ? 'checked="checked"' : '' ;
                        ?>
                        <td><input type="checkbox" id="enable-fontawesome" name="enable-fontawesome" value="true" <?php echo $checked;?>></td>
                </tr>
                </table>
                <p><?php _e('You should enable it to work <strong>[google_map]</strong>, <strong>[slick_slider]</strong> shortcodes and font awesome icons (some theme load font awesome by default). It is important to not upload unnecessary CSS and JS.', 'wp-foundation-shortcodes')?></p>

	    <?php submit_button(); ?>

	</form>


</div>
