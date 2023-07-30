<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

/**
 * Class PreTemplatesActionsRenderer.
 *
 * // TODO: Complete doc.
 */
class PreTemplatesActionsRenderer {

	public function __construct() {
		// Final hook - render the nested action array.
		add_action( 'admin_head', [ $this, 'render_head_hooks' ], 100 ); // Back-end - Admin.
		add_action( 'wp_head', [ $this, 'render_head_hooks' ], 100 ); // Front-end.
		add_action( 'login_head', [ $this, 'render_head_hooks' ], 100 ); // Login.
		add_action( 'customize_controls_print_scripts', [ $this, 'render_head_hooks' ], 100 ); // Customizer.
	}

	public function render_head_hooks() {
		// Render all the hooks so far.
		$this->render_hooks();
		// Add header marker to hooks collection
		// $this->all_hooks[] = array( 'End Header. Start Body', false, 'marker' );
		// Change to doing 'write' which will write the hook as it happens.
		$this->doing = 'write';
	}

	private function render_hooks() {
		foreach ( $this->all_hooks as $nested_value ) {
			if ( 'action' == $nested_value['type'] ) {
				$this->render_action( $nested_value );
			}
		}
	}
}
