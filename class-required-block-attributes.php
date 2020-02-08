<?php // phpcs:ignore WordPress.Files.FileName.
/**
 * WordPress plugin to check required block attributes are set when a post is published.
 *
 * @package   required-block-attributes
 * @author    imath
 * @license   GPL-2.0+
 * @link      https://imathi.eu
 *
 * @wordpress-plugin
 * Plugin Name:       Required Block Attributes
 * Plugin URI:        https://github.com/imath/required-block-attributes
 * Description:       WordPress plugin to check required block attributes are set when a post is published.
 * Version:           1.0.0
 * Author:            imath
 * Author URI:        https://imathi.eu
 * Text Domain:       required-block-attributes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 */

namespace Required_Block_Attributes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class
 *
 * @since 1.0.0
 */
final class Main {
	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var object $instance The plugin main instance.
	 */
	protected static $instance = null;

	/**
	 * Initializes the plugin
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->inc();
	}

	/**
	 * Returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function start() {

		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Loads needed files.
	 *
	 * @since 1.0.0
	 */
	private function inc() {
		$inc_path = plugin_dir_path( __FILE__ ) . 'inc/';

		require $inc_path . 'globals.php';
		require $inc_path . 'functions.php';
		require $inc_path . 'registers.php';

		if ( is_admin() ) {
			require $inc_path . 'admin.php';
		}

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			require $inc_path . 'example.php';
		}
	}
}

/**
 * Starts the plugin.
 *
 * @since 1.0.0
 *
 * @return Main The main instance of the plugin.
 */
function rba() {
	return Main::start();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\rba', 9 );
