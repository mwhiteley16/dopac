<?php
/**
 * Search form
 *
 * @package      Docpac
 * @author       Whiteley Designs
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text">Search for</span>
		<input type="search" class="search-field" placeholder="Search" value="<?php echo get_search_query(); ?>" name="s" title="search docpac" />
	</label>
	<button type="submit" aria-label="Submit" class="search-submit">Search</button>
</form>
