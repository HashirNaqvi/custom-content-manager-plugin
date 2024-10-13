<?php
/*
Plugin Name: Custom Content Manager for Small Businesses
Description: A plugin to manage promotional sidebars, customize site-wide messages, and add meta information for small business websites.
Version: 1.0
Author:Hashir Naqvi
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once(plugin_dir_path(__FILE__) . 'inc/register-sidebars.php');
require_once(plugin_dir_path(__FILE__) . 'inc/customizer-settings.php');
require_once(plugin_dir_path(__FILE__) . 'inc/meta-boxes.php');
