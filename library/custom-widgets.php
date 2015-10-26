<?php
/**
 * Register widget areas
 *
 * @package WordPress
 * @subpackage Hero
 * @since Hero 1.0.0
 */

// Recent posts
class Hero_WP_Widget_Recent_Posts extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site HERO") );
        parent::__construct('recent-posts', __('Recent Posts HERO'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <div class="widget-list">
        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <div class="post-entry">
                <div class="row">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="column small-12 large-3"><a class='image-thumbnail' href="<?php the_permalink() ?>"><?php the_post_thumbnail( array(50, 50) ) ?></a></div>
                <?php endif; ?>

                <?php if ( has_post_format( 'video' ) ) :
                    echo "<div class='column small-12 large-3 text-center'><i class='fa fa-video-camera'></i></div>";
                elseif ( has_post_format( 'image' ) ) :
                    echo "";
                else :
                    echo "<div class='column small-12 large-3 text-center'><i class='fa fa-thumb-tack'></i></div>";
                endif; ?>

                <div class="column small-12 large-9">
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
            <?php if ( $show_date ) : ?>
                <span class="post-date"><?php echo get_the_date(); ?></span>
            <?php endif; ?>
                </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
        <?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
    }
}

/**
 * WP Instagram Widget
 *
 * @package WordPress
 * @subpackage WP Instagram Widget
 * Description: WP Instagram widget is a no fuss WordPress widget to showcase your latest Instagram pics.
 * Author: Scott Evans
 * Author URI: http://scott.ee
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @since WP Instagram Widget 1.8.1
 */


