<?php
/**
 * The WP_REST_Controller is in the REST plugin, but not in core WordPress
 * This may be a problem when running WP 4.4
 */

if ( class_exists( 'WP_REST_Controller' ) ) {
	return;
}

abstract class WP_REST_Controller {

	/**
	 * Prepare a response for inserting into a collection.
	 *
	 * @param WP_REST_Response $response Response object.
	 * @return array Response data, ready for insertion into collection data.
	 */
	public function prepare_response_for_collection( $response ) {
		if ( ! ( $response instanceof WP_REST_Response ) ) {
			return $response;
		}

		$data = (array) $response->get_data();
		$links = WP_REST_Server::get_response_links( $response );
		if ( ! empty( $links ) ) {
			$data['_links'] = $links;
		}

		return $data;
	}

	/**
	 * Filter a response based on the context defined in the schema
	 *
	 * @param array $data
	 * @param string $context
	 * @return array
	 */
	public function filter_response_by_context( $data, $context ) {

		$schema = $this->get_item_schema();
		foreach ( $data as $key => $value ) {
			if ( empty( $schema['properties'][ $key ] ) || empty( $schema['properties'][ $key ]['context'] ) ) {
				continue;
			}

			if ( ! in_array( $context, $schema['properties'][ $key ]['context'] ) ) {
				unset( $data[ $key ] );
			}

			if ( 'object' === $schema['properties'][ $key ]['type'] && ! empty( $schema['properties'][ $key ]['properties'] ) ) {
				foreach ( $schema['properties'][ $key ]['properties'] as $attribute => $details ) {
					if ( empty( $details['context'] ) ) {
						continue;
					}
					if ( ! in_array( $context, $details['context'] ) ) {
						unset( $data[ $key ][ $attribute ] );
					}
				}
			}
		}

		return $data;
	}

	/**
	 * Get the item's schema, conforming to JSON Schema
	 *
	 * @return array
	 */
	public function get_item_schema() {
		return $this->add_additional_fields_schema( array() );
	}

	/**
	 * Get the item's schema for display / public consumption purposes.
	 *
	 * @return array
	 */
	public function get_public_item_schema() {

		$schema = $this->get_item_schema();

		foreach ( $schema['properties'] as &$property ) {
			if ( isset( $property['arg_options'] ) ) {
				unset( $property['arg_options'] );
			}
		}

		return $schema;
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'page'                   => array(
				'description'        => 'Current page of the collection.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			),
			'per_page'               => array(
				'description'        => 'Maximum number of items to be returned in result set.',
				'type'               => 'integer',
				'default'            => 10,
				'sanitize_callback'  => 'absint',
			),
			'search'                 => array(
				'description'        => 'Limit results to those matching a string.',
				'type'               => 'string',
				'sanitize_callback'  => 'sanitize_text_field',
			),
		);
	}

	/**
	 * Add the values from additional fields to a data object
	 *
	 * @param array  $object
	 * @param WP_REST_Request $request
	 * @return array modified object with additional fields
	 */
	protected function add_additional_fields_to_object( $object, $request ) {

		$additional_fields = $this->get_additional_fields();

		foreach ( $additional_fields as $field_name => $field_options ) {

			if ( ! $field_options['get_callback'] ) {
				continue;
			}

			$object[ $field_name ] = call_user_func( $field_options['get_callback'], $object, $field_name, $request );
		}

		return $object;
	}

	/**
	 * Update the values of additional fields added to a data object.
	 *
	 * @param array  $object
	 * @param WP_REST_Request $request
	 */
	protected function update_additional_fields_for_object( $object, $request ) {

		$additional_fields = $this->get_additional_fields();

		foreach ( $additional_fields as $field_name => $field_options ) {

			if ( ! $field_options['update_callback'] ) {
				continue;
			}

			// Don't run the update callbacks if the data wasn't passed in the request
			if ( ! isset( $request[ $field_name ] ) ) {
				continue;
			}

			call_user_func( $field_options['update_callback'], $request[ $field_name ], $object, $field_name, $request );
		}
	}

	/**
	 * Add the schema from additional fields to an schema array
	 *
	 * The type of object is inferred from the passed schema.
	 *
	 * @param array $schema Schema array
	 */
	protected function add_additional_fields_schema( $schema ) {
		if ( ! $schema || ! isset( $schema['title'] ) ) {
			return $schema;
		}

		/**
		 * Can't use $this->get_object_type otherwise we cause an inf loop
		 */
		$object_type = $schema['title'];

		$additional_fields = $this->get_additional_fields( $object_type );

		foreach ( $additional_fields as $field_name => $field_options ) {
			if ( ! $field_options['schema'] ) {
				continue;
			}

			$schema['properties'][ $field_name ] = $field_options['schema'];
		}

		return $schema;
	}

