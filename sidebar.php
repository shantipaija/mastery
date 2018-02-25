</div><!-- close .main-content-inner -->
<?php
	 
	$sidebar_class = "col-sm-12 col-md-4";
		
	$layout_class = get_layout_class(); 
	if($layout_class=="dbar"){
		$sidebar_class ="col-sm-3 col-md-3";
	}
 ?>
<div id="secondary" class="widget-area <?php echo $sidebar_class;?>" role="complementary">
	<div class="well">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>

			<aside id="archives" class="widget">
				<h3 class="widget-title"><?php esc_html_e( 'Archives', 'mastery' ); ?></h3>
				<ul>
					<?php
					$archives_args = array(
						'type' => 'monthly',
					);
					wp_get_archives( $archives_args ); ?>
				</ul>
			</aside>

			<aside id="meta" class="widget">
				<h3 class="widget-title"><?php esc_html_e( 'Meta', 'mastery' ); ?></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>

		<?php endif; // end sidebar widget area ?>
	</div>
</div><!-- #secondary -->
