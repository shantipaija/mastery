<?php
/**
 * Template Name: Design01 Page
 *
 * This is the template that displays full width page sidebar
 *
 * @package mastery
 */
get_header("design01"); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>



			<!-- Widget Section -->
		<?php if ( is_active_sidebar( 'mastery_design01_section1' ) ) : ?>
			<section id="services">
				<div class="container">
					<div class="row text-center">
						<?php dynamic_sidebar( 'mastery_design01_section1' ); ?>
					</div>
				</div>
			</section>
		 <?php endif; ?>


		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar("design01");
get_footer("design01");
