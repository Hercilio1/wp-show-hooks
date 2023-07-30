<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

use WPShowHooks\Custom\Crawlers\AbstractHooksCrawler;
use WPShowHooks\Custom\Crawlers\ActionsCrawler;
use WPShowHooks\Custom\StatesManager\Crawling;
use WPShowHooks\Custom\StatesManager\Rendering;

/**
 * Class HooksReader. Hooks all hooks of the system and delegates the right action.
 */
final class HooksReader {

	private static ?HooksReader $instance = null;
	private array $all_crawlers;

	public static function get_instance() : HooksReader {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$this->all_crawlers = [];
		// TODO: Dinamize.
		$crawler = new ActionsCrawler();
		$crawler->set_state( new Crawling() );
		$this->add_crawler( $crawler );
		// --
		$this->intercept_hooks();
	}

	private function intercept_hooks() : void {
		add_action( 'all', [ $this, 'process_hook' ] );
		// TODO: Remove the following code.
		add_action( 'wp_head', [ $this, 'tmp_active_rendering' ], PHP_INT_MAX - 2 );
		// add_action( 'shutdown', [ $this, 'tmp_print' ] );
	}

	/**
	 * Hooks every single hook triggered by the system.
	 *
	 * @param string $hook The name of the hook.
	 */
	public function process_hook( string $hook ) : void {
		foreach ( $this->all_crawlers as $crawler ) {
			$crawler->crawl( $hook );
		}
	}

	/**
	 * Adds a new crawler to the system.
	 *
	 * @param AbstractHooksCrawler $crawler The crawler to be added.
	 */
	public function add_crawler( AbstractHooksCrawler $crawler ) : void {
		$this->all_crawlers[] = $crawler;
	}

	public function tmp_active_rendering() : void {
		foreach ( $this->all_crawlers as $crawler ) {
			$crawler->set_state( new Rendering() );
		}
	}

	public function tmp_print() : void {
		echo '<pre>';
		print_r( $this->all_crawlers );
		exit;
	}
}
