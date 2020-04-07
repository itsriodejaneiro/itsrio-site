<?php
	
function fca_pc_splash_page() {
	add_submenu_page(
		null,
		__('Activate', 'facebook-conversion-pixel'),
		__('Activate', 'facebook-conversion-pixel'),
		'manage_options',
		'pixel-cat-splash',
		'fca_pc_render_splash_page'
	);
}
add_action( 'admin_menu', 'fca_pc_splash_page' );

function fca_pc_render_splash_page() {
		
	wp_enqueue_style('fca_pc_splash_css', FCA_PC_PLUGINS_URL . '/includes/splash/splash.min.css', false, FCA_PC_PLUGIN_VER );
	wp_enqueue_script('fca_pc_splash_js', FCA_PC_PLUGINS_URL . '/includes/splash/splash.min.js', false, FCA_PC_PLUGIN_VER, true );
		
	$user = wp_get_current_user();
	$name = empty( $user->user_firstname ) ? '' : $user->user_firstname;
	$email = $user->user_email;
	$site_link = '<a href="' . get_site_url() . '">'. get_site_url() . '</a>';
	$website = get_site_url();
	
	echo '<form method="post" action="' . admin_url( '/admin.php?page=pixel-cat-splash' ) . '">';
		echo '<div id="fca-logo-wrapper">';
			echo '<div id="fca-logo-wrapper-inner">';
				echo '<img id="fca-logo-text" src="' . FCA_PC_PLUGINS_URL . '/assets/fatcatapps-logo-text.png' . '">';
			echo '</div>';
		echo '</div>';
		
		echo "<input type='hidden' name='fname' value='$name'>";
		echo "<input type='hidden' name='email' value='$email'>";
		
		echo '<div id="fca-splash">';
			echo '<h1>' . __( 'Welcome to Pixel Cat', 'facebook-conversion-pixel' ) . '</h1>';
			
			echo '<div id="fca-splash-main" class="fca-splash-box">';
				echo '<p id="fca-splash-main-text">' .  sprintf ( __( 'In order to enjoy all our features and functionality, Pixel Cat needs to connect %1$s your user, %2$s at %3$s, to <strong>api.fatcatapps.com</strong>.', 'facebook-conversion-pixel' ), '<br>', '<strong>' . $name . '</strong>', '<strong>' . $website . '</strong>'  ) . '</p>';
				echo "<button type='submit' id='fca-pc-submit-btn' class='fca-pc-button button button-primary' name='fca-pc-submit-optin' >" . __( 'Connect Pixel Cat', 'facebook-conversion-pixel') . "</button><br>";
				echo "<button type='submit' id='fca-pc-optout-btn' name='fca-pc-submit-optout' >" . __( 'Skip This Step', 'facebook-conversion-pixel') . "</button>";
			echo '</div>';
			
			echo '<div id="fca-splash-permissions" class="fca-splash-box">';
				echo '<a id="fca-splash-permissions-toggle" href="#" >' . __( 'What permission is being granted?', 'facebook-conversion-pixel' ) . '</a>';
				echo '<div id="fca-splash-permissions-dropdown" style="display: none;">';
					echo '<h3>' .  __( 'Your Website Info', 'facebook-conversion-pixel' ) . '</h3>';
					echo '<p>' .  __( 'Your URL, WordPress version, plugins & themes. This data lets us make sure this plugin always stays compatible with the most popular plugins and themes.', 'facebook-conversion-pixel' ) . '</p>';
					
					echo '<h3>' .  __( 'Your Info', 'facebook-conversion-pixel' ) . '</h3>';
					echo '<p>' .  __( 'Your name and email.', 'facebook-conversion-pixel' ) . '</p>';
					
					echo '<h3>' .  __( 'Plugin Usage', 'facebook-conversion-pixel' ) . '</h3>';
					echo '<p>' .  __( "How you use this plugin's features and settings. This is limited to usage data, and does not include your Facebook Pixel Data. This data helps us learn which features are most popular, so we can improve the plugin further.", 'facebook-conversion-pixel' ) . '</p>';				
				echo '</div>';
			echo '</div>';
			

		echo '</div>';
	
	echo '</form>';
	
	echo '<div id="fca-splash-footer">';
		echo '<a target="_blank" href="https://fatcatapps.com/legal/terms-service/">' . _x( 'Terms', 'as in terms and conditions', 'facebook-conversion-pixel' ) . '</a> | <a target="_blank" href="https://fatcatapps.com/legal/privacy-policy/">' . _x( 'Privacy', 'as in privacy policy', 'facebook-conversion-pixel' ) . '</a>';
	echo '</div>';
}

function fca_pc_admin_redirects() {

	if ( isset( $_POST['fca-pc-submit-optout'] ) ) {
		update_option( 'fca_pc_activation_status', 'disabled' );
		wp_redirect( admin_url( '/admin.php?page=fca_pc_settings_page' ) );
		exit;
	} else if ( isset( $_POST['fca-pc-submit-optin'] ) ) {
		update_option( 'fca_pc_activation_status', 'active' );
		
		$email = urlencode ( sanitize_email ( $_POST['email'] ) );
		$name = urlencode ( esc_textarea ( $_POST['fname'] ) );
		$product = 'pixelcat';
		$url =  "https://api.fatcatapps.com/api/activate.php?email=$email&fname=$name&product=$product";
		$return = wp_remote_get( $url );
	
		wp_redirect( admin_url( '/admin.php?page=fca_pc_settings_page' ) );
		exit;
	}
	
	$status = get_option( 'fca_pc_activation_status' );
	if ( empty($status) && isset( $_GET['page'] ) &&$_GET['page'] === 'fca_pc_settings_page' ) {
        wp_redirect( admin_url( '/admin.php?page=pixel-cat-splash' ) );
		exit;
    }

}
add_action('admin_init', 'fca_pc_admin_redirects');

