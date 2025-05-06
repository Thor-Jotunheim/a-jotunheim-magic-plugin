<?php
/**
 * Custom full-width template for BasePress articles
 * 
 * This template overrides the default BasePress full-width template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the custom header
basepress_get_header('basepress');
?>
<div class="jotunheim-kb-content-wrapper">
    <div class="bpress-wrap">
        <div class="bpress-content-area bpress-full-width">
            
            <!-- Breadcrumbs -->
            <?php basepress_breadcrumbs(); ?>
            
            <!-- Article content -->
            <main class="bpress-main" role="main">
                <div class="bpress-content-wrap">
                <?php
                // Start the loop
                while (have_posts()) : the_post();

                    // Include the article content template
                    basepress_get_template_part('post-content');

                    // Get Votes section if enabled
                    basepress_votes();

                    // End of the loop
                endwhile;
                ?>

                <!-- Add previous and next articles navigation -->
                <?php basepress_get_template_part('adjacent-articles'); ?>
                </div>
            </main>

            <?php
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>

        </div><!-- content area -->
    </div><!-- .bpress-wrap -->
</div><!-- .jotunheim-kb-content-wrapper -->

<?php 
// Hook for content before footer
do_action('jotunheim_kb_before_basepress_footer');

// Get the custom footer
basepress_get_footer('basepress'); 
?>