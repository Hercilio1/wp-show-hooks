<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

/**
 * Class ActivationStatus. Reads the plugin activation status.
 */
final class ActivationStatus {

	const QUERY_VAR_KEY      = 'wp-show-hooks';
	const AVAILABLE_STATUSES = [
		'show-action',
		'show-filter',
	];

	private static ?ActivationStatus $instance = null;

	private string $status;

	public static function get_instance() : ActivationStatus {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->status = $this->load_status();
	}

	private function load_status() : string {
		if ( $this->is_disabled() ) {
			return 'off';
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$status = isset( $_GET[ self::QUERY_VAR_KEY ] ) ? sanitize_text_field( wp_unslash( $_GET[ self::QUERY_VAR_KEY ] ) ) : 'off';

		if ( ! in_array( $status, self::AVAILABLE_STATUSES, true ) ) {
			$status = 'off';
		}
		return $status;
	}

	public function is_disabled() : bool {
		/**
		 * Apply filters. It allows to disable the plugins features.
		 *
		 * It has to be hooked before plugins_loaded (priority PHP_MAX_INT -2) action.
		 *
		 * @param bool $is_disabled
		 */
		$is_disabled = apply_filters( 'wp_show_hooks_is_disabled', false );

		// We could define the manage_options verification as the default value of the filter, but
		// we decided to keep it here because this plugin is a development tool.
		return $is_disabled || ! current_user_can( 'manage_options' );
	}

	public function is_active() : bool {
		return in_array( $this->status, self::AVAILABLE_STATUSES, true );
	}

	public function get_status() : string {
		return $this->status;
	}

	public function get_activation_url( string $service ) : string {
		global $wp_query;
		if ( ! $wp_query ) {
			return '';
		}
		if ( ! in_array( $service, self::AVAILABLE_STATUSES, true ) ) {
			return $this->get_deactivation_url();
		}
		return add_query_arg( self::QUERY_VAR_KEY, $service );
	}

	public function get_deactivation_url() : string {
		global $wp_query;
		if ( ! $wp_query ) {
			return '';
		}
		return remove_query_arg( self::QUERY_VAR_KEY );
	}
}
