<?php
class Comunicados extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Acontece (Comunicados)', 'et_builder' );
		$this->slug = 'et_pb_comunicados';
		$this->fb_support = true;

		$this->whitelisted_fields = ['posts_type', 'count'];

		$this->fields_defaults = array(
			'posts_type'      => [10, 'add_default_setting'],
			'count'      => ['3', 'add_default_setting']
			);

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		$fields = array(
			'posts_type' => array(
				'label'             => esc_html__( 'Tipo de conteúdo', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'et_builder' ),
				'options'         => array(
					'0' => esc_html__( 'Tudo', 'et_builder' ),
					'varandas_ctp' => esc_html__( 'Varandas', 'et_builder' ),
					'cursos_ctp'      => esc_html__( 'Cursos', 'et_builder' ),
					'projetos_ctp'     => esc_html__( 'Projetos', 'et_builder' ),
					'publicacoes_ctp'     => esc_html__( 'Publicações', 'et_builder' ),
					),
				),
			'count' => array(
				'label'             => esc_html__( 'Post type', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Quantos posts serão exibidos?', 'et_builder' )
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $wp_filter;
		global $paged;
		global $post;
		global $data;
		global $components;

		$wp_filter_cache = $wp_filter;
		$posts_type        = $this->shortcode_atts['posts_type'];
		$count        	 = $this->shortcode_atts['count'];

		$data['its_tabs'][] = 'comunicados';

		$args['post_type'] = ['comunicados_ctp'];
		$query = new wp_query($args);

		if ($query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				$post = (array)$post;
				$components['comunicados']['posts'][] = array(
					'title' => $post['post_title'],
					'permalink' => get_permalink($post['ID']),
					'excerpt' => $post['post_excerpt'],
					'thumb' => get_thumbnail_url_full( $post['ID'] ),
					);
			}
		}

		$components['comunicados']['max'] = '3';

		ob_start();
		
		include(__DIR__.'/view_comunicados.php');

		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
}

new Comunicados;
