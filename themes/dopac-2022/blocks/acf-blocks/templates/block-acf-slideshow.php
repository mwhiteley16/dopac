<?php
/**
 *  Slideshow Block
 *
 * @package      DOCPAC
 * @author       Matt Whiteley
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// block ID
$block_id = 'slideshow-block-' . $block['id'];

// block Classes
$block_classes = 'acf-block slideshow-block';

if ( ! empty( $block['className'] ) ) { // custom class name
     $block_classes .= ' ' . $block['className'];
}

// get align class if present
if ( ! empty( $block['align'] ) ) {
     $block_classes .= ' align' . $block['align'];
}
?>

<?php if ( have_rows( 'wd_block_slideshow' ) ) : ?>
     <div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

          <div class="slideshow-block__slides">
               <?php while ( have_rows( 'wd_block_slideshow' ) ) : the_row(); ?>

                    <?php
                    $wd_slideshow_image = get_sub_field( 'wd_slideshow_image' );
                    ?>

                    <div class="slideshow-block__slide">
                         <img class="nolazy" src="<?php echo esc_url( $wd_slideshow_image['url'] ); ?>"  alt="<?php echo esc_attr( $wd_slideshow_image['alt'] ); ?>" />
                    </div>

               <?php endwhile; ?>
          </div>

     </div>
<?php endif; ?>
