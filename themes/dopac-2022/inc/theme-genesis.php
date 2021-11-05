<?php
/**
 * Genesis Changes
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
* Remove default stylesheet
*/
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );


/**
* Theme support
*/
add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-accessibility',
     [
          '404-page',
          'drop-down-menu',
          'headings',
          'rems',
          'search-form',
          'skip-links'
     ]
);
add_theme_support( 'genesis-structural-wraps',
     [
          'footer',
          'header',
          'nav',
          'site-inner',
          'site-tagline'
     ]
);


/**
* Custom logo
*/
add_theme_support( 'custom-logo',
     [
          'width'       => 244,
          'height'      => 315,
          'flex-width'  => true,
          'flex-height' => true,
          'header-text' => [
               '.site-title',
               '.site-description'
          ]
     ]
);


/**
* Setup menu options
*/
add_theme_support( 'genesis-menus',
     [
          'primary' => __( 'Primary Menu', WD_CHILD_THEME_SLUG ),
          'top'     => __( 'Top Menu', WD_CHILD_THEME_SLUG ),
          'footer'  => __( 'Footer Menu', WD_CHILD_THEME_SLUG )
     ]
);


/**
* Remove Sidebars
*/
add_action( 'genesis_before_loop', 'wd_remove_sidebars' );
function wd_remove_sidebars() {
     remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );
     remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
}


/**
* Setup proper page template options
*/
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_register_layout(
     'thin-layout',
          [
               'label' => __( 'Thin Layout', WD_CHILD_THEME_SLUG )
          ]
);


/**
* Remove unused widget areas
*/
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );


/**
* Remove edit link from front end
*/
add_filter( 'genesis_edit_post_link' , '__return_false' );


/**
* Remove sub navigation
*/
remove_action( 'genesis_after_header', 'genesis_do_subnav' );


/**
* Remove content-sidebar div
*/
add_filter( 'genesis_markup_content-sidebar-wrap_open', '__return_false' );
add_filter( 'genesis_markup_content-sidebar-wrap_close', '__return_false' );


/**
* Replace header with custom header
*/
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'wd_header' );
function wd_header() {
     get_template_part( 'partials/header' );
}


/**
* Replace footer with custom footer
*/
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'wd_footer' );
function wd_footer() {
     get_template_part( 'partials/footer' );
}


/**
* Remove superfish scripts
*/
add_action( 'wp_enqueue_scripts', 'wd_disable_superfish' );
function wd_disable_superfish() {

	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}


/**
* Custom loop
*/
function wd_custom_loop() {

     if ( have_posts() ) {

          do_action( 'genesis_before_while' );

          echo '<div class="loop-wrapper">';

               while ( have_posts() ) {

                    the_post();

                    do_action( 'genesis_before_entry' );

                         if ( is_search() ) {
                              get_template_part( 'partials/search-loop-item' );
                         } elseif( is_post_type_archive( 'events' ) ) {
                              get_template_part( 'partials/event-item' );
                         } else {
                              get_template_part( 'partials/loop-item' );
                         }

                    do_action( 'genesis_after_entry' );

               }

          echo '</div>';

          do_action( 'genesis_after_endwhile' );

     } else {

     	do_action( 'genesis_loop_else' );
     }
}

/**
* Enable the block-based widget editor
*/
add_filter( 'use_widgets_block_editor', '__return_true' );


/**
* Add search toggle under header
*/
add_action( 'genesis_after_header', 'wd_search_toggle', 14 );
function wd_search_toggle() { ?>

     <div class="search-dropdown">

          <button class="close-search-toggle" aria-label="Close Search">
               <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/utility/close.svg" alt="Close Icon" aria-hidden="true" role="img" focusable="false">
          </button>

          <?php echo get_search_form(); ?>

     </div>

<?php }


