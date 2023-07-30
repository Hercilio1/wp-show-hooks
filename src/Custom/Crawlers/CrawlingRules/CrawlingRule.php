<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers\CrawlingRules;

/**
 * Interface CrawlingRule. Define the pattern of crawling rules.
 */
interface CrawlingRule {
	public function is_valid( array $hook ) : bool;
}
