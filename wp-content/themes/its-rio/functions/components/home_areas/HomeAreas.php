<?php

$tabs_content = '';

class ET_Builder_Module_Home_Areas extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'ITS - Home Areas', 'et_builder' );
		$this->slug            = 'et_pb_home_areas';
		$this->child_slug      = 'et_pb_home_areas_item';
		$this->child_item_text = esc_html__( 'Área', 'et_builder' );

		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
			'title'
			);

		$this->main_css_element = '%%order_class%%.et_pb_tabs';
		$this->advanced_options = [];
		$this->custom_css_options =[];
	}

	function get_fields() {
		$fields = array(
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
					),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
				),
			'title' => array(
				'label'           => esc_html__( 'Título', 'et_builder' ),
				'type'            => 'text',
				),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
				),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id                         = $this->shortcode_atts['module_id'];
		$module_class                      = $this->shortcode_atts['module_class'];
		$title                      = $this->shortcode_atts['title'];
		$module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

		$all_tabs_content = $this->shortcode_content;

		global $et_pb_tab_titles;
		global $et_pb_tab_classes;
		global $tabs_content;
		global $data;
		global $components;
		global $meta;

		ob_start();
		include(__DIR__.'/view_home_areas.php');
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
new ET_Builder_Module_Home_Areas;

class ET_Builder_Module_Home_Areas_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Tab', 'et_builder' );
		$this->slug                        = 'et_pb_home_areas_item';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'link_title',
			'link',
			'midia',
			'title',
			'content_new',
			);

		$this->advanced_setting_title_text = esc_html__( 'Nova área', 'et_builder' );
		$this->settings_text               = esc_html__( 'Informações da área', 'et_builder' );
		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = [];
	}

	function get_fields() {
		$fields = array(
			'midia' => array(
				'label'       => esc_html__( 'URL da imagem ou vídeo', 'et_builder' ),
				'type'        => 'text',
				),
			'link' => array(
				'label'       => esc_html__( 'URL do botão', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Ex.: "/varandas"', 'et_builder' ),
				),
			'link_title' => array(
				'label'       => esc_html__( 'Título do botão', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Ex.: "conheça as varandas"', 'et_builder' ),
				),
			'title' => array(
				'label'       => esc_html__( 'Chamada da área', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'Ex.: "Abrindo janelas  para o futuro"', 'et_builder' ),
				),
			'content_new' => array(
				'label'       => esc_html__( 'Texto explicativo', 'et_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( 'Este texto irá aparecer na página interna', 'et_builder' ),
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $et_pb_tab_titles;
		global $et_pb_tab_classes;
		global $tabs_content;

		$i = 0;
		$title = $this->shortcode_atts['title'];
		$link_title = $this->shortcode_atts['link_title'];
		$link = $this->shortcode_atts['link'];
		$midia = $this->shortcode_atts['midia'];

		$module_class = ET_Builder_Element::add_module_order_class( '', $function_name );

		$et_pb_tab_titles[]  = '' !== $title ? $title : esc_html__( 'Tab', 'et_builder' );
		$et_pb_tab_classes[] = $module_class;

		$content = $this->shortcode_content;

		$tabs_content[] = compact('title', 'link_title', 'link', 'midia', 'content');
	}
}
new ET_Builder_Module_Home_Areas_Item;