<?php
/**
 * Podcasting related functions.
 *
 * @since   1.0.0-beta.5
 * @package SMP\Podcasting
 */

defined( 'ABSPATH' ) or exit;

/**
 * Sets the settings that are used in Podcasting screen.
 *
 * @return array The settings.
 *
 * @since 1.0.0-beta.5
 */
function smp_podcasting_set_settings() {
	global $post;

	$settings = array(
		array(
			'type' => 'title',
			'id'   => 'podcast_settings',
		),
		array(
			'title'       => __( 'Podcast Title', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'title',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Description', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'description',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Website Link', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'website_link',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Language', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'language',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Copyright', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'copyright',
			'placeholder' => '%parent%',
			// translators: %s: copyright symbol HTML entitiy (&copy;).
			'desc'        => wp_sprintf( esc_html__( 'Tip: Use %s to generate a copyright symbol.', 'sermon-manager-pro' ), '<code>' . htmlspecialchars( '&copy;' ) . '</code>' ),
		),
		array(
			'title'       => __( 'Webmaster Name', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'webmaster_name',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Webmaster Email', 'sermon-manager-pro' ),
			'type'        => 'email',
			'id'          => 'webmaster_email',
			'placeholder' => '%parent%',
		),
		array(
			'title'       => __( 'Author', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'itunes_author',
			'placeholder' => '%parent%',
			'desc'        => __( 'This will display at the &ldquo;Artist&rdquo; in the iTunes Store.', 'sermon-manager-pro' ),
		),
		array(
			'title'       => __( 'Subtitle', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'itunes_subtitle',
			'placeholder' => '%parent%',
			'desc'        => __( 'Your subtitle should briefly tell the listener what they can expect to hear.', 'sermon-manager-pro' ),
		),
		array(
			'title'       => __( 'Summary', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'itunes_summary',
			'placeholder' => '%parent%',
			'desc'        => __( 'Keep your Podcast Summary short, sweet and informative. Be sure to include a brief statement about your mission and in what region your audio content originates.', 'sermon-manager-pro' ),
		),
		array(
			'title'       => __( 'Owner Name', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'itunes_owner_name',
			'placeholder' => '%parent%',
			'desc'        => __( 'This should typically be the name of your Church.', 'sermon-manager-pro' ),
		),
		array(
			'title'       => __( 'Owner Email', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'itunes_owner_email',
			'placeholder' => '%parent%',
			'desc'        => __( 'Use an email address that you don&rsquo;t mind being made public. If someone wants to contact you regarding your Podcast this is the address they will use.', 'sermon-manager-pro' ),
		),
		array(
			'title'       => __( 'Cover Image', 'sermon-manager-pro' ),
			'type'        => 'image',
			'id'          => 'itunes_cover_image',
			'desc'        => __( 'This JPG will serve as the Podcast artwork in the iTunes Store. The image must be between 1,400px by 1,400px and 3,000px by 3,000px or else iTunes will not accept your feed.', 'sermon-manager-pro' ),
			'placeholder' => '%parent%',
		),
		array(
			'title'   => __( 'Category 1', 'sermon-manager-pro' ),
			'type'    => 'select',
			'id'      => 'itunes_category_1',
			'options' => 'smp_get_itunes_categories',
			'desc'    => 'This is the primary podcast category. It is usually "Religion & Spirituality".',
		),
		array(
			'title'      => 'Category 1 sub-category',
			'type'       => 'select',
			'id'         => 'itunes_category_1_subcategory',
			'desc'       => __( 'Required.', 'sermon-manager-pro' ),
			'ajax'       => true,
			'options'    => array(
				'' => 'Loading...',
			),
			'display_if' => array(
				'id'     => 'podcast_itunes_category_1',
				'!value' => '',
			),
		),
		array(
			'title'      => __( 'Category 2', 'sermon-manager-pro' ),
			'type'       => 'select',
			'id'         => 'itunes_category_2',
			'options'    => 'smp_get_itunes_categories',
			'desc'       => __( 'Optional.', 'sermon-manager-pro' ),
			'display_if' => array(
				'id'     => 'podcast_itunes_category_1',
				'!value' => '',
			),
		),
		array(
			'title'      => 'Category 2 sub-category',
			'type'       => 'select',
			'id'         => 'itunes_category_2_subcategory',
			'desc'       => __( 'Required.', 'sermon-manager-pro' ),
			'ajax'       => true,
			'options'    => array(
				'' => 'Loading...',
			),
			'display_if' => array(
				'id'     => 'podcast_itunes_category_2',
				'!value' => '',
			),
		),
		array(
			'title'      => __( 'Category 3', 'sermon-manager-pro' ),
			'type'       => 'select',
			'id'         => 'itunes_category_3',
			'options'    => 'smp_get_itunes_categories',
			'desc'       => __( 'Optional.', 'sermon-manager-pro' ),
			'display_if' => array(
				'id'     => 'podcast_itunes_category_2',
				'!value' => '',
			),
		),
		array(
			'title'      => 'Category 3 sub-category',
			'type'       => 'select',
			'id'         => 'itunes_category_3_subcategory',
			'desc'       => __( 'Required.', 'sermon-manager-pro' ),
			'ajax'       => true,
			'options'    => array(
				'' => 'Loading...',
			),
			'display_if' => array(
				'id'     => 'podcast_itunes_category_3',
				'!value' => '',
			),
		),
		array(
			'title'    => __( 'PodTrac Tracking', 'sermon-manager-pro' ),
			'type'     => 'checkbox',
			'id'       => 'podtrac',
			'desc'     => __( 'Enables PodTrac tracking.', 'sermon-manager-pro' ),
			// translators: %s <a href="http://podtrac.com">podtrac.com</a>.
			'desc_tip' => wp_sprintf( __( 'For more info on PodTrac or to sign up for an account, visit %s', 'sermon-manager-pro' ), '<a href="http://podtrac.com">podtrac.com</a>' ),
			'default'  => 'no',
		),
		array(
			'title'    => __( 'HTML in description', 'sermon-manager-pro' ),
			'type'     => 'checkbox',
			'id'       => 'enable_podcast_html_description',
			'desc'     => __( 'Enables showing of HTML in iTunes description field. Uncheck if description looks messy.', 'sermon-manager-pro' ),
			'desc_tip' => __( 'It is recommended to leave it unchecked. Uncheck if the feed does not validate.', 'sermon-manager-pro' ),
			'default'  => 'no',
		),
		array(
			'title'       => __( 'Number of podcasts to show', 'sermon-manager-pro' ),
			'type'        => 'number',
			'id'          => 'podcasts_per_page',
			'placeholder' => '%parent%',
		),
		array(
			'title'    => __( 'Sermon Image', 'sermon-manager-pro' ),
			'type'     => 'checkbox',
			'id'       => 'podcast_sermon_image_series',
			'desc'     => __( 'Fallback to series image if sermon does not have its own image.', 'sermon-manager-pro' ),
			'desc_tip' => __( 'Default disabled.', 'sermon-manager-pro' ),
			'default'  => 'no',
		),
		array(
			'type' => 'sectionend',
			'id'   => 'podcast_settings',
		),
	);

	// If there is no default.
	$wordpress_settings = array(
		'podcasts_per_page'  => get_option( 'posts_per_rss' ),
		'title'              => get_bloginfo( 'name' ),
		'description'        => get_bloginfo( 'description' ),
		'website_link'       => home_url(),
		'language'           => get_bloginfo( 'language' ),
		// translators: %s: The website name.
		'copyright'          => wp_sprintf( __( 'Copyright &copy; %s', 'sermon-manager-pro' ), get_bloginfo( 'name' ) ),
		'webmaster_name'     => __( 'e.g. Your Name', 'sermon-manager-pro' ),
		'webmaster_email'    => __( 'e.g. Your Email', 'sermon-manager-pro' ),
		'itunes_author'      => __( 'e.g. Primary Speaker or Church Name', 'sermon-manager-pro' ),
		// translators: %s: The website name.
		'itunes_subtitle'    => wp_sprintf( __( 'e.g. Preaching and teaching audio from %s', 'sermon-manager-pro' ), get_bloginfo( 'name' ) ),
		// translators: %s: The website name.
		'itunes_summary'     => wp_sprintf( __( 'e.g. Weekly teaching audio brought to you by %s in City, State.', 'sermon-manager-pro' ), get_bloginfo( 'name' ) ),
		'itunes_owner_name'  => get_bloginfo( 'name' ),
		'itunes_owner_email' => __( 'e.g. Your Email', 'sermon-manager-pro' ),
	);

	// Add more settings for the default podcast.
	if ( \SMP\Plugin::instance()->podcasting_manager->get_default_podcast_id() === (int) $post->ID ) {
		unset( $settings[ count( $settings ) - 1 ] );

		/* $settings[] = array(
			'title'       => __( 'iTunes Podcast URL', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'podcast_url_itunes',
			'placeholder' => 'pcast://itunes.apple.com/us/podcast/…/id…',
			'desc'        => 'URL to use for the iTunes link in the <code>[list_podcasts]</code> shortcode. Change “https” to “pcast” to make the link open directly into the Apple Podcasts app. Shortcode key to include/exclude: <code>itunes</code>.',
			'desc_tip'    => 'Leave empty to disable.',
		);
		$settings[] = array(
			'title'       => __( 'Android Podcast URL', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'podcast_url_android',
			'placeholder' => 'https://subscribeonandroid.com/' . str_replace( 'https://', '', get_site_url( null, '?feed=rss2&post_type=wpfc_sermon', 'https' ) ),
			'desc'        => 'URL to use for the Android link in the <code>[list_podcasts]</code> shortcode. Shortcode key to include/exclude: <code>android</code>.',
			'desc_tip'    => 'Leave empty to disable.',
		);
		$settings[] = array(
			'title'       => __( 'Overcast Podcast URL', 'sermon-manager-pro' ),
			'type'        => 'text',
			'id'          => 'podcast_url_overcast',
			'placeholder' => 'https://overcast.fm/…',
			'desc'        => 'URL to use for the Overcast link in the <code>[list_podcasts]</code> shortcode.  Shortcode key to include/exclude: <code>overcast</code>.',
			'desc_tip'    => 'Leave empty to disable.',
		); */
		$settings[] = array(
			'title'   => __( 'Sermons to show', 'sermon-manager-pro' ),
			'type'    => 'select',
			'id'      => 'sermons_to_show',
			'options' => array(
				''               => __( 'Audio sermons only', 'sermon-manager-pro' ),
				'video'          => __( 'Video sermons only', 'sermon-manager-pro' ),
				'audio_priority' => __( 'Audio sermons priority', 'sermon-manager-pro' ),
				'video_priority' => __( 'Video sermons priority', 'sermon-manager-pro' ),
			),
			'desc'    => __( 'This field turn on the video playing in podcast instead of audio.', 'sermon-manager-pro' ),
		);
		$settings[] = array(
			'type' => 'sectionend',
			'id'   => 'podcast_settings',
		);
	}

	foreach ( $settings as &$setting ) {
		if ( isset( $setting['placeholder'] ) && '%parent%' === $setting['placeholder'] ) {
			$setting['placeholder'] = SermonManager::getOption( substr( $setting['id'], 8 ) );

			if ( ! $setting['placeholder'] && isset( $wordpress_settings[ $setting['id'] ] ) ) {
				$setting['placeholder'] = $wordpress_settings[ $setting['id'] ];
			}
		}
	}

	return $settings;
}

add_filter( 'sm_pro_get_podcasting_settings', 'smp_podcasting_set_settings' );
