<?php
// Customize Business Info and Promotion Settings
function ccm_customize_register($wp_customize) {
    // Add section for business info
    $wp_customize->add_section('ccm_business_info', array(
        'title'    => __('Business Info', 'custom-content-manager'),
        'priority' => 30,
    ));

    // Add setting for site-wide message
    $wp_customize->add_setting('ccm_promo_message', array(
        'default'   => 'Welcome to our business!',
        'transport' => 'refresh',
    ));

    // Add control for promo message
    $wp_customize->add_control('ccm_promo_message_control', array(
        'label'    => __('Promotional Message', 'custom-content-manager'),
        'section'  => 'ccm_business_info',
        'settings' => 'ccm_promo_message',
        'type'     => 'textarea',
    ));

    // Add setting for business hours
    $wp_customize->add_setting('ccm_business_hours', array(
        'default'   => 'Mon-Fri: 9am-5pm',
        'transport' => 'refresh',
    ));

    // Add control for business hours
    $wp_customize->add_control('ccm_business_hours_control', array(
        'label'    => __('Business Hours', 'custom-content-manager'),
        'section'  => 'ccm_business_info',
        'settings' => 'ccm_business_hours',
        'type'     => 'text',
    ));
}
add_action('customize_register', 'ccm_customize_register');

// Output customized content
function ccm_display_custom_info() {
    echo '<div class="custom-info">';
    echo '<p>' . get_theme_mod('ccm_promo_message', 'Welcome to our business!') . '</p>';
    echo '<p><strong>Business Hours: </strong>' . get_theme_mod('ccm_business_hours', 'Mon-Fri: 9am-5pm') . '</p>';
    echo '</div>';
}
add_action('wp_footer', 'ccm_display_custom_info');
