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
		if ( ! isset( $wp_actions[ $hook ] ) ) {
			return null;
		}
		$hook_cell = [
			'ID'                 => $hook,
			'callback'           => false,
			'type'               => 'action',
			'nested_hooks_count' => $this->get_nested_hooks_count( $hook ),
			'nested_hooks_data'  => $this->get_nested_hooks_data( $hook ),

		];

		if ( ! $this->is_a_valid_hook( $hook_cell ) ) {
			return null;
		}
		$this->all_hooks[] = $hook_cell;

		// TODO: Add recent hook algorithm.
		return $hook_cell;
	}

	private function get_nested_hooks_count( string $hook_id ) : int {
		global $wp_filter;
		if ( ! isset( $wp_filter[ $hook_id ] ) || empty( $wp_filter[ $hook_id ] ) ) {
			return 0;
		}

		$nested_hooks = $wp_filter[ $hook_id ];

		$nested_hooks_count = 0;
		foreach ( $nested_hooks as $value ) {
			$nested_hooks_count += count( $value );
		}
		return $nested_hooks_count;
	}

	private function get_nested_hooks_data( string $hook_id ) : array {
		global $wp_filter;
		if ( ! isset( $wp_filter[ $hook_id ] ) || empty( $wp_filter[ $hook_id ] ) ) {
			return [];
		}

		$nested_hooks = [];
		foreach ( $wp_filter[ $hook_id ] as $nested_value ) {
			foreach ( $nested_value as $nested_inner_key => $nested_inner_value ) {
				if ( $nested_inner_value['function'] && is_array( $nested_inner_value['function'] ) && count( $nested_inner_value['function'] ) > 1 ) {
					$class_name = false;
					if ( is_object( $nested_inner_value['function'][0] ) ) {
						$class_name = get_class( $nested_inner_value['function'][0] );
					}
					if ( is_string( $nested_inner_value['function'][0] ) ) {
						$class_name = $nested_inner_value['function'][0];
					}
					if ( $class_name ) {
						$nested_hooks[] = $class_name . '->' . $nested_inner_value['function'][1];
					} else {
						$nested_hooks[] = $nested_inner_value['function'][1];
					}
				} else {
					$nested_hooks[] = $nested_inner_key;
				}
			}
		}
		return $nested_hooks;
	}
}
