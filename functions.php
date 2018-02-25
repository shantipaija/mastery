<?php
/**
 * mastery functions and definitions
 *
 * @package mastery
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (! isset($content_width)) {
    $content_width = 648; /* pixels */
}

/**
 * Set the content width for full width pages with no sidebar.
 */
function mastery_content_width()
{
    if (is_page_template('page-fullwidth.php')) {
        global $content_width;
        $content_width = 1008; /* pixels */
    }
}
add_action('template_redirect', 'mastery_content_width');

if (! function_exists('mastery_main_content_bootstrap_classes')) :
    /**
 * Add Bootstrap classes to the main-content-area wrapper.
 */
    function mastery_main_content_bootstrap_classes()
    {
        $layout_class = get_layout_class();
        if ($layout_class=="dbar") {
            return 'col-sm-6 col-md-6';
        } elseif (is_page_template('page-fullwidth.php')) {
            return 'col-sm-12 col-md-12';
        }
        return 'col-sm-12 col-md-8';
    }
endif; // mastery_main_content_bootstrap_classes

if (! function_exists('mastery_setup')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
    function mastery_setup()
    {

          /*
           * Make theme available for translation.
           * Translations can be filed in the /languages/ directory.
           */
        load_theme_textdomain('mastery', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

          add_theme_support( 'custom-logo' );

          add_theme_support( 'custom-header', array(
  	'wp-head-callback' => 'theme_slug_header_style',
  ) );


function theme_slug_header_style() {
	/*
	 * If header text is set to display, let's bail.
	 */
	if ( display_header_text() ) {
		return;
	}
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	</style>
	<?php
}

          /*
           * Creating responsive video for posts/pages
           */
          if ( ! function_exists( 'mastery_responsive_video' ) ) :
          	function mastery_responsive_video( $html, $url, $attr, $post_ID ) {
          		return '<div class="fitvids-video">' . $html . '</div>';
          	}

          	add_filter( 'embed_oembed_html', 'mastery_responsive_video', 10, 4 );
          endif;

          /**************************************************************************************/
        /**
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
        add_theme_support('post-thumbnails');

        add_image_size('tab-small', 60, 60, true); // Small Thumbnail

        //16:9 ratio
        add_image_size('mastery-featured', 750, 422, true);
        add_image_size('mastery-featured-fullwidth', 1140, 641, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
              'primary'      => esc_html__('Primary Menu', 'mastery'),
              'footer-links' => esc_html__('Footer Links', 'mastery'),// secondary nav in footer
              'design01'      => esc_html__('Design01 Menu', 'mastery'),
          ));

        // Enable support for Post Formats.
        add_theme_support('post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ));

        // Setup the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('mastery_custom_background_args', array(
              'default-color' => 'F2F2F2',
              'default-image' => '',
          )));

        // Enable support for HTML5 markup.
        add_theme_support('html5', array(
              'comment-list',
              'search-form',
              'comment-form',
              'gallery',
              'caption',
          ));

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        // Backwards compatibility for Custom CSS
        $custom_css = of_get_option('custom_css');
        if ($custom_css) {
            $wp_custom_css_post = wp_get_custom_css_post();

            if ($wp_custom_css_post) {
                $wp_custom_css = $wp_custom_css_post->post_content . $custom_css;
            } else {
                $wp_custom_css = $custom_css;
            }

            wp_update_custom_css_post($wp_custom_css);

            $options = get_option('mastery');
            unset($options['custom_css']);
            update_option('mastery', $options);
        }
    }
endif; // mastery_setup
add_action('after_setup_theme', 'mastery_setup');

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function mastery_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar left (double sidebar)', 'mastery'),
        'id'            => 'sidebar-left',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'mastery'),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Sidebar for Search result page', 'mastery'),// add to translation
        'id'            => 'sidebar-search',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));


    register_sidebar(array(
        'id'            => 'footer-widget-1',
        'name'          => esc_html__('Footer Widget 1', 'mastery'),
        'description'   => esc_html__('Used for footer widget area', 'mastery'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-2',
        'name'          => esc_html__('Footer Widget 2', 'mastery'),
        'description'   => esc_html__('Used for footer widget area', 'mastery'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-3',
        'name'          => esc_html__('Footer Widget 3', 'mastery'),
        'description'   => esc_html__('Used for footer widget area', 'mastery'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'id'            => 'footer-widget-4',
        'name'          => esc_html__('Footer Widget 4', 'mastery'),
        'description'   => esc_html__('Used for footer widget area', 'mastery'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));

    /* Design 01 is page template that has its own widgets and sidebar */

    register_sidebar(array(
      'name'          => esc_html__('Sidebar for Design 01 page', 'mastery'),// add to translation
      'id'            => 'sidebar-design01',
        'description'   => esc_html__( 'Displayed on Page types where Template is chosen as "Design01 Page". Page Editor > Page Attributes > Template > Design01 Page', 'mastery' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
      ));

  // registering the Front Page: Content Top Section
    register_sidebar( array(
      'name'          => esc_html__( 'Design01 Page Section 1', 'mastery' ),
      'id'            => 'mastery_design01_section1',
      'description'   => esc_html__( 'Displayed on Page types where Template is chosen as "Design01 Page". Page Editor > Page Attributes > Template > Design01 Page', 'mastery' ),
        // 'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title section-heading  text-uppercase"><span>',
      'after_title'   => '</span></h2>',
      ) );


      register_sidebar(array(
          'id'            => 'footer-design01-widget-1',
          'name'          => esc_html__('Footer Design01 Widget 1', 'mastery'),
          'description'   => esc_html__('Used for footer widget area', 'mastery'),
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widgettitle">',
          'after_title'   => '</h3>',
      ));
      register_sidebar(array(
          'id'            => 'footer-design01-widget-2',
          'name'          => esc_html__('Footer Design01 Widget 2', 'mastery'),
          'description'   => esc_html__('Used for footer widget area', 'mastery'),
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widgettitle">',
          'after_title'   => '</h3>',
      ));
      register_sidebar(array(
          'id'            => 'footer-design01-widget-3',
          'name'          => esc_html__('Footer Design01 Widget 3', 'mastery'),
          'description'   => esc_html__('Used for footer widget area', 'mastery'),
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widgettitle">',
          'after_title'   => '</h3>',
      ));
      register_sidebar(array(
          'id'            => 'footer-design01-widget-4',
          'name'          => esc_html__('Footer Design01 Widget 4', 'mastery'),
          'description'   => esc_html__('Used for footer widget area', 'mastery'),
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widgettitle">',
          'after_title'   => '</h3>',
      ));
      register_sidebar(array(
          'id'            => 'footer-design01-widget-5',
          'name'          => esc_html__('Footer Design01 Widget 5', 'mastery'),
          'description'   => esc_html__('Used for footer widget area', 'mastery'),
          'before_widget' => '<div id="%1$s" class="widget %2$s">',
          'after_widget'  => '</div>',
          'before_title'  => '<h3 class="widgettitle">',
          'after_title'   => '</h3>',
      ));

    register_widget('mastery_Social_Widget');
    register_widget('mastery_Popular_Posts');
    register_widget('mastery_Categories');
}
add_action('widgets_init', 'mastery_widgets_init');


/* --------------------------------------------------------------
       Theme Widgets
-------------------------------------------------------------- */
require_once(get_template_directory() . '/inc/widgets/class-mastery-categories.php');
require_once(get_template_directory() . '/inc/widgets/class-mastery-popular-posts.php');
require_once(get_template_directory() . '/inc/widgets/class-mastery-social-widget.php');


/**
 * This function removes inline styles set by WordPress gallery.
 */
function mastery_remove_gallery_css($css)
{
    return preg_replace("#<style abc >(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'mastery_remove_gallery_css');

/**
 * Enqueue scripts and styles.
 */
function mastery_scripts()
{

    // register Bootstrap default CSS
    wp_register_style('mastery-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');

    // register Font Awesome stylesheet
    wp_register_style('mastery-fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');

    // Add Google Fonts
    $font = of_get_option('main_body_typography');
    if (isset($font['subset'])) {
        wp_register_style('mastery-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700|Roboto+Slab:400,300,700&subset=' . $font['subset']);
    } else {
        wp_register_style('mastery-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700|Roboto+Slab:400,300,700');
    }



    wp_enqueue_style('mastery-fonts');

    // Add slider CSS only if is front page ans slider is enabled
    if ((is_home() || is_front_page()) && of_get_option('mastery_slider_checkbox') == 1) {
        wp_enqueue_style('flexslider-css', get_template_directory_uri() . '/assets/css/flexslider.css');
    }

    $mastery_bootstrap = 'mastery-bootstrap';
    // Add main theme stylesheet

    wp_enqueue_style('mastery-style', get_stylesheet_uri(), array('mastery-bootstrap','mastery-fontawesome'));

    // Add Modernizr for better HTML5 and CSS3 support
    wp_enqueue_script('mastery-modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr.min.js', array( 'jquery' ));

    // Add Bootstrap default JS
    wp_enqueue_script('mastery-bootstrapjs', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array( 'jquery' ));

    if ((is_home() || is_front_page()) && of_get_option('mastery_slider_checkbox') == 1) {
        // Add slider JS only if is front page ans slider is enabled
        wp_enqueue_script('flexslider-js', get_template_directory_uri() . '/assets/js/vendor/flexslider.min.js', array( 'jquery' ), '20140222', true);
        // Flexslider customization
        wp_enqueue_script('flexslider-customization', get_template_directory_uri() . '/assets/js/flexslider-custom.min.js', array( 'jquery', 'flexslider-js' ), '20140716', true);
    }

    // Main theme related functions
    // wp_enqueue_script('mastery-functions', get_template_directory_uri() . '/assets/js/functions.min.js', array( 'jquery' ));
    wp_enqueue_script('mastery-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ));


    // This one is for accessibility
    wp_enqueue_script('mastery-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20140222', true);

    // Treaded comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }




		$custom_css = " /* custom css */ ";

		if ( of_get_option( 'link_color' ) ) {
			$custom_css .= 'a, #infinite-handle span, #secondary .widget .post-content a, .entry-meta a {color:' . of_get_option( 'link_color' ) . '}';
		}
		if ( of_get_option( 'link_hover_color' ) ) {
			$custom_css .= 'a:hover, a:active, #secondary .widget .post-content a:hover,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current, #secondary .widget a:hover  {color: ' . of_get_option( 'link_hover_color' ) . ';}';
		}
		if ( of_get_option( 'element_color' ) ) {
			$custom_css .= '.btn-default, .label-default, .flex-caption h2, .btn.btn-default.read-more,button,
              .navigation .wp-pagenavi-pagination span.current,.navigation .wp-pagenavi-pagination a:hover,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce input.button, .woocommerce #respond input#submit.alt,
              .woocommerce a.button, .woocommerce button.button,
              .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background-color: ' . of_get_option( 'element_color' ) . '; border-color: ' . of_get_option( 'element_color' ) . ';}';

			$custom_css .= '.site-main [class*="navigation"] a, .more-link, .pagination>li>a, .pagination>li>span, .cfa-button { color: ' . of_get_option( 'element_color' ) . '}';
			$custom_css .= '.cfa-button {border-color: ' . of_get_option( 'element_color' ) . ';}';
		}

		if ( of_get_option( 'element_color_hover' ) ) {
			// $custom_css .= '.btn-default:hover, .label-default[href]:hover, .tagcloud a:hover,button, .main-content [class*="navigation"] a:hover,.label-default[href]:focus, #infinite-handle span:hover,.btn.btn-default.read-more:hover, .btn-default:hover, .scroll-to-top:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .site-main [class*="navigation"] a:hover, .more-link:hover, #image-navigation .nav-previous a:hover, #image-navigation .nav-next a:hover, .cfa-button:hover,.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, a:hover .flex-caption h2 { background-color: ' . of_get_option( 'element_color_hover' ) . '; border-color: ' . of_get_option( 'element_color_hover' ) . '; }';
			$custom_css .= '.btn.btn-lg.cfa-button:hover { background-color: ' . of_get_option( 'element_color_hover' ) . '; border-color: ' . of_get_option( 'element_color_hover' ) . '; }';
		}




		if ( of_get_option( 'background_color' ) ) {
			$custom_css .= 'body.custom-background { background-color: ' . of_get_option( 'background_color' ) . ' !important;}';
		}

		if ( of_get_option( 'element_color_hover' ) ) {
			$custom_css .= '.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {color: ' . of_get_option( 'element_color_hover' ) . ';}';
		}
		if ( of_get_option( 'cfa_bg_color' ) ) {
			$custom_css .= '.cfa { background-color: ' . of_get_option( 'cfa_bg_color' ) . '; } .cfa-button:hover a {color: ' . of_get_option( 'cfa_bg_color' ) . ';}';
		}
		if ( of_get_option( 'cfa_color' ) ) {
			$custom_css .= '.cfa-text { color: ' . of_get_option( 'cfa_color' ) . ';}';
		}
		if ( of_get_option( 'cfa_btn_color' ) || of_get_option( 'cfa_btn_txt_color' ) ) {
			$custom_css .= '.cfa-button {border-color: ' . of_get_option( 'cfa_btn_color' ) . '; color: ' . of_get_option( 'cfa_btn_txt_color' ) . ';}';
		}
		if ( of_get_option( 'heading_color' ) ) {
			$custom_css .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title, .entry-title a {color: ' . of_get_option( 'heading_color' ) . ';}';
		}
		if ( of_get_option( 'header_text_color' ) ) {
			$custom_css .= '.navbar > .container .navbar-brand, .site-description {color: ' . of_get_option( 'header_text_color' ) . ' !important;}';
		}

		if ( of_get_option( 'nav_bg_color' ) ) {
			$custom_css .= '.navbar.navbar-default, .navbar-default .navbar-nav .open .dropdown-menu > li > a {background-color: ' . of_get_option( 'nav_bg_color' ) . ';}';
		}
		if ( of_get_option( 'nav_link_color' ) ) {
			$custom_css .= '.navbar-default .navbar-nav > li > a, .navbar-default .navbar-nav.mastery-mobile-menu > li:hover > a, .navbar-default .navbar-nav.mastery-mobile-menu > li:hover > .caret, .navbar-default .navbar-nav > li, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus { color: ' . of_get_option( 'nav_link_color' ) . ';}';
			$custom_css .= '@media (max-width: 767px){ .navbar-default .navbar-nav > li:hover > a, .navbar-default .navbar-nav > li:hover > .caret{ color: ' . of_get_option( 'nav_link_color' ) . '!important ;} }';
		}
		if ( of_get_option( 'nav_item_hover_color' ) ) {
			$custom_css .= '.navbar-default .navbar-nav > li:hover > a, .navbar-nav > li:hover > .caret, .navbar-default .navbar-nav.mastery-mobile-menu > li.open > a, .navbar-default .navbar-nav.mastery-mobile-menu > li.open > .caret, .navbar-default .navbar-nav > li:hover, .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > .caret, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {color: ' . of_get_option( 'nav_item_hover_color' ) . ';}';
			$custom_css .= '@media (max-width: 767px){ .navbar-default .navbar-nav > li.open > a, .navbar-default .navbar-nav > li.open > .caret { color: ' . of_get_option( 'nav_item_hover_color' ) . ' !important; } }';
		}
		if ( of_get_option( 'nav_dropdown_bg' ) ) {
			$custom_css .= '.dropdown-menu {background-color: ' . of_get_option( 'nav_dropdown_bg' ) . ';}';
		}
		if ( of_get_option( 'nav_dropdown_item' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .open .dropdown-menu > li > a, .dropdown-menu > li > a, .dropdown-menu > li > .caret { color: ' . of_get_option( 'nav_dropdown_item' ) . ';}';
		}

		if ( of_get_option( 'nav_dropdown_bg_hover' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .dropdown-menu > li:hover, .navbar-default .navbar-nav .dropdown-menu > li:focus, .dropdown-menu > .active {background-color: ' . of_get_option( 'nav_dropdown_bg_hover' ) . ';}';
			$custom_css .= '@media (max-width: 767px) {.navbar-default .navbar-nav .dropdown-menu > li:hover, .navbar-default .navbar-nav .dropdown-menu > li:focus, .dropdown-menu > .active {background: transparent;} }';
		}
		if ( of_get_option( 'nav_dropdown_item_hover' ) ) {
			$custom_css .= '.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>.caret, .dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover, .dropdown-menu>li:hover>a, .dropdown-menu>li:hover>.caret {color:' . of_get_option( 'nav_dropdown_item_hover' ) . ';}';
			$custom_css .= '@media (max-width: 767px) {.navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .dropdown-menu > li.active > .caret, .navbar-default .navbar-nav .dropdown-menu > li.open > a, .navbar-default .navbar-nav li.open > a, .navbar-default .navbar-nav li.open > .caret {color:' . of_get_option( 'nav_dropdown_item_hover' ) . ';} }';
		}

		if ( of_get_option( 'nav_dropdown_item_hover' ) ) {
			$custom_css .= '.navbar-default .navbar-nav .current-menu-ancestor a.dropdown-toggle { color: ' . of_get_option( 'nav_dropdown_item_hover' ) . ';}';
		}
		if ( of_get_option( 'footer_bg_color' ) ) {
			$custom_css .= '#colophon {background-color: ' . of_get_option( 'footer_bg_color' ) . ';}';
		}
		if ( of_get_option( 'footer_text_color' ) ) {
			$custom_css .= '#footer-area, .site-info, .site-info caption, #footer-area caption {color: ' . of_get_option( 'footer_text_color' ) . ';}';
		}
		if ( of_get_option( 'footer_widget_bg_color' ) ) {
			$custom_css .= '#footer-area {background-color: ' . of_get_option( 'footer_widget_bg_color' ) . ';}';
		}
		if ( of_get_option( 'footer_link_color' ) ) {
			$custom_css .= '.site-info a, #footer-area a {color: ' . of_get_option( 'footer_link_color' ) . ';}';
		}
		if ( of_get_option( 'social_color' ) ) {
			$custom_css .= '.social-icons li a {background-color: ' . of_get_option( 'social_color' ) . ' !important ;}';
		}
		if ( of_get_option( 'social_footer_color' ) ) {
			$custom_css .= '#footer-area .social-icons li a {background-color: ' . of_get_option( 'social_footer_color' ) . ' !important ;}';
		}
		global $typography_options;
		$typography = of_get_option( 'main_body_typography' );
		if ( $typography ) {
			if ( isset( $typography['color'] ) ) {
				$custom_css .= 'body, .entry-content {color:' . $typography['color'] . '}';
			}
			if ( isset( $typography['face'] ) && isset( $typography_options['faces'][ $typography['face'] ] ) ) {
				$custom_css .= '.entry-content {font-family: ' . $typography_options['faces'][ $typography['face'] ] . ';}';
			}
			if ( isset( $typography['size'] ) ) {
				$custom_css .= '.entry-content {font-size:' . $typography['size'] . '}';
			}
			if ( isset( $typography['style'] ) ) {
				$custom_css .= '.entry-content {font-weight:' . $typography['style'] . '}';
			}
		}
		if ( of_get_option( 'custom_css' ) ) {
			echo html_entity_decode( of_get_option( 'custom_css', 'no entry' ) );
		}

		// echo "<style>".$custom_css."</style>";

        $color_scheme = of_get_option('style_color', 'white');

        if(!empty($color_scheme)){
            wp_enqueue_style('custom_css_scheme', get_template_directory_uri() . '/'. $color_scheme . '.css');
        }else{
			       wp_enqueue_style( 'custom_css_scheme', get_template_directory_uri() . '/white.css');
		    }

		wp_add_inline_style( 'custom_css_scheme', $custom_css );


}
add_action('wp_enqueue_scripts', 'mastery_scripts');

/**
* get_bgcolor - Returns  background color
*/

if (! function_exists('get_bgcolor')) :

    function get_bgcolor()
    {
        $background_color = of_get_option('background_color');
        $bgcolor = (strlen($background_color)>3)?"<style>body{background-color:$background_color;}</style>":"";
        echo  $bgcolor;

    }

     add_action('wp_head', 'get_bgcolor', 8);

endif;


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Metabox additions.
 */
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Register Social Icon menu
 */
add_action('init', 'register_social_menu');

function register_social_menu()
{
    register_nav_menu('social-menu', _x('Social Menu', 'nav menu location', 'mastery'));
}

/* Globals variables */
global $options_categories;
$options_categories = array();
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
    $options_categories[ $category->cat_ID ] = $category->cat_name;
}

global $site_layout;
$site_layout = array(
    'side-pull-left' => esc_html__('Right Sidebar', 'mastery'),
    'side-pull-right' => esc_html__('Left Sidebar', 'mastery'),
    'dbar' => esc_html__('Double Sidebar', 'mastery'),
    'no-sidebar' => esc_html__('No Sidebar', 'mastery'),
    'full-width' => esc_html__('Full Width', 'mastery'),
);

global $style_color;
$style_color = array(
    'lightgray' 	=> esc_html__('Light Gray', 'mastery'),
    'darkgray' 	=> esc_html__('Dark Gray ', 'mastery'),
    'red' 	=> esc_html__('Red ', 'mastery'),
    'green' 	=> esc_html__('Green ', 'mastery'),
    'blue' 	=> esc_html__('Blue ', 'mastery'),
    'orange' 	=> esc_html__('Orange ', 'mastery'),
    'white' 	=> esc_html__('White ', 'mastery'),
    // todo
    // translation required
);

// Typography Options
global $typography_options;
$typography_options = array(
    'sizes' => array(
        '6px' => '6px',         '10px' => '10px',       '12px' => '12px',
        '14px' => '14px',       '15px' => '15px',       '16px' => '16px',
        '18px' => '18px',       '20px' => '20px',       '24px' => '24px',
        '28px' => '28px',       '32px' => '32px',       '36px' => '36px',
        '42px' => '42px',       '48px' => '48px',
    ),
    'faces' => array(
        'arial'          => 'Arial',
        'verdana'        => 'Verdana, Geneva',
        'trebuchet'      => 'Trebuchet',
        'georgia'        => 'Georgia',
        'times'          => 'Times New Roman',
        'tahoma'         => 'Tahoma, Geneva',
        'Open Sans'      => 'Open Sans',
        'palatino'       => 'Palatino',
        'helvetica'      => 'Helvetica',
        'Helvetica Neue' => 'Helvetica Neue,Helvetica,Arial,sans-serif',
    ),
    'styles' => array(
        'normal' => 'Normal',
        'bold' => 'Bold',
    ),
    'color'  => true,
);

/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if (! function_exists('of_get_option')) :
    function of_get_option($name, $default = false)
    {
        $option_name = '';
        // Get option settings from database
        $options = get_option('mastery');

        // Return specific option
        if (isset($options[ $name ])) {
            return $options[ $name ];
        }

        return $default;
    }
endif;

/* WooCommerce Support Declaration */
if (! function_exists('mastery_woo_setup')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 */
    function mastery_woo_setup()
    {
        /*
         * Enable support for WooCemmerce.
        */
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }
endif; // mastery_woo_setup
add_action('after_setup_theme', 'mastery_woo_setup');

if (! function_exists('get_woocommerce_page_id')) :
    /**
 * Sets up theme defaults and registers support for various WordPress features.
 */
    function get_woocommerce_page_id()
    {
        if (is_shop()) {
            return get_option('woocommerce_shop_page_id');
        } elseif (is_cart()) {
            return get_option('woocommerce_cart_page_id');
        } elseif (is_checkout()) {
            return get_option('woocommerce_checkout_page_id');
        } elseif (is_checkout_pay_page()) {
            return get_option('woocommerce_pay_page_id');
        } elseif (is_account_page()) {
            return get_option('woocommerce_myaccount_page_id');
        }
        return false;
    }
endif;

/**
* is_it_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*/
if (! function_exists('is_it_woocommerce_page')) :

    function is_it_woocommerce_page()
    {
        if (function_exists('is_woocommerce') && is_woocommerce()) {
            return true;
        }
        $woocommerce_keys   = array(
            'woocommerce_shop_page_id',
            'woocommerce_terms_page_id',
            'woocommerce_cart_page_id',
            'woocommerce_checkout_page_id',
            'woocommerce_pay_page_id',
            'woocommerce_thanks_page_id',
            'woocommerce_myaccount_page_id',
            'woocommerce_edit_address_page_id',
            'woocommerce_view_order_page_id',
            'woocommerce_change_password_page_id',
            'woocommerce_logout_page_id',
            'woocommerce_lost_password_page_id',
        ) ;
        foreach ($woocommerce_keys as $wc_page_id) {
            if (get_the_ID() == get_option($wc_page_id, 0)) {
                return true ;
            }
        }
        return false;
    }

endif;

/**
* get_layout_class - Returns class name for layout i.e full-width, right-sidebar, left-sidebar etc )
*/
if (! function_exists('get_layout_class')) :

    function get_layout_class()
    {
        global $post;
        if (is_singular() && get_post_meta($post->ID, 'site_layout', true) && ! is_singular(array( 'product' ))) {
            $layout_class = get_post_meta($post->ID, 'site_layout', true);
        } elseif (function_exists('is_woocommerce') && function_exists('is_it_woocommerce_page') && is_it_woocommerce_page() && ! is_search()) {// Check for WooCommerce
            $page_id = (is_product()) ? $post->ID : get_woocommerce_page_id();

            if ($page_id && get_post_meta($page_id, 'site_layout', true)) {
                $layout_class = get_post_meta($page_id, 'site_layout', true);
            } else {
                $layout_class = of_get_option('woo_site_layout', 'full-width');
            }
        } else {
            $layout_class = of_get_option('site_layout', 'side-pull-left');
        }
        return $layout_class;
    }

endif;


add_action('wp_ajax_mastery_get_attachment_media', 'mastery_get_attachment_image');
function mastery_get_attachment_image()
{
    $id  = intval($_POST['attachment_id']);
    $response = array();
    $response['id'] = $id;
    $response['image'] = wp_get_attachment_image($id, 'medium');
    echo json_encode($response);
    die();
}

// Add epsilon framework
require get_template_directory() . '/inc/libraries/epsilon-framework/class-epsilon-autoloader.php';
$epsilon_framework_settings = array(
    'controls' => array( 'toggle' ), // array of controls to load
    'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
);
new Epsilon_Framework($epsilon_framework_settings);

//Include Welcome Screen
require get_template_directory() . '/inc/welcome-screen/welcome-page-setup.php';



function mastery_excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt).'...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}


/**
 * Registers an editor stylesheet for the theme.
 */
function mastery_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'mastery_add_editor_styles' );


// JavaScript less Social Media Share button to speed up website
if ( !function_exists( 'socialmedia_share_button' ) ){

    function socialmedia_share_button($type = "", $size = ""){

        // icon
        $facebook   = "";       $twitter    = "";
        $googleplus = "";       $pinterest  ="";
        $whatsapp   = "";       $telegram   = "";

        // Name of Social Media
        if ( $type == "name" || $type == "title"){

            $facebook   = "Facebook";       $twitter    = "Twitter";
            $googleplus = "Google+";        $pinterest  ="Pinterest";
            $whatsapp   = "WhatsApp";       $telegram   = "Telegram";

        }

        // Do this on social media
        if ( $type == "full" || $type == "detail"){

            $facebook   = "Share on Facebook";          $twitter    = "Tweet on Twitter";
            $googleplus = "Share on Google+";           $pinterest  ="Pin on Pinterest";
            $whatsapp   = "Share on WhatsApp";          $telegram   = "Share on Telegram";

        }

        $buttonsize = ( $size=="big" || $size =="large" ) ? "social-large" : ( ( $size=="medium") ? "social-medium" : "social-small" );

        ?>
<a class="social-link" href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" title="Share on Facebook" target="_blank" aria-label="Facebook"><div class="social-sharing-button social-facebook <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg></div><?php echo $facebook; ?></div></a><a class="social-link" href="https://twitter.com/intent/tweet/?text=<?php echo urlencode( get_the_title() ); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;hashtags=" title="Tweet this with Twitter" target="_blank" aria-label="Twitter"><div class="social-sharing-button social-twitter <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg></div><?php echo $twitter; ?></div></a><a class="social-link" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" title="Share on Google Plus" target="_blank" aria-label="Google+"><div class="social-sharing-button social-google <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.37 12.93c-.73-.52-1.4-1.27-1.4-1.5 0-.43.03-.63.98-1.37 1.23-.97 1.9-2.23 1.9-3.57 0-1.22-.36-2.3-1-3.05h.5c.1 0 .2-.04.28-.1l1.36-.98c.16-.12.23-.34.17-.54-.07-.2-.25-.33-.46-.33H7.6c-.66 0-1.34.12-2 .35-2.23.76-3.78 2.66-3.78 4.6 0 2.76 2.13 4.85 5 4.9-.07.23-.1.45-.1.66 0 .43.1.83.33 1.22h-.08c-2.72 0-5.17 1.34-6.1 3.32-.25.52-.37 1.04-.37 1.56 0 .5.13.98.38 1.44.6 1.04 1.84 1.86 3.55 2.28.87.23 1.82.34 2.8.34.88 0 1.7-.1 2.5-.34 2.4-.7 3.97-2.48 3.97-4.54 0-1.97-.63-3.15-2.33-4.35zm-7.7 4.5c0-1.42 1.8-2.68 3.9-2.68h.05c.45 0 .9.07 1.3.2l.42.28c.96.66 1.6 1.1 1.77 1.8.05.16.07.33.07.5 0 1.8-1.33 2.7-3.96 2.7-1.98 0-3.54-1.23-3.54-2.8zM5.54 3.9c.33-.38.75-.58 1.23-.58h.05c1.35.05 2.64 1.55 2.88 3.35.14 1.02-.08 1.97-.6 2.55-.32.37-.74.56-1.23.56h-.03c-1.32-.04-2.63-1.6-2.87-3.4-.13-1 .08-1.92.58-2.5zM23.5 9.5h-3v-3h-2v3h-3v2h3v3h2v-3h3"/></svg></div><?php echo $googleplus; ?></div></a><a class="social-link" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php if(has_post_thumbnail()) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" title="Pin it on Pinterest" target="_blank" aria-label="Pinterest"><div class="social-sharing-button social-pinterest <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.14.5C5.86.5 2.7 5 2.7 8.75c0 2.27.86 4.3 2.7 5.05.3.12.57 0 .66-.33l.27-1.06c.1-.32.06-.44-.2-.73-.52-.62-.86-1.44-.86-2.6 0-3.33 2.5-6.32 6.5-6.32 3.55 0 5.5 2.17 5.5 5.07 0 3.8-1.7 7.02-4.2 7.02-1.37 0-2.4-1.14-2.07-2.54.4-1.68 1.16-3.48 1.16-4.7 0-1.07-.58-1.98-1.78-1.98-1.4 0-2.55 1.47-2.55 3.42 0 1.25.43 2.1.43 2.1l-1.7 7.2c-.5 2.13-.08 4.75-.04 5 .02.17.22.2.3.1.14-.18 1.82-2.26 2.4-4.33.16-.58.93-3.63.93-3.63.45.88 1.8 1.65 3.22 1.65 4.25 0 7.13-3.87 7.13-9.05C20.5 4.15 17.18.5 12.14.5z"/></svg></div><?php echo $pinterest; ?></div></a><a class="social-link" href="whatsapp://send?text=<?php echo urlencode( get_the_title() );  echo urlencode(get_permalink()); ?>" title="Share on WhatsApp" target="_blank" aria-label="WhatsApp"><div class="social-sharing-button social-whatsapp <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20.1 3.9C17.9 1.7 15 .5 12 .5 5.8.5.7 5.6.7 11.9c0 2 .5 3.9 1.5 5.6L.6 23.4l6-1.6c1.6.9 3.5 1.3 5.4 1.3 6.3 0 11.4-5.1 11.4-11.4-.1-2.8-1.2-5.7-3.3-7.8zM12 21.4c-1.7 0-3.3-.5-4.8-1.3l-.4-.2-3.5 1 1-3.4L4 17c-1-1.5-1.4-3.2-1.4-5.1 0-5.2 4.2-9.4 9.4-9.4 2.5 0 4.9 1 6.7 2.8 1.8 1.8 2.8 4.2 2.8 6.7-.1 5.2-4.3 9.4-9.5 9.4zm5.1-7.1c-.3-.1-1.7-.9-1.9-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1s-1.2-.5-2.3-1.4c-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6s.3-.3.4-.5c.2-.1.3-.3.4-.5.1-.2 0-.4 0-.5C10 9 9.3 7.6 9 7c-.1-.4-.4-.3-.5-.3h-.6s-.4.1-.7.3c-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.3.2-.7.2-1.2.2-1.3-.1-.3-.3-.4-.6-.5z"/></svg></div><?php echo $whatsapp; ?></div></a><a class="social-link" href="https://telegram.me/share/url?text=<?php echo urlencode( get_the_title() ); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" title="Share on Telegram" target="_blank" aria-label="Telegram"><div class="social-sharing-button social-telegram <?php echo $buttonsize; ?>"><div aria-hidden="true" class="social-icon icon-solid"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M.707 8.475C.275 8.64 0 9.508 0 9.508s.284.867.718 1.03l5.09 1.897 1.986 6.38a1.102 1.102 0 0 0 1.75.527l2.96-2.41a.405.405 0 0 1 .494-.013l5.34 3.87a1.1 1.1 0 0 0 1.046.135 1.1 1.1 0 0 0 .682-.803l3.91-18.795A1.102 1.102 0 0 0 22.5.075L.706 8.475z"/></svg></div><?php echo $telegram; ?></div></a>
    <?php
    }
}
