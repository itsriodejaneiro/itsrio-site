<?php
/**
 * Facebook Instant Articles for WP.
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * @package default
 */

use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Elements\Header;
use Facebook\InstantArticles\Elements\Time;
use Facebook\InstantArticles\Elements\Ad;
use Facebook\InstantArticles\Elements\Analytics;
use Facebook\InstantArticles\Elements\Author;
use Facebook\InstantArticles\Elements\Image;
use Facebook\InstantArticles\Elements\Video;
use Facebook\InstantArticles\Elements\Caption;
use Facebook\InstantArticles\Elements\Footer;
use Facebook\InstantArticles\Transformer\Transformer;
/**
 * Class responsible for constructing our content and preparing it for rendering
 *
 * @since 0.1
 */
class Instant_Articles_Post {

	/**
	 * The post
	 *
	 * @var $_post
	 */
	protected $_post = null;

	/**
	 * The post cached content
	 *
	 * @var string $_content
	 */
	protected $_content = null;

	/** @var string The post’s optional subtitle */
	protected $_subtitle = null;

	/**
	 * Instant Article instance object
	 *
	 * @var InstantArticle Last built version of the Instant Article object
	 */
	protected $_instant_article = null;

	/**
	 * Instant Article Transformer instance object
	 *
	 * @var Transformer The Transformer object
	 */
	public $transformer = null;

	/**
	 * Setup data and build the content
	 *
	 * @since 0.1
	 * @param Instant_Article_Post $post ID of the post.
	 */
	public function __construct( $post ) {
		$this->_post = $post;
	}

	/**
	 * Get the ID for this post.
	 *
	 * @since 0.1
	 * @return int The post ID.
	 */
	public function get_the_id() {
		return $this->_post->ID;
	}

	/**
	 * Get the title for this post.
	 *
	 * @since 0.1
	 * @return string The title.
	 */
	public function get_the_title() {
		$title = $this->_post->post_title;

		/**
		 * Apply the default filter 'the_title' for the post title.
		 *
		 * @since 3.1
		 * @param string  $title  The current post title.
		 * @param int     $id     The current post ID.
		 */
		$title = apply_filters( 'the_title', $title, $this->_post->ID );

		/**
		 * Filter the post title for use in instant articles.
		 *
		 * @since 0.1
		 *
		 * @param string $title The current post title.
		 * @param Instant_Article_Post $instant_article_post The instant article post.
		 */
		$title = apply_filters( 'instant_articles_title', $title, $this );

		return $title;
	}

	/**
	 * Get the title for this post.
	 *
	 * @since 0.1
	 * @return string The title.
	 */
	public function get_the_title_rss() {
		$title = $this->get_the_title();

		/**
		 * Apply the default WP Filters for the post title for use in a feed. This ensures proper escaping.
		 *
		 * @since 0.1
		 *
		 * @param string $title The current post title.
		 */
		$title = apply_filters( 'the_title_rss', $title );

		return $title;
	}

	/**
	 * Check if this post has a subtitle
	 *
	 * @since 0.2
	 * @return bool Whether the post has a subtitle or not
	 */
	public function has_subtitle() {

		$has_subtitle = false;

		$subtitle = $this->get_the_subtitle();

		if ( strlen( $subtitle ) ) {
			$has_subtitle = true;
		}

		return $subtitle;
	}

	/**
	 * Get the subtitle for this post
	 *
	 * @since 0.2
	 * @return string The subtitle
	 */
	public function get_the_subtitle() {

		// If we have already been through this function, we’ll have the result stored here
		if ( ! is_null( $this->_subtitle ) ) {
			return $this->_subtitle;
		}

		$subtitle = '';

		/**
		 * Filter the subtitle for use in instant articles
		 *
		 * @since 0.2
		 *
		 * @param string                 $subtitle              The current subtitle for the post.
		 * @param Instant_Article_Post   $instant_article_post  The instant article post
		 */
		$subtitle = apply_filters( 'instant_articles_subtitle', $subtitle, $this );

		$this->_subtitle = $subtitle;

		return $subtitle;
	}

