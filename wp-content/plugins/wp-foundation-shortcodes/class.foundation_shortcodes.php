<?php
if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly
}

if ( !class_exists('WP_Foundation_shortcodes_shortcodes') ) {

// global vars
$global_wp_foundation_shortcodes = Array('accordion_counter' => 0, 'accordion_id' => '', 'equalizer_counter' => 0, 'equalizer_total' => 0, 'tab_counter' => 0, 'tab_title'=>false, 'tab_id' => '' );

class WP_Foundation_shortcodes_shortcodes{
	function __construct(){

		// posts
		add_shortcode('posts_grid', array($this, 'posts_grid'));
		add_shortcode('posts_list', array($this, 'posts_list'));
		add_shortcode('posts_lightbox', array($this, 'posts_lightbox'));
		add_shortcode('posts_cycle', array($this, 'posts_cycle'));

		// buttons
		add_shortcode('button', array($this, 'button'));
		add_shortcode('button_groups', array($this, 'button_groups'));
		add_shortcode('button_group', array($this, 'button_group'));
		add_shortcode('split_button', array($this, 'split_button'));
		add_shortcode('dropdown', array($this, 'dropdown'));
		add_shortcode('radio_button_groups', array($this, 'radio_button_groups'));
		add_shortcode('radio_button_group', array($this, 'radio_button_group'));
		add_shortcode('button_option_groups', array($this, 'button_option_groups'));
		add_shortcode('button_option_group', array($this, 'button_option_group'));

		// Elements
		add_shortcode('table', array($this, 'table'));
		add_shortcode('tabs', array($this, 'tabs'));
		add_shortcode('tab', array($this, 'tab'));
		add_shortcode('progressbar', array($this, 'progressbar'));
		add_shortcode('pricing_table', array($this, 'pricing_table'));
		add_shortcode('equalizers', array($this, 'equalizers'));
		add_shortcode('equalizer', array($this, 'equalizer'));
		add_shortcode('label', array($this, 'label'));
		add_shortcode('accordions', array($this, 'accordions'));
		add_shortcode('accordion', array($this, 'accordion'));
		add_shortcode('blockquote', array($this, 'blockquote'));
		add_shortcode('icon', array($this, 'icon'));
		add_shortcode('address', array($this, 'address'));
		add_shortcode('clear', array($this, 'clear'));
		add_shortcode('span', array($this, 'span_func'));
		add_shortcode('hr', array($this, 'hr'));
		add_shortcode('inline_list', array($this, 'inline_list'));
		add_shortcode('link', array($this, 'link_func'));
		add_shortcode('keystroke', array($this, 'keystroke'));

		// Callouts & Prompts
		add_shortcode('alert_box', array($this, 'alert_box'));
		add_shortcode('panel', array($this, 'panel'));
		add_shortcode('tooltip', array($this, 'tooltip'));
		add_shortcode('banner', array($this, 'banner'));
		add_shortcode('service_box', array($this, 'service_box'));
		add_shortcode('comments', array($this, 'comments'));
		add_shortcode('categories', array($this, 'categories'));
		add_shortcode('tags', array($this, 'tags'));

		// widgets
		add_shortcode('google_map', array($this, 'google_map'));
		add_shortcode('product_card', array($this, 'product_card'));
		add_shortcode('product_card_hover', array($this, 'product_card_hover'));
		add_shortcode('social_login_button', array($this, 'social_login_button'));

		// grid
		add_shortcode('row', array($this, 'row'));
		add_shortcode('columns', array($this, 'columns'));
		add_shortcode('column', array($this, 'columns'));

		// block grid
		add_shortcode('blocks_grid', array($this, 'blocks_grid'));
		add_shortcode('block_grid', array($this, 'block_grid'));

		// media
		add_shortcode('orbit_sliders', array($this, 'orbit_sliders'));
		add_shortcode('orbit_slider', array($this, 'orbit_slider'));
		add_shortcode('thumbnail', array($this, 'thumbnail'));
		add_shortcode('clearing_thumbs', array($this, 'clearing_thumbs'));
		add_shortcode('clearing_thumb', array($this, 'clearing_thumb'));
		add_shortcode('slick_sliders', array($this, 'slick_sliders'));
		add_shortcode('slick_slider', array($this, 'slick_slider'));

		// forms
		add_shortcode('range_slider', array($this, 'range_slider'));
		add_shortcode('switch', array($this, 'switch_func'));
	}

        public static function table($atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		extract(shortcode_atts(
                        array(
                                'caption' => '',
                                'colwidth'   => '',
                                'colalign' => 'yes',
				'custom_class' => '',
				'class' => ''
                ), $atts));
		// ini
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$i = 0;

		// set 
		$colalign_arr = explode('|',$colalign);
		$colwidth_arr = explode('|',$colwidth);

		// escape
		$content = str_replace(array('<br />', '<br/>', '<br>'), array("\r\n", "\r\n", "\r\n"), $content);
        	$content = str_replace('<p>', "\r\n", $content);
	        $content = str_replace('</p>', '', $content);
		$content = str_replace('&nbsp;','',$content);
	        $char_codes = array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8242;', '&#8243;' );
        	$replacements = array( "'", "'", '"', '"', "'", '"' );
	        $content = str_replace( $char_codes, $replacements, $content );

		$output = '<table class="wpfs '.$custom_class.'"'.$free_atts.'>';
		if ($caption) $output .= '<caption>'.$caption.'</caption>';

		foreach(preg_split("/((\r?\n)|(\r\n?))/", $content) as $line){
			$line = trim($line);
			if (!$line) continue;

			if ($i == 0){
				// create thead
		                $output .= '<thead><tr>';
				// explode row
				$cells = explode('|', $line);
				$c=0;
				foreach ($cells as $cell){
					$class = (isset($colalign_arr[$c])) ? ' class="text-'.$colalign_arr[$c].'"' : '' ;
					$width = (isset($colwidth_arr[$c])) ? ' width="'.$colwidth_arr[$c].'"' : '' ;
					$output .= '<th'.$class.$width.'>'.$cell.'</th>';
					$c++;
				}

				$output .= '</tr></thead><tbody>';
			}
			else{
				$output .= '<tr>';
				$cells = explode('|', $line);
				$c=0;
                                foreach ($cells as $cell){
					$class = (isset($colalign_arr[$c])) ? ' class="text-'.$colalign_arr[$c].'"' : '' ;
                                        $output .= '<td>'.$cell.'</td>';
					$c++;
                                }
				$output .='</tr>';
			}
			$i++;
		}

		$output .= '</tbody></table>';

		$output = do_shortcode($output);

                return $output;
	}

	public static function alert_box( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		$alertContent = ($content) ? do_shortcode($content) : __('Alert box', 'wp-foundation-shortcodes');
                extract(shortcode_atts(
                        array(
                                'type' => '',
                                'color' => '',
                                'corners'   => '',
                                'close' => 'yes',
                                'custom_class' => '',
				'class' => '',
                                'icon'    => ''
                ), $atts));
                $close_btn = ($close == 'yes') ? '<a href="#" class="close">&times;</a>'  : '' ;

		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		// ini
		$font_icon ='';
		$domain = WP_FOUNDATION_SHORTCODES_DOMAIN;
		$type_val = str_replace(' ', '-', trim($type));

		if ($icon == 'yes'):
			switch($color){
				case "success":
					$font_icon = '<i class="fa fa-check"></i>';
				break;
				case "secondary":
					$font_icon = '<i class="fa fa-cog"></i>';
				break;
				case "alert":
                                        $font_icon = '<i class="fa fa-heartbeat"></i>';
                                break;
				case "info":
                                        $font_icon = '<i class="fa fa-info-circle"></i>';
                                break;
				case "warning":
                                        $font_icon = '<i class="fa fa-exclamation-triangle"></i>';
                                break;
				default:
					$font_icon ='<i class="fa fa-lightbulb-o"></i>';
				break;
			}
		endif;
		
                $output = <<<HTML
                <div data-alert class="wpfs alert-box type-{$type_val} {$domain} {$color} {$corners} {$custom_class}"{$free_atts}>{$font_icon}{$alertContent}{$close_btn}</div>
HTML;
                return $output;
	}

	// tabs
	public static function tabs( $atts, $content = null){
		global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
				'direction' => 'horizontal',
	                        'custom_class' => '',
				'class'
                ), $atts));

		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$global_wp_foundation_shortcodes['tab_counter'] = 0;
		$global_wp_foundation_shortcodes['tab_title'] = true;
		$global_wp_foundation_shortcodes['tab_id'] = rand();

		$output = '<div class="wpfs tabs-wrapper '.$custom_class.'">';

		$output .= '<ul class="tabs '.$direction.'" data-tab '.$free_atts.'>';
		$output .=  do_shortcode($content);
		$output .= '</ul><!--/.tabs -->';
		
		$global_wp_foundation_shortcodes['tab_counter'] = 0;
		$global_wp_foundation_shortcodes['tab_title'] = false;
		$output .= '<div class="tabs-content">';
		$output .=  do_shortcode($content);
		$output .= '</div><!-- /.tabs-content -->';
		$output .= '</div><!-- /.tabs-wrapper -->';

                return $output;
	}

	// help function for tabs
	public static function tab( $atts, $content = null){
                global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $tabContent = do_shortcode($content);
		$global_wp_foundation_shortcodes['tab_counter']++;

                extract(shortcode_atts(array(
                        'title' => ''
                ), $atts));
                $active_class = ($global_wp_foundation_shortcodes['tab_counter'] == 1) ? 'active' : '' ;
		
		if ($global_wp_foundation_shortcodes['tab_title']){
			$output = <<<HTML
			<li class="tab-title {$active_class}" {$free_atts}><a href="#tabpanel-{$global_wp_foundation_shortcodes['tab_id']}-{$global_wp_foundation_shortcodes['tab_counter']}">{$title}</a></li>
HTML;
		} else {
			$output = <<<HTML
                        <div class="content {$active_class}" id="tabpanel-{$global_wp_foundation_shortcodes['tab_id']}-{$global_wp_foundation_shortcodes['tab_counter']}">
				{$tabContent}
                        </div>
HTML;
		}
		
                return $output;
        }

	// accordions   
        public static function accordions( $atts, $content = null){
                global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'custom_class' => '',
				'class' => ''
                ), $atts));
                // ini
                $i = 0;

		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$global_wp_foundation_shortcodes['accordion_counter'] = 0;
		$global_wp_foundation_shortcodes['accordion_id'] = rand();
                $output = '<ul class="wpfs accordion '.$custom_class.'" data-accordion '.$free_atts.'>';
                $output .=  do_shortcode($content);
                $output .= '</ul><!-- /.accordion -->';

                return $output;
        }

        // help function for accordions
        public static function accordion( $atts, $content = null){
                global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $accordionContent = do_shortcode($content);
                $global_wp_foundation_shortcodes['accordion_counter'] ++;
                extract(shortcode_atts(array(
                        'title' => '',
                        'active' => '',
			'custom_class' => '',
                        'class' => ''
			
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $active_class = ($active == 'yes') ? 'active' : '' ;
                $output = <<<HTML
                        <li class="wpfs accordion-navigation {$custom_class}"{$free_atts}>
                                <a href="#panel-{$global_wp_foundation_shortcodes['accordion_id']}-{$global_wp_foundation_shortcodes['accordion_counter']}a">{$title}</a>
                                <div id="panel-{$global_wp_foundation_shortcodes['accordion_id']}-{$global_wp_foundation_shortcodes['accordion_counter']}a" class="content {$active_class}">{$accordionContent}</div>
                        </li>
HTML;
                return $output;
        }


	// progressbar
	public static function progressbar( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'value' => '',
                                'color' => '',
                                'corners'   => '',
                                'custom_class' => '',
				'class' => ''
                ), $atts));

		// ini
		$domain = WP_FOUNDATION_SHORTCODES_DOMAIN;
		$value = floatval($value);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
                <div class="wpfs progress {$domain} {$corners} {$custom_class}"{$free_atts}>
                        <span class="meter {$color}" style="width:{$value}%;">
				<p class="percent">{$value}%</p>
			</span>
                </div><!-- /.progress -->
HTML;
                return $output;
	}

	public static function range_slider( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'direction' => '',
                                'accessibility' => '',
                                'corners'   => '',
                                'custom_class' => '',				
                                'class' => '',				
                                'initial_value' => '',
                                'start_value' => '',
                                'end_value' => '',
                                'step' => ''
                ), $atts));

                $direction_data_options = $direction_class = $initial_value_data_options = '';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                switch ($direction){
                        case 'vertical':
                                $direction_class = 'vertical-range';
                                $direction_data_options = 'vertical: true;';
                        break;
                        default:

                        break;
                }
                if ($initial_value){
                        $initial_value_data_options = 'initial:'.$initial_value.';';
                }else{
                        $initial_value = 50;
                }
		$start_value_data_options = ($start_value) ? 'start:'.$start_value.';' : '' ;
		$end_value_data_options = ($end_value) ? 'end:'.$end_value.';' : '' ;
		$step_data_options = ($step) ? 'step:'.$step.';' : '' ;

                $id = rand(); // create unique id

                $output = <<<HTML
                <div class="wpfs range-slider {$direction_class} {$accessibility} {$corners} {$custom_class}" data-slider data-options="{$direction_data_options}{$initial_value_data_options}{$start_value_data_options}{$end_value_data_options}{$step_data_options}"{$free_atts}>
	                <span class="range-slider-handle" role="slider" tabindex="0"></span>
                        <span class="range-slider-active-segment"></span>
                        <input type="hidden">
                </div>