/**
* Pre-footer CTA area
*/
add_action( 'genesis_before_footer', 'wd_pre_footer_cta' );
function wd_pre_footer_cta() {

     $wd_options_pre_footer_image = get_field( 'wd_options_pre_footer_image', 'option' );
     $wd_options_pre_footer_cta_text = get_field( 'wd_options_pre_footer_cta_text', 'option' );

     // get button variables and add proper rel tags based on target setting
     $wd_options_pre_footer_button_1 = get_field( 'wd_options_pre_footer_button_1', 'option' );
     $button_1_target = ! empty( $wd_options_pre_footer_button_1['target'] ) ? ' target="' . $wd_options_pre_footer_button_1['target'] . '"' : '';
     if ( $wd_options_pre_footer_button_1['target'] == '_blank' ) { $button_1_target .= ' rel="noopener noreferrer"'; }

     $wd_options_pre_footer_button_2 = get_field( 'wd_options_pre_footer_button_2', 'option' );
     $button_2_target = ! empty( $wd_options_pre_footer_button_2['target'] ) ? ' target="' . $wd_options_pre_footer_button_2['target'] . '"' : '';
     if ( $wd_options_pre_footer_button_2['target'] == '_blank' ) { $button_2_target .= ' rel="noopener noreferrer"'; }

     $wd_options_pre_footer_button_3 = get_field( 'wd_options_pre_footer_button_3', 'option' );
     $button_3_target = ! empty( $wd_options_pre_footer_button_3['target'] ) ? ' target="' . $wd_options_pre_footer_button_3['target'] . '"' : '';
     if ( $wd_options_pre_footer_button_3['target'] == '_blank' ) { $button_3_target .= ' rel="noopener noreferrer"'; }
     ?>

     <div class="pre-footer-cta">

          <?php if ( $wd_options_pre_footer_image ) : ?>
               <div class="pre-footer-cta__image">
                    <img src="<?php echo esc_url( $wd_options_pre_footer_image['url'] ); ?>" alt="<?php echo esc_attr( $wd_options_pre_footer_image['alt'] ); ?>" />
               </div>
          <?php endif; ?>

          <div class="pre-footer-cta__blue">

               <span class="pre-footer-cta__header">
                    <?php echo $wd_options_pre_footer_cta_text; ?>
               </span>

               <div class="pre-footer-cta__buttons wp-block-buttons">

                    <div class="wp-block-button pre-footer-cta__button pre-footer-cta__button--1">
                         <a class="wp-block-button__link has-base-color-color has-white-background-color has-text-color has-background" href="<?php echo esc_url( $wd_options_pre_footer_button_1['url'] ); ?>" <?php echo $button_1_target; ?>>
                              <?php echo esc_html( $wd_options_pre_footer_button_1['title'] ); ?>
                         </a>
                    </div>

                    <div class="wp-block-button pre-footer-cta__button pre-footer-cta__button--2">
                         <a class="wp-block-button__link has-white-color has-red-light-background-color has-text-color has-background" href="<?php echo esc_url( $wd_options_pre_footer_button_2['url'] ); ?>" <?php echo $button_2_target; ?>>
                              <?php echo esc_html( $wd_options_pre_footer_button_2['title'] ); ?>
                         </a>
                    </div>

                    <div class="wp-block-button pre-footer-cta__button pre-footer-cta__button--3">
                         <a class="wp-block-button__link has-base-color-color has-white-background-color has-text-color has-background" href="<?php echo esc_url( $wd_options_pre_footer_button_3['url'] ); ?>" <?php echo $button_3_target; ?>>
                              <?php echo esc_html( $wd_options_pre_footer_button_3['title'] ); ?>
                         </a>
                    </div>

               </div>

          </div>

     </div>

<?php }


/**
* Customized header area on pages
*/
add_action( 'genesis_after_header', 'wd_custom_page_header', 18 );
function wd_custom_page_header() {

     $wd_enable_title_over_featured_image = get_field( 'wd_enable_title_over_featured_image', get_the_ID() );

     if ( is_page() && has_post_thumbnail() && $wd_enable_title_over_featured_image == 1 ) {
          remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
          remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
          remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

          $wd_hero_image_overlay_text_override = get_field( 'wd_hero_image_overlay_text_override', get_the_ID() );
          $title_text = ! empty( $wd_hero_image_overlay_text_override ) ? $wd_hero_image_overlay_text_override : get_the_title();

          echo '<header class="entry-header entry-header--with-thumbnail">';

               echo '<div class="entry-header__thumbnail">';
                    the_post_thumbnail();
               echo '</div>';

               echo '<div class="wrap">';
                    echo '<h1 class="entry-title">';
                         echo $title_text;
                    echo '</h2>';
               echo '</div>';

          echo '</header>';
     }
}
