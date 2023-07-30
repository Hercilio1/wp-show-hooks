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
		Custom\HooksReader::get_instance();
	}

	public static function setup() : void {
		Setup\Enqueue::init();
	}
}
