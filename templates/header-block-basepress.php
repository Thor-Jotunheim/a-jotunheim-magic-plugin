<?php
/**
 * Minimal header template that allows WordPress site editor header block to be used
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Use WordPress core get_header to ensure block templates are properly loaded
get_header();

// No other output needed as we want the theme's block header to be used
?>