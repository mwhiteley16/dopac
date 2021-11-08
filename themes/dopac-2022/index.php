<?php
/**
* Remove page title from 'posts' page
*/
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );


/**
* Add custom entry header
*/
add_action( 'genesis_after_header', 'wd_blog_archive_custom_entry_header' );
function wd_blog_archive_custom_entry_header() {

     $wd_options_news_archive_hero_image = get_field( 'wd_options_news_archive_hero_image', 'option' );
     $wd_options_news_archive_header = get_field( 'wd_options_news_archive_header', 'option' );

     echo '<header class="entry-header entry-header--with-thumbnail">';

          echo '<div class="entry-header__thumbnail">';
               echo '<img src="' . $wd_options_news_archive_hero_image['url'] .'" alt="' . $wd_options_news_archive_hero_image['alt'] . '" />';
          echo '</div>';

          echo '<div class="wrap">';
               echo '<h1 class="entry-title">';
                    echo $wd_options_news_archive_header;
               echo '</h2>';
          echo '</div>';

     echo '</header>';

}


/**
* Add custom block area to bottom of page
*/
add_action( 'genesis_after_content', 'wd_news_archive_bottom', 15 );
function wd_news_archive_bottom() {

     if( function_exists( 'wd_block_area' ) ) {
          wd_block_area()->show( 'news-archive-bottom' );
     }
}


/**
* Use custom loop
*/
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wd_custom_loop' );

genesis();
