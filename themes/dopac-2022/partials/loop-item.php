<?php
/**
 * Loop item partial
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/
?>

<div class="loop-item">

     <?php if ( has_post_thumbnail() ) : ?>
          <div class="loop-item__thumbnail">
               <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'dopac-thumbnail' ); ?></a>
          </div>
     <?php endif; ?>

     <div class="loop-item__content">

          <h4 class="loop-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

          <div class="loop-item__excerpt">
               <?php the_excerpt(); ?>
          </div>

     </div>

</div>
