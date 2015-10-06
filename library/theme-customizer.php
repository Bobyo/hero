<?php
/**
 * Register theme support for languages, menus, post-thumbnails, post-formats etc.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

function hero_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'hero_logo_section' , array(
        'title'       => __( 'Logo', 'hero' ),
        'priority'    => 30,
        'description' => 'Upload a logo to replace the default site name and description in the header. If no image is uploaded, then the basic blog name will be used.',
        ) );

    $wp_customize->add_setting( 'hero_logo' );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_logo', array(
        'label'    => __( 'Logo', 'hero' ),
        'section'  => 'hero_logo_section',
        'settings' => 'hero_logo',
        ) ) );
}
add_action( 'customize_register', 'hero_theme_customizer' );

function twentythirteen_custom_header_setup() {
    $args = array(
        // Text color and image (empty to use none).
        'default-text-color'     => '220e10',
        'default-image'          => '%s/assets/images/headers/stars.jpeg',

        // Set height and width, with a maximum value for the width.
        'height'                 => 230,
        'width'                  => 1600,

        // Callbacks for styling the header and the admin preview.
        'wp-head-callback'       => 'twentythirteen_header_style',
    );

    add_theme_support( 'custom-header', $args );

    /*
     * Default custom headers packaged with the theme.
     * %s is a placeholder for the theme template directory URI.
     */
    register_default_headers( array(
        'circle' => array(
            'url'           => '%s/assets/images/headers/stars.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/circle-thumbnail.png',
            'description'   => _x( 'Circle', 'header image description', 'twentythirteen' )
        ),
        'diamond' => array(
            'url'           => '%s/assets/images/headers/woods.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/diamond-thumbnail.png',
            'description'   => _x( 'Diamond', 'header image description', 'twentythirteen' )
        ),
        'star' => array(
            'url'           => '%s/assets/images/headers/gazing.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/star-thumbnail.png',
            'description'   => _x( 'Star', 'header image description', 'twentythirteen' )
        ),
    ) );
}
add_action( 'after_setup_theme', 'twentythirteen_custom_header_setup', 11 );

function twentythirteen_header_style() {
    $header_image = get_header_image();
    $text_color   = get_header_textcolor();

    // If no custom options for text are set, let's bail.
    if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
        return;

    // If we get this far, we have custom styles.
    ?>
    <style type="text/css" id="hero-header-css">
    <?php
        if ( ! empty( $header_image ) ) :
    ?>
        #front-hero {
            background: url(<?php header_image(); ?>) no-repeat scroll top;
            background-size: 1600px auto;
        }
    <?php
        endif;

        // Has the text been hidden?
        if ( ! display_header_text() ) :
    ?>
        .site-title,
        .site-description {
            position: absolute;
            clip: rect(1px 1px 1px 1px); /* IE7 */
            clip: rect(1px, 1px, 1px, 1px);
        }
    <?php
            if ( empty( $header_image ) ) :
    ?>
        .site-header .home-link {
            min-height: 0;
        }
    <?php
            endif;

        // If the user has set a custom color for the text, use that.
        elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
    ?>
        .site-title,
        .site-description {
            color: #<?php echo esc_attr( $text_color ); ?>;
        }
    <?php endif; ?>
    </style>
    <?php
}

?>


