<?php

/**
 * !!!!!!!!!! MAIS IMPORTANTE DE TUDO! Esse negócio salva um cache ferrado no navegador, é bom sempre limpar !!!!!!!!!!!!!!!
 *
 * 1. Métodos obrigatórios:
 *
 * > init()
 * > get_fields()
 * > shortcode_callback()
 *
 *
 * 2. Finalidade dos métodos:
 *
 * > init() - Definir informações que aparecerão na lista de Módulos no Construtor Divi
 * > get_filds() - Após um módulo ser adicionado, esse método definirá os campos com
 *   informações relevantes para serem definidas pelo usuário para esse módulo.
 * > shortcode_callback() - Aqui é definido todo output do módulo no front.
 *
 *
 * 3. Observações:
 *
 * > No arquivo class-et-builder-element.php é possível encontrar
 *   e criar novos campos pela variável $field['type'] para a
 *   variável $fields_defaults e para $whitelisted_fields.
 *
 * > É possível usar reflection para ver a estrutura de um ET_BUilder_Module
 *   com var_dump(get_class_vars('ITS_Latest_Post'));
 *
 */



class ITS_Latest_Post extends ET_Builder_Module {

	function init() {
		$this->name       = esc_html__( 'ITS - Últimos Posts', 'et_builder' );
		$this->slug       = 'et_pb_latest_post';
		$this->fb_support = true;

		$this->whitelisted_fields = array(
			'posts_number',
			'cpt',
			'module_id',
			'module_class'
			);

		$this->fields_defaults = array(
			'posts_number'      => array( 10, 'add_default_setting' ),
			'cpt'      => array( '', 'add_default_setting' )
			);

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
			'posts_number' => array(
				'label'             => esc_html__( 'Posts Number', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'et_builder' ),
				'computed_affects'   => array(
					'__posts',
					),
				),
			'cpt' => array(
				'label'             => esc_html__( 'Post type', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Qual post_type pertence a esta página .', 'et_builder' ),
				'computed_affects'   => array(
					'__posts',
					),
				),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
				),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
				),
			'__posts' => array(
				'type' => 'computed',
				'computed_callback' => array( 'ITS_Latest_Post', 'front_output' ),
				'computed_depends_on' => array(
					'posts_number',
					'post_type'
					),
				),
			);
		return $fields;
	}

	static function front_output( $args = array(), $conditional_tags = array(), $current_page = array() ) {

		return [];
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		/**
		 * Cached $wp_filter so it can be restored at the end of the callback.
		 * This is needed because this callback uses the_content filter / calls a function
		 * which uses the_content filter. WordPress doesn't support nested filter
		 */
		global $wp_filter;
		$wp_filter_cache = $wp_filter;

		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$post_type        	 = $this->shortcode_atts['cpt'];
		$posts = '';

		global $paged;

		ob_start();

		query_posts([
			'post_type' => $post_type. '_ctp',
			]);
			// 'posts_per_page'=> $posts_number


		include(__DIR__.'/view_posts.php');


		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
}

new ITS_Latest_Post;
