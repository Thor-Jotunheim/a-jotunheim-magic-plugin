<?php
/**
 * Template for displaying BasePress single articles
 * This template ensures we use the standard theme header and footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the theme header with standard site structure
get_header();
?>

<div class="jotunheim-kb-container">
    <div class="jotunheim-kb-content-wrapper">
        <?php 
        // Add breadcrumbs
        if (function_exists('basepress_breadcrumbs')) {
            basepress_breadcrumbs();
        }
        
        // Start the loop
        while (have_posts()) : the_post(); 
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('kb-article'); ?>>
                <header class="kb-article-header">
                    <h1 class="kb-article-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="kb-article-content">
                    <?php the_content(); ?>
                </div>
                
                <?php 
                // Add voting if available
                if (function_exists('basepress_votes')) {
                    basepress_votes();
                }
                ?>
            </article>
            
            <?php 
            // Add adjacent articles navigation
            if (function_exists('basepress_get_template_part')) {
                basepress_get_template_part('adjacent-articles');
            }
            
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
        endwhile; 
        ?>
    </div>
</div>

<?php
// Get the theme footer
get_footer();
?>