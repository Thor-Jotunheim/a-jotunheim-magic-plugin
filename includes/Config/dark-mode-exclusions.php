<?php
// File: includes/Config/dark-mode-exclusions.php

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * Configuration for pages that should exclude the dark mode button
 * 
 * You can specify pages by:
 * - Slug (e.g., 'wiki', 'faq')
 * - Full URL path (e.g., '/wiki/', '/jotunheim-manual/')
 * - Page ID (e.g., 123)
 */
function jotunheim_get_dark_mode_exclusions() {
    return array(
        // Page slugs
        'wiki',
        'jotunheim-manual',
        'faq',
        
        // URL paths (with leading and trailing slashes)
        '/wiki/',
        '/jotunheim-manual/',
        '/faq/',
        
        // Add more pages as needed
        // 'another-page-slug',
        // '/custom-path/',
        // 456, // Page ID example
    );
}

/**
 * Check if the current page should exclude the dark mode button
 * 
 * @return bool True if button should be excluded, false otherwise
 */
function jotunheim_should_exclude_dark_mode_button() {
    $exclusions = jotunheim_get_dark_mode_exclusions();
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Get current page slug
    $current_slug = '';
    if (is_page()) {
        global $post;
        $current_slug = $post->post_name;
    }
    
    // Get current page ID
    $current_page_id = get_the_ID();
    
    foreach ($exclusions as $exclusion) {
        // Check by page ID
        if (is_numeric($exclusion) && $current_page_id == $exclusion) {
            return true;
        }
        
        // Check by slug
        if (is_string($exclusion) && $current_slug === $exclusion) {
            return true;
        }
        
        // Check by URL path
        if (is_string($exclusion) && strpos($current_url, $exclusion) !== false) {
            return true;
        }
    }
    
    return false;
}