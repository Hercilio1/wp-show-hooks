<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\StatesManager;

use WPShowHooks\Custom\Crawlers\AbstractHooksCrawler;

/**
 * Abstract class State. Holds the pattern of the states that the plugin can be in.
 */
abstract class State {

	protected AbstractHooksCrawler $crawler;

	abstract public function crawl( string $hook ) : void;
	abstract public function get_status() : string;

	/**
	 * Back-reference to the selected crawler.
	 *
	 * @param AbstractHooksCrawler $crawler The crawler to be referenced.
	 */
	public function set_crawler( AbstractHooksCrawler $crawler ) : void {
		$this->crawler = $crawler;
	}
}
