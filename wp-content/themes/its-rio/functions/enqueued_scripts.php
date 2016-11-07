<?php

function its_styles() {
	wp_enqueue_style( 'foundation', esc_url_raw('/wp-content/themes/its-rio/assets/css/foundation.min.css'), array(), null );
	wp_enqueue_style( 'its', esc_url_raw('/wp-content/themes/its-rio/assets/css/its.css'), array(), null );
}

add_action('wp_enqueue_scripts', 'its_styles');