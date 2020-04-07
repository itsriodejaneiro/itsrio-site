<?php

function fca_pc_landingpagecat_events() {
	wp_localize_script( 'fca_pc_client_js', 'fcaPcLandingPageCatEnabled', array('true') );
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_landingpagecat_events' );