<?php

function its_styles() {
	global $data;

	// wp_enqueue_style( 'foundation', esc_url_raw('/wp-content/themes/its-rio/assets/css/foundation.min.css'), array(), null );
	wp_enqueue_script( 'vue', esc_url_raw("https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"), array(), null);

	wp_localize_script( 'vue', 'data', $data );

}

add_action('wp_enqueue_scripts', 'its_styles');