<?php 

class Partner extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'ITS - Parceiros', 'et_builder' );
		$this->slug       = 'et_pb_partner';

		$this->whitelisted_fields = array(
			'src',
			'gallery_ids',
			'gallery_orderby',
			'title',
			'module_id',
			'module_class',
			);

		$this->fields_defaults = [];
		$this->main_css_element = '%%order_class%%.et_pb_partner';
		$this->advanced_options = [];
		$this->custom_css_options = [];
	}

	function get_fields() {
		$fields = array(
			'src' => array(
				'label'           => esc_html__( 'Gallery Images', 'et_builder' ),
				'renderer'        => 'et_builder_get_gallery_settings',
				'option_category' => 'basic_option',
				),
			'title' => array(
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				),
			'gallery_ids' => array(
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
				),
			'gallery_orderby' => array(
				'label' => esc_html__( 'Gallery Images', 'et_builder' ),
				'type'  => 'hidden',
				'class' => array( 'et-pb-gallery-ids-field' ),
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
		global $data;	
		$module_id              = $this->shortcode_atts['module_id'];
		$module_class           = $this->shortcode_atts['module_class'];
		$gallery_ids            = $this->shortcode_atts['gallery_ids'];
		$title 		            = $this->shortcode_atts['title'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$attachments = array();
		if ( ! empty( $gallery_ids ) ) {
			$attachments_args = array(
				'include'        => $gallery_ids,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => 'ASC',
				'orderby'        => 'post__in',
				);

			$_attachments = get_posts( $attachments_args );

			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		}

		if ( empty($attachments) )
			return '';

		wp_enqueue_script( 'hashchange' );

		$data['its_tabs'][] = $title;

		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$width =  1080;
			$width = (int) apply_filters( 'et_pb_partner_image_width', $width );

			$height = 9999;
			$height = (int) apply_filters( 'et_pb_partner_image_height', $height );

			list($full_src, $full_width, $full_height) = wp_get_attachment_image_src( $id, 'full' );
			$gallery[] = ['src' => esc_url($full_src), 'title' => esc_attr($attachment->post_excerpt) ];
		}

		ob_start();
		include(__DIR__.'/view_partner.php');
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
new Partner;