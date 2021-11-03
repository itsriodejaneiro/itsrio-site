<?php
/**
 * Facebook Instant Articles for WP.
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * @package default
 */

use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\InstantArticleStatus;
use Facebook\InstantArticles\Client\ServerMessage;
use Facebook\Exceptions\FacebookResponseException;

/**
 * Class responsible for drawing the meta box on the post edit page
 *
 * @since 0.1
 */
class Instant_Articles_Meta_Box {

	/**
	 * Initiator for Metabox.
	 */
	public static function init() {
		add_action( 'add_meta_boxes', array( 'Instant_Articles_Meta_Box', 'register_meta_box' ) );
		add_action(
			'wp_ajax_instant_articles_meta_box',
			array( 'Instant_Articles_Meta_Box', 'render_meta_box' )
		);
		add_action(
			'wp_ajax_instant_articles_force_submit',
			array( 'Instant_Articles_Meta_Box', 'force_submit' )
		);
	}

	/**
	 * Register Meta Box renderer.
	 */
	public static function register_meta_box() {
		add_meta_box(
			'instant_article_meta_box',
			'Facebook Instant Articles',
			array( 'Instant_Articles_Meta_Box', 'render_meta_box_loader' ),

			/** This filter is defined in facebook-instant-articles.php. */
			apply_filters( 'instant_articles_post_types', array( 'post' ) ),
			'normal',
			'default'
		);
	}

	/**
	 * Includes the template for Metabox.
	 *
	 * @param Post $post the post request content.
	 */
	public static function render_meta_box_loader( $post ) {
		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}

		include( dirname( __FILE__ ) . '/meta-box-loader-template.php' );
	}

	/**
	 * Renderer for the Metabox.
	 */
	public static function force_submit() {
		$post_id = intval( $_POST[ 'post_ID' ] );

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( -1, 403 );
		}

		check_ajax_referer( 'instant-articles-force-submit-' . $post_id, 'security' );
		$force = sanitize_text_field( $_POST[ 'force' ] ) === 'true';
		update_post_meta( $post_id, Instant_Articles_Publisher::FORCE_SUBMIT_KEY, $force );
		Instant_Articles_Publisher::submit_article( $post_id, get_post( $post_id ) );
	}

	/**
	 * Renderer for the Metabox.
	 */
	public static function render_meta_box() {
		$post_id = intval( $_POST[ 'post_ID' ] );

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			wp_die( -1, 403 );
		}

		$ajax_nonce = wp_create_nonce( "instant-articles-force-submit-" . $post_id );
		$post = get_post( $post_id );
		$adapter = new Instant_Articles_Post( $post );
		$article = $adapter->to_instant_article();
		$canonical_url = $adapter->get_canonical_url();
		$submission_status = null;
		$published = 'publish' === $post->post_status;
		$dev_mode = false;
		$force_submit = get_post_meta( $post_id, Instant_Articles_Publisher::FORCE_SUBMIT_KEY, true );
		$should_submit_post = apply_filters( 'instant_articles_should_submit_post', true, $adapter );

		Instant_Articles_Wizard::menu_items();
		$settings_page_href = Instant_Articles_Wizard::get_url();

		$publishing_settings = Instant_Articles_Option_Publishing::get_option_decoded();
		$publish_with_warnings = $publishing_settings[ 'publish_with_warnings' ];
		if ( $published ) {
			try {
				$fb_app_settings = Instant_Articles_Option_FB_App::get_option_decoded();
				$fb_page_settings = Instant_Articles_Option_FB_Page::get_option_decoded();
				$publishing_settings = Instant_Articles_Option_Publishing::get_option_decoded();

				$dev_mode = isset( $publishing_settings['dev_mode'] )
					? ( $publishing_settings['dev_mode'] ? true : false )
					: false;

				if ( isset( $fb_app_settings['app_id'] )
					&& isset( $fb_app_settings['app_secret'] )
					&& isset( $fb_page_settings['page_access_token'] )
					&& isset( $fb_page_settings['page_id'] ) ) {
					// Instantiate a new Client to get the status of this article.
					$client = Client::create(
						$fb_app_settings['app_id'],
						$fb_app_settings['app_secret'],
						$fb_page_settings['page_access_token'],
						$fb_page_settings['page_id'],
						$dev_mode
					);

					$submission_status_id = get_post_meta( $post_id, Instant_Articles_Publisher::SUBMISSION_ID_KEY, true );
					if ( ! empty( $submission_status_id ) ) {
						$submission_status = $client->getSubmissionStatus( $submission_status_id );
					} else {
						// Grab the latest status of this article and display.
						$article_id = $client->getArticleIDFromCanonicalURL( $canonical_url );
						$submission_status = $client->getLastSubmissionStatus( $article_id );
					}
				}
			} catch ( FacebookResponseException $e ) {
				$submission_status = null;
			}
		}

		include( dirname( __FILE__ ) . '/meta-box-template.php' );

		die();
	}
}
