<?php

function wp_book_add_dashboard_widgets() {
    wp_add_dashboard_widget(
        'wp_book_top_categories', 
        'Top 5 Book Categories', 
        'wp_book_display_top_categories' 
    );
}
add_action('wp_dashboard_setup', 'wp_book_add_dashboard_widgets');


function wp_book_display_top_categories() {
    global $wpdb;

    $taxonomy = 'book_category';
    if (!taxonomy_exists($taxonomy)) {
        echo '<p>Taxonomy not found.</p>';
        return;
    }

    $query = "
        SELECT t.term_id, t.name, COUNT(p.ID) as book_count
        FROM {$wpdb->terms} t
        INNER JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
        LEFT JOIN {$wpdb->term_relationships} tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
        LEFT JOIN {$wpdb->posts} p ON tr.object_id = p.ID
        WHERE tt.taxonomy = %s AND p.post_type = 'book' AND p.post_status = 'publish'
        GROUP BY t.term_id
        ORDER BY book_count DESC
        LIMIT 5
    ";

    $results = $wpdb->get_results($wpdb->prepare($query, $taxonomy));

    if ($results) {
        echo '<ul>';
        foreach ($results as $category) {
            echo '<li>' . esc_html($category->name) . ': ' . esc_html($category->book_count) . ' books</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No categories found.</p>';
    }
}
