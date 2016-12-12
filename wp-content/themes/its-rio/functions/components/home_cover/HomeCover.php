<?php

$tabs_content = '';

class ET_Builder_Module_Home_Cover extends ET_Builder_Module {
	function init() {
		$this->name            = esc_html__( 'Home ITS - Capa', 'et_builder' );
		$this->slug            = 'et_pb_home_cover';
		$this->whitelisted_fields = array(
			'src',
			'gallery_ids',
			'gallery_orderby',
			'title',
			);
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
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $data;
		$gallery_ids = $this->shortcode_atts['gallery_ids'];
		$title = $this->shortcode_atts['title'];


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
		include(__DIR__.'/view_home_cover.php');
		$output = ob_get_contents();
		ob_end_clean();
		$data['home_cover'] = $output;	

		return '';
	}
}
new ET_Builder_Module_Home_Cover;
