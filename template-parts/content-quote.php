<?php
/**
 * The template part for displaying content
 *
 * 
 * @package Nadege
 * @since Nadege 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><?php _e( 'Featured', 'nadege' ); ?></span>
		<?php endif; ?>

		<div class="entry-meta">
			<?php nadege_entry_meta(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<?php nadege_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				wp_kses ( __( '%1$s<span class="screen-reader-text"> "%2$s"</span>', 'nadege' ), nadege_only_allow_span() ),
				__('Continue reading', 'nadege'),
				get_the_title()
			) );

			nadege_entry_taxonomies();

			if ( function_exists( 'sharing_display' ) ) {
				sharing_display( '', true );
			}

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'nadege' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'nadege' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
