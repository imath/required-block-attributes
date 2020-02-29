<?php
/**
 * Admin functions.
 *
 * @package required-block-attributes
 * @subpackage \inc\admin
 */

namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the Pre Publish Panel JavaScript file.
 *
 * This panel informs about the missing required attributes before
 * the post is published or updated.
 *
 * @since  1.0.0
 */
function enqueue_block_editor_assets() {
	\wp_enqueue_style( 'required-block-attributes-pre-publish-panel' );
	\wp_enqueue_script( 'required-block-attributes-pre-publish-panel' );

	// Load JavaScript translations.
	\wp_set_script_translations(
		'required-block-attributes-pre-publish-panel',
		'required-block-attributes',
		rba()->lang_path
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );
