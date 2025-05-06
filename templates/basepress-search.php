<?php
/**
 * Template for displaying BasePress search results
 * This template ensures we use the standard theme header and footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the theme header with standard site structure
get_header();
?>

<div class="jotunheim-kb-container">
    <div class="jotunheim-kb-content-wrapper">
        <!-- Search results header -->
        <header class="kb-search-header">
            <?php 
            if (function_exists('basepress_breadcrumbs')) {
                basepress_breadcrumbs();
            }
            ?>
            
            <h1 class="kb-search-title">
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
        <main class="kb-search-results">
            <?php
            if (have_posts()) :
                // Display the search form at the top
                if (function_exists('basepress_get_template_part')) {
                    basepress_get_template_part('search-form');
                }
                
                echo '<div class="kb-search-results-list">';
                
                // Start the Loop
                while (have_posts()) : the_post();
                    // Include the search results content template
                    if (function_exists('basepress_get_template_part')) {
                        basepress_get_template_part('content-search');
                    } else {
                        // Fallback in case the function doesn't exist
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('kb-search-item'); ?>>
                            <h2 class="kb-search-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="kb-search-item-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                        <?php
                    }
                endwhile;
                
                echo '</div>';

                // Previous/next page navigation
                if (function_exists('basepress_pagination')) {
                    basepress_pagination();
                }
            else :
                // No results found template
                if (function_exists('basepress_get_template_part')) {
                    basepress_get_template_part('content-none');
                } else {
                    // Fallback
                    ?>
                    <div class="kb-no-results">
                        <p><?php _e('No results found. Please try a different search.', 'basepress'); ?></p>
                    </div>
                    <?php
                }
            endif;
            ?>
        </main>
    </div>
</div>

<?php
// Get the theme footer
get_footer();
?>