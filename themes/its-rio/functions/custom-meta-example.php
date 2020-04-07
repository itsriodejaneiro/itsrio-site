<?php
function prfx_custom_meta() {
	add_meta_box( 'prfx_meta', __( 'Meta Box Title', 'prfx-textdomain' ), 'prfx_meta_callback', 'cursos_ctp' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>
	<p>
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
	</p> 
	<?php
}

function prfx_meta_save( $post_id ) {

	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox', '' );
	}

	if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox-two', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox-two', '' );
	}

}
add_action( 'save_post', 'prfx_meta_save' );