	/**
	 * Get the excerpt for this post.
	 *
	 * @since 0.1
	 * @return string  The excerpt.
	 */
	public function get_the_excerpt() {

		$post = get_post( $this->get_the_id() );

		// This should ideally not happen, but it may do so if someone tampers with the query.
		// Returning the same protected post excerpt as "usual" may help them identify what’s going on.
		if ( post_password_required( $this->get_the_ID() ) ) {
			return __( 'There is no excerpt because this is a protected post.' );
		}

		// Make sure no “read more” link is added.
		add_filter( 'excerpt_more', '__return_empty_string', 999 );

		/**
		 * Apply the default WP Filters for the post excerpt.
		 *
		 * @since 0.1
		 *
		 * @param string  $post_excerpt  The post excerpt.
		 */
		$excerpt = apply_filters( 'get_the_excerpt', $post->post_excerpt );

		/**
		 * Filter the post excerpt for instant articles.
		 *
		 * @since 0.1
		 *
		 * @param string $excerpt The current post excerpt.
		 * @param Instant_Article_Post $instant_article_post The instant article post.
		 */
		$excerpt = apply_filters( 'instant_articles_excerpt', $excerpt, $this );

		return $excerpt;
	}

	/**
	 * Get the excerpt for this post
	 *
	 * @since 0.1
	 * @return string The excerpt
	 */
	public function get_the_excerpt_rss() {

		$excerpt = $this->get_the_excerpt();

		/**
		 * Apply the default WP Filters for the post excerpt for use in a feed. This ensures proper escaping.
		 *
		 * @since 0.1
		 *
		 * @param string  $excerpt  The current post excerpt.
		 */
		$excerpt = apply_filters( 'the_excerpt_rss', $excerpt );

		return $excerpt;
	}

	/**
	 * Get the canonical URL for this post
	 *
	 * A little warning here: It is extremely important that this is the same canonical URL as is used on the web site.
	 * This is the identificator Facebook use to connect the "read" web article with the instant article.
	 * Do not add any querystring params or URL fragments it. Not any. Not even for tracking.
	 *
	 * @since 0.1
	 * @return string  The canonical URL
	 */
	public function get_canonical_url() {
		// If post is draft, clone it to get the eventual permalink,
		// see http://wordpress.stackexchange.com/a/42988.
		if ( in_array( $this->_post->post_status, array( 'draft', 'pending', 'auto-draft' ), true ) ) {
			$post_clone = clone $this->_post;
			$post_clone->post_status = 'published';
			$post_clone->post_name = sanitize_title( $post_clone->post_name ? $post_clone->post_name : $post_clone->post_title, $post_clone->ID );
			$url = get_permalink( $post_clone );
		} else {
			$url = get_permalink( $this->_post );
		}

		return $url;
	}

	/**
	 * Get the article body for this post
	 *
	 * @since 0.1
	 * @return string The content
	 */
	public function get_the_content() {

		if ( is_null( $this->_content ) ) {
			$this->_content = $this->_get_the_content();
		}

		return $this->_content;

	}

	/**
	 * Put together the article body for this post
	 *
	 * @since 0.1
	 * @return string The content
	 */
	protected function _get_the_content() {

		// Try to get the content from a transient, but only if the cached version have the same modtime.
		$cache_mod_time = get_transient( 'instantarticles_mod_' . $this->_post->ID );
		if ( get_post_modified_time( 'Y-m-d H:i:s', true, $this->_post->ID ) === $cache_mod_time ) {
			$content = get_transient( 'instantarticles_content_' . $this->_post->ID );
			if ( false !== $content && strlen( $content ) ) {
				return $content;
			}
		}

		global $post, $more;

		// Force $more.
		$orig_more = $more;
		$more = 1;

		// If we’re not it the loop or otherwise properly setup.
		$reset_postdata = false;
		if ( empty( $post ) || $this->_post->ID !== $post->ID ) {
			$post = get_post( $this->_post->ID );
			setup_postdata( $post );
			$reset_postdata = true;
		}

		// Now get the content.
		$content = $this->_post->post_content;

		/**
		 * Apply the default filter 'the_content' for the post content.
		 *
		 * @since 0.1
		 * @param string  $content  The current post content.
		 */

		// Some people choose to disable wpautop. Due to the Instant Articles spec, we really want it in!
		if ( ! has_filter( 'the_content', 'wpautop' ) )
			add_filter( 'the_content', 'wpautop' );

		$content = apply_filters( 'the_content', $content );

		// Maybe cleanup some globals after us?
		$more = $orig_more;
		if ( $reset_postdata ) {
			wp_reset_postdata();
		}

		// Remove hyperlinks beginning with a # as they cause errors on Facebook (from http://wordpress.stackexchange.com/a/227332/19528)
		preg_match_all( '!<a[^>]*? href=[\'"]#[^<]+</a>!i', $content, $matches );
		foreach ( $matches[0] as $link ) {
			$content = str_replace( $link, strip_tags($link), $content );
		}

		/**
		 * Filter the post content for Instant Articles.
		 *
		 * @since 0.1
		 * @param string  $content  The post content.
		 */
		$content = apply_filters( 'instant_articles_content', $content );

		// Cache the content.
		set_transient( 'instantarticles_mod_' . $this->_post->ID, get_post_modified_time( 'Y-m-d H:i:s', true, $this->_post->ID ), WEEK_IN_SECONDS );
		set_transient( 'instantarticles_content_' . $this->_post->ID, $content, WEEK_IN_SECONDS );

		return $content;
	}

