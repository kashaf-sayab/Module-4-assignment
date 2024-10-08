<?php
/*
 * Plugin Name:       wp-book
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
 * Text Domain:       wp-book
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
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-post.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-taxonomies.php';
//meta box
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-meta-boxes.php';
// meta-table
require_once plugin_dir_path( __FILE__ ) . 'includes/db-table.php';
// setting page
require_once plugin_dir_path( __FILE__ ) . 'includes/setting-page.php';
// add short code
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

// add widgets
require_once plugin_dir_path( __FILE__ ) . 'includes/widgets.php';

// add dashboard widgets
require_once plugin_dir_path( __FILE__ ) . 'includes/dashboard-widget.php';
