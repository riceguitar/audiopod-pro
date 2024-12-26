<?php
function sermons_blog_layout_render_sermons_grid( $attributes ){
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	
	$recent_posts = array(
		'post_type'      => $attributes['post_type'],
		'posts_per_page' => $attributes['postscount'],
		'post_status'    => $attributes['post_type'] === 'attachment' ? 'inherit' : 'publish',
		'order'          => $attributes['order'],
		'orderby'        => $attributes['orderBy'],
		'category'       => isset($attributes['categories']) ? $attributes['categories'] : '',
		'paged'          => $paged,
		);
	
	$recent_posts = apply_filters('smp/shortcodes/gutrenberg/sermon_query', smp_add_taxonomy_to_query( $recent_posts ));
	
	ob_start();

	if ( count( $recent_posts ) === 0 ) {
		return;
	}
		
	global $paged;
	if ( empty( $paged ) ) {
		$paged = 1;
	}

	$count_posts      = wp_count_posts( 'wpfc_sermon' );
	$published_posts  = $count_posts->publish;
	$total_posts      = ceil( $published_posts / $attributes['postscount'] );
	$total_pagination = min( $total_posts, $attributes['paginationTotalPages'] );

	$pagination_args = array(
		'base'         => get_pagenum_link( 1 ) . '%_%',
		'format'       => '?paged=%#%',
		'total'        => $total_pagination,
		'current'      => $paged,
		'show_all'     => true,
		'end_size'     => 1,
		'prev_text'    => $attributes['previousLabel'],
		'next_text'    => $attributes['nextLabel'],
		'type'         => 'plain',
		'add_args'     => false,
		'add_fragment' => '',
	);

	if ( $attributes['displayPrevNext'] ) {
		$pagination_args['prev_next'] = true;
	} else {
		$pagination_args['prev_next'] = false;
	}

	$gridViewWrapper = $attributes['postLayout'] === 'list' ? 'wp-block-sermons-blog-layout-sermons-grid sermons-grid-view gpl-d-flex gpl-flex-wrap list-layout' : 'wp-block-sermons-blog-layout-sermons-grid sermons-grid-view gpl-d-flex gpl-flex-wrap';
	
	echo '<div class="' . esc_attr( $gridViewWrapper ) . ' ' . $attributes['gridLayoutStyle'] . '" style="--item-padding-left-right : ' . $attributes['columnGap'] . 'px; --item-margin-bottom : ' . ($attributes['columnGap']*2) . 'px; --item-height : ' . (300-$attributes['columnGap']) . 'px">';
	
	if ( isset( $attributes['displayFilters'] ) && $attributes['displayFilters'] ) {
		$content = render_wpfc_sorting(
				array(
					'hide_topics'        => $attributes['displayFilterTopics'] ? false : 'yes',
					'hide_series'        => $attributes['displayFilterSeries'] ? false : 'yes',
					'hide_preachers'     => $attributes['displayFilterPreacher'] ? false : 'yes',
					'hide_books'         => $attributes['displayFilterBook'] ? false : 'yes',
					'hide_service_types' => $attributes['displayFilterServiceType'] ? false : 'yes',
					'hide_dates'         => $attributes['displayFilterDates'] ? false : 'yes',
					'classes'            => 'no-spacing',
				)
			);
			echo $content;
	}
	
	$parentClasses = 'sm-inner-grid gpl-column-12 gpl-d-flex gpl-flex-wrap';
	
	$parentClasses = $attributes['displayMasonry']  ? $parentClasses . ' masonry-layout' : $parentClasses;
	
	$masonryLayout = $attributes['displayMasonry']  ? ' data-masonry=\'{ "gutter": 0 }\' ' : '';
	
	$equalHeight = $attributes['equalHeight'] && !$attributes['displayMasonry'] ? ' equal-height' : '';
	
	echo '<div class="' . esc_attr($parentClasses) . '" ' . $masonryLayout . '>';	
	
	    $the_query = new WP_Query( $recent_posts );
		
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post(); 
				$gridView = $attributes['postLayout'] === 'grid' ? 'post-item wpfc-sermon gpl-mb-30 gpl-column-' . $attributes['columns'] . '' : 'post-item gpl-mb-30 wpfc-sermon';
				echo '<article id="post-' . get_the_ID() . '" class="' . esc_attr( $gridView ) . ' ' . $attributes['gridLayoutStyle'] . ' ' . join(' ', get_post_class( )). '">'; 
				echo '<div class="wpfc-sermon-inner ' . $attributes['align'] . $equalHeight . ' image-position-' . $attributes['imagePosition'] . '">'; ?>
						<?php if ( $attributes['displaySermonFeaturedType'] ) : ?>
							<?php if ( 'image' == $attributes['featuredType'] ) : ?>
								<div class="wpfc-sermon-image">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo get_sermon_image_url( true ); ?>"
												alt="<?php the_title(); ?>">
										<div class="wpfc-sermon-image-img" <?php echo 'style="background-image: url(' . get_sermon_image_url( true ) . ')"'; ?>>
										</div>
									</a>
								</div>
							<?php endif; ?>
							<?php if ( 'video' == $attributes['featuredType'] ) : ?>
								<?php if ( get_wpfc_sermon_meta( 'sermon_video_link' ) ) : ?>
									<div class="wpfc-sermon-video wpfc-sermon-video-link">
										<?php echo wpfc_render_video( get_wpfc_sermon_meta( 'sermon_video_link' ) ); ?>
									</div>
								<?php endif; ?>
								<?php if ( get_wpfc_sermon_meta( 'sermon_video' ) ) : ?>
									<div class="wpfc-sermon-video wpfc-sermon-video-embed">
										<?php echo do_shortcode( get_wpfc_sermon_meta( 'sermon_video' ) ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						<?php endif; ?>
						<div class="wpfc-sermon-main <?php echo get_sermon_image_url() ? '' : 'no-image'; ?>">
							<div class="wpfc-sermon-header">
								<div class="wpfc-sermon-header-main">
									<?php if ( has_term( '', 'wpfc_sermon_series', get_the_ID() ) and ( $attributes['displaySermonSeries'] ) ) : ?>
										<div class="wpfc-sermon-meta-item wpfc-sermon-meta-series">
											<?php the_terms( get_the_ID(), 'wpfc_sermon_series' ); ?>
										</div>
									<?php endif; ?>
									<?php if ( $attributes['displayTitle'] ) : ?>
									<h3 class="wpfc-sermon-title" <?php echo 'style="padding-bottom:' . $attributes['titlePadding'] . 'px;"'; ?>>
										<a class="wpfc-sermon-title-text"
											href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php endif; ?>
									<?php if ( $attributes['displaySermonDate'] ) : ?>
										<div class="wpfc-sermon-meta-item wpfc-sermon-meta-date">
											<?php if (\SermonManager::getOption( 'use_published_date' ) ) : ?>
												<?php the_date(  ); ?>
											<?php else : ?>
												<?php echo \SM_Dates::get(  ); ?>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="wpfc-sermon-description">
								<?php if ( $attributes['displaySermonDescription'] ) : ?>
									<div class="sermon-description-content" <?php echo 'style="padding-bottom:' . $attributes['descriptionPadding'] . 'px;"'; ?>>
										<?php if ( has_excerpt() ) : ?>
											<?php echo get_the_excerpt(); ?>
										<?php else : ?>
											<?php echo wp_trim_words(the_content(), 30 ); ?>
										<?php endif; ?>
									</div>
									<?php if ( ( str_word_count( the_content() ) > 30 ) && ( $attributes['displaySermonReadMoreButton'] ) ) : ?>
										<div class="wpfc-sermon-description-read-more">
											<a href="<?php echo get_permalink(); ?>"><?php echo $attributes['postReadMoreButtonText']; ?></a>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							<?php if ( ( $attributes['displaySermonAudio'] ) && ( get_wpfc_sermon_meta( 'sermon_audio' ) || get_wpfc_sermon_meta( 'sermon_audio_id' ) ) ) : ?>
								<?php
								$sermon_audio_id     = get_wpfc_sermon_meta( 'sermon_audio_id' );
								$sermon_audio_url_wp = $sermon_audio_id ? wp_get_attachment_url( intval( $sermon_audio_id ) ) : false;
								$sermon_audio_url    = $sermon_audio_id && $sermon_audio_url_wp ? $sermon_audio_url_wp : get_wpfc_sermon_meta( 'sermon_audio' );
								?>
								<div class="wpfc-sermon-audio">
									<?php echo wpfc_render_audio( $sermon_audio_url ); ?>
								</div>
							<?php endif; ?>
							<?php if ( ( ( $attributes['displaySermonPreacher'] ) && ( has_term( '', 'wpfc_preacher', get_the_ID() ) ) ) || ( ( $attributes['displaySermonBiblePassage'] ) && ( get_wpfc_sermon_meta( 'bible_passage' ) ) ) || ( ( $attributes['displaySermonServiceType'] ) && ( has_term( '', 'wpfc_service_type', get_the_ID() ) ) ) ) : ?>
								<div class="wpfc-sermon-footer">
									<?php if ( ( $attributes['displaySermonPreacher'] ) && ( has_term( '', 'wpfc_preacher', get_the_ID() ) ) ) : ?>
										<div class="wpfc-sermon-meta-item wpfc-sermon-meta-preacher">
											<?php
											echo apply_filters( 'sermon-images-list-the-terms', '', // phpcs:ignore
												array(
													'taxonomy'     => 'wpfc_preacher', // phpcs:ignore
													'after'        => '', // phpcs:ignore
													'after_image'  => '', // phpcs:ignore
													'before'       => '', // phpcs:ignore
													'before_image' => '', // phpcs:ignore
												)
											);
											?>
											<span class="wpfc-sermon-meta-prefix"><?php echo __( 'Preacher', 'sermon-manager-for-wordpress' ); ?>
												:</span>
											<span class="wpfc-sermon-meta-text"><?php the_terms( get_the_ID(), 'wpfc_preacher' ); ?></span>
										</div>
									<?php endif; ?>
									<?php if ( ( $attributes['displaySermonBiblePassage'] ) && ( get_wpfc_sermon_meta( 'bible_passage' ) ) ) : ?>
										<div class="wpfc-sermon-meta-item wpfc-sermon-meta-passage">
											<span class="wpfc-sermon-meta-prefix"><?php echo __( 'Passage', 'sermon-manager-for-wordpress' ); ?>
												:</span>
											<span class="wpfc-sermon-meta-text"><?php wpfc_sermon_meta( 'bible_passage' ); ?></span>
										</div>
									<?php endif; ?>
									<?php if ( ( $attributes['displaySermonServiceType'] ) && ( has_term( '', 'wpfc_service_type', get_the_ID() ) ) ) : ?>
										<div class="wpfc-sermon-meta-item wpfc-sermon-meta-service">
											<span class="wpfc-sermon-meta-prefix"><?php echo __( 'Service Type', 'sermon-manager-for-wordpress' ); ?>
												:</span>
											<span class="wpfc-sermon-meta-text"><?php the_terms( get_the_ID(), 'wpfc_service_type' ); ?></span>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</article>

				<?php
			}
	
		}

		wp_reset_query();
		
	echo '</div>';
			
			$paginate_links = paginate_links( $pagination_args );
		    if ( ( $paginate_links ) && ( isset( $attributes['displayPagination'] ) ) && ( $attributes['displayPagination'] ) ) {
				?>
				<nav class="gutenberg-pagination custom-pagination" style="text-align:<?php echo $attributes['paginationAlignment']; ?>;">
					<p><?php echo $paginate_links; ?></p>
				</nav>
				<?php
			}
			
			echo '</div>';	

	$posts = ob_get_contents();

	ob_end_clean();

	return $posts;
}

