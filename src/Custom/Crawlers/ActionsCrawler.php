<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers;

/**
 * Class ActionsCrawler. Crawls all system actions.
 */
class ActionsCrawler extends AbstractHooksCrawler {

	public function add_hook( string $hook ) : ?array {
		global $wp_actions;
		// Check if it is an action.
		if ( isset( $wp_actions[ $hook ] ) ) {
			$hook_cell         = [
				'ID'       => $hook,
				'callback' => false,
				'type'     => 'action',
			];
			$this->all_hooks[] = $hook_cell;
			return $hook_cell;
		}
		// TODO: Add recent hook algorithm.
		return null;
	}
}