	/**
	 * Get the published date for this post (ISO 8601).
	 *
	 * @since 0.1
	 * @return string  The published date formatted suitable for use in the RSS feed and the html time elements (ISO 8601).
	 */
	public function get_the_pubdate_iso() {

		$published_date = mysql2date( 'c', get_post_time( 'Y-m-d H:i:s', true, $this->_post->ID ), false );

		/**
		 * Filter the post published date (ISO 8601).
		 *
		 * @since 0.1
		 *
		 * @param string                 $published_date        The current post published date.
		 * @param Instant_Article_Post   $instant_article_post  The instant article post.
		 */
		$published_date = apply_filters( 'instant_articles_published_date_iso', $published_date, $this );

		return $published_date;

	}

	/**
	 * Get the modified date for this post (ISO 8601).
	 *
	 * @since 0.1
	 * @return string  The modified date formatted suitable for use in the RSS feed and the html time elements (ISO 8601).
	 */
	public function get_the_moddate_iso() {

		$modified_date = mysql2date( 'c', get_post_modified_time( 'Y-m-d H:i:s', true, $this->_post->ID ), false );

		/**
		 * Filter the post modified date (ISO 8601).
		 *
		 * @since 0.1
		 *
		 * @param string                 $modified_date         The current post modified date.
		 * @param Instant_Article_Post   $instant_article_post  The instant article post.
		 */
		$modified_date = apply_filters( 'instant_articles_modified_date_iso', $modified_date, $this );

		return $modified_date;

	}
	/**
	 * Get the author(s).
	 *
	 * @since 0.1
	 * @return array  $authors  The post author(s).
	 */
	public function get_the_authors() {

		$authors = array();

		$wp_user = get_userdata( $this->_post->post_author );

		if ( is_a( $wp_user, 'WP_User' ) ) {
			$author = new stdClass;
			$author->ID            = $wp_user->ID;
			$author->display_name  = $wp_user->data->display_name;
			$author->first_name    = $wp_user->first_name;
			$author->last_name     = $wp_user->last_name;
			$author->user_login    = $wp_user->data->user_login;
			$author->user_nicename = $wp_user->data->user_nicename;
			$author->user_email    = $wp_user->data->user_email;
			$author->user_url      = $wp_user->data->user_url;
			$author->bio           = $wp_user->description;

			$authors[] = $author;
		}

		/**
		 * Filter the post author(s).
		 *
		 * @since 0.1
		 *
		 * @param array  $authors  The current post author(s).
		 * @param int    $post_id  The instant article post.
		 */
		$authors = apply_filters( 'instant_articles_authors', $authors, $this->_post->ID );

		return $authors;
	}

	/**
	 * Get featured image for cover.
	 *
	 * @since 0.1
	 * @return array {
	 *     Array containing image source and caption.
	 *
	 *     @type string $src Image URL.
	 *     @type string $caption Image caption.
	 * }
	 */
	public function get_the_featured_image() {

		$image_data = array(
			'src' => '',
			'caption' => '',
		);
		if ( has_post_thumbnail( $this->_post->ID ) ) {

			$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $this->_post->ID ), 'full' );
			$attachment_id   = get_post_thumbnail_id( $this->_post->ID );

