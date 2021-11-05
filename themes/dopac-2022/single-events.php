<?php
/**
* Modify entry header
*/
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'wd_events_single_header' );
function wd_events_single_header() {
     echo '<header class="events-archive-header">';
          echo '<h1>DOCPAC Events</h1>';
     echo '</header>';
}


/**
* Add event name/time
*/
add_action( 'genesis_entry_content', 'wd_events_single_above_content', 3 );
function wd_events_single_above_content() { ?>

     <div class="single-events-top">

          <div class="single-events-title">
               <h2 class="has-blue-color has-text-color"><?php the_title(); ?></h2>
          </div>

          <div class="single-events-datetime">

               <?php
               $start      = get_post_meta( get_the_ID(), 'be_event_start', true );
               $end        = get_post_meta( get_the_ID(), 'be_event_end', true );
               $allday     = get_post_meta( get_the_ID() , 'be_event_allday', true );
               echo '<p class="event-duration">';
                    echo '<span class="has-blue-color has-text-color">Start:</span> ' . date( 'n/j/Y', $start );
                    if ( !empty( $end ) ) {
                         if ( $allday != '1') {
                              echo ' ' . date( 'g:i a', $start );
                         }
                         echo '<br><span class="has-red-color has-text-color">End:</span> ' . date( 'n/j/Y', $end );
                         if ( $allday != '1') {
                              echo ' ' . date( 'g:i a', $end );
                         }
                    }
               echo '</p>';
               ?>

          </div>

     </div>

     <?php if ( has_post_thumbnail() ) : ?>
          <div class="single-events-image">
               <?php the_post_thumbnail(); ?>
          </div>
     <?php endif; ?>

     <?php if( function_exists( 'shared_counts' ) ) {
          echo '<div class="social-sharing-wrap">';
               echo '<span class="social-sharing-text">Share</span>';
               shared_counts()->front->display();
          echo '</div>';
     } ?>

     <?php $wd_cpt_event_type = get_field( 'wd_cpt_event_type' ); ?>
     <?php if ( ! empty( $wd_cpt_event_type ) ) : ?>
          <div class="single-events-type">
               <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/utility/sound.svg" alt="Sound Icon">
               <span><?php echo $wd_cpt_event_type; ?></span>
          </div>
     <?php endif; ?>

<?php }


/**
* Add custom block area to bottom of page
*/
add_action( 'genesis_after_content', 'wd_events_archive_bottom' );
function wd_events_archive_bottom() {

     if( function_exists( 'wd_block_area' ) ) {
          wd_block_area()->show( 'events-archive-bottom' );
     }
}

genesis();
