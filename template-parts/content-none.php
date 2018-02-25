<?php
/**
* This template is displayed when there is not any posts to show in home or archive page and the search page.
*
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
* @package mastery
*/
?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'mastery' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php
				$wp_kses_args = array(
					'a' => array(
						'href' => array(),
					),
				);
				printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mastery' ), $wp_kses_args ), esc_url( admin_url( 'post-new.php' ) ) );

			?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mastery' ); ?></p>
			<?php
			get_search_form();
		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mastery' ); ?></p>
			<?php
			get_search_form();
		endif;

		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
