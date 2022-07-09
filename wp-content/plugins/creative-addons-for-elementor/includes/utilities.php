<?php
namespace Creative_Addons\Includes;

use Creative_Addons\Includes\System\Logging;
use Elementor\Plugin;
use WP_Error;
use WP_User;

defined( 'ABSPATH' ) || exit();

/**
 * Various utility functions
 */
class Utilities {

	static $wp_options_cache = array();

	public static function is_published( $post_id ) {
		$post_status = get_post_status( $post_id );
		return ! empty($post_status) && $post_status === 'publish';
	}
	
	public static function is_private( $post_id ) {
		$post_status = get_post_status( $post_id );
		return ! empty($post_status) && $post_status === 'private';
	}

	public static function is_post_being_edited() {
		return (
			Plugin::instance()->editor->is_edit_mode() ||
			Plugin::instance()->preview->is_preview_mode() ||
			is_preview()
		);
	}
	
	public static function is_post_edit_screen() {
		return (
			Plugin::instance()->editor->is_edit_mode() ||
			Plugin::instance()->preview->is_preview_mode() 
		);
	}


	/**************************************************************************************************************************
	 *                     POST OPERATIONS
	 *************************************************************************************************************************

	/**
	 * Retrieve an article with security checks
	 *
	 * @param $post_id
	 * @return null|WP_Post - return null if this is NOT CPT post
	 */
	public static function get_post( $post_id ) {

		if ( empty($post_id) ) {
			return null;
		}

		// ensure post_id is valid
		$post_id = self::sanitize_int( $post_id );
		if ( empty($post_id) ) {
			return null;
		}

		// retrieve the post and ensure it is one
		$post = get_post( $post_id );
		if ( empty($post) || ! is_object($post) || ! $post instanceof WP_Post ) {
			return null;
		}

		return $post;
	}

	/**
	 * Get post status text.
	 * @param $post_status
	 * @return mixed
	 */
	public static function get_post_status_text( $post_status ) {

		$post_statuses = array( 'draft' => __( 'Draft' ), 'pending' => __( 'Pending' ),
		                        'publish' => __( 'Published' ), 'future' => __( 'Scheduled' ),
								'private' => __( 'Private' ),
								'trash'   => __( 'Trash' ));

		if ( empty($post_status) || ! in_array($post_status, array_keys($post_statuses)) ) {
			return $post_status;
		}

		return $post_statuses[$post_status];
	}


	/**************************************************************************************************************************
	 *
	 *                     STRING OPERATIONS
	 *
	 **************************************************************************************************************************/

	/**
	 * PHP substr() function returns FALSE if the input string is empty. This method
	 * returns empty string if input is empty or if error occurs.
	 *
	 * @param $string
	 * @param $start
	 * @param null $length
	 *
	 * @return string
	 */
	public static function substr( $string, $start, $length=null ) {
		$result = substr($string, $start, $length);
		return empty($result) ? '' : $result;
	}

	/**************************************************************************************************************************
	 *
	 *                     NUMBER OPERATIONS
	 *
	 **************************************************************************************************************************/

	/**
	 * Determine if value is positive integer ( > 0 )
	 * @param int $number is check
	 * @return bool
	 */
	public static function is_positive_int( $number ) {

		// no invalid format
		if ( empty($number) || ! is_numeric($number) ) {
			return false;
		}

		// no non-digit characters
		$numbers_only = preg_replace('/\D/', "", $number );
		if ( empty($numbers_only) || $numbers_only != $number ) {
			return false;
		}

		// only positive
		return $numbers_only > 0;
	}

	/**
	 * Determine if value is positive integer
	 * @param int $number is check
	 * @return bool
	 */
	public static function is_positive_or_zero_int( $number ) {

		if ( ! isset($number) || ! is_numeric($number) ) {
			return false;
		}

		if ( ( (int) $number) != ( (float) $number )) {
			return false;
		}

		$number = (int) $number;

		return is_int($number);
	}


	/**************************************************************************************************************************
	 *
	 *                     DATE OPERATIONS
	 *
	 **************************************************************************************************************************/

	/**
	 * Retrieve specific format from given date-time string e.g. '10-16-2003 10:20:01' becomes '10-16-2003'
	 *
	 * @param $datetime_str
	 * @param string $format e.g. 'Y-m-d H:i:s'  or  'M j, Y'
	 *
	 * @return string formatted date or the original string
	 */
	public static function get_formatted_datetime_string( $datetime_str, $format='M j, Y' ) {

		if ( empty($datetime_str) || empty($format) ) {
			return $datetime_str;
		}

		$time = strtotime($datetime_str);
		if ( empty($time) ) {
			return $datetime_str;
		}

		$date_time = date_i18n($format, $time);
		if ( $date_time == $format ) {
			$date_time = $datetime_str;
		}

		return empty($date_time) ? $datetime_str : $date_time;
	}

