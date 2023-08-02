<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Setup;

/**
 * Class Enqueue.
 *
 * // TODO: Complete doc.
 */
class Enqueue {

	public static function init() {
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue_script' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_script' ] );
		add_action( 'login_enqueue_scripts', [ __CLASS__, 'enqueue_script' ] );
	}

	public static function enqueue_script() {
		// Main Styles.
		wp_enqueue_style( 'wp-show-hooks', WP_SHOW_HOOKS_URL . 'assets/css/style.css', [], WP_DEBUG ?? time(), 'screen' );
		wp_enqueue_style( 'ash-main-css', WP_SHOW_HOOKS_URL . 'assets/css/ash-main.css', [], WP_DEBUG ?? time(), 'screen' );
		// Main Scripts.
		wp_enqueue_script( 'wp-show-hooks', WP_SHOW_HOOKS_URL . 'assets/js/main.js', [ 'jquery' ], WP_DEBUG ?? time(), true );
		wp_enqueue_script( 'ash-main-js', WP_SHOW_HOOKS_URL . 'assets/js/ash-main.js', [ 'jquery' ], WP_DEBUG ?? time(), true );
		wp_localize_script(
			'ash-main-js',
			'ash_main_js',
			[
				'home_url'  => get_home_url(),
				'admin_url' => admin_url(),
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
			]
		);
	}
}
