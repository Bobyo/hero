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
                        <?php if ( get_theme_mod( 'hero_admin_avatar' ) ) : ?>
                            <div class='author-avatar'>
                                <img src='<?php echo esc_url( get_theme_mod( 'hero_admin_avatar' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tagline">
                        <h1><?php echo get_theme_mod( 'hero_tagline_main' ) ?></h1>
                        <h4 class="subheader"><?php bloginfo( 'description' ); ?></h4>
                    </div>
                    <?php if ( hero_options( 'hide_social' ) == '0' ) :
                    echo ' <div id="watch" class="small-12 columns"><section id="facebook"><a href="https://facebook.com/' .hero_options( 'facebook' ). '">' .hero_options( 'facebook' ). '</a></section>
<section id="twitter"><a href="https://twitter.com/' .hero_options( 'twitter' ). '">' .hero_options( 'twitter' ). '</a></section></div> ';
                    endif; ?>
                </div>
            </div>
    </div>

</header>

<div class="row">
    <?php if(hero_options('hero_hide_sidebar') == '0') : ?>
    	<?php get_template_part( 'parts/check-if-sidebar-exist' ); ?>
    <?php else :
        echo '<div class="small-12 large-8 large-push-2 columns" role="main">';
    endif ?>

	<?php if ( have_posts() ) : ?>

		<?php do_action( 'foundationpress_before_content' ); ?>

		<?php while ( have_posts() ) : the_post(); ?>
            <?php if ( has_post_format( 'image' )) {
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail();
                    echo '<a class="hide playbutton" href="' . esc_url( get_permalink() ) . '"><i class="fa fa-play "></i></a>';
                }
        } ?>

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
    <?php if(hero_options('hero_hide_sidebar') == '0') :
	   echo get_sidebar();
    endif ?>
</div>
<?php get_footer(); ?>
