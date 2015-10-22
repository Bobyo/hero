<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "off-canvas-wrap" div and all content after.
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0.0
 */

?>

</section>
<div id="footer-container">
	<footer id="footer">
		<?php do_action( 'foundationpress_before_footer' ); ?>
		<?php dynamic_sidebar( 'footer-widgets' ); ?>
		<?php do_action( 'foundationpress_after_footer' ); ?>
	</footer>

    <div class="row">
        <div class="column large-2 medium-6 small-12">
            <div class="footer-logo">

                <?php if ( get_theme_mod( 'hero_logo' ) ) : ?>
                    <div class='site-logo'>
                        <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src='<?php echo esc_url( get_theme_mod( 'hero_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
                    </div>
                <?php else : ?>
                    <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                <?php endif; ?>

            </div>
        </div>
        <div class="column large-8 medium-6 small-12">
            <div class="footer-menu">
                <?php foundationpress_top_bar_l(); ?>
                <?php foundationpress_top_bar_r(); ?>
            </div>
        </div>
        <div class="column large-2 medium-6 small-12">
            <div class="copyright">
                <p>Copyright © 2015 <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>. Skinned with <a href="http://creativecoon.com/hero">Hero</a>.
            </div>
        </div>

    </div>





</div>

<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>

<a class="exit-off-canvas"></a>
<?php endif; ?>

	<?php do_action( 'foundationpress_layout_end' ); ?>

<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'offcanvas' ) : ?>
	</div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
<?php do_action( 'foundationpress_before_closing_body' ); ?>
<script type="text/javascript" src="http://localhost:35729/livereload.js?snipver=1"></script>
</body>
</html>
