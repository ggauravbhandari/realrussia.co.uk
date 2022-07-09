<?php

class FrmAPIAppHelper {

	/**
	 * @var string $plug_version
	 */
	public static $plug_version = '1.11';

	/**
	 * @since 1.10
	 *
	 * @return string
	 */
	public static function plugin_version() {
		return self::$plug_version;
	}

	public static function generate( $chars = 4, $num_segments = 4 ) {
		$tokens     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$key_string = '';

		for ( $i = 0; $i < $num_segments; $i++ ) {
			$segment = '';

			for ( $j = 0; $j < $chars; $j++ ) {
				$segment .= $tokens[ rand( 0, 35 ) ];
			}

			$key_string .= $segment;

			if ($i < ( $num_segments - 1 ))
				$key_string .= '-';
		}

		return $key_string;
	}

	public static function is_frm_route() {
		return ( strpos( $_SERVER['REQUEST_URI'], '/frm/' ) === false ) ? false : true;
	}

	/**
	 * @since 1.02
	 * @return string
	 */
	public static function path() {
		return dirname( dirname( __FILE__ ) );
	}

	/**
	 * @since 1.02
	 * @return string
	 */
	public static function folder_name() {
		return basename( self::path() );
	}

	/**
	 * @since 1.02
	 * @return string
	 */
	public static function plugin_url() {
		return plugins_url( '', self::path() . '/formidable-api.php' );
	}

	/**
	 * FrmProXMLHelper::get_date is deprecated
	 * @since 1.04
	 */
	public static function format_date( $field, &$date ) {
		_deprecated_function( __METHOD__, '1.04.01', __CLASS__ . '::format_field_value' );
		self::format_field_value( $field, $date );
	}

	/**
	 * @since 1.04.01
	 */
	public static function format_field_value( $field, &$value ) {
		if ( is_callable( 'FrmFieldFactory::get_field_object' ) ) {
			$field_obj = FrmFieldFactory::get_field_object( $field );
			$value = $field_obj->get_import_value( $value, array( 'ids' => array() ) );
		} elseif ( $field->type === 'date' ) {
			$value = FrmProXMLHelper::get_date( $value );
		} elseif ( $field->type === 'data' ) {
			$value = FrmProXMLHelper::get_dfe_id( $value, $field );
		} elseif ( ( $field->type === 'checkbox' || $field->type === 'select' ) && is_callable( 'FrmProXMLHelper::get_multi_opts' ) ) {
			$value = FrmProXMLHelper::get_multi_opts( $value, $field );
		}
	}

	/**
	 * @since 1.04.01
	 */
	public static function format_file_id( &$value, $field ) {
		if ( is_callable( 'FrmProFileImport::import_attachment' ) && is_object( $field ) ) {
			$_REQUEST['csv_files'] = 1;
			$value = FrmProFileImport::import_attachment( $value, $field );
		} else {
			$value = FrmProXMLHelper::get_file_id( $value );
		}

		// string to array
		if ( ! is_array( $value ) && strpos( $value, ',' ) ) {
			$ids = explode( ',', $value );
			$ids = array_filter( $ids, 'is_numeric' );
			if ( ! empty( $ids ) && count( $ids ) > 1 ) {
				$value = $ids;
			}
		}
	}

	/**
	 * Prepare order and limit parameters for easy use in endpoints
	 *
	 * @param  array $request
	 *
	 * @return array
	 */
	public static function prepare_order_and_limit( $request ) {
		$output = array();
		$limit_or_page_size = ( ! empty( $request['limit'] ) ) ? $request['limit'] : $request['page_size'];
		$order  = ' ORDER BY ' . $request['order_by'] . ' ' . $request['order'];
		$offset = $limit_or_page_size * ( absint( $request['page'] ) - 1 );
		$limit  = ' LIMIT ' . $offset . ',' . $limit_or_page_size;
		array_push( $output, $order, $limit );

		return $output;
	}

	/**
	 * @since 1.10
	 *
	 * @return string
	 */
	public static function embed_protocol() {
		return get_option( 'permalink_structure' ) ? '/frm_embed/' : '?frm_embed=';
	}

	/**
	 * @since 1.10
	 *
	 * @param string $form_key
	 * @return string
	 */
	public static function get_embed_url( $form_key ) {
		return home_url() . self::embed_protocol() . $form_key;
	}
}
