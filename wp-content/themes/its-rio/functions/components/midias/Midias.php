<?php

$tabs_content_midias = '';

class ET_Builder_Module_Midias extends ET_Builder_Module {
	function init() {
		global $tabs_content_midias;
		$tabs_content_midias = [];
		$this->name            = esc_html__( 'ITS - Mídias', 'et_builder' );
		$this->slug            = 'et_pb_midias';
		$this->child_slug      = 'et_pb_midias_item';
		$this->child_item_text = esc_html__( 'Mídia', 'et_builder' );

		$this->whitelisted_fields = ['par_title'];
	}

	function get_fields() {
		$fields = array(
			'par_title' => array(
				'label'       => esc_html__( 'Título da seção', 'et_builder' ),
				'type'        => 'text',
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $wp_filter;
		global $et_pb_tab_titles;
		global $et_pb_tab_classes;
		global $tabs_content_midias;
		global $data;
		global $components;
		global $meta;
		
		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$par_title = $this->shortcode_atts['par_title'];
		$all_tabs_content_midias = $this->shortcode_content;
		
		

		$data['its_tabs'][] = $par_title;

		ob_start();
		include(__DIR__.'/view_midias.php');
		$output = ob_get_contents();
		ob_end_clean();

		// for ($i=0; $i < count($tabs_content_midias); $i++) {
		// 	$components['informacoes'][] = [
		// 	'title' => $et_pb_tab_titles[$i],
		// 	'content' => trim(preg_replace('/\s+/', ' ', $tabs_content_midias[$i]))
		// 	];
		// }

		// wp_reset_postdata();

		return $output;
	}
}
new ET_Builder_Module_Midias;

class ET_Builder_Module_Midias_Item extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Home ITS - Capa', 'et_builder' );
		$this->slug = 'et_pb_midias_item';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = ['title','url','description'];
		
		$this->advanced_setting_title_text = esc_html__( 'Nova Mídia', 'et_builder' );
		$this->settings_text               = esc_html__( 'Configurações', 'et_builder' );
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				),
			'description' => array(
				'label'             => esc_html__( 'Descrição', 'et_builder' ),
				'type'              => 'text',
				),
			'url' => array(
				'label'             => esc_html__( 'ID do vídeo no YouTube', 'et_builder' ),
				'type'              => 'text',
				'description'		=> esc_html__('O ID do vídeo é o que vem depoisdo "?v=" na URL, aqui representado por "XXXXX": "www.youtube.com/watch?v=XXXXX"', 'et_builder')
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $et_pb_tab_titles;
		global $et_pb_tab_classes;
		global $tabs_content_midias;

		$i = 0;
		$title = $this->shortcode_atts['title'];
		$url = $this->shortcode_atts['url'];

		$module_class = ET_Builder_Element::add_module_order_class( '', $function_name );

		$et_pb_tab_titles[]  = '' !== $title ? $title : esc_html__( 'Mídia', 'et_builder' );
		$et_pb_tab_classes[] = $module_class;
		$description = $this->shortcode_content;
		$tabs_content_midias[] = compact('title','description','url');

	}
}
new ET_Builder_Module_Midias_Item;