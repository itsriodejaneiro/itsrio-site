<?php

add_filter( 'rwmb_meta_boxes', 'its_meta_boxes' );

function its_meta_boxes($meta_boxes) {
	$query_publicacoes = new WP_Query(['post_type' => 'publicacoes_ctp', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC']);
	$publicacoes = [];

	while ( $query_publicacoes->have_posts() ) : $query_publicacoes->the_post();
	$publicacoes[get_the_ID()]=get_the_title();
	wp_reset_query();
	wp_reset_postdata();
	endwhile;

	$query_pessoas = new WP_Query(['post_type' => 'pessoas', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC']);
	$pessoas = [];

	while ( $query_pessoas->have_posts() ) : $query_pessoas->the_post();
	$pessoas[get_the_ID()]=get_the_title();
	wp_reset_query();
	wp_reset_postdata();
	endwhile;

	$meta_boxes = array([
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['publicacoes_ctp','projetos_ctp'],
		'fields'     => array(
			['id'   => 'info_header', 'name' => __('Linha de Pesquisa', 'textdomain'), 'type' => 'text']
			),
		],
		[
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['cursos_ctp'],
		'fields'     => array(
			['id'   => 'info_inscinicio', 'name' => __('Início das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_inscfim', 'name' => __('Fim das Inscrições', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_cursoinicio', 'name' => __('Início do Curso', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_valor', 'name' => __('Coluna com informações de valor', 'textdomain'), 'type' => 'wysiwyg'],
			)
		],
		[
		'title'      => __('Informações', 'textdomain' ),
		'post_types' => ['varandas_ctp'],
		'fields'     => array(
			['id'   => 'info_inscfim', 'name' => __('Data do evento', 'textdomain'), 'type' => 'date'],
			['id'   => 'info_datahorario', 'name' => __('Data e Horário', 'textdomain'), 'type' => 'text'],
			)
		],
		[
		'id'         => 'its_publicacoes',
		'title'      => __( 'Publicações', 'batuta_' ),
		'post_types' => [ 'projetos_ctp', 'varandas_ctp', 'cursos_ctp'],
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'        => __( 'Publicações', 'batuta_' ),
				'id'          => "its_publicacoes",
				'type'        => 'select_advanced',
				'options'     => $publicacoes,
				'multiple'    => true,
				'std'         => 'value2',
				'placeholder' => __( 'Selecione as publicações', 'galeria_se' ),
				),
			)
		],
		[
		'id'         => 'its_pessoas',
		'title'      => __( 'Equipe, Palestrantes e Autores', 'batuta_' ),
		'post_types' => [ 'varandas_ctp', 'cursos_ctp','page', 'comunicados_ctp' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			array(
				'name'        => __( 'Palestrantes e Autores', 'batuta_' ),
				'id'          => "its_pessoas",
				'type'        => 'select_advanced',
				'options'     => $pessoas,
				'multiple'    => true,
				'std'         => 'value2',
				'placeholder' => __( 'Selecione as pessoas', 'galeria_se' ),
				),
			)
		],
		);
	return $meta_boxes;
}





// function prfx_custom_meta() {
// 	add_meta_box( 'prfx_meta', __( 'Meta Box Title', 'prfx-textdomain' ), 'prfx_meta_callback', 'cursos_ctp' );
// }
// add_action( 'add_meta_boxes', 'prfx_custom_meta' );

// function prfx_meta_callback( $post ) {
// 	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
// 	$prfx_stored_meta = get_post_meta( $post->ID );
if(1 == 2) :?>
	<!-- <p>
		<span class="prfx-row-title"><?php _e( 'Example Checkbox Input', 'prfx-textdomain' )?></span>
		<div class="prfx-row-content">
			<label for="meta-checkbox">
				<input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox'] ) ) checked( $prfx_stored_meta['meta-checkbox'][0], 'yes' ); ?> />
				<?php _e( 'Checkbox label', 'prfx-textdomain' )?>
			</label>
			<label for="meta-checkbox-two">
				<input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-two'] ) ) checked( $prfx_stored_meta['meta-checkbox-two'][0], 'yes' ); ?> />
				<?php _e( 'Another checkbox', 'prfx-textdomain' )?>
			</label>
		</div>
	</p> -->
	<?php
	endif;
 //}

// function prfx_meta_save( $post_id ) {

// 	$is_autosave = wp_is_post_autosave( $post_id );
// 	$is_revision = wp_is_post_revision( $post_id );
// 	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

// 	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
// 		return;
// 	}

// 	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
// 		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
// 	} else {
// 		update_post_meta( $post_id, 'meta-checkbox', '' );
// 	}

// 	// var_dump($_POST[ 'meta-checkbox-two' ]);
// 	// die;
// 	if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
// 		update_post_meta( $post_id, 'meta-checkbox-two', 'yes' );
// 	} else {
// 		update_post_meta( $post_id, 'meta-checkbox-two', '' );
// 	}

// }
// add_action( 'save_post', 'prfx_meta_save' );
