<?php
class PeopleList extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Lista de Pessoas', 'et_builder' );
		$this->slug = 'et_pb_peoplelist';
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
				'label'             => esc_html__( 'Listar quem:', 'et_builder' ),
				'option_category'   => 'configuration',
				'description'       => esc_html__( 'Escolha de que tipo de pessoas deseja criar uma lista.', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'board'      => esc_html__( 'Board', 'et_builder' ),
					'diretores'     => esc_html__( 'Diretores', 'et_builder' ),
					'equipe'     => esc_html__( 'Equipe', 'et_builder' ),
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
		global $title;
		global $data;

		// $data['its_tabs'][] = $title['singular'] == 'cursos' ? 'professores' : 'palestrantes';

		$wp_filter_cache = $wp_filter;
		$meta = (get_the_ID());

		ob_start();

		include(__DIR__.'/view_people_list.php');

		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		wp_reset_postdata();

		return $output;
	}
}

new PeopleList;
