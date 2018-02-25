<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-inner-content search-post-inner-content">
		<header class="entry-header page-header search-header">
        
			<h2 class="entr y-title search-title "><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="search-url"><?php the_permalink(); ?></div>
			<div class="entry-meta search-entry-meta">
				<?php //mastery_posted_on(); ?>

				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( esc_html__( ', ', 'mastery' ) );
				if ( $categories_list && mastery_categorized_blog() ) :
				?>
				<span class="cat-links"><i class="fa fa-folder-open-o"></i>
				<?php printf( esc_html__( ' %1$s', 'mastery' ), $categories_list ); ?>
				</span>
				<?php endif; // End if categories ?>
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

			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-content search-result-content">
			<?php 
			// the_content(); 
			?>
            <span class="search-post-thumb">
			<?php 
            the_post_thumbnail( array(150,150) );
            ?>
            </span>
            <?php
			the_excerpt();
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
		  <div class="tagcloud search-tagcloud">

				<?php
				  $tags = get_the_tags( get_the_ID() );
				foreach ( $tags as $tag ) {
					echo '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a> ';
				} ?>

		  </div>
		  <!-- end tags -->
			<?php endif; ?>

		</footer><!-- .entry-meta -->
	</div>
</article><!-- #post-## -->
