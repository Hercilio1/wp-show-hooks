<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers\CrawlingRules;

/**
 * Class IgnoringPrefixes. Rules for ignoring prefixes.
 */
class IgnoringPrefixes implements CrawlingRule {

	private ?array $prefixes = null;

	public function is_valid( array $hook ) : bool {
		$prefixes = $this->get_prefixes();
		foreach ( $prefixes as $prefix ) {
			if ( 0 === strpos( $hook['ID'], $prefix ) ) {
				return false;
			}
		}
		return true;
	}

	public function get_prefixes() : array {
		if ( is_null( $this->prefixes ) ) {
			/**
			 * Apply filters. Return a dynamic list of prefixes. Hook this filter after the
			 * plugins_loaded hook.
			 *
			 * @param array $prefixes The list of prefixes to be ignored.
			 */
			$this->prefixes = apply_filters(
				'wp_show_hooks_ignored_prefixes',
				[
					'get_template_part',
					'wp_before_load_template',
					'wp_after_load_template',
				]
			);
		}
		return $this->prefixes;
	}
}
