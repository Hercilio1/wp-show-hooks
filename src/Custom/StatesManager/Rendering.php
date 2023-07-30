<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\StatesManager;

/**
 * Class Rendering. When the crawling system is active and rendering hooks.
 */
class Rendering extends State {

	public function crawl( string $hook ) : void {
	}

	public function get_status(): string {
		return 'rendering';
	}
}
