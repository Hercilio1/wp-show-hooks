<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\HooksDictionary;

/**
 * Class ActionsDictionary. Renders a dictionary of actions.
 */
class ActionsDictionary {

	public static function init() : void {
		add_action( 'shutdown', [ __CLASS__, 'render' ] );
	}

	public static function render() : void {
		include WP_SHOW_HOOKS_PATH . 'templates/hooks-dictionary.php';
	}
}
