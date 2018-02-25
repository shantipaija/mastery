<?php
/**
 * @package mastery
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-item-wrap">
		<?php

			$content = apply_filters( 'the_content', get_the_content() );
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );

			if ( ! empty( $video ) ) {
				foreach ( $video as $video_html ) {
					echo '<div class="entry-video">';
						echo $video_html;
					echo '</div>';
				}
			}elseif ( has_post_thumbnail() ) {
				$thumbnail_args = array(
					'class' => 'single-featured',
				);
				$title_args = array(
					'echo' => false,
				);
				echo '<a href="' . get_the_permalink() . '" title="' . the_title_attribute( $title_args ) . '" >';
				the_post_thumbnail( 'mastery-featured', $thumbnail_args);
				echo '</a>';
			}

		?>
		<div class="post-inner-content">
			<header class="entry-header page-header">

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php mastery_posted_on(); ?>

                    <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link"><i class="fa fa-comment-o"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'mastery' ), esc_html__( '1 Comment', 'mastery' ), esc_html__( '% Comments', 'mastery' ) ); ?></span>
				<?php endif; ?>


				</div><!-- .entry-meta -->

                <?php socialmedia_share_button(); ?>
				<?php if ( get_edit_post_link() ) : ?>
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
				<?php endif; ?>
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'mastery' ); ?></a></p>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">

			<?php

                if ( (get_theme_mod( 'mastery_excerpts' ) == 1 ) && (! is_single()) ) {
					the_excerpt();?>
					<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read More', 'mastery' ); ?></a></p>
                    <?php
                }else{
                    the_content( esc_html__( 'Read More', 'mastery' ) );
                }

            ?>

				<?php
					wp_link_pages( array(
						'before'            => '<div class="page-links">' . esc_html__( 'Pages:', 'mastery' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1,
					) );
				?>
			</div><!-- .entry-content -->
			<?php endif; ?>
            
            <?php socialmedia_share_button('full'); ?>
		</div>
	</div>
</article><!-- #post-## -->
