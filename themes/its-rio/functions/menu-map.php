<?php 

add_action('admin_menu', 'its_wp_map');

function its_wp_map() {
	add_menu_page('Mapa', 'Mapa Institucional', 'administrator', __FILE__, 'wp_map_settings', '' );
	// add_action( 'admin_init', 'register_its_wp_map' );
}

// function register_its_wp_map() {
	// register_setting( 'wp_map_settings', 'map' );
// 	register_setting( 'wp_map_settings', 'footer_adress' );
// 	register_setting( 'wp_map_settings', 'footer_description' );
// }

function wp_map_settings() {
	?>
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js'></script>
	<link rel="stylesheet" href="/wp-content/themes/its-rio/assets/css/wp-map.css">
	<div class="wrap" id="map-vue-container">
		<h1>Mapas</h1>
		<?php include ROOT.'functions/components/map/view_wp_map.php' ?>
	</div>
	<?php 
}