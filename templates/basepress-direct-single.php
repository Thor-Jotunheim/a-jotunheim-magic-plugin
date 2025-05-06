<?php
/**
 * Direct override template for BasePress single articles
 * This template bypasses BasePress's theme system and directly uses get_header/get_footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Header is automatically added by our filter

// Get the post
global $post;
?>

<div class="jotunheim-kb-content">
    <div class="jotunheim-kb-container">
        <!-- Breadcrumbs -->
        <?php 
        if (function_exists('basepress_breadcrumbs')) {
            basepress_breadcrumbs();
        }
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('jotunheim-kb-article'); ?>>
            <header class="jotunheim-kb-article-header">
                <h1 class="jotunheim-kb-article-title"><?php the_title(); ?></h1>
            </header>

            <div class="jotunheim-kb-article-content">
                <?php 
                // Article content
                the_content();
                
                // Votes if available
                if (function_exists('basepress_votes')) {
                    basepress_votes();
                }
                ?>
            </div>
        </article>
        
        <?php
        // Article navigation
        if (function_exists('basepress_get_template_part')) {
            basepress_get_template_part('adjacent-articles');
        }
        
        // Comments
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </div>
</div>

<?php
// Footer is automatically added by our filter