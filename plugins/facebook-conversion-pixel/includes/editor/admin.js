/* jshint asi: true */
//////////////////
//CONFIG
//////////////////
var basic_params = [
	'value',
	'currency',
	'content_name',
	'content_type',
	'content_ids',
	'content_category',
	'search_string',
	'num_items',
	'status',
	'custom'
]

var supported_params = {

	'ViewContent': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 0,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'Search': {
		'value': 1,
		'currency': 1,
		'content_name': 0,
		'content_type': 0,
		'content_ids': 1,
		'content_category': 1,
		'search_string': 1,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'AddToCart': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 0,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'AddToWishlist': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 1,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'InitiateCheckout': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 1,
		'search_string': 0,
		'num_items': 1,
		'status': 0,
		'custom': 1
	},

	'AddPaymentInfo': {
		'value': 1,
		'currency': 1,
		'content_name': 0,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 1,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'Purchase': {
		'value': 2,
		'currency': 2,
		'content_name': 1,
		'content_type': 1,
		'content_ids': 1,
		'content_category': 0,
		'search_string': 0,
		'num_items': 1,
		'status': 0,
		'custom': 1
	},

	'Lead': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 0,
		'content_ids': 0,
		'content_category': 1,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	},

	'CompleteRegistration': {
		'value': 1,
		'currency': 1,
		'content_name': 1,
		'content_type': 0,
		'content_ids': 0,
		'content_category': 0,
		'search_string': 0,
		'num_items': 0,
		'status': 1,
		'custom': 1
	},

	'custom': {
		'value': 0,
		'currency': 0,
		'content_name': 0,
		'content_type': 0,
		'content_ids': 0,
		'content_category': 0,
		'search_string': 0,
		'num_items': 0,
		'status': 0,
		'custom': 1
	}

}

var time_delay_events = ['ViewContent', 'custom']

