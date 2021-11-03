<?php
/**
 * Footer partial
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>

<?php // footer menu
if( has_nav_menu( 'footer' ) ) {
     wp_nav_menu( [
          'theme_location'    => "footer",
          'menu_class'        => "footer-menu__menu",
          'container'         => "div",
          'container_class'   => "footer-menu"
     ] );
}
?>

<?php
$wd_options_footer_email_signup_form = get_field( 'wd_options_footer_email_signup_form', 'option' );
if ( function_exists( 'gravity_form' ) && ! empty( $wd_options_footer_email_signup_form ) ) : ?>
     <div class="footer-email-subscribe">
          <?php gravity_form( $wd_options_footer_email_signup_form, false, false, false, '', true ); ?>
     </div>
<?php endif; ?>

<?php if ( have_rows( 'wd_options_social_media_links', 'option' ) ) : ?>
     <div class="social-media">
     	<?php while ( have_rows( 'wd_options_social_media_links', 'option' ) ) : the_row(); ?>

               <a class="social-media__link" href="<?php the_sub_field( 'wd_link' ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php the_sub_field( 'wd_aria_label' ); ?>">
                    <?php the_sub_field( 'wd_icon' ); ?>
               </a>

     	<?php endwhile; ?>
     </div>
<?php endif; ?>