class null_instagram_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'null-instagram-feed',
            __( 'Instagram', 'wp-instagram-widget' ),
            array( 'classname' => 'null-instagram-feed', 'description' => __( 'Displays your latest Instagram photos', 'wp-instagram-widget' ) )
        );
    }
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
        $username = empty( $instance['username'] ) ? '' : $instance['username'];
        $limit = empty( $instance['number'] ) ? 9 : $instance['number'];
        $size = empty( $instance['size'] ) ? 'large' : $instance['size'];
        $target = empty( $instance['target'] ) ? '_self' : $instance['target'];
        $link = empty( $instance['link'] ) ? '' : $instance['link'];
        echo $before_widget;
        if ( ! empty( $title ) ) { echo $before_title . $title . $after_title; };
        do_action( 'wpiw_before_widget', $instance );
        if ( $username != '' ) {
            $media_array = $this->scrape_instagram( $username, $limit );
            if ( is_wp_error( $media_array ) ) {
                echo $media_array->get_error_message();
            } else {
                // filter for images only?
                if ( $images_only = apply_filters( 'wpiw_images_only', FALSE ) )
                    $media_array = array_filter( $media_array, array( $this, 'images_only' ) );
                // filters for custom classes
                $ulclass = esc_attr( apply_filters( 'wpiw_list_class', 'instagram-pics instagram-size-' . $size ) );
                $liclass = esc_attr( apply_filters( 'wpiw_item_class', '' ) );
                $aclass = esc_attr( apply_filters( 'wpiw_a_class', '' ) );
                $imgclass = esc_attr( apply_filters( 'wpiw_img_class', '' ) );
                ?><ul class="<?php echo esc_attr( $ulclass ); ?>"><?php
                foreach ( $media_array as $item ) {
                    // copy the else line into a new file (parts/wp-instagram-widget.php) within your theme and customise accordingly
                    if ( locate_template( 'parts/wp-instagram-widget.php' ) != '' ) {
                        include locate_template( 'parts/wp-instagram-widget.php' );
                    } else {
                        echo '<li class="'. $liclass .'"><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'"  class="'. $aclass .'"><img src="'. esc_url( $item[$size] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"  class="'. $imgclass .'"/></a></li>';
                    }
                }
                ?></ul><?php
            }
        }
        if ( $link != '' ) {
            ?><span class="clear instagram-tag"><a class="has-tip tip-right" title="Follow Me!" data-tooltip data-options="disable_for_touch:true" aria-haspopup="true" href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>"><i class="fa fa-instagram"></i></a></span><?php
        }
        do_action( 'wpiw_after_widget', $instance );
        echo $after_widget;
    }
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Instagram', 'wp-instagram-widget' ), 'username' => '', 'size' => 'large', 'link' => __( 'Follow Me!', 'wp-instagram-widget' ), 'number' => 9, 'target' => '_self' ) );
        $title = esc_attr( $instance['title'] );
        $username = esc_attr( $instance['username'] );
        $number = absint( $instance['number'] );
        $size = esc_attr( $instance['size'] );
        $target = esc_attr( $instance['target'] );
        $link = esc_attr( $instance['link'] );
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wp-instagram-widget' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username', 'wp-instagram-widget' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of photos', 'wp-instagram-widget' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Photo size', 'wp-instagram-widget' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" class="widefat">
                <option value="thumbnail" <?php selected( 'thumbnail', $size ) ?>><?php _e( 'Thumbnail', 'wp-instagram-widget' ); ?></option>
                <option value="small" <?php selected( 'small', $size ) ?>><?php _e( 'Small', 'wp-instagram-widget' ); ?></option>
                <option value="large" <?php selected( 'large', $size ) ?>><?php _e( 'Large', 'wp-instagram-widget' ); ?></option>
                <option value="original" <?php selected( 'original', $size ) ?>><?php _e( 'Original', 'wp-instagram-widget' ); ?></option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e( 'Open links in', 'wp-instagram-widget' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>" class="widefat">
                <option value="_self" <?php selected( '_self', $target ) ?>><?php _e( 'Current window (_self)', 'wp-instagram-widget' ); ?></option>
                <option value="_blank" <?php selected( '_blank', $target ) ?>><?php _e( 'New window (_blank)', 'wp-instagram-widget' ); ?></option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link text', 'wp-instagram-widget' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" /></label></p>
        <?php
    }
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['username'] = trim( strip_tags( $new_instance['username'] ) );
        $instance['number'] = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
        $instance['size'] = ( ( $new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large' || $new_instance['size'] == 'small' || $new_instance['size'] == 'original' ) ? $new_instance['size'] : 'large' );
        $instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_self' );
        $instance['link'] = strip_tags( $new_instance['link'] );
        return $instance;
    }
    // based on https://gist.github.com/cosmocatalano/4544576
    function scrape_instagram( $username, $slice = 9 ) {
        $username = strtolower( $username );
        $username = str_replace( '@', '', $username );
        if ( false === ( $instagram = get_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ) ) ) ) {
            $remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );
            if ( is_wp_error( $remote ) )
                return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
            if ( 200 != wp_remote_retrieve_response_code( $remote ) )
                return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
            $shards = explode( 'window._sharedData = ', $remote['body'] );
            $insta_json = explode( ';</script>', $shards[1] );
            $insta_array = json_decode( $insta_json[0], TRUE );
            if ( ! $insta_array )
                return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
                $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
            } else {
                return new WP_Error( 'bad_json_2', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            }
            if ( ! is_array( $images ) )
                return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'wp-instagram-widget' ) );
            $instagram = array();
            foreach ( $images as $image ) {
                $image['thumbnail_src'] = preg_replace( "/^https:/i", "", $image['thumbnail_src'] );
                $image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
                $image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
                $image['large'] = $image['thumbnail_src'];
                $image['display_src'] = preg_replace( "/^https:/i", "", $image['display_src'] );
                if ( $image['is_video'] == true ) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }
                $caption = __( 'Instagram Image', 'wp-instagram-widget' );
                if ( ! empty( $image['caption'] ) ) {
                    $caption = $image['caption'];
                }
                $instagram[] = array(
                    'description'   => $caption,
                    'link'          => '//instagram.com/p/' . $image['code'],
                    'time'          => $image['date'],
                    'comments'      => $image['comments']['count'],
                    'likes'         => $image['likes']['count'],
                    'thumbnail'     => $image['thumbnail'],
                    'small'         => $image['small'],
                    'large'         => $image['large'],
                    'original'      => $image['display_src'],
                    'type'          => $type
                );
            }
            // do not set an empty transient - should help catch private or empty accounts
            if ( ! empty( $instagram ) ) {
                $instagram = base64_encode( serialize( $instagram ) );
                set_transient( 'instagram-media-5-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
            }
        }
        if ( ! empty( $instagram ) ) {
            $instagram = unserialize( base64_decode( $instagram ) );
            return array_slice( $instagram, 0, $slice );
        } else {
            return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'wp-instagram-widget' ) );
        }
    }
    function images_only( $media_item ) {
        if ( $media_item['type'] == 'image' )
            return true;
        return false;
    }
}

/**
 * Advanced Text widget class
 */
class hero_about_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'hero_about_widget',
      __('About me widget special for showcasing your person on the site.'),
      array( 'description' => __( 'You can have any kind of html/shrotcodes here.', 'hero' ), )
    );
  }

  function widget( $args, $instance ) {
    extract($args);
    $title = apply_filters( 'hero_about_widget', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
    $text = apply_filters( 'hero_about_widget', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
    $class = apply_filters( 'hero_about_widget', empty( $instance['class'] ) ? '' : $instance['class'], $instance );

    echo $before_widget;
    if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
      <div class="hero_about_widget <?php echo $class; ?>"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
    <?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['class'] = strip_tags($new_instance['class']);

    if ( current_user_can('unfiltered_html') )
      $instance['text'] =  $new_instance['text'];
    else
      $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
    $instance['filter'] = isset($new_instance['filter']);

    return $instance;
  }

  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array(
        'title' => '',
        'text' => '',
        'class' => ''
      )
    );
    $title = strip_tags($instance['title']);
    $text = esc_textarea($instance['text']);
    $class = esc_textarea($instance['class']);
  ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

    <p><label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Class:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" /></p>

    <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>">
        <?php echo $text; ?>
    </textarea>

    <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
  <?php
  }
}

function hero_register_custom_widgets() {
    register_widget( 'Hero_WP_Widget_Recent_Posts' );
    register_widget( 'null_instagram_widget' );
    register_widget( 'hero_about_widget' );
}
add_action( 'widgets_init', 'hero_register_custom_widgets' );
?>
