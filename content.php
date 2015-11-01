<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
        <div class="header__container--addborder">
            <div class="category-list ribbon">
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    echo '<a rel="nofollow" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                }
                ?>
            </div>
    		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="header__container--meta row">
                <div class="header__container--author columns large-4 small-4 text-center"><?php echo get_avatar( $post->post_author, 35 ); ?> <span class="name"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span> </div>
                <div class="header__container--time columns large-4 small-4 text-center"><?php the_time( get_option( 'date_format' ) ); ?></div>
                <div class="header__container--comments columns large-4 small-4 text-center"><a href="<?php comments_link(); ?>"><?php comments_number( 'No comments', 'One Comment', '% Comments' ); ?></a> </div>
            </div>
        </div>
	</header>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading...', 'foundationpress' ) ); ?>
	</div>
	<footer>

	</footer>
	<hr />
</article>
