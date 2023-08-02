<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Crawlers\StatesManager;

use WPShowHooks\Custom\Renderers\ActionRenderer;

/**
 * Class Rendering. When the crawling system is active and rendering hooks.
 */
class Rendering extends State {

	public function crawl( string $hook ) : void {
		$current_hook = $this->crawler->add_hook( $hook );
		if ( $current_hook ) {
			ActionRenderer::render( $current_hook );
		}
	}

	public function get_status() : string {
		return 'rendering';
	}
}