function sermons_blog_layout_register_sermons_grid(){
	
	if( !function_exists('register_block_type') ){
		return;
	}

	register_block_type( 'sermons-blog-layout/sermons-grid', array(
		'attributes' => array(
			'align' => array(
				'type' => 'string',
				'default' => 'left',
			),
			'post_type' => array(
				'type' => 'string',
				'default' => 'wpfc_sermon'
			),
			'categories' => array(
				'type' => 'string',
			),
			'team_cats' => array(
				'type' => 'string',
			),
			'postscount' => array(
				'type' => 'number',
				'default' => 9,
			),
			'order' => array(
				'type' => 'string',
				'default' => 'desc',
			),
			'orderBy'  => array(
				'type' => 'string',
				'default' => 'date',
			),
			'columns' => array(
				'type' => 'number',
				'default' => 3
			),
			'imagePosition' => array(
				'type' => 'string',
				'default' => 'left'
			),
			'columnGap' => array(
				'type' => 'number',
				'default' => 15
			),
			'equalHeight' => array(
				'type' => 'boolen',
				'default' => false
			),
			'displayMasonry' => array(
				'type' => 'boolen',
				'default' => false
			),
			'postLayout' => array(
				'type' => 'string',
				'default' => 'grid',
			),
			'gridLayoutStyle' => array(
				'type' => 'string',
				'default' => 'sermon_skin',
			),
			'displayFilters' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterTopics' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterSeries' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterPreacher' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterBook' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterServiceType' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayFilterDates' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displaySermonFeaturedType' => array(
				'type' => 'boolen',
				'default' => true
			),
			'featuredType' => array(
				'type' => 'string',
				'default' => 'image',
			),
			'displaySermonSeries' => array(
				'type' => 'boolen',
				'default' => true
			),
			'displayTitle' => array(
				'type' => 'boolen',
				'default' => true
			),
			'titlePadding' => array(
				'type' => 'number',
				'default' => 0
			),
			'displaySermonDate' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displaySermonDescription' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'descriptionPadding' => array(
				'type' => 'number',
				'default' => 10
			),
			'displaySermonReadMoreButton' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'postReadMoreButtonText' => array(
				'type' => 'string',
				'default' => 'Read More',
			),
			'displaySermonAudio' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displaySermonPreacher' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displaySermonBiblePassage' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displaySermonServiceType' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'displayPagination' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'paginationTotalPages' => array(
				'type' => 'number',
				'default' => 5,
			),
			'displayPrevNext' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'previousLabel' => array(
				'type' => 'string',
				'default' => '« Previous',
			),
			'nextLabel' => array(
				'type' => 'string',
				'default' => 'Next »',
			),
			'paginationAlignment' => array(
				'type' => 'string',
				'default' => 'left',
			),
		),
		'render_callback' => 'sermons_blog_layout_render_sermons_grid',
	));
	
	
}
add_action( 'init', 'sermons_blog_layout_register_sermons_grid' );

