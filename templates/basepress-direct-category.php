<?php
/**
 * Direct override template for BasePress knowledge base category archive
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Header is automatically added by our filter

// Get the current category term
$term = get_queried_object();
?>

<div class="jotunheim-kb-content">
    <div class="jotunheim-kb-container">
        <!-- Breadcrumbs -->
        <?php 
        if (function_exists('basepress_breadcrumbs')) {
            basepress_breadcrumbs();
        }
        ?>
        
        <header class="jotunheim-kb-category-header">
            <h1 class="jotunheim-kb-category-title"><?php echo esc_html($term->name); ?></h1>
            
            <?php if (!empty($term->description)): ?>
                <div class="jotunheim-kb-category-description">
                    <?php echo wp_kses_post($term->description); ?>
                </div>
            <?php endif; ?>
            
            <?php
            // Search form
            if (function_exists('basepress_get_template_part')) {
                basepress_get_template_part('search-form');
            }
            ?>
        </header>
        
        <div class="jotunheim-kb-category-content">
            <?php
            if (have_posts()) :
                ?>
                <div class="jotunheim-kb-articles">
                    <?php
                    // Start the Loop
                    while (have_posts()) : the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('jotunheim-kb-article-item'); ?>>
                            <h2 class="jotunheim-kb-article-item-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <?php if (has_excerpt()): ?>
                                <div class="jotunheim-kb-article-item-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>
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
                ?>
                <p class="jotunheim-kb-no-articles"><?php _e('No articles found in this category.', 'basepress'); ?></p>
                <?php
            endif;
            
            // Display subcategories if any
            if (function_exists('basepress_get_subcategories') && function_exists('basepress_get_template_part')) {
                $subcategories = basepress_get_subcategories($term->term_id);
                
                if (!empty($subcategories)) :
                    ?>
                    <div class="jotunheim-kb-subcategories">
                        <h2 class="jotunheim-kb-subcategories-title"><?php _e('Subcategories', 'basepress'); ?></h2>
                        <?php
                        foreach ($subcategories as $subcategory) {
                            set_query_var('kb_category', $subcategory);
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