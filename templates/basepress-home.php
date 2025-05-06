<?php
/**
 * Template for displaying the BasePress knowledge base home page
 * This template ensures we use the standard theme header and footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the theme header with standard site structure
get_header();

// Get KB vars
global $basepress_utils;
$knowledge_bases = $basepress_utils->get_knowledge_bases();
$current_knowledge_base = $basepress_utils->get_current_knowledge_base();
?>

<div class="jotunheim-kb-container">
    <div class="jotunheim-kb-content-wrapper">
        <!-- Knowledge base header -->
        <header class="kb-home-header">
            <h1 class="kb-home-title">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
            
            <?php 
            // Add search form if enabled
            if (function_exists('basepress_get_template_part')) {
                basepress_get_template_part('search-form');
            }
            ?>
        </header>

        <!-- Knowledge base content -->
        <div class="kb-home-content">
            <?php
            // Output the page content if there is any
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            
            // Display categories
            if (function_exists('basepress_get_kb_categories') && function_exists('basepress_get_template_part')) {
                $kb_categories = basepress_get_kb_categories($current_knowledge_base->term_id);
                
                if (!empty($kb_categories)) {
                    echo '<div class="kb-categories-grid">';
                    
                    foreach ($kb_categories as $kb_category) {
                        set_query_var('kb_category', $kb_category);
                        basepress_get_template_part('content-category');
                    }
                    
                    echo '</div>';
                }
            } else {
                // Fallback if functions aren't available
                ?>
                <div class="kb-categories-fallback">
                    <p><?php _e('Categories could not be loaded. Please ensure BasePress is properly installed.', 'basepress'); ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
// Get the theme footer
get_footer();
?>