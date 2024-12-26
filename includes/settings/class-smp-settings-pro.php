<?php
/**
 * Adds a setting page for Pro stuff.
 *
 * @since   2.0.4
 *
 * @package SMP\Settings
 */

namespace SMP\Settings;

use SM_Settings_Page;
use SMP\Plugin;

/**
 * Class SMP_Settings_Pro
 *
 * @package SMP\Settings
 */
class SMP_Settings_Pro extends SM_Settings_Page {
	/**
	 * SM_Settings_Pro constructor.
	 */
	public function __construct() {
		$this->id    = 'pro';
		$this->label = __( 'Pro', 'sermon-manager-pro' );

		parent::__construct();

		
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {
		$settings = apply_filters( 'sm_pro_settings', array(
			array(
				'title' => __( 'Sermon Manager Pro', 'sermon-manager-pro' ),
				'type'  => 'title',
				'desc'  => '',
				'id'    => 'pro_settings',
			),
			array(
				'title'    => __( 'Blubrry PowerPress', 'sermon-manager-pro' ),
				'type'     => 'checkbox',
				'desc'     => __( 'Use Blubrry PowerPress player, instead of Sermon Manager\'s one.', 'sermon-manager-pro' ),
				'desc_tip' => __( 'This is like adding <code>[powerpress]</code> shortcode at the end, except that we do it for you. Default unchecked.', 'sermon-manager-pro' ),
				'id'       => 'blubrry_powerpress_player',
				'default'  => 'no',
			),
			array(
				'title'   => __( 'Update branch', 'sermon-manager-pro' ),
				'type'    => 'select',
				'id'      => 'update_branch',
				'options' => array(
					'release' => __( 'Release', 'sermon-manager-pro' ),
					'nightly' => __( 'Nightly', 'sermon-manager-pro' ),
				),
				'desc'    => 'This option allows you to select from what source you want to get your updates. Explanation of sources: <br><ul><li><strong>Release</strong> - The default update source. Plugin is updated roughly every week to the latest stable release.</li><li><strong>Nightly</strong> - Latest untested and unstable changes. Updates happen often.</li></ul>',
				'default' => 'release',
			),
			array(
				'type' => 'sectionend',
				'id'   => 'pro_settings',
			),
		) );

		return apply_filters( 'smp_get_settings_' . $this->id, $settings );
	}

	
}

return new SMP_Settings_Pro();
