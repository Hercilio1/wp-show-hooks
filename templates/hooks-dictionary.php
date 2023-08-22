<?php
/**
 * Implemented by Hercilio M. Ortiz (https://github.com/Hercilio1).
 *
 * @package WP_Show_Hooks
 */

list(
	'hooks_list' => $hooks_list,
) = wp_parse_args(
	$args,
	[
		'hooks_list' => [],
	]
);

?>

<div id="wp-show-hooks">
	<div class="container-modal">
		<div class="sidebar-modal">
			<div class="heading">
				<p class="section-title">Hooks list</p>
				<span class="close" id="closeModalBtn">&times;</span>
			</div>
			<div class="hooks-list">
				<?php foreach ( $hooks_list as $hook ) : ?>
					<div>
						<span><?php echo esc_html( $hook['ID'] ); ?></span>
						<ul class="hooks-details">
							<?php foreach ( $hook['nested_hooks_data'] as $callbacks ) : ?>
								<li><span><?php echo esc_html( $callbacks ); ?></span>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
