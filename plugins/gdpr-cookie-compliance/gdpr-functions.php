<?php
/**
 * Moove_Functions File Doc Comment
 *
 * @category Moove_Functions
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'moove_gdpr_get_plugin_directory_url' ) ) :
	/**
	 * Relative path of the GDPR cookie plugin
	 */
	function moove_gdpr_get_plugin_directory_url() {
		return plugin_dir_url( __FILE__ );
	}
endif;

if ( ! function_exists( 'gdpr_get_site_id' ) ) :
	/**
	 * Returns the current blog id as site_id
	 */
	function gdpr_get_site_id() {
		return function_exists( 'get_current_blog_id' ) ? get_current_blog_id() : 1;
	}
endif;


if ( ! function_exists( 'gdpr_get_field' ) ) :
	/**
	 * Get simple value from gdpr database by option_key
	 */
	function gdpr_get_field( $option_key = false, $site_id = false ) {
		$results = false;
		if ( $option_key ) :
			$site_id 							= $site_id && intval( $site_id ) ? $site_id : gdpr_get_site_id();
			$database_controller 	= new Moove_GDPR_DB_Controller();
			$results							= $database_controller->get( $option_key, $site_id );
			$results 							= $results && isset( $results->option_value ) ? maybe_unserialize( $results->option_value ) : false;
		endif;
		return $results;
	}

endif;

if ( ! function_exists( 'gdpr_get_options' ) ) :
	/**
	 * Get simple value from gdpr database by option_key
	 */
	function gdpr_get_options( $site_id = false ) {
		$site_id 							= $site_id && intval( $site_id ) ? $site_id : gdpr_get_site_id();
		$database_controller 	= new Moove_GDPR_DB_Controller();
		$results							= $database_controller->get_options( $site_id );
		$results_filtered 		= array();
		if ( is_array( $results ) && ! empty( $results ) ) :
			foreach ( $results as $key => $value ) :
				$results_filtered[$key] = maybe_unserialize( $value->option_value );
			endforeach;
		endif;
		$results_filtered 		= $results_filtered && ! empty( $results_filtered ) ? $results_filtered : false;
		return $results_filtered;
	}

endif;

if ( ! function_exists( 'gdpr_update_field' ) ) :
	/**
	 * Get simple value from gdpr database by option_key
	 */
	function gdpr_update_field( $option_key = false, $option_value = false, $site_id = false ) {
		$results = false;
		if ( $option_key && $option_value ) :
			$site_id 							= $site_id && intval( $site_id ) ? $site_id : gdpr_get_site_id();
			$database_controller 	= new Moove_GDPR_DB_Controller();
			$results							= $database_controller->update( 
				array(
					'option_key'		=> $option_key,
					'option_value'	=> $option_value,
					'site_id'				=> $site_id
				)
			);
		endif;
		return $results;
	}

endif;

if ( ! function_exists( 'gdpr_delete_option' ) ) :
	/**
	 * Get simple value from gdpr database by option_key
	 */
	function gdpr_delete_option() {
		$database_controller 	= new Moove_GDPR_DB_Controller();
		$results							= $database_controller->delete_option();
		return $results;
	}

endif;



add_filter( 'plugin_action_links', 'moove_gdpr_plugin_settings_link', 10, 2 );
/**
 * Extension to display support, premium and settings links in the plugin listing page
 *
 * @param array  $links Links.
 * @param string $file File.
 */
function moove_gdpr_plugin_settings_link( $links, $file ) {
	if ( plugin_basename( dirname( __FILE__ ) . '/moove-gdpr.php' ) === $file ) {
		/*
		* Insert the Settings page link at the beginning
		*/
		$in = '<a href="'.esc_url( admin_url( 'admin.php' ) ).'?page=moove-gdpr">' . __( 'Settings', 'gdpr-cookie-compliance' ) . '</a>';
		array_unshift( $links, $in );

		/*
		* Insert the Support page link at the end
		*/
		$in = '<a href="https://support.mooveagency.com/forum/gdpr-cookie-compliance/" target="_blank">' . __( 'Support', 'gdpr-cookie-compliance' ) . '</a>';
		array_push( $links, $in );

		/*
		* Insert the Premium Upgrade link at the end
		*/
		$in = '<a href="https://www.mooveagency.com/wordpress-plugins/gdpr-cookie-compliance/" target="_blank">' . __( 'Premium Upgrade', 'gdpr-cookie-compliance' ) . '</a>';
		array_push( $links, $in );
	}
	return $links;
}

