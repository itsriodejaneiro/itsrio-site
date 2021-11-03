<?php
class SocialMedias extends ET_Builder_Module {

	public $sociais = ["title","youtube", "twitter", "facebook", "instagram", "medium","github"];

	function init() {
		$this->name = esc_html__( 'ITS - Nas redes sociais', 'et_builder' );
		$this->slug = 'et_pb_social_medias';
		$this->fb_support = true;

		$this->whitelisted_fields = $this->sociais;
		$this->fields_defaults = $this->sociais;

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		$fields = [];

		foreach ($this->sociais as $social) {
			$fields[$social] = ['label' => esc_html__('Link do '. ucfirst($social), 'et_builder'), 'type' => 'text'];
		}

		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $closed;
		global $wp_filter;
		global $paged;
		global $post;
		global $meta;
		global $data;

		$wp_filter_cache = $wp_filter;
		$title = $this->shortcode_atts['title'];

		$output = '';
		$data['its_tabs'][] = $title;

		ob_start();
		include(__DIR__.'/view_social_medias.php');
		$output = ob_get_contents();
		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);
		wp_reset_postdata();

		return $output;
	}
}

new SocialMedias;
