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
function wpbk_register_book_post_type() {

    
    $labels = array(
        'name'                  => _x('Books', 'Post type general name', 'wp-book'),
        'singular_name'         => _x('Book', 'Post type singular name', 'wp-book'),
        'menu_name'             => _x('Books', 'Admin Menu text', 'wp-book'), 
        'name_admin_bar'        => _x('Book', 'Add New on Toolbar', 'wp-book'), 
        'add_new'               => __('Add New', 'wp-book'), 
        'add_new_item'          => __('Add New Book', 'wp-book'),
        'new_item'              => __('New Book', 'wp-book'), 
        'edit_item'             => __('Edit Book', 'wp-book'), 
        'view_item'             => __('View Book', 'wp-book'), 
        'all_items'             => __('All Books', 'wp-book'), 
        'search_items'          => __('Search Books', 'wp-book'), 
        'parent_item_colon'     => __('Parent Books:', 'wp-book'), 
        'not_found'             => __('No books found.', 'wp-book'), 
        'not_found_in_trash'    => __('No books found in Trash.', 'wp-book'),
        'featured_image'        => _x('Featured image', 'wp-book'), 
        'set_featured_image'    => _x('Set Featured image', 'wp-book'),
        'remove_featured_image' => _x('Remove cover image','wp-book'),
        'use_featured_image'    => _x('Use as cover image','wp-book'),
        'archives'              => _x('Book archives', 'wp-book'), 
        'insert_into_item'      => _x('Insert into book', 'wp-book'), 
        'uploaded_to_this_item' => _x('Uploaded to this book', 'wp-book'),
        'filter_items_list'     => _x('Filter books list', 'wp-book'), 
        'items_list_navigation' => _x('Books list navigation', 'wp-book'), 
        'items_list'            => _x('Books list', 'wp-book'), 
    );

    $args = array(
        'labels'             => $labels, 
        'public'             => true, 
        'publicly_queryable' => true, 
        'show_ui'            => true, 
        'show_in_menu'       => true, 
        'query_var'          => true, 
        'rewrite'            => array('slug' => 'book'), 
        'capability_type'    => 'post', 
        'has_archive'        => true, 
        'hierarchical'       => false, 
        'menu_position'      => null, 
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
		'taxonomies'         => array( 'category', 'post_tag' ), 
        'show_in_rest'       => true, 
    );

    register_post_type('book', $args);
}

add_action('init', 'wpbk_register_book_post_type');