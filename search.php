<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package mastery
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
						<?php get_search_form(); ?>

		<?php
		if ( have_posts() ) : ?>
			<h1 class="page-title search-page-title"><?php printf( esc_html__( 'Search Results for %s', 'mastery' ), '<em><a href="'.esc_url( home_url( '/' ) ).'?s=' . get_search_query() . '">' . get_search_query() . '</a></em>' ); ?></h1>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_pagination( array(
				'prev_text' => '<i class="fa fa-chevron-left"></i> ' . __( 'Newer posts', 'mastery' ),
				'next_text' => __( 'Older posts', 'mastery' ) . ' <i class="fa fa-chevron-right"></i>',
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar("search");
get_footer();
