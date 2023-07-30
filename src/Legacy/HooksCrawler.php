<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

namespace WPShowHooks\Custom;

/**
 * Class HooksCrawler.
 *
 * // TODO: Complete doc.
 */
class HooksCrawler {

	private array $all_hooks;
	private array $recent_hooks;
	private array $hooks_to_ignore;

	public function __construct() {
		add_action( 'all', [ $this, 'hook_all_hooks' ], 100 );
	}

	public function hook_all_hooks( $hook ) {
		global $wp_actions, $wp_filter;
		if ( ! in_array( $hook, $this->recent_hooks, true ) ) {
			if ( isset( $wp_actions[ $hook ] ) ) {
				// Action.
				$this->all_hooks[] = [
					'ID'       => $hook,
					'callback' => false,
					'type'     => 'action',
				];
			} else {
				// Filter.
				$this->all_hooks[] = [
					'ID'       => $hook,
					'callback' => false,
					'type'     => 'filter',
				];
			}
		}
		// TODO: Consider to remove recent hooks control.
		if ( isset( $wp_actions[ $hook ] ) && ! in_array( $hook, $this->recent_hooks ) && ! in_array( $hook, $this->hooks_to_ignore ) ) {
			if ( 'write' === $this->doing ) {
				$this->render_action( end( $this->all_hooks ) );
			}
		}

		// Discarded functionality: if the hook was
		// run recently then don't show it again.
		// Better to use the once run or always run theory.
		$this->recent_hooks[] = $hook;

		// TODO: Consider to remove the following offset control.
		if ( count( $this->recent_hooks ) > 100 ) {
			array_shift( $this->recent_hooks );
		}
	}

	private function render_action( $args = [] ) {
		global $wp_filter;
		// Get all the nested hooks.
		$nested_hooks = ( isset( $wp_filter[ $args['ID'] ] ) ) ? $wp_filter[ $args['ID'] ] : false;
		// Count the number of functions on this hook.
		$nested_hooks_count = 0;
		if ( $nested_hooks ) {
			foreach ( $nested_hooks as $key => $value ) {
				$nested_hooks_count += count( $value );
			}
		}
		?>
		<span style="display:none;" class="ash-hook ash-hook-<?php echo esc_attr( $args['type'] ); ?> <?php echo ( $nested_hooks ) ? esc_html( 'ash-hook-has-hooks' ) : ''; ?>" >
			<?php
			if ( 'action' === $args['type'] ) {
				?>
				<span class="ash-hook-type ash-hook-type">A</span>
				<?php
			} elseif ( 'filter' === $args['type'] ) {
				?>
				<span class="ash-hook-type ash-hook-type">F</span>
				<?php
			}
			// Main - Write the action hook name.
			echo esc_html( $args['ID'] );
			// Write the count number if any function are hooked.
			if ( $nested_hooks_count ) {
				?>
				<span class="ash-hook-count">
					<?php echo esc_html( $nested_hooks_count ); ?>
				</span>
				<?php
			}
			// Write out list of all the function hooked to an action.
			if ( isset( $wp_filter[ $args['ID'] ] ) ) :
				$nested_hooks = $wp_filter[ $args['ID'] ];
				if ( $nested_hooks ) :
					?>
					<ul class="ash-hook-dropdown">
						<li class="ash-hook-heading">
							<?php
								$type = ucwords( esc_attr( $args['type'] ) );
								$id   = esc_attr( $args['ID'] );
								$url  = "https://codex.wordpress.org/Plugin_API/{$type}_Reference/{$id}";
								echo "<strong>{$type}:</strong> <a href='{$url}' target='_blank'>{$id}</a>";
							?>
						</li>
						<?php
						foreach ( $nested_hooks as $nested_key => $nested_value ) :
							// Show the priority number if the following hooked functions.
							?>
							<li class="ash-priority">
								<span class="ash-priority-label"><strong><?php echo esc_html( 'Priority:' ); /* _e('Priority', 'another-show-hooks') */ ?></strong> <?php echo esc_attr( $nested_key ); ?></span>
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
