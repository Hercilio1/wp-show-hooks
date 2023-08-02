<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks;

use WPShowHooks\Custom\ActivationStatus;

/**
 * Class Init. Initializes the plugin and the sequential main flow.
 */
class Init {

	public static function init() : void {
		self::init_admin();
		add_action( 'plugins_loaded', [ __CLASS__, 'init_show_hooks' ], PHP_INT_MAX - 2 );
	}

	public static function init_admin() : void {
		Custom\Admin\AdminBar::init();
	}

	public static function init_show_hooks() : void {
		if ( ! ActivationStatus::get_instance()->is_active() ) {
			return;
		}
		Setup\Enqueue::init();
		Custom\HooksReader::get_instance();
	}
}
