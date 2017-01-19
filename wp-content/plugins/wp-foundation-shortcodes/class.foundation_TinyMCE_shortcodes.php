<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

/**
 * TinyMCE Shortcode Integration
 */
if ( !class_exists('WP_Foundation_TinyMCE_Shortcodes') ) {

class WP_Foundation_TinyMCE_Shortcodes {

	function __construct() {
		// Init
                add_action( 'admin_init', array( $this, 'init' ) );

                // wp_ajax_... is only run for logged users.
                add_action( 'wp_ajax_wp_foundation_shortcodes_check_url_action', array( $this, 'ajax_action_check_url' ) );
                add_action( 'wp_ajax_p_foundation_shortcodes_shortcodes_nonce', array( $this, 'ajax_action_generate_nonce' ) );

                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );

                // Output the markup in the footer.
                add_action( 'admin_footer', array( $this, 'output_dialog_markup' ) );
	}
	
	// get everything started
        function init() {
                global $pagenow;

                if ( ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) == 'true' && ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' ) ) ) )  {

                       // Add the tinyMCE buttons and plugins.
                       add_filter( 'mce_buttons', array( $this, 'filter_mce_buttons' ) );
                       add_filter( 'mce_external_plugins', array( $this, 'filter_mce_external_plugins' ) );

                       wp_enqueue_style( 'tinymce-shortcodes', WP_FOUNDATION_SHORTCODES_URL . 'admin/css/tinymce-shortcodes.css', false, WP_FOUNDATION_SHORTCODES_VERSION, 'all' );
                }
        }

	// add new button to the tinyMCE editor
        function filter_mce_buttons( $buttons ) {
	        array_push( $buttons, '|', 'wp_foundation_shortcodes_shortcodes_button' );
                return $buttons;
        }

	// add functionality to the tinyMCE editor as an external plugin
        function filter_mce_external_plugins( $plugins ) {
 	       global $wp_version;
               $plugins['FoundationTinyMCEShortcodes'] = wp_nonce_url( esc_url( WP_FOUNDATION_SHORTCODES_URL . 'admin/shortcodes/editor.js?v=0.2' ), 'wp-foundation-shortcodes-tinymce-shortcodes' );
               return $plugins;
        }

	// checks if a given url (via GET or POST) exists
        function ajax_action_check_url() {
	        $hadError = true;
                $url = isset( $_REQUEST['url'] ) ? $_REQUEST['url'] : '';
                if ( strlen( $url ) > 0  && function_exists( 'get_headers' ) ) {
		        $url = esc_url( $url );
                        $file_headers = @get_headers( $url );
                        $exists = $file_headers && $file_headers[0] != 'HTTP/1.1 404 Not Found';
                        $hadError = false;
                }
                echo '{ "exists": '. ($exists ? '1' : '0') . ($hadError ? ', "error" : 1 ' : '') . ' }';
                die();
        }

	// generate a nonce
        function ajax_action_generate_nonce() {
	        echo wp_create_nonce( 'wp-foundation-shortcodes-tinymce-shortcodes' );
                die();
        }

        function enqueue_scripts() {
	        wp_register_script( 'tinymce-dialog-script', plugins_url( 'admin/shortcodes/dialog.js', __FILE__ ), array( 'jquery' ), WP_FOUNDATION_SHORTCODES_VERSION, true );
                wp_enqueue_script( 'tinymce-dialog-script' );
                $plugin_data = array(
         	       'url' => WP_FOUNDATION_SHORTCODES_URL,
                );
	        wp_localize_script( 'tinymce-dialog-script', 'plugin_data', $plugin_data );
        }
	
        // Output the HTML markup for the dialog box.
        function output_dialog_markup () {
	        // URL to TinyMCE plugin folder
                $plugin_url = WP_FOUNDATION_SHORTCODES_URL . '/includes/shortcodes/'; ?>

                <div id="dialog" style="display:none">
        	        <div class="buttons-wrapper">
                               <input type="button" id="cancel-button" class="button alignleft" name="cancel" value="<?php _e('Cancel', 'wp-foundation-shortcodes') ?>" accesskey="C" />
                 	       <input type="button" id="insert-button" class="button-primary alignright" name="insert" value="<?php _e('Insert', 'wp-foundation-shortcodes') ?>" accesskey="I" />
                               <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <h3 class="sc-options-title"><?php _e('Shortcode Options', 'wp-foundation-shortcodes') ?></h3>
                        <div id="shortcode-options" class="alignleft">
	                        <table id="options-table"></table>
                                <input type="hidden" id="selected-shortcode" value="">
                        </div>
                        <div class="clear"></div>
                </div><!-- /#dialog -->
        <?php }

}
}
