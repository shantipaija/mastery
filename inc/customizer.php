<?php
/**
 * Mastery Customizer
 *
 * @package Mastery
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mastery_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('background_color');
}
add_action( 'customize_register', 'mastery_customize_register' );

/**
 * Options for Mastery Customizer.
 */
function mastery_customizer( $wp_customize ) {

	/* Main option Settings Panel */
	$wp_customize->add_panel('mastery_main_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Mastery Options', 'mastery' ),
		'description' => __( 'Panel to update Mastery theme options', 'mastery' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));


	/* Main option Settings Panel */
	$wp_customize->add_panel('mastery_homepage_options', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Mastery HomePage Options', 'mastery' ),
		'description' => __( 'Panel to update mastery homepage options', 'mastery' ), // Include html tags such as <p>.
		'priority' => 10,// Mixed with top-level-section hierarchy.
	));

	// add "Content Options" section
	$wp_customize->add_section( 'mastery_content_section' , array(
		'title'      => esc_html__( 'Content Options', 'mastery' ),
		'priority'   => 50,
		'panel' => 'mastery_main_options',
	) );
	// add setting for excerpts/full posts toggle
	$wp_customize->add_setting( 'mastery_excerpts', array(
		'default'           => 0,
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	// add checkbox control for excerpts/full posts toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery_excerpts', array(
		'label'     => esc_html__( 'Show post excerpts in Home, Archive, and Category pages', 'mastery' ),
		'section'   => 'mastery_content_section',
		'priority'  => 10,
		'type'      => 'epsilon-toggle',
	) ) );

	$wp_customize->add_setting( 'mastery_page_comments', array(
		'default' => 1,
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery_page_comments', array(
		'label'     => esc_html__( 'Display Comments on Static Pages?', 'mastery' ),
		'section'   => 'mastery_content_section',
		'priority'  => 20,
		'type'      => 'epsilon-toggle',
	) ) );


	// add setting for Show/Hide posts date toggle
	$wp_customize->add_setting( 'mastery_post_date', array(
		'default'           => 1,
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts date toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery_post_date', array(
		'label'     => esc_html__( 'Show post date?', 'mastery' ),
		'section'   => 'mastery_content_section',
		'priority'  => 30,
		'type'      => 'epsilon-toggle',
	) ) );

	// add setting for Show/Hide posts Author Bio toggle
	$wp_customize->add_setting( 'mastery_post_author_bio', array(
		'default'           => 1,
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	// add checkbox control for Show/Hide posts Author Bio toggle
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery_post_author_bio', array(
		'label'     => esc_html__( 'Show Author Bio?', 'mastery' ),
		'section'   => 'mastery_content_section',
		'priority'  => 40,
		'type'      => 'epsilon-toggle',
	) ) );



	/* mastery Main Options */
	$wp_customize->add_section('mastery_slider_options', array(
		'title' => __( 'Slider options', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_homepage_options',
	));
	$wp_customize->add_setting( 'mastery[mastery_slider_checkbox]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery[mastery_slider_checkbox]', array(
		'label' => esc_html__( 'Check if you want to enable slider', 'mastery' ),
		'section'   => 'mastery_slider_options',
		'priority'  => 5,
		'type'      => 'epsilon-toggle',
	) ) );
	$wp_customize->add_setting( 'mastery[mastery_slider_link_checkbox]', array(
		'default' => 1,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery[mastery_slider_link_checkbox]', array(
		'label' => esc_html__( 'Turn "off" this option to remove the link from the slides', 'mastery' ),
		'section'   => 'mastery_slider_options',
		'priority'  => 6,
		'type'      => 'epsilon-toggle',
	) ) );

	// Pull all the categories into an array
	global $options_categories;
	$wp_customize->add_setting('mastery[mastery_slide_categories]', array(
		'default' => '',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'mastery_sanitize_slidecat',
	));
	$wp_customize->add_control('mastery[mastery_slide_categories]', array(
		'label' => __( 'Slider Category', 'mastery' ),
		'section' => 'mastery_slider_options',
		'type'    => 'select',
		'description' => __( 'Select a category for the featured post slider', 'mastery' ),
		'choices'    => $options_categories,
	));

	$wp_customize->add_setting('mastery[mastery_slide_number]', array(
		'default' => 3,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_number',
	));
	$wp_customize->add_control('mastery[mastery_slide_number]', array(
		'label' => __( 'Number of slide items', 'mastery' ),
		'section' => 'mastery_slider_options',
		'description' => __( 'Enter the number of slide items', 'mastery' ),
		'type' => 'text',
	));
