<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package mastery
 */
?>

<?php
$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

if  ( ! empty( $featured_image_url ) ) : ?>
	<div class="imghov">
		<?php
		if ( is_page_template( 'page-fullwidth.php' ) ) {
			the_post_thumbnail( array( 750 , 250 ), array(
				'class' => 'single-featured',
			) );
		} else {    the_post_thumbnail( 'mastery-featured', array(
			'class' => 'single-featured',
		) );
		}
		?>
	</div>
<?php endif; ?>

<div class="post-inner-content">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header col-md-12 page-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="meta">
			<?php mastery_posted_on(); ?>
		</div>
	</header><!-- .entry-header -->
<div class="clear"></div>
	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mastery' ),
				'after'  => '</div>',
			) );
		?>

	<?php
	  // Checks if this is homepage to enable homepage widgets
	if ( is_front_page() ) :
		get_sidebar( 'home' );
	  endif;
	?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'mastery' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<i class="fa fa-pencil-square-o"></i><span class="edit-link">',
					'</span>'
				);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-## -->
</div>
