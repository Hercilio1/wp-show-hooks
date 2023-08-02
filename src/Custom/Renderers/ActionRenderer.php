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
		<span style="display:none;" class="ash-hook ash-hook-<?php echo esc_attr( $hook['type'] ); ?> <?php echo ( $nested_hooks ) ? esc_html( 'ash-hook-has-hooks' ) : ''; ?>" >
			<?php
			if ( 'action' === $hook['type'] ) {
				?>
				<span class="ash-hook-type ash-hook-type">A</span>
				<?php
			} elseif ( 'filter' === $hook['type'] ) {
				?>
				<span class="ash-hook-type ash-hook-type">F</span>
				<?php
			}
			// Main - Write the action hook name.
			echo esc_html( $hook['ID'] );
			// Write the count number if any function are hooked.
			if ( $nested_hooks_count ) {
				?>
				<span class="ash-hook-count">
					<?php echo esc_html( $nested_hooks_count ); ?>
				</span>
				<?php
			}
			// Write out list of all the function hooked to an action.
			if ( isset( $wp_filter[ $hook['ID'] ] ) ) :
				$nested_hooks = $wp_filter[ $hook['ID'] ];
				if ( $nested_hooks ) :
					?>
					<ul class="ash-hook-dropdown">
						<li class="ash-hook-heading">
							<?php
								$type = ucwords( esc_attr( $hook['type'] ) );
								$id   = esc_attr( $hook['ID'] );
								$url  = "https://codex.wordpress.org/Plugin_API/{$type}_Reference/{$id}";
								echo wp_kses_post( "<strong>{$type}:</strong> <a href='{$url}' target='_blank'>{$id}</a>" );
							?>
						</li>
						<?php
						foreach ( $nested_hooks as $nested_key => $nested_value ) :
							// Show the priority number if the following hooked functions.
							?>
							<li class="ash-priority">
								<span class="ash-priority-label">
									<strong>
										<?php
										echo esc_html( 'Priority:' );
										esc_html_e( 'Priority', 'another-show-hooks' );
										?>
									</strong>
									<?php echo esc_attr( $nested_key ); ?>
								</span>
							</li>
							<?php
							foreach ( $nested_value as $nested_inner_key => $nested_inner_value ) :
								// Show all teh functions hooked to this priority of this hook.
								?>
								<li>
									<?php
									if ( $nested_inner_value['function'] && is_array( $nested_inner_value['function'] ) && count( $nested_inner_value['function'] ) > 1 ) :

										// Hooked function ( of type object->method() ).
										?>
										<span class="ash-function-string">
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
										<?php
									else :
										// Hooked function ( of type function() ).
										?>
										<span class="ash-function-string">
											<?php echo esc_attr( $nested_inner_key ); ?>
										</span>
										<?php
									endif;
									?>
								</li>
								<?php
							endforeach;
						endforeach;
						?>
					</ul>
					<?php
				endif;
			endif;
			?>
		</span>
		<?php
	}
}
