<?php



 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>  itemscope itemtype="https://schema.org/CreativeWork">
    <?php
    $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

    if  ( ! empty( $featured_image_url ) ) : ?>
  	<div class="imghov">
  		<div class="tiles">
  			<div
  			 data-scale="1.3"
  			 data-image="<?php echo get_the_post_thumbnail_url(get_the_ID(),'mastery-featured' ); ?>"
  			 class="zoom-thumbnail-tile <?php
  			if ( is_page_template( 'page-fullwidth.php' ) ) {
  				echo "single-featured fullwidth";
  			} else {
  				echo "single-featured sidebars";
  			}
  			?>"></div>
  		</div>
	</div>
  <?php endif; ?>
	<div class="post-inner-content">
		<header class="entry-header col-md-12 page-header">

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-meta  nomargin">

				<?php  //mastery_author_name(); ?>
				<?php mastery_posted_on(); ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', 'mastery' ) );
				if ( $categories_list && mastery_categorized_blog() ) :
				?>
				<span class="cat-links meta-blocks"><i class="fa fa-folder-open-o fa-lg"></i> Category<br />
				<?php printf( esc_html__( ' %1$s', 'mastery' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>
			</div><!-- .entry-meta -->
      <div class="clear"></div>
      <div>
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
      </div>
		</header><!-- .entry-header -->

		<div class="entry-content">
            <?php //the_content( esc_html__( 'Read More...', 'mastery' ) ); ?>

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

		<footer class="entry-meta">

			<?php if ( has_tag() ) : ?>
		  <!-- tags -->
		  <div class="tagcloud">

				<?php
				  $tags = get_the_tags( get_the_ID() );
				foreach ( $tags as $tag ) {
					echo '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a> ';
				} ?>

		  </div>
		  <!-- end tags -->
			<?php endif; ?>

            <?php

                socialmedia_share_button('','medium');

            ?>
		</footer><!-- .entry-meta -->

	</div>
	<?php if ( get_theme_mod( 'mastery_post_author_bio' ) == 1 ) : ?>
		<div class="post-inner-content secondary-content-box">
	  	<!-- author bio -->
	  		<div class="author-bio content-box-inner">

			<!-- avatar -->
				<div class="avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID' ) , '60' ); ?>
				</div>
			<!-- end avatar -->

			<!-- user bio -->
				<div class="author-bio-content">
		  			<h4 class="author-name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a></h4>
				  	<p class="author-description">
				  		<?php
					  		if ( get_the_author_meta( 'description' ) ) :
								echo get_the_author_meta( 'description' );
							endif;
						?>
				  	</p>
				</div><!-- end .author-bio-content -->
	  		</div><!-- end .author-bio  -->
		</div>
	<?php endif; ?>
</article><!-- #post-## -->
