<?php
/*
 * Plugin Name:       wp-plugin
 * Plugin URI:        https://wp.plugin.com
 * Description:       plugin for managing books 
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            kashaf
 * Author URI:        https://author.example.com/
 * License:           GPL v2 
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://wp.plugin.com
 * Text Domain:       wp-plugin
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
    exit; 
}


function activate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-activator.php';
	Wp_Book_Activator::activate();
}

function deactivate_wp_book() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-book-deactivator.php';
	Wp_Book_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_wp_book' );
register_deactivation_hook( __FILE__, 'deactivate_wp_book' );
//cerated Post,category,tags
require_once plugin_dir_path( __FILE__ ) . 'includes/post-category-tags.php';
//meta box
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-meta-boxes.php';
// meta-table
require_once plugin_dir_path( __FILE__ ) . 'includes/db-table.php';

