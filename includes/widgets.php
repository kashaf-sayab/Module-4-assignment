<?php
class WP_Book_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wp_book_widget', // Base ID
            'Books by Category', // Name
            array('description' => __('A widget to display books by category', 'wp-book'))
        );
    }

    public function widget($args, $instance) {
        $category = !empty($instance['category']) ? $instance['category'] : '';
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if ($category) {
            $this->get_books_by_category($category);
        }
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $category = !empty($instance['category']) ? $instance['category'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'wp-book'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php _e('Category:', 'wp-book'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
                <?php
                $terms = get_terms(array('taxonomy' => 'book_category', 'hide_empty' => false));
                foreach ($terms as $term) {
                    echo '<option value="' . esc_attr($term->slug) . '" ' . selected($category, $term->slug, false) . '>' . esc_html($term->name) . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
        return $instance;
    }

    private function get_books_by_category($category) {
        $query = new WP_Query(array(
            'post_type' => 'book',
            'tax_query' => array(
                array(
                    'taxonomy' => 'book_category',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            ),
        ));

        if ($query->have_posts()) {
            echo '<ul>';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        } else {
            _e('No books found in this category.', 'wp-book');
        }
        wp_reset_postdata();
    }
}
