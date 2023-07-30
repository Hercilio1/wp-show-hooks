<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

/**
 * Class BackDoorSwitchRenderer.
 *
 * // TODO: Complete doc.
 */
class BackDoorSwitchRenderer {

	/*
	 * Notification Switch
	 * Displays notification interface that will alway display
	 * even if the interface is corrupted in other places.
	 */
	public function notification_switch() {
		// Suspend the hooks rendering.
		$this->detach_hooks();
		// Setup a base URL and clear it of the intial `ash-hooks` arg.
		$url = add_query_arg( 'ash-hooks', 'off' );
		?>
		<a class="ash-notification-switch" href="<?php echo esc_url( $url ); ?>">
			<span class="ash-notification-indicator"></span>
			<?php esc_attr_e( 'Stop Showing Hooks', 'another-show-hooks' ); ?>
		</a>
		<?php
		// De-suspend the hooks rendering.
		$this->attach_hooks();
	}
}
