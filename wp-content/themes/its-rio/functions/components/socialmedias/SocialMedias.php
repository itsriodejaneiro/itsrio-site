<?php
class SocialMedias extends ET_Builder_Module {

	public $sociais = ["youtube", "twitter", "facebook", "instagram", "medium"];

	function init() {
		$this->name = esc_html__( 'ITS - Nas redes sociais', 'et_builder' );
		$this->slug = 'et_pb_social_medias';
		$this->fb_support = true;

		$this->whitelisted_fields = ['title', 'subtitle','palestrante','data','content'];

		$this->fields_defaults = ['title'];
		$this->fields_defaults[] = $this->sociais;

		$this->main_css_element = '%%order_class%% .et_pb_post';
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
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				)
			);

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
