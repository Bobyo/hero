<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<header id="front-hero" role="banner">
    <div class="marketing hero-bg gray">
            <div class="row valign-middle setting-height">
                <div class="columns text-center">
                    <div class="hero-thumb">
                        <img src="https://s3.amazonaws.com/uifaces/faces/twitter/soffes/73.jpg" alt="@soffes">
                    </div>
                    <div class="tagline">
                        <h1><?php echo get_theme_mod( 'hero_tagline_main' ) ?></h1>
                        <h4 class="subheader"><?php bloginfo( 'description' ); ?></h4>
                    </div>

                    <div id="watch" class="small-12 columns">
                        <section id="stargazers">
                            <a href="https://github.com/olefredrik/foundationpress">1.5k stargazers</a>
                        </section>
                        <section id="twitter">
                            <a href="https://twitter.com/olefredrik">@olefredrik</a>
                        </section>
                    </div>
                </div>
            </div>
    </div>

</header>

<div class="row">
	<?php get_template_part( 'parts/check-if-sidebar-exist' ); ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'foundationpress_before_content' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>

		<?php do_action( 'foundationpress_before_pagination' ); ?>

	<?php endif;?>



	<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
		</nav>
	<?php } ?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
