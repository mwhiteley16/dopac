<?php
/**
 * Team Block
 *
 * @package      DOPAC
 * @author       Matt Whiteley
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Block ID
$block_id = 'team-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) { // add anchor if present
     $id = $block['anchor'];
}

// Block Classes
$block_classes = 'acf-block team-block';

// optionally disable pointer events (prevent clicking links within block editor)
$disable_pointer_events = true;
if ( $disable_pointer_events == 1 && is_admin() ) {
     $block_classes .= ' disable-pointer-events';
}

// get align class if present
if ( ! empty( $block['align'] ) ) {
     $block_classes .= ' align' . $block['align'];
}

// get custom class name if present
if ( ! empty( $block['className'] ) ) {
     $block_classes .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

     <?php if ( have_rows( 'wd_block_team_members' ) ) : ?>
          <div class="team-block__interior">

               <?php while ( have_rows( 'wd_block_team_members' ) ) : the_row(); ?>

                    <?php
                    $wd_team_name = get_sub_field( 'wd_team_name' );
                    $wd_team_headshot = get_sub_field( 'wd_team_headshot' );
                    $wd_team_position = get_sub_field( 'wd_team_position' );
                    $team_member_link = get_sub_field( 'team_member_link' );
                    ?>

                    <div class="team-block__item">

                         <?php if ( $wd_team_headshot ) : ?>
                              <div class="team-block__headshot">
                                   <img src="<?php echo esc_url( $wd_team_headshot['url'] ); ?>" alt="<?php echo esc_attr( $wd_team_headshot['alt'] ); ?>" />
                              </div>
                         <?php endif; ?>

                         <span class="team-block__name"><?php echo $wd_team_name; ?></span>

                         <?php if ( $wd_team_position ) : ?>
                              <span class="team-block__position">
                                   <?php echo $wd_team_position; ?>
                              </span>
                         <?php endif; ?>

                         <?php if ( $team_member_link ) : ?>
                              <div class="team-block__link">
                                   <a href="<?php echo esc_url( $team_member_link['url'] ); ?>" target="<?php echo esc_attr( $team_member_link['target'] ); ?>">Learn More <i class="fal fa-angle-double-right"></i></a>
                              </div>
                         <?php endif; ?>

                         <?php if ( have_rows( 'wd_team_social' ) ) : ?>
                              <div class="team-block__social">
                                   <?php while ( have_rows( 'wd_team_social' ) ) : the_row(); ?>
                                        <span class="team-block__social-item">
                                             <a href="<?php the_sub_field( 'wd_social_link' ); ?>" target="_blank" rel="noopener nofollow" aria-label="<?php the_sub_field( 'wd_aria_label' ); ?>">
                                                  <?php the_sub_field( 'wd_social_icon' ); ?>
                                             </a>
                                        </span>
                                   <?php endwhile; ?>
                              </div>
                         <?php endif; ?>

                    </div>

               <?php endwhile; ?>

          </div>
     <?php endif; ?>

</div>
