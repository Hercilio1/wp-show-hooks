<?php

class Another_Show_Hooks {
	private $status;
	private $all_hooks    = [];
	private $recent_hooks = [];
	private $ignore_hooks = [];
	private $doing        = 'collect';

	function init() {

		// Use this to set any tags known to cause display problems.
		// Will be display in sidebar.
		$this->ignore_hooks = apply_filters(
			'ash_show_hooks_ignore_hooks',
			[
				'attribute_escape',
				'body_class',
				'the_post',
				'post_edit_form_tag',
			// 'gettext',
			]
		);

		// Attach the hooks as on plugin init.
		$this->attach_hooks();
		// Init the plugin.
		add_action( 'init', [ $this, 'plugin_init' ] );
	}

	/**
	 * Helper function to attach the filter that render all the hook labels.
	 */
	public function attach_hooks() {
		// Status = active (show-action-hooks ou show-filter-hooks):
		// - Attach HooksCrawler.
		// - Attach BackDoorSwitchRenderer.
		// - Attach FiltersRenderer.
	}

	/**
	 * Helper function to detach the filter that render all the hook labels.
	 */
	public function detach_hooks() {
		// Status = active (show-action-hooks ou show-filter-hooks):
		// - Detach HooksCrawler.
		// - Detach BackDoorSwitchRenderer.
		// - Detach FiltersRenderer.
	}

	public function plugin_active() {
		// - Enqueue scripts.
		// - Load Admin Bar.
		// - Print pre-templates hooks.
		// -- From now one doing = 'write'.
	}
}
