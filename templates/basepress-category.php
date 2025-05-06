<?php
/**
 * Template for displaying BasePress category archives
 * This template ensures we use the standard theme header and footer
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Get the theme header with standard site structure
get_header();

// Get current category data
$term = get_queried_object();
?>

<div class="jotunheim-kb-container">
    <div class="jotunheim-kb-content-wrapper">
        <!-- Category header -->
        <header class="kb-category-header">
            <?php 
            if (function_exists('basepress_breadcrumbs')) {
                basepress_breadcrumbs();
            }
            ?>
            
            <h1 class="kb-category-title"><?php echo esc_html($term->name); ?></h1>
            
            <?php if (!empty($term->description)): ?>
                <div class="kb-category-description">
                    <?php echo wp_kses_post($term->description); ?>
                </div>
            <?php endif; ?>
        </header>

        <!-- Category content -->
        <main class="kb-category-content">
            <?php
            if (have_posts()) :
                echo '<div class="kb-articles-grid">';
                
                // Loop for articles
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('kb-article-item'); ?>>
                        <h2 class="kb-article-item-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php if (has_excerpt()): ?>
                            <div class="kb-article-item-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </article>
                    <?php
                endwhile;
                
                echo '</div>';

                // Previous/next page navigation
                if (function_exists('basepress_pagination')) {
                    basepress_pagination();
                }
            else :
                ?>
                <div class="kb-no-articles">
                    <p><?php _e('No articles found in this category.', 'basepress'); ?></p>
                </div>
                <?php
            endif;
            
            // Display subcategories if any
            if (function_exists('basepress_get_subcategories') && function_exists('basepress_get_template_part')) {
                $subcategories = basepress_get_subcategories($term->term_id);
                if (!empty($subcategories)) {
                    echo '<div class="kb-subcategories">';
                    echo '<h2 class="kb-subcategories-title">' . __('Subcategories', 'basepress') . '</h2>';
                    
                    foreach ($subcategories as $subcategory) {
                        set_query_var('kb_category', $subcategory);
                        basepress_get_template_part('content-category');
                    }
                    
                    echo '</div>';
                }
            }
            ?>
        </main>
    </div>
</div>

<?php
// Get the theme footer
get_footer();
?>