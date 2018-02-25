<?php
/**
 * The Sidebar widget area for footer.
 *
 * @package mastery
 */
?>

	<?php
	// If footer sidebars do not have widget let's bail.

	if ( ! is_active_sidebar( 'footer-design01-widget-1' ) && ! is_active_sidebar( 'footer-design01-widget-2' ) && ! is_active_sidebar( 'footer-widget-3' ) && ! is_active_sidebar( 'footer-widget-4' ) && ! is_active_sidebar( 'footer-widget-5' ) ) {
		return;
	}


	// If we made it this far we must have widgets.
	?>

	<div class="footer-widget-area">
		<?php if ( is_active_sidebar( 'footer-design01-widget-1' ) ) : ?>
		<div class="footer-widget col-md-4" role="complementary">
			<?php dynamic_sidebar( 'footer-design01-widget-1' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-design01-widget-2' ) ) : ?>
		<div class="footer-widget col-md-2" role="complementary">
			<?php dynamic_sidebar( 'footer-design01-widget-2' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-design01-widget-3' ) ) : ?>
		<div class="footer-widget col-md-2" role="complementary">
			<?php dynamic_sidebar( 'footer-design01-widget-3' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-design01-widget-4' ) ) : ?>
		<div class="footer-widget col-md-2" role="complementary">
			<?php dynamic_sidebar( 'footer-design01-widget-4' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-design01-widget-5' ) ) : ?>
		<div class="footer-widget col-md-2" role="complementary">
			<?php dynamic_sidebar( 'footer-design01-widget-5' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>
	</div>
