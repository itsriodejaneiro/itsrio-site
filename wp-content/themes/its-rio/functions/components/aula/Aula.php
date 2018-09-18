<?php
class Aula extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Aula', 'et_builder' );
		$this->slug = 'et_pb_aula';
		$this->fb_support = true;

		$this->whitelisted_fields = ['title', 'subtitle','palestrante_1','palestrante_2','palestrante_3','data','content'];

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		$pessoas = ['0' => ''];
		$query_pessoas = new WP_Query([
			'post_type' => 'pessoas',
			'posts_per_page' => 1000,
			]);

		while ($query_pessoas->have_posts()) {
			$query_pessoas->the_post();
			$pessoas[get_the_ID()] = esc_html__( get_the_title(), 'et_builder' );
		}

		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				),
			'subtitle' => array(
				'label'             => esc_html__( 'Subtítulo', 'et_builder' ),
				'type'              => 'text',
				),
			'data' => array(
				'label'             => esc_html__( 'Data e Hora', 'et_builder' ),
				'type'              => 'text',
				),
			'palestrante_1' => array(
				'label'             => esc_html__( 'Palestrante 1', 'et_builder' ),
				'type'              => 'select',
				'options'         => $pessoas
				),
			'palestrante_2' => array(
				'label'             => esc_html__( 'Palestrante 2', 'et_builder' ),
				'type'              => 'select',
				'options'         => $pessoas
				),
			'palestrante_3' => array(
				'label'             => esc_html__( 'Palestrante 3', 'et_builder' ),
				'type'              => 'select',
				'options'         => $pessoas
				),
			'content' => array(
				'label'             => esc_html__( 'Conteúdo', 'et_builder' ),
				'type'              => 'tiny_mce',
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $closed;
		global $wp_filter;
		global $paged;
		global $post;
		global $components;
		global $data;

		$wp_filter_cache = $wp_filter;
		$title = $this->shortcode_atts['title'];
		$subtitle = $this->shortcode_atts['subtitle'];
		$palestrante_1 = $this->shortcode_atts['palestrante_1'];
		$palestrante_2 = $this->shortcode_atts['palestrante_2'];
		$palestrante_3 = $this->shortcode_atts['palestrante_3'];
		$date = $this->shortcode_atts['data'];
		$content = wpautop($this->shortcode_content);
		$output = '';

		for ($i=1; $i <= 3; $i++) { 
			if(${'palestrante_'.$i} != '' && ${'palestrante_'.$i} != '0'){
				$palestrante = new WP_Query( ['p' => ${'palestrante_'.$i}, 'post_type' => 'pessoas'] );
				$palestrante->have_posts();
				$palestrante->the_post();
				${'palestrante_'.$i} = get_the_title();
			}else
				${'palestrante_'.$i} = '';
		}

		$components['aulas'][] = compact('title', 'subtitle', 'palestrante_1', 'palestrante_2', 'palestrante_3', 'date', 'content');

		if(!in_array(pll__('aulas'), $data['its_tabs'])){
			$data['its_tabs'][] = pll__('aulas');
			ob_start();
			include(__DIR__.'/view_aula.php');
			$output = ob_get_contents();
			ob_end_clean();
		}

		if(!in_array(pll__('aulas'), $data['its_tabs']))
			$data['its_tabs'][] = pll__('aulas');

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);
		wp_reset_postdata();

		return $output;
	}
}

new Aula;
