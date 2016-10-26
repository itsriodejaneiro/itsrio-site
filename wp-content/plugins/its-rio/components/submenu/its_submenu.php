<?php

class ITS_Submenu extends ET_Builder_Module {

	function init() {
		$this->name       = esc_html__( 'ITS - Submenu', 'et_builder' );
		$this->slug       = 'et_pb_submenu';
		$this->fb_support = true;

		$this->whitelisted_fields = [
		'title',
		'description',
		'cpt',
		'o_que_sao'
		];

		$this->fields_defaults = [
		'title'      		=> ['', 'add_default_setting'],
		'cpt'      		=> ['', 'add_default_setting'],
		'o_que_sao'     => ['', 'add_default_setting'],
		'description'   => ['', 'add_default_setting']
		];

		$this->main_css_element = '%%order_class%% .et_pb_post';
		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Header', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .entry-title",
						'important' => 'all',
						),
					),
				'meta' => array(
					'label'    => esc_html__( 'Meta', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .post-meta",
						),
					),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'et_builder' ),
					'css'      => array(
						'color'        => "{$this->main_css_element}, {$this->main_css_element} .post-content *",
						'line_height' => "{$this->main_css_element} p",
						),
					),
				),
			'border' => array(),
			);
		$this->custom_css_options = array(
			'title' => array(
				'label'    => esc_html__( 'Title', 'et_builder' ),
				'selector' => '.et_pb_post .entry-title',
				),
			'post_meta' => array(
				'label'    => esc_html__( 'Post Meta', 'et_builder' ),
				'selector' => '.et_pb_post .post-meta',
				),
			'pagenavi' => array(
				'label'    => esc_html__( 'Pagenavi', 'et_builder' ),
				'selector' => '.wp_pagenavi',
				),
			'featured_image' => array(
				'label'    => esc_html__( 'Featured Image', 'et_builder' ),
				'selector' => '.et_pb_image_container',
				),
			'read_more' => array(
				'label'    => esc_html__( 'Read More Button', 'et_builder' ),
				'selector' => '.et_pb_post .more-link',
				),
			);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Título do submenu.', 'et_builder' ),
				),
			'cpt' => array(
				'label'             => esc_html__( 'Post type', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Qual post_type pertence a esta página .', 'et_builder' ),
				),
			'description' => array(
				'label'             => esc_html__( 'Descrição', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( '', 'et_builder' ),
				),
			'o_que_sao' => array(
				'label'             => esc_html__( 'O que são', 'et_builder' ),
				'type'            	=> 'tiny_mce',
				'option_category' 	=> 'basic_option',
				)
			);

		return $fields;
	}

	static function front_output( $args = array(), $conditional_tags = array(), $current_page = array() ) {

		return [];
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {

		global $wp_filter, $paged;

		$wp_filter_cache = $wp_filter;
		$title	 		 = $this->shortcode_atts['title'];
		$description	 = $this->shortcode_atts['description'];
		$o_que_sao		 = $this->shortcode_atts['o_que_sao'];
		$postType		 = $this->shortcode_atts['cpt'];


		ob_start();

		// query_posts(['post_type' => $post_type. '_ctp']);


		include(__DIR__.'/view_submenu.php');


		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
}

new ITS_Submenu;
