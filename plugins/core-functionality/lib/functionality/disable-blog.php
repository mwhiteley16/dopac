<?php
/**
 * Core Functionality Plugin
 * 
 * @package    CoreFunctionality
 * @since      1.0.0
 * @copyright  Copyright (c) 2014, Bill Erickson & Jared Atchison
 * @license    GPL-2.0+
 */

class EA_Disable_Blog{
 
  /**
	 * This is our constructor
	 *
	 */
	public function __construct() {
 
		add_action( 'admin_menu',                 array( $this, 'remove_menu_items'        ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'remove_from_admin_bar'    ) );
		add_action( 'wp_dashboard_setup',         array( $this, 'remove_dashboard_widgets' ) );
 
	}
	
	/**
	 * Remove Menu Items
	 *
	 */
	function remove_menu_items() {
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
	}
	
	/**
	 * Remove from Admin Bar
	 *
	 */
	function remove_from_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'new-post', 'new-content' );
	}
	
	/**
	 * Remove Dashboard Widgets
	 *
	 */
	function remove_dashboard_widgets() {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	}
 
}
new EA_Disable_Blog();