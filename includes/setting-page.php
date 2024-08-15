<?php
// Add settings page under the Books menu
function wp_book_add_settings_page() {
    add_submenu_page(
        'edit.php?post_type=book', // Parent slug
        'Book Settings',           // Page title
        'Settings',                // Menu title
        'manage_options',          // Capability
        'wp_book_settings',        // Menu slug
        'wp_book_settings_page'    // Callback function
    );
}
add_action('admin_menu', 'wp_book_add_settings_page');

// Display the settings page form
function wp_book_settings_page() {
    ?>
    <div class="wrap">
        <h1>Book Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_book_settings_group');
            do_settings_sections('wp_book_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function wp_book_register_settings() {
    register_setting('wp_book_settings_group', 'wp_book_currency');
    register_setting('wp_book_settings_group', 'wp_book_books_per_page');
    
    add_settings_section(
        'wp_book_settings_section',
        'General Settings',
        'wp_book_settings_section_callback',
        'wp_book_settings'
    );
    
    add_settings_field(
        'wp_book_currency',
        'Currency',
        'wp_book_currency_field_callback',
        'wp_book_settings',
        'wp_book_settings_section'
    );
    
    add_settings_field(
        'wp_book_books_per_page',
        'Books Per Page',
        'wp_book_books_per_page_field_callback',
        'wp_book_settings',
        'wp_book_settings_section'
    );
}
add_action('admin_init', 'wp_book_register_settings');

function wp_book_settings_section_callback() {
    echo '<p>Adjust your settings below:</p>';
}

function wp_book_currency_field_callback() {
    $currency = get_option('wp_book_currency', 'USD');
    echo '<input type="text" name="wp_book_currency" value="' . esc_attr($currency) . '" />';
}

function wp_book_books_per_page_field_callback() {
    $books_per_page = get_option('wp_book_books_per_page', 10);
    echo '<input type="number" name="wp_book_books_per_page" value="' . esc_attr($books_per_page) . '" />';
}
