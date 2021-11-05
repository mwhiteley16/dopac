<?php
/**
 * Event item partial
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>

<?php
$start = get_post_meta( get_the_ID(), 'be_event_start', true );
$end = get_post_meta( get_the_ID(), 'be_event_end', true );
$allday = get_post_meta( get_the_ID() , 'be_event_allday', true );
$wd_cpt_event_type = get_field( 'wd_cpt_event_type' );
?>

<div class="event-item<?php if ( ! has_post_thumbnail() ) : ?> no-thumbnail<?php endif; ?>">

     <?php if ( has_post_thumbnail() ) : ?>
          <div class="event-item__thumbnail">
               <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'dopac-thumbnail' ); ?></a>

               <?php if ( ! empty( $wd_cpt_event_type ) ) : ?>
                    <div class="event-item__type">
                         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/utility/sound.svg" alt="Sound Icon">
                         <span><?php echo $wd_cpt_event_type; ?></span>
                    </div>
               <?php endif; ?>
               
          </div>
     <?php endif; ?>

     <div class="event-item__content">

          <span class="event-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>

          <span class="event-item__duration">
               <?php
               echo date( 'M j, Y', $start );
               if ( !empty( $end ) ) {
                    echo '&nbsp;-&nbsp; ' . date( 'M j, Y', $end );
               }
               ?>
          </span>

          <div class="event-item__excerpt">
               <?php the_excerpt(); ?>
          </div>

          <div class="event-item__button wp-block-buttons is-content-justification-right">
               <div class="wp-block-button is-style-inverse has-small-font-size">
                    <a class="wp-block-button__link has-red-color has-text-color has-red-background-color has-background" href="<?php the_permalink(); ?>">
                         Learn More
                    </a>
               </div>
          </div>

     </div>

</div>
