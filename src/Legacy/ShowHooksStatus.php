<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Cookies;

/**
 * Class ShowHooksStatus.
 *
 * // TODO: Complete doc.
 */
class ShowHooksStatus {

	protected string $status;

	public function __construct() {
		if (
			! current_user_can( 'manage_options' ) || // Restrict use to Admins only
			! $this->is_active() // Allow filters to deactivate.
		) {
			$this->status = 'off';
			return;
		}
	}

	public function is_active() {
		// Filters to deactivate our plugin - backend, frontend or sitewide.
		// add_filter( 'ash_show_hooks_active', '__return_false' );
		// add_filter( 'ash_show_hooks_backend_active', '__return_false' );
		// add_filter( 'ash_show_hooks_frontend_active', '__return_false' );
		if ( ! apply_filters( 'ash_show_hooks_active', true ) ) {
			// Sitewide.
			return false;
		}
		if ( is_admin() ) {
			// Backend.
			if ( ! apply_filters( 'ash_show_hooks_backend_active', true ) ) {
				return false;
			}
		} else {
			// Frontend.
			if ( ! apply_filters( 'ash_show_hooks_frontend_active', true ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Helper function that sets the active status of the hooks displaying.
	 */
	public function set_active_status() {
		if ( ! isset( $this->status ) ) {
			if ( ! isset( $_COOKIE['ash_status'] ) ) {
				try {
					setcookie( 'ash_status', 'off', time() + 3600 * 24 * 100, '/' );
				} catch ( Exception $e ) {
					echo $e->getMessage();
				}
			}
			if ( isset( $_REQUEST['ash-hooks'] ) ) {
				try {
					setcookie( 'ash_status', sanitize_text_field( $_REQUEST['ash-hooks'] ), time() + 3600 * 24 * 100, '/' );
				} catch ( Exception $e ) {
					echo $e->getMessage();
				}
				$this->status = sanitize_text_field( $_REQUEST['ash-hooks'] );
			} elseif ( isset( $_COOKIE['ash_status'] ) ) {
				$this->status = sanitize_text_field( $_COOKIE['ash_status'] );
			} else {
				$this->status = 'off';
			}
		}
	}


}
