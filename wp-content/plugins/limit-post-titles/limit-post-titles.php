<?php
/*
Plugin Name:          Limit Post Titles
Plugin URI:           http://stephenradford.me/restricting-post-titles-in-wordpress-with-a-character-limit
Description:          Limit post titles using JS in the dashboard
Version:              1.0.2
Author:               Cocoon Development Ltd
Author URI:           http://wearecocoon.co.uk
*/

class SR_Limit_Post_Titles {

	/**
	 * Stores the plugins options
	 * @var array
	 */
	private $options;

	/**
	 * List of post types to ignore
	 * @var array
	 */
	private $ignore = array(
		'attachment',
		'revision',
		'nav_menu_item',
	);

	public function __construct()
	{
		$this->options = get_option('sr_title_options');
		add_action('admin_enqueue_scripts', array($this, 'enqueuer'));
		add_action('admin_menu', array($this, 'create_settings_page'));
		add_action('admin_init', array($this, 'register_settings'));
	}

	/**
	 * Enqueue styles and JS
	 */
	public function enqueuer()
	{
		// We only need to enqueue if it's a particular post type page and the limit is > 0
		$p = get_current_screen();
		if(is_admin() && isset($this->options['post_types'][$p->post_type]) && isset($this->options['limit']) && $this->options['limit'] > 0)
		{
			if(is_rtl()) {
				wp_register_style('limit-post-titles-style', plugin_dir_url(__FILE__).'limit-post-titles-rtl.css', false, '1.0.1');
			} else {
				wp_register_style('limit-post-titles-style', plugin_dir_url(__FILE__).'limit-post-titles.css', false, '1.0.1');
			}
			wp_enqueue_style('limit-post-titles-style');
			wp_enqueue_script('limit-post-titles', plugin_dir_url(__FILE__).'limit-post-titles.min.js');
			wp_localize_script('limit-post-titles', 'sr_post_titles', array(
				'limit' => $this->options['limit'],
			));
		}
	}

	/**
	 * Create the options page in WordPress
	 */
	public function create_settings_page()
	{
		add_options_page('Limit Post Titles', 'Limit Post Titles', 'delete_others_posts', 'sr_limiter', array($this, 'load_settings_page'));
	}

	/**
	 * Load the template for the settings page
	 */
	public function load_settings_page()
	{
		require_once __DIR__.'/settings.php';
	}

	/**
	 * Register settings and fields
	 */
	public function register_settings()
	{
		register_setting('sr_title_group', 'sr_title_options', array($this, 'sanitize'));
        add_settings_section('sr_title_section', 'Settings', array( $this, 'section_callback'), 'sr_limiter');

        add_settings_field('limit', 'Character Limit', array($this, 'limit_callback'), 'sr_limiter', 'sr_title_section');
		add_settings_field('post_types', 'Post Types', array($this, 'post_types_callback'), 'sr_limiter', 'sr_title_section');
	}

	/**
	 * Section Callback
	 */
	public function section_callback()
	{
		echo 'Enter the character limit and select the post types you wish to limit. Entering a character limit of 0 will disable the plugin.';
	}

	/**
	 * Callback for the limit filed
	 */
	public function limit_callback()
	{
		printf('<input type="text" id="limit" name="sr_title_options[limit]" value="%s">', isset($this->options['limit']) ? esc_attr($this->options['limit']) : 0);
	}

	/**
	 * Callback for the list of post types
	 */
	public function post_types_callback()
	{
		echo '<ul>';
		foreach(get_post_types() as $pt){
			if(in_array($pt, $this->ignore)) continue;
			printf('<li><label><input type="checkbox" name="sr_title_options[post_types][%s]" %s> %s</label></li>', $pt, (isset($this->options['post_types'][$pt])) ? 'checked' : '', $pt);
		}
		echo '</ul>';
	}

	/**
	 * Sanitize the content input in the plugin
	 * @param  array $input Unsanitized content
	 * @return array Sanitized content
	 */
	public function sanitize($input)
	{
		$input['limit'] = (int) $input['limit'];
		return $input;
	}

}

new SR_Limit_Post_Titles();
