<?php
/**
 *  Information Grid Block
 *
 * @package      DOPAC
 * @author       Matt Whiteley
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// ACF custom fields
$wd_block_info_grid_columns = get_field( 'wd_block_info_grid_columns' );

// block ID
$block_id = 'info-grid-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) { // add anchor if present
     $id = $block['anchor'];
}

// block Classes
$block_classes = 'acf-block info-grid-block column-count-' . $wd_block_info_grid_columns;

// optionally disable pointer events (prevent clicking links within block editor)
$disable_pointer_events = true;
if ( $disable_pointer_events == 1 && is_admin() ) {
     $block_classes .= ' disable-pointer-events';
}

if ( ! empty( $block['align'] ) ) {
     $block_classes .= ' align' . $block['align'];
}

if ( ! empty( $block['className'] ) ) { // custom class name
     $block_classes .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

     <?php if ( have_rows( 'wd_block_info_grid_item' ) ) : ?>
          <div class="info-grid-block__grid">
               <?php while ( have_rows( 'wd_block_info_grid_item' ) ) : the_row(); ?>

                    <?php
                    $wd_image = get_sub_field( 'wd_image' );
                    $wd_link = get_sub_field( 'wd_link' );
                    $wd_link_target = ! empty( $wd_link['target'] ) ? ' target="' . $wd_link['target'] . '"' : '';
                    if ( $wd_link['target'] == '_blank' ) { $wd_link_target .= ' rel="noopener noreferrer"'; }
                    $wd_description = get_sub_field( 'wd_description' );
                    ?>

                    <div class="info-grid-block__item">

                         <?php if ( ! empty( $wd_image ) ) : ?>
                              <div class="info-grid-block__image">

                                   <?php if ( ! empty( $wd_link ) ) : ?>
                                        <a href="<?php echo esc_url( $wd_link['url'] ); ?>"<?php echo $wd_link_target; ?>>
                                   <?php endif; ?>

                                   <img src="<?php echo esc_url( $wd_image['sizes']['dopac-thumbnail'] ); ?>" alt="<?php echo esc_attr( $wd_image['alt'] ); ?>" />

                                   <?php if ( ! empty( $wd_link ) ) : ?>
                                        </a>
                                   <?php endif; ?>

                              </div>
                         <?php endif; ?>

                         <div class="info-grid-block__content">

                              <?php if ( ! empty( $wd_link ) ) : ?>
                                   <h3 class="info-grid-block__title">
                                        <a href="<?php echo esc_url( $wd_link['url'] ); ?>"<?php echo $wd_link_target; ?>>
                                             <?php echo esc_html( $wd_link['title'] ); ?>
                                        </a>
                                   </h3>
                              <?php endif; ?>

                              <?php if ( ! empty( $wd_description) ) : ?>
                                   <div class="info-grid-block__description">
                                        <?php echo $wd_description; ?>
                                   </div>
                              <?php endif; ?>

                         </div>

                    </div>

               <?php endwhile; ?>
          </div>
     <?php endif; ?>

</div>
