<?php
/**
* Header title
*/
add_action( 'genesis_before_content', 'wd_events_archive_title', 3 );
function wd_events_archive_title() {
     echo '<header class="events-archive-header">';
          echo '<h1>DOCPAC Events</h1>';
     echo '</header>';
}


/**
* Upcoming Events header
*/
add_action( 'genesis_before_loop', 'wd_events_archive_upcoming_events_header' );
function wd_events_archive_upcoming_events_header() {
     echo '<h2 class="upcoming-events-header">Upcoming Events</h2>';
}


/**
 * Message to display if no events or only 1 event is upcominng
 *
 * @since 1.0.0
 * @return string
 */
function ja_upcoming_events_none() {

	global $events_found;

	if ( $events_found ) {
		return '<h4>More events will be scheduled soon!</h4>';
	} else {
		return '<h4>There are currently no events scheduled, however check back soon!</h4>';
	}
}
add_filter( 'genesis_noposts_text', 'ja_upcoming_events_none' );

/**
 * Archive event header details
 *
 * @since 1.0.0
 */
function ja_upcoming_event() {

	global $events_found;

	$events_found = false;

	$recent_args = array (
		'posts_per_page' => '1',
		'post_type'      => 'events',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'meta_key'       => 'be_event_start',
		'meta_query'     => array(
			array(
				'key'     => 'be_event_end',
				'value'   => current_time( 'timestamp' ),
				'compare' => '>'
			),
		),
	);

	$recent = new WP_Query( $recent_args ); while( $recent->have_posts() ) : $recent->the_post();

		echo '<div class="event-header clearfix">';

			echo '<div class="left">';
				echo '<a href="' . get_permalink() . '">';
				the_post_thumbnail( 'banner' );
				echo '</a>';
			echo '</div>';

			echo '<div class="right">';

				echo '<h2 class="has-blue-color has-text-color"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
				$start      = get_post_meta( get_the_ID(), 'be_event_start', true );
				$end        = get_post_meta( get_the_ID(), 'be_event_end', true );
				$allday     = get_post_meta( get_the_ID() , 'be_event_allday', true );
				echo '<p class="event-duration" style="font-weight:600;">';
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

                    echo '<span class="event-header-excerpt">';
                         echo get_the_excerpt();
                    echo '</span>';

                    echo '<div class="event-header-button wp-block-buttons is-content-justification-center">';
                         echo '<div class="wp-block-button is-style-inverse has-small-font-size">';
                              echo '<a class="wp-block-button__link has-blue-color has-text-color has-blue-background-color has-background" href="' . get_the_permalink() . '">';
                                   echo 'Learn More';
                              echo '</a>';
                         echo '</div>';
                    echo '</div>';

			echo '</div>';

		echo '</div>';

		$events_found = true;

	endwhile;

	wp_reset_postdata();
}
add_action( 'genesis_before_content', 'ja_upcoming_event' );


/**
* Past events
*/
add_action( 'genesis_after_content', 'wd_events_archive_past_events', 12 );
function wd_events_archive_past_events() {
     echo '<h2 class="upcoming-events-header upcoming-events-header--past">Past Events</h2>';

     $past_args = array (
		'posts_per_page' => '3',
		'post_type'      => 'events',
		'orderby'        => 'meta_value_num',
		'order'          => 'DSC',
		'meta_key'       => 'be_event_start',
		'meta_query'     => array(
			array(
				'key'     => 'be_event_end',
				'value'   => current_time( 'timestamp' ),
				'compare' => '<='
			),
		),
	);
     echo '<div class="loop-wrapper">';
     $past = new WP_Query( $past_args ); while( $past->have_posts() ) : $past->the_post();
     get_template_part( 'partials/event-item' );
     endwhile;
     echo '</div>';
}


/**
* Add custom block area to bottom of page
*/
add_action( 'genesis_after_content', 'wd_events_archive_bottom', 15 );
function wd_events_archive_bottom() {

     if( function_exists( 'wd_block_area' ) ) {
          wd_block_area()->show( 'events-archive-bottom' );
     }
}


/**
* Use custom loop
*/
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'wd_custom_loop' );


genesis();
