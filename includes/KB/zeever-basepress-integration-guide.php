<?php
/**
 * BasePress Zeever Theme Integration Guide
 * 
 * This file contains instructions and code samples for properly integrating 
 * BasePress with the Zeever theme.
 */

// Prevent direct access
if (!defined('ABSPATH')) exit;

/**
 * BasePress Header Integration
 * 
 * Copy this code to your Zeever theme's header-basepress.html file
 * (Located at wp-content/themes/zeever/header-basepress.html)
 */

/**
 * HTML to copy to header-basepress.html:
 * 
 * <!DOCTYPE html>
 * <html <?php language_attributes(); ?>>
 * <head>
 * 	<meta charset="<?php bloginfo( 'charset' ); ?>">
 * 	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
 * 	<link rel="profile" href="http://gmpg.org/xfn/11">
 * 	<?php wp_head(); ?>
 * </head>
 * 
 * <body <?php body_class(); ?>>
 * <?php wp_body_open(); ?>
 * 
 * <?php do_action('zeever_before_header'); ?>
 * 
 * <header id="masthead" class="site-header">
 *     <?php get_template_part('template-parts/header'); ?>
 * </header><!-- #masthead -->
 * 
 * <?php do_action('zeever_after_header'); ?>
 * 
 * <div id="content" class="site-content">
 *     <div class="jotunheim-kb-container">
 *         <div class="jotunheim-kb-content-wrapper">
 */

/**
 * BasePress Footer Integration
 * 
 * Copy this code to your Zeever theme's footer-basepress.html file
 * (Located at wp-content/themes/zeever/footer-basepress.html)
 */

/**
 * HTML to copy to footer-basepress.html:
 * 
 *         </div><!-- .jotunheim-kb-content-wrapper -->
 *     </div><!-- .jotunheim-kb-container -->
 * </div><!-- #content -->
 * 
 * <?php do_action('zeever_before_footer'); ?>
 * 
 * <footer id="colophon" class="site-footer">
 *     <?php get_template_part('template-parts/footer'); ?>
 * </footer>
 * 
 * <?php do_action('zeever_after_footer'); ?>
 * 
 * <?php wp_footer(); ?>
 * </body>
 * </html>
 */

/**
 * Instructions for proper BasePress integration:
 * 
 * 1. Copy the header HTML code above into your Zeever theme's header-basepress.html file
 * 2. Copy the footer HTML code above into your Zeever theme's footer-basepress.html file
 * 3. Make sure both files are in the root directory of your Zeever theme
 * 4. Ensure proper permissions (644 or -rw-r--r--)
 * 5. Clear any caching plugins if changes don't appear immediately
 */