/**
 * Get an attachment ID given a URL.
 *
 * @param string $url URL.
 * @return int Attachment ID on success, 0 on failure
 */
function gdpr_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir           = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file       = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			),
		);
		$query      = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) :
				$query->the_post();
				$post_id = get_the_ID();
				$meta    = wp_get_attachment_metadata( $post_id );
				if ( $meta && isset( $meta['file'] ) && isset( $meta['sizes'] ) ) :
					$original_file       = basename( $meta['file'] );
					$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
					if ( $original_file === $file || in_array( $file, $cropped_image_files, false ) ) {
						$attachment_id = $post_id;
						break;
					}
				endif;
			endwhile;
			wp_reset_postdata();
		}
	}
	return $attachment_id;
}

/**
 * Get image alt text by image URL
 *
 * @param String $image_url Image URL.
 *
 * @return Bool | String
 */
function gdpr_get_logo_alt( $image_url ) {

	global $wpdb;

	if ( empty( $image_url ) ) {
		return get_bloginfo( 'name' );
	}
	$image_id = gdpr_get_attachment_id( $image_url );
	if ( $image_id ) :
		$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		return $image_alt;
	else :
		return get_bloginfo( 'name' );
	endif;

}

/**
 * GDPR Module manager, introduced in version 1.1.5
 *
 * @param string $module Module.
 */
function gdpr_get_module( $module = '' ) {
	if ( $module ) :
		$module_controller = new GDPR_Modules();
		$response          = false;
		switch ( $module ) :
			case 'floating-button':
				$response = apply_filters( 'gdpr_floating_button_module', $module_controller->get_floating_button() );
				break;
			case 'infobar-base':
				$response = apply_filters( 'gdpr_infobar_base_module', $module_controller->get_infobar_base() );
				break;
			case 'infobar-content':
				$response = apply_filters( 'gdpr_infobar_content_module', $module_controller->get_infobar_content() );
				break;
			case 'infobar-buttons':
				$response = apply_filters( 'gdpr_infobar_buttons_module', $module_controller->get_infobar_buttons() );
				break;
			case 'company-logo':
				$response = apply_filters( 'gdpr_company_logo_module', $module_controller->get_company_logo() );
				break;
			case 'gdpr-branding':
				$response = apply_filters( 'gdpr_branding_module', $module_controller->get_gdpr_branding() );
				break;
			case 'modal-base':
				$response = apply_filters( 'gdpr_modal_base_module', $module_controller->get_modal_base() );
				break;
			case 'tab-navigation':
				$response = apply_filters( 'gdpr_tab_navigation_module', $module_controller->get_tab_navigation() );
				break;
			case 'modal-footer-buttons':
				$response = apply_filters( 'gdpr_modal_footer_buttons_module', $module_controller->get_tab_footer_buttons() );
				break;
			case 'section-overview':
				$response = apply_filters( 'gdpr_section_overview_module', $module_controller->get_section_overview() );
				break;
			case 'section-strictly':
				$response = apply_filters( 'gdpr_section_strictly_module', $module_controller->get_section_strictly() );
				break;
			case 'section-advanced':
				$response = apply_filters( 'gdpr_section_advanced_module', $module_controller->get_section_advanced() );
				break;
			case 'section-third_party':
				$response = apply_filters( 'gdpr_section_third_party_module', $module_controller->get_section_third_party() );
				break;
			case 'section-cookiepolicy':
				$response = apply_filters( 'gdpr_section_cookiepolicy_module', $module_controller->get_section_cookiepolicy() );
				break;
			case 'branding-styles':
				$response = apply_filters( 'gdpr_branding_styles_module', $module_controller->get_branding_styles() );
				break;
			default:
		endswitch;
	endif;
	return $response;
}


