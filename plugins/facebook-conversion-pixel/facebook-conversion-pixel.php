<?php
/*
	Plugin Name: Pixel Cat Lite
	Plugin URI: https://fatcatapps.com/pixel-cat
	Description: Provides an easy way to embed Facebook pixels
	Text Domain: facebook-conversion-pixel
	Domain Path: /languages
	Author: Fatcat Apps
	Author URI: https://fatcatapps.com/
	License: GPLv2
	Version: 2.5.2
*/


// BASIC SECURITY
defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );



$has_legacy_save = get_option( 'fb_pxl_options', false ) != false;
$upgraded = get_option( 'fca_pc_upgrade_complete' );

if ( !$upgraded && $has_legacy_save ) {

	include_once( plugin_dir_path( __FILE__ ) . '/deprecated/facebook-conversion-pixel.php' );

	//ADD NAG
	function fca_pc_admin_deprecated_notice() {
		$dismissed_deprecated_notice = get_option( 'fca_pc_deprecated_dismissed', false );

		if ( isSet( $_GET['fca_pc_upgrade'] ) && current_user_can('manage_options') ) {
			update_option( 'fca_pc_upgrade_complete', true );
			update_option( 'fca_pc_after_upgrade_info', true );
			echo '<script>window.location="' . admin_url('admin.php?page=fca_pc_settings_page') . '"</script>';
			exit;
		}
		if ( isSet( $_GET['fca_pc_dismiss_upgrade'] ) && current_user_can('manage_options') ) {
			update_option( 'fca_pc_deprecated_dismissed', true );
			if ( $_GET['fca_pc_dismiss_upgrade'] === 'later' ) {
				//remind in a week
				wp_schedule_single_event( current_time( 'timestamp' ) + 604800, 'fca_pc_clear_dismissal_action' );
			}
		} else if ( $dismissed_deprecated_notice != true && current_user_can('manage_options') ) {
			$upgrade_url = admin_url( 'options-general.php?page=fb_pxl_options&fca_pc_upgrade=true' );
			$retired_url = 'https://www.facebook.com/business/help/1686199411616919';
			$dismiss_url = add_query_arg( 'fca_pc_dismiss_upgrade', 'true' );
			$remind_url = add_query_arg( 'fca_pc_dismiss_upgrade', 'later' );
			$read_more_url = 'https://fatcatapps.com/migrate-new-facebook-pixel/';

			echo '<div id="fca-pc-setup-notice" class="notice notice-success is-dismissible" style="padding-bottom: 8px; padding-top: 8px;">';
				echo '<img style="float:left; margin-right: 16px;" height="120" width="120" src="' . plugins_url( '', __FILE__ ) . '/assets/pixelcat_icon_128_128_360.png' . '">';
				echo '<p style="margin-top: 0;"><strong>' .  __( "Facebook Conversion Pixel: ", 'facebook-conversion-pixel' ) . '</strong>' .  __( "Thanks for updating. We've renamed this plugin to <strong>Pixel Cat</strong> and now support the <strong>new Facebook Pixel. ", 'facebook-conversion-pixel' ) . '</strong></p>';
				echo "<p>Facebook <a href='$retired_url' target='_blank'>" .  __( "has retired the Facebook Conversion Pixel", 'facebook-conversion-pixel' ) . '</a> ' . __( "in favor of the new Facebook Pixel, so we recommend upgrading. Don't worry, you can revert back with one click, and we'll keep your settings.", 'facebook-conversion-pixel') . '</p>';
				echo '<p style="font-style: italic;" >' . __( "Please note: moving to the new Facebook Pixel will require a couple minutes of setup from you. ", 'facebook-conversion-pixel' ) . "<a target='_blank' href='$read_more_url'>" . __( 'Click here for instructions', 'facebook-conversion-pixel' ) . '</a>.</p>';
				echo "<a style='margin-right: 16px;' href='$upgrade_url' class='button button-primary'>" . __( 'Upgrade', 'facebook-conversion-pixel') . "</a> ";
				echo "<a style='margin-right: 16px; position: relative;	top: 4px;' href='$remind_url'>" . __( 'Remind me next week', 'facebook-conversion-pixel') . "</a> ";
				echo "<a style='margin-right: 16px; position: relative;	top: 4px;' href='$dismiss_url'>" . __( 'No, thanks', 'facebook-conversion-pixel') . "</a> ";
				echo '<br style="clear:both">';
			echo '</div>';
		}
	}
	add_action( 'admin_notices', 'fca_pc_admin_deprecated_notice' );

	function fca_pc_clear_dismissal() {
		update_option( 'fca_pc_deprecated_dismissed', false );
	}
	add_action( 'fca_pc_clear_dismissal_action' , 'fca_pc_clear_dismissal' );


} else if ( !defined('FCA_PC_PLUGIN_DIR') ) {

	//DEFINE SOME USEFUL CONSTANTS
	define( 'FCA_PC_DEBUG', FALSE );
	define( 'FCA_PC_PLUGIN_VER', '2.5.2' );
	define( 'FCA_PC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'FCA_PC_PLUGINS_URL', plugins_url( '', __FILE__ ) );
	define( 'FCA_PC_PLUGINS_BASENAME', plugin_basename(__FILE__) );
	define( 'FCA_PC_PLUGIN_FILE', __FILE__ );
	define( 'FCA_PC_PLUGIN_PACKAGE', 'Lite' ); //DONT CHANGE THIS - BREAKS AUTO UPDATER
	define( 'FCA_PC_PLUGIN_NAME', 'Pixel Cat Premium: ' . FCA_PC_PLUGIN_PACKAGE );

	//LOAD CORE
	include_once( FCA_PC_PLUGIN_DIR . '/includes/functions.php' );
	include_once( FCA_PC_PLUGIN_DIR . '/includes/api.php' );

	$options = get_option( 'fca_pc', array() );

	//LOAD OPTIONAL MODULES
	if ( !empty( $options['woo_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/woo-events.php' ) && $options['search_integration'] == 'on' ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/woo-events.php' );
	}
	if ( !empty( $options['woo_feed'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/woo-feed.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/woo-feed.php' );
	}
	if ( !empty( $options['edd_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/edd-events.php' ) && $options['search_integration'] == 'on' ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/edd-events.php' );
	}
	if ( !empty( $options['edd_feed'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/edd-feed.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/edd-feed.php' );
	}
	if ( !empty( $options['quizcat_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/quizcat.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/quizcat.php' );
	}
	if ( !empty( $options['optincat_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/optincat.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/optincat.php' );
	}
	if ( !empty( $options['landingpagecat_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/landingpagecat.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/landingpagecat.php' );
	}
	if ( !empty( $options['ept_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/ept.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/ept.php' );
	}
	if ( !empty( $options['amp_integration'] ) && file_exists ( FCA_PC_PLUGIN_DIR . '/includes/integrations/amp.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/integrations/amp.php' );
	}

	//LOAD MODULES
	include_once( FCA_PC_PLUGIN_DIR . '/includes/editor/editor.php' );
	if ( file_exists ( FCA_PC_PLUGIN_DIR . '/includes/editor/editor-premium.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/editor/editor-premium.php' );
	}

	/* TEMPORARILY DISABLED
	if ( file_exists ( FCA_PC_PLUGIN_DIR . '/includes/splash/splash.php' ) ) {
		//include_once( FCA_PC_PLUGIN_DIR . '/includes/splash/splash.php' );
	}
	*/

	if ( file_exists ( FCA_PC_PLUGIN_DIR . '/includes/licensing/licensing.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/licensing/licensing.php' );
	}

	if ( file_exists ( FCA_PC_PLUGIN_DIR . '/includes/upgrade.php' ) ) {
		include_once( FCA_PC_PLUGIN_DIR . '/includes/upgrade.php' );
	}

	if ( FCA_PC_PLUGIN_PACKAGE === 'Lite' ) {
		//ACTIVATION HOOK
		function fca_pc_activation() {
			fca_pc_api_action( 'Activated Pixel Cat Free' );
		}
		register_activation_hook( FCA_PC_PLUGIN_FILE, 'fca_pc_activation' );

		//DEACTIVATION HOOK
		function fca_pc_deactivation() {
			fca_pc_api_action( 'Deactivated Pixel Cat Free' );
		}
		register_deactivation_hook( FCA_PC_PLUGIN_FILE, 'fca_pc_deactivation' );
	}


	//INSERT PIXEL
	function fca_pc_maybe_add_pixel() {

		$options = get_option( 'fca_pc', array() );

		$pixel = empty ( $options['id'] ) ? '' : $options['id'];

		$roles = wp_get_current_user()->roles;
		$exclude = empty ( $options['exclude'] ) ? array() : $options['exclude'];
		$roles_check_passed = 0 === count( array_intersect( array_map( 'strtolower', $roles ), array_map( 'strtolower', $exclude ) ) );

		if ( $roles_check_passed ) {

			//HOOK IN OTHER INTEGRATIONS/FEATURES
			do_action( 'fca_pc_start_pixel_output', $options );

			wp_enqueue_script('jquery');
			wp_enqueue_script('fca_pc_client_js');

			if ( FCA_PC_DEBUG ) {
				//INCLUDE VIDEO.COMPILED.JS FOR DEVELOPMENT
				wp_enqueue_script( 'fca_pc_video_js', FCA_PC_PLUGINS_URL . '/video.js', array(), false, true );
			} else {
				wp_enqueue_script( 'fca_pc_video_js', FCA_PC_PLUGINS_URL . '/video.compiled.js', array(), false, true );
			}

			wp_localize_script( 'fca_pc_client_js', 'fcaPcEvents', fca_pc_get_active_events() );
			wp_localize_script( 'fca_pc_client_js', 'fcaPcDebug', array( 'debug' => FCA_PC_DEBUG ) );
			wp_localize_script( 'fca_pc_client_js', 'fcaPcPost', fca_pc_post_parameters() );

			//ONLY USE DEFAULT SEARCH IF WE DIDNT USE WOO OR EDD SPECIFIC
			if ( is_search() && $options['search_integration'] == 'on' ) {
				wp_localize_script( 'fca_pc_client_js', 'fcaPcSearchQuery', array( 'search_string' => get_search_query() ) );
			}
			if ( !empty( $options['user_parameters'] ) ) {
				wp_localize_script( 'fca_pc_client_js', 'fcaPcUserParams', fca_pc_user_parameters() );
			}

			ob_start(); ?>

			<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','https://connect.facebook.net/en_US/fbevents.js');
			<?php echo fca_pc_pixel_init( $options ) ?>
			fbq('track', 'PageView');

			</script>
			<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=<?php echo $pixel ?>&ev=PageView&noscript=1"
			/></noscript>
			<!-- DO NOT MODIFY -->
			<!-- End Facebook Pixel Code -->

			<?php
			echo ob_get_clean();
		}
	}
	add_action('wp_head', 'fca_pc_maybe_add_pixel', 1);

	function fca_pc_pixel_init( $options ) {

		$code = '';
		$advanced_matching = empty( $options['advanced_matching'] ) ? false : true;

		$og_pixel = empty ( $options['id'] ) ? '' : $options['id'];

		if ( $advanced_matching ) {
			$code .= "fbq('init', '$og_pixel', " . fca_pc_advanced_matching()  . " );";
		} else {
			$code .= "fbq('init', '$og_pixel' );";
		}


		if ( isset( $options['ids'] ) && is_array( $options['ids'] ) ) {
			forEach ( $options['ids'] as $pixel ) {

				if ( $advanced_matching ) {
					$code .= "fbq('init', '$pixel', " . fca_pc_advanced_matching()  . " );";
				} else {
					$code .= "fbq('init', '$pixel' );";
				}

			}
		}

		return $code;
	}

	function fca_pc_register_scripts() {
		if ( FCA_PC_DEBUG ) {
			wp_register_script('fca_pc_client_js', FCA_PC_PLUGINS_URL . '/pixel-cat.js', array('jquery'), FCA_PC_PLUGIN_VER, true );
		} else {
			wp_register_script('fca_pc_client_js', FCA_PC_PLUGINS_URL . '/pixel-cat.min.js', array('jquery'), FCA_PC_PLUGIN_VER, true );
		}
	}
	add_action('init', 'fca_pc_register_scripts' );

	function fca_pc_add_plugin_action_links( $links ) {

		$configure_url = admin_url('admin.php?page=fca_pc_settings_page');
		$support_url = FCA_PC_PLUGIN_PACKAGE === 'Lite' ? 'https://wordpress.org/support/plugin/facebook-conversion-pixel' : 'https://fatcatapps.com/support';

		$new_links = array(
			'configure' => "<a href='$configure_url' >" . __('Configure Pixel', 'facebook-conversion-pixel' ) . '</a>',
			'support' => "<a target='_blank' href='$support_url' >" . __('Support', 'facebook-conversion-pixel' ) . '</a>'
		);

		$links = array_merge( $new_links, $links );

		return $links;

	}
	add_filter( 'plugin_action_links_' . FCA_PC_PLUGINS_BASENAME, 'fca_pc_add_plugin_action_links' );

	// LOCALIZATION
	function fca_pc_load_localization() {
		load_plugin_textdomain( 'pixel-cat', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	add_action( 'init', 'fca_pc_load_localization' );

	//ADD NAG IF NO PIXEL IS SET
	function fca_pc_admin_notice() {

		$show_upgrade_info = get_option( 'fca_pc_after_upgrade_info', false );

		if ( isSet( $_GET['fca_pc_dismiss_upgrade_info'] ) && current_user_can('manage_options') ) {
			$show_upgrade_info = false;
			update_option( 'fca_pc_after_upgrade_info', false );
		}

		if ( $show_upgrade_info ) {
			$settings_url = admin_url( 'admin.php?page=fca_pc_settings_page' );
			$read_more_url = 'https://fatcatapps.com/migrate-new-facebook-pixel/';
			$dismiss_url = add_query_arg( 'fca_pc_dismiss_upgrade_info', true );

			echo '<div id="fca-pc-setup-notice" class="notice notice-success is-dismissible" style="padding-bottom: 8px; padding-top: 8px;">';
				echo '<p style="margin-top: 0;"><strong>' .  __( "Pixel Cat: ", 'facebook-conversion-pixel' ) . '</strong>' .  __( "Thanks for upgrading to the new Facebook Pixel. We've prepared a handy guide that explains what you'll need to do to complete setup.", 'facebook-conversion-pixel' ) . '</p>';
				echo '<p>'.  __( "Want to revert to the old Facebook Conversion Pixel? Go to your", 'facebook-conversion-pixel' ) . " <a href='$settings_url'>" . __( "Facebook Pixel settings</a> and click 'Click here to downgrade' at the very bottom of the screen.", 'facebook-conversion-pixel' ) . '</p>';
				echo "<a style='margin-right: 16px; margin-top: 32px;' href='$read_more_url' class='button button-primary' target='_blank' >" . __( 'Read the Facebook Pixel migration guide', 'facebook-conversion-pixel') . "</a> ";
				echo "<a style='margin-right: 16px; position: relative;	top: 36px;' href='$dismiss_url'>" . __( 'Close', 'facebook-conversion-pixel') . "</a> ";
				echo '<br style="clear:both">';
			echo '</div>';

		}

		$dismissed = get_option( 'fca_pc_no_pixel_dismissed', false );
		$options = get_option( 'fca_pc', array() );
		$screen = get_current_screen();

		if ( isSet( $_GET['fca_pc_dismiss_no_pixel'] ) && current_user_can('manage_options') ) {
			$dismissed = true;
			update_option( 'fca_pc_no_pixel_dismissed', true );
		}

		if ( !$dismissed && empty( $options['id'] ) && $screen->id != 'toplevel_page_fca_pc_settings_page'  ) {
			$url = admin_url( 'admin.php?page=fca_pc_settings_page' );
			$dismiss_url = add_query_arg( 'fca_pc_dismiss_no_pixel', true );

			echo '<div id="fca-pc-setup-notice" class="notice notice-success is-dismissible" style="padding-bottom: 8px; padding-top: 8px;">';
				echo '<p><strong>' . __( "Thank you for installing Pixel Cat.", 'facebook-conversion-pixel' ) . '</strong></p>';
				echo '<p>' . __( "It looks like you haven't configured your Facebook Pixel yet. Ready to get started?", 'facebook-conversion-pixel' ) . '</p>';
				echo "<a href='$url' class='button button-primary' style='margin-top: 25px;'>" . __( 'Set up my Pixel', 'facebook-conversion-pixel') . "</a> ";
				echo "<a style='position: relative; top: 30px; left: 16px;' href='$dismiss_url' >" . __( 'Dismiss', 'facebook-conversion-pixel') . "</a> ";
				echo '<br style="clear:both">';
			echo '</div>';
		}

	}
	add_action( 'admin_notices', 'fca_pc_admin_notice' );

	//ADD DOWNGRADE LINK
	function fca_pc_admin_footer( $text ) {
		$screen = get_current_screen();
		$has_legacy_save = get_option( 'fb_pxl_options', false ) != false;
		if ( $has_legacy_save && $screen->id == 'toplevel_page_fca_pc_settings_page' && FCA_PC_PLUGIN_PACKAGE === 'Lite' ) {
			$downgrade_url = admin_url( 'admin.php?page=fca_pc_settings_page&fca_pc_downgrade=true' );
			$text = __('Looking for the old Facebook Conversion Pixel?', 'facebook-conversion-pixel') . " <a href='$downgrade_url'>" . __('Click here to downgrade', 'facebook-conversion-pixel') . '</a>';
		}
		return $text;
	}
	add_filter( 'admin_footer_text', 'fca_pc_admin_footer', 9999, 1 );

	//TURN OFF EDD/WOOCOMMERCE INTEGRATIONS WHEN PLUGINS ARE DISABLED
	function fca_pc_plugin_check( $plugin ) {

		$options = get_option( 'fca_pc', array() );

		if ( $plugin == 'woocommerce/woocommerce.php' ) {
			$options['woo_integration'] = false;
			$options['woo_feed'] = false;
		}
		if ( $plugin == 'easy-digital-downloads/easy-digital-downloads.php' ) {
			$options['edd_integration'] = false;
			$options['edd_feed'] = false;
		}

		update_option( 'fca_pc', $options );

	}
	add_action( 'deactivated_plugin', 'fca_pc_plugin_check', 10, 1 );

	//DEACTIVATION SURVEY
	if ( FCA_PC_PLUGIN_PACKAGE === 'Lite' ) {
		function fca_pc_admin_deactivation_survey( $hook ) {
			if ( $hook === 'plugins.php' ) {

				ob_start(); ?>

				<div id="fca-deactivate" style="position: fixed; left: 232px; top: 191px; border: 1px solid #979797; background-color: white; z-index: 9999; padding: 12px; max-width: 669px;">
					<h3 style="font-size: 14px; border-bottom: 1px solid #979797; padding-bottom: 8px; margin-top: 0;"><?php _e( 'Sorry to see you go', 'facebook-conversion-pixel' ) ?></h3>
					<p><?php _e( 'Hi, this is David, the creator of Pixel Cat. Thanks so much for giving my plugin a try. I’m sorry that you didn’t love it.', 'facebook-conversion-pixel' ) ?>
					</p>
					<p><?php _e( 'I have a quick question that I hope you’ll answer to help us make Pixel Cat better: what made you deactivate?', 'facebook-conversion-pixel' ) ?>
					</p>
					<p><?php _e( 'You can leave me a message below. I’d really appreciate it.', 'facebook-conversion-pixel' ) ?>
					</p>

					<p><textarea style='width: 100%;' id='fca-pc-deactivate-textarea' placeholder='<?php _e( 'What made you deactivate?', 'facebook-conversion-pixel' ) ?>'></textarea></p>

					<div style='float: right;' id='fca-deactivate-nav'>
						<button style='margin-right: 5px;' type='button' class='button button-secondary' id='fca-pc-deactivate-skip'><?php _e( 'Skip', 'facebook-conversion-pixel' ) ?></button>
						<button type='button' class='button button-primary' id='fca-pc-deactivate-send'><?php _e( 'Send Feedback', 'facebook-conversion-pixel' ) ?></button>
					</div>

				</div>

				<?php

				$html = ob_get_clean();

				$data = array(
					'html' => $html,
					'nonce' => wp_create_nonce( 'fca_pc_uninstall_nonce' ),
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				);

				wp_enqueue_script('fca_pc_deactivation_js', FCA_PC_PLUGINS_URL . '/includes/deactivation.min.js', false, FCA_PC_PLUGIN_VER, true );
				wp_localize_script( 'fca_pc_deactivation_js', 'fca_pc', $data );
			}


		}
		add_action( 'admin_enqueue_scripts', 'fca_pc_admin_deactivation_survey' );
	}
}
