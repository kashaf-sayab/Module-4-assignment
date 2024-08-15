<?php
function wp_book_add_meta_box() {
    add_meta_box(
        'wp_book_meta_box',
        'Book Details',
        'wp_book_meta_box_callback',
        'book',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'wp_book_add_meta_box' );

function wp_book_meta_box_callback($post) {
    
    wp_nonce_field('wp_book_save_meta_box_data', 'wp_book_meta_box_nonce');

    $author_name = get_post_meta($post->ID, '_wp_book_author_name', true);
    $price = get_post_meta($post->ID, '_wp_book_price', true);
    $publisher = get_post_meta($post->ID, '_wp_book_publisher', true);
    $year = get_post_meta($post->ID, '_wp_book_year', true);
    $edition = get_post_meta($post->ID, '_wp_book_edition', true);
    $url = get_post_meta($post->ID, '_wp_book_url', true);

    ?>
    <label for="wp_book_author_name">Author Name</label>
    <input type="text" id="wp_book_author_name" name="wp_book_author_name" value="<?php echo esc_attr($author_name); ?>" size="25" /><br>

    <label for="wp_book_price">Price</label>
    <input type="text" id="wp_book_price" name="wp_book_price" value="<?php echo esc_attr($price); ?>" size="25" /><br>

    <label for="wp_book_publisher">Publisher</label>
    <input type="text" id="wp_book_publisher" name="wp_book_publisher" value="<?php echo esc_attr($publisher); ?>" size="25" /><br>

    <label for="wp_book_year">Year</label>
    <input type="text" id="wp_book_year" name="wp_book_year" value="<?php echo esc_attr($year); ?>" size="25" /><br>

    <label for="wp_book_edition">Edition</label>
    <input type="text" id="wp_book_edition" name="wp_book_edition" value="<?php echo esc_attr($edition); ?>" size="25" /><br>

    <label for="wp_book_url">URL</label>
    <input type="text" id="wp_book_url" name="wp_book_url" value="<?php echo esc_attr($url); ?>" size="25" />
    <?php
}

function save_book_meta_box_data($post_id) {
    if (!isset($_POST['wp_book_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['wp_book_meta_box_nonce'], 'wp_book_save_meta_box_data')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $author_name = sanitize_text_field($_POST['wp_book_author_name']);
    $price = sanitize_text_field($_POST['wp_book_price']);
    $publisher = sanitize_text_field($_POST['wp_book_publisher']);
    $year = sanitize_text_field($_POST['wp_book_year']);
    $edition = sanitize_text_field($_POST['wp_book_edition']);
    $url = esc_url($_POST['wp_book_url']);

    
    $fields = [
        'author_name' => $author_name,
        'price' => $price,
        'publisher' => $publisher,
        'year' => $year,
        'edition' => $edition,
        'url' => $url,
    ];
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'book_meta';
    
    foreach ($fields as $key => $value) {
        $wpdb->replace(
            $table_name,
            [
                'book_id' => $post_id,
                'meta_key' => '_wp_book_' . $key,
                'meta_value' => $value,
            ],
            [
                '%d',
                '%s',
                '%s'
            ]
        );
    }
}
add_action('save_post', 'save_book_meta_box_data');