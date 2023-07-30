<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers;

/**
 * Class AbstractHooksCrawler. Crawls all system actions.
 */
class ActionsCrawler extends AbstractHooksCrawler {

	public function add_hook( string $hook ) : void {
		global $wp_actions;
		if ( isset( $wp_actions[ $hook ] ) ) {
			// It is an action.
			$this->all_hooks[] = [
				'ID'       => $hook,
				'callback' => false,
				'type'     => 'action',
			];
		}
	}
}
