<?php
/**
 * Custom search template for BasePress search results
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the custom header
basepress_get_header('basepress');
?>
<div class="jotunheim-kb-content-wrapper">
    <div class="bpress-wrap">
        <div class="bpress-content-area bpress-full-width">
            
            <!-- Search results header -->
            <header class="bpress-page-header">
                <?php basepress_breadcrumbs(); ?>
                <h1 class="bpress-page-title">
                    <?php 
                    global $basepress_utils, $wp_query;
                    $options = $basepress_utils->get_options();
                    $search_page_title = isset($options['search_page_title']) ? $options['search_page_title'] : __('Search results for: %s', 'basepress');
                    
                    if ($wp_query->found_posts == 0 && isset($options['search_page_no_results_title'])) {
                        echo esc_html(str_replace('%s', get_search_query(), $options['search_page_no_results_title']));
                    } else {
                        $search_page_title = str_replace('%number%', $wp_query->found_posts, $search_page_title);
                        echo esc_html(str_replace('%s', get_search_query(), $search_page_title));
                    }
                    ?>
                </h1>
            </header>

            <!-- Search results content -->
            <main class="bpress-main" role="main">
                <div class="bpress-content-wrap">
                    <?php
                    if (have_posts()) :
                        // Start the Loop
                        while (have_posts()) : the_post();
                            // Include the search results content template
                            basepress_get_template_part('content-search');
                        endwhile;

                        // Previous/next page navigation
                        basepress_pagination();
                    else :
                        // No results template
                        basepress_get_template_part('content-none');
                    endif;
                    ?>
                </div>
            </main>
        </div><!-- .bpress-content-area -->
    </div><!-- .bpress-wrap -->
</div><!-- .jotunheim-kb-content-wrapper -->

<?php 
// Custom hook before footer
do_action('jotunheim_kb_before_basepress_footer');

// Get the custom footer
basepress_get_footer('basepress');
?>