	/**
	 * Get nof hours passed between two dates.
	 *
	 * @param string $date1
	 * @param string $date2 OR if empty then use current date
	 *
	 * @return int - number of hours between dates [0-x] or null if error
	 * @noinspection PhpParamsInspection
	 * @throws \Exception
	 */
	public static function get_hours_since( $date1, $date2='' ) {

		try {
			$date1_dt = new \DateTime( $date1 );
			$date2_dt = new \DateTime( $date2 );
		} catch(Exception $ex) {
			return null;
		}

		if ( empty($date1_dt) || empty($date2_dt) ) {
			return null;
		}

		$hours = date_diff($date1_dt, $date2_dt)->h;

		return $hours === false ? null : $hours;
	}

	/**
	 * Get nof days passed between two dates.
	 *
	 * @param string $date1
	 * @param string $date2 OR if empty then use current date
	 *
	 * @return int - number of days between dates [0-x] or null if error
	 * @noinspection PhpParamsInspection
	 * @throws \Exception
	 */
	public static function get_days_since( $date1, $date2='' ) {

		try {
			$date1_dt = new \DateTime( $date1 );
			$date2_dt = new \DateTime( $date2 );
		} catch(Exception $ex) {
			return null;
		}

		if ( empty($date1_dt) || empty($date2_dt) ) {
			return null;
		}

		$days = (int)date_diff($date1_dt, $date2_dt)->format("%r%a");

		return $days === false ? null : $days;
	}

	/**
	 * How long ago pass date occurred.
	 *
	 * @param string $date1
	 *
	 * @return string x year|month|week|day|hour|minute|second(s) or '[unknown]' on error
	 */
	public static function time_since_today( $date1 ) {
		return self::how_long_ago( $date1 );
	}

	/**
	 * How long ago since now.
	 *
	 * @param string $date1
	 * @param string $date2 or if empty use current time
	 *
	 * @return string x year|month|week|day|hour|minute|second(s) or '[unknown]' on error
	 */
	public static function how_long_ago( $date1, $date2='' ) {

		$time1 = strtotime($date1);
		$time2 = empty($date2) ? time() : strtotime($date2);
		if ( empty($time1) || empty($time2) ) {
			return '[???]';
		}

		$time = abs($time2 - $time1);
		$time = ( $time < 1 )? 1 : $time;
		$tokens = array (
			31536000 => __( 'year' ),
			2592000 => __( 'month' ),
			604800 => __( 'week' ),
			86400 => __( 'day' ),
			3600 => __( 'hour' ),
			60 => __( 'min' ),
			1 => __( 'sec' )
		);

		$output = '';
		foreach ($tokens as $unit => $text) {
			if ($time >= $unit) {
				$numberOfUnits = floor($time / $unit);
				$output =  $numberOfUnits . ' ' . $text . ( $numberOfUnits >1 ? 's' : '');
				break;
			}
		}

		return $output;
	}


	/**************************************************************************************************************************
	 *
	 *                     AJAX NOTICES
	 *
	 *************************************************************************************************************************/

	/**
	 * Display content (not message). will call wp_die()
	 *
	 * @param $message
	 */
	public static function ajax_show_content( $message ) {
		if ( defined('DOING_AJAX') ) {
			wp_die( json_encode( array( 'message' => $message ) ) );
		}
	}

	/**
	 * AJAX: Used on response back to JS. will call wp_die()
	 *
	 * @param string $message
	 * @param string $title
	 * @param string $type
	 */
	public static function ajax_show_info_die( $message, $title='', $type='success' ) {
		if ( defined('DOING_AJAX') ) {
			wp_die( json_encode( array( 'message' => self::get_bottom_notice_message_box( $message, $title, $type ) ) ) );
		}
	}

	/**
	 * AJAX: Used on response back to JS. will call wp_die()
	 *
	 * @param $message
	 * @param string $title
	 */
	public static function ajax_show_error_die( $message, $title='' ) {
		if ( defined('DOING_AJAX') ) {
			wp_die( json_encode( array( 'error' => true, 'message' => self::get_bottom_notice_message_box( $message, $title, 'error') ) ) );
		}
	}

	/**
	 * Show info or error message to the user
	 *
	 * @param $message
	 * @param string $title
	 * @param string $type
	 *
	 * @return string
	 */
	public static function get_bottom_notice_message_box($message, $title='', $type='success' ) {

		$message = empty( $message ) ? '' : $message;

		return
			"<div class='eckb-bottom-notice-message'>
				<div class='contents'>
					<span class='" . esc_attr( $type ) . "'>" .
						( empty( $title ) ? '' : '<h4>' . esc_html( $title ) . '</h4>' ) . "
						<p> " . wp_kses_post( $message ) . "</p>
					</span>
				</div>
				<div class='crel-close-notice fa fa-window-close'></div>
			</div>";
	}

