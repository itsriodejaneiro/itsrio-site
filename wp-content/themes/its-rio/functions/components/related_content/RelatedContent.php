<?php
class RelatedContent extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Conteúdo Relacionado', 'et_builder' );
		$this->slug = 'et_pb_related_content';
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

		$wp_filter_cache = $wp_filter;
		$posts_type        = $this->shortcode_atts['posts_type'];
		$count        	 = $this->shortcode_atts['count'];

		$data['its_tabs'][] = 'relacionados';

		ob_start();

		$tags = wp_get_post_tags($post->ID);

		if ($tags) {
			$tag_ids = [];

			foreach($tags as $individual_tag)
				$tag_ids[] = $individual_tag->term_id;

			$args = [
			'post_type' => $posts_type,
			'tag__in' => $tag_ids,
			'post__not_in' => [$post->ID],
			'posts_per_page' =>  $count,
			];

			$query = new wp_query($args);

			include(__DIR__.'/view_related_content.php');
		}


		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
}

new RelatedContent;
