<?php

////////////////////////////
// SETTINGS PAGE
////////////////////////////

function fca_pc_plugin_menu() {

	add_menu_page(
		__( 'Pixel Cat', 'facebook-conversion-pixel' ),
		__( 'Pixel Cat', 'facebook-conversion-pixel' ),
		'manage_options',
		'fca_pc_settings_page',
		'fca_pc_settings_page',
		FCA_PC_PLUGINS_URL . '/assets/icon.png',
		119
	);

}
add_action( 'admin_menu', 'fca_pc_plugin_menu' );

//ENQUEUE ANY SCRIPTS OR CSS FOR OUR ADMIN PAGE EDITOR
function fca_pc_admin_enqueue() {

	wp_enqueue_style('dashicons');
	wp_enqueue_script('jquery');

	wp_enqueue_script( 'fca_pc_select2', FCA_PC_PLUGINS_URL . '/includes/select2/select2.min.js', array(), FCA_PC_PLUGIN_VER, true );
	wp_enqueue_style( 'fca_pc_select2', FCA_PC_PLUGINS_URL . '/includes/select2/select2.min.css', array(), FCA_PC_PLUGIN_VER );

	wp_enqueue_style( 'fca_pc_tooltipster_stylesheet', FCA_PC_PLUGINS_URL . '/includes/tooltipster/tooltipster.bundle.min.css', array(), FCA_PC_PLUGIN_VER );
	wp_enqueue_style( 'fca_pc_tooltipster_borderless_css', FCA_PC_PLUGINS_URL . '/includes/tooltipster/tooltipster-borderless.min.css', array(), FCA_PC_PLUGIN_VER );
	wp_enqueue_script( 'fca_pc_tooltipster_js',FCA_PC_PLUGINS_URL . '/includes/tooltipster/tooltipster.bundle.min.js', array('jquery'), FCA_PC_PLUGIN_VER, true );

	$admin_dependencies = array('jquery', 'fca_pc_select2', 'fca_pc_tooltipster_js' );

	if ( FCA_PC_DEBUG ) {
		wp_enqueue_script('fca_pc_admin_js', FCA_PC_PLUGINS_URL . '/includes/editor/admin.js', $admin_dependencies, FCA_PC_PLUGIN_VER, true );
		wp_enqueue_style( 'fca_pc_admin_stylesheet', FCA_PC_PLUGINS_URL . '/includes/editor/admin.css', array(), FCA_PC_PLUGIN_VER );
	} else {
		wp_enqueue_script('fca_pc_admin_js', FCA_PC_PLUGINS_URL . '/includes/editor/admin.min.js', $admin_dependencies, FCA_PC_PLUGIN_VER, true );
		wp_enqueue_style( 'fca_pc_admin_stylesheet', FCA_PC_PLUGINS_URL . '/includes/editor/admin.min.css', array(), FCA_PC_PLUGIN_VER );
	}
	$options = get_option( 'fca_pc', array() );
	$events = empty( $options['event_json'] ) ? json_encode( array() ) : stripslashes_deep( $options['event_json'] );

	$admin_data = array (
		'ajaxurl' => admin_url ( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'fca_pc_admin_nonce' ),
		'eventTemplate' => fca_pc_event_row_html(),
		'premium' => function_exists ('fca_pc_add_premium_event_form'),
		'edd_active' => is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' ),
		'woo_active' => is_plugin_active( 'woocommerce/woocommerce.php' ),
	);
	wp_localize_script( 'fca_pc_admin_js', 'fcaPcDebug', array( 'debug' => FCA_PC_DEBUG ) );
	wp_localize_script( 'fca_pc_admin_js', 'fcaPcAdminData', $admin_data );

	if ( function_exists( 'fca_pc_editor_premium_data' ) ) {
		fca_pc_editor_premium_data();
	}

}

function fca_pc_settings_page() {

	$options = get_option( 'fca_pc', array() );

	if ( isSet( $_POST['fca_pc_save'] ) ) {
		$options = fca_pc_settings_save();
	}

	if ( isSet( $_GET['fca_pc_downgrade'] ) ) {
		update_option( 'fca_pc_upgrade_complete', false );
		echo '<script>window.location="' . admin_url('options-general.php?page=fb_pxl_options') . '"</script>';
		exit;
	}

	$form_class = FCA_PC_PLUGIN_PACKAGE === 'Lite' ? 'fca-pc-free' : 'fca-pc-premium';

	$pixel_id = empty ( $options['id'] ) ? '' : $options['id'];
	$pixel_ids = empty ( $options['ids'] ) ? array() : $options['ids'];
	$options['events'] = empty ( $options['events'] ) ? array() : $options['events'];

	fca_pc_admin_enqueue();


	$html = "<div id='fca-pc-overlay' style='display:none'></div>";

	$html .= "<form novalidate style='display: none' action='' method='post' id='fca_pc_main_form' class='$form_class'>";

		$html .= '<h1>' .  __('Pixel Cat', 'facebook-conversion-pixel') . '</h1>';

		$html .= '<p>' . __('Help: ', 'facebook-conversion-pixel');
			$html .= '<a href="https://fatcatapps.com/facebook-pixel/#Option_2_Install_a_Facebook_Pixel_WordPress_plugin_recommended" target="_blank">' . __('Setup Instructions', 'facebook-conversion-pixel') . '</a> | ';
			$html .= '<a href="https://fatcatapps.com/migrate-new-facebook-pixel/" target="_blank">' . __('Migration from old Conversion Pixel', 'facebook-conversion-pixel') . '</a> | ';
			$html .= '<a href="https://fatcatapps.com/facebook-pixel/" target="_blank">' . __('FB Pixel: The Definitive Guide', 'facebook-conversion-pixel') . '</a> | ';
			$html .= '<a href="https://wordpress.org/support/plugin/facebook-conversion-pixel" target="_blank">' . __('Support Forum', 'facebook-conversion-pixel') . '</a>';
		$html .= '</p>';

		$html .= "<h1 class='nav-tab-wrapper fca-pc-nav $form_class'>";
			$html .= '<a href="#" data-target="#fca_pc_main_table, #fca-pc-events-table" class="nav-tab">' . __('Main', 'facebook-conversion-pixel') . '</a>';
			$html .= '<a href="#" data-target="#fca_pc_settings_table" class="nav-tab">' . __('Settings', 'facebook-conversion-pixel') . '</a>';
			$html .= '<a href="#" data-target="#fca-pc-e-commerce" class="nav-tab">' . __('E-commerce', 'facebook-conversion-pixel') . '</a>';
			$html .= '<a href="#" data-target="#fca_pc_integrations_table" class="nav-tab">' . __('More Integrations', 'facebook-conversion-pixel') . '</a>';

		$html .= '</h1>';

		//ADD A HIDDEN INPUT TO DETERMINE IF WE HAVE AN EMPTY SAVE OR NOT
		$html .= fca_pc_input ( 'has_save', '', true, 'hidden' );

		$html .= '<table id="fca_pc_main_table" class="fca_pc_setting_table"  >';
			$html .= "<tr>";
				$html .= '<th>' . __('Facebook Pixel ID', 'facebook-conversion-pixel') . '</th>';
				$html .= '<td id="fca-pc-helptext" title="' . __('Your Facebook Pixel ID should only contain numbers', 'facebook-conversion-pixel' ) . '" >';
				$html .= fca_pc_input ( 'id', 'e.g. 123456789123456', $pixel_id, 'text' );
				$html .= '<button type="button" id="fca_pc_new_pixel_id" class="button button-secondary" title="' . __('Add Pixel ID (Pro only)', 'facebook-conversion-pixel' ) . '">';
				$html .= '<span class="dashicons dashicons-plus" style="vertical-align: middle;"></span>Add New';
				$html .= '</button></br>';
				$html .= '<a class="fca_pc_hint" href="https://fatcatapps.com/facebook-pixel-wordpress-plugin/#pixel-id" target="_blank">' . __( 'What is my Facebook Pixel ID?', 'facebook-conversion-pixel' ) . '</a>';
				$html .= '</td>';
			$html .= "</tr>";

			if ( function_exists( 'fca_pc_additional_pixel_inputs' ) ) {
				$html .= fca_pc_additional_pixel_inputs( $pixel_ids );
			}

		$html .= '</table>';

		$html .= fca_pc_event_panel( $options['events'] );

		$html .= fca_pc_add_settings_table( $options );

		$html .= fca_pc_add_e_commerce_integrations( $options );

		$html .= fca_pc_add_more_integrations( $options );

		$html .= '<button id="fca_pc_save" type="submit" style="margin-top: 20px;" name="fca_pc_save" class="button button-primary">' . __('Save', 'facebook-conversion-pixel') . '</button>';

		$html .= fca_pc_add_event_form();

	$html .= '</form>';

	if ( FCA_PC_PLUGIN_PACKAGE === 'Lite' ) {
		$html .= fca_pc_marketing_metabox();
	}

	echo $html;
}

