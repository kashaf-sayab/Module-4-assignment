<?php

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
        'featured_image'        => __('Featured image', 'wp-book'), 
        'set_featured_image'    => __('Set Featured image', 'wp-book'),
        'remove_featured_image' => __('Remove cover image','wp-book'),
        'use_featured_image'    => __('Use as cover image','wp-book'),
        'archives'              => __('Book archives', 'wp-book'), 
        'insert_into_item'      => __('Insert into book', 'wp-book'), 
        'uploaded_to_this_item' => __('Uploaded to this book', 'wp-book'),
        'filter_items_list'     => __('Filter books list', 'wp-book'), 
        'items_list_navigation' => __('Books list navigation', 'wp-book'), 
        'items_list'            => __('Books list', 'wp-book'), 
    );

    $args = array(
        'labels'             => $labels, 
        'public'             => true, 
        'publicly_queryable' => true, 
        'show_ui'            => true, 
        'show_in_menu'       => true, 
        'menu_icon'          => 'dashicons-book',
        'query_var'          => true, 
        'rewrite'            => array('slug' => 'book'), 
        'capability_type'    => 'post', 
        'has_archive'        => true, 
        'hierarchical'       => false, 
        'menu_position'      => null, 
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'), 
        'show_in_rest'       => true, 
    );

    register_post_type('book', $args);
}

add_action('init', 'wpbk_register_book_post_type');