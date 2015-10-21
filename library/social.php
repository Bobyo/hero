<?php
/**
 * Create our very own social buttons on the bottom of the page
 *
 * @package WordPress
 * @subpackage Hero
 * @since Hero 1.1.0
 */

function get_first_image()
{
    global $post, $posts;
    $first_img = '';
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1];
    if(empty($first_img)) $first_img = false;
    return $first_img;
}

function hero_social_sharing_buttons($content) {
    // Show this on post and page only. Add filter is_home() for home page
        global $post, $posts;

        // Get current page URL
        $shortURL = get_permalink();

        $thumb = get_first_image();
        if(!$thumb) {
            $thumb=wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $thumb=$thumb[0];
        }

        // Get current page title
        // $shortTitle = get_the_title(); --> update below

        $shortTitle = str_replace( ' ', '%20', get_the_title());

        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$shortTitle.'&amp;url='.$shortURL.'&amp;via='.hero_options( 'twitter' );
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$shortURL;
        $googleURL = 'https://plus.google.com/share?url='.$shortURL;
        $pinterestURL = 'http://pinterest.com/pin/create/button/?url='.$shortURL.'&media='.$thumb.'&description='.$shortTitle;

        // Add sharing button at the end of page/page content
        $content .= '<div class="social">';
        $content .= '<a class="fb" href="'. $twitterURL .'" target="_blank"><i class="fa fa-twitter"></i></a>';
        $content .= '<a class="tw" href="'.$facebookURL.'" target="_blank"><i class="fa fa-facebook"></i></a>';
        $content .= '<a class="gpls" href="'.$googleURL.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
        $content .= '<a class="pin" href="'.$pinterestURL.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
        $content .= '</div>';
        return $content;

};
add_filter( 'the_content', 'hero_social_sharing_buttons');
?>
