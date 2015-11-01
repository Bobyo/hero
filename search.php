<?php
/**
 * The template for displaying search results pages.
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
        if ( ! empty( get_header_image() ) ) :
            $thumb = header_image();
        endif;
    }

    return $thumb;

  }

?>



<div class="le-hero has-background is-gray search" style="background-image: url( <?php echo getadminimage(); ?> )">
    <header>
        <div class="row valign-middle">
            <div class="column large-12 medium-12 small-12 text-center">
                <h2><?php _e( 'Search Results for', 'foundationpress' ); ?> "<?php echo get_search_query(); ?>"</h2>
            </div>
        </div>
    </header>
</div>
<div class="row">
	<div class="small-12 large-8 columns large-push-2" role="main">

		<?php do_action( 'foundationpress_before_content' ); ?>


	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', get_post_format() ); ?>
		<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>

	<?php endif;?>

	<?php do_action( 'foundationpress_before_pagination' ); ?>

	<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>

		<nav id="post-nav">
			<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
			<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
		</nav>
	<?php } ?>

	<?php do_action( 'foundationpress_after_content' ); ?>

	</div>
</div>
<?php get_footer(); ?>
