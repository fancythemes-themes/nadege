<?php
/**
 * The template for displaying search results pages
 *
 * 
 * @package Nadege
 * @since Nadege 1.0
 */

get_header(); ?>

	<?php nadege_breadcrumbs(); ?>

	<?php $list_class = get_theme_mod( 'search_blog_list_view', 'list') . '-view'; ?>
	<section id="primary" class="content-area <?php echo esc_attr($list_class); ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						/* translators: %s: search keyword */ 
						printf( esc_html__( 'Search Results for: %s', 'nadege' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				if ( 'classic' == get_theme_mod( 'archive_blog_list_view', 'list') )
					get_template_part( 'template-parts/content', get_post_format() );
				else
					get_template_part( 'template-parts/content-list', get_post_format() );

			// End the loop.
			endwhile;

			nadege_posts_pagination();

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
