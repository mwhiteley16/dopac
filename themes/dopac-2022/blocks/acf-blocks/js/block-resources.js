(function($){

     var initializeBlock = function( $block ) {

          $('.resources-block__toggle-question').click(function() {
               $(this).parent('.resources-block__toggle').toggleClass('active');
               $(this).siblings('.resources-block__toggle-answer').slideToggle();
          });

    }

    // Initialize each block on page load (front end).
    $(document).ready(function(){
        $('.resources-block').each(function(){
            initializeBlock( $(this) );
        });
    });

     if( window.acf ) {
          window.acf.addAction( 'render_block_preview/type=acf-resources', initializeBlock );
     }

})(jQuery);
