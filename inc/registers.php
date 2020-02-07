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

/**
 * Registers the Pre Publish Panel JavaScript file.
 *
 * @since 1.0.0
 */
function register_pre_publish_panel() {
	$rba = rba();

	// Registers the JavaScript URL of the Pre Publish Panel.
	\wp_register_script(
		'required-block-attributes-pre-publish-panel',
		$rba->dist_url . 'pre-publish-panel/index.js',
		array(
			'wp-element',
			'wp-plugins',
			'wp-edit-post',
			'wp-compose',
			'wp-data',
			'wp-components',
			'wp-i18n',
			'lodash',
		),
		$rba->version,
		true
	);

	// Registers the CSS styles for the Pre Publish Panel.
	\wp_register_style(
		'required-block-attributes-pre-publish-panel',
		$rba->dist_url . 'pre-publish-panel/index.css',
		array(),
		$rba->version
	);
}
add_action( 'init', __NAMESPACE__ . '\register_pre_publish_panel' );
