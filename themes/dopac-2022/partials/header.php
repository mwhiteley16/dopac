<?php
/**
 * Header partial
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>

<?php // get custom logo
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
?>

<?php if ( function_exists( 'the_custom_logo' ) ) : ?>
     <div class="site-header__logo">
          <a class="custom-logo-link" href="<?php echo get_home_url(); ?>">
               <img class="custom-logo" src="<?php echo esc_url( $logo[0] ); ?>" alt="Dorothy H. O'Connor Pet Adoption Center Logo" height="52" width="246">
          </a>
     </div>
<?php endif; ?>

<?php // left menu
if( has_nav_menu( 'top' ) ) {
     wp_nav_menu( [
          'theme_location'    => "top",
          'menu_class'        => "top-menu__menu",
          'container'         => "div",
          'container_class'   => "top-menu",
          'link_before'       => "<span>",
          'link_after'        => "</span>",
     ] );
}
?>

<div class="mobile-navigation-icon">
     <span></span>
     <span></span>
     <span></span>
</div>