	public static function user_not_logged_in() {
		self::ajax_show_error_die( '<p>' . __( 'You are not logged in. Refresh your page and log in.', 'creative-addons-for-elementor' ) . '</p>', __( 'Cannot save your changes', 'creative-addons-for-elementor' ) );
	}


	/**************************************************************************************************************************
	 *
	 *                     SECURITY
	 *
	 *************************************************************************************************************************/

	/**
	 * Return digits only.
	 *
	 * @param $number
	 * @param int $default
	 * @return int <default>
	 */
	public static function sanitize_int( $number, $default=0 ) {

		if ( $number === null || ! is_numeric($number) ) {
			return $default;
		}

		// intval returns 0 on error so handle 0 here first
		if ( $number == 0 ) {
			return 0;
		}

		$number = intval($number);

		return empty($number) ? $default : (int) $number;
	}

	/**
	 * Return text, space, "-" and "_" only.
	 *
	 * @param $text
	 * @param String $default
	 * @return String|$default
	 */
	public static function sanitize_english_text( $text, $default='' ) {

		if ( empty($text) || ! is_string($text) ) {
			return $default;
		}

		$text = preg_replace('/[^A-Za-z0-9 \-_]/', '', $text);

		return empty($text) ? $default : $text;
	}

	/**
	 * Retrieve ID or return error. Used for IDs.
	 *
	 * @param mixed $id is either $id number or array with 'id' index
	 *
	 * @return int|WP_Error
	 */
	public static function sanitize_get_id( $id ) {

		if ( empty( $id) || is_wp_error($id) ) {
			Logging::add_log( 'Error occurred (01)' );
			return new WP_Error('E001', 'invalid ID' );
		}

		if ( is_array( $id) ) {
			if ( ! isset( $id['id']) ) {
				Logging::add_log( 'Error occurred (02)' );
				return new WP_Error('E002', 'invalid ID' );
			}

			$id_value = $id['id'];
			if ( ! self::is_positive_int( $id_value ) ) {
				Logging::add_log( 'Error occurred (03)', $id_value );
				return new WP_Error('E003', 'invalid ID' );
			}

			return (int) $id_value;
		}

		if ( ! self::is_positive_int( $id ) ) {
			Logging::add_log( 'Error occurred (04)', $id );
			return new WP_Error('E004', 'invalid ID' );
		}

		return (int) $id;
	}

    /**
     * Sanitize array full of ints.
     *
     * @param $array_values
     * @param string $default
     * @return array|string
     */
	public static function sanitize_int_array( $array_values, $default='' ) {
	    if ( ! is_array($array_values) ) {
	        return $default;
        }

        $sanitized_array = array();
        foreach( $array_values as $value ) {
	        $sanitized_array[] = self::sanitize_int( $value );
        }

        return $sanitized_array;
    }

	/**
	 * Decode and sanitize form fields.
	 *
	 * @param $form
	 * @param $all_fields_specs
	 * @return array
	 */
	public static function retrieve_and_sanitize_form( $form, $all_fields_specs ) {
		if ( empty($form) ) {
			return array();
		}

		// first urldecode()
		if (is_string($form)) {
			parse_str($form, $submitted_fields);
		} else {
			$submitted_fields = $form;
		}

		// now sanitize each field
		$sanitized_fields = array();
		foreach( $submitted_fields as $submitted_key => $submitted_value ) {

			$field_type = empty($all_fields_specs[$submitted_key]['type']) ? '' : $all_fields_specs[$submitted_key]['type'];

			if ( $field_type == Input_Filter::WP_EDITOR ) {
				$sanitized_fields[$submitted_key] = wp_kses_post( $submitted_value );

			} elseif ( $field_type == Input_Filter::TEXT && ! empty($all_fields_specs[$submitted_key]['allowed_tags']) ) {
				// text input with allowed tags 
				$sanitized_fields[$submitted_key] = wp_kses( $submitted_value, $all_fields_specs[$submitted_key]['allowed_tags'] );

			} else {
				$sanitized_fields[$submitted_key] = sanitize_text_field( $submitted_value );
			}

		}

		return $sanitized_fields;
	}

	/**
	 * Return ints and comma only.
	 *
	 * @param $text
	 * @param String $default
	 * @return String|$default
	 */
	public static function sanitize_comma_separated_ints( $text, $default='' ) {

		if ( empty($text) || ! is_string($text) ) {
			return $default;
		}

		$text = preg_replace('/[^0-9 \,_]/', '', $text);

		return empty($text) ? $default : $text;
	}

