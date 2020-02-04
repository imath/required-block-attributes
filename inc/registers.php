<?php
/**
 * Register functions.
 *
 * @package required-block-attributes
 * @subpackage \inc\registers
 */
namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function register_block_type() {
	$rba = rba();

	// Registers the JavaScript URL of the block.
	\wp_register_script(
		'required-block-attributes-example-block',
		$rba->dist_url . 'index.js',
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
			'required_attributes' => array(
				array(
					'name'  => 'attributeOne',
					'label' => __( 'Attribute One', 'required-block-attributes' ),
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