/**
 * Create API fields for additional info
 */

function sermons_blog_layout_register_rest_fields(  ) {
	$post_types = get_post_types();
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_topics',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => false,
					'hide_series'        => 'yes',
					'hide_preachers'     => 'yes',
					'hide_books'         => 'yes',
					'hide_service_types' => 'yes',
					'hide_dates'         => 'yes',
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Topics', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_series',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => 'yes',
					'hide_series'        => false,
					'hide_preachers'     => 'yes',
					'hide_books'         => 'yes',
					'hide_service_types' => 'yes',
					'hide_dates'         => 'yes',
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Series', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_preachers',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => 'yes',
					'hide_series'        => 'yes',
					'hide_preachers'     => false,
					'hide_books'         => 'yes',
					'hide_service_types' => 'yes',
					'hide_dates'         => 'yes',
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Preachers', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_books',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => 'yes',
					'hide_series'        => 'yes',
					'hide_preachers'     => 'yes',
					'hide_books'         => false,
					'hide_service_types' => 'yes',
					'hide_dates'         => 'yes',
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Books', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_service_types',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => 'yes',
					'hide_series'        => 'yes',
					'hide_preachers'     => 'yes',
					'hide_books'         => 'yes',
					'hide_service_types' => false,
					'hide_dates'         => 'yes',
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Service Types', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_filters_dates',
		array(
			'get_callback' => function() { return render_wpfc_sorting(
				array(
					'hide_topics'        => 'yes',
					'hide_series'        => 'yes',
					'hide_preachers'     => 'yes',
					'hide_books'         => 'yes',
					'hide_service_types' => 'yes',
					'hide_dates'         => false,
					'classes'            => 'no-spacing',
				)
			); },
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Filters Dates', 'sermons-blog-layout'),
				'type' => 'string'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_image_url',
		array(
			'get_callback' => 'get_sermons_blog_image_url',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Image Url', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_video',
		array(
			'get_callback' => 'get_sermons_blog_video',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Video', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_series',
		array(
			'get_callback' => 'get_sermons_blog_series',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Series', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_meta_sermon_description',
		array(
			'get_callback' => 'get_sermons_blog_meta_sermon_description',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Description', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	
	register_rest_field(
		$post_types,
		'sermons_blog_show_readmore',
		array(
			'get_callback' => 'get_sermons_blog_show_readmore',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Shoe Read More', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_audio',
		array(
			'get_callback' => 'get_sermons_blog_audio',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Series Audio', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_preacher_image',
		array(
			'get_callback' => 'get_sermons_blog_preacher_image',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Series Preacher Image', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_preacher',
		array(
			'get_callback' => 'get_sermons_blog_preacher',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Preacher', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_bible_passage',
		array(
			'get_callback' => 'get_sermons_blog_bible_passage',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Bible Passage', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
	register_rest_field(
		$post_types,
		'sermons_blog_service_type',
		array(
			'get_callback' => 'get_sermons_blog_service_type',
			'update_callback' => null,
			'schema' => array(
				'description' => __( 'Sermon Service Type', 'sermons-blog-layout'),
				'type' => 'array'
			)
		)
	);
	
}

add_action('rest_api_init', 'sermons_blog_layout_register_rest_fields');

function get_sermons_blog_image_url () {
		
	return 	get_sermon_image_url( true );
	
}

function get_sermons_blog_video () {
		
	return 	wpfc_render_video( get_wpfc_sermon_meta( 'sermon_video_link' ) );
	
}

function get_sermons_blog_series () {
	$sermon_series = get_the_term_list( get_the_ID(), 'wpfc_sermon_series' );
	
	if ( is_wp_error( $sermon_series ) )
        return false;
   
    return apply_filters( 'the_terms', $sermon_series, 'wpfc_sermon_series' );	
	
}

function get_sermons_blog_meta_sermon_description() {
		
	return 	wp_trim_words( get_the_content(), 30 );	
	
}

function get_sermons_blog_show_readmore() {
	if  ( str_word_count( get_the_content() ) > 30 )	{
		return true;
	} else {
		return false;
	}
	
}

function get_sermons_blog_audio () {
	$sermon_audio_id = get_wpfc_sermon_meta( 'sermon_audio_id' );
	$sermon_audio_url_wp = $sermon_audio_id ? wp_get_attachment_url( intval( $sermon_audio_id ) ) : false;
	$sermon_audio_url    = $sermon_audio_id && $sermon_audio_url_wp ? $sermon_audio_url_wp : get_wpfc_sermon_meta( 'sermon_audio' );
		
	return 	wpfc_render_audio( $sermon_audio_url );	
	
}

function get_sermons_blog_preacher_image () {
	$sermon_preacher_image = apply_filters( 'sermon-images-list-the-terms', '', // phpcs:ignore
					array(
						'taxonomy'     => 'wpfc_preacher', // phpcs:ignore
						'after'        => '', // phpcs:ignore
						'after_image'  => '', // phpcs:ignore
						'before'       => '', // phpcs:ignore
						'before_image' => '', // phpcs:ignore
						)
				);
		
	return 	$sermon_preacher_image;	
	
}

function get_sermons_blog_preacher () {
	$sermon_preacher = get_the_term_list( get_the_ID(), 'wpfc_preacher' );
	
	if ( is_wp_error( $sermon_preacher ) )
        return false;
   
    return apply_filters( 'the_terms', $sermon_preacher, 'wpfc_preacher' );	
	
}

function get_sermons_blog_bible_passage () {
		
	return 	get_wpfc_sermon_meta( 'bible_passage' );
	
}

function get_sermons_blog_service_type () {
	$service_type = get_the_term_list( get_the_ID(), 'wpfc_service_type' );
	
	if ( is_wp_error( $service_type ) )
        return false;
   
    return apply_filters( 'the_terms', $service_type, 'wpfc_service_type' );	
	
}