	/**
	 * Get a list of all the allowed html tags.
	 * @return array
	 */
	public static function get_allowed_html_tags() {
		return [
			'abbr' => [
				'title' => []
			],
			'b' => [],
			'br' => [],
			'em' => [],
			'i' => [],
			'span' => [
				'class' => []
			],
			'strong' => [],
			'u' => []
		];
	}

	/**
	 * Strip tags that are not allowed.
	 * @param string $string
	 * @return string
	 */
	public static function use_kses_filter( $string='' ) {
		return wp_kses( $string, self::get_allowed_html_tags() );
	}

	/**
	 * Retrieve value from POST or GET
	 *
	 * @param $key
	 * @param string $default
	 * @param string $value_type How to treat and sanitize value. Values: text, url
	 * @param int $max_length
	 * @return array|string - empty if not found
	 */
	public static function post( $key, $default = '', $value_type = 'text', $max_length = 0 ) {

		if ( isset( $_POST[$key] ) ) {
			return self::post_sanitize( $key, $default, $value_type, $max_length );
		}

		if ( isset( $_GET[$key] ) ) {
			return self::get_sanitize( $key, $default, $value_type, $max_length );
		}

		return $default;
	}

	/**
	 * Retrieve value from POST or GET
	 *
	 * @param $key
	 * @param string $default
	 * @param string $value_type How to treat and sanitize value. Values: text, url
	 * @param int $max_length
	 * @return array|string - empty if not found
	 */
	private static function post_sanitize( $key, $default = '', $value_type = 'text', $max_length = 0 ) {

		if ( $_POST[$key] === null || is_object( $_POST[$key] )  ) {
			return $default;
		}

		// config is sanitizing with its own specs separately
		if ( $value_type == 'db-config' ) {
			return $_POST[$key];
		}

		if ( is_array( $_POST[$key] ) ) {
			return self::sanitize_array( $_POST[$key] );
		}

		// jquery serialized form. sanitize values in array
		if ( $value_type == 'form' ) {
			$result = is_array( $default ) ? $default : [];
			wp_parse_str( stripslashes( $_POST[$key] ), $decoded_form );
			foreach ( $decoded_form as $field => $val ) {
				$result[$field] = wp_kses_post( $val );
			}
			return $result;
		}

		if ( $value_type == 'text-area' ) {
			$value = sanitize_textarea_field( stripslashes( $_POST[$key] ) );  // do not strip line breaks
		} else if ( $value_type == 'email' ) {
			$value = sanitize_email( $_POST[$key] );  // strips out all characters that are not allowable in an email
		} else if ( $value_type == 'url' ) {
			$value = sanitize_text_field( urldecode( $_POST[$key] ) );
		} else if ( $value_type == 'wp_editor' ) {
			$value = wp_kses_post( $_POST[$key] );
		} else {
			$value = sanitize_text_field( stripslashes( $_POST[$key] ) );
		}

		// optionally limit value by length
		if ( ! empty( $max_length ) ) {
			$value = substr( $value, 0, $max_length );
		}

		return $value;
	}

	public static function request_key( $key, $default = '' ) {

		if ( is_string( $_REQUEST[$key] ) ) {
			return sanitize_key( $_REQUEST[$key] );
		}

		return $default;
	}

	/**
	 * Retrieve value from POST or GET
	 *
	 * @param $key
	 * @param string $default
	 * @param string $value_type How to treat and sanitize value. Values: text, url
	 * @param int $max_length
	 * @return array|string - empty if not found
	 */
	public static function get( $key, $default = '', $value_type = 'text', $max_length = 0 ) {

		if ( isset( $_GET[$key] ) ) {
			return self::get_sanitize( $key, $default, $value_type, $max_length );
		}

		if ( isset( $_POST[$key] ) ) {
			return self::post_sanitize( $key, $default, $value_type, $max_length );
		}

		return $default;
	}

	/**
	 * Retrieve value from POST or GET
	 *
	 * @param $key
	 * @param string $default
	 * @param string $value_type How to treat and sanitize value. Values: text, url
	 * @param int $max_length
	 * @return array|string - empty if not found
	 */
	private static function get_sanitize( $key, $default = '', $value_type = 'text', $max_length = 0 ) {

		if ( $_GET[$key] === null || is_object( $_GET[$key] )  ) {
			return $default;
		}

		// config is sanitizing with its own specs separately
		if ( $value_type == 'db-config' ) {
			return $_POST[$key];
		}

		if ( is_array( $_GET[$key] ) ) {
			return self::sanitize_array( $_GET[$key] );
		}

		// jquery serialized form. sanitize values in array
		if ( $value_type == 'form' ) {
			$result = is_array( $default ) ? $default : [];
			wp_parse_str( stripslashes( $_GET[$key] ), $decoded_form );
			foreach ( $decoded_form as $field => $val ) {
				$result[$field] = wp_kses_post( $val );
			}
			return $result;
		}

		if ( $value_type == 'text-area' ) {
			$value = sanitize_textarea_field( stripslashes( $_GET[$key] ) );  // do not strip line breaks
		} else if ( $value_type == 'email' ) {
			$value = sanitize_email( $_GET[$key] );  // strips out all characters that are not allowable in an email
		} else if ( $value_type == 'url' ) {
			$value = sanitize_text_field( urldecode( $_GET[$key] ) );
		} else if ( $value_type == 'wp_editor' ) {
			$value = wp_kses_post( $_GET[$key] );
		} else {
			$value = sanitize_text_field( stripslashes( $_GET[$key] ) );
		}

		// optionally limit value by length
		if ( ! empty( $max_length ) ) {
			$value = substr( $value, 0, $max_length );
		}

		return $value;
	}

