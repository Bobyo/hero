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

// function hero_theme_bgColor ( $wp_customize ) {
//     $wp_customize->add_section( 'hero_bgColor', array(
//         'title'         => __( 'Hero overlay Background', 'hero' ),
//         'priority'      => 40,
//         'description'   => 'Set the background color for the hero that will act like a overlay',
//     ) );

//     $wp_customize->add_setting( 'hero_bg_color', array(
//         'default' => '#999999'
//         ) );

//     $wp_customize->add_control( new WP_Customize_Color_Control ( $wp_customize, 'hero_bg_color', array(
//         'label'    => __( 'Color', 'hero' ),
//         'sections' => 'hero_bgColor',
//         'settings' => 'hero_bg_color',
//         ) ) );

// }

function hero_register_theme_customizer( $wp_customize ) {

    $wp_customize->add_setting(
        'hero_head_overlayBg',
        array(
            'default'     => '#000000'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'link_color',
            array(
                'label'      => __( 'Head overlay color', 'tcx' ),
                'section'    => 'colors',
                'settings'   => 'hero_head_overlayBg'
            )
        )
    );

}
add_action( 'customize_register', 'hero_register_theme_customizer' );

function header_BgColor() {

    function hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
        return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
            $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }

    $color = get_theme_mod( 'hero_head_overlayBg' );
    $rgba = hex2rgba($color, 0.3);

    ?>
    <style type="text/css">
        .hero-bg {
            background-color: <?php echo $rgba; ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'header_BgColor' );

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
        'stars' => array(
            'url'           => '%s/assets/images/headers/stars.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/stars-thumbnail.jpg',
            'description'   => _x( 'Stars', 'header image description', 'twentythirteen' )
        ),
        'woods' => array(
            'url'           => '%s/assets/images/headers/woods.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/woods-thumbnail.jpg',
            'description'   => _x( 'Woods', 'header image description', 'twentythirteen' )
        ),
        'gazing' => array(
            'url'           => '%s/assets/images/headers/gazing.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/gazing-thumbnail.jpg',
            'description'   => _x( 'Gazing', 'header image description', 'twentythirteen' )
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
            background-size: cover;
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


