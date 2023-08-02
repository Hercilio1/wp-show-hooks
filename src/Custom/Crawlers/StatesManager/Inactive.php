<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers\StatesManager;

/**
 * Class Inactive. When the crawling system is inactive.
 */
class Inactive extends State {

	public function crawl( string $hook ) : void {
	}

	public function get_status(): string {
		return 'inactive';
	}
}
