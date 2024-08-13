<?php
function wp_book_add_meta_box() {
    add_meta_box(
        'wp_book_meta_box',        // Unique ID
        'Book Details',            // Box title
        'wp_book_meta_box_html',   // Content callback, must be of type callable
        'book',                    // Post type
        'normal',                  // Context (where on the screen it will be shown)
        'high'                     // Priority
    );
}
add_action('add_meta_boxes', 'wp_book_add_meta_box');

function wp_book_meta_box_html($post) {
    $author_name = get_post_meta($post->ID, '_wp_book_author_name', true);
    $price = get_post_meta($post->ID, '_wp_book_price', true);
    $publisher = get_post_meta($post->ID, '_wp_book_publisher', true);
    $year = get_post_meta($post->ID, '_wp_book_year', true);
    $edition = get_post_meta($post->ID, '_wp_book_edition', true);
    $url = get_post_meta($post->ID, '_wp_book_url', true);

    wp_nonce_field('wp_book_save_meta_box_data', 'wp_book_meta_box_nonce');

    ?>
    <p>
        <label for="wp_book_author_name">Author Name</label>
        <input type="text" id="wp_book_author_name" name="wp_book_author_name" value="<?php echo esc_attr($author_name); ?>" size="25" />
    </p>
    <p>
        <label for="wp_book_price">Price</label>
        <input type="text" id="wp_book_price" name="wp_book_price" value="<?php echo esc_attr($price); ?>" size="25" />
    </p>
    <p>
        <label for="wp_book_publisher">Publisher</label>
        <input type="text" id="wp_book_publisher" name="wp_book_publisher" value="<?php echo esc_attr($publisher); ?>" size="25" />
    </p>
    <p>
        <label for="wp_book_year">Year</label>
        <input type="text" id="wp_book_year" name="wp_book_year" value="<?php echo esc_attr($year); ?>" size="25" />
    </p>
    <p>
        <label for="wp_book_edition">Edition</label>
        <input type="text" id="wp_book_edition" name="wp_book_edition" value="<?php echo esc_attr($edition); ?>" size="25" />
    </p>
    <p>
        <label for="wp_book_url">URL</label>
        <input type="url" id="wp_book_url" name="wp_book_url" value="<?php echo esc_attr($url); ?>" size="25" />
    </p>
    <?php
}

function wp_book_save_meta_box_data($post_id) {
    if (!isset($_POST['wp_book_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['wp_book_meta_box_nonce'], 'wp_book_save_meta_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'wp_book_author_name',
        'wp_book_price',
        'wp_book_publisher',
        'wp_book_year',
        'wp_book_edition',
        'wp_book_url'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'wp_book_save_meta_box_data');
