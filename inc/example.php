<?php
/**
 * Example of use.
 *
 * @package required-block-attributes
 * @subpackage \inc\example
 */
namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers a block to show how to add required attributes.
 *
 * @since 1.0.0
 */
function register_block_type() {
	$rba = rba();

	// Registers the JavaScript URL of the block.
	\wp_register_script(
		'required-block-attributes-example-block',
		$rba->dist_url . 'block/index.js',
		array(
			'wp-element',
			'wp-components',
			'wp-i18n',
		),
		$rba->version,
		true
	);

	// Register the Entity block.
	\register_block_type(
		'required-block-attributes/example',
		array(
			'editor_script'       => 'required-block-attributes-example-block',
			'required_attributes' => array( // This parameter makes sure required attributes are checked on the server side.
				array(
					'name'  => 'attributeOne',
					'label' => __( 'Attribute One', 'required-block-attributes' ), // The label is used into the Block's editor error notice.
				),
				array(
					'name'  => 'attributeTwo',
					'label' => __( 'Attribute Two', 'required-block-attributes' ),
				),
			),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register_block_type' );
