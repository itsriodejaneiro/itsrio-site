<?php
class Publicacoes extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Publicações', 'et_builder' );
		$this->slug = 'et_pb_publicacoes';
		$this->fb_support = true;

		$this->whitelisted_fields = [];

		$this->fields_defaults = [];

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		return [];
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $wp_filter;
		global $paged;
		global $post;
		global $title;
		global $data;

		$wp_filter_cache = $wp_filter;
		$meta = get_post_meta(get_the_ID());

		$data['its_tabs'][] = 'publicações';

		ob_start();

		include(__DIR__.'/view_publicacoes.php');

		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		wp_reset_postdata();

		return $output;
	}
}

new Publicacoes;