	public static function sanitize_array( $value ) {
		$result = [];
		foreach ( $value as $key => $val ) {

			// can be 2-dimension array
			if ( is_array( $val ) ) {

				if ( empty( $result[ $key ] ) ) {
					$result[ $key ] = [];
				}

				foreach ( $val as $key_2 => $val_2 ) {
					$result[ $key ][ $key_2 ] = sanitize_text_field( stripslashes( $val_2 ) );
				}

			} else {
				$result[ $key ] = sanitize_text_field( stripslashes( $val ) );
			}
		}

		return $result;
	}



	/**************************************************************************************************************************
	 *
	 *                     GET/SAVE/UPDATE AN OPTION
	 *
	 *************************************************************************************************************************/

	/**
	 * Get KB-SPECIFIC option. Function adds KB ID suffix. Prefix represent core or ADD-ON prefix.
	 *
	 * @param $kb_id - assuming it is a valid ID
	 * @param $option_name - without kb suffix
	 * @param $default - use if KB option not found
	 * @param bool $is_array - ensure returned value is an array, otherwise return default
	 * @return string|array|null or default
	 */
	public static function get_kb_option( $kb_id, $option_name, $default, $is_array=false ) {
		$full_option_name = $option_name . '_' . $kb_id;
		return self::get_wp_option( $full_option_name, $default, $is_array );
	}

	/**
	 * Use to get:
	 *  a) PLUGIN-WIDE option not specific to any KB with e p k b prefix.
	 *  b) ADD-ON-SPECIFIC option with ADD-ON prefix.
	 *  b) KB-SPECIFIC configuration with e p k b prefix and KB ID suffix.
	 *
	 * @param $option_name
	 * @param $default
	 * @param bool|false $is_array
	 * @param bool $return_error
	 *
	 * @return array|string|WP_Error or default or error if $return_error is true
	 */
	public static function get_wp_option( $option_name, $default, $is_array=false, $return_error=false ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		if ( isset(self::$wp_options_cache[$option_name]) ) {
			return self::$wp_options_cache[$option_name];
		}

		// retrieve specific WP option
		$option = $wpdb->get_var( $wpdb->prepare("SELECT option_value FROM $wpdb->options WHERE option_name = %s", $option_name ) );
		if ( $option !== null ) {
			$option = maybe_unserialize( $option );
		}

		if ( $return_error && $option === null && ! empty($wpdb->last_error) ) {
			$wpdb_last_error = $wpdb->last_error;   // add_log changes last_error so store it first
			Logging::add_log( "DB failure: " . $wpdb_last_error, 'Option Name: ' . $option_name );
			return new WP_Error(__( 'Error occurred', 'creative-addons-for-elementor' ), $wpdb_last_error);
		}

		// if WP option is missing then return defaults
		if ( $option === null || ( $is_array && ! is_array($option) ) ) {
			return $default;
		}

		self::$wp_options_cache[$option_name] = $option;

		return $option;
	}

	/**
	 * Save KB-SPECIFIC option. Function adds KB ID suffix. Prefix represent core or ADD-ON prefix.
	 *
	 * @param $kb_id - assuming it is a valid ID
	 * @param $option_name - without kb suffix
	 * @param array $option_value
	 * @param $sanitized - ensures input is sanitized
	 *
	 * @return array|WP_Error if option cannot be serialized or db insert failed
	 */
	public static function save_kb_option( $kb_id, $option_name, $option_value, $sanitized ) {
		$full_option_name = $option_name . '_' . $kb_id;
		return self::save_wp_option( $full_option_name, $option_value, $sanitized );
	}

