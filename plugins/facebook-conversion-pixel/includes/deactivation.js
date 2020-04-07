/* jshint asi: true */
jQuery(document).ready(function($){
	
	var $deactivateButton = $('#the-list tr.active').filter( function() { return $(this).data('plugin') === 'pixel-cat/pixel-cat.php' || $(this).data('plugin') === 'facebook-conversion-pixel/facebook-conversion-pixel.php' } ).find('.deactivate a')
		
	$deactivateButton.click(function(e){
		e.preventDefault()
		$deactivateButton.unbind('click')
		$('body').append(fca_pc.html)
		fca_pc_uninstall_button_handlers( $deactivateButton.attr('href') )
		
	})
}) 

function fca_pc_uninstall_button_handlers( url ) {
	var $ = jQuery
	$('#fca-pc-deactivate-skip').click(function(){
		$(this).prop( 'disabled', true )
		window.location.href = url
	})
	$('#fca-pc-deactivate-send').click(function(){
		$(this).prop( 'disabled', true )
		$(this).html('...')
		$('#fca-pc-deactivate-skip').hide()
		$.ajax({
			url: fca_pc.ajaxurl,
			type: 'POST',
			data: {
				"action": "fca_pc_uninstall",
				"nonce": fca_pc.nonce,
				"msg": $('#fca-pc-deactivate-textarea').val()
			}
		}).done( function( response ) {
			console.log ( response )
			window.location.href = url			
		})	
	})
	
}