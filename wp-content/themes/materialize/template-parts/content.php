<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Materialize
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card">
    <div class="card-image">
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		} else { ?>
			<img src="<?php bloginfo('template_directory'); ?>/img/default.png" alt="<?php the_title(); ?>" />
		<?php } ?>
     <span class="card-title">	
    	<header class="entry-header">
				<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
			</header><!-- .entry-header -->
			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php materialize_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		 </span>
    </div>
 
		<div class="card-content">
			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
			
					if (! is_single()) {
						the_excerpt( sprintf(
							__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'immaterial' ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );
					} else {
						the_content( sprintf(
							__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'immaterial' ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );
					}
				?>
 
				<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'immaterial' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div>
		<div class="card-action">
			<footer class="entry-footer">
				<?php materialize_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div>
</article><!-- #post-## -->