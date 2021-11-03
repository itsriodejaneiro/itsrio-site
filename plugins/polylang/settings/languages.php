<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Don't access directly
};

/**
 * The list of predefined languages
 *
 * for each language:
 * [0] => ISO 639-1 language code
 * [1] => WordPress locale
 * [2] => name
 * [3] => text direction
 * [4] => flag code
 */
$languages = array(
	'af' => array( 'af', 'af', 'Afrikaans', 'ltr', 'za' ),
	'ar' => array( 'ar', 'ar', 'العربية', 'rtl', 'arab' ),
	'ary' => array( 'ar', 'ary', 'العربية المغربية', 'rtl', 'ma' ),
	'az' => array( 'az', 'az', 'Azərbaycan', 'ltr', 'az' ),
	'azb' => array( 'az', 'azb', 'گؤنئی آذربایجان', 'rtl', 'az' ),
	'bel' => array( 'be', 'bel', 'Беларуская мова', 'ltr', 'by' ),
	'bg_BG' => array( 'bg', 'bg_BG', 'български', 'ltr', 'bg' ),
	'bn_BD' => array( 'bn', 'bn_BD', 'বাংলা', 'ltr', 'bd' ),
	'bo' => array( 'bo', 'bo', 'བོད་ཡིག', 'ltr', 'tibet' ),
	'bs_BA' => array( 'bs', 'bs_BA', 'Bosanski', 'ltr', 'ba' ),
	'ca' => array( 'ca', 'ca', 'Català', 'ltr', 'catalonia' ),
	'ceb' => array( 'ceb', 'ceb', 'Cebuano', 'ltr', 'ph' ),
	'cs_CZ' => array( 'cs', 'cs_CZ', 'Čeština', 'ltr', 'cz' ),
	'cy' => array( 'cy', 'cy', 'Cymraeg', 'ltr', 'wales' ),
	'da_DK' => array( 'da', 'da_DK', 'Dansk', 'ltr', 'dk' ),
	'de_CH' => array( 'de', 'de_CH', 'Deutsch', 'ltr', 'ch' ),
	'de_CH_informal' => array( 'de', 'de_CH_informal', 'Deutsch', 'ltr', 'ch' ),
	'de_DE' => array( 'de', 'de_DE', 'Deutsch', 'ltr', 'de' ),
	'de_DE_formal' => array( 'de', 'de_DE_formal', 'Deutsch', 'ltr', 'de' ),
	'el' => array( 'el', 'el', 'Ελληνικά', 'ltr', 'gr' ),
	'en_AU' => array( 'en', 'en_AU', 'English', 'ltr', 'au' ),
	'en_CA' => array( 'en', 'en_CA', 'English', 'ltr', 'ca' ),
	'en_GB' => array( 'en', 'en_GB', 'English', 'ltr', 'gb' ),
	'en_NZ' => array( 'en', 'en_NZ', 'English', 'ltr', 'nz' ),
	'en_US' => array( 'en', 'en_US', 'English', 'ltr', 'us' ),
	'en_ZA' => array( 'en', 'en_ZA', 'English', 'ltr', 'za' ),
	'eo' => array( 'eo', 'eo', 'Esperanto', 'ltr', 'esperanto' ),
	'es_AR' => array( 'es', 'es_AR', 'Español', 'ltr', 'ar' ),
	'es_CL' => array( 'es', 'es_CL', 'Español', 'ltr', 'cl' ),
	'es_CO' => array( 'es', 'es_CO', 'Español', 'ltr', 'co' ),
	'es_ES' => array( 'es', 'es_ES', 'Español', 'ltr', 'es' ),
	'es_GT' => array( 'es', 'es_GT', 'Español', 'ltr', 'gt' ),
	'es_MX' => array( 'es', 'es_MX', 'Español', 'ltr', 'mx' ),
	'es_PE' => array( 'es', 'es_PE', 'Español', 'ltr', 'pe' ),
	'es_VE' => array( 'es', 'es_VE', 'Español', 'ltr', 've' ),
	'et' => array( 'et', 'et', 'Eesti', 'ltr', 'ee' ),
	'eu' => array( 'eu', 'eu', 'Euskara', 'ltr', 'basque' ),
	'fa_AF' => array( 'fa', 'fa_AF', 'فارسی', 'rtl', 'af' ),
	'fa_IR' => array( 'fa', 'fa_IR', 'فارسی', 'rtl', 'ir' ),
	'fi' => array( 'fi', 'fi', 'Suomi', 'ltr', 'fi' ),
	'fo' => array( 'fo', 'fo', 'Føroyskt', 'ltr', 'fo' ),
	'fr_BE' => array( 'fr', 'fr_BE', 'Français', 'ltr', 'be' ),
	'fr_CA' => array( 'fr', 'fr_CA', 'Français', 'ltr', 'quebec' ),
	'fr_FR' => array( 'fr', 'fr_FR', 'Français', 'ltr', 'fr' ),
	'fy' => array( 'fy', 'fy', 'Frysk', 'ltr', 'nl' ),
	'gd' => array( 'gd', 'gd', 'Gàidhlig', 'ltr', 'scotland' ),
	'gl_ES' => array( 'gl', 'gl_ES', 'Galego', 'ltr', 'galicia' ),
	'gu' => array( 'gu', 'gu', 'ગુજરાતી', 'ltr', 'in' ),
	'haz' => array( 'haz', 'haz', 'هزاره گی', 'rtl', 'af' ),
	'he_IL' => array( 'he', 'he_IL', 'עברית', 'rtl', 'il' ),
	'hi_IN' => array( 'hi', 'hi_IN', 'हिन्दी', 'ltr', 'in' ),
	'hr' => array( 'hr', 'hr', 'Hrvatski', 'ltr', 'hr' ),
	'hu_HU' => array( 'hu', 'hu_HU', 'Magyar', 'ltr', 'hu' ),
	'hy' => array( 'hy', 'hy', 'Հայերեն', 'ltr', 'am' ),
	'id_ID' => array( 'id', 'id_ID', 'Bahasa Indonesia', 'ltr', 'id' ),
	'is_IS' => array( 'is', 'is_IS', 'Íslenska', 'ltr', 'is' ),
	'it_IT' => array( 'it', 'it_IT', 'Italiano', 'ltr', 'it' ),
	'ja' => array( 'ja', 'ja', '日本語', 'ltr', 'jp' ),
	'jv_ID' => array( 'jv', 'jv_ID', 'Basa Jawa', 'ltr', 'id' ),
	'ka_GE' => array( 'ka', 'ka_GE', 'ქართული', 'ltr', 'ge' ),
	'kk' => array( 'kk', 'kk', 'Қазақ тілі', 'ltr', 'kz' ),
	'ko_KR' => array( 'ko', 'ko_KR', '한국어', 'ltr', 'kr' ),
	'ckb' => array( 'ku', 'ckb', 'کوردی', 'rtl', 'kurdistan' ),
	'lo' => array( 'lo', 'lo', 'ພາສາລາວ', 'ltr', 'la' ),
	'lt_LT' => array( 'lt', 'lt_LT', 'Lietuviškai', 'ltr', 'lt' ),
	'lv' => array( 'lv', 'lv', 'Latviešu valoda', 'ltr', 'lv' ),
	'mk_MK' => array( 'mk', 'mk_MK', 'македонски јазик', 'ltr', 'mk' ),
	'mn' => array( 'mn', 'mn', 'Монгол хэл', 'ltr', 'mn' ),
	'mr' => array( 'mr', 'mr', 'मराठी', 'ltr', 'in' ),
	'ms_MY' => array( 'ms', 'ms_MY', 'Bahasa Melayu', 'ltr', 'my' ),
	'my_MM' => array( 'my', 'my_MM', 'ဗမာစာ', 'ltr', 'mm' ),
	'nb_NO' => array( 'nb', 'nb_NO', 'Norsk Bokmål', 'ltr', 'no' ),
	'ne_NP' => array( 'ne', 'ne_NP', 'नेपाली', 'ltr', 'np' ),
	'nl_NL' => array( 'nl', 'nl_NL', 'Nederlands', 'ltr', 'nl' ),
	'nl_NL_formal' => array( 'nl', 'nl_NL_formal', 'Nederlands', 'ltr', 'nl' ),
	'nn_NO' => array( 'nn', 'nn_NO', 'Norsk Nynorsk', 'ltr', 'no' ),
	'oci' => array( 'oc', 'oci', 'Occitan', 'ltr', 'occitania' ),
	'pl_PL' => array( 'pl', 'pl_PL', 'Polski', 'ltr', 'pl' ),
	'ps' => array( 'ps', 'ps', 'پښتو', 'rtl', 'af' ),
	'pt_BR' => array( 'pt', 'pt_BR', 'Português', 'ltr', 'br' ),
	'pt_PT' => array( 'pt', 'pt_PT', 'Português', 'ltr', 'pt' ),
	'ro_RO' => array( 'ro', 'ro_RO', 'Română', 'ltr', 'ro' ),
	'ru_RU' => array( 'ru', 'ru_RU', 'Русский', 'ltr', 'ru' ),
	'si_LK' => array( 'si', 'si_LK', 'සිංහල', 'ltr', 'lk' ),
	'sk_SK' => array( 'sk', 'sk_SK', 'Slovenčina', 'ltr', 'sk' ),
	'sl_SI' => array( 'sl', 'sl_SI', 'Slovenščina', 'ltr', 'si' ),
	'so_SO' => array( 'so', 'so_SO', 'Af-Soomaali', 'ltr', 'so' ),
	'sq' => array( 'sq', 'sq', 'Shqip', 'ltr', 'al' ),
	'sr_RS' => array( 'sr', 'sr_RS', 'Српски језик', 'ltr', 'rs' ),
	'su_ID' => array( 'su', 'su_ID', 'Basa Sunda', 'ltr', 'id' ),
	'sv_SE' => array( 'sv', 'sv_SE', 'Svenska', 'ltr', 'se' ),
	'szl' => array( 'szl', 'szl', 'Ślōnskŏ gŏdka', 'ltr', 'pl' ),
	'ta_LK' => array( 'ta', 'ta_LK', 'தமிழ்', 'ltr', 'lk' ),
	'th' => array( 'th', 'th', 'ไทย', 'ltr', 'th' ),
	'tl' => array( 'tl', 'tl', 'Tagalog', 'ltr', 'ph' ),
	'tr_TR' => array( 'tr', 'tr_TR', 'Türkçe', 'ltr', 'tr' ),
	'ug_CN' => array( 'ug', 'ug_CN', 'Uyƣurqə', 'ltr', 'cn' ),
	'uk' => array( 'uk', 'uk', 'Українська', 'ltr', 'ua' ),
	'ur' => array( 'ur', 'ur', 'اردو', 'rtl', 'pk' ),
	'uz_UZ' => array( 'uz', 'uz_UZ', 'Oʻzbek', 'ltr', 'uz' ),
	'vec' => array( 'vec', 'vec', 'Vèneto', 'ltr', 'veneto' ),
	'vi' => array( 'vi', 'vi', 'Tiếng Việt', 'ltr', 'vn' ),
	'zh_CN' => array( 'zh', 'zh_CN', '中文 (中国)', 'ltr', 'cn' ),
	'zh_HK' => array( 'zh', 'zh_HK', '中文 (香港)', 'ltr', 'hk' ),
	'zh_TW' => array( 'zh', 'zh_TW', '中文 (台灣)', 'ltr', 'tw' ),
);

/**
 * Filter the list of predefined languages
 *
 * @since 1.7.10
 *
 * @param array $languages
 */
$languages = apply_filters( 'pll_predefined_languages', $languages );
