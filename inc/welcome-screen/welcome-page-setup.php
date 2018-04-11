<?php

add_action( 'customize_register', 'mastery_welcome_customize_register' );

function mastery_welcome_customize_register( $wp_customize ) {

		global $mastery_required_actions, $mastery_recommended_plugins;
		$theme_slug = 'mastery';
		$customizer_recommended_plugins = array();
	if ( is_array( $mastery_recommended_plugins ) ) {
		foreach ( $mastery_recommended_plugins as $k => $s ) {
			if ( $s['recommended'] ) {
				$customizer_recommended_plugins[ $k ] = $s;
			}
		}
	}

		$wp_customize->add_section(
			new Epsilon_Section_Recommended_Actions(
				$wp_customize,
				'epsilon_recomended_section',
				array(
					'title'                         => esc_html__( 'Recomended Actions', 'mastery' ),
					'social_text'                   => esc_html__( 'We are social :', 'mastery' ),
					'plugin_text'                   => esc_html__( 'Recomended Plugins :', 'mastery' ),
					'actions'                       => $mastery_required_actions,
					'plugins'                       => $customizer_recommended_plugins,
					'theme_specific_option'         => $theme_slug . '_show_required_actions',
					'theme_specific_plugin_option'  => $theme_slug . '_show_recommended_plugins',
					'facebook'                      => '//www.facebook.com/LogHQ/',
					'twitter'                       => '//www.twitter.com/logHQ/',
					'wp_review'                     => false,  // Review this theme on w.org
					'priority'                      => 0,
				)
			)
		);

		$wp_customize->add_section(
			new Epsilon_Section_Pro(
				$wp_customize,
				'epsilon-section-pro',
				array(
					'title'       => esc_html__( 'Mastery', 'mastery' ),
					'button_text' => esc_html__( 'Documentation', 'mastery' ),
					'button_url'  => esc_url_raw( 'https://wp.login.plus/doc/mastery-theme-documentation/' ),
					'priority'    => 0,
				)
			)
		);

}

add_action( 'customize_controls_enqueue_scripts', 'mastery_welcome_scripts_for_customizer', 0 );

function mastery_welcome_scripts_for_customizer() {
	wp_enqueue_style( 'mastery-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/welcome-screen/css/welcome_customizer.css' );
	wp_enqueue_style( 'plugin-install' );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );
	wp_enqueue_script( 'mastery-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/welcome-screen/js/welcome_customizer.js', array( 'customize-controls' ), '1.0', true );

	wp_localize_script( 'mastery-welcome-screen-customizer-js', 'masteryWelcomeScreenObject', array(
		'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
		'template_directory'       => get_template_directory_uri(),
	) );

}

// Load the system checks ( used for notifications )
require get_template_directory() . '/inc/welcome-screen/class-mastery-notify-system.php';

// Welcome screen
if ( is_admin() ) {
	global $mastery_required_actions, $mastery_recommended_plugins;
	$mastery_recommended_plugins = array(
		'notice-box-loghq'    => array(
			'recommended' => true,
		),
	);
	/*
	 * id - unique id; required
	 * title
	 * description
	 * check - check for plugins (if installed)
	 * plugin_slug - the plugin's slug (used for installing the plugin)
	 *
	 */


	$mastery_required_actions = array();
	require get_template_directory() . '/inc/welcome-screen/class-mastery-welcome.php';
}// End if().
