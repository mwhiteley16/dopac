<?php
/**
 * Gutenberg
 *
 * @author       WhiteleyDesigns
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
* Add support for wide blocks
*/
add_theme_support( 'align-wide' );


/**
* Enable block editor styles
*/
add_editor_style( 'assets/css/editor-style.css' );
add_theme_support( 'editor-styles' );


/**
* Disable custom colors
*/
add_theme_support( 'disable-custom-colors' );


/**
* Gradient color setup
*
* @link https://richtabor.com/block-editor-gradients/
*/
add_theme_support( 'editor-gradient-presets', [] );
add_theme_support( 'disable-custom-gradients', true ); // disable


/**
* Responsive embeds
*/
add_theme_support( 'responsive-embeds' );


/**
* Customize block editor color palette
*
* Match colors with variables set in /assets/scss/partials/base/variables.scss
*
*/
add_theme_support( 'editor-color-palette',
     [
     	[
     		'name'  => __( 'Blue', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'blue',
     		'color' => '#002868',
     	],
     	[
     		'name'  => __( 'Blue Light', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'blue-light',
     		'color' => '#f2f5f7',
     	],
     	[
     		'name'  => __( 'Red', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'red',
     		'color' => '#8c1a11',
     	],
     	[
     		'name'  => __( 'Red Light', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'red-light',
     		'color' => '#d41d2f',
     	],
     	[
     		'name'  => __( 'Gold', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'gold',
     		'color' => '#bc9774',
     	],
     	[
     		'name'  => __( 'Gold Light', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'gold-light',
     		'color' => '#f1e9e1',
     	],
     	[
     		'name'  => __( 'Grey Light', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'grey-light',
     		'color' => '#c4c4c4',
     	],
     	[
     		'name'  => __( 'Grey Medium', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'grey-medium',
     		'color' => '#b3b3b0',
     	],
     	[
     		'name'  => __( 'Grey Dark', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'grey-dark',
     		'color' => '#4a4a4a',
     	],
          [
     		'name'  => __( 'White', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'white',
     		'color' => '#ffffff',
          ],
          [
     		'name'  => __( 'Black', WD_CHILD_THEME_SLUG ),
     		'slug'  => 'black',
     		'color' => '#000000',
          ],
     ]
);


/**
* Customize block editor font sizes
*
* Match font sizes with sizes set in /assets/scss/partials/blocks/core/paragraphs.scss
*
*/
add_theme_support( 'editor-font-sizes',
     [
     	[
     		'name'      => __( 'Small', WD_CHILD_THEME_SLUG ),
     		'shortName' => __( 'S', WD_CHILD_THEME_SLUG ),
     		'size'      => 16,
     		'slug'      => 'small'
     	],
     	[
     		'name'      => __( 'Regular', WD_CHILD_THEME_SLUG ),
     		'shortName' => __( 'M', WD_CHILD_THEME_SLUG ),
     		'size'      => 18,
     		'slug'      => 'regular'
     	],
     	[
     		'name'      => __( 'Large', WD_CHILD_THEME_SLUG ),
     		'shortName' => __( 'L', WD_CHILD_THEME_SLUG ),
     		'size'      => 20,
     		'slug'      => 'large'
     	]
     ]
);


/**
* Show Reusable Blocks UI in WordPress admin
*
* @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
*
*/
function wd_reusable_blocks_admin_menu() {

    add_menu_page(
         'Reusable Blocks',
         'Reusable Blocks',
         'edit_posts',
         'edit.php?post_type=wp_block',
         '',
         'dashicons-editor-table',
         32
    );

}
add_action( 'admin_menu', 'wd_reusable_blocks_admin_menu' );
