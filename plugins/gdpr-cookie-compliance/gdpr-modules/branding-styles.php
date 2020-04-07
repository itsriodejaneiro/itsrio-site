<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
?>
<style id="gdpr_cookie_compliance_inline_styles" type='text/css'>
	<?php
		$primary_colour     = $content->primary_colour;
		$secondary_colour   = $content->secondary_colour;
		$button_bg          = $content->button_bg;
		$button_hover_bg    = $content->button_hover_bg;
		$button_font        = $content->button_font;
		$font_family        = $content->font_family;

		$moove_gdpr_cnt = new Moove_GDPR_Controller();
		echo $moove_gdpr_cnt->get_minified_styles( $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font, $font_family  );
	?>
</style>