<?php
/**
 * Register theme support for languages, menus, post-thumbnails, post-formats etc.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

/**
* Returns the options array for Hero
* @since Hero 1.1.0
*/

require_once( 'sanitization-callbacks.php' );

function hero_options($name, $default = false) {
    $options = ( get_option( 'hero_options' ) ) ? get_option( 'hero_options' ) : null;
    // return the option if it exists
    if ( isset( $options[ $name ] ) ) {
        return apply_filters( 'hero_options_$name', $options[ $name ] );
    }
    // return default if nothing else
    return apply_filters( 'hero_$name', $default );
}

function hero_theme_customizer( $wp_customize ) {
    $wp_customize->add_section( 'hero_logo_section' , array(
        'title'       => __( 'Logo & Author Avatar', 'hero' ),
        'priority'    => 30,
        'description' => 'Upload a logo to replace the default site name and description in the header. If no image is uploaded, then the basic blog name will be used.',
        ) );

    $wp_customize->add_setting( 'hero_logo', array(
        'sanitize_callback' => 'herosense_sanitize_image',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_logo', array(
        'label'    => __( 'Logo', 'hero' ),
        'section'  => 'hero_logo_section',
        'settings' => 'hero_logo',
        ) ) );

    $wp_customize->add_setting( 'hero_admin_avatar', array(
        'sanitize_callback' => 'herosense_sanitize_image',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hero_admin_avatar', array(
        'label'    => __( 'Admin Rounded Avatar', 'hero' ),
        'section'  => 'hero_logo_section',
        'settings' => 'hero_admin_avatar',
        ) ) );
}
add_action( 'customize_register', 'hero_theme_customizer' );

function hero_theme_maintitle( $wp_customize ) {

    $wp_customize->add_setting( 'hero_tagline_main', array (
        'sanitize_callback' => 'herosense_sanitize_html',
        ) );

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hero_tagline_main',
            array(
                'label'          => __( 'Hero title', 'hero' ),
                'default'        => __( 'This is the default header hero title', 'hero' ),
                'section'        => 'title_tagline',
                'settings'       => 'hero_tagline_main',
                'type'           => 'text',
                )
            )
     );
}
add_action( 'customize_register', 'hero_theme_maintitle' );

function herosense_theme_social( $wp_customize ) {

    $wp_customize->add_section( 'hero_social_section' , array(
        'title'       => __( 'Social', 'hero' ),
        'priority'    => 30,
        'description' => 'Set up your social accounts to display them in the hero area of the site.',
        ) );

    $wp_customize->add_setting('hero_options[hide_social]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '0', # Default un-checked
        'sanitize_callback' => 'herosense_sanitize_checkbox',
        ));

    $wp_customize->add_control('hero_options[hide_social]', array(
        'settings' => 'hero_options[hide_social]',
        'label'    => __('Hide the social links in the hero area', 'herosense'),
        'section'  => 'hero_social_section',
        'type'     => 'checkbox', # Type of control: checkbox
    ));


    # Add text input form to change custom text
    $wp_customize->add_setting('hero_options[twitter]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 'your-username', # Default custom text
        'sanitize_callback' => 'herosense_sanitize_checkbox',
    ));

    $wp_customize->add_control('hero_options[twitter]', array(
        'label' => 'Twitter ID', # Label of text form
        'section' => 'hero_social_section', # Layout Section
        'type' => 'text', # Type of control: text input
        ));

    # Add text input form to change custom text
    $wp_customize->add_setting('hero_options[facebook]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 'your-username', # Default custom text
        'sanitize_callback' => 'herosense_sanitize_checkbox',
    ));

    $wp_customize->add_control('hero_options[facebook]', array(
        'label' => 'Facebook ID', # Label of text form
        'section' => 'hero_social_section', # Layout Section
        'type' => 'text', # Type of control: text input
        ));


}
add_action( 'customize_register', 'herosense_theme_social' );


function hero_theme_hidesidebar( $wp_customize ) {

    $wp_customize->add_setting('hero_options[hero_hide_sidebar]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'std'       => '0', # Default checked
        'sanitize_callback' => 'herosense_sanitize_checkbox',
    ));

    $wp_customize->add_control('hero_options[hero_hide_sidebar]', array(
        'settings' => 'hero_options[hero_hide_sidebar]',
        'label'    => __('Hide the sidebar on the frontpage', 'hero'),
        'description' => __('Enabling this will hide the sidebar on the homepage', 'hero'),
        'section'  => 'title_tagline', # Layout Section
        'type'     => 'checkbox', # Type of control: checkbox
    ));

}
add_action( 'customize_register', 'hero_theme_hidesidebar' );

function herosense_custom_header_setup() {
    $args = array(
        // Text color and image (empty to use none).
        'default-text-color'     => '220e10',
        'default-image'          => '%s/assets/images/headers/stars.jpeg',

        // Set height and width, with a maximum value for the width.
        'height'                 => 230,
        'width'                  => 1600,

        // Callbacks for styling the header and the admin preview.
        'wp-head-callback'       => 'herosense_header_style',
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
            'description'   => _x( 'Stars', 'header image description', 'herosense' )
        ),
        'woods' => array(
            'url'           => '%s/assets/images/headers/woods.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/woods-thumbnail.jpg',
            'description'   => _x( 'Woods', 'header image description', 'herosense' )
        ),
        'gazing' => array(
            'url'           => '%s/assets/images/headers/gazing.jpeg',
            'thumbnail_url' => '%s/assets/images/headers/gazing-thumbnail.jpg',
            'description'   => _x( 'Gazing', 'header image description', 'herosense' )
        ),
    ) );
}
add_action( 'after_setup_theme', 'herosense_custom_header_setup', 11 );

function herosense_header_style() {
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
            background-image: url(<?php header_image(); ?>);
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
        #front-hero h1 {
            color: #<?php echo esc_attr( $text_color ); ?>;
        }
    <?php endif; ?>
    </style>
    <?php
}
?>
