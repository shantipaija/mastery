<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package mastery
 */
?>
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .site-content -->

	<div id="footer-area">
		<div class="container footer-inner">
			<div class="row">
				<?php get_sidebar( 'design01footer' ); ?>
			</div>
		</div>

		<div class="scroll-to-top"><i class="fa fa-angle-up"></i></div><!-- .scroll-to-top -->
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
