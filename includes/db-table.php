<?php
function wp_book_create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'book_meta';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        book_id bigint(20) NOT NULL,
        meta_key varchar(255) NOT NULL,
        meta_value longtext NOT NULL,
        PRIMARY KEY (id),
        KEY book_id (book_id),
        KEY meta_key (meta_key(191))
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action( 'plugins_loaded', 'wp_book_create_custom_table' );