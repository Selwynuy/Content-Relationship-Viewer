<?php
/**
 * Plugin Name: College Department Carousel
 * Plugin URI: 
 * Description: A carousel widget for displaying related posts in Elementor
 * Version: 1.0.0
 * Author: 
 * Author URI: 
 * Text Domain: college-department
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Plugin activation hook
register_activation_hook(__FILE__, 'college_department_carousel_activate');
function college_department_carousel_activate() {
    // Check if Elementor is installed and activated
    if (!did_action('elementor/loaded')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires Elementor to be installed and activated.');
    }
}

// Plugin deactivation hook
register_deactivation_hook(__FILE__, 'college_department_carousel_deactivate');
function college_department_carousel_deactivate() {
    // Cleanup if needed
}

/**
 * Related Posts Carousel
 */

function enqueue_swiper_carousel_assets() {
    // Swiper Carousel Assets
    wp_enqueue_style('swiper-carousel', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-carousel', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array('jquery'), null, true);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

    // Plugin Assets
    wp_enqueue_style('related-posts-carousel', plugins_url('assets/css/related-posts-carousel.css', __FILE__));
    wp_enqueue_script('related-posts-carousel', plugins_url('assets/js/related-posts-carousel.js', __FILE__), array('jquery', 'swiper-carousel'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_carousel_assets');

// Register Elementor Widget
function register_related_posts_carousel_widget($widgets_manager) {
    require_once(__DIR__ . '/widgets/related-posts-carousel-widget.php');
    $widgets_manager->register(new \Related_Posts_Carousel_Widget());
}
add_action('elementor/widgets/register', 'register_related_posts_carousel_widget'); 