if ( ! function_exists( 'gdpr_cookie_is_accepted' ) ) :
	/**
	 * Checking accepted cookie values by type
	 *
	 * @param string $type Type.
	 */
	function gdpr_cookie_is_accepted( $type = '' ) {
		$response       = false;
		$type           = sanitize_text_field( $type );
		$accepted_types = array( 'strict', 'thirdparty', 'advanced' );
		if ( $type && in_array( $type, $accepted_types ) ) :
			$gdpr_content = new Moove_GDPR_Content();
			$php_cookies  = $gdpr_content->gdpr_get_php_cookies();
			$response     = $php_cookies && isset( $php_cookies[ $type ] ) && $php_cookies[ $type ] ? true : false;
		endif;
		return $response;
	}
endif;

if ( ! function_exists( 'gdpr_get_display_language_by_locale' ) ) :
	/**
	 * Language locale
	 *
	 * @param string $locale Locale.
	 */
	function gdpr_get_display_language_by_locale( $locale ) {
		$locale_lang    = explode( '-', $locale );
		$_locale        = isset( $locale_lang[0] ) ? $locale_lang[0] : $locale;
		$language_codes = array(
			'aa' => 'Afar',
			'ab' => 'Abkhazian',
			'ae' => 'Avestan',
			'af' => 'Afrikaans',
			'ak' => 'Akan',
			'am' => 'Amharic',
			'an' => 'Aragonese',
			'ar' => 'Arabic',
			'as' => 'Assamese',
			'av' => 'Avaric',
			'ay' => 'Aymara',
			'az' => 'Azerbaijani',
			'ba' => 'Bashkir',
			'be' => 'Belarusian',
			'bg' => 'Bulgarian',
			'bh' => 'Bihari',
			'bi' => 'Bislama',
			'bm' => 'Bambara',
			'bn' => 'Bengali',
			'bo' => 'Tibetan',
			'br' => 'Breton',
			'bs' => 'Bosnian',
			'ca' => 'Catalan',
			'ce' => 'Chechen',
			'ch' => 'Chamorro',
			'co' => 'Corsican',
			'cr' => 'Cree',
			'cs' => 'Czech',
			'cu' => 'Church Slavic',
			'cv' => 'Chuvash',
			'cy' => 'Welsh',
			'da' => 'Danish',
			'de' => 'German',
			'dv' => 'Divehi',
			'dz' => 'Dzongkha',
			'ee' => 'Ewe',
			'el' => 'Greek',
			'en' => 'English',
			'eo' => 'Esperanto',
			'es' => 'Spanish',
			'et' => 'Estonian',
			'eu' => 'Basque',
			'fa' => 'Persian',
			'ff' => 'Fulah',
			'fi' => 'Finnish',
			'fj' => 'Fijian',
			'fo' => 'Faroese',
			'fr' => 'French',
			'fy' => 'Western Frisian',
			'ga' => 'Irish',
			'gd' => 'Scottish Gaelic',
			'gl' => 'Galician',
			'gn' => 'Guarani',
			'gu' => 'Gujarati',
			'gv' => 'Manx',
			'ha' => 'Hausa',
			'he' => 'Hebrew',
			'hi' => 'Hindi',
			'ho' => 'Hiri Motu',
			'hr' => 'Croatian',
			'ht' => 'Haitian',
			'hu' => 'Hungarian',
			'hy' => 'Armenian',
			'hz' => 'Herero',
			'ia' => 'Interlingua (International Auxiliary Language Association)',
			'id' => 'Indonesian',
			'ie' => 'Interlingue',
			'ig' => 'Igbo',
			'ii' => 'Sichuan Yi',
			'ik' => 'Inupiaq',
			'io' => 'Ido',
			'is' => 'Icelandic',
			'it' => 'Italian',
			'iu' => 'Inuktitut',
			'ja' => 'Japanese',
			'jv' => 'Javanese',
			'ka' => 'Georgian',
			'kg' => 'Kongo',
			'ki' => 'Kikuyu',
			'kj' => 'Kwanyama',
			'kk' => 'Kazakh',
			'kl' => 'Kalaallisut',
			'km' => 'Khmer',
			'kn' => 'Kannada',
			'ko' => 'Korean',
			'kr' => 'Kanuri',
			'ks' => 'Kashmiri',
			'ku' => 'Kurdish',
			'kv' => 'Komi',
			'kw' => 'Cornish',
			'ky' => 'Kirghiz',
			'la' => 'Latin',
			'lb' => 'Luxembourgish',
			'lg' => 'Ganda',
			'li' => 'Limburgish',
			'ln' => 'Lingala',
			'lo' => 'Lao',
			'lt' => 'Lithuanian',
			'lu' => 'Luba-Katanga',
			'lv' => 'Latvian',
			'mg' => 'Malagasy',
			'mh' => 'Marshallese',
			'mi' => 'Maori',
			'mk' => 'Macedonian',
			'ml' => 'Malayalam',
			'mn' => 'Mongolian',
			'mr' => 'Marathi',
			'ms' => 'Malay',
			'mt' => 'Maltese',
			'my' => 'Burmese',
			'na' => 'Nauru',
			'nb' => 'Norwegian Bokmal',
			'nd' => 'North Ndebele',
			'ne' => 'Nepali',
			'ng' => 'Ndonga',
			'nl' => 'Dutch',
			'nn' => 'Norwegian Nynorsk',
			'no' => 'Norwegian',
			'nr' => 'South Ndebele',
			'nv' => 'Navajo',
			'ny' => 'Chichewa',
			'oc' => 'Occitan',
			'oj' => 'Ojibwa',
			'om' => 'Oromo',
			'or' => 'Oriya',
			'os' => 'Ossetian',
			'pa' => 'Panjabi',
			'pi' => 'Pali',
			'pl' => 'Polish',
			'ps' => 'Pashto',
			'pt' => 'Portuguese',
			'qu' => 'Quechua',
			'rm' => 'Raeto-Romance',
			'rn' => 'Kirundi',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'rw' => 'Kinyarwanda',
			'sa' => 'Sanskrit',
			'sc' => 'Sardinian',
			'sd' => 'Sindhi',
			'se' => 'Northern Sami',
			'sg' => 'Sango',
			'si' => 'Sinhala',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'sm' => 'Samoan',
			'sn' => 'Shona',
			'so' => 'Somali',
			'sq' => 'Albanian',
			'sr' => 'Serbian',
			'ss' => 'Swati',
			'st' => 'Southern Sotho',
			'su' => 'Sundanese',
			'sv' => 'Swedish',
			'sw' => 'Swahili',
			'ta' => 'Tamil',
			'te' => 'Telugu',
			'tg' => 'Tajik',
			'th' => 'Thai',
			'ti' => 'Tigrinya',
			'tk' => 'Turkmen',
			'tl' => 'Tagalog',
			'tn' => 'Tswana',
			'to' => 'Tonga',
			'tr' => 'Turkish',
			'ts' => 'Tsonga',
			'tt' => 'Tatar',
			'tw' => 'Twi',
			'ty' => 'Tahitian',
			'ug' => 'Uighur',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			've' => 'Venda',
			'vi' => 'Vietnamese',
			'vo' => 'Volapuk',
			'wa' => 'Walloon',
			'wo' => 'Wolof',
			'xh' => 'Xhosa',
			'yi' => 'Yiddish',
			'yo' => 'Yoruba',
			'za' => 'Zhuang',
			'zh' => 'Chinese',
			'zu' => 'Zulu',
		);
		return isset( $language_codes[ $_locale ] ) ? $language_codes[ $_locale ] . ' [' . $locale . ']' : $locale;
	}
endif;
