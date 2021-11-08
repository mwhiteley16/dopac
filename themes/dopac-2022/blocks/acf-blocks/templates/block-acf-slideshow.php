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

// create the placeholder template
$inner_template = [
     [ 'core/heading',
          [
               'level'       => 2,
               'placeholder' => 'Hero Block Title Here',
               // 'content'     => 'Pre-defined header here.'
          ]
     ],
     [ 'core/paragraph',
          [
               'placeholder' => 'Placeholder text here.',
               // 'content'     => 'Pre-defined content here.'
          ]
     ],
     [ 'core/buttons',
          [ // button block attributes
               'contentJustification' => '',
          ],
          [ // settings for each buttons without buttons
               [ 'core/button',
                    [
                         'backgroundColor' => '',
                    ]
               ]
          ]
     ]
];
?>

<?php if ( have_rows( 'wd_block_slideshow' ) ) : ?>
     <div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_classes ); ?>">

          <div class="slideshow-block__slides">
               <?php while ( have_rows( 'wd_block_slideshow' ) ) : the_row(); ?>

                    <?php
                    $wd_slideshow_image = get_sub_field( 'wd_slideshow_image' );
                    $wd_block_slideshow_content_alignment = get_sub_field( 'wd_block_slideshow_content_alignment' );
                    $wd_block_slideshow_primary_header = get_sub_field( 'wd_block_slideshow_primary_header' );
                    $wd_block_slideshow_primary_header_size = get_sub_field( 'wd_block_slideshow_primary_header_size' );
                    $wd_block_slideshow_secondary_header = get_sub_field( 'wd_block_slideshow_secondary_header' );
                    $wd_block_slideshow_secondary_header_size = get_sub_field( 'wd_block_slideshow_secondary_header_size' );
                    $wd_block_slideshow_button = get_sub_field( 'wd_block_slideshow_button' );
                    $wd_block_slideshow_include_overlay = get_sub_field( 'wd_block_slideshow_include_overlay' );
                    ?>

                    <div class="slideshow-block__slide <?php echo $wd_block_slideshow_content_alignment; ?> <?php echo $wd_block_slideshow_include_overlay; ?>">

                         <div class="slideshow-block__image">
                              <img class="nolazy" src="<?php echo esc_url( $wd_slideshow_image['url'] ); ?>"  alt="<?php echo esc_attr( $wd_slideshow_image['alt'] ); ?>" />
                         </div>

                         <div class="slideshow-block__content">
                              <div class="slideshow-block__content-inner">

                                   <?php if ( ! empty( $wd_block_slideshow_primary_header ) ) : ?>
                                        <<?php echo $wd_block_slideshow_primary_header_size; ?> class="slideshow-block__primary-header">
                                             <?php echo $wd_block_slideshow_primary_header; ?>
                                        </<?php echo $wd_block_slideshow_primary_header_size; ?>>
                                   <?php endif; ?>

                                   <?php if ( ! empty( $wd_block_slideshow_secondary_header ) ) : ?>
                                        <<?php echo $wd_block_slideshow_secondary_header_size; ?> class="slideshow-block__secondary-header">
                                             <?php echo $wd_block_slideshow_secondary_header; ?>
                                        </<?php echo $wd_block_slideshow_secondary_header_size; ?>>
                                   <?php endif; ?>

                                   <?php if ( ! empty( $wd_block_slideshow_button ) ) : ?>
                                        <div class="wp-block-buttons slideshow-block__button">
                                             <div class="wp-block-button has-small-font-size">
                                                  <a class="wp-block-button__link has-white-color has-red-light-background-color has-text-color has-background" href="<?php echo esc_url( $wd_block_slideshow_button['url'] ); ?>" target="<?php echo esc_attr( $wd_block_slideshow_button['target'] ); ?>">
                                                       <?php echo esc_html( $wd_block_slideshow_button['title'] ); ?>
                                                  </a>
                                             </div>
                                        </div>
                                   <?php endif; ?>

                              </div>
                         </div>

                    </div>

               <?php endwhile; ?>
          </div>

     </div>
<?php endif; ?>
