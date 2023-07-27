<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Admin;

/**
 * Class AdminBar.
 *
 * // TODO: Complete doc.
 */
class AdminBar {

	public function __construct() {
		add_action( 'admin_bar_menu', [ $this, 'admin_bar_menu' ], 90 );
		// Top Admin Bar Styles.
		add_action( 'wp_print_styles', [ $this, 'add_builder_edit_button_css' ] );
		add_action( 'admin_print_styles', [ $this, 'add_builder_edit_button_css' ] );
	}


	public function admin_bar_menu( $wp_admin_bar ) {
		// Suspend the hooks rendering.
		$this->detach_hooks();
		// Setup a base URL and clear it of the intial `ash-hooks` arg.
		$url = remove_query_arg( 'ash-hooks' );
		if ( 'show-action-hooks' == $this->status ) {
			$title = __( 'Stop Showing Action Hooks', 'another-show-hooks' );
			$href  = add_query_arg( 'ash-hooks', 'off', $url );
			$css   = 'ash-hooks-on ash-hooks-normal';
		} else {
			$title = __( 'Show Action Hooks', 'another-show-hooks' );
			$href  = add_query_arg( 'ash-hooks', 'show-action-hooks', $url );
			$css   = '';
		}
		$menu_title = __( 'Show Hooks', 'another-show-hooks' );
		if ( ( 'show-action-hooks' == $this->status ) ) {
			$menu_title = __( 'Stop Showing Action Hooks', 'another-show-hooks' );
			$href       = add_query_arg( 'ash-hooks', 'off', $url );
		}
		if ( ( 'show-filter-hooks' == $this->status ) ) {
			$menu_title = __( 'Stop Showing Action & Filter Hooks', 'another-show-hooks' );
			$href       = add_query_arg( 'ash-hooks', 'off', $url );
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
		if ( $this->status == 'show-filter-hooks' ) {
			$title = __( 'Stop Showing Action & Filter Hooks', 'another-show-hooks' );
			$href  = add_query_arg( 'ash-hooks', 'off', $url );
			$css   = 'ash-hooks-on ash-hooks-sidebar';
		} else {
			$title = __( 'Show Act  ion & Filter Hooks', 'another-show-hooks' );
			$href  = add_query_arg( 'ash-hooks', 'show-filter-hooks', $url );
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

		// De-suspend the hooks rendering.
		$this->attach_hooks();
	}

	/**
	 * Custom css to add icon to admin bar edit button.
	 */
	public function add_builder_edit_button_css() {
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
