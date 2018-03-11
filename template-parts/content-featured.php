<?php
/**
 * The template part for displaying content
 *
 * @package Nadege
 * @since Nadege 1.0
 */
?>
<?php $display_class = 'overlay-thumbnail'; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $display_class ); ?>>

	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><?php esc_html_e( 'Featured', 'nadege' ); ?></span>
		<?php endif; ?>

		<div class="entry-meta">
			<?php nadege_entry_meta(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<?php //nadege_excerpt(); ?>

	<?php nadege_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->