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
		global $wp_filter;
		global $paged;
		global $post;
		global $title;
		global $data;
		global $components;
		global $lang;

		$moduleTitle = $this->shortcode_atts['title'];
		$moduleExcerpt = $this->shortcode_atts['excerpt'];
		$categorized = $this->shortcode_atts['categorized'];

		$data['its_tabs'][] = $moduleTitle;

		$wp_filter_cache = $wp_filter;
		$meta = get_post_meta(get_the_ID());


		$ids = $meta['its_pessoas'];
		$cats = [];
		$listaCategorizada = false;
		$query_palestrantes = get_posts(['post_type' => 'pessoas', 'include' => implode(',', $ids) , 'order' => 'ASC']);
		foreach ($query_palestrantes as $postt) {
			$p = (array)$postt;
			$cat = get_the_category($p['ID']);
			if(!$cat || $categorized == 'off')
				$cats[] =  array(
					'ID' => $p['ID'],
					'title' => $p['post_title'],
					'content' => $p['post_content'],
					'thumb' => get_the_post_thumbnail_url($p['ID']),
					);
			
			if($categorized == 'on'){
				foreach($cat as $c){
					$cc = (array)$c;
					$listaCategorizada = true;
					$cats[$cc['name']]['pessoaActive'] = '';

					$cats[$cc['name']][$p['post_title']] = array(
						'ID' => $p['ID'],
						'title' => $p['post_title'],
						'content' => $p['post_content'],
						'thumb' => get_the_post_thumbnail_url($p['ID']) 
						);
				}		
			}
		}
		if($listaCategorizada){
			if($post->post_type == 'page'){
				if($lang == 'pt')
					$cats = orderPessoas($cats, ['conselho','diretores','equipe']);
				else
					$cats = orderPessoas($cats, ['board','directors','team']);
			}else{
				// $cats = orderPessoas($cats);
			}
		}

		$cats['pessoaActive'] = '';
		$components['pessoas'] = $cats;
		
		ob_start();

		if($listaCategorizada)
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

function orderPessoas($array, $order = false){
	$arFinal = [];
	foreach ($order as $o) {
		$arFinal += [$o => $array[$o] ] ;
	}

	// $cats = ['conselho' => $conselho] + ['diretores' => $diretores] + ['equipe' => $equipe] + $cats;

	if(!$order){
		foreach ($arFinal as $key => $value) {
			ksort($arFinal[$key]);
		}
	}

	return $arFinal;

}