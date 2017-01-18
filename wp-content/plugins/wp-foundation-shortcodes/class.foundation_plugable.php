<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('WP_Foundation_shortcodes_plugable') ) {

class WP_Foundation_shortcodes_plugables{
        function __construct(){

	}

	public static function get_template_part($slug, $name = null ){
		$default_file = "{$slug}.php";
		$templates = array();
		if ( isset($name) ){
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
	
		if (is_file('includes/'.$templates[0])){
			return 'includes/'.$templates[0];
		}
	
		return 'includes/'.$default_file;
	}

	public static function entry_meta(){
		$format = get_post_format();
	        if ( current_theme_supports( 'post-formats', $format ) ) {
        	        printf( '<span class="entry-format">%1$s<a href="%2$s">&nbsp;%3$s</a></span>',
                	        sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'wp-foundation-shortcodes' ) ),
                        	esc_url( get_post_format_link( $format ) ),
	                        get_post_format_string( $format )
        	        );
	        }

        	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
                	$time_string = '<time class="entry-date published updated fa fa-calendar" datetime="%1$s">&nbsp;%2$s</time>';

	                if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        	                $time_string = '<time class="entry-date published fa fa-calendar" datetime="%1$s">&nbsp;%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                	}

	                $time_string = sprintf( $time_string,
        	                esc_attr( get_the_date( 'c' ) ),
                	        get_the_date(),
                        	esc_attr( get_the_modified_date( 'c' ) ),
	                        get_the_modified_date()
        	        );

	                printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
        	                _x( 'Posted on', 'Used before publish date.', 'wp-foundation-shortcodes' ),
                	        esc_url( get_permalink() ),
                        	$time_string
	                );
        	}
		if ( 'post' == get_post_type() ) {
         	       if ( is_singular() || is_multi_author() ) {
                	        printf( '<span class="byline"><span class="author"><span class="screen-reader-text">%1$s </span><a class="url fn n fa fa-user" href="%2$s">&nbsp;%3$s</a></span></span>',
                        	        _x( 'Author', 'Used before post author name.', 'wp-foundation-shortcodes' ),
                                	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	                                get_the_author()
        	                );
                	}

	                $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'wp-foundation-shortcodes' ) );
        	        if ( $categories_list && self::categorized_blog() ) {
                	        printf( '<span class="cat-links fa fa-folder-open-o">&nbsp;<span class="screen-reader-text">%1$s </span>%2$s</span>',
                        	        _x( 'Categories', 'Used before category names.', 'wp-foundation-shortcodes' ),
                                	$categories_list
	                        );
        		}

	                $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'wp-foundation-shortcodes' ) );
        	        if ( $tags_list ) {
                	        printf( '<span class="tags-links fa fa-tags"><span class="screen-reader-text">%1$s </span>&nbsp;%2$s</span>',
                        	        _x( 'Tags', 'Used before tag names.', 'wp-foundation-shortcodes' ),
                                	$tags_list
	                        );
        	        }
	        }

		if ( is_attachment() && wp_attachment_is_image() ) {
	                // Retrieve attachment metadata.
        	        $metadata = wp_get_attachment_metadata();

	                printf( '<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
        	                _x( 'Full size', 'Used before full size attachment link.', 'wp-foundation-shortcodes' ),
                	        esc_url( wp_get_attachment_url() ),
                        	$metadata['width'],
	                        $metadata['height']
        	        );
	        }

	        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        	        echo '<span class="comments-link fa fa-comment-o">&nbsp;';
                	/* translators: %s: post title */
	                comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'wp-foundation-shortcodes' ), get_the_title() ) );
        	        echo '</span>';
	        }
	}

	/**
	 * Determine whether blog/site has more than one category.
	 *
	 * @return bool True of there is more than one category, false otherwise.
	 */
	public static function categorized_blog() {
        	if ( false === ( $all_the_cool_cats = get_transient( 'foundation_categories' ) ) ) {
	                // Create an array of all the categories that are attached to posts.
        	        $all_the_cool_cats = get_categories( array(
                	        'fields'     => 'ids',
                        	'hide_empty' => 1,

	                        // We only need to know if there is more than one category.
        	                'number'     => 2,
                	) );

	                // Count the number of categories that are attached to the posts.
        	        $all_the_cool_cats = count( $all_the_cool_cats );

	                set_transient( 'foundation_categories', $all_the_cool_cats );
        	}

	        if ( $all_the_cool_cats > 1 ) {
        	        // This blog has more than 1 category so categorized_blog should return true.
                	return true;
	        } else {
        	        // This blog has only 1 category so categorized_blog should return false.
                	return false;
	        }
	}

} // end class

} // end if