	/**
	 * Get all the registered additional fields for a given object-type
	 *
	 * @param  string $object_type
	 * @return array
	 */
	protected function get_additional_fields( $object_type = null ) {

		if ( ! $object_type ) {
			$object_type = $this->get_object_type();
		}

		if ( ! $object_type ) {
			return array();
		}

		global $wp_rest_additional_fields;

		if ( ! $wp_rest_additional_fields || ! isset( $wp_rest_additional_fields[ $object_type ] ) ) {
			return array();
		}

		return $wp_rest_additional_fields[ $object_type ];
	}

	/**
	 * Get the object type this controller is responsible for managing.
	 *
	 * @return string
	 */
	protected function get_object_type() {
		$schema = $this->get_item_schema();

		if ( ! $schema || ! isset( $schema['title'] ) ) {
			return null;
		}

		return $schema['title'];
	}

	/**
	 * Get an array of endpoint arguments from the item schema for the controller.
	 *
	 * @param $add_required_flag Whether to use the 'required' flag from the schema proprties.
	 *                           This is because update requests will not have any required params
	 *                           Where as create requests will.
	 * @return array
	 */
	public function get_endpoint_args_for_item_schema( $add_required_flag = true ) {

		$schema                = $this->get_item_schema();
		$schema_properties     = ! empty( $schema['properties'] ) ? $schema['properties'] : array();
		$endpoint_args = array();

		foreach ( $schema_properties as $field_id => $params ) {

			// Anything marked as readonly should not be a arg
			if ( ! empty( $params['readonly'] ) ) {
				continue;
			}

			$endpoint_args[ $field_id ] = array(
				'validate_callback' => array( $this, 'validate_schema_property' ),
				'sanitize_callback' => array( $this, 'sanitize_schema_property' ),
			);

			if ( isset( $params['default'] ) ) {
				$endpoint_args[ $field_id ]['default'] = $params['default'];
			}

			if ( $add_required_flag && ! empty( $params['required'] ) ) {
				$endpoint_args[ $field_id ]['required'] = true;
			}

			// Merge in any options provided by the schema property
			if ( isset( $params['arg_options'] ) ) {
				$endpoint_args[ $field_id ] = array_merge( $endpoint_args[ $field_id ], $params['arg_options'] );
			}
		}

		return $endpoint_args;
	}

	/**
	 * Validate an parameter value that's based on a property from the item schema.
	 *
	 * @param  mixed $value
	 * @param  WP_REST_Request $request
	 * @param  string $parameter
	 * @return WP_Error|bool
	 */
	public function validate_schema_property( $value, $request, $parameter ) {

		/**
		 * We don't currently validate against empty values, as lots of checks
		 * can unintentially fail, as the callback will often handle an empty
		 * value it's self.
		 */
		if ( ! $value ) {
			return true;
		}

		$schema = $this->get_item_schema();

		if ( ! isset( $schema['properties'][ $parameter ] ) ) {
			return true;
		}

		$property = $schema['properties'][ $parameter ];

		if ( ! empty( $property['enum'] ) ) {
			if ( ! in_array( $value, $property['enum'] ) ) {
				return new WP_Error( 'rest_invalid_param', sprintf( __( '%s is not one of %s' ), $parameter, implode( ', ', $property['enum'] ) ) );
			}
		}

		if ( 'integer' === $property['type'] && ! is_numeric( $value ) ) {
			return new WP_Error( 'rest_invalid_param', sprintf( __( '%s is not of type %s' ), $parameter, 'integer' ) );
		}

		if ( 'string' === $property['type'] && ! is_string( $value ) ) {
			return new WP_Error( 'rest_invalid_param', sprintf( __( '%s is not of type %s' ), $parameter, 'string' ) );
		}

		if ( isset( $property['format'] ) ) {
			switch ( $property['format'] ) {
				case 'date-time':
					if ( ! rest_parse_date( $value ) ) {
						return new WP_Error( 'rest_invalid_date', __( 'The date you provided is invalid.' ) );
					}
					break;

				case 'email':
					if ( ! is_email( $value ) ) {
						return new WP_Error( 'rest_invalid_email', __( 'The email address you provided is invalid.' ) );
					}
					break;
			}
		}

		return true;
	}

	/**
	 * Sanitize an parameter value that's based on a property from the item schema.
	 *
	 * @param  mixed $value
	 * @param  WP_REST_Request $request
	 * @param  string $parameter
	 * @return WP_Error|bool
	 */
	public function sanitize_schema_property( $value, $request, $parameter ) {

		$schema = $this->get_item_schema();

		if ( ! isset( $schema['properties'][ $parameter ] ) ) {
			return true;
		}

		$property = $schema['properties'][ $parameter ];

		if ( 'integer' === $property['type'] ) {
			return intval( $value );
		}

		if ( isset( $property['format'] ) ) {
			switch ( $property['format'] ) {
				case 'date-time':
					return sanitize_text_field( $value );

				case 'email':
					// as sanitize_email is very lossy, we just want to
					// make sure the string is safe
					if ( sanitize_email( $value ) ) {
						return sanitize_email( $value );
					}
					return sanitize_text_field( $value );

				case 'uri':
					return esc_url_raw( $value );
			}
		}

		return $value;
	}
}
