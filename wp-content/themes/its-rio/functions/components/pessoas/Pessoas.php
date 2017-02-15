<?php
class Pessoas extends ET_Builder_Module {

	function init() {
		$this->name = esc_html__( 'ITS - Pessoas', 'et_builder' );
		$this->slug = 'et_pb_pessoas';
		$this->fb_support = true;

		$this->whitelisted_fields = ['title','excerpt','categorized'];

		$this->fields_defaults = [];

		$this->main_css_element = '%%order_class%% .et_pb_post';
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'             => esc_html__( 'Título', 'et_builder' ),
				'type'              => 'text',
				),
			'excerpt' => array(
				'label'             => esc_html__( 'Texto (opcional)', 'et_builder' ),
				'type'              => 'text',
				),
			'categorized' => array(
				'label'             => esc_html__( 'Agrupar pessoas por categoria?', 'et_builder' ),
				'type'              => 'yes_no_button',
				'options'           => array(
					'off' => esc_html__( "Não", 'et_builder' ),
					'on'  => esc_html__( 'Sim', 'et_builder' ),
					),
				),
			);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		global $post;
		global $title;
		global $data;
		global $components;
		global $lang;

		$moduleTitle = $this->shortcode_atts['title'];
		$moduleExcerpt = $this->shortcode_atts['excerpt'];
		$categorized = $this->shortcode_atts['categorized'];

		$data['its_tabs'][] = $moduleTitle;

		$meta = get_post_meta(get_the_ID());

		$ids = $meta['its_pessoas'];
		$filter_cats = [];
		$filter_cats_ar = explode(',', $meta['its_pessoas_cat'][0]);

		foreach ($filter_cats_ar as $f)
			$filter_cats[] = trim($f);
		
		$list_of_posts = [];
		
		if($categorized == 'off'){
			$query_palestrantes = get_posts(['post_type' => 'pessoas', 'include' => implode(',', $ids), 'order' => 'ASC', 'orderby' => 'title', 'posts_per_page' => -1]);
			foreach ($query_palestrantes as $postt) {
				$list_of_posts[] =  array(
					'ID' => $postt->ID,
					'title' => $postt->post_title,
					'content' => $postt->post_content,
					'thumb' => get_the_post_thumbnail_url($postt->ID),
					);
			}
		}else{
			if(empty($filter_cats) || is_null($filter_cats) || count($filter_cats) == 0){
				$categories = get_terms('category', array('post_type' => ['pessoas'], 'fields' => 'all', 'orderby' => 'title', 'order' => 'ASC'));
				foreach ($categories as $cat) 
					$filter_cats[] = $cat->name;
			}

			$posts = get_posts([ 'post_type' => 'pessoas','posts_per_page' => -1, 'include' => $ids, 'order' => 'ASC', 'orderby' => 'title']);

			foreach ($filter_cats as $cat) {
				foreach ($posts as $post) {
					if(has_category($cat, $post)){
						$list_of_posts[$cat]['pessoaActive'] = '';

						$list_of_posts[$cat][] = array(
							'ID' => $post->ID,
							'title' => $post->post_title,
							'content' => $post->post_content,
							'thumb' => get_the_post_thumbnail_url($post->ID) 
							);
					}
				}
			}
		}

		$list_of_posts['pessoaActive'] = '';
		$components['pessoas'] = $list_of_posts;
		$firstCat = isset($filter_cats[0]) ? $filter_cats[0] : '';

		ob_start();

		if($categorized == 'on')
			include(__DIR__.'/view_pessoas_cat.php');
		else
			include(__DIR__.'/view_pessoas.php');

		$output = ob_get_contents();

		ob_end_clean();

		$wp_filter = $wp_filter_cache;
		unset($wp_filter_cache);

		wp_reset_postdata();

		return $output;
	}
}

new Pessoas;

function orderPessoas($order, $array){
	$arFinal = [];
	foreach ($order as $o) {
		$arFinal += [$o => $array[$o] ] ;
	}

	// $cats = ['conselho' => $conselho] + ['diretores' => $diretores] + ['equipe' => $equipe] + $cats;

	foreach ($cats as $key => $value) {
		ksort($cats[$key]);
	}

	return $arFinal;

}