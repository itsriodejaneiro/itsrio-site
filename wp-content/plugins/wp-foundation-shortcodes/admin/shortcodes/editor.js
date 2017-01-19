/*
 *      This file taken from "Cherry Plugin": http://www.cherryframework.com/update/meet-the-cherry-plugin-bare-functionalities-no-strings-attached/
 *      Makes small changes 2015-08
 * */

(function() {
	// TinyMCE plugin start.
	tinymce.PluginManager.add( 'FoundationTinyMCEShortcodes', function( editor, url ) {
		// Register a command to open the dialog.
		editor.addCommand( 'wp_foundation_shortcodes_open_dialog', function( ui, v ) {
			foundationSelectedShortcodeType = v;
			selectedText = editor.selection.getContent({format: 'text'});
			tb_dialog_helper.loadShortcodeDetails();
			tb_dialog_helper.setupShortcodeType( v );

			jQuery( '#shortcode-options' ).addClass( 'shortcode-' + v );
			jQuery( '#selected-shortcode' ).val( v );

			var f=jQuery(window).width();
			b=jQuery(window).height();
			f=720<f?720:f;
			f+=32;
			b-=120;

			tb_show( "Insert ["+ v +"] shortcode", "#TB_inline?width="+f+"&height="+b+"&inlineId=dialog" );
		});

		// Register a command to insert the self-closing shortcode immediately.
		editor.addCommand( 'wp_foundation_shortcodes_insert_self_immediate', function( ui, v ) {
			editor.insertContent( '[' + v + ']' );
		});

		// Register a command to insert the enclosing shortcode immediately.
		editor.addCommand( 'wp_foundation_shortcodes_insert_immediate', function( ui, v ) {
			var selected = editor.selection.getContent({format: 'text'});

			editor.insertContent( '[' + v + ']' + selected + '[/' + v + ']' );
		});

		// Register a command to insert the N-enclosing shortcode immediately.
		editor.addCommand( 'wp_foundation_shortcodes_insert_immediate_n', function( ui, v ) {
			var arr = v.split('|'),
				selected = editor.selection.getContent({format: 'text'}),
				sortcode;

			for (var i = 0, len = arr.length; i < len; i++) {
				if (0 === i) {
					sortcode = '[' + arr[i] + ']' + selected + '[/' + arr[i] + ']';
				} else {
					sortcode += '[' + arr[i] + '][/' + arr[i] + ']';
				};
			};
			editor.insertContent( sortcode );
		});
		
		// Register a command to insert the Grid shortcode immediately.
		editor.addCommand( 'wp_foundation_shortcodes_insert_immediate_grid', function( ui, v ) {
                        var arr = v.split('|'),
                                selected = editor.selection.getContent({format: 'text'}),
                                sortcode = '';

                        for (var i = 0, len = arr.length; i < len; i++) {
	                        sortcode += '[columns class="' + arr[i] + '"] '+arr[i]+' [/columns]';
                        };
                        editor.insertContent( '[row] '+sortcode+' [/row]' );
                });

		// Register a command to insert `Accordion` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_accordions', function( ui, v ) {
			editor.insertContent( '[accordions custom_class="your_custom_class"] [accordion title="title1" active="yes"] tab content [/accordion] [accordion title="title2"] another content tab [/accordion] [/accordions]' );
		});

		// Register a command to insert `Table` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_table', function( ui, v ) {
			editor.insertContent( '[table caption="Foundation table" colwidth="20|100|50" colalign="left|left|center|left|right" custom_class="your_custom_class"]<br/>num|head1|head2|head3|head4<br/>1|row1col1|row1col2|row1col3|100<br/>2|row2col1|row2col2|row2col3|200<br/>3|row3col1|row3col2|row3col3|300<br/>4|row4col1|row4col2|row4col3|400<br/>[/table]' );
		});

		// Register a command to insert `Equalizer` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_equalizer', function( ui, v ) {
                        editor.insertContent( '[equalizers custom_class="your_custom_class"] [equalizer title="Panel 1"] Panel 1 text ... [/equalizer] [equalizer title="Panel 2"] Panel 2 text ... [/equalizer] [equalizer title="Panel 3" custom_class="callout"] Panel 3 a lot of text text text text... [/equalizer] [/equalizers]' );
                });

		// Register a command to insert `Blocks Grid` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_blocks_grid', function( ui, v ) {
                        editor.insertContent( '[blocks_grid class="small-block-grid-2 medium-block-grid-3 large-block-grid-4"] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?1"></a> [/block_grid] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?2"></a> [/block_grid] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?3"></a> [/block_grid] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?4"></a> [/block_grid] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?5"></a> [/block_grid] [block_grid] <a class="th"><img src="http://lorempixel.com/400/400/?6"></a> [/block_grid] [/blocks_grid]' );
                });

		// Register a command to insert `Orbit Slider` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_orbit_slider', function( ui, v ) {
                        editor.insertContent( '[orbit_sliders] [orbit_slider title="Caption One."]<img src="http://lorempixel.com/1000/300/?1">[/orbit_slider] [orbit_slider title="Caption Two."]<img src="http://lorempixel.com/1000/300/?2">[/orbit_slider] [orbit_slider title="Caption Three."]<img src="http://lorempixel.com/1000/300/?3">[/orbit_slider] [/orbit_sliders] ' );
                });

		// Register a command to insert `Clearing Lightbox` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_clearing_lightbox', function( ui, v ) {
                        editor.insertContent( '[clearing_thumbs class="small-block-grid-2 medium-block-grid-3 large-block-grid-4"] [clearing_thumb title="caption here..." url="http://lorempixel.com/1120/720/?1"] http://lorempixel.com/400/400/?1 [/clearing_thumb] [clearing_thumb title="caption here..." url="http://lorempixel.com/1120/720/?2"] http://lorempixel.com/400/400/?2 [/clearing_thumb] [clearing_thumb title="caption here..." url="http://lorempixel.com/1120/720/?3"] http://lorempixel.com/400/400/?3 [/clearing_thumb] [clearing_thumb title="caption here..." url="http://lorempixel.com/1120/720/?4"] http://lorempixel.com/400/400/?4 [/clearing_thumb] [clearing_thumb title="caption here..." url="http://lorempixel.com/1120/720/?5"] http://lorempixel.com/400/400/?5 [/clearing_thumb] [/clearing_thumbs]' );
                });

		// Register a command to insert `Inline List` shortcode.
		editor.addCommand( 'wp_foundation_shortcodes_insert_inline_list', function( ui, v ) {
                        editor.insertContent( '[inline_list custom_class="your_custom_class"] [link url="#"] Link 1 [/link] [link url="#"] Link 2 [/link] [link url="#"] Link 3 [/link] [link url="#"] Link 4 [/link] [link url="#"] Link 5 [/link] [/inline_list]' );
                });

		// Add a button that opens a window
		editor.addButton( 'wp_foundation_shortcodes_shortcodes_button', {
			type: 'menubutton',
			icon: 'icon foundation-icon',
			tooltip: 'Insert a Foundation Shortcode',
			menu: [
				// Posts
				{text: 'Posts', menu: [
					{text: 'Posts Grid', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'posts_grid', { title: 'Posts Grid' } ); } },
					{text: 'Posts List', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'posts_list', { title: 'Posts List' } ); } },
					{text: 'Posts Lightbox', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'posts_lightbox', { title: 'Posts Lightbox' } ); } },
					{text: 'Posts Cycle', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'posts_cycle', { title: 'Posts Cycle' } ); } }
				]},
				// Buttons
				{text: 'Buttons', menu: [
					{text: 'Button', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'button', { title: 'Button' } ); } },
					{text: 'Button Groups', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'button_groups', { title: 'Button Groups' } ); } },
					{text: 'Radio Button Groups', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'radio_button_groups', { title: 'Radio Button Groups' } ); } },
					{text: 'Split Button', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'split_button', { title: 'Split Button' } ); } },
					{text: 'Dropdown', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'dropdown', { title: 'Dropdown' } ); } },
					{text: 'Button Option Groups', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'button_option_groups', { title: 'Button Option Groups' } ); } }
				]},
				// Elements menu.
				{text: 'Elements', menu: [
					{text: 'Label', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'label', { title: 'Label' } ); } },
					{text: 'Blockquote', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'blockquote', { title: 'Blockquote' } ); } },
					{text: 'Icon', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'icon', { title: 'Icon' } ); } },
					{text: 'Address', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'address', { title: 'Address' } ); } },
					{text: 'Inline List', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_inline_list', false, 'inline_list', { title: 'Inline List' } ); } },
					{text: 'Keystroke', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'keystroke', { title: 'Keystroke' } ); } },
					{text: 'Horizontal rule', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'hr', { title: 'Horizontal rule' } ); } },
					{text: 'Clear', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_self_immediate', false, 'clear', { title: 'Clear' } ); } }
				]},
				// Callouts & Prompts menu.
				{text: 'Callouts & Prompts', menu: [
					{text: 'Alert Box', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'alert_box', { title: 'Alert Box' } ); } },
					{text: 'Panel', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'panel', { title: 'Panel' } ); } },
					{text: 'Tooltip', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'tooltip', { title: 'Tooltip' } ); } },
					{text: 'Banner', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'banner', { title: 'Banner' } ); } },
					{text: 'Service Box', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'service_box', { title: 'Service Box' } ); } },
					{text: 'Comments', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'comments', { title: 'Comments' } ); } },
					{text: 'Categories', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'categories', { title: 'categories' } ); } },
					{text: 'Tags', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_self_immediate', false, 'tags', { title: 'Tags' } ); } }
				]},
				// Content.
				{text: 'Content', menu:[
					{text: 'Pricing Table', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'pricing_table', { title: 'Pricing Table' } ); } },
					{text: 'Progressbar', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'progressbar', { title: 'Progressbar' } ); } },
					{text: 'Table', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_table', false, 'table', { title: 'Table' } ); } },
					{text: 'Accordion', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_accordions', false, 'accordions', { title: 'Accordion' } ); } },
					{text: 'Tabs', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'tabs', { title: 'Tabs' } ); } },
					{text: 'Equalizer', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_equalizer', false, 'equalizer', { title: 'Equalizer' } ); } },
				]},
				// 2 col Grid
				{text: '2 Columns Grid', menu: [
                                        {text: '1/2 | 1/2', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-6|medium-6', { title: '1/2 | 1/2' } ); } },
                                        {text: '2/3 | 1/3', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-8|medium-4', { title: '2/3 | 1/3' } ); } },
                                        {text: '1/3 | 2/3', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-4|medium-8', { title: '1/3 | 2/3' } ); } }
                                ]},
				// 3 col grid
				{text: '3 Columns Grid', menu: [
                                        {text: '1/3 | 1/3 | 1/3', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-4|medium-4|medium-4', { title: '1/3 | 1/3 | 1/3' } ); } },
                                        {text: '1/2 | 1/4 | 1/4', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-6|medium-3|medium-3', { title: '1/2 | 1/4 | 1/4' } ); } },
                                        {text: '1/4 | 1/2 | 1/4', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-3|medium-6|medium-3', { title: '1/4 | 1/2 | 1/4' } ); } },
                                        {text: '1/4 | 1/4 | 1/2', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'medium-3|medium-3|medium-6', { title: '1/4 | 1/4 | 1/2' } ); } }
                                ]},
				// 4 col grid
				{text: '4 Columns Grid', menu: [
                                        {text: '1/4 | 1/4 | 1/4 | 1/4', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_immediate_grid', false, 'small-6 medium-3|small-6 medium-3|small-6 medium-3|small-6 medium-3', { title: '1/4 | 1/4 | 1/4 | 1/4' } ); } }
                                ]},
				// Blocks grid
				{text: 'Blocks Grid', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_blocks_grid', false, 'blocks_grid', { title: 'Blocks Grid' } ); } },
				// Widgets
				{text: 'Widgets', menu: [
					{text: 'Google Map', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'google_map', { title: 'Google Map' } ); } },
					{text: 'Product Card', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'product_card', { title: 'Product Card' } ); } },
					{text: 'Product Card with hover effects', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'product_card_hover', { title: 'Product Card with hover effects' } ); } },
					{text: 'Social Login Button', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'social_login_button', { title: 'Social Login Button' } ); } }
				]},
				// Media
				{text: 'Media', menu: [
					{text: 'Orbit Slider', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_orbit_slider', false, 'table', { title: 'Orbit Slider' } ); } },
					{text: 'Slick Slider', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'slick_slider', { title: 'Slick Slider' } ); } },
					{text: 'Thumbnail', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'thumbnail', { title: 'Thumbnail' } ); } },
					{text: 'Clearing Lightbox', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_insert_clearing_lightbox', false, 'clearing_lightbox', { title: 'Clearing Lightbox' } ); } },
					{text: 'Video', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'video', { title: 'Video' } ); } },
					
				]},
				// Forms
				{text: 'Forms', menu: [
					{text: 'Switch', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'switch', { title: 'Switch' } ); } },
					{text: 'Range Slider', onclick: function() { editor.execCommand( 'wp_foundation_shortcodes_open_dialog', false, 'range_slider', { title: 'Range Slider' } ); } }
				]}
	
			
			]
		});
	}); // TinyMCE plugin end.
})();
