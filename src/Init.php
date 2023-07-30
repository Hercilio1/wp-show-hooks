<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks;

/**
 * Class Init. Initializes the plugin and the sequential main flow.
 */
class Init {

	public static function init() : void {
		self::setup();

		add_action( 'plugins_loaded', [ __CLASS__, 'read_hooks' ] );
	}

	public static function setup() : void {
		Setup\Enqueue::init();
	}

	public static function read_hooks() : void {
		Custom\HooksReader::get_instance();
	}
}
