<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\HooksDictionary;

use WPShowHooks\Custom\HooksReader;

/**
 * Class ActionsDictionary. Renders a dictionary of actions.
 */
class ActionsDictionary {

	public static function init() : void {
		add_action( 'shutdown', [ __CLASS__, 'render' ] );
	}

	public static function render() : void {
		$hooks_crawler = HooksReader::get_instance()->get_crawler( 'action' );
		if ( null === $hooks_crawler ) {
			return;
		}
		$args               = [];
		$args['hooks_list'] = $hooks_crawler->get_all_hooks();
		include WP_SHOW_HOOKS_PATH . 'templates/hooks-dictionary.php';
	}
}
