<?php

$tabs_content = '';

class ET_Builder_Module_Informacoes extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'ITS - Informações', 'et_builder' );
		$this->slug            = 'et_pb_informacoes';
		$this->child_slug      = 'et_pb_informacao';
		$this->child_item_text = esc_html__( 'Tab', 'et_builder' );

		$this->whitelisted_fields = array(
			'admin_label',
			'module_id',
			'module_class',
			'active_tab_background_color',
			'inactive_tab_background_color',
			);

		$this->main_css_element = '%%order_class%%.et_pb_tabs';
		$this->advanced_options = array(
			'fonts' => array(
				'tab' => array(
					'label'    => esc_html__( 'Tab', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .et_pb_tabs_controls li",
						'color' => "{$this->main_css_element} .et_pb_tabs_controls li a",
						),
					),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .et_pb_all_tabs",
						'line_height' => "{$this->main_css_element} p",
						),
					),
				),
			'background' => array(
				'css' => array(
					'main' => "{$this->main_css_element} .et_pb_all_tabs",
					),
				'settings' => array(
					'color' => 'alpha',
					),
				),
			'border' => array(),
			);
		$this->custom_css_options = array(
			'tabs_controls' => array(
				'label'    => esc_html__( 'Tabs Controls', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls',
				),
			'tab' => array(
				'label'    => esc_html__( 'Tab', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls li',
				),
			'active_tab' => array(
				'label'    => esc_html__( 'Active Tab', 'et_builder' ),
				'selector' => '.et_pb_tabs_controls li.et_pb_tab_active',
				),
			'tabs_content' => array(
				'label'    => esc_html__( 'Tabs Content', 'et_builder' ),
				'selector' => '.et_pb_all_tabs',
				),
			);
	}

	function get_fields() {
		$fields = array(
			'active_tab_background_color' => array(
				'label'             => esc_html__( 'Active Tab Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				),
			'inactive_tab_background_color' => array(
				'label'             => esc_html__( 'Inactive Tab Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
				),
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
		$active_tab_background_color       = $this->shortcode_atts['active_tab_background_color'];
		$inactive_tab_background_color     = $this->shortcode_atts['inactive_tab_background_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$all_tabs_content = $this->shortcode_content;

		global $et_pb_tab_titles;
		global $et_pb_tab_classes;
		global $tabs_content;
		global $data;
		global $components;
		global $meta;

		$data['its_tabs'][] = 'informações';
		ob_start();
		include(__DIR__.'/view_informacoes.php');
		$output = ob_get_contents();
		ob_end_clean();

		for ($i=0; $i < count($tabs_content); $i++) {
			$components['informacoes'][] = [
			'title' => $et_pb_tab_titles[$i],
			'content' => trim(preg_replace('/\s+/', ' ', $tabs_content[$i]))
			];
		}

		// wp_reset_postdata();

		return $output;
	}
}
new ET_Builder_Module_Informacoes;

class ET_Builder_Module_Informacoes_Item extends ET_Builder_Module {
	function init() {
		$this->name                        = esc_html__( 'Tab', 'et_builder' );
		$this->slug                        = 'et_pb_informacao';
		$this->type                        = 'child';
		$this->child_title_var             = 'title';

		$this->whitelisted_fields = array(
			'title',
			'content_new',
			);

		$this->advanced_setting_title_text = esc_html__( 'New Tab', 'et_builder' );
		$this->settings_text               = esc_html__( 'Tab Settings', 'et_builder' );
		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'tab' => array(
					'label'    => esc_html__( 'Tab', 'et_builder' ),
					'css'      => array(
						'main'      => ".et_pb_tabs .et_pb_tabs_controls li{$this->main_css_element}",
						'color'     => ".et_pb_tabs .et_pb_tabs_controls li{$this->main_css_element} a",
						'important' => 'all',
						),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
							),
						),
					),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'et_builder' ),
					'css'      => array(
						'line_height' => "{$this->main_css_element} p",
						),
					'line_height' => array(
						'range_settings' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
							),
						),
					),
				),
			'background' => array(
				'css' => array(
					'main' => "div{$this->main_css_element}",
					'important' => 'all',
					),
				'settings' => array(
					'color' => 'alpha',
					),
				),
			);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'       => esc_html__( 'Título da Aba', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( '(A aba de datas pode ser gerada automaticamente ao definir o título como "data" e deixar o conteúdo em branco)', 'et_builder' ),
				),
			'content_new' => array(
				'label'       => esc_html__( 'Content', 'et_builder' ),
				'type'        => 'tiny_mce',
				'description' => esc_html__( 'Here you can define the content that will be placed within the current tab.', 'et_builder' ),
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

		$module_class = ET_Builder_Element::add_module_order_class( '', $function_name );

		$et_pb_tab_titles[]  = '' !== $title ? $title : esc_html__( 'Tab', 'et_builder' );
		$et_pb_tab_classes[] = $module_class;

		$tabs_content[] = $this->shortcode_content;

	}
}
new ET_Builder_Module_Informacoes_Item;