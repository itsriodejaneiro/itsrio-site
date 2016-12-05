<?php
class HomeCards extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'Home ITS - Conteúdos', 'et_builder' );
		$this->slug = 'et_pb_home_cards';
		$this->fb_support = true;

		$this->whitelisted_fields = ['count'];

		$this->fields_defaults = array(
			'count'      => ['3', 'add_default_setting']
			);

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		$fields = array(
			'count' => array(
				'label'             => esc_html__( 'Quantidade', 'et_builder' ),
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
		$count = $this->shortcode_atts['count'];

		$args = array(
			'meta_query' => array(
				array(
					'key' => 'home_banner',
					'value' => '1',
					'compare' => '=',
					)
				),
			'posts_per_page' => $count,
			'post_type' => [ 'varandas_ctp', 'cursos_ctp','comunicados_ctp', 'publicacoes_ctp' ],
			);

		$query = new WP_Query($args);

		ob_start();
		include(__DIR__.'/view_home_cards.php');
		$output = ob_get_contents();
		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		return $output;
	}
}

new HomeCards;