	/**
	 * Save WP option
	 * @param $option_name
	 * @param $option_value
	 * @param $sanitized
	 * @return mixed|WP_Error
	 */
	public static function save_wp_option( $option_name, $option_value, $sanitized ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		if ( $sanitized !== true ) {
			return new WP_Error( '433', __( 'Error occurred', 'creative-addons-for-elementor' ) . ' ' . $option_name );
		}

		// do not store null
		if ( $option_value === null ) {
            $option_value = '';
        }

		// add or update the option
		$serialized_value = $option_value;
		if ( is_array( $option_value ) || is_object( $option_value ) ) {
			$serialized_value = maybe_serialize($option_value);
			if ( empty($serialized_value) ) {
				return new WP_Error( '434', __( 'Error occurred', 'creative-addons-for-elementor' ) . ' ' . $option_name );
			}
		}

		$result = $wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->options (`option_name`, `option_value`, `autoload`) VALUES (%s, %s, %s)
 												 ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`), `autoload` = VALUES(`autoload`)",
												$option_name, $serialized_value, 'no' ) );
		if ( $result === false ) {
			Logging::add_log( 'Failed to update option', $option_name );
			return new WP_Error( '435', 'Failed to update option ' . $option_name );
		}

		self::$wp_options_cache[$option_name] = $option_value;

		return $option_value;
	}


    /**************************************************************************************************************************
     *
     *                     DATABASE
     *
     *************************************************************************************************************************/

	/**
	 * Get given Post Metadata
	 *
	 * @param $post_id
	 * @param $meta_key
	 * @param $default
	 * @param bool|false $is_array
	 * @param bool $return_error
	 *
	 * @return array|string or default or error if $return_error is true
	 */
	public static function get_postmeta( $post_id, $meta_key, $default, $is_array=false, $return_error=false ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		if ( ! self::is_positive_int( $post_id) ) {
			return $return_error ? new WP_Error( __( 'Error occurred', 'creative-addons-for-elementor' ), self::get_variable_string( $post_id ) ) : $default;
		}

		// retrieve specific option
		$option = $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = %d and meta_key = '%s'", $post_id, $meta_key ) );
		if ($option !== null ) {
			$option = maybe_unserialize( $option );
		}

		if ( $return_error && $option === null && ! empty($wpdb->last_error) ) {
			$wpdb_last_error = $wpdb->last_error;   // add_log changes last_error so store it first
			Logging::add_log( "DB failure: " . $wpdb_last_error, 'Meta Key: ' . $meta_key );
			return new WP_Error(__( 'Error occurred', 'creative-addons-for-elementor' ), $wpdb_last_error);
		}

		// if the option is missing then return defaults
		if ( $option === null || ( $is_array && ! is_array($option) ) ) {
			return $default;
		}

		return $option;
	}

	/**
	 * Save or Insert Post Metadata
	 *
	 * @param $post_id
	 * @param $meta_key
	 * @param $meta_value
	 * @param $sanitized
	 *
	 * @return mixed|WP_Error
	 */
	public static function save_postmeta( $post_id, $meta_key, $meta_value, $sanitized ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		if ( ! self::is_positive_int( $post_id) ) {
			return new WP_Error( __( 'Error occurred', 'creative-addons-for-elementor' ), self::get_variable_string( $post_id ) );
		}

		if ( $sanitized !== true ) {
			return new WP_Error( '433', __( 'Error occurred', 'creative-addons-for-elementor' ) . ' ' . $meta_key );
		}

		// do not store null
		if ( $meta_value === null ) {
			$meta_value = '';
		}

		// add or update the option
		$serialized_value = $meta_value;
		if ( is_array( $meta_value ) || is_object( $meta_value ) ) {
			$serialized_value = maybe_serialize($meta_value);
			if ( empty($serialized_value) ) {
				return new WP_Error( '434', __( 'Error occurred', 'creative-addons-for-elementor' ) . ' ' . $meta_key );
			}
		}

		// check if the meta field already exists before doing 'upsert'
		$result = $wpdb->get_row( $wpdb->prepare( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '%s' AND post_id = %d", $meta_key, $post_id ) );
		if ( $result === null && ! empty($wpdb->last_error) ) {
			$wpdb_last_error = $wpdb->last_error;   // add_log changes last_error so store it first
			Logging::add_log( "DB failure: " . $wpdb_last_error );
			return new WP_Error('DB failure', $wpdb_last_error);
		}

		// INSERT or UPDATE the meta field
		if ( empty($result) ) {
			if ( false === $wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->postmeta (`meta_key`, `meta_value`, `post_id`) VALUES (%s, %s, %d)", $meta_key, $serialized_value, $post_id ) ) ) {
				Logging::add_log("Failed to insert meta data. ", $meta_key);
				return new WP_Error( '33', __( 'Error occurred', 'creative-addons-for-elementor' ) );
			}
		} else {
			if ( false === $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->postmeta SET meta_value = %s WHERE meta_key = '%s' AND post_id = %d", $serialized_value, $meta_key, $post_id ) ) ) {
				Logging::add_log("Failed to update meta data. ", $meta_key);
				return new WP_Error( '33', __( 'Error occurred', 'creative-addons-for-elementor' ) );
			}
		}

		if ( $result === false ) {
			Logging::add_log( 'Failed to update meta key', $meta_key );
			return new WP_Error( '435', __( 'Error occurred', 'creative-addons-for-elementor' ) . ' ' . $meta_key );
		}

		return $meta_value;
	}

	/**
	 * Delete given Post Metadata
	 *
	 * @param $post_id
	 * @param $meta_key
	 *
	 * @return bool
	 */
	public static function delete_postmeta( $post_id, $meta_key ) {
		/** @var $wpdb Wpdb */
		global $wpdb;

		if ( ! self::is_positive_int( $post_id) ) {
			return false;
		}

		// delete specific option
		if ( false === $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE post_id = %d and meta_key = '%s'", $post_id, $meta_key ) ) ) {
			Logging::add_log("Could not delete post '" . self::get_variable_string($meta_key) . "'' metadata: ", $post_id);
			return false;
		}

		return true;
	}


	/**************************************************************************************************************************
	 *
	 *                     OTHER
	 *
	 *************************************************************************************************************************/

	/**
	 * Return string representation of given variable for logging purposes
	 *
	 * @param $var
	 *
	 * @return string
	 */
	public static function get_variable_string( $var ) {

		if ( ! is_array($var) ) {
			return self::get_variable_not_array( $var );
		}

		if ( empty($var) ) {
			return '[empty]';
		}

		$output = 'array';
		$ix = 0;
		foreach ($var as $key => $value) {

            if ( $ix++ > 10 ) {
                $output .= '[.....]';
                break;
            }

			$output .= "[" . $key . " => ";
			if ( ! is_array($value) ) {
				$output .= self::get_variable_not_array( $value ) . "]";
				continue;
			}

			$ix2 = 0;
			$output .= "[";
			$first = true;
			foreach($value as $key2 => $value2) {
                if ( $ix2++ > 10 ) {
                    $output .= '[.....]';
                    break;
                }

				if ( is_array($value2) ) {
                    $output .= print_r($value2, true);
                } else {
					$output .= ( $first ? '' : ', ' ) . $key2 . " => " . self::get_variable_not_array( $value2 );
					$first = false;
					continue;
				}
            }
			$output .= "]]";
		}

		return $output;
	}

	private static function get_variable_not_array( $var ) {

		if ( $var === null ) {
			return '<null>';
		}

		if ( ! isset($var) ) {
            /** @noinspection HtmlUnknownAttribute */
            return '<not set>';
		}

		if ( is_array($var) ) {
			return empty($var) ? '[]' : '[...]';
		}

		if ( is_object( $var ) ) {
			return '<' . get_class($var) . '>';
		}

		if ( is_bool( $var ) ) {
			return $var ? 'TRUE' : 'FALSE';
		}

		if ( is_string($var) || is_numeric($var) ) {
			return $var;
		}

		return '<unknown>';
	}

	/**
	 * Array1 VALUES NOT IN array2
	 *
	 * @param array $array1
	 * @param array $array2
	 *
	 * @return array of values in array1 NOT in array2
	 */
	public static function diff_two_dimentional_arrays( array $array1, array $array2 ) {

		if ( empty($array1) ) {
			return array();
		}

		if ( empty($array2) ) {
			return $array1;
		}

		// flatten first array
		foreach( $array1 as $key => $value ) {
			if ( is_array($value) ) {
				$tmp_value = '';
				foreach( $value as $tmp ) {
					$tmp_value .= ( empty($tmp_value) ? '' : ',' ) . ( empty($tmp) ? '' : $tmp );
				}
				$array1[$key] = $tmp_value;
			}
		}

		// flatten second array
		foreach( $array2 as $key => $value ) {
			if ( is_array($value) ) {
				$tmp_value = '';
				foreach( $value as $tmp ) {
					$tmp_value .= ( empty($tmp_value) ? '' : ',' ) . ( empty($tmp) ? '' : $tmp );
				}
				$array2[$key] = $tmp_value;
			}
		}

		return array_diff_assoc($array1, $array2);
	}

	/**
	 * Get current user.
	 *
	 * @return null|WP_User
	 */
	public static function get_current_user() {

		$user = null;
		if ( function_exists('wp_get_current_user') ) {
			$user = wp_get_current_user();
		}

		// is user not logged in? user ID is 0 if not logged
		if ( empty($user) || ! $user instanceof WP_User || empty($user->ID) ) {
			$user = null;
		}

		return $user;
	}

	/**
	 * Common way to show support link
	 * @return string
	 */
	public static function contact_us_for_support() {

		$label = ' ' .  _x('Please contact us for support:', 'creative-addons-for-elementor') . ' ';
		$click_text =  _x('click here', 'creative-addons-for-elementor');

		return $label . '<a href="https://www.creative-addons.com/technical-support/" target="_blank" rel="noopener noreferrer">' . $click_text . '</a>';
	}

	/**
	 * Send email using WordPress email facility.
	 *
	 * @param $message
	 * @param string $to_support_email - usually admin or support
	 * @param string $reply_to_email - usually customer email
	 * @param string $reply_to_name - usually customer name
	 * @param string $subject - which functionality is this email coming from
	 *
	 * @return string - return '' if email sent otherwise return error message
	 */
	public static function send_email( $message, $to_support_email='', $reply_to_email='', $reply_to_name='', $subject='' ) {

		// validate MESSAGE
		if ( empty( $message ) || strlen( $message ) > 5000 ) {
			Logging::add_log( 'Invalid or too long email message', $message );
			return __( 'Error occurred', 'creative-addons-for-elementor' ) . ' (0)';
		}
		$message = sanitize_textarea_field( $message );

		// validate TO email
		if ( empty( $to_support_email ) ) { // send to admin if empty
			$to_support_email = get_option( 'admin_email' );
		}

		$to_support_email = sanitize_email( $to_support_email );
		if ( empty( $to_support_email ) || strlen( $to_support_email) > 100 ) {
			return __( 'Invalid email', 'creative-addons-for-elementor' ) . ' (1)';
		}

		if ( ! is_email( $to_support_email ) ) {
			return __( 'Invalid email', 'creative-addons-for-elementor' ) . ' (2)';
		}

		// validate REPLY TO email/name
		if ( empty( $reply_to_email ) ) {
			$reply_to_email = get_option( 'admin_email' );
		}

		$reply_to_email = sanitize_email( $reply_to_email );
		if ( empty( $reply_to_email ) || strlen( $reply_to_email ) > 100 ) {
			return __( 'Invalid email', 'creative-addons-for-elementor' ) . ' (3)';
		}
		
		if ( ! is_email( $reply_to_email ) ) {
			return __( 'Invalid email', 'creative-addons-for-elementor' ) . ' (4)';
		}
		
		if ( strlen( $reply_to_name ) > 100 ) {
			return __( 'Error occurred', 'creative-addons-for-elementor' ) . ' (5)';
		}
		
		$reply_to_name = sanitize_text_field( $reply_to_name );

		// validate SUBJECT
		$subject = sanitize_text_field( $subject );
		if ( empty( $subject ) ) {
			$subject = esc_html__( 'New message', 'creative-addons-for-elementor' ) . ' ' . esc_html_x( 'from', 'email sent from someone', 'creative-addons-for-elementor' ) . ' ' . esc_attr( get_bloginfo( 'name' ) );
		}

		if ( strlen( $subject ) > 200 ) {
			return __( 'Invalid subject', 'creative-addons-for-elementor' );
		}
		
		if ( strlen( $message ) > 10000 ) {
			return __( 'Email message is too long', 'creative-addons-for-elementor' );
		}

		// setup Email header
		$from_name = get_bloginfo( 'name' ); // Site title (set in Settings > General)
		$from_email = get_option( 'admin_email' );
		$headers = array(
			"From: {$from_name} <{$from_email}>\r\n",
			"Reply-To: {$reply_to_name} <{$reply_to_email}>\r\n",
			"Content-Type: text/html; charset=utf-8\r\n",
		);

		// setup Email message
		$message =
			'<html>
				<body>' . esc_html( $message ) .  '
				</body>
			</html>';

		// convert text to HTML - clickable links, turning line breaks into <p> and <br/> tags
		//$message = wpautop( make_clickable( $message ), false );
		$message = str_replace( '&#038;', '&amp;', $message );
		$message = str_replace( [ "\r\n", '\r\n', "\n", '\n', "\r", '\r' ], '<br />', $message );

		// we to add filter to allow HTML in the email content to make sure the content type was not changed by third-party code
		add_filter( 'wp_mail_content_type', array( 'Utilities', 'set_html_content_type' ), 999 );

		// send email
		$result = wp_mail( $to_support_email, $subject, $message, $headers );

		// remove filter that allows HTML in the email content
		remove_filter( 'wp_mail_content_type', array( 'Utilities', 'set_html_content_type' ), 999 );

		return $result == false ? __( 'Failed to send the email.', 'creative-addons-for-elementor' ) : '';
	}

	/**
	 * Check first installed version. Return true if $version less or equal than first installed version. Also return true if crel_version_first was removed. Use to apply some functions only to new users
	 * @param $version
	 * @return bool
	 */
	public static function is_new_user( $version ) {
		$plugin_first_version = self::get_wp_option( 'crel_version_first', $version );
		return ! version_compare( $plugin_first_version, $version, '<' );
	}
}
