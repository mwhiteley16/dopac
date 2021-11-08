<?php
/**
* Remove entry header meta
*/
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );


/**
* Remove entry footer
*/
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );


genesis();
