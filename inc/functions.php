<?php
/**
 * General functions.
 *
 * @package required-block-attributes
 * @subpackage \inc\functions
 */
namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Makes sure Required Block Attributes are set before publishing/updating the post type.
 *
 * @since 1.0.0
 *
 * @param stdClass        $prepared_post An object representing a single post prepared
 *                                       for inserting or updating the database.
 * @param WP_REST_Request $request       Request object.
 */
function validate_block_attributes( $prepared_post, \WP_REST_Request $request ) {
	if ( ! isset( $prepared_post->post_status ) ) {
		$post_status = \get_post_status( $prepared_post->ID );
	} else {
		$post_status = $prepared_post->post_status;
	}

	if ( 'publish' !== $post_status ) {
		return $prepared_post;
	}

	$prepared_blocks     = \parse_blocks( $prepared_post->post_content );
	$block_types         = \WP_Block_Type_Registry::get_instance()->get_all_registered();
	$required_attributes = array();
	$missing_values      = array();

	foreach ( $block_types as $block_type ) {
		if ( ! isset( $block_type->required_attributes ) || ! $block_type->required_attributes ) {
			continue;
		}

		$required_attributes[ $block_type->name ] = $block_type->required_attributes;
	}

	foreach ( $required_attributes as $block_name => $required_atts ) {
		$blocks = \wp_filter_object_list( $prepared_blocks, array( 'blockName' => $block_name ) );

		foreach ( $required_atts as $required_attribute ) {
			foreach ( $blocks as $block ) {
				if ( ! isset( $block['attrs'][ $required_attribute['name'] ] ) || ! $block['attrs'][ $required_attribute['name'] ] ) {
					$missing_values[] = $required_attribute['label'];
				}
			}
		}
	}

	if ( $missing_values ) {
		return new \WP_Error(
			'required_block_attributes_missing_required_value',
			sprintf(
				_n( 'a required field is not set, please make sure to fill in the field : %s.', 'Some required fields are not set, please make sure to fill in the following fields : %s.', count( $missing_values ), 'required-block-attributes' ),
				implode( ', ', array_map( 'esc_html', $missing_values ) )
			),
			array( 'status' => 400 )
		);
	}

	return $prepared_post;
}

/**
 * Filters the data to insert/update into the DB for post types supporting the WP REST API.
 *
 * @since 1.0.0
 */
function set_filters() {
	$post_types = \get_post_types( array( 'show_in_rest' => true ) );

	foreach ( $post_types as $post_type ) {
		add_filter( 'rest_pre_insert_' . $post_type, __NAMESPACE__ . '\validate_block_attributes', 10, 2 );
	}
}
add_action( 'rest_api_init', __NAMESPACE__ . '\set_filters', 1000 );