			if ( is_array( $image_array ) ) {
				$image_data['src'] = $image_array[0];
				$attachment_post = get_post( $attachment_id );
				if ( is_a( $attachment_post, 'WP_Post' ) ) {
					$image_data['caption'] = $attachment_post->post_excerpt;
				}
			}
		}

		/**
		 * Filter the featured image.
		 *
		 * @since 0.1
		 * @param array $image_data {
		 *     Array containg image source and caption.
		 *
		 *     @type string $src Image URL.
		 *     @type string $caption Image caption.
		 * }
		 * @param int $post_id The post ID.
		 */
		$image_data = apply_filters( 'instant_articles_featured_image', $image_data, $this->_post->ID );
		return $image_data;
	}

	/**
	 * Get the cover media.
	 *
	 * @since 0.1
	 * @return Image|Video
	 */
	public function get_cover_media() {

		$cover_media = Image::create();


		// If someone else is handling this, let them. Otherwise fall back to us trying to use the featured image.
		if ( has_filter( 'instant_articles_cover_media' ) ) {
			/**
			 * Filter the cover media.
			 *
			 * @since 0.1
			 * @param Image     $cover_media  The cover media object.
			 * @param int       $post_id      The current post ID.
			 */
			$cover_media = apply_filters( 'instant_articles_cover_media', $cover_media, $this->_post->ID );
		} else {

			$featured_image_data = $this->get_the_featured_image();
			if ( isset( $featured_image_data['src'] ) && strlen( $featured_image_data['src'] ) ) {
				$cover_media = Image::create()->withURL($featured_image_data['src']);
				if( isset( $featured_image_data['caption'] ) && strlen( $featured_image_data['caption'] )) {
					$cover_media->withCaption(Caption::create()->withTitle($featured_image_data['caption']));
				}
			}
		}

		return $cover_media;
	}

	/**
	 * Get kicker text.
	 *
	 * @since 0.1
	 * @return string
	 */
	public function get_the_kicker() {

		$category = '';

		if ( has_category() ) {
			$categories = get_the_category();

			if ( is_array( $categories ) && isset( $categories[0]->name ) && __( 'Uncategorized' ) !== $categories[0]->name ) {
				$category = $categories[0]->name;
			}
		}

		/**
		 * Filter the kicker text.
		 *
		 * @since 0.1
		 *
		 * @param string  $category  The first category returned from get_the_category().
		 * @param int     $post_id   The post ID.
		 */
		$category_kicker = apply_filters( 'instant_articles_cover_kicker', $category,  $this->_post->ID );

		return $category_kicker ? $category_kicker : '';
	}

	/**
	 * Get newsfeed cover type, image or video.
	 *
	 * @since 0.1
	 * @return string
	 */
	public function get_newsfeed_cover() {

		$type = 'image';

		/**
		 * Filter the cover type property.
		 *
		 * @since 0.1
		 *
		 * @param string  $type     Set to 'video' for video cover. Featured image (image) is default.
		 * @param int     $post_id  The post ID.
		 */
		$type = apply_filters( 'instant_articles_cover_type', $type,  $this->_post->ID );

		return $type;
	}


	/**
	 * Render post
	 *
	 * @since 0.1
	 * @return InstantArticle
	 */
	public function to_instant_article() {

		/**
		 * Fires before the instant article is rendered.
		 *
		 * @since 0.1
		 * @param Instant_Article_Post  $instant_article_post  The instant article post.
		 */
		do_action( 'instant_articles_before_transform_post', $this );

		is_transforming_instant_article( true );

		// Get time zone configured in WordPress. Default to UTC if no time zone configured.
		$date_time_zone = get_option( 'timezone_string' ) ? new DateTimeZone( get_option( 'timezone_string' ) ) : new DateTimeZone( 'UTC' );

		// Initialize transformer
		$file_path = plugin_dir_path( __FILE__ ) . 'rules-configuration.json';
		$configuration = file_get_contents( $file_path );

		$transformer = new Transformer();
		$this->transformer = $transformer;
		$transformer->loadRules( $configuration );

		$transformer = apply_filters( 'instant_articles_transformer_rules_loaded', $transformer );

		$settings_publishing = Instant_Articles_Option_Publishing::get_option_decoded();

		if (
			isset( $settings_publishing['custom_rules_enabled'] ) &&
			! empty( $settings_publishing['custom_rules_enabled'] ) &&
			isset( $settings_publishing['custom_rules'] ) &&
			! empty( $settings_publishing['custom_rules'] )
		) {
			$transformer->loadRules( $settings_publishing['custom_rules'] );
		}

		$transformer = apply_filters( 'instant_articles_transformer_custom_rules_loaded', $transformer );

		$blog_charset = get_option( 'blog_charset' );

		$header =
			Header::create()
				->withPublishTime(
					Time::create( Time::PUBLISHED )->withDatetime( new DateTime( $this->_post->post_date, $date_time_zone ) )
				)
				->withModifyTime(
					Time::create( Time::MODIFIED )->withDatetime( new DateTime( $this->_post->post_modified, $date_time_zone ) )
				);

		$title = $this->get_the_title();
		if ( $title ) {
			$document = new DOMDocument();
			libxml_use_internal_errors(true);
			$document->loadHTML( '<?xml encoding="' . $blog_charset . '" ?><h1>' . $title . '</h1>' );
			libxml_use_internal_errors(false);
			$transformer->transform( $header, $document );
		}

		if ( $this->has_subtitle() ) {
			$header->withSubTitle ( $this->get_the_subtitle() ) ;
		}

		$authors = $this->get_the_authors();
		foreach ( $authors as $author ) {
			$author_obj = Author::create();
			if ( $author->display_name ) {
				$author_obj->withName( $author->display_name );
			}
			if ( $author->bio ) {
				$author_obj->withDescription( $author->bio );
			}
			if ( $author->user_url ) {
				$author_obj->withURL( $author->user_url );
			}
			$header->addAuthor( $author_obj );
		}
		$kicker = $this->get_the_kicker();
		if ( $kicker ) {
			$header->withKicker( $kicker );
		}

		$cover = $this->get_cover_media();
		if ( $cover->getUrl() ) {
			$header->withCover( $cover );
		}

		$this->instant_article =
			InstantArticle::create()
				->withCanonicalUrl( $this->get_canonical_url() )
				->withHeader( $header )
				->addMetaProperty( 'op:generator:application', 'facebook-instant-articles-wp' )
				->addMetaProperty( 'op:generator:application:version', IA_PLUGIN_VERSION );

		$settings_style = Instant_Articles_Option_Styles::get_option_decoded();
		if ( isset( $settings_style['article_style'] ) && ! empty( $settings_style['article_style'] ) ) {
			$this->instant_article->withStyle( $settings_style['article_style'] );
		} else {
			$this->instant_article->withStyle( 'default' );
		}

		if ( isset( $settings_style['rtl_enabled'] ) ) {
			$this->instant_article->enableRTL();
		}

		$transformer->transformString( $this->instant_article, $this->get_the_content(), get_option( 'blog_charset' ) );

		$this->add_ads_from_settings();
		$this->add_analytics_from_settings();

		$this->instant_article = apply_filters( 'instant_articles_transformed_element', $this->instant_article );

		is_transforming_instant_article( false );

		/**
		 * Fires after the instant article is rendered.
		 *
		 * @since 0.1
		 * @param Instant_Article_Post  $instant_article_post  The instant article post.
		 */
		do_action( 'instant_articles_after_transform_post', $this );

		return $this->instant_article;
	}

	/**
	 * Add all ad code(s) to the Header of an InstantArticle.
	 *
	 * @since 0.3
	 */
	public function add_ads_from_settings() {
		$header = $this->instant_article->getHeader();

		$settings_ads = Instant_Articles_Option_Ads::get_option_decoded();

		$width = 300;
		$height = 250;

		$dimensions_match = array();
		$dimensions_raw = isset( $settings_ads['dimensions'] ) ? $settings_ads['dimensions'] : null;
		if ( preg_match( '/^(?:\s)*(\d+)x(\d+)(?:\s)*$/', $dimensions_raw, $dimensions_match ) ) {
			$width = intval( $dimensions_match[1] );
			$height = intval( $dimensions_match[2] );
		}

		$ad = Ad::create()
			->enableDefaultForReuse()
			->withWidth( $width )
			->withHeight( $height );

		$source_of_ad = isset( $settings_ads['ad_source'] ) ? $settings_ads['ad_source'] : 'none';
		switch ( $source_of_ad ) {

			case 'none':
				break;

			case 'fan':
				if ( ! empty( $settings_ads['fan_placement_id'] ) ) {
					$placement_id = $settings_ads['fan_placement_id'];

					$ad->withSource(
						add_query_arg(
							array(
								'placement' => $placement_id,
								'adtype' => 'banner' . $width . 'x' . $height,
							),
							'https://www.facebook.com/adnw_request'
						)
					);

					$header->addAd( $ad );
				}
				break;

			case 'iframe':
				if ( ! empty( $settings_ads['iframe_url'] ) ) {
					$ad->withSource(
						$settings_ads['iframe_url']
					);

					$header->addAd( $ad );
				}
				break;

			case 'embed':
				if ( ! empty( $settings_ads['embed_code'] ) ) {

					$document = new DOMDocument();
					$fragment = $document->createDocumentFragment();
					$valid_html = @$fragment->appendXML( $settings_ads['embed_code'] );

					if ( $valid_html ) {
						$ad->withHTML(
							$fragment
						);
						$header->addAd( $ad );
					}
				}
				break;

			default:
				if ( ! empty( $source_of_ad ) ) {
					$registered_compat_ads = Instant_Articles_Option::get_registered_compat( 'instant_articles_compat_registry_ads' );
					foreach ( $registered_compat_ads as $compat_id => $compat_info ) {
						if ( array_key_exists( $compat_id, $registered_compat_ads ) ) {

							$document = new DOMDocument();
							$fragment = $document->createDocumentFragment();
							$valid_html = @$fragment->appendXML( $compat_info['payload'] );

							if ( $valid_html ) {
								$ad = Ad::create()
									->enableDefaultForReuse()
									->withWidth( $width )
									->withHeight( $height )
									->withHTML(
										$fragment
									);

								$header->addAd( $ad );
							}
						}
					}
				}
				break;
		}

		$this->instant_article->enableAutomaticAdPlacement();
	}

	/**
	 * Add all analytic tracking code(s) an InstantArticle.
	 *
	 * @since 0.3
	 */
	public function add_analytics_from_settings() {
		$settings_analytics = Instant_Articles_Option_Analytics::get_option_decoded();

		if ( isset( $settings_analytics['embed_code_enabled'] ) && ! empty( $settings_analytics['embed_code'] ) ) {

			$document = new DOMDocument();
			$fragment = $document->createDocumentFragment();
			$valid_html = @$fragment->appendXML( $settings_analytics['embed_code'] );

			if ( $valid_html ) {
				$this->instant_article
					->addChild(
						Analytics::create()
							->withHTML(
								$fragment
							)
					);
			}
		}

		if ( ! empty( $settings_analytics['integrations'] ) ) {
			$settings_analytics_compats = $settings_analytics['integrations'];
			$registered_compat_analytics = Instant_Articles_Option::get_registered_compat( 'instant_articles_compat_registry_analytics' );
			foreach ( $registered_compat_analytics as $compat_id => $compat_info ) {
				if ( in_array( $compat_id, $settings_analytics_compats, true ) ) {

					$document = new DOMDocument();
					$fragment = $document->createDocumentFragment();
					$valid_html = @$fragment->appendXML( $compat_info['payload'] );

					if ( $valid_html ) {
						$this->instant_article
							->addChild(
								Analytics::create()
									->withHTML(
										$fragment
									)
							);
					}
				}
			}
		}
	}

	/**
	 * Article <head> style.
	 *
	 * @since 0.1
	 * @return string The article style.
	 */
	public function get_article_style() {

		/**
		 * Filter the article style to use.
		 *
		 * @since 0.1
		 * @param string                    $template               Path to the current (default) template.
		 * @param Instant_Article_Post      $instant_article_post   The instant article post.
		 */
		$article_style = apply_filters( 'instant_articles_style', 'default', $this );

		return $article_style;
	}
}