HTML;

                return $output;
	}	

	public static function pricing_table( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		extract(shortcode_atts(
                        array(
                                'title'    => '',
                                'price'    => '',
                                'description' => '',
                                'item_name_1' => '',
                                'item_name_2' => '',
                                'item_name_3' => '',
                                'item_name_4' => '',
                                'item_name_5' => '',
                                'item_name_6' => '',
                                'item_name_7' => '',
                                'item_name_8' => '',
                                'item_name_9' => '',
                                'item_name_10' => '',
                                'button_text' => '',
                                'url'    => '',
                                'target'  => '',
                                'custom_class'   => '',
                                'class'   => '',
				'recommended' => 'no'
                ), $atts));
		
		// ini
		$url = esc_attr($url);
		$target = esc_attr($target);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$recommended_class_val = ($recommended == 'yes') ? 'recommended' : '' ;
		$recommended_title_val = ($recommended == 'yes') ? '<li class="best"><strong>'.__('Recommended', 'wp-foundation-shortcodes').'</strong></li>' : '' ;

                $output = <<<HTML
                <ul class="wpfs pricing-table {$custom_class} {$recommended_class_val}"{$free_atts}>
			{$recommended_title_val}
                        <li class="title">{$title}</li>
                        <li class="price">{$price}</li>
			<li class="description">{$description}</li>
HTML;
		for($i = 1; $i <= 10; $i++){
	                if (${"item_name_$i"}) $output .= '<li class="bullet-item">'.do_shortcode(${"item_name_$i"}).'</li>';
		}

		$output .= <<<HTML
                        <li class="cta-button"><a class="button radius" href="{$url}" target="{$target}">{$button_text}</a></li>
                </ul>
HTML;
		return $output;
	}
	
	// button
	public static function button( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		$buttonContent = ($content) ? do_shortcode($content) : __('Read more', 'wp-foundation-shortcodes');
                extract(shortcode_atts(
                        array(
                                'url'    => '',
                                'target'  => '',
                                'color'   => '',
                                'corners'   => '',
                                'size'    => '',
                                'custom_class'   => '',
                                'class'   => '',
                                'icon'    => ''
                ), $atts));

                $font_icon = ($icon) ? '<i class="fa '.$icon.'"></i> ' : '' ;

		$tag_open = ($url) ? '<a href="'.$url.'" target="'.$target.'"' : '<button' ;
		$tag_close = ($url) ? '</a>' : '</button>' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		$output = <<<HTML
			{$tag_open} class="wpfs button {$color} {$corners} {$size} {$custom_class}"{$free_atts}>{$font_icon}{$buttonContent}{$tag_close}
HTML;
                return $output;
	}

	// label
	public static function label( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		$labelContent = ($content) ? do_shortcode($content) : __('Label', 'wp-foundation-shortcodes');
                extract(shortcode_atts(
                        array(
                                'color'   => '',
                                'corners'   => '',
                                'custom_class'   => '',
                                'class'   => '',
                                'icon'    => ''
                ), $atts));

                $font_icon = ($icon) ? '<i class="fa '.$icon.'"></i> ' : '' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
                        <span class="wpfs label {$color} {$corners} {$custom_class}"{$free_atts}>{$font_icon}{$labelContent}</span>
HTML;


                return $output;
	}

	// equalizers
	public static function equalizers( $atts, $content = null){
		global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$global_wp_foundation_shortcodes['equalizer_counter'] = 0;
		
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		
		$output = '<div data-equalizer class="wpfs row '.$custom_class.'"'.$free_atts.'>';
		$output .=  do_shortcode($content);
		$output .= '</div><!-- /.data-equalizer -->';

                return $output;
        }

	// help function for equalizers
	public static function equalizer( $atts, $content = null){
		global $global_wp_foundation_shortcodes;
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		$equalizerContent = do_shortcode($content);
		$global_wp_foundation_shortcodes['equalizer_counter'] ++;
		$atts = array_map( 'esc_attr', (array)$atts );

		extract(shortcode_atts(array(
                        'title' => ''
                ), $atts));
		$output = <<<HTML
		<div class="{$custom_class} columns"{$free_atts}>
		    <div data-equalizer-watch class="panel panel-{$global_wp_foundation_shortcodes['equalizer_counter']}">
			<h3 class="title">{$title}</h3>
                        <div class="inside">
           	             {$equalizerContent}
                        </div>
			<div class="clearfix"></div>
		    </div>
		</div>
HTML;
		return $output;
	}

	// dropdown
	public static function dropdown( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$dropdownContent = do_shortcode($content);
                extract(shortcode_atts(
                        array(
				'button_text' =>  __('Dropdown', 'wp-foundation-shortcodes'),
				'button_size' => '',
                                'button_color'   => '',
                                'button_corners'   => '',
                                'dropdown_size'    => '',
				'dropdown_direction' => '',
				'dropdown_autoclose' => '',
				'dropdown_open_on_hover' => '',
                                'custom_class'   => '',
                                'class'   => ''
			
                ), $atts));

		// ini	
		$id = rand();
		$button_class_arr = $dropdown_class_arr = $data_options_arr = Array();
		$button_size = esc_attr($button_size);
		$button_color = esc_attr($button_color);
		$button_corners = esc_attr($button_corners);
		$dropdown_size = esc_attr($dropdown_size);
		$dropdown_direction = esc_attr($dropdown_direction);
		$dropdown_autoclose = esc_attr($dropdown_autoclose);
		$dropdown_open_on_hover = esc_attr($dropdown_open_on_hover);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		
		if ($button_size != 'simple_link'){
			array_push($button_class_arr, 'button', $button_size, $button_color, $button_corners);
		}

		if ($dropdown_size) array_push($dropdown_class_arr, $dropdown_size);

		if ($dropdown_direction){
			array_push($data_options_arr, 'align:'.$dropdown_direction.';');
		}
		if ($dropdown_open_on_hover == 'yes'){
			array_push($data_options_arr, 'is_hover:true; hover_timeout:5000;');
		}
		
		$aria_autoclose = ($dropdown_autoclose == 'yes') ? 'true' : 'false' ;
		$button_class = implode(' ', $button_class_arr);
		$data_options = implode(' ',$data_options_arr);
		$dropdown_class = implode(' ',$dropdown_class_arr);

		$output = <<<HTML
		<div class="wpfs dropdown-wrapper {$custom_class}"{$free_atts}>
			<a class="{$button_class}" data-dropdown="drop{$id}" aria-controls="drop{$id}" aria-expanded="false" data-options="{$data_options}">{$button_text} &raquo;</a>
			<div id="drop{$id}" data-dropdown-content class="f-dropdown content {$dropdown_class}" aria-hidden="true" tabindex="-1" aria-autoclose="{$aria_autoclose}">{$dropdownContent}</div>
		</div><!-- /.dropdown-wrapper -->
HTML;

		return $output;
	}

	// split buttons
        public static function split_button( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $splitButtonsContent = do_shortcode($content);
                extract(shortcode_atts(
                        array(
                                'button_text' =>  __('Split Button', 'wp-foundation-shortcodes'),
				'button_url' => '',
                                'button_size' => '',
                                'button_color'   => '',
                                'button_corners'   => '',
                                'dropdown_size'    => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));

		// ini
                $id = rand();
		$button_url = esc_attr($button_url);
		$button_size = esc_attr($button_size);
		$button_color = esc_attr($button_color);
		$button_corners = esc_attr($button_corners);
		$dropdown_size = esc_attr($dropdown_size);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
		<div class="wpfs split-button-wrapper {$custom_class}"{$free_atts}>
			<a href="{$button_url}" class="button split {$button_size} {$button_color} {$button_corners}">{$button_text} <span data-dropdown="drop-{$id}"></span></a>
			<div id="drop-{$id}" class="f-dropdown content {$dropdown_size}" data-dropdown-content>{$splitButtonsContent}</div>
		</div><!-- /.split-button-wrapper -->
HTML;

                return $output;
        }
	
	// blockquote
	public static function blockquote( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $blockquoteContent = ($content) ? do_shortcode($content) : __('Those people who think they know everything are a great annoyance to those of us who do.', 'wp-foundation-shortcodes');
		extract(shortcode_atts(
                        array(
				'author'	=> '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		$output = <<<HTML
		<blockquote class="wpfs {$custom_class}"{$free_atts}>{$blockquoteContent}<cite>{$author}</cite></blockquote>
HTML;

		return $output;
	}
	
	// icon
        public static function icon( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
		$iconContent = ($content) ? '&nbsp;'.do_shortcode($content) : '';
                extract(shortcode_atts(
                        array(
                                'icon'        => '',
                                'size'        => '',
                                'color'        => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$icon_color = ($color) ? 'color:'.$color.';' : '' ;
		$icon_size = ($size) ? 'font-size:'.$size.';' : '' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
		<i class="wpfs {$custom_class} fa {$icon}"{$free_atts} style="{$icon_color}{$icon_size}">{$iconContent}</i>
HTML;

                return $output;
        }

	// address
        public static function address( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $addressContent = ($content) ? do_shortcode($content) : '';
                extract(shortcode_atts(
                        array(
                                'title'        => '',
                                'custom_class'   => '',
				'class' => ''
                ), $atts));
		$address_title = ($title) ? '<strong>'.$title.'</strong><br/>' : '' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
		<address class="wpfs {$custom_class}"{$free_atts}>
			{$address_title}{$addressContent}
		</address>
HTML;

                return $output;
        }
	
	// clear
	public static function clear( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$output = <<<HTML
		<div class="clearfix"{$free_atts}></div>
HTML;

                return $output;
	}

	// span
        public static function span_func( $atts, $content = null){
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$spanContent = ($content) ? do_shortcode($content) : '';
		extract(shortcode_atts(
                        array(
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$custom_class_val = ($custom_class) ? ' class="'.$custom_class.'"' : '' ;
                $output = <<<HTML
                <span{$custom_class_val}{$free_atts}>{$spanContent}</span>
HTML;

                return $output;
        }

	// hr
	public static function hr( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$custom_class_val = ($custom_class) ? ' class="'.$custom_class.'"' : '' ;
                $output = <<<HTML
                <hr{$custom_class_val}{$free_atts}/>
HTML;

                return $output;
        }

	// row
	public static function row( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$rowContent = ($content) ? do_shortcode($content) : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
				'custom_class'   => '',
                                'class'        => ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
                <div class="row {$custom_class}"{$free_atts}>{$rowContent}</div>
HTML;

                return $output;
        }

	// columns
	public static function columns( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		$columnsContent = ($content) ? do_shortcode($content) : '';
		extract(shortcode_atts(
                        array(
				'custom_class'   => '',
                                'class'        => ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$output = <<<HTML
                <div class="columns {$custom_class}"{$free_atts}>{$columnsContent}</div>
HTML;
		return $output;
	}

	// blocks grid
	public static function blocks_grid( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                $blocksGridContent = ($content) ? do_shortcode($content) : '';
                extract(shortcode_atts(
                        array(
				'custom_class'   => '',
                                'class'        => ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
                <ul class="wpfs {$custom_class}"{$free_atts}>{$blocksGridContent}</ul>
HTML;
                return $output;
        }

	// block grid
	public static function block_grid( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$blockGridContent = ($content) ? do_shortcode($content) : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'custom_class'   => '',
                                'class'        => ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$custom_class_val = ($custom_class) ? ' class="'.$custom_class.'"' : '' ;
		$output = <<<HTML
                <li{$custom_class_val}{$free_atts}>{$blockGridContent}</li>
HTML;
                return $output;
	}

	// google map
	public static function google_map( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(array(
                	'lat_value'      => '42.340244',
                        'lng_value'      => '-71.105876',
                        'zoom_value'     => '14',
                        'zoom_wheel'     => 'no',
                        'custom_class'  => '',
                        'class'  => '',
                ), $atts));
		
		$id        = rand();
                $lat_value        = floatval( $lat_value );
                $lng_value        = floatval( $lng_value );
                $zoom_value       = intval( $zoom_value );
                $zoom_wheel       = ($zoom_wheel=='yes') ? 'true' : 'false';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		if (get_option('enable-google-map')):
		$output = <<<HTML
			<div class="wpfs google-map {$custom_class}"{$free_atts}>
		                <div id="map-canvas-{$id}" class="gmap"></div>
			</div>
                	<script>
				jQuery(function(){
                                google_api_map_init_{$id}();
                                function google_api_map_init_{$id}(){
                                        var map;
                                        var coordData = new google.maps.LatLng(parseFloat({$lat_value}), parseFloat({$lng_value}));
                                        var marker;

                                        function initialize() {
                                                var mapOptions = {
                                                        zoom: {$zoom_value},
                                                        center: coordData,
                                                        scrollwheel: {$zoom_wheel}
                                                }
                                                var map = new google.maps.Map(document.getElementById("map-canvas-{$id}"), mapOptions);
                                                marker = new google.maps.Marker({
                                                        map:map,
                                                        draggable:true,
                                                        position: coordData
                                                });
                                        }
                                        google.maps.event.addDomListener(window, "load", initialize);
                                }
				});
                                
                </script>
HTML;
		else:
                $url = get_bloginfo('url').'/wp-admin/admin.php?page=wpfoundation_dashboard';
                $mes = sprintf( __( 'Warning: you should enable Google Map first. Go to <a href="%s" target="_blank">WP Foundation Shortcodes Settings</a> page.', 'wp-foundation-shortcodes' ), $url );

                $output = <<<HTML
                <p>{$mes}</p>
HTML;
                endif;
                return $output;
	}
	
	// orbit sliders
        public static function orbit_sliders( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $orbitSlidersContent = ($content) ? do_shortcode($content) : '';
                $output = <<<HTML
			<ul data-orbit class="wpfs"{$free_atts}>{$orbitSlidersContent}</ul>
HTML;
                return $output;
        }

        // orbit slider
        public static function orbit_slider( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $orbitSliderContent = ($content) ? do_shortcode($content) : '';
		extract(shortcode_atts(
                        array(
                                'title'        => ''
                ), $atts));

		$caption = '<div class="orbit-caption"'.$free_atts.'>'.$title.'</div>';
                $output = <<<HTML
                <li>{$orbitSliderContent}{$caption}</li>
HTML;
                return $output;
        }

	// thumbnail
	public static function thumbnail( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                $thumbnailContent = ($content) ? do_shortcode($content) : '';
		$thumbnailContent = esc_attr($thumbnailContent);
		extract(shortcode_atts(
                        array(
                                'url'    => '',
                                'target'  => '',
                                'corners'   => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));

		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
		<a class="wpfs th {$corners} {$custom_class}" role="button" aria-label="Thumbnail" href="{$url}" target="{$target}"{$free_atts}>
			<img aria-hidden=true src="{$thumbnailContent}"/>
		</a>
HTML;
                return $output;
        }

	// Clearing thumbs
	public static function clearing_thumbs( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
                $clearingThumbsContent = ($content) ? do_shortcode($content) : '';
		extract(shortcode_atts(
                        array(
				'custom_class'   => '',
                                'class'        => ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
		<ul class="wpfs clearing-thumbs {$custom_class}" data-clearing{$free_atts}>
			{$clearingThumbsContent}
		</ul>
HTML;
                return $output;
        }

	// Clearing thumb - help function for clearing_thumbs
	public static function clearing_thumb( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                $clearingThumbContent = ($content) ? do_shortcode($content) : '';
		$clearingThumbContent = esc_attr($clearingThumbContent);
                extract(shortcode_atts(
                        array(
                                'title'       => '',
				'url'		=> ''
                ), $atts));
		$href = ($url) ? 'href="'.$url.'"' : '' ;
		$data_caption = ($title) ? 'data-caption="'.$title.'"' : '' ;
                $output = <<<HTML
			<li{$free_atts}><a class="th" {$href}><img {$data_caption} src="{$clearingThumbContent}"></a></li>
HTML;
                return $output;
        }

	// slick slider
        public static function slick_sliders( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		$slickSlidersContent = ($content) ? do_shortcode($content) : '';
		extract(shortcode_atts(
                        array(
                                'autoplay'       => 'no',
                                'slides_to_show' => 1,
				'slides_to_scroll' => 1,
				'dots'		=> 'yes',
				'infinite'	=> 'yes',
				'custom_class'	=> ''
                ), $atts));

		$id = rand();

		if (get_option('enable-slick-slider')):
		$autoplay_val = ($autoplay == 'yes') ? 'true' : 'false' ;
		$dots_val = ($dots == 'yes') ? 'true' : 'false' ;
		$infinite_val = ($infinite == 'yes') ? 'true' : 'false' ;		
		$output = <<<HTML
			<div class="wpfs slick-slider slider slider-{$id} {$custom_class}"{$free_atts}>
				{$slickSlidersContent}
			</div>
			<script>
			jQuery(function(){
			jQuery('.slider-{$id}').slick({
				autoplay:{$autoplay_val},
				slidesToShow: {$slides_to_show},
				slidesToScroll: {$slides_to_scroll},
				dots: {$dots_val},
				infinite: {$infinite_val}
			});
			});
			</script>	
HTML;
		else:
                        $url = get_bloginfo('url').'/wp-admin/admin.php?page=wpfoundation_dashboard';
                        $mes = sprintf( __( 'Warning: you should enable Slick Slider first. Go to <a href="%s" target="_blank">WP Foundation Shortcodes Settings</a> page.', 'wp-foundation-shortcodes'), $url );

                        $output = <<<HTML
                        <p>{$mes}</p>
HTML;
                endif;
		return $output;
	}
	
	// help function for slick slider
	public static function slick_slider( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$slickSliderContent = ($content) ? do_shortcode($content) : '';
		$slickSliderContent = esc_attr($slickSliderContent);
		$output = <<<HTML
		<div{$free_atts}><img src="{$slickSliderContent}" alt=""></div>
HTML;
		return $output;
        }

	// button groups
        public static function button_groups( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'color'   => '',
                                'corners'   => '',
                                'size'    => '',
                                'custom_class'   => '',
                                'class'   => ''
                ), $atts));

		if ($color) 	$content = str_replace ('[button_group', '[button_group color="'.$color.'"', $content);
		if ($size) 	$content = str_replace ('[button_group', '[button_group size="'.$size.'"', $content);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		
		$buttonGroupsContent = ($content) ? do_shortcode($content) : '';
                $output = <<<HTML
			<ul class="wpfs button-group {$corners} {$custom_class}"{$free_atts}>
				{$buttonGroupsContent}
			</ul>
HTML;
                return $output;
        }

        // button group
        public static function button_group( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$buttonGroupContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'color'   => '',
                                'size'    => '',
				'url'	=> ''
                ), $atts));
                $output = <<<HTML
			<li{$free_atts}><a href="{$url}" class="button {$color} {$size}">{$buttonGroupContent}</a></li>
HTML;
                return $output;
        }

	

	// switch
	public static function switch_func( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$id = 'switch-'.rand();
                extract(shortcode_atts(
                        array(
				'type' => 'checkbox',
				'name' => '',
				'id' => $id,
				'corners' => '',
                                'size'    => '',
				'label_on_status' => '',
				'label_off_status' => '',
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));
		
		// ini
                $domain = WP_FOUNDATION_SHORTCODES_DOMAIN;
		$type = esc_attr($type);
		$name = esc_attr($name);
		$id = esc_attr($id);
		$corners = esc_attr($corners);
		$size = esc_attr($size);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
	
		$name_val = ($name) ? 'name="'.trim($name).'"'  : '' ;
		$label_on_status_val = ($label_on_status) ? '<span class="switch-on-off switch-on">'.$label_on_status.'</span>' : '' ;
		$label_off_status_val = ($label_off_status) ? '<span class="switch-on-off switch-off">'.$label_off_status.'</span>' : '' ;

                $output = <<<HTML
		<div class="wpfs switch {$domain} {$corners} {$size} {$custom_class}"{$free_atts}>
			<input id="{$id}" type="{$type}" {$name_val}>
			<label for="{$id}">
				{$label_on_status_val}{$label_off_status_val}
			</label>
		</div>
HTML;
                return $output;
        }

	// inline list
	public static function inline_list( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$inlineListContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'custom_class'  => '',
                                'class'  => '',				
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$output = <<<HTML
		<ul class="wpfs inline-list {$custom_class}"{$free_atts}>{$inlineListContent}</ul>
HTML;
		return $output;
	}

	// link
	public static function link_func( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$linkContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
                                'url'  => ''
                ), $atts));
		$output = <<<HTML
		<li{$free_atts}><a href="{$url}">{$linkContent}</a></li>
HTML;
		return $output;
	}

	// keystroke
	public static function keystroke( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $keystrokeContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
		<kbd class="wpfs {$custom_class}"{$free_atts}>{$keystrokeContent}</kbd>
HTML;
                return $output;
        }

	// panel
        public static function panel( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $panelContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
				'corners' => '',
				'callout' => 'no',
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));

		$callout_class = ($callout == 'yes') ? 'callout' : '' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $output = <<<HTML
		<div class="wpfs panel {$corners} {$callout_class} {$custom_class}"{$free_atts}>{$panelContent}</div>
HTML;
                return $output;
        }

	// tooltip
        public static function tooltip( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $tooltipContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
				'title' => '',
                                'corners' => '',
				'direction' => 'bottom',
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));
		
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		switch ($direction){
                        case 'top':
                                $direction_class = 'tip-top';
                        break;
			case 'left':
                                $direction_class = 'tip-left';
                        break;
			case 'right':
                                $direction_class = 'tip-right';
                        break;
			case 'bottom':
			default:
				$direction_class = 'tip-bottom';
			break;
                }

                $output = <<<HTML
		<span data-tooltip aria-haspopup="true" class="wpfs has-tip {$direction_class} {$corners} {$custom_class}" title="{$title}"{$free_atts}>{$tooltipContent}</span>
HTML;
                return $output;
        }

	// product_card
	public static function product_card( $atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $productCardContent = ($content) ? do_shortcode($content) : '';
                extract(shortcode_atts(
                        array(
                                'title' => '',
				'price' => '',
				'img' => '',
				'button_text' => '',
				'url' => '',
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));

		// ini
		$img = esc_attr($img);
		$url = esc_attr($url);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		$button_val = ($button_text) ? '<a class="button expand add-to-cart" href="'.$url.'">'.$button_text.'</a>' : '' ;
		$title_val = ($title) ? '<h3><a href="'.$url.'">'.$title.'</a></h3>' : '' ;
		$price_val = ($price) ? '<h5>'.$price.'</h5>' : '' ;

		$output = <<<HTML
		<div class="wpfs product-card-wrapper {$custom_class}"{$free_atts}>
		        <div class="img-wrapper">
				{$button_val}
				<a href="{$url}"><img src="{$img}" alt=""></a>
		        </div>  
			{$title_val}
			{$price_val}
		        <p>{$productCardContent}</p>
		</div>
HTML;
		return $output;
	}

	// product_card_hover
	public static function product_card_hover( $atts, $content = null){
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                extract(shortcode_atts(
                        array(
                                'title' => '',
                                'price' => '',
                                'img' => '',
                                'button_text' => '',
                                'url' => '',
                                'hover_effect' => '',
                                'custom_class'  => '',
                                'class'  => '',
                ), $atts));

		// ini
		$img = esc_attr($img);
		$url = esc_attr($url);
		$hover_effect = esc_attr($hover_effect);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		$output = <<<HTML
		<div class="wpfs product-card-hover-wrapper {$hover_effect} {$custom_class}"{$free_atts}>
	      		<img src="{$img}" alt="">
			<div class="image-overlay-content">
			        <h2>{$title}</h2>
			        <p class="price">{$price}</p>
			        <a href="{$url}" class="button">{$button_text}</a>
			</div>
		</div>	
HTML;
		return $output;
	}

	// radio button groups
        public static function radio_button_groups( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
				'name' => '',
                                'color'   => '',
                                'corners'   => '',
                                'size'    => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));

		$domain = WP_FOUNDATION_SHORTCODES_DOMAIN;
		$name_val = ($name) ? $name : 'r-group-'.rand();

                if ($color)     $content = str_replace ('[radio_button_group', '[radio_button_group color="'.$color.'"', $content);
                if ($size)      $content = str_replace ('[radio_button_group', '[radio_button_group size="'.$size.'"', $content);
                $content = str_replace ('[radio_button_group', '[radio_button_group name="'.$name_val.'"', $content);

                $buttonGroupsContent = ($content) ? do_shortcode($content) : '';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
                        <ul class="wpfs button-group toggle {$domain} {$corners} {$custom_class}"{$free_atts}>
                                {$buttonGroupsContent}
                        </ul>
HTML;
                return $output;
        }

        // radio button group
        public static function radio_button_group( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $buttonGroupContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'color'   => '',
                                'size'    => '',
                                'name'   => '',
				'id' => ''
                ), $atts));
                $output = <<<HTML
			<li{$free_atts}>
				<input type="radio" id="{$id}" name="{$name}" data-toggle="button">
				<label class="button {$color} {$size}" for="{$id}">{$buttonGroupContent}</label>
			</li>
HTML;
                return $output;
        }

	// button_option_groups
	public static function button_option_groups($atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'label' => '',
                                'corners'   => '',
                                'size'    => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
	
		$domain = WP_FOUNDATION_SHORTCODES_DOMAIN;

		if ($corners)   $content = str_replace ('[button_option_group', '[button_option_group corners="'.$corners.'"', $content);
                if ($size)      $content = str_replace ('[button_option_group', '[button_option_group size="'.$size.'"', $content);
	
		$buttonGroupsContent = ($content) ? do_shortcode($content) : '';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $output = <<<HTML
			<div class="wpfs button-group button-option-group {$domain} size-{$size}  {$custom_class}" data-grouptype="{$label}"{$free_atts}>
				{$buttonGroupsContent}
			</div>
HTML;
		return $output;
	}

	// button_option_group
	public static function button_option_group($atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $buttonGroupContent = ($content) ? do_shortcode($content) : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(
                        array(
                                'corners'   	=> '',
                                'size'    	=> '',
                                'custom_class' 	=> '',
                                'class' 	=> '',
				'url'		=> ''
                ), $atts));
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$output = <<<HTML
			<a href="{$url}" class="wpfs button {$custom_class} {$corners} {$size}"{$free_atts}>{$buttonGroupContent}</a>
HTML;
		return $output;
	}

	//social_login_button
	public static function social_login_button($atts, $content = null){
		$content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $buttonContent = ($content) ? do_shortcode($content) : '';	
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(
                        array(
				'type'		=> '',
                                'corners'       => '',
                                'size'          => '',
                                'custom_class'  => '',
                                'class'  => '',
				'icon_side'	=> ''
                ), $atts));

		// ini
		$domain = WP_FOUNDATION_SHORTCODES_DOMAIN;
		$fa_class = '';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		switch($type){
			case 'facebook':
				$fa_class = 'fa-facebook-official';
			break;
			case 'twitter':
				$fa_class = 'fa-twitter';
			break;
			case 'google':
                                $fa_class = 'fa-google-plus-square';
                        break;
			default:

			break;
		}

		$output = <<<HTML
		<button href="#" class="wpfs {$type} button split {$domain} social-login-button {$corners} {$size} {$icon_side}-icon {$custom_class}"{$free_atts}><span><i class="fa {$fa_class}"></i>
</span>{$buttonContent}</button>
HTML;
                return $output;
	}

	// posts cycle
	public static function posts_cycle($atts, $content = null){
                global $post;
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                ob_start();
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(array(
			'numberposts' => '',
                        'category'        => '',
                        'tag'        => '',
                        'order_by'        => 'date',
                        'order'           => 'DESC',
                        'meta'            => 'yes',
                        'excerpt_count'   => '25',
			'autoplay'       => 'no',
                        'posts_to_show' => 1,
                        'posts_to_scroll' => 1,
                        'dots'          => 'yes',
                        'infinite'      => 'yes',
                        'custom_class'    => '',
                        'class'    => '',
                ), $atts));
		
		$id = rand(); // rand id

                if (get_option('enable-slick-slider')):
                $autoplay_val = ($autoplay == 'yes') ? 'true' : 'false' ;
                $dots_val = ($dots == 'yes') ? 'true' : 'false' ;
                $infinite_val = ($infinite == 'yes') ? 'true' : 'false' ;
		$thumb_size = ($posts_to_show == 1) ? 'large' : 'medium' ;
		$args = array(
                        'post_type'         => 'post',
                        'category_name'     => $category,
                        'tag'                   => $tag,
                        'numberposts'       => $numberposts,
                        'orderby'           => $order_by,
                        'order'             => $order,
                        'suppress_filters'  => get_option('suppress_filters') // WPML filter
                );
                $myposts = get_posts( $args );

                if ( empty( $myposts ) ) {
                        wp_reset_postdata();
                        return;
                }
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		?>
                        <div class="wpfs slider posts-cycle slider-<?php echo $id;?> <?php echo $custom_class;?>"<?php echo $free_atts;?>>
				<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>
                        	<div>
                	                <?php include(WP_Foundation_shortcodes_plugables::get_template_part('content', get_post_format() )); ?>
        	                </div>
	                        <?php endforeach; ?>
                        </div>
                        <script>
                        jQuery(function(){
                        jQuery('.slider-<?php echo $id;?>').slick({
                                autoplay:<?php echo $autoplay_val;?>,
                                slidesToShow: <?php echo $posts_to_show;?>,
                                slidesToScroll: <?php echo $posts_to_scroll;?>,
                                dots: <?php echo $dots_val;?>,
                                infinite: <?php echo $infinite_val;?>
                        });
                        });
                        </script>
		
                <?php else:
                        $url = get_bloginfo('url').'/wp-admin/admin.php?page=wpfoundation_dashboard';
                        $mes = sprintf( __( 'Warning: you should enable Slick Slider first. Go to <a href="%s" target="_blank">WP Foundation Shortcodes Settings</a> page.', 'wp-foundation-shortcodes' ), $url );

                        $output = <<<HTML
                        <p>{$mes}</p>
HTML;
                endif;

		wp_reset_postdata();
                return ob_get_clean();
	}

	// posts_grid
	public static function posts_grid($atts, $content = null){
		global $post;
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		ob_start();
		$atts = array_map( 'esc_attr', (array)$atts );
		extract(shortcode_atts(array(
                        'category'        => '',
                        'tag'        => '',
                        'columns'         => '3',
                        'rows'            => '3',
                        'order_by'        => 'date',
                        'order'           => 'DESC',
                        'meta'            => 'yes',
                        'excerpt_count'   => '25',
                        'custom_class'    => '',
                        'class'    => '',
                ), $atts));

		// ini
		$columns = abs(round($columns));
		$rows = abs(round($rows));
		$columns = ($columns) ? $columns : 3 ;
		$rows = ($rows) ? $rows : 3 ;
		$excerpt_count = abs(intval($excerpt_count));
		$excerpt_count = ($excerpt_count) ? $excerpt_count : 25 ;
		$large_num      = ($columns) ? $columns : 1;
                $tmp = round($large_num / 2);
                $medium_num     = ($tmp) ? $tmp : 1;
                $tmp = round($medium_num / 2);
                $small_num      = ($tmp) ? $tmp : 1;
		$order_by = ($order_by == 'random') ? 'rand' : $order_by  ;
		$thumb_size = ($columns == 1) ? 'large' : 'medium' ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $args = array(
			'post_type'         => 'post',
               	        'category_name'     => $category,
			'tag'			=> $tag,
                        'numberposts'       => ($columns * $rows),
       	                'orderby'           => $order_by,
               	        'order'             => $order,
                       	'suppress_filters'  => get_option('suppress_filters') // WPML filter
                );


                $myposts = get_posts( $args );

                if ( empty( $myposts ) ) {
	                wp_reset_postdata();
                        return;
                }
		?>
	
		<ul class="wpfs small-block-grid-<?php echo $small_num;?> medium-block-grid-<?php echo $medium_num;?> large-block-grid-<?php echo $large_num;?> posts-grid <?php echo $custom_class;?>"<?php echo $free_atts;?>>
			<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>
                        <li>
				<?php include(WP_Foundation_shortcodes_plugables::get_template_part('content', get_post_format() )); ?>
                        </li>
	                <?php endforeach; ?>
		</ul>
	
		<?php
		wp_reset_postdata();
		return ob_get_clean();
	}

	// posts_list
        public static function posts_list($atts, $content = null){
                global $post;
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                ob_start();
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(array(
			'numberposts'	=> '',
			'thumbs'	=> '', //thumbnail, medium, large
			'post_content'	=> '', //excerpt, content
                        'category'      => '',
                        'tag'        	=> '',
                        'order_by'      => 'date',
                        'order'         => 'DESC',
                        'meta'          => 'yes',
                        'custom_class'  => '',
                        'class'  => '',
                ), $atts));

		// ini
		$numberposts = intval($numberposts);
		$order_by = ($order_by == 'random') ? 'rand' : $order_by  ;
		$thumbs = ($thumbs == 'small') ? 'thumbnail' : $thumbs ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

                $args = array(
                        'post_type'         => 'post',
                        'category_name'     => $category,
                        'tag'                   => $tag, 
                        'numberposts'       => $numberposts,
                        'orderby'           => $order_by,
                        'order'             => $order,
                        'suppress_filters'  => get_option('suppress_filters') // WPML filter
                );

		$myposts = get_posts( $args );

                if ( empty( $myposts ) ) {
                        wp_reset_postdata();
                        return;
                }
                ?>
		<div class="wpfs posts-list <?php echo $custom_class;?>"<?php echo $free_atts; ?>>
			<?php foreach ( $myposts as $post ) : setup_postdata( $post );?>
			<div class="list-item list-item-<?php echo $post->ID;?>">
                                <?php include(WP_Foundation_shortcodes_plugables::get_template_part('post-list-content', get_post_format() )); ?>
                        </div>
			<?php endforeach; ?>
		</div>
		<?php
		wp_reset_postdata();
                return ob_get_clean();
	}

	// posts_lightbox
        public static function posts_lightbox($atts, $content = null){
                global $post;
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                ob_start();
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(array(
			'numberposts'   => '',
                        'category'        => '',
                        'tag'        => '',
			'thumbs'	=> '',
                        'order_by'        => 'date',
                        'order'           => 'DESC',
                        'custom_class'    => '',
                        'class'    => '',
                ), $atts));

                // ini
		$thumbs_val = '';
                $order_by = ($order_by == 'random') ? 'rand' : $order_by  ;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		switch($thumbs){
			case "small":
				$thumbs_val = 'thumbnail';
			break;
			case "mini":
                                $thumbs_val = Array( get_option('thumbnail_size_w')*2/3  ,get_option('thumbnail_size_h')*2/3);
                        break;
			default:
				$thumbs_val = 'medium';
			break;
		}

                $args = array(
                        'post_type'         => 'post',
                        'category_name'     => $category,
                        'tag'                   => $tag,
                        'numberposts'       => $numberposts,
                        'orderby'           => $order_by,
                        'order'             => $order,
                        'suppress_filters'  => get_option('suppress_filters') // WPML filter
                );


                $myposts = get_posts( $args );

                if ( empty( $myposts ) ) {
                        wp_reset_postdata();
                        return;
                }
                ?>
		<ul class="wpfs clearing-thumbs <?php echo $custom_class;?> posts-lightbox" data-clearing<?php echo $free_atts; ?>>
                        <?php foreach ( $myposts as $post ) : setup_postdata( $post );
			if ( !has_post_thumbnail() ){ continue; }
			?>
                        <li>
                                <?php include(WP_Foundation_shortcodes_plugables::get_template_part('post-lightbox-content', get_post_format() )); ?>
                        </li>
                        <?php endforeach; ?>
                </ul>

                <?php
                wp_reset_postdata();
                return ob_get_clean();        
	}

	// tags
        public static function tags($atts, $content = null){
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$args = array(
			'smallest'                  => 8, 
			'largest'                   => 22,
			'unit'                      => 'pt', 
			'echo'			=> false,
			'format'		=> 'array'
		);

		$tags = wp_tag_cloud($args);
		$tags_content = '';
		foreach($tags as $tag){
                        $tags_content .= $tag.' ';
                }	

		$output = <<<HTML
			<div class="wpfs tags-cloud clearfix"{$free_atts}>{$tags_content}</div><!-- /.tags-cloud (end) -->
HTML;
                return $output;
	}

	// categories
	public static function categories($atts, $content = null){
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
		$atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(array(
                        'list_type'   => '',
                        'custom_class'    => '',
                        'class'    => '',
                ), $atts));

		// ini
		$list_start = $list_end = $categories_content = '';
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		switch($list_type){
			case "disc":
			case "circle":
			case "square":
			case "no-bullet":
				$list_start = '<ul class="wpfs categories-list '.$list_type.' '.$custom_class.'"'.$free_atts.'>';
				$list_end = '</ul>';
			break;
			case "numbered":
				$list_start = '<ol class="wpfs categories-list '.$list_type.' '.$custom_class.'"'.$free_atts.'>';
                                $list_end = '</ol>';
			break;
			default:

			break;
		}

		$args = array(
                        'type'     => 'post'
                );
                $categories = get_categories($args);
		if ($categories) :
		foreach ($categories as $category) {
                        $categories_content .= '<li><a href="' . get_category_link( $category ) . '">' . $category->name.'</a></li>';
                }
		endif;

		$output = <<<HTML
		{$list_start}{$categories_content}{$list_end}
