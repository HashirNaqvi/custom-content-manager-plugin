<?php
// Widget class to display promotions
class CCM_Promotion_Widget extends WP_Widget {
    
    // Constructor for the widget
    public function __construct() {
        parent::__construct(
            'ccm_promotion_widget', // Base ID
            __('Promotion Sidebar', 'custom-content-manager'), // Widget name
            array('description' => __('Displays promotions on selected pages.', 'custom-content-manager')) // Args
        );
    }

    // Frontend display logic for the widget
    public function widget($args, $instance) {
        if (!empty($instance['pages']) && is_array($instance['pages'])) {
            // Display widget only on selected pages
            if (!is_page($instance['pages'])) {
                return; // Don't show the widget if not on selected pages
            }
        }

        echo $args['before_widget']; // Widget wrapper start
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if (!empty($instance['content'])) {
            echo '<p>' . esc_html($instance['content']) . '</p>';
        }
        echo $args['after_widget']; // Widget wrapper end
    }

    // Backend widget form (admin side)
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $content = !empty($instance['content']) ? $instance['content'] : '';
        $selected_pages = !empty($instance['pages']) ? $instance['pages'] : array();

        // Fetch all published pages
        $pages = get_pages();
        ?>
        <!-- Title Field -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'custom-content-manager'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <!-- Content Field -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php _e('Content:', 'custom-content-manager'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>" rows="4"><?php echo esc_textarea($content); ?></textarea>
        </p>

        <!-- Page Selection Field -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('pages')); ?>"><?php _e('Select Pages to Display:', 'custom-content-manager'); ?></label>
            <select multiple="multiple" class="widefat" id="<?php echo esc_attr($this->get_field_id('pages')); ?>" name="<?php echo esc_attr($this->get_field_name('pages')); ?>[]">
                <?php foreach ($pages as $page): ?>
                    <option value="<?php echo esc_attr($page->ID); ?>" <?php echo in_array($page->ID, $selected_pages) ? 'selected="selected"' : ''; ?>>
                        <?php echo esc_html($page->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small><?php _e('Hold CTRL (Windows) or CMD (Mac) to select multiple pages.', 'custom-content-manager'); ?></small>
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['content'] = (!empty($new_instance['content'])) ? sanitize_text_field($new_instance['content']) : '';
        $instance['pages'] = (!empty($new_instance['pages'])) ? array_map('intval', $new_instance['pages']) : array();
        return $instance;
    }
}

// Register the widget
function ccm_register_promotion_sidebar_widget() {
    register_widget('CCM_Promotion_Widget');
}
add_action('widgets_init', 'ccm_register_promotion_sidebar_widget');

// Register the sidebar where the widget will be placed
function ccm_register_promotion_sidebar() {
    register_sidebar(array(
        'name'          => __('Promotion Sidebar', 'custom-content-manager'),
        'id'            => 'promotion-sidebar',
        'description'   => __('Displays promotions in the sidebar.', 'custom-content-manager'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'ccm_register_promotion_sidebar');
