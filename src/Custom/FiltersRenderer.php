<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

/**
 * Class FiltersRenderer.
 *
 * // TODO: Complete doc.
 */
class FiltersRenderer {

	public function __construct() {
		add_action( 'wp_footer', [ $this, 'filter_hooks_panel' ] );
		add_action( 'admin_footer', [ $this, 'filter_hooks_panel' ] );
	}

	public function filter_hooks_panel() {

		if ( $this->status !== 'show-filter-hooks' ) {
			return;
		}

		global $wp_filter, $wp_actions;
		?>

		<div  id="ash-dragable-hook-panel" class="ash-nested-hooks-block <?php echo ( 'show-filter-hooks' == $this->status ) ? esc_html( 'ash-active' ) : ''; ?> ">
			<div class="ash-show-hooks-icon-test">
				<!-- <i class="la la-exchange"></i> -->
				<span class="dashicons dashicons-leftright"></span>
			</div>
			<div class="ash-show-hooks-sub-div">
				<div class="ash-show-move-window">
					<span class="ash-show-move-text" aria-hidden="true"><span class="dashicons dashicons-move"></span> Move Window</span>
				</div>
				<?php
				foreach ( $this->all_hooks as $va_nested_value ) {
					if ( 'action' == $va_nested_value['type'] || 'filter' == $va_nested_value['type'] ) {
						$this->render_action( $va_nested_value );
					} else {
						?>
						<div class="ash-collection-divider">
							<?php echo esc_attr( $va_nested_value['ID'] ); ?>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}
