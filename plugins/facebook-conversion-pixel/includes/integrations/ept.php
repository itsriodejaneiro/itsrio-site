<?php

function fca_pc_ept_events() {
	wp_localize_script( 'fca_pc_client_js', 'fcaPcEptEnabled', array('true') );
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_ept_events' );