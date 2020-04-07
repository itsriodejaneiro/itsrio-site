<?php 
		
function fca_pc_amp_integration() {
	
	$options = get_option( 'fca_pc', array() );
	$pixel = empty ( $options['id'] ) ? '' : $options['id'];
	
	if ( $pixel ) {
		echo "<amp-pixel src='https://www.facebook.com/tr?id=$pixel&ev=PageView&noscript=1' layout='nodisplay'></amp-pixel>";
	}
			
	if ( isset( $options['ids'] ) && is_array( $options['ids'] ) ) {
		forEach ( $options['ids'] as $pixel ) {
			echo "<amp-pixel src='https://www.facebook.com/tr?id=$pixel&ev=PageView&noscript=1' layout='nodisplay'></amp-pixel>";
		}
	}
	
}
//AUTOMATTIC GOOGLE AMP PLUGIN
add_action( 'amp_post_template_footer', 'fca_pc_amp_integration' );

//AMP for WP 
add_action( 'amp_end', 'fca_pc_amp_integration' );