jQuery(document).ready(function($){

	//////////////////
	//INIT
	//////////////////
	if ( fcaPcDebug.debug ) {
		console.log ( fcaPcAdminData )
		console.log ( fcaPcPremiumData )
	}

	if ( typeof( fcaPcPremiumData ) === 'undefined' ) {
		$(  '.fca-pc-user_parameters, ' +
			'.fca-pc-utm_support, ' +
			'#fca-pc-modal-delay-input, ' +
			'#fca-pc-modal-scroll-input, ' +
			'#fca-pc-add-custom-param, ' +
			'.fca-pc-woo_extra_params, ' +
			'.fca-pc-woo_delay, ' +
			'.fca-pc-edd_extra_params, ' +
			'.fca-pc-edd_delay, ' +
			'.fca-pc-advanced_matching, ' +
			'.fca-pc-amp_integration'
		).prop('checked', false).prop('disabled', true).closest('tr').addClass('fca-pc-integration-disabled')

		$( '#fca_pc_new_pixel_id' ).addClass('fca-pc-integration-disabled')
		$( '#mode-option-css, #mode-option-hover, #mode-option-url, #custom-event-option' ).each( function() {
			$(this).html( $(this).html() + ' - Pro Only' ).prop('disabled', true )
		})

	} else {

		//PREMIUM BUILDS
		if ( fcaPcAdminData.woo_active == false ) {
			$( 	'.fca-pc-woo_extra_params, ' +
				'.fca-pc-woo_delay' ).prop('checked', false).prop('disabled', true).closest('tr').addClass('fca-pc-integration-disabled')
		}
		if ( fcaPcAdminData.edd_active == false ) {
			$(	'.fca-pc-edd_extra_params, ' +
				'.fca-pc-edd_delay' ).prop('checked', false).prop('disabled', true).closest('tr').addClass('fca-pc-integration-disabled')
		}
	}


	function draw_events() {
		$('.fca_pc_event_row').each(function(){
			draw_event( $(this), JSON.parse( $(this).find('.fca-pc-json').val() ) )
		})
	}
	draw_events()

	$('.fca_pc_multiselect').select2()
	$('#fca-pc-helptext, .fca_pc_error_tip').not('.tooltipstered').tooltipster( { trigger: 'custom', timer: 6000, maxWidth: 350, theme: ['tooltipster-borderless', 'tooltipster-pixel-cat'] } )
	$('.fca_pc_pro_tooltip, .fca_pc_tooltip, .fca_pc_event_tooltip, .fca_delete_icon, .fca_controls_icon, #fca_pc_new_pixel_id').not('.tooltipstered').tooltipster( { contentAsHTML: true, theme: ['tooltipster-borderless', 'tooltipster-pixel-cat'] } )

	//////////////////
	//EVENT HANDLERS
	//////////////////

	//PIXEL ID VALIDATION
	$('.fca-pc-id').on('input', function(e){
		var value = $(this).val()
		if ( !(/^\d+$/.test(value)) && value !== '' ) {
			$(this).val('')
			$('#fca-pc-helptext').tooltipster('open')
		}
	})

	//NAV
	$('.fca-pc-nav a').click(function(){
		$('.nav-tab-active').removeClass('nav-tab-active')
		$(this).addClass('nav-tab-active')
		$('.fca-pc-nav a').each(function(){
			$( $(this).data('target') ).hide()
		})
		$( $(this).data('target') ).show()
		$(this).blur()
	})
	$('.fca-pc-nav a').first().click()

	//TABLE HEADINGS TOGGLE CHECKBOXES
	$('.fca_pc_integrations_table th').click(function(){
		$(this).next().find('input').click()
	})

	//NEW EVENT BUTTON
	$('#fca_pc_new_event').click(function(){
		$('#fca-pc-event-save').data('eventID', '')

		//SET DEFAULTS
		$('.fca-pc-content_name').val('{post_title}')
		$('.fca-pc-content_type').val('product')
		$('.fca-pc-content_ids').val('{post_id}')
		$('.fca-pc-content_category').val('{post_category}')
		$('.fca-pc-search_string').val('')
		$('.fca-pc-num_items').val('')
		$('.fca-pc-status').val('')
		$('.fca-pc-value').val('')
		$('.fca-pc-currency').val('')
		$('.fca-pc-event_name' ).val('')

		$('#fca-pc-modal-post-trigger-input').val('').change()
		$('#fca-pc-modal-css-trigger-input').val('')
		$('#fca-pc-modal-url-trigger-input').val('')
		$('#fca-pc-modal-delay-input').val(0)
		$('#fca-pc-modal-scroll-input').val(0)

		//DEFAULT TO VIEW CONTENT EVENT
		$('#fca-pc-modal-event-input').val('ViewContent').change()

		$('#fca-pc-event-modal').show()
		$('#fca-pc-overlay').show()

	})

	//NEW PIXEL ID
	$('#fca_pc_new_pixel_id').click(function(){
		if ( !$(this).hasClass('fca-pc-integration-disabled') ) {
			$("#fca_sp_pixel_id_td").append( fcaPcPremiumData.pixelInputTemplate )
			attach_row_actions()
			$("#fca_sp_pixel_ids").show()
		}

	})

	//CANCEL DIALOG
	$('#fca-pc-event-cancel').click(function(){
		$('#fca-pc-event-modal').hide()
		$('.fca_pc_tooltip').tooltipster('hide')
		$('#fca-pc-overlay').hide()
	})

	//KEYBINDS
	$('#fca_pc_main_form').bind('keypress keydown keyup', function(e){
		var select2Open = $(e.target).hasClass('select2-search__field')

		if ( e.keyCode == 27 && !select2Open ) {
			$('#fca-pc-event-cancel').click()
		}
		if ( e.keyCode == 13 && !select2Open ) {
			e.preventDefault()
			if ( $('#fca-pc-event-modal').is(':visible') ) {
				$('#fca-pc-event-save').click()
			}
			return false
		}
    })

	//SAVE DIALOG CLICK
	$('#fca-pc-event-save').click(function(){

		var valid = true
		//DATA VALIDATION / TOOLTIPS
		$('.fca_pc_tooltip').tooltipster('close')
		if ( !$('#fca-pc-modal-post-trigger-input').val() && $('#fca-pc-modal-trigger-type-input').val() === 'post' ) {
			$('#fca-pc-modal-post-trigger-input').closest('tr').find('.fca_pc_tooltip').tooltipster('show')
			valid = false
		}
		if ( !$('#fca-pc-modal-css-trigger-input').val() && $('#fca-pc-modal-trigger-type-input').val() === 'css' ) {
			$('#fca-pc-modal-css-trigger-input').closest('tr').find('.fca_pc_tooltip').tooltipster('show')
			valid = false
		}

		if ( !$('#fca-pc-modal-url-trigger-input').val() && $('#fca-pc-modal-trigger-type-input').val() === 'url' ) {
			$('#fca-pc-modal-url-trigger-input').closest('tr').find('.fca_pc_tooltip').tooltipster('show')
			valid = false
		}

		$('.fca-required-param').each( function(){
			if ( !$(this).find('input').val() ) {
				$('#fca-pc-show-param').click()
				$(this).find('.fca_pc_tooltip').tooltipster('show')
				valid = false
			}
		})

		if ( !$('.fca-pc-event_name').val() && $('#fca-pc-modal-event-input').val() === 'custom' ) {
			$('.fca-pc-event_name').closest('tr').find('.fca_pc_tooltip').tooltipster('show')
			valid = false
		}

		if ( !valid ) {
			return false
		}

		var fbEvent = {}

		fbEvent.triggerType = $('#fca-pc-modal-trigger-type-input').val()

		switch ( fbEvent.triggerType ) {

			case 'css':
				fbEvent.trigger = $('#fca-pc-modal-css-trigger-input').val()
				break

			case 'hover':
				fbEvent.trigger = $('#fca-pc-modal-css-trigger-input').val()
				break

			case 'post':
				fbEvent.trigger = $('#fca-pc-modal-post-trigger-input').val()
				break

			case 'url':
				fbEvent.trigger = $('#fca-pc-modal-url-trigger-input').val()
				break

			default:
				break


		}

		//PARAMETERS
		fbEvent.parameters = {}
		if ( $('#fca-pc-modal-event-input').val() === 'custom' ) {
			fbEvent.event = $('.fca-pc-event_name').val()

		} else {
			//ONLY SAVE PARAMETERS THAT ARE VALID FOR THIS EVENT (?)
			fbEvent.event = $('#fca-pc-modal-event-input').val()
			for ( var i = 0; i < basic_params.length; i++ ) {
				var thisParam = basic_params[i]
				if ( supported_params[fbEvent.event][thisParam] > 0 && $('.fca-pc-' + thisParam ).val() != '' ) {
					fbEvent.parameters[thisParam] = $('.fca-pc-' + thisParam ).val()
				}
			}
		}

		//SET CUSTOM PARAMETERS
		$('.fca-pc-input-parameter-name').each(function(index, element){
			var name = $( this ).val()
			var value = $( this ).parent('td').next().find('.fca-pc-input-parameter-value').val()
			if( name && value ) {
				fbEvent.parameters[ name ] = value
			}
		})

		//DELAY
		fbEvent.delay = $('#fca-pc-modal-delay-input').val()

		//SCROLL
		fbEvent.scroll = $('#fca-pc-modal-scroll-input').val()

		fbEvent.apiAction = $('#fca-pc-modal-event-input').val() === 'custom' ? 'trackCustom' : 'track'

		//ID
		if ( $(this).data('eventID') ) {
			fbEvent.ID = $(this).data('eventID')
			//PAUSED
			fbEvent.paused = $('#' + fbEvent.ID ).hasClass('paused')

			draw_event( $('#' + fbEvent.ID ), fbEvent )

		} else {
			fbEvent.ID = fca_pc_new_GUID()
			draw_event( false, fbEvent )
		}

		$('#fca-pc-overlay').hide()
		$('#fca-pc-event-modal').hide()
	})

	//EVENT CHANGE HANDLER
	$('#fca-pc-modal-event-input').change(function(){

		var event = $(this).val()

		//RESET STATE
		$('.fca-active-param').removeClass('fca-active-param')
		$('.fca-required-param').removeClass('fca-required-param')
		$('.fca_pc_tooltip').tooltipster('hide')

		//HIDE TOOLTIPS
		$('#fca_pc_tooltip_viewcontent, #fca_pc_tooltip_lead').hide()
		$('.fca-required-param-tooltip' ).hide()

		//SET WHAT PARAMETERS ARE AVAIALBLE FOR THE EVENT
		for ( item in supported_params[event] ) {
			if ( supported_params[event][item] > 0 ) {
				//GREATER THAN 0 MEANS IT SUPPORTS THIS PARAM
				$('#fca_pc_param_' + item ).addClass('fca-active-param')
				//2 MEANS IT REQUIRES THIS PARAM
				if ( supported_params[event][item] === 2 ) {
					$('#fca_pc_param_' + item ).addClass('fca-required-param')
					$('.fca-required-param-tooltip' ).show()
					//IF WE HAVE REQUIRED PARAMS, EXPAND THE PARAMETER LIST
					$('#fca-pc-show-param').click()

				}
			}
		}

		//SET VISIBILITY BY TRIGGERING SHOW/HIDE CLICK HANDLER
		$('.fca-pc-param-toggle').not(':visible').click()

		//MAYBE SHOW THE TIME DELAY & SCROLL % OPTIONS
		if ( $('#fca-pc-modal-trigger-type-input').val() === 'post' ) {
			$('#fca-pc-modal-delay-input, #fca-pc-modal-scroll-input').closest('tr').show()
			$('#fca_pc_tooltip_viewcontent').show()
		} else {
			$('#fca-pc-modal-delay-input, #fca-pc-modal-scroll-input').closest('tr').hide()
			$('#fca_pc_tooltip_lead').show()
		}


		$('#fca_pc_param_custom' ).addClass('fca-active-param')
		//EXTRA STUFF FOR CUSTOM EVENT
		if ( event === 'custom' ) {
			$('#fca_pc_param_event_name' ).show()
		} else {
			$('#fca_pc_param_event_name' ).hide()
		}

	})

	//PARAMETER TOGGLE BUTTON
	$('.fca-pc-param-toggle').click(function(){
		$('.fca-pc-param-row').hide()
		if ( $(this).attr('id') === 'fca-pc-show-param' ) {
			$('#fca-pc-show-param').hide()
			$('#fca-pc-hide-param').show()
			$('#fca-pc-param-help').show()
			$('.fca-active-param').show()
		} else {
			$('#fca-pc-hide-param').hide()
			$('#fca-pc-show-param').show()
			$('#fca-pc-param-help').hide()
		}
	})

	//WOO FEED SETTING TOGGLE
	$('.fca-pc-woo_feed').change( function(){
		if ( this.checked ) {
			$('.fca-pc-woo-feed-settings').not('.fca-pc-woo-advanced-feed-settings').show('fast')
		} else {
			$('.fca-pc-woo-feed-settings').hide('fast')
		}

	}).change()

	//WOO ADVANCED FEED SETTINGS TOGGLE
	$('.fca-pc-feed-toggle').click(function(){
		$('.fca-pc-feed-toggle').hide()
		if ( $(this).attr('id') === 'fca-pc-show-feed-settings' ) {
			$('#fca-pc-show-feed-settings').hide()
			$('#fca-pc-hide-feed-settings').show()

			$('.fca-pc-woo-advanced-feed-settings').show()
		} else {
			$('#fca-pc-show-feed-settings').show()
			$('#fca-pc-hide-feed-settings').hide()

			$('.fca-pc-woo-advanced-feed-settings').hide()
		}
	})

	//EDD FEED SETTING TOGGLE
	$('.fca-pc-edd_feed').change( function(){
		if ( this.checked ) {
			$('.fca-pc-edd-feed-settings').show('fast')
		} else {
			$('.fca-pc-edd-feed-settings').hide('fast')
		}

	}).change()

	//CUSTOM PARAMETER TABLE
	if ( typeof fcaPcPremiumData !== 'undefined' ) {
		$('#fca-pc-add-custom-param').click( function(){
			$('#fca_pc_custom_param_table').append( fcaPcPremiumData.customParamTemplate )
			attach_row_actions()
		})
	}

	//SET INPUT VISIBILITY
	$('#fca-pc-modal-trigger-type-input').change(function(){
		//HIDE SELECT2 - BUGGY WHEN HIDING
		$('.fca_pc_multiselect').select2('close')

		$('#fca-pc-post-input-tr, #fca-pc-css-input-tr, #fca-pc-url-input-tr').hide()
		$('#fca-pc-modal-event-input').change()

		$('#fca-pc-' + $(this).val() + '-input-tr').show()
		if ( $(this).val() === 'hover' ) {
			$('#fca-pc-css-input-tr').show()
		}

	}).change()
	
	//EVENT ROW ACTIONS
	function attach_row_actions() {

		$('.fca_delete_icon_confirm').unbind( 'click' )
		$('.fca_delete_icon_confirm').click( function( e ){
			//DONT SHOW OVERLAY IF YOU CLICK DELETE
			e.stopPropagation()
			$( this ).closest( '.fca_deletable_item' ).hide( 'fast', function() {
				$( this ).remove()
			})
		})

		$('.fca_controls_icon_pause').unbind( 'click' )
		$('.fca_controls_icon_pause').click( function( e ){
			e.stopPropagation()
			var $jsonInput = $(this).closest('.fca_pc_event_row').find('.fca-pc-json')
			var event = JSON.parse( $jsonInput.val() )

			event.paused = true
			$jsonInput.val( JSON.stringify(event) )

			$(this).closest('tr').addClass('paused')
			$(this).hide().siblings('.fca_controls_icon_play').show()
		})

		$('.fca_controls_icon_play').unbind( 'click' )
		$('.fca_controls_icon_play').click( function( e ){
			e.stopPropagation()
			var $jsonInput = $(this).closest('.fca_pc_event_row').find('.fca-pc-json')
			var event = JSON.parse( $jsonInput.val() )

			event.paused = false
			$jsonInput.val( JSON.stringify(event) )


			$(this).closest('tr').removeClass('paused')
			$(this).hide().siblings('.fca_controls_icon_pause').show()

		})

		$('.fca_delete_icon_cancel').unbind( 'click' )
		$('.fca_delete_icon_cancel').click( function( e ){
			e.stopPropagation()
			$(this).hide()
			$(this).siblings('.fca_delete_icon').hide()
			$(this).siblings('.fca_delete_button').show()
		})

		$('.fca_delete_button').unbind( 'click' )
		$('.fca_delete_button').click( function( e ){
			e.stopPropagation()
			$(this).hide().siblings('.fca_delete_icon').show()

		})

		//EDIT EVENT CLICK
		$('.fca_pc_event_row').unbind( 'click' )
		$('.fca_pc_event_row').click( function( click ){

			//SET THE SAVE BUTTON TO THIS ID
			$('#fca-pc-event-save').data( 'eventID', $(this).attr('ID') )
			load_event( JSON.parse( $(this).find('.fca-pc-json').val() ) )
			$('#fca-pc-event-modal').show()
			$('#fca-pc-overlay').show()

		})

		//ATTACH TOOLTIPS
		$('.fca_delete_icon, .fca_controls_icon').not('.tooltipstered').tooltipster( { contentAsHTML: true, theme: ['tooltipster-borderless', 'tooltipster-pixel-cat'] } )

	}
	attach_row_actions()

	//TRIGGER NAVIGATION CONFIRM PROMPT FOR THIS PAGE
	var confirmUnload = true

	$('input, select').on( 'input, change', function() {
		window.onbeforeunload = function() {
			return confirmUnload
		}
	})


	$('#fca_pc_save').click( function() {
		confirmUnload = null
	})

	//THE PAGE IS HIDDEN UNTIL NOW
	$('#fca_pc_main_form, #fca-pc-marketing-metabox').show()

	///////////////////
	//HELPER FUNCTIONS
	///////////////////

	function draw_event( $target, event ) {
		if ( fcaPcDebug.debug ) {
			console.log ( $target, event )
		}
		if ( $target ) {
			$target.attr('id', event.ID )

			$target.find('.fca-pc-event-td').html( event.event )
			$target.find('.fca-pc-trigger-td').html( get_event_trigger_names( event.trigger ) )


			$target.removeClass('paused')
			$target.find('.fca_controls_icon_play').hide().siblings('.fca_controls_icon_pause').show()

			if ( event.paused ) {
				$target.addClass('paused')
				$target.find('.fca_controls_icon_pause').hide().siblings('.fca_controls_icon_play').show()

			}
		} else {
			$('#fca-pc-events').append(
				fcaPcAdminData.eventTemplate.replace( '{{EVENT}}', event.event )
											.replace( '{{TRIGGER}}', get_event_trigger_names( event.trigger ) )
											.replace( '{{ID}}', event.ID )
			)
			attach_row_actions()
		}
		$('#' + event.ID ).find('.fca-pc-json').val( JSON.stringify( event ) )
	}



	function get_event_trigger_names( triggers ) {
		if ( typeof triggers === 'string' ) {
			return triggers
		} else {
			var array = []
			$('#fca-pc-modal-post-trigger-input option').filter( function( index, element ){
				return triggers.indexOf( $(element).val() ) !== -1
			}).each( function() {
				array.push( $(this).html() )
			})
			return array.join(', ')
		}
	}

	//LOAD THE MODAL WITH EVENT DATA
	function load_event( event ) {

		//CLEAR CUSTOM PARAMETERS
		$( '#fca_pc_custom_param_table' ).find( '.fca_delete_icon_confirm' ).click()

		//STANDARD EVENTS
		if ( supported_params.hasOwnProperty( event.event ) ) {
			$('#fca-pc-modal-event-input').val( event.event ).change()

			//SET PARAMS
			for ( var i = 0; i < basic_params.length; i++) {
				if ( event.parameters.hasOwnProperty( basic_params[i] ) ) {
					//set
					$('.fca-pc-' + basic_params[i] ).val( event.parameters[basic_params[i]] )
				} else {
					//reset
					$('.fca-pc-' + basic_params[i] ).val('')
				}
			}

			//SET CUSTOM PARAMS
			for ( var eventParam in event.parameters ) {

				if ( basic_params.indexOf( eventParam ) === -1 ) {
					$( '#fca-pc-add-custom-param' ).click()
					$( '.fca-pc-input-parameter-name' ).last().val( eventParam )
					$( '.fca-pc-input-parameter-value' ).last().val( event.parameters[eventParam] )
				}

			}

		} else {
			//CUSTOM EVENTS
			$('#fca-pc-modal-event-input').val( 'custom' ).change()
			$('.fca-pc-event_name').val( event.event )

			//SET PARAMS
			for ( var eventParam in event.parameters ) {
				$( '#fca-pc-add-custom-param' ).click()
				$( '.fca-pc-input-parameter-name' ).last().val( eventParam )
				$( '.fca-pc-input-parameter-value' ).last().val( event.parameters[eventParam] )
			}
		}

		var delay = event.hasOwnProperty('delay') ? event.delay : 0
		$('#fca-pc-modal-delay-input').val( delay )

		var scroll = event.hasOwnProperty('scroll') ? event.scroll : 0
		$('#fca-pc-modal-scroll-input').val( scroll )

		//LOAD TRIGGERS

		$('#fca-pc-modal-trigger-type-input').val( event.triggerType ).change()
		switch ( event.triggerType ) {

			case 'post':
				$('#fca-pc-modal-post-trigger-input').children().each(function(){
					if ( event.trigger.indexOf( $(this).val() ) !== -1 ) {
						$(this).prop('selected', true)
					} else {
						$(this).prop('selected', false)
					}
				}).change()
				break
			case 'css':
				$('#fca-pc-modal-css-trigger-input').val( event.trigger )
				break

			case 'hover':
				$('#fca-pc-modal-css-trigger-input').val( event.trigger )
				break

			case 'url':
				$('#fca-pc-modal-url-trigger-input').val( event.trigger )
				break
		}

	}

	//GUID Generation ( http://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript/21963136#21963136 )
	var fca_pc_hash_seed = []
	for (var i=0; i<256; i++) {
		fca_pc_hash_seed[i] = (i<16?'0':'')+(i).toString(16)
	}
	function fca_pc_new_GUID() {
		var d0 = Math.random()*0x100000000>>>0
		var d1 = Math.random()*0x100000000>>>0
		var d2 = Math.random()*0x100000000>>>0
		var d3 = Math.random()*0x100000000>>>0

		return fca_pc_hash_seed[d0&0xff]+fca_pc_hash_seed[d0>>8&0xff]+fca_pc_hash_seed[d0>>16&0xff]+fca_pc_hash_seed[d0>>24&0xff]+'-'+
		fca_pc_hash_seed[d1&0xff]+fca_pc_hash_seed[d1>>8&0xff]+'-'+fca_pc_hash_seed[d1>>16&0x0f|0x40]+fca_pc_hash_seed[d1>>24&0xff]+'-'+
		fca_pc_hash_seed[d2&0x3f|0x80]+fca_pc_hash_seed[d2>>8&0xff]+'-'+fca_pc_hash_seed[d2>>16&0xff]+fca_pc_hash_seed[d2>>24&0xff]+
		fca_pc_hash_seed[d3&0xff]+fca_pc_hash_seed[d3>>8&0xff]+fca_pc_hash_seed[d3>>16&0xff]+fca_pc_hash_seed[d3>>24&0xff]
	}
})
