<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\StatesManager;

/**
 * Class Crawling. When the crawling system is active but the hooks are only being crawled.
 */
class Crawling extends State {

	public function crawl( string $hook ) : void {
		$this->crawler->add_hook( $hook );
	}

	public function get_status(): string {
		return 'crawling';
	}
}
