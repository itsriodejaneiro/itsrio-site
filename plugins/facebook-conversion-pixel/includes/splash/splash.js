/* jshint asi: true */
jQuery(document).ready(function($){
	
	var footerMarginTop = parseInt ( $('#fca-splash-footer').css('margin-top') )

	$('#fca-splash-permissions-toggle').click(function(event){
		event.preventDefault()
		$('#fca-splash-permissions-dropdown').toggle()

		if ( $('#fca-splash-permissions-dropdown:visible').length == 1 ) {
			$('#fca-splash-footer').css('margin-top', footerMarginTop - 208 + 'px' )
		} else {
			$('#fca-splash-footer').css('margin-top', footerMarginTop + 'px' )
		}
		
	})
}) 