HTML;

		return $output;
	}

	// comments
	public static function comments($atts, $content = null){
		global $wpdb;
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $atts = array_map( 'esc_attr', (array)$atts );
                extract(shortcode_atts(array(
                        'num'   => '',
                        'custom_class'    => '',
                        'class'    => '',
                ), $atts));

		if ( function_exists( 'wpml_get_language_information' ) ) {
                        global $sitepress;
                        $sql = "
                                SELECT * FROM {$wpdb->comments}
                                JOIN {$wpdb->prefix}icl_translations
                                ON {$wpdb->comments}.comment_post_id = {$wpdb->prefix}icl_translations.element_id
                                AND {$wpdb->prefix}icl_translations.element_type='post_post'
                                WHERE comment_approved = '1'
                                AND language_code = '".$sitepress->get_current_language()."'
                                ORDER BY comment_date_gmt DESC LIMIT {$num}";
                } else {
                        $sql = "
                                SELECT * FROM $wpdb->comments
                                LEFT OUTER JOIN $wpdb->posts
                                ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
                                WHERE comment_approved = '1'
                                AND comment_type = ''
                                AND post_password = ''
                                ORDER BY comment_date_gmt DESC LIMIT {$num}";
                }

                $comments = $wpdb->get_results($sql);
		
		// ini
		$comment_len = 100;
		$comments_content = '';
		$itemcounter = 1;
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);

		if ($comments) :
		foreach ($comments as $comment) {
                        $comments_content .= '<li class="list-item-'.$itemcounter.'"'.$free_atts.'>';
                                $comments_content .= '<a href="'.get_comment_link($comment->comment_ID).'" title="'.__('on', 'wp-foundation-shortcodes').' '.get_the_title($comment->comment_post_ID).'">';
                                $comments_content .= strip_tags($comment->comment_author).' : ' . strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len));
                                if (strlen($comment->comment_content) > $comment_len) $comments_content .= '...';
                                $comments_content .= '</a>';
                        $comments_content .= '</li>';
                        $itemcounter++;
                }
		endif;

		$output = <<<HTML
		<ul class="wpfs comments-list {$custom_class}">{$comments_content}</ul>
