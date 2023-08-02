<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Admin;

use WP_Admin_Bar;
use WPShowHooks\Custom\ActivationStatus;

/**
 * Class AdminBar. Loads the activeness control on the admin bar.
 */
class AdminBar {

	public static function init() {
		add_action( 'admin_bar_menu', [ __CLASS__, 'admin_bar_menu' ], 90 );
		// Top Admin Bar Styles.
		add_action( 'wp_print_styles', [ __CLASS__, 'add_builder_edit_button_css' ] );
		// phpcs:ignore
		// add_action( 'admin_print_styles', [ __CLASS__, 'add_builder_edit_button_css' ] );
	}

	public static function admin_bar_menu( WP_Admin_Bar $wp_admin_bar ) : void {
		$activation_manager = ActivationStatus::get_instance();

		$status           = $activation_manager->get_status();
		$deactivation_url = $activation_manager->get_deactivation_url();

		if ( 'show-action' === $status ) {
			$title = __( 'Stop Showing Action Hooks', 'another-show-hooks' );
			$href  = $deactivation_url;
			$css   = 'ash-hooks-on ash-hooks-normal';
		} else {
			$title = __( 'Show Action Hooks', 'another-show-hooks' );
			$href  = $activation_manager->get_activation_url( 'show-action' );
			$css   = '';
		}

		$menu_title = __( 'Show Hooks', 'another-show-hooks' );
		if ( ( 'show-action' === $status ) ) {
			$menu_title = __( 'Stop Showing Action Hooks', 'another-show-hooks' );
			$href       = $deactivation_url;
		} elseif ( 'show-filter' === $status ) {
			$menu_title = __( 'Stop Showing Action & Filter Hooks', 'another-show-hooks' );
			$href       = $deactivation_url;
		}

		$wp_admin_bar->add_menu(
			[
				'title'  => '<span class="ab-icon"></span><span class="ab-label">' . $menu_title . '</span>',
				'id'     => 'ash-main-menu',
				'parent' => false,
				'href'   => $href,
			]
		);
		$wp_admin_bar->add_menu(
			[
				'title'  => $title,
				'id'     => 'ash-simply-show-hooks',
				'parent' => 'ash-main-menu',
				'href'   => $href,
				'meta'   => [ 'class' => $css ],
			]
		);
		if ( 'show-filter' === $status ) {
			$title = __( 'Stop Showing Action & Filter Hooks', 'another-show-hooks' );
			$href  = $deactivation_url;
			$css   = 'ash-hooks-on ash-hooks-sidebar';
		} else {
			$title = __( 'Show Act  ion & Filter Hooks', 'another-show-hooks' );
			$href  = $activation_manager->get_activation_url( 'show-filter' );
			$css   = '';
		}

		$wp_admin_bar->add_menu(
			[
				'title'  => $title,
				'id'     => 'ash-show-all-hooks',
				'parent' => 'ash-main-menu',
				'href'   => $href,
				'meta'   => [ 'class' => $css ],
			]
		);
	}

	/**
	 * Custom css to add icon to admin bar edit button.
	 */
	public static function add_builder_edit_button_css() : void {
		?>
		<style>
		#wp-admin-bar-ash-main-menu .ab-icon:before{
			font-family: "dashicons" !important;
			content: "\f323" !important;
			font-size: 16px !important;
		}
		</style>
		<?php
	}
}