/*
	$wp_customize->add_setting('mastery[mastery_slide_height]', array(
		'default' => 500,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_number',
	));
	$wp_customize->add_control('mastery[mastery_slide_height]', array(
		'label' => __( 'Height of slider ', 'mastery' ),
		'section' => 'mastery_slider_options',
		'description' => __( 'Enter the height for slider', 'mastery' ),
		'type' => 'text',
	));
*/
	$wp_customize->add_section('mastery_layout_options', array(
		'title' => __( 'Layout Options', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));
	$wp_customize->add_section('mastery_style_color_options', array(
		'title' => __( 'Color Schemes', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));

	// Layout options
	global $site_layout;
	$wp_customize->add_setting('mastery[site_layout]', array(
		'default' => 'side-pull-left',
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_layout',
	));
	$wp_customize->add_control('mastery[site_layout]', array(
		'label' => __( 'Website Layout Options', 'mastery' ),
		'section' => 'mastery_layout_options',
		'type'    => 'select',
		'description' => __( 'Choose between different layout options to be used as default', 'mastery' ),
		'choices'    => $site_layout,
	));

	// Colorful Template Styles options
	global $style_color;
	$wp_customize->add_setting('mastery[style_color]', array(
		'default' => 'white',
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_template',
	));
	$wp_customize->add_control('mastery[style_color]', array(
		'label' => __( 'Color Schemes', 'mastery' ),
		'section' => 'mastery_style_color_options',
		'type'    => 'select',
		'description' => __( 'Choose between different color template options to be used as default', 'mastery' ),
		'choices'    => $style_color,
	));

	//Background color
	$wp_customize->add_setting('mastery[background_color]', array(
		'default' => sanitize_hex_color( 'cccccc' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[background_color]', array(
		'label' => __( 'Background Color', 'mastery' ),
		//'description'   => __( 'Background Color','mastery' ),
		'section' => 'mastery_style_color_options',
	)));

	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_setting('mastery[woo_site_layout]', array(
			'default' => 'full-width',
			'type' => 'option',
			'sanitize_callback' => 'mastery_sanitize_layout',
		));
		$wp_customize->add_control('mastery[woo_site_layout]', array(
			'label' => __( 'WooCommerce Page Layout Options', 'mastery' ),
			'section' => 'mastery_layout_options',
			'type'    => 'select',
			'description' => __( 'Choose between different layout options to be used as default for all woocommerce pages', 'mastery' ),
			'choices'    => $site_layout,
		));
	}

	$wp_customize->add_setting('mastery[element_color_hover]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));


	 /* mastery Call To Action Options */
	$wp_customize->add_section('mastery_action_options', array(
		'title' => __( 'Call To Action (CTA)', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_homepage_options',
	));


	$wp_customize->add_setting('mastery[cfa_bg_color]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[cfa_bg_color]', array(
		'label' => __( 'CTA Section : Background Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
	)));


	$wp_customize->add_setting('mastery[w2f_cfa_text]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_strip_slashes',
	));
	$wp_customize->add_control('mastery[w2f_cfa_text]', array(
		'label' => __( 'Call To Action - Message Text', 'mastery' ),
		'description' => sprintf( __( 'Enter the text for CTA section', 'mastery' ) ),
		'section' => 'mastery_action_options',
		'type' => 'textarea',
	));


	$wp_customize->add_setting('mastery[cfa_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[cfa_color]', array(
		'label' => __( 'Call To Action - Message Text Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
	)));


	$wp_customize->add_setting('mastery[w2f_cfa_button]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_nohtml',
	));

	$wp_customize->add_control('mastery[w2f_cfa_button]', array(
		'label' => __( 'CTA Button Text', 'mastery' ),
		'section' => 'mastery_action_options',
		'description' => __( 'Enter the text for CTA button', 'mastery' ),
		'type' => 'text',
	));

	$wp_customize->add_setting('mastery[w2f_cfa_link]', array(
		'default' => '',
		'type' => 'option',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('mastery[w2f_cfa_link]', array(
		'label' => __( 'CTA button link', 'mastery' ),
		'section' => 'mastery_action_options',
		'description' => __( 'Enter the link for CTA button', 'mastery' ),
		'type' => 'text',
	));


	$wp_customize->add_setting('mastery[cfa_btn_txt_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[cfa_btn_txt_color]', array(
		'label' => __( 'CTA Button Text Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
	)));

	$wp_customize->add_setting('mastery[cfa_btn_bg_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));

	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[cfa_btn_bg_color]', array(
		'label' => __( 'CTA Button Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
	)));


	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[element_color_hover]', array(
		'label' => __( 'CTA Button Color on hover', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
		'settings' => 'mastery[element_color_hover]',
	)));

	$wp_customize->add_setting('mastery[cfa_btn_border_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[cfa_btn_border_color]', array(
		'label' => __( 'CTA Button Border Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_action_options',
	)));


	/* this setting overrides other buttons */
	/*
		$wp_customize->add_setting('mastery[element_color]', array(
			'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
			'type'  => 'option',
			'sanitize_callback' => 'mastery_sanitize_hexcolor',
		));
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[element_color]', array(
			'label' => __( 'CTA Button Color', 'mastery' ),
			'description'   => __( 'Default used if no color is selected','mastery' ),
			'section' => 'mastery_action_options',
			'settings' => 'mastery[element_color]',
		)));

		*/
	/* mastery Typography Options */
	$wp_customize->add_section('mastery_typography_options', array(
		'title' => __( 'Typography', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));
	// Typography Defaults
	$typography_defaults = array(
		'size'  => '14px',
		'face'  => 'Open Sans',
		'style' => 'normal',
		'color' => '#6B6B6B',
	);

	// Typography Options
	global $typography_options;
	$wp_customize->add_setting('mastery[main_body_typography][size]', array(
		'default' => $typography_defaults['size'],
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_typo_size',
	));
	$wp_customize->add_control('mastery[main_body_typography][size]', array(
		'label' => __( 'Main Body Text', 'mastery' ),
		'description' => __( 'Used in p tags', 'mastery' ),
		'section' => 'mastery_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['sizes'],
	));
	$wp_customize->add_setting('mastery[main_body_typography][face]', array(
		'default' => $typography_defaults['face'],
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_typo_face',
	));
	$wp_customize->add_control('mastery[main_body_typography][face]', array(
		'section' => 'mastery_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['faces'],
	));
	$wp_customize->add_setting('mastery[main_body_typography][style]', array(
		'default' => $typography_defaults['style'],
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_typo_style',
	));
	$wp_customize->add_control('mastery[main_body_typography][style]', array(
		'section' => 'mastery_typography_options',
		'type'    => 'select',
		'choices'    => $typography_options['styles'],
	));
	$wp_customize->add_setting('mastery[main_body_typography][color]', array(
		// 'default' => sanitize_hex_color( '#6B6B6B' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[main_body_typography][color]', array(
		'section' => 'mastery_typography_options',
	)));
	$wp_customize->add_setting('mastery[main_body_typography][subset]', array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_html'
    ));
    $wp_customize->add_control('mastery[main_body_typography][subset]', array(
        'label' => __('Font Subset', 'mastery'),
        'section' => 'mastery_typography_options',
        'description' => __('Enter the Google fonts subset', 'mastery'),
        'type' => 'text'
    ));

	$wp_customize->add_setting('mastery[heading_color]', array(
		// 'default' => sanitize_hex_color( '#444' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[heading_color]', array(
		'label' => __( 'Heading Color', 'mastery' ),
		'description'   => __( 'Color for all headings (h1-h6)','mastery' ),
		'section' => 'mastery_typography_options',
	)));
	$wp_customize->add_setting('mastery[link_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[link_color]', array(
		'label' => __( 'Link Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_typography_options',
	)));
	$wp_customize->add_setting('mastery[link_hover_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[link_hover_color]', array(
		'label' => __( 'Link:hover Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_typography_options',
	)));

	/* mastery Header Options */
	$wp_customize->add_section('mastery_header_options', array(
		'title' => __( 'Header Menu', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));

	$wp_customize->add_setting('mastery[sticky_menu]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery[sticky_menu]', array(
		'label' => __( 'Sticky Menu', 'mastery' ),
		'description' => sprintf( __( 'Check to show fixed header', 'mastery' ) ),
		'section' => 'mastery_header_options',
		'type' => 'epsilon-toggle',
	) ) );

