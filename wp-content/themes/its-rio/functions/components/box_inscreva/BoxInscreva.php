<?php
class BoxInscreva extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Chamada de Inscreva-se', 'et_builder' );
		$this->slug = 'et_pb_box_inscreva';
		$this->fb_support = true;

		$this->whitelisted_fields = ['title', 'subtitle','buttonText'];
	}

	function get_fields() {
		$palestrantes = [];
		$query_palestrantes = new WP_Query([
			'post_type' => 'palestrantes'
			]);

		while ($query_palestrantes->have_posts()) {
			$query_palestrantes->the_post();
			$palestrantes[get_the_ID()] = esc_html__( get_the_title(), 'et_builder' );
		}

		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Título em destaque', 'et_builder' ),
				'description'              => 'O texto maior',
				'type'              => 'text',
				),
			'subtitle' => array(
				'label'             => esc_html__( 'Subtítulo', 'et_builder' ),
				'type'              => 'text',
				'description'              => 'Aparecerá em baixo do botão',
				),
			'buttonText' => array(
				'label'             => esc_html__( 'Texto do botão', 'et_builder' ),
				'type'              => 'text',
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $wp_filter;
		global $paged;
		global $post;
		global $meta;
		global $data;
		global $closed;
		global $postType;

		if($closed)
			return '';

		$wp_filter_cache = $wp_filter;
		$title = $this->shortcode_atts['title'];
		$subtitle = $this->shortcode_atts['subtitle'];
		$buttonText = $atts['buttontext'];

		ob_start();
		include(__DIR__.'/view_box_inscreva.php');
		$output = ob_get_contents();
		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);
		wp_reset_postdata();

		return $output;
	}
}

new BoxInscreva;
