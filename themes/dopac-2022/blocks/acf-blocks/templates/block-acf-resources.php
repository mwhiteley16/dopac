<?php
/**
 *  Resources Block
 *
 * @package      DOPAC
 * @author       Matt Whiteley
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// acf variables

// block ID
$block_id = 'resources-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) { // add anchor if present
     $id = $block['anchor'];
}

// block Classes
$block_classes = 'acf-block resources-block';

// optionally disable pointer events (prevent clicking links within block editor)
$disable_pointer_events = false;
if ( $disable_pointer_events == 1 && is_admin() ) {
     $block_classes .= ' disable-pointer-events';
}

if ( ! empty( $block['className'] ) ) { // custom class name
     $block_classes .= ' ' . $block['className'];
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

     <?php if ( have_rows( '_ja_pet_guide' ) ) : ?>
          <?php $faq_count = 0; ?>
          <?php while ( have_rows( '_ja_pet_guide' ) ) : the_row(); $faq_count++; ?>
               <div class="resources-block__toggle">
                    <button class="resources-block__toggle-question">
                         <?php the_sub_field( 'title' ); ?>
                    </button>
                    <div class="resources-block__toggle-answer">
                         <?php the_sub_field( 'tip' ); ?>
                    </div>
               </div>
          <?php endwhile; ?>
     <?php endif; ?>   

</div>
