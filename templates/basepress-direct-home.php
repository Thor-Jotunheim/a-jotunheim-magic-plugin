<?php
/**
 * Direct override template for BasePress knowledge base home page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Header is automatically added by our filter

// Get KB variables
global $basepress_utils;
$current_kb = $basepress_utils->get_current_knowledge_base();
?>

<div class="jotunheim-kb-content">
    <div class="jotunheim-kb-container">
        <h1 class="jotunheim-kb-home-title"><?php echo esc_html(get_the_title()); ?></h1>
        
        <?php
        // Search form
        if (function_exists('basepress_get_template_part')) {
            basepress_get_template_part('search-form');
        }
        ?>
        
        <div class="jotunheim-kb-home-content">
            <?php
            // Output the page content if there is any
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            
            // Display categories
            if (function_exists('basepress_get_kb_categories') && function_exists('basepress_get_template_part')) {
                $kb_categories = basepress_get_kb_categories($current_kb->term_id);
                
                if (!empty($kb_categories)) :
                    ?>
                    <div class="jotunheim-kb-categories">
                        <?php
                        foreach ($kb_categories as $kb_category) {
                            set_query_var('kb_category', $kb_category);
                            basepress_get_template_part('content-category');
                        }
                        ?>
                    </div>
                    <?php
                endif;
            }
            ?>
        </div>
    </div>
</div>

<?php
// Footer is automatically added by our filter