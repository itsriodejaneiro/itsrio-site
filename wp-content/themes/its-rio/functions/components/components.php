<?php


function my_et_builder_post_types( $post_types ) {
	$post_types[] = 'varandas_ctp';
	$post_types[] = 'projetos_ctp';
	$post_types[] = 'cursos_ctp';
	$post_types[] = 'publicacoes_ctp';


	return $post_types;
}

add_filter( 'et_builder_post_types', 'my_et_builder_post_types' );


function DS_Custom_Modules(){
	if(class_exists("ET_Builder_Module")){
		include("related_content/RelatedContent.php");
		include("aula/Aula.php");
	}
}

function Prep_DS_Custom_Modules(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' );
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'DS_Custom_Modules', 9789);
	}
}

Prep_DS_Custom_Modules();

function dd($a)
{
	var_dump($a);
	die;
}