function fca_pc_add_event_form() {

	$events = array(
		'ViewContent' => 'ViewContent',
		'Lead' => 'Lead',
		'AddToCart' => 'AddToCart',
		'AddToWishlist' => 'AddToWishlist',
		'InitiateCheckout' => 'InitiateCheckout',
		'AddPaymentInfo' => 'AddPaymentInfo',
		'Purchase' => 'Purchase',
		'CompleteRegistration' => 'CompleteRegistration'
	);

	$triggers = array(
		'all' => __('All Pages', 'facebook-conversion-pixel'),
		'front' => __('Front Page', 'facebook-conversion-pixel'),
		'blog' => __('Blog Page', 'facebook-conversion-pixel')
	);

	$custom_post_type_triggers = apply_filters( 'fca_pc_custom_post_support', array() );

	if ( is_array( $custom_post_type_triggers ) && count( $custom_post_type_triggers ) > 0 ) {
		forEach ( $custom_post_type_triggers as $cpt_slug ) {
			$cpt_obj = get_post_type_object( $cpt_slug );

			if ( $cpt_obj ) {
				$cpt_name = $cpt_obj->labels->singular_name;

				forEach ( get_posts( array( 'posts_per_page' => -1, 'post_type' => $cpt_slug ) ) as $p ) {
					$triggers[$p->ID] = $cpt_name . ' ' . $p->ID . ' - ' . $p->post_title;
				}
			}
		}
	}

	forEach ( get_posts( array( 'posts_per_page' => -1, 'post_type' => 'product' ) ) as $product ) {
		$triggers[$product->ID] = 'Product ' . $product->ID . ' - ' . $product->post_title;
	}

	forEach ( get_posts( array( 'posts_per_page' => -1, 'post_type' => 'download' ) ) as $download ) {
		$triggers[$download->ID] = 'Download ' . $download->ID . ' - ' . $download->post_title;
	}

	forEach ( get_pages( array( 'posts_per_page' => -1 ) ) as $page ) {
		$triggers[$page->ID] = 'Page ' . $page->ID . ' - ' . $page->post_title;
	}
	forEach ( get_posts( array( 'posts_per_page' => -1 ) ) as $post ) {
		$triggers[$post->ID] = 'Post ' . $post->ID . ' - ' . $post->post_title;
	}

	forEach ( get_categories() as $cat ) {
		$triggers['cat' . $cat->cat_ID] = 'Category ' . $cat->cat_ID . ' - ' . $cat->category_nicename;
	}

	forEach ( get_tags() as $tag ) {
		$triggers['tag' . $tag->term_id] = 'Tag ' . $tag->term_id  . ' - ' . $tag->name;
	}

	//REMOVE BLOG PAGE FROM OPTIONS - USE BLOG SETTING INSTEAD
	$blog_id = get_option('page_for_posts');
	if ( $blog_id !== 0 ) {
		unset ( $triggers[$blog_id] );
	}

	$modes = array (
		'post' => 'Page Visit',
		'css' => 'Click on Element',
		'hover' => 'Hover over Element',
		'url' => 'URL Click'
	);

	ob_start(); ?>
	<div id='fca-pc-event-modal' style='display: none;'>
		<h3><?php _e('Edit Event', 'facebook-conversion-pixel') ?></h3>
		<table class="fca_pc_modal_table">
				<th><?php _e('Trigger', 'facebook-conversion-pixel') ?></th>
				<td>
					<select id='fca-pc-modal-trigger-type-input' class='fca_pc_select' name='fca[trigger_type]' style='width: 100%' >
						<?php
						forEach ( $modes as $key => $value ) {
							echo "<option id='mode-option-$key' value='$key'>$value</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr id='fca-pc-css-input-tr'>
				<th><?php _e('CSS Target', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('Enter CSS classes or IDs that will trigger the event on click.<br>Add more than one class or ID separted by commas.  E.g. "#my-header, .checkout-button"', 'facebook-conversion-pixel') ) ?></th>
				<td>
					<input id='fca-pc-modal-css-trigger-input' type='text' placeholder='e.g. #checkout-button' class='fca-pc-input-text fca-pc-css-trigger' style='width: 100%'>
				</td>
			</tr>
			<tr id='fca-pc-url-input-tr'>
				<th><?php _e('URL Click', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('Enter the URL you wish to trigger the event on click.', 'facebook-conversion-pixel') ) ?></th>
				<td>
					<input id='fca-pc-modal-url-trigger-input' type='url' placeholder='https://fatcatapps.com' class='fca-pc-input-text fca-pc-url-trigger' style='width: 100%'>
				</td>
			</tr>
			<tr id='fca-pc-post-input-tr'>
				<th><?php _e('Pages', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('Choose where on your site to trigger this event. You can choose any posts, pages, or categories.', 'facebook-conversion-pixel') ) ?></th>
				<td>
					<select id='fca-pc-modal-post-trigger-input' class='fca_pc_multiselect' multiple='multiple' style='width: 100%' >

						<?php
						forEach ( $triggers as $key => $value ) {
							echo "<option value='$key'>$value</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php _e('Event', 'facebook-conversion-pixel'); ?></th>
				<td>
					<select id='fca-pc-modal-event-input' class='fca_pc_select' style='width: 100%' >
						<optgroup label='<?php _e( 'Standard Events', 'facebook-conversion-pixel' ) ?>'>
						<?php
						forEach ( $events as $key => $value ) {
							echo "<option value='$key'>$value</option>";
						}?>
						</optgroup>
						<option value='custom' id='custom-event-option' ' class='fca-bold'><?php _e( 'Custom Event', 'facebook-conversion-pixel' ) ?></option>
					</select>
				</td>
			</tr>
			<tr id='fca_pc_param_event_name'>
				<th><?php _e('Event Name', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('Choose the name of the Custom Event.  Max 50 characters', 'facebook-conversion-pixel') ) ?></th>
				<td><?php echo fca_pc_input ( 'event_name', '', '', 'text' ) ?></td>
			</tr>
			<tr>
				<th><?php _e('Time delay', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('You can add a time-delay to exclude bouncing visitors (Pro only).', 'facebook-conversion-pixel') ) ?></th>
				<td><input id='fca-pc-modal-delay-input' type='number' min='0' max='3600' step='1' value='0'><?php _e('seconds', 'facebook-conversion-pixel') ?></td>
			</tr>
			<tr>
				<th><?php _e('Scroll %', 'facebook-conversion-pixel'); echo fca_pc_tooltip( __('You can add a scroll percent trigger to exclude bouncing visitors (Pro only).', 'facebook-conversion-pixel') ) ?></th>
				<td><input id='fca-pc-modal-scroll-input' type='number' min='0' max='100' step='5' value='0'><?php _e('%', 'facebook-conversion-pixel') ?></td>
			</tr>
			<tr>
				<th style='vertical-align: top'><?php _e('Parameters', 'facebook-conversion-pixel')?></th>
				<td><?php echo '<span id="fca-pc-show-param" class="fca-pc-param-toggle">' . __('(show)', 'facebook-conversion-pixel') . '</span><span style="display: none;" id="fca-pc-hide-param" class="fca-pc-param-toggle">' . __('(hide)', 'facebook-conversion-pixel') . '</span>' ?></td>
			</tr>
			<tr>
				<td id='fca-pc-param-help' class='fca-pc-param-row' colspan=2 style='font-style: italic;'><?php _e('Add custom parameters here.  You can use any of the following automatic parameters:', 'facebook-conversion-pixel')?><br>
					{post_title}, {post_id}, {post_type}, {post_category}
				</td>
			</tr>
			<tr>
				<?php echo fca_pc_event_parameters() ?>
			</tr>
		</table>

		<button type='button' id='fca-pc-event-save' class='button button-primary' style='margin-right: 8px'><?php _e('Save', 'facebook-conversion-pixel') ?></button>
		<button type='button' id='fca-pc-event-cancel' class='button button-secondary'><?php _e('Cancel', 'facebook-conversion-pixel') ?></button>

	</div>

	<?php
	return ob_get_clean();
}

//SPIT OUT THE DIFFERENT PARAMETER OPTIONS FOR EACH EVENT
function fca_pc_event_parameters () {
	ob_start(); ?>
		<tr class='fca-pc-param-row' id='fca_pc_param_value'>
			<th>value:<span class='fca-required-param-tooltip'><?php echo fca_pc_tooltip( __('This field is required', 'facebook-conversion-pixel') ) ?></span></th>
			<td><?php echo fca_pc_input( 'value', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_currency'>
			<th>currency:<span class='fca-required-param-tooltip'><?php echo fca_pc_tooltip( __('This field is required', 'facebook-conversion-pixel') ) ?></span></th>
			<td><?php echo fca_pc_input( 'currency', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_content_name'>
			<th>content_name:</th>
			<td><?php echo fca_pc_input( 'content_name', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_content_type'>
			<th>content_type:</th>
			<td><?php echo fca_pc_select( 'content_type', '', array( 'product' => 'product', 'product_group' => 'product_group' ) ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_content_ids'>
			<th>content_ids:</th>
			<td><?php echo fca_pc_input( 'content_ids', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_content_category'>
			<th>content_category:</th>
			<td><?php echo fca_pc_input( 'content_category', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_search_string'>
			<th>search_string:</th>
			<td><?php echo fca_pc_input( 'search_string', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_num_items'>
			<th>num_items:</th>
			<td><?php echo fca_pc_input( 'num_items', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_status'>
			<th>status:</th>
			<td><?php echo fca_pc_input( 'status', '', '', 'text' ) ?></td>
		</tr>
		<tr class='fca-pc-param-row' id='fca_pc_param_custom'>
			<td colspan='3' style='position: relative; left: -3px;'>
				<?php
				echo fca_pc_custom_param_table();
				if ( FCA_PC_PLUGIN_PACKAGE === 'Lite' ) {
					echo '<span style="font-weight: bold; position: relative; top: 5px; left: 5px;">' . __('(Pro Only)', 'facebook-conversion-pixel') . '</span>';
				}
				?>
			</td>
		</tr>
	<?php
	return ob_get_clean();
}

function fca_pc_custom_param_table() {

	ob_start(); ?>

	<table id='fca_pc_custom_param_table' style='width:100%;'>
	</table>
	<button type='button' id='fca-pc-add-custom-param' class='button button-secondary' ><span class='dashicons dashicons-plus' style='vertical-align: middle;' ></span><?php _e('Add Custom Parameter', 'facebook-conversion-pixel') ?></button>

	<?php
	return ob_get_clean();
}

function fca_pc_custom_param_row() {

	ob_start(); ?>

	<tr class='fca_deletable_item'>
		<td style='width: 120px;'><input type='text' style='width:100%; height: 35px;' placeholder='<?php _e( 'Parameter', 'facebook-conversion-pixel' ) ?>' class='fca-pc-input-parameter-name'></td>
		<td><input type='text' style='width:100%; height: 35px;' placeholder='<?php _e( 'Value', 'facebook-conversion-pixel' ) ?>' class='fca-pc-input-parameter-value'></td>
		<td style='width: 66px; text-align: right; height: 35px;'><?php echo fca_pc_delete_icons() ?></td>
	</tr>

	<?php
	return ob_get_clean();
}

function fca_pc_event_tooltips(){

	$viewcontent_hover_text =  htmlentities ( __("We'll automatically send the following event parameters to Facebook:<br>content_name: Post/Page title (eg. \"My first blogpost\")<br>content_type: Post type (eg. \"Post\", \"Page\", \"Product\")<br>content_ids: The WordPress post id (eg. \"47\")", 'facebook-conversion-pixel'), ENT_QUOTES );
	$lead_hover_text = htmlentities ( __("We'll automatically send the following event parameters to Facebook:<br>content_name: Post/Page title (eg. \"My first blogpost\")<br>content_category: The post's category, if any (eg. \"News\")", 'facebook-conversion-pixel'), ENT_QUOTES );

	$html = "<p class='fca_pc_hint' id='fca_pc_tooltip_viewcontent'>";
		$html .= sprintf( __("Send the %1sViewContent%2s standard event to Facebook.<br>(%3sWhich Parameters will be sent?%4s)", 'facebook-conversion-pixel'), '<strong>', '</strong>', "<span class='fca_pc_event_tooltip' title='$viewcontent_hover_text'>", '</span>' );
	$html .= '</p>';

	$html .= "<p class='fca_pc_hint' id='fca_pc_tooltip_lead' style='display: none'>";
		$html .= sprintf( __("Send the %1sLead%2s standard event to Facebook.<br>(%1sWhich Parameters will be sent?%2s)", 'facebook-conversion-pixel'), '<strong>', '</strong>', "<span class='fca_pc_event_tooltip' title='$lead_hover_text'>", '</span>' );
	$html .= '</p>';
	return $html;
}

function fca_pc_event_panel( $events = array() ) {
	$html = '<div id="fca-pc-events-table">';
		$html .= "<h3>" . __('Events', 'facebook-conversion-pixel') . "</h3>";
		$html .= "<p>" . __('Add events based on user behavior.', 'facebook-conversion-pixel') . "</p>";
		$html .= '<table id="fca-pc-events" class="widefat">';
			$html .= '<tr id="fca-pc-event-table-heading">';
				//HIDDEN COLUMN FOR JSON
				$html .= '<th style="display:none;"></th>';
				$html .= '<th style="width: 67px;">' . __('Status', 'facebook-conversion-pixel') . '</th>';
				$html .= '<th style="width: 30%;">' . __('Event', 'facebook-conversion-pixel') . '</th>';
				$html .= '<th style="width: calc( 70% - 150px );">' . __('Trigger', 'facebook-conversion-pixel') . '</th>';
				$html .= '<th style="text-align: right; width: 67px;"></th>';
			$html .= '</tr>';
			forEach ( $events as $event ) {
				$html .= fca_pc_event_row_html( $event );
			}
		$html .= '</table>';
		$html .= '<button type="button" id="fca_pc_new_event" class="button button-secondary"><span class="dashicons dashicons-plus" style="vertical-align: middle;"></span>' . __('Add New', 'facebook-conversion-pixel') . '</button><br>';
	$html .= '</div>';

	return $html;
}

//EVENT TABLE ROW TEMPLATE
function fca_pc_event_row_html( $event = '' ) {
	ob_start(); ?>
	<tr id='{{ID}}' class='fca_pc_event_row fca_deletable_item'>
		<td class='fca-pc-json-td' style='display:none;'><input type='hidden' class='fca-pc-input-hidden fca-pc-json' name='fca_pc[event_json][]' value='<?php echo stripslashes_deep( $event ) ?>' /></td>
		<td class='fca-pc-controls-td'>
			<span class='dashicons dashicons-controls-pause fca_controls_icon fca_controls_icon_play' title='<?php _e('Paused - Click to Activate', 'facebook-conversion-pixel' ) ?>' style='display:none;' ></span>
			<span class='dashicons dashicons-controls-play fca_controls_icon fca_controls_icon_pause' title='<?php _e('Active - Click to Pause', 'facebook-conversion-pixel' ) ?>' ></span>
		</td>
		<td class='fca-pc-event-td'>{{EVENT}}</td>
		<td class='fca-pc-trigger-td'>{{TRIGGER}}</td>
		<td class='fca-pc-delete-td'><?php echo fca_pc_delete_icons() ?></td>
	</tr>
	<?php
	return ob_get_clean();
}

function fca_pc_settings_save() {
	$data = array();

	echo '<div id="fca-pc-notice-save" class="notice notice-success is-dismissible">';
		echo '<p><strong>' . __( "Settings saved.", 'facebook-conversion-pixel' ) . '</strong></p>';
	echo '</div>';

	$data['has_save'] = intval ( $_POST['fca_pc']['has_save'] );
	$data['id'] = fca_pc_bigintval ( $_POST['fca_pc']['id'] );
	$data['events'] = empty( $_POST['fca_pc']['event_json'] ) ? array() : array_map( 'fca_pc_sanitize_text_array', $_POST['fca_pc']['event_json'] );

	$data['exclude'] = empty( $_POST['fca_pc']['exclude'] ) ? array() : array_map( 'fca_pc_sanitize_text_array', $_POST['fca_pc']['exclude'] );

	$data['search_integration'] = empty( $_POST['fca_pc']['search_integration'] ) ? '' : 'on';
	$data['quizcat_integration'] = empty( $_POST['fca_pc']['quizcat_integration'] ) ? '' : 'on';
	$data['optincat_integration'] = empty( $_POST['fca_pc']['optincat_integration'] ) ? '' : 'on';
	$data['landingpagecat_integration'] = empty( $_POST['fca_pc']['landingpagecat_integration'] ) ? '' : 'on';
	$data['ept_integration'] = empty( $_POST['fca_pc']['ept_integration'] ) ? '' : 'on';
	

	$data['woo_integration'] = empty( $_POST['fca_pc']['woo_integration'] ) ? '' : 'on';
	$data['woo_feed'] = empty( $_POST['fca_pc']['woo_feed'] ) ? '' : 'on';
	$data['woo_excluded_categories'] = empty( $_POST['fca_pc']['woo_excluded_categories'] ) ? '' : $_POST['fca_pc']['woo_excluded_categories'];
	$data['woo_product_id'] = empty( $_POST['fca_pc']['woo_product_id'] ) ? '' : $_POST['fca_pc']['woo_product_id'];
	$data['woo_desc_mode'] = empty( $_POST['fca_pc']['woo_desc_mode'] ) ? '' : $_POST['fca_pc']['woo_desc_mode'];
	$data['google_product_category'] = empty( $_POST['fca_pc']['google_product_category'] ) ? '' : $_POST['fca_pc']['google_product_category'];

	$data['edd_integration'] = empty( $_POST['fca_pc']['edd_integration'] ) ? '' : 'on';
	$data['edd_feed'] = empty( $_POST['fca_pc']['edd_feed'] ) ? '' : 'on';
	$data['edd_excluded_categories'] = empty( $_POST['fca_pc']['edd_excluded_categories'] ) ? '' : $_POST['fca_pc']['edd_excluded_categories'];
	$data['edd_desc_mode'] = empty( $_POST['fca_pc']['edd_desc_mode'] ) ? '' : $_POST['fca_pc']['edd_desc_mode'];

	if ( function_exists( 'fca_pc_premium_save' ) ) {
		$data = fca_pc_premium_save( $data );
	}

	update_option( 'fca_pc', $data );

	return $data;
}

function fca_pc_add_settings_table( $options ) {

	$amp_on = empty( $options['amp_integration'] ) ? '' : 'on';

	$user_parameters_on = empty( $options['user_parameters'] ) ? '' : 'on';
	$utm_support_on = empty( $options['utm_support'] ) ? '' : 'on';

	$advanced_matching = empty ( $options['advanced_matching'] ) ? false : true;
	$exclude = empty ( $options['exclude'] ) ? array() : $options['exclude'];

	$pro_tooltip = FCA_PC_PLUGIN_PACKAGE !== 'Lite' ? '' : 'class="fca_pc_pro_tooltip" title="' . __("This option is available only with Pixel Cat Pro. Click the blue button on the right-hand side to learn more.", 'facebook-conversion-pixel') . '"';

	ob_start(); ?>

	<table id="fca_pc_settings_table" class='fca_pc_setting_table fca_pc_integrations_table'>
		<tr>
			<th><?php _e('Exclude Users', 'facebook-conversion-pixel') ?></th>
			<td><?php echo fca_pc_input( 'exclude', '', $exclude, 'roles' ) ?>
			<span class='fca_pc_hint'><?php _e("Logged in users selected above will not trigger your pixel.", 'facebook-conversion-pixel') ?></span></td>
		</tr>
		<tr <?php echo $pro_tooltip ?>>
			<th><?php _e('Advanced Matching', 'facebook-conversion-pixel') ?></th>
			<td><?php echo fca_pc_input( 'advanced_matching', '', $advanced_matching, 'checkbox' ) ?>
			<span class='fca_pc_hint'><?php _e("Enable Advanced Matching for all events. According to Facebook, advertisers using advanced matching can expect a 10% increase in attributed conversions and 20% increase in reach.", 'facebook-conversion-pixel') ?></span></td>
		</tr>

		<tr <?php echo $pro_tooltip ?>>
			<th><?php _e('Additional user information', 'facebook-conversion-pixel') ?></th>
			<td><?php echo fca_pc_input( 'user_parameters', '', $user_parameters_on, 'checkbox' ) ?>
			<span class='fca_pc_hint'><?php _e("Send HTTP referrer, user language, post categories and tags as event parameters, so you can create better custom audiences.", 'facebook-conversion-pixel') ?></span></td>
		</tr>
		<tr <?php echo $pro_tooltip ?>>
			<th><?php _e('UTM Tag support', 'facebook-conversion-pixel') ?></th>
			<td><?php echo fca_pc_input( 'utm_support', '', $utm_support_on, 'checkbox' ) ?>
			<span class='fca_pc_hint'><?php _e("Send Google UTM source, medium, campaign, term, and content as event parameters, so you can target your visitors based on Google Analytics data.", 'facebook-conversion-pixel') ?></span></td>
		</tr>

		<tr <?php echo $pro_tooltip ?>>
			<th><?php _e('AMP support', 'facebook-conversion-pixel') ?></th>
			<td><?php echo fca_pc_input( 'amp_integration', '', $amp_on, 'checkbox' ) ?>
			<span class='fca_pc_hint'><?php _e("Make sure your pixel fires on AMP pages.", 'facebook-conversion-pixel') ?></span></td>
		</tr>

	</table>

	<?php
	return ob_get_clean();
}


function fca_pc_add_more_integrations( $options ) {

	$qc_active = ( is_plugin_active( 'quiz-cat/quizcat.php' ) OR
				 is_plugin_active( 'quiz-cat-premium/quizcat.php' ) OR
				 is_plugin_active( 'quiz-cat-wp/quizcat.php' ) );

	$lpc_active = ( is_plugin_active( 'landing-page-cat/landing-page-cat.php' ) OR
				  is_plugin_active( 'landing-page-cat-premium/landing-page-cat.php' ) OR
				  is_plugin_active( 'landing-page-cat-wp/landing-page-cat.php' ) );

	$eoi_active = class_exists( 'DhEasyOptIns' );

	$ept_active = ( is_plugin_active( 'easy-pricing-tables-premium/easy-pricing-tables-premium.php' ) OR
					is_plugin_active( 'easy-pricing-tables/pricing-table-plugin.php' ) );

	$search_integration_on = empty( $options['search_integration'] ) ? '' : 'on';
	$quizcat_integration_on = empty( $options['quizcat_integration'] ) ? '' : 'on';
	$optincat_integration_on = empty( $options['optincat_integration'] ) ? '' : 'on';
	$landingpagecat_integration_on = empty( $options['landingpagecat_integration'] ) ? '' : 'on';
	$ept_integration_on = empty( $options['ept_integration'] ) ? '' : 'on';
	$video_events_on = empty( $options['video_events'] ) ? '' : 'on';

	ob_start(); ?>
	<div id="fca_pc_integrations_table" style="display: none">
		<h3><?php _e('WordPress Integrations', 'facebook-conversion-pixel') ?></h3>
		<table class='fca_pc_setting_table fca_pc_integrations_table'>
			<tr>
				<th><?php _e('WordPress Search Event', 'facebook-conversion-pixel') ?></th>
				<td><?php echo fca_pc_input( 'search_integration', '', $search_integration_on, 'checkbox' ) ?>
				<span class='fca_pc_hint'><?php _e("Trigger the Search event when a search is performed using WordPress' built-in search feature.", 'facebook-conversion-pixel') ?></span></td>
			</tr>
			<tr>
			<?php if ( $ept_active ) { ?>
				<th>
					<?php _e('Easy Pricing Tables', 'facebook-conversion-pixel') ?>
					<p class='installed-text installed'><span class="dashicons dashicons-yes"></span><?php _e('Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'ept_integration', '', $ept_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Send InitiateCheckout event to Facebook.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/knowledge-base/pixel-cat-integrations/'><?php _e('Learn More...', 'facebook-conversion-pixel') ?></a></span>
				</td>
			<?php } else { ?>
				<th class='fca-pc-integration-disabled'>
					<?php _e('Easy Pricing Tables', 'facebook-conversion-pixel') ?>
					<p class='installed-text'><span class="dashicons dashicons-no"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'ept_integration', '', false, 'checkbox', 'disabled' ) ?>
					<span class='fca_pc_hint'><?php _e("Create beautiful pricing comparison tables that increase your sales.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/easypricingtables/'><?php _e('Learn more here', 'facebook-conversion-pixel') ?></a>.</span>
				</td>
			<?php } ?>
			</tr>
			<tr>
			<?php if ( $eoi_active ) { ?>
				<th>
					<?php _e('Optin Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text installed'><span class="dashicons dashicons-yes"></span><?php _e('Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'optincat_integration', '', $optincat_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Send Lead event to Facebook.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/knowledge-base/pixel-cat-integrations/'><?php _e('Learn More...', 'facebook-conversion-pixel') ?></a></span>
				</td>
			<?php } else { ?>
				<th class='fca-pc-integration-disabled'>
					<?php _e('Optin Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text'><span class="dashicons dashicons-no"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'optincat_integration', '', false, 'checkbox', 'disabled' ) ?>
					<span class='fca_pc_hint'><?php _e("Convert more blog readers into email subscribers using Optin Cat.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/optincat/'><?php _e('Learn more here', 'facebook-conversion-pixel') ?></a>.</span>
				</td>
			<?php } ?>
			</tr>
			<tr>
			<?php if ( $qc_active ) { ?>
				<th>
					<?php _e('Quiz Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text installed'><span class="dashicons dashicons-yes"></span><?php _e('Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'quizcat_integration', '', $quizcat_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Send Lead event, plus custom events related to Quiz engagement to Facebook.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/knowledge-base/pixel-cat-integrations/'><?php _e('Learn More...', 'facebook-conversion-pixel') ?></a></span>
				</td>
			<?php } else { ?>
				<th class='fca-pc-integration-disabled'>
					<?php _e('Quiz Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text'><span class="dashicons dashicons-no"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'quizcat_integration', '', false, 'checkbox', 'disabled' ) ?>
					<span class='fca_pc_hint'><?php _e("Quiz Cat lets you create beautiful quizzes that boost social shares and grow your email list.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/quizcat/'><?php _e('Learn more here', 'facebook-conversion-pixel') ?></a>.</span>
				</td>
			<?php } ?>
			</tr>
			<tr>
			<?php if ( $lpc_active ) { ?>
				<th>
					<?php _e('Landing Page Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text installed'><span class="dashicons dashicons-yes"></span><?php _e('Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'landingpagecat_integration', '', $landingpagecat_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Send Lead event to Facebook.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/knowledge-base/pixel-cat-integrations/'><?php _e('Learn More...', 'facebook-conversion-pixel') ?></a></span>
				</td>
			<?php } else { ?>
				<th class='fca-pc-integration-disabled'>
					<?php _e('Landing Page Cat', 'facebook-conversion-pixel') ?>
					<p class='installed-text'><span class="dashicons dashicons-no"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></p>
				</th>
				<td>
					<?php echo fca_pc_input( 'landingpagecat_integration', '', false, 'checkbox', 'disabled' ) ?>
					<span class='fca_pc_hint'><?php _e("Landing Page Cat lets you publish simple, beautiful landing pages in 2 minutes.", 'facebook-conversion-pixel') ?>
					<a target='_blank' href='https://fatcatapps.com/landingpagecat/'><?php _e('Learn more here', 'facebook-conversion-pixel') ?></a>.</span>
				</td>
			<?php } ?>
			</tr>
			<?php if ( FCA_PC_PLUGIN_PACKAGE === 'Lite' ) { 
				$tooltip = __("This option is available only with Pixel Cat Pro. Click the blue button on the right-hand side to learn more.", 'facebook-conversion-pixel');
				?>
				<tr class='fca-pc-integration-disabled fca_pc_pro_tooltip' title="<?php echo $tooltip ?>" >
					<th >
						<?php _e('Video Events', 'facebook-conversion-pixel') ?>
					</th>
					<td>
						<?php echo fca_pc_input( 'video_events', '', false, 'checkbox', 'disabled' ) ?>
						<span class='fca_pc_hint'><?php _e("Enable Video Events feature.", 'facebook-conversion-pixel') ?></span>
					</td>
				</tr>
			<?php } else { ?>
				<tr>
					<th>
						<?php _e('Video Events', 'facebook-conversion-pixel') ?>
					</th>
					<td>
						<?php echo fca_pc_input( 'video_events', '', $video_events_on, 'checkbox' ) ?>
						<span class='fca_pc_hint'><?php _e("Enable Video Events feature.", 'facebook-conversion-pixel') ?></span>
					</td>
				</tr>
			<?php } ?>
			
		</table>
	</div>
	<?php
	return ob_get_clean();
}

function fca_pc_add_e_commerce_integrations( $options ) {
	ob_start(); ?>
	<div id="fca-pc-e-commerce">
		<?php
		echo fca_pc_add_woo_integrations( $options );
		echo fca_pc_add_edd_integrations( $options );
		?>
	</div>
	<?php
	return ob_get_clean();
}

function fca_pc_add_woo_integrations( $options ) {

	$version_ok = false;
	$woo_is_active = is_plugin_active( 'woocommerce/woocommerce.php' );

	if ( $woo_is_active ) {
		global $woocommerce;
		if ( version_compare( $woocommerce->version, '3.0.0', ">=" ) ) {
			$version_ok = true;
		}
	}
	$woo_active = $woo_is_active && $version_ok;

	$woo_integration_on = empty( $options['woo_integration'] ) ? '' : 'on';
	$woo_extra_params = empty( $options['woo_extra_params'] ) ? '' : 'on';
	$woo_delay = empty( $options['woo_delay'] ) ? 0 : intVal($options['woo_delay']);
	$woo_feed_on = empty( $options['woo_feed'] ) ? '' : 'on';

	$woo_id_mode = empty( $options['woo_product_id'] ) ? 'post_id' : $options['woo_product_id'];
	$id_options = array(
		'post_id' => 'WordPress Post ID (recommended)',
		'sku' => 'WooCommerce SKU',
	);

	$woo_desc_mode = empty( $options['woo_desc_mode'] ) ? 'description' : $options['woo_desc_mode'];
	$description_options = array(
		'description' => 'Product Content',
		'short' => 'Product Short Description',
	);

	$excluded_categories = empty( $options['woo_excluded_categories'] ) ? array() : $options['woo_excluded_categories'];
	$categories = fca_pc_woo_product_cat_and_tags();

	$google_product_category = empty( $options['google_product_category'] ) ? '' : $options['google_product_category'];
	$pro_tooltip = FCA_PC_PLUGIN_PACKAGE !== 'Lite' ? '' : 'class="fca_pc_pro_tooltip" title="' . __("This option is available only with Pixel Cat Pro. Click the blue button on the right-hand side to learn more.", 'facebook-conversion-pixel') . '"';

	ob_start(); ?>
	<div id='fca-pc-woo-table'>
		<?php if ( !$woo_is_active ) { ?>
			<h3>
				<?php _e('WooCommerce', 'facebook-conversion-pixel') ?>
				<span class="installed-text"><span alt="f158" class="dashicons dashicons-no-alt"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></span>
			</h3>
			<p><?php _e('Plugin not detected. To use this integration, please install Woocommerce v.3.0 or greater.', 'facebook-conversion-pixel') ?></p>
		<?php } else {
			?>
			<h3>
				<?php _e('WooCommerce Integration', 'facebook-conversion-pixel') ?>
				<span class="installed-text installed"><div alt="f147" class="dashicons dashicons-yes"></div><?php _e('Installed', 'facebook-conversion-pixel') ?></span>
			</h3>

			<table class='fca_pc_integrations_table'>
				<tr>
					<th><?php _e('Track Shopping Events', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'woo_integration', '', $woo_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Automatically send the following events to Facebook: Add&nbsp;To&nbsp;Cart, Add&nbsp;Payment&nbsp;Info, Purchase, View&nbsp;Content, Search, and Add&nbsp;to&nbsp;Wishlist.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr <?php echo $pro_tooltip; ?>>
					<th><?php _e('Delay ViewContent Event', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'woo_delay', '', $woo_delay, 'number', "min='0' max='100' step='1'" ) ?>seconds<br>
					<span class='fca_pc_hint'><?php _e("Exclude bouncing visitors by delaying the ViewContent event on product pages.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr <?php echo $pro_tooltip; ?>>
					<th><?php _e('Send Extra Info with Purchase Event', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'woo_extra_params', '', $woo_extra_params, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Sends LTV (lifetime value), coupon codes (if used) and shipping info as parameters of your purchase event, so you can build better, more targeted custom audiences.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr>
					<th><?php _e('Product Feed', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'woo_feed', '', $woo_feed_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("A Product Feed is required to use Facebook Dynamic Product Ads.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings'>
					<th><?php _e('Feed URL', 'facebook-conversion-pixel') ?></th>
						<td><input style='height: 35px;' type='text' onclick='this.select()' readonly value='<?php echo get_site_url() . '?feed=pixelcat' ?>' >
					<span class='fca_pc_hint'><?php _e("You'll need above URL when setting up your Facebook Product Catalog.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings'>
					<th><?php _e('Exclude Categories/Tags', 'facebook-conversion-pixel') ?></th>
						<td><select id='fca-pc-exclude-woo-categories' name='fca_pc[woo_excluded_categories][]' class='fca_pc_multiselect' multiple='multiple' style='width: 100%' >
						<?php
						forEach ( $categories as $key => $value ) {
							if ( in_array( $key, $excluded_categories ) ) {
								echo "<option value='$key' selected='selected'>$value</option>";
							} else {
								echo "<option value='$key'>$value</option>";
							}
						}?>
						</select>
					<span class='fca_pc_hint'><?php _e("Selected product categories and tags will not be included in your feed.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings'>
					<th><?php _e('Advanced Feed Settings', 'facebook-conversion-pixel') ?></th>
						<td><?php echo '<span id="fca-pc-show-feed-settings" class="fca-pc-feed-toggle">' . __('(show)', 'facebook-conversion-pixel') . '</span><span style="display: none;" id="fca-pc-hide-feed-settings" class="fca-pc-feed-toggle">' . __('(hide)', 'facebook-conversion-pixel') . '</span>' ?></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings fca-pc-woo-advanced-feed-settings' style='display:none;'>
					<th><?php _e('Product Identifier', 'facebook-conversion-pixel') ?></th>
						<td><select name='fca_pc[woo_product_id]' style='width: 100%' >
						<?php

						forEach ( $id_options as $key => $value ) {
							if ( $woo_id_mode == $key ) {
								echo "<option value='$key' selected='selected'>$value</option>";
							} else {
								echo "<option value='$key'>$value</option>";
							}
						}?>
						</select>
					<span class='fca_pc_hint'><?php _e("Set how to identify your product using the Facebook Pixel (content_id) and the feed (g:id)", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings fca-pc-woo-advanced-feed-settings' style='display:none;'>
					<th><?php _e('Description Field', 'facebook-conversion-pixel') ?></th>
						<td><select name='fca_pc[woo_desc_mode]' style='width: 100%' >
						<?php

						forEach ( $description_options as $key => $value ) {
							if ( $woo_desc_mode == $key ) {
								echo "<option value='$key' selected='selected'>$value</option>";
							} else {
								echo "<option value='$key'>$value</option>";
							}
						}?>
						</select>
					<span class='fca_pc_hint'><?php _e("Set the field to use as your product description for the Facebook product catalog", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-woo-feed-settings fca-pc-woo-advanced-feed-settings' style='display:none;'>
					<th><?php _e('Google Product Category', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'google_product_category', 'e.g. 2271', $google_product_category, 'text' ) ?>
					<span class='fca_pc_hint'><?php echo __("Enter your numeric Google Product Category ID here.  If your category is \"Apparel & Accessories > Clothing > Dresses\", enter 2271.  ", 'facebook-conversion-pixel') . '<a href="http://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.xls" target="_blank">' . __("Click here", 'facebook-conversion-pixel') . '</a> ' . __("for a current spreadsheet of all Categories & IDs.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
			</table>
			<?php
		} ?>
	</div>
<?php return ob_get_clean();

}

function fca_pc_add_edd_integrations( $options ) {

	$edd_active = is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' );
	$edd_integration_on = empty( $options['edd_integration'] ) ? '' : 'on';
	$edd_extra_params = empty( $options['edd_extra_params'] ) ? '' : 'on';
	$edd_delay = empty( $options['edd_delay'] ) ? 0 : intVal($options['edd_delay']);
	$edd_feed_on = empty( $options['edd_feed'] ) ? '' : 'on';

	$edd_desc_mode = empty( $options['edd_desc_mode'] ) ? 'content' : $options['edd_desc_mode'];
	$description_options = array(
		'content' => 'Product Description',
		'excerpt' => 'Excerpt',
	);

	$excluded_categories = empty( $options['edd_excluded_categories'] ) ? array() : $options['edd_excluded_categories'];
	$categories = fca_pc_edd_product_cat_and_tags();
	$pro_tooltip = FCA_PC_PLUGIN_PACKAGE !== 'Lite' ? '' : 'class="fca_pc_pro_tooltip" title="' . __("This option is available only with Pixel Cat Pro. Click the blue button on the right-hand side to learn more.", 'facebook-conversion-pixel') . '"';

	ob_start();	?>

	<div id='fca-pc-edd-table'>

		<?php if ( !$edd_active ) {
			?>
			<h3>
				<?php _e('Easy Digital Downloads Integration', 'facebook-conversion-pixel') ?>
				<span class="installed-text"><span alt="f158" class="dashicons dashicons-no-alt"></span><?php _e('Not Installed', 'facebook-conversion-pixel') ?></span>
			</h3>
			<p><?php _e('Plugin not detected. To use this integration, please install Easy Digital Downloads v2.8 or greater.', 'facebook-conversion-pixel') ?></p>
			<?php
		} else {
			?>
			<h3>
				<?php _e('Easy Digital Downloads Integration', 'facebook-conversion-pixel') ?>
				<span class="installed-text installed"><div alt="f147" class="dashicons dashicons-yes"></div><?php _e('Installed', 'facebook-conversion-pixel') ?></span>
			</h3>
			<table class='fca_pc_integrations_table'>
				<tr>
					<th><?php _e('Track EDD Events', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'edd_integration', '', $edd_integration_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Automatically send the following Easy Digital Downloads events to Facebook: Add To Cart, Add&nbsp;Payment&nbsp;Info, Purchase, View&nbsp;Content, Search, and Add&nbsp;to&nbsp;Wishlist.", 'facebook-conversion-pixel') ?></span></td>
				</tr>

				<tr <?php echo $pro_tooltip ?>>
					<th><?php _e('Delay ViewContent Event', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'edd_delay', '', $edd_delay, 'number', "min='0' max='100' step='1'" ) ?>seconds<br>
					<span class='fca_pc_hint'><?php _e("Exclude bouncing visitors by delaying the ViewContent event on download pages.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr <?php echo $pro_tooltip ?>>
					<th><?php _e('Send Extra Info with Purchase Event', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'edd_extra_params', '', $edd_extra_params, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("Sends LTV (lifetime value), coupon codes (if used) and shipping info as parameters of your purchase event, so you can build better, more targeted custom audiences.", 'facebook-conversion-pixel') ?></span></td>
				</tr>

				<tr>
					<th><?php _e('Product Feed', 'facebook-conversion-pixel') ?></th>
						<td><?php echo fca_pc_input( 'edd_feed', '', $edd_feed_on, 'checkbox' ) ?>
					<span class='fca_pc_hint'><?php _e("A Product Feed is required to use Facebook Dynamic Product Ads.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-edd-feed-settings'>
					<th><?php _e('Feed URL', 'facebook-conversion-pixel') ?></th>
						<td><input style='height: 35px;' type='text' onclick='this.select()' readonly value='<?php echo get_site_url() . '?feed=edd-pixelcat' ?>' >
					<span class='fca_pc_hint'><?php _e("You'll need above URL when setting up your Facebook Product Catalog.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-edd-feed-settings'>
					<th><?php _e('Exclude Categories/Tags', 'facebook-conversion-pixel') ?></th>
						<td><select id='fca-pc-exclude-edd-categories' name='fca_pc[edd_excluded_categories][]' class='fca_pc_multiselect' multiple='multiple' style='width: 100%' >
						<?php
						forEach ( $categories as $key => $value ) {
							if ( in_array( $key, $excluded_categories ) ) {
								echo "<option value='$key' selected='selected'>$value</option>";
							} else {
								echo "<option value='$key'>$value</option>";
							}
						}?>
						</select>
					<span class='fca_pc_hint'><?php _e("Selected product categories and tags will not be included in your feed.", 'facebook-conversion-pixel') ?></span></td>
				</tr>
				<tr class='fca-pc-edd-feed-settings' style='display:none;'>
					<th><?php _e('Description Field', 'facebook-conversion-pixel') ?></th>
						<td><select name='fca_pc[edd_desc_mode]' style='width: 100%' >
						<?php
						forEach ( $description_options as $key => $value ) {
							if ( $edd_desc_mode == $key ) {
								echo "<option value='$key' selected='selected'>$value</option>";
							} else {
								echo "<option value='$key'>$value</option>";
							}
						}?>
						</select>
					<span class='fca_pc_hint'><?php _e("Set the field to use as your product description for the Facebook product catalog", 'facebook-conversion-pixel') ?></span></td>
				</tr>

			</table>
			<?php
		} ?>
	</div>
<?php return ob_get_clean();

}

function fca_pc_marketing_metabox() {
	ob_start(); ?>
	<div id='fca-pc-marketing-metabox' style='display: none;'>
		<h3><?php _e( 'Get Pixel Cat Premium', 'facebook-conversion-pixel' ); ?></h3>

		<ul>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Dynamic Events, so you can build <strong>powerful custom audiences</strong>', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Advanced Matching for improved reach', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Powerful Custom Events & Parameters', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Multiple Pixels', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Google AMP Integration', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( '1-Click WooCommerce Integration', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( '1-Click Easy Digital Downloads Integration', 'facebook-conversion-pixel' ); ?></li>
			<li><div class="dashicons dashicons-yes"></div> <?php _e( 'Priority Email Support', 'facebook-conversion-pixel' ); ?></li>
		</ul>
		<div style='text-align: center'>
			<a href="https://fatcatapps.com/pixelcat/premium" target="_blank" class="button button-primary button-large"><?php _e('Run Better Ads >>', 'facebook-conversion-pixel'); ?></a>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
