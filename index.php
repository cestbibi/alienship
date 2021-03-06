<?php
/**
 * The main template file.
 * @package Alien Ship
 * @since Alien Ship 0.1
 */

get_header(); ?>

		<div id="main-row" class="row">
			<?php do_action( 'alienship_content_before' ); ?>
			<div id="content" role="main" class="<?php echo apply_filters( 'alienship_content_container_class', 'col-sm-9' ); ?>">
				<?php if ( have_posts() ) {

					if ( of_get_option('alienship_content_nav_above') ) { alienship_content_nav( 'nav-above' ); } // display content nav above posts?

					/**
					 * Featured Posts
					 */
					if ( of_get_option('alienship_featured_posts') ) {

						if ( of_get_option( 'alienship_featured_posts_display_type', 1 ) == "1" ) {
							alienship_featured_posts_slider();
						} else {
							alienship_featured_posts_grid();
						}

						/**
						 * Show or hide featured posts in the main post index
						 */
						// Do not duplicate featured posts in the post index
						if ( of_get_option( 'alienship_featured_posts_show_dupes' ) == "0" ) {
							global $wp_query;
							$wp_query->set( 'tag__not_in', array( of_get_option( 'alienship_featured_posts_tag' ) ) );
							$wp_query->get_posts();
						}

						// Duplicate featured posts in the post index
						if ( of_get_option( 'alienship_featured_posts_show_dupes' ) == "1" ) {
							global $wp_query;
							$wp_query->set( 'post_status', 'publish' );
							$wp_query->get_posts();
						}

					} // if (of_get_option('alienship_featured_posts') )


				// Start the Loop
				while ( have_posts() ) : the_post();
					do_action( 'alienship_loop_before' );

					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					$format = get_post_format();
					if ( false === $format )
						$format = 'standard';
					get_template_part( '/templates/parts/content', $format );

					do_action( 'alienship_loop_after' );
				endwhile;

				if ( of_get_option('alienship_content_nav_below',1) ) { alienship_content_nav( 'nav-below' ); } // display content nav below posts?

			} else {

				// No results
				get_template_part( '/templates/parts/content', 'none' );

			} //have_posts
			do_action( 'alienship_content_after' ); ?>
		</div><!-- #content -->

		<?php get_sidebar(); ?>
	</div><!-- .row -->
<?php get_footer(); ?>
