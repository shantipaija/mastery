<?php
/* *
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package mastery
 */

if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && (strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false) ) { header( 'X-UA-Compatible: IE=edge,chrome=1' );
} ?>
<!doctype html>
<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head itemscope itemtype="https://schema.org/WebSite">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="<?php echo ((!empty (of_get_option( 'nav_bg_color' )))?of_get_option( 'nav_bg_color' ):(of_get_option('style_color','white'))); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
	<a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header"  itemscope itemtype="https://schema.org/WPHeader">
			<div class="custom-header-media">
				<?php the_custom_header_markup(); ?>
			</div>
			<nav class="navbar navbar-default <?php if ( of_get_option( 'sticky_menu' ) ) { echo 'enable-navbar-fixed-top'; } ?>" itemscope itemtype="https://schema.org/SiteNavigationElement">
				<div class="container">
					<div class="row">

						<div class="site-navigation-inner col-md-12">
							<div class="navbar-header">
								<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>

									<div class="brand-name" itemscope itemtype="http://schema.org/Brand">
										<?php
										the_custom_logo();

										if ( display_header_text() || ( is_customize_preview() &&  display_header_text() ) ) :
												?>
												<div class="site-branding-text">
													<?php
													if ( is_front_page() || is_home() ) : ?>
													<h1 class="site-title"  itemprop="name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" ><?php bloginfo( 'name' ); ?></a></h1>
													<?php else : ?>
													<p class=" site-title"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
													<?php endif;?>

													<p class="site-description"  itemprop="description"><?php echo get_bloginfo('description'); ?></p>

												</div>
										<?php endif; ?>

                  </div><!-- end of .brand-name -->

						</div><!-- /.navbar-header -->
							<?php mastery_header_menu(); // main navigation ?>
						</div><!-- /.site-navigation-inner -->
					</div><!-- /.row -->
				</div><!-- /.container -->
			</nav><!-- .site-navigation -->
		</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="top-section">
			<?php mastery_featured_slider(); ?>
			<?php mastery_call_for_action(); ?>
		</div>
		<div class="container main-content-area">
			<?php
			$layout_class = get_layout_class();
			?>
			<div class="row <?php
			// what is this line doing here?
			echo $layout_class;

			?>">
			<?php

				if($layout_class=="dbar"){
					get_sidebar("left");
				}
			?>
				<div class="main-content-inner <?php echo mastery_main_content_bootstrap_classes(); ?>">
