<?php

function fca_pc_optincat_events() {
	wp_localize_script( 'fca_pc_client_js', 'fcaPcOptinCatEnabled', array( 'true' ) );
}
add_action( 'fca_pc_start_pixel_output', 'fca_pc_optincat_events' );