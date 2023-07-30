<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers;

use WPShowHooks\Custom\StatesManager\Inactive;
use WPShowHooks\Custom\StatesManager\State;

/**
 * Abstract class AbstractHooksCrawler. Define a general crawler for any kind of hook.
 */
abstract class AbstractHooksCrawler {

	protected State $state;
	protected array $all_hooks;

	public function __construct() {
		$this->state     = new Inactive( $this );
		$this->all_hooks = [];
	}

	/**
	 * Relies the crawling to the current state.
	 *
	 * @param string $hook The name of the hook.
	 */
	public function crawl( string $hook ) : void {
		$this->state->crawl( $hook );
	}

	/**
	 * Add a hook to the list of hooks to be crawled based on the crawler rules.
	 *
	 * @param string $hook The name of the hook.
	 */
	abstract public function add_hook( string $hook ) : void;

	public function set_state( State $state ) : void {
		$state->set_crawler( $this );
		$this->state = $state;
	}
}