HTML;
		
		return $output;
	}

	// banner
        public static function banner( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $bannerContent = do_shortcode($content);;
                extract(shortcode_atts(
                        array(
				'title' => '',
				'img'	=> '',
                                'url'    => '',
				'btn_text' => __('Read more', 'wp-foundation-shortcodes'),
                                'target'  => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));

		// ini
		$img = esc_attr($img);
		$url = esc_attr($url);
		$target = esc_attr($target);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
		$figure_val = '';

		if ($img) :
			$figure_val = <<<HTML
			<figure class="featured-thumbnail">
                                <a href="{$url}">
                                        <img alt="" src="{$img}">
                                </a>
                        </figure>
HTML;
		endif;

                $output = <<<HTML
		<div class="wpfs banner-wraper {$custom_class}"{$free_atts}>
			{$figure_val}
			<h3 class="title">{$title}</h3>
			<p class="txt">{$bannerContent}</p>
			<div class="button-wrapper">
				<a target="{$target}" class="button radius" href="{$url}">{$btn_text}</a>
			</div>
		</div>
HTML;
                return $output;
        }

	// service_box
	public static function service_box( $atts, $content = null){
                $content = trim($content);
		$free_atts = (isset($atts[0])) ? ' '.trim($atts[0], '{}') : '';
                $boxContent = do_shortcode($content);;
                extract(shortcode_atts(
                        array(
                                'title' => '',
                                'subtitle' => '',
				'icon' => '',
                                'url'    => '',
                                'btn_text' => __('Read more', 'wp-foundation-shortcodes'),
                                'target'  => '',
				'color'	=> '',
				'corners' => '',
				'size' => '',
                                'custom_class'   => '',
                                'class'   => '',
                ), $atts));
	
		// ini
                $icon = esc_attr($icon);
                $url = esc_attr($url);
                $target = esc_attr($target);
		$color  = esc_attr($color);
		$corners = esc_attr($corners);
		$size = esc_attr($size);
		$custom_class = ($custom_class) ? esc_attr($custom_class) : esc_attr($class);
                $figure_val = '';	

		if ($icon):
			$figure_val = <<<HTML
			<figure class="icon">
                                <i class="fa {$icon}"></i>
                        </figure>
HTML;
		endif;

		$output = <<<HTML
		<div class="wpfs service-box panel radius {$custom_class}"{$free_atts}>
			{$figure_val}
			<div class="service-box-content">
				<h2 class="title">{$title}</h2>
				<h5 class="subtitle">{$subtitle}</h5>
				<div class="txt">{$boxContent}</div>
				<div class="button-wrapper">
					<a target="{$target}" class="button {$color} {$corners} {$size}" href="{$url}">{$btn_text}</a>
				</div>
			</div>
		</div>
HTML;
		return $output;
	}

}
}

