<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<?php
	// display live search box.
	echo do_shortcode( '[doc_wp_live_search]' );
?>
<div class="wrap docs-wraper">

	<div id="primary" class="content-area grid-parent mobile-grid-100 grid-75 tablet-grid-75">
		<main id="main" class="in-wrap" role="main">

		<?php if ( have_posts() ) : ?>
		<div class="bsf-page-header">
			<?php

				echo '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>';
				the_archive_description( '<div class="bsf-taxonomy-description">', '</div>' );

			if ( function_exists( 'yoast_breadcrumb' ) ) {
				echo '<div class="bsf-tax-breadcrumb">' . do_shortcode( '[wpseo_breadcrumb]' ) . '</div>';
			}
			?>
		</div><!-- .page-header -->
	<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<?php
				$current_category = get_queried_object();
				$current_category_id = $current_category->term_id;

				$termchildren = get_terms('docs_category',array('child_of' => $current_category_id));

				if ( $termchildren && ! is_wp_error( $termchildren ) ) :
				?>

				<div class="bsf-page-header bsf-categories-wrap clearfix">
					<?php
					foreach ( $termchildren as $key => $object ) {
						?>
						<div class="bsf-cat-col" >
							<a class="bsf-cat-link" href="<?php echo esc_url( get_term_link( $object->slug, $object->taxonomy ) ); ?>">
								<h4><?php echo esc_html( $object->name ); ?></h4>
								<span class="bsf-cat-count">
									<?php /* translators: %s: article count term */ ?>
									<?php printf( __( '%1$s Articles', 'bsf-docs' ), $object->count ); ?>
								</span>
							</a>
						</div>

					<?php
						// }
					}
					?>
				</div>

				<?php
				endif;
			?>
		<?php endif; ?>

		<?php
		if ( have_posts() ) :
		?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file.
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				?>
				<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> post type-docs status-publish format-standard docs_category">
					<h2 class="bsf-entry-title">
						<a rel="bookmark" href="<?php echo esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>
				</article>
				<?php
			endwhile;
			the_posts_pagination(
				array(
					'prev_text' => '&laquo;<span class="screen-reader-text">' . __( 'Previous page', 'bsf-docs' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'bsf-docs' ) . '</span>&raquo;',
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'bsf-docs' ) . ' </span>',
				)
			);

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div itemscope="itemscope" id="secondary" class="widget-area sidebar grid-25 tablet-grid-25 grid-parent docs-sidebar-area secondary" role="complementary">
			<div class="sidebar-main content-area">
				<?php dynamic_sidebar( 'docs-sidebar-1' ); ?>
			</div>
		</div>
</div><!-- .wrap -->

<?php get_footer(); ?>
