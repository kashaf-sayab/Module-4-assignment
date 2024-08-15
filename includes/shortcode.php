<?php
function wp_book_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'id' => '', 
        ),
        $atts,
        'book'
    );

    if (empty($atts['id'])) {
        return '<p>No book ID specified.</p>';
    }

    $args = array(
        'post_type' => 'book',
        'p' => intval($atts['id']), 
        'post_status' => 'publish'
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            $author_name = get_post_meta($id, '_wp_book_author_name', true);
            $price = get_post_meta($id, '_wp_book_price', true);
            $publisher = get_post_meta($id, '_wp_book_publisher', true);
            $year = get_post_meta($id, '_wp_book_year', true);
            $edition = get_post_meta($id, '_wp_book_edition', true);
            $url = get_post_meta($id, '_wp_book_url', true);

            echo '<div class="book-details">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p><strong>Author:</strong> ' . esc_html($author_name) . '</p>';
            echo '<p><strong>Price:</strong> ' . esc_html($price) . '</p>';
            echo '<p><strong>Publisher:</strong> ' . esc_html($publisher) . '</p>';
            echo '<p><strong>Year:</strong> ' . esc_html($year) . '</p>';
            echo '<p><strong>Edition:</strong> ' . esc_html($edition) . '</p>';
            echo '<p><strong>URL:</strong> <a href="' . esc_url($url) . '">' . esc_html($url) . '</a></p>';
            echo '</div>';
        }
    } else {
        echo '<p>No book found with the provided ID.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('book', 'wp_book_shortcode');
