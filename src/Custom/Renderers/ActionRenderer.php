<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom\Renderers;

/**
 * Class ActionRenderer. Renders the actions "views".
 */
class ActionRenderer {

	public static function render( array $hook ) : void {
		global $wp_filter;
		// Get all the nested hooks.
		$nested_hooks = ( isset( $wp_filter[ $hook['ID'] ] ) ) ? $wp_filter[ $hook['ID'] ] : false;
		// Count the number of functions on this hook.
		$nested_hooks_count = 0;
		if ( $nested_hooks ) {
			foreach ( $nested_hooks as $value ) {
				$nested_hooks_count += count( $value );
			}
		}
		?>
		<span style="display:none;" class="wpsh-hook wpsh-hook-<?php echo esc_attr( $hook['type'] ); ?> <?php echo ( $nested_hooks ) ? esc_html( 'wpsh-hook-has-hooks' ) : ''; ?>" >
			<span class="wpsh-hook-container">
				<?php
				if ( 'action' === $hook['type'] ) {
					?>
					<span class="wpsh-hook-type wpsh-hook-type">A</span>
					<?php
				} elseif ( 'filter' === $hook['type'] ) {
					?>
					<span class="wpsh-hook-type wpsh-hook-type">F</span>
					<?php
				}
				// Main - Write the action hook name.
				?>
				<span class="wpsh-hook-label"><?php echo esc_html( $hook['ID'] ); ?></span>
			</span>
			<?php
			// Write the count number if any function are hooked.
			if ( $nested_hooks_count ) {
				?>
				<span class="wpsh-hook-count">
					<?php echo esc_html( $nested_hooks_count ); ?>
				</span>
				<?php
			}
			// Write out list of all the function hooked to an action.
			?>
			<div class="wpsh-hook-dropdown">
				<div class="wpsh-hook-dropdown-offset"></div>
				<div class="wpsh-hook-dropdown-heading">
					<?php
						$type = ucwords( esc_attr( $hook['type'] ) );
						$id   = esc_attr( $hook['ID'] );
						// TODO: Mover para outro lugar.
						$url = "https://codex.wordpress.org/Plugin_API/{$type}_Reference/{$id}";
						echo wp_kses_post( "<strong>{$type}:</strong> {$id}" );
					?>
				</div>
				<?php
				if ( isset( $wp_filter[ $hook['ID'] ] ) ) :
					$nested_hooks = $wp_filter[ $hook['ID'] ];
					if ( $nested_hooks ) :
						?>
						<ul class="wpsh-hook-dropdown-body">
							<?php foreach ( $nested_hooks as $nested_key => $nested_value ) : ?>
								<?php // Show the priority number if the following hooked functions. ?>
								<li class="wpsh-priority">
									<span class="wpsh-priority-label">
										<strong>
											<?php
											echo esc_html( 'Priority:' );
											esc_html_e( 'Priority', 'another-show-hooks' );
											?>
										</strong>
										<?php echo esc_attr( $nested_key ); ?>
									</span>
								</li>
								<?php foreach ( $nested_value as $nested_inner_key => $nested_inner_value ) : ?>
									<?php // Show all teh functions hooked to this priority of this hook. ?>
									<li>
										<?php if ( $nested_inner_value['function'] && is_array( $nested_inner_value['function'] ) && count( $nested_inner_value['function'] ) > 1 ) : ?>
											<span class="wpsh-function-string">
												<?php
												$classname = false;
												if ( is_object( $nested_inner_value['function'][0] ) || is_string( $nested_inner_value['function'][0] ) ) {
													if ( is_object( $nested_inner_value['function'][0] ) ) {
														$classname = get_class( $nested_inner_value['function'][0] );
													}
													if ( is_string( $nested_inner_value['function'][0] ) ) {
														$classname = $nested_inner_value['function'][0];
													}
													if ( $classname ) {
														?>
														<?php echo esc_attr( $classname ); ?>&ndash;&gt;
														<?php
													}
												}
												?>
												<?php echo esc_attr( $nested_inner_value['function'][1] ); ?>
											</span>
										<?php else : ?>
											<span class="wpsh-function-string">
												<?php echo esc_attr( $nested_inner_key ); ?>
											</span>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</span>
		<?php
	}
}
