<?php
/**
 * Direct override template for BasePress knowledge base search results
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Header is automatically added by our filter
?>

<div class="jotunheim-kb-content">
    <div class="jotunheim-kb-container">
        <!-- Search header -->
        <header class="jotunheim-kb-search-header">
            <?php 
            if (function_exists('basepress_breadcrumbs')) {
                basepress_breadcrumbs();
            }
            
            // Get search results info
            global $basepress_utils, $wp_query;
            $options = $basepress_utils->get_options();
            $search_page_title = isset($options['search_page_title']) ? $options['search_page_title'] : __('Search results for: %s', 'basepress');
            ?>
            
            <h1 class="jotunheim-kb-search-title">
                <?php
                if ($wp_query->found_posts == 0 && isset($options['search_page_no_results_title'])) {
                    echo esc_html(str_replace('%s', get_search_query(), $options['search_page_no_results_title']));
                } else {
                    $search_page_title = str_replace('%number%', $wp_query->found_posts, $search_page_title);
                    echo esc_html(str_replace('%s', get_search_query(), $search_page_title));
                }
                ?>
            </h1>
            
            <?php
            // Search form
            if (function_exists('basepress_get_template_part')) {
                basepress_get_template_part('search-form');
            }
            ?>
        </header>
        
        <!-- Search results -->
        <div class="jotunheim-kb-search-results">
            <?php
            if (have_posts()) :
                ?>
                <div class="jotunheim-kb-search-articles">
                    <?php
                    // Start the Loop
                    while (have_posts()) : the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('jotunheim-kb-search-item'); ?>>
                            <h2 class="jotunheim-kb-search-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="jotunheim-kb-search-item-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php
                // Pagination
                if (function_exists('basepress_pagination')) {
                    basepress_pagination();
                }
            else:
                if (function_exists('basepress_get_template_part')) {
                    basepress_get_template_part('content-none');
                } else {
                    ?>
                    <div class="jotunheim-kb-no-results">
                        <p><?php _e('No results found. Please try a different search term.', 'basepress'); ?></p>
                    </div>
                    <?php
                }
            endif;
            ?>
        </div>
    </div>
</div>

<?php
// Footer is automatically added by our filter