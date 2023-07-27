<?php
/**
 * Plugin Name:         WP Show Hooks
 * Plugin URI:          https://github.com/Hercilio1/wp-show-hooks
 * Description:         Show all triggered hooks fired on the current WordPress page.
 * Author:              Hercilio M. Ortiz
 * Author URI:          https://github.com/Hercilio1
 * Text Domain:         wp-show-hooks
 * Domain Path:         /languages
 * Version:             0.1.0
 * Requires at least:   5.8
 * Requires PHP:        7.3
 *
 * @package WP_Show_Hooks
 */

/**
 * This project was forked from https://github.com/vairafiq/another-show-hooks.
 * I just improved the features and added some new ones focusing on the developer experience.
 */

defined( 'ABSPATH' ) || exit();

if ( ! defined( 'WP_SHOW_HOOKS_VERSION' ) ) {
    define( 'WP_SHOW_HOOKS_VERSION', '0.1.0' );
}

if ( ! defined( 'WP_SHOW_HOOKS_FILE' ) ) {
    define( 'WP_SHOW_HOOKS_FILE', __FILE__ );
}

if ( ! defined( 'WP_SHOW_HOOKS_PATH' ) ) {
    define( 'WP_SHOW_HOOKS_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WP_SHOW_HOOKS_URL' ) ) {
    define( 'WP_SHOW_HOOKS_URL', plugin_dir_url( __FILE__ ) );
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

if ( class_exists( '\\WPShowHooks\\\\Init' ) ) {
    WPShowHooks\Init::init();
}