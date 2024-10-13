<?php
// Add Meta Box
function ccm_add_custom_meta_box() {
    add_meta_box(
        'ccm_meta_box_id',
        __('Additional Information', 'custom-content-manager'),
        'ccm_meta_box_callback',
        'page', // You can also add this to 'post' or custom post types
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'ccm_add_custom_meta_box');

// Meta Box Callback Function
function ccm_meta_box_callback($post) {
    // Add a nonce field so we can check for it later.
    wp_nonce_field('ccm_meta_box_nonce', 'ccm_meta_box_nonce_field');

    // Get previously saved meta
    $testimonial = get_post_meta($post->ID, '_ccm_testimonial', true);
    ?>
    <p>
        <label for="ccm_testimonial"><?php _e('Customer Testimonial:', 'custom-content-manager'); ?></label>
        <textarea id="ccm_testimonial" name="ccm_testimonial" rows="4" style="width: 100%;"><?php echo esc_textarea($testimonial); ?></textarea>
    </p>
    <?php
}

// Save Meta Box Data
function ccm_save_meta_box_data($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['ccm_meta_box_nonce_field'])) {
        return;
    }
    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['ccm_meta_box_nonce_field'], 'ccm_meta_box_nonce')) {
        return;
    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    }

    // Sanitize and save the testimonial data
    if (isset($_POST['ccm_testimonial'])) {
        $testimonial = sanitize_textarea_field($_POST['ccm_testimonial']);
        update_post_meta($post_id, '_ccm_testimonial', $testimonial);
    }
}
add_action('save_post', 'ccm_save_meta_box_data');
