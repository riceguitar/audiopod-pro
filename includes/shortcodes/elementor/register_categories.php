<?php
/**
 * This file register categories for Elementor.
 *
 * @since   2.0.4
 * @package SMP\Shortcodes
 */

// Register category.
add_action(
	'Elementor\Core\Common\Modules\Finder',
	function ( $elements_manager ) {
		$elements_manager->register(
			'sermon-manager-pro-elements',
			array(
				'title' => __( 'Sermon Manager Pro Elements', 'sermon-manager-pro' ),
				'icon'  => 'fa fa-plug',
			)
		);

		$elements_manager->register(
			'sermon-manager-pro-theme-elements',
			array(
				'title' => __( 'Sermon Manager Pro Theme Elements', 'sermon-manager-pro' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}
);
