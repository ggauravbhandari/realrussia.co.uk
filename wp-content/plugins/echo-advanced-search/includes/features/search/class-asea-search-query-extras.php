<?php

/**
 * Provides additional functions for Search Query class
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_Search_Query_Extras {

	public static $debug_msg = [];

	/**
	 * Retrieve individual search keywords (keywords) or keep them together as sentence if too long
	 *
	 * @param $kb_id
	 * @param $sanitized_raw_user_input
	 * @param bool $filter_stop_words
	 * @return array
	 */
	public static function get_search_keywords( $kb_id, $sanitized_raw_user_input, $filter_stop_words=true ) {

		$current_language = self::get_current_language( $kb_id );
		//$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// split the individual keywords if possible
		$filtered_search_keywords = array( $sanitized_raw_user_input );

		// get individual keywords
		if ( preg_match_all( '/".*?("|$)|((?<=[\t ",+])|^)[^\t ",+]+/', $sanitized_raw_user_input, $keywords ) == false ) {
			self::$debug_msg[] = " Error parsing keywords.";
			return $filtered_search_keywords;
		}

		// 1. filter stop words
		$filtered_search_keywords = array();
		foreach ( $keywords[0] as $keyword ) {

			$keyword = urldecode($keyword);
			$keyword = preg_match( '/^".+"$/', $keyword ) ? trim( $keyword, "\"'" ) : trim( $keyword, "\"' " );
			$keyword = ASEA_Utilities::mb_strtolower( $keyword ); // does not work with å etc.: strtolower($keyword);

			// filter stop words
			if ( $filter_stop_words && $current_language == 'en' && in_array( $keyword, self::stop_words(), true ) ) {
				self::$debug_msg[] = ' Stop word removed: ' . $keyword;
				continue;
			}

			$filtered_search_keywords[] = $keyword;
		}


		// 3. synonyms
		// TODO $filtered_search_keywords = self::replace_with_synonyms($kb_id, $filtered_search_keywords);

		// consider search keywords a sentence if it is too long or contains stop words
		if ( empty($filtered_search_keywords) || count($filtered_search_keywords) > ASEA_Search_Query::MAX_KEY_WORDS ) {
			$filtered_search_keywords = array( $sanitized_raw_user_input );
		}

		return $filtered_search_keywords;
	}

	/**
	 * Determine current language used.
	 *
	 * @param $kb_id
	 * @param bool $get_language_name
	 * @return bool|mixed|string
	 */
	public static function get_current_language( $kb_id, $get_language_name=false ) {

		return 'en';  // TODO

		$current_language_localle = get_bloginfo( 'language' );  // en_US (language_localle)  substr( get_locale(), 0, 2 )

		// WPML
		if ( ASEA_Core_Utilities::is_wpml_enabled_addon( $kb_id ) ) {
			$current_language_localle = apply_filters( 'wpml_current_language', null );
		}
		// Polylang
		else if ( function_exists( 'pll_current_language' ) ) {
			$current_language_localle = pll_current_language( 'slug' );
		}

		$language = empty($current_language_localle) ? 'en' : substr( $current_language_localle, 0, 2 );

		// if we want lanauge name instead of code then we need to lookup the name
		if ( $get_language_name ) {

			require_once ABSPATH . 'wp-admin/includes/translation-install.php';

			$translations = wp_get_available_translations();
			$language = isset($translations[$language]) ? $translations[$language]['native_name'] : 'English (US)';
		}

		return $language;
	}

	public static function get_search_debug( $kb_id ) {
		$debug_msg_array = array_unique(self::$debug_msg);
		$debug_msg = '<br/>' . self::get_current_language( $kb_id, true ) . '<br/>';
		foreach( $debug_msg_array as $line ) {
			$debug_msg .= $line . '<br/>';
		}
		return $debug_msg;
	}

	/**
	 * Words that should not be matched in search as they are fillers rather than actual keywords
	 */
	public static function stop_words() {

		/* translators: This is a comma-separated list of very common words that should be excluded from a search,
		 * like a, an, and the. These are usually called "stopwords". You should not simply translate these individual
		 * words into your language. Instead, look for and provide commonly accepted stopwords in your language.
		 */
		// TODO	$words = explode( ',', _x( 'about,an,are,as,at,be,by,com,for,from,how,in,is,it,of,on,or,that,the,this,to,was,what,when,where,who,will,with,www',
		//'Comma-separated list of search stopwords in your language' ) );
		// TODO translate?

		return array( "a", "an", "about", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although",
			"always","among", "amongst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around",
			"back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides",
			"between", "beyond", "both", "bottom","but", "by", "can", "cannot", "cant", "could", "couldnt", "cry", "describe", "detail",
			"done", "down", "due", "during", "each", "either", "else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every",
			"everyone", "everything", "everywhere", "except", "few", "fill", "find", "for", "former", "formerly",
			"found", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "hence", "her", "here", "hereafter", "hereby",
			"herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred",  "inc", "indeed", "interest", "into",
			"its", "itself", "keep", "last", "latter", "latterly", "least", "less", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more",
			"moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nobody",
			"none", "noone", "nor", "not", "nothing", "now", "nowhere", "off", "often","once", "one", "only", "onto", "other", "others", "otherwise",
			"our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems",
			"serious", "several", "she", "should", "show", "side", "since", "sincere",  "some", "somehow", "someone", "something", "sometime",
			"sometimes", "somewhere", "still", "such", "system", "take", "than", "that", "the", "their", "them", "themselves", "then", "there", "thereafter",
			"thereby", "therefore", "therein", "thereupon", "these", "they",  "thin", "this", "those", "though", "through", "throughout", "thru",
			"thus", "to", "together", "too", "top", "toward", "towards", "under", "until","upon",  "very", "via", "was", "we",
			"well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether",
			"which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours",
			"yourself", "yourselves", "the" );
	}

	public static function html_css_keywords() {
		return array( "align", "background", "block", "border", "bottom", "button", "center", "class", "code", "color", "column", "content", "data", "display", "end", "family", "font",
			"form", "height", "image", "label", "layout", "left", "link", "list", "main", "media", "option", "order", "page", "placeholder", "read", "row", "section", "script", "size",
			"start", "style", "title", "width", "left", "tab", "table", "target", "top", "url", "body", "footer", "format", "grid", "header", "margin", "mask", "meta", "object", "padding",
			"picture", "progress", "position", "place", "select", "template", "value", "weight", "elementor" );
	}
}
