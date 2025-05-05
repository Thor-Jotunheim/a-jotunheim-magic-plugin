<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Knowledge Base Interface
 * 
 * Renders the interface for the knowledge base, including the New+ button
 * for authorized users and search/filtering functionality.
 */
function jotunheim_knowledge_base_interface() {
    // Get the proper knowledge base post type
    $kb_post_type = function_exists('basepress_get_post_type') ? basepress_get_post_type() : 'knowledgebase';
    
    // Check if user has permission to edit
    $can_edit = current_user_can('edit_' . $kb_post_type . 's');
    
    // Get the taxonomy used for categories (may vary with different KB plugins)
    $taxonomy = 'knowledge_category';
    if (function_exists('basepress_get_taxonomy') && basepress_get_taxonomy()) {
        $taxonomy = basepress_get_taxonomy();
    }
    
    // Get categories for the knowledge base
    $categories = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ]);
    
    // Start output buffering
    ob_start();
    ?>
    <div class="knowledge-base-container">
        <div class="knowledge-base-header">
            <h1>Jotunheim Knowledge Base</h1>
            <?php if ($can_edit): ?>
            <div class="knowledge-base-actions">
                <a href="<?php echo esc_url(admin_url('post-new.php?post_type=' . $kb_post_type)); ?>" class="button button-primary">New+ Knowledge Base Entry</a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Add search box -->
        <div class="knowledge-base-search">
            <input type="text" id="kb-search" placeholder="Search Knowledge Base...">
        </div>
        
        <!-- Categories and posts -->
        <div class="knowledge-base-content">
            <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                <div class="knowledge-base-categories">
                    <h3>Categories</h3>
                    <ul>
                        <li><a href="#" class="kb-category-link active" data-category="all">All Categories</a></li>
                        <?php foreach ($categories as $category) : ?>
                            <li><a href="#" class="kb-category-link" data-category="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <div class="knowledge-base-posts">
                <h3>Articles</h3>
                <div id="kb-posts-container">
                    <?php
                    $args = [
                        'post_type' => $kb_post_type,
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ];
                    
                    $query = new WP_Query($args);
                    
                    if ($query->have_posts()) :
                        echo '<ul class="kb-posts-list">';
                        while ($query->have_posts()) : $query->the_post();
                            $post_categories = get_the_terms(get_the_ID(), $taxonomy);
                            $category_slugs = [];
                            
                            if (!empty($post_categories) && !is_wp_error($post_categories)) {
                                foreach ($post_categories as $cat) {
                                    $category_slugs[] = $cat->slug;
                                }
                            }
                            
                            echo '<li class="kb-post-item" data-categories="' . esc_attr(implode(' ', $category_slugs)) . '">';
                            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
                            if ($can_edit) {
                                echo ' <a href="' . esc_url(get_edit_post_link()) . '" class="kb-edit-link">[Edit]</a>';
                            }
                            echo '</li>';
                        endwhile;
                        echo '</ul>';
                    else :
                        echo '<p>No knowledge base entries found.</p>';
                    endif;
                    
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Filter by category
        $('.kb-category-link').on('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            $('.kb-category-link').removeClass('active');
            
            // Add active class to clicked link
            $(this).addClass('active');
            
            var category = $(this).data('category');
            
            if (category === 'all') {
                // Show all posts
                $('.kb-post-item').show();
            } else {
                // Hide all posts first
                $('.kb-post-item').hide();
                
                // Show posts in selected category
                $('.kb-post-item[data-categories*="' + category + '"]').show();
            }
        });
        
        // Search functionality
        $('#kb-search').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            
            $('.kb-post-item').each(function() {
                var title = $(this).text().toLowerCase();
                
                if (title.indexOf(searchTerm) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            
            // Reset category filter when searching
            $('.kb-category-link').removeClass('active');
            $('.kb-category-link[data-category="all"]').addClass('active');
        });
    });
    </script>
    
    <style>
    .knowledge-base-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .knowledge-base-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .knowledge-base-search {
        margin-bottom: 20px;
    }
    
    .knowledge-base-search input {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }
    
    .knowledge-base-content {
        display: flex;
        gap: 20px;
    }
    
    .knowledge-base-categories {
        flex: 0 0 250px;
    }
    
    .knowledge-base-categories ul {
        list-style: none;
        padding: 0;
    }
    
    .knowledge-base-categories li {
        margin-bottom: 10px;
    }
    
    .knowledge-base-categories a {
        text-decoration: none;
        color: #333;
    }
    
    .knowledge-base-categories a.active {
        font-weight: bold;
        color: #0073aa;
    }
    
    .knowledge-base-posts {
        flex: 1;
    }
    
    .kb-posts-list {
        list-style: none;
        padding: 0;
    }
    
    .kb-post-item {
        margin-bottom: 10px;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 5px;
    }
    
    .kb-post-item a {
        text-decoration: none;
        color: #333;
    }
    
    .kb-edit-link {
        color: #0073aa;
        font-size: 0.8em;
        margin-left: 5px;
    }
    
    .button-primary {
        display: inline-block;
        padding: 10px 15px;
        background: #0073aa;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }
    
    @media (max-width: 768px) {
        .knowledge-base-content {
            flex-direction: column;
        }
        
        .knowledge-base-categories {
            flex: 0 0 auto;
        }
    }
    </style>
    <?php
    
    // Return the buffered content
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('jotunheim_knowledge_base', 'jotunheim_knowledge_base_interface');