<?php
function wp_book_load_widget() {
    register_widget('WP_Book_Category_Widget');
}
add_action('widgets_init', 'wp_book_load_widget');

class WP_Book_Category_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wp_book_category_widget', 
            'Books by Category', 
            array('description' => __('A Widget to display books by selected category.', 'wp-book'),) // Args
        );
    }

    public function widget($args, $instance) {
        $category_id = !empty($instance['category_id']) ? $instance['category_id'] : 0;
        
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $this->display_books_by_category($category_id);
        
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Books by Category', 'wp-book');
        $category_id = !empty($instance['category_id']) ? $instance['category_id'] : 0;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-book'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Category:', 'wp-book'); ?></label>
            <?php
            wp_dropdown_categories(array(
                'show_option_all' => __('Select Category', 'wp-book'),
                'name' => $this->get_field_name('category_id'),
                'id' => $this->get_field_id('category_id'),
                'selected' => $category_id,
                'taxonomy' => 'book_category',
                'hide_empty' => false,
            ));
            ?>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['category_id'] = (!empty($new_instance['category_id'])) ? intval($new_instance['category_id']) : 0;
        return $instance;
    }

    private function display_books_by_category($category_id) {
        if (!$category_id) {
            echo '<p>' . __('No category selected.', 'wp-book') . '</p>';
            return;
        }

        $args = array(
            'post_type' => 'book',
            'tax_query' => array(
                array(
                    'taxonomy' => 'book_category',
                    'field'    => 'id',
                    'terms'    => $category_id,
                ),
            ),
        );

        $query = new WP_Query($args);

        if (!$query->have_posts()) {
            echo '<p>' . __('No books found in this category.', 'wp-book') . '</p>';
            return;
        }

        echo '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';

        wp_reset_postdata();
    }
}
