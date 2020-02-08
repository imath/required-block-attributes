<?php
/**
 * Functions about globals.
 *
 * @package required-block-attributes
 * @subpackage \inc\globals
 */

namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set plugin's globals.
 *
 * @since 1.0.0
 */
function set_globals() {
	$rba = rba();

	$rba->version = '1.0.0';

	$rba->inc_path  = plugin_dir_path( __FILE__ );
	$rba->dist_url  = plugins_url( 'dist/', dirname( __FILE__ ) );
	$rba->lang_path = trailingslashit( dirname( $rba->inc_path ) ) . 'languages';
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\set_globals', 10 );
