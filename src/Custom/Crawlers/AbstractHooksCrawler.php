<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers;

use WPShowHooks\Custom\Crawlers\CrawlingRules\IgnoringPrefixes;
use WPShowHooks\Custom\Crawlers\StatesManager\Inactive;
use WPShowHooks\Custom\Crawlers\StatesManager\State;

/**
 * Abstract class AbstractHooksCrawler. Define a general crawler for any kind of hook.
 */
abstract class AbstractHooksCrawler {

	protected State $state;
	protected array $all_hooks;
	protected array $crawling_rules;

	public function __construct() {
		$this->state          = new Inactive( $this );
		$this->all_hooks      = [];
		$this->crawling_rules = [
			new IgnoringPrefixes(),
		];
	}

	public function set_state( State $state ) : void {
		$state->set_crawler( $this );
		$this->state = $state;
	}

	public function is_a_valid_hook( array $hook ) : bool {
		foreach ( $this->crawling_rules as  $rule ) {
			if ( ! $rule->is_valid( $hook ) ) {
				return false;
			}
		}
		return true;
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
	 *
	 * @return array|null The hook added or null if the hook was not added.
	 */
	abstract public function add_hook( string $hook ) : ?array;
}