//header-text-color
	$wp_customize->add_setting('mastery[header_text_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[header_text_color]', array(
		'label' => __( 'Header Text Color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_header_options',
	)));
//header-text-color

	$wp_customize->add_setting('mastery[nav_bg_color]', array(
		'default' => '', //sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_bg_color]', array(
		'label' => __( 'Top nav background color', 'mastery' ),
		'description'   => __( 'Default used if no color is selected','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_link_color]', array(
		// 'default' => sanitize_hex_color( '#000000' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_link_color]', array(
		'label' => __( 'Top nav item color', 'mastery' ),
		'description'   => __( 'Link color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_item_hover_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_item_hover_color]', array(
		'label' => __( 'Top nav item hover color', 'mastery' ),
		'description'   => __( 'Link:hover color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_dropdown_bg]', array(
		// 'default' => sanitize_hex_color( '#ffffff' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_dropdown_bg]', array(
		'label' => __( 'Top nav dropdown background color', 'mastery' ),
		'description'   => __( 'Background of dropdown item hover color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_dropdown_item]', array(
		// 'default' => sanitize_hex_color( '#636467' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_dropdown_item]', array(
		'label' => __( 'Top nav dropdown item color', 'mastery' ),
		'description'   => __( 'Dropdown item color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_dropdown_item_hover]', array(
		// 'default' => sanitize_hex_color( '#FFF' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_dropdown_item_hover]', array(
		'label' => __( 'Top nav dropdown item hover color', 'mastery' ),
		'description'   => __( 'Dropdown item hover color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	$wp_customize->add_setting('mastery[nav_dropdown_bg_hover]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[nav_dropdown_bg_hover]', array(
		'label' => __( 'Top nav dropdown item background hover color', 'mastery' ),
		'description'   => __( 'Background of dropdown item hover color','mastery' ),
		'section' => 'mastery_header_options',
	)));

	/* mastery Footer Options */
	$wp_customize->add_section('mastery_footer_options', array(
		'title' => __( 'Footer', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));
	$wp_customize->add_setting('mastery[footer_widget_bg_color]', array(
		// 'default' => sanitize_hex_color( 'rgba(59, 59, 59, 0.8)' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[footer_widget_bg_color]', array(
		'label' => __( 'Footer widget area background color', 'mastery' ),
		'section' => 'mastery_footer_options',
	)));

	$wp_customize->add_setting('mastery[footer_bg_color]', array(
		// 'default' => sanitize_hex_color( '#1F1F1F' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[footer_bg_color]', array(
		'label' => __( 'Footer background color', 'mastery' ),
		'section' => 'mastery_footer_options',
	)));

	$wp_customize->add_setting('mastery[footer_text_color]', array(
		// 'default' => sanitize_hex_color( '#999' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[footer_text_color]', array(
		'label' => __( 'Footer text color', 'mastery' ),
		'section' => 'mastery_footer_options',
	)));

	$wp_customize->add_setting('mastery[footer_link_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[footer_link_color]', array(
		'label' => __( 'Footer link color', 'mastery' ),
		'section' => 'mastery_footer_options',
	)));

	$wp_customize->add_setting('mastery[custom_footer_text]', array(
		//'default' => 'mastery',
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_strip_slashes',
	));
	$wp_customize->add_control('mastery[custom_footer_text]', array(
		'label' => __( 'Footer information', 'mastery' ),
		'description' => sprintf( __( 'Footer Text (like Copyright Message)', 'mastery' ) ),
		'section' => 'mastery_footer_options',
		'type' => 'textarea',
	));

	/* mastery Social Options */
	$wp_customize->add_section('mastery_social_options', array(
		'title' => __( 'Social', 'mastery' ),
		'priority' => 31,
		'panel' => 'mastery_main_options',
	));
	$wp_customize->add_setting('mastery[social_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[social_color]', array(
		'label' => __( 'Social icon color', 'mastery' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'mastery' ) ),
		'section' => 'mastery_social_options',
	)));

	$wp_customize->add_setting('mastery[social_footer_color]', array(
		// 'default' => sanitize_hex_color( '#DADADA' ),
		'type'  => 'option',
		'sanitize_callback' => 'mastery_sanitize_hexcolor',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mastery[social_footer_color]', array(
		'label' => __( 'Footer social icon color', 'mastery' ),
		'description' => sprintf( __( 'Default used if no color is selected', 'mastery' ) ),
		'section' => 'mastery_social_options',
	)));

	$wp_customize->add_setting('mastery[footer_social]', array(
		'default' => 0,
		'type' => 'option',
		'sanitize_callback' => 'mastery_sanitize_checkbox',
	));
	$wp_customize->add_control( new Epsilon_Control_Toggle( $wp_customize, 'mastery[footer_social]', array(
		'label' => __( 'Footer Social Icons', 'mastery' ),
		'description' => sprintf( __( 'Check to show social icons in footer', 'mastery' ) ),
		'section' => 'mastery_social_options',
		'type' => 'epsilon-toggle',
	) ) );

}
add_action( 'customize_register', 'mastery_customizer' );



/**
 * Sanitzie checkbox for WordPress customizer
 */
function mastery_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}
}
/**
 * Adds sanitization callback function: colors
 * @package mastery
 */
function mastery_sanitize_hexcolor( $color ) {
	$unhashed = sanitize_hex_color_no_hash( $color );
	if ( $unhashed ) {
		return '#' . $unhashed;
	}
	return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package mastery
 */
function mastery_sanitize_nohtml( $input ) {
	return wp_filter_nohtml_kses( $input );
}

/**
 * Adds sanitization callback function: Number
 * @package mastery
 */
function mastery_sanitize_number( $input ) {
	if ( isset( $input ) && is_numeric( $input ) ) {
		return $input;
	}
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package mastery
 */
function mastery_sanitize_strip_slashes( $input ) {
	return wp_kses_stripslashes( $input );
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package mastery
 */
function mastery_sanitize_textarea( $input ) {
	return sanitize_text_field( $input );
}

/**
 * Adds sanitization callback function: Slider Category
 * @package mastery
 */
function mastery_sanitize_slidecat( $input ) {
	global $options_categories;
	if ( array_key_exists( $input, $options_categories ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Sidebar Layout
 * @package mastery
 */
function mastery_sanitize_layout( $input ) {
	global $site_layout;
	if ( array_key_exists( $input, $site_layout ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Color Template
 * @package mastery
 */
function mastery_sanitize_template( $input ) {
	global $style_color;
	if ( array_key_exists( $input, $style_color ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Adds sanitization callback function: Typography Size
 * @package mastery
 */
function mastery_sanitize_typo_size( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
		return $input;
	} else {
		return $typography_defaults['size'];
	}
}
/**
 * Adds sanitization callback function: Typography Face
 * @package mastery
 */
function mastery_sanitize_typo_face( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['faces'] ) ) {
		return $input;
	} else {
		return $typography_defaults['face'];
	}
}
/**
 * Adds sanitization callback function: Typography Style
 * @package mastery
 */
function mastery_sanitize_typo_style( $input ) {
	global $typography_options, $typography_defaults;
	if ( array_key_exists( $input, $typography_options['styles'] ) ) {
		return $input;
	} else {
		return $typography_defaults['style'];
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mastery_customize_preview_js() {
	wp_enqueue_script( 'mastery_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20140317', true );
}
add_action( 'customize_preview_init', 'mastery_customize_preview_js' );

/*
 * Customizer Slider Toggle {category and numb of slides}
 */
add_action( 'customize_controls_print_footer_scripts', 'mastery_slider_toggle' );

function mastery_slider_toggle() {
	?>
<script>
	jQuery(document).ready(function() {
		/* This one shows/hides the an option when a checkbox is clicked. */
		jQuery('#customize-control-mastery-mastery_slide_categories, #customize-control-mastery-mastery_slide_number').hide();
		jQuery('#customize-control-mastery-mastery_slider_checkbox input').click(function() {
			jQuery('#customize-control-mastery-mastery_slide_categories, #customize-control-mastery-mastery_slide_number').fadeToggle(400);
		});

		if (jQuery('#customize-control-mastery-mastery_slider_checkbox input:checked').val() !== undefined) {
			jQuery('#customize-control-mastery-mastery_slide_categories, #customize-control-mastery-mastery_slide_number').show();
		}
	});
</script>
<?php
}
