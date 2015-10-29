<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<?php
  function getadminimage() {
    global $post;

    $args = array(
        'numberposts' => 1,
        'post_mime_type' => 'image',
        'post_parent' => $post->ID,
        'post_type' => 'attachment',
        'post_status' => null,
        );
    $attachments = get_posts( $args );

    if ( has_post_thumbnail() ) {
        $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
        $thumb = $url[0];
    } elseif ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            $thumb = wp_get_attachment_image_src( $attachment->ID, array(5000, 1000), false, '' );
        }

    } else {

    }

    return $thumb;

  }

?>



<div class="le-hero hero-admin has-background is-gray" style="background-image: url( <?php echo getadminimage(); ?> )">
    <header>
        <div class="row valign-middle">
            <div class="column large-12 medium-12 small-12">
                <?php if ( is_author() ) : ?>
                    <div class='author-avatar text-center'>
                        <?php echo get_avatar( $post->post_author, 150 ); ?>
                    </div>
                    <h2 class="entry-title text-center"><?php the_author(); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </header>
</div>

<div class="row">
<!-- Row for main content area -->
	<div class="small-12 large-8 columns" role="main">

	<?php if ( have_posts() ) : ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>

	<?php endif; // End have_posts() check. ?>

	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
		</nav>
	<?php } ?>

	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
