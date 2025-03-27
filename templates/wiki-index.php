<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Get all wiki pages
$wiki_query = new WP_Query(array(
    'post_type' => 'jotunheim_wiki',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
));

// Check if user can edit
$can_edit = Jotunheim_Wiki_Permissions::current_user_can_edit_wiki();
?>

<div class="jotunheim-wiki-container">
    <div class="jotunheim-wiki-header">
        <h2>Wiki Pages</h2>
        <?php if ($can_edit): ?>
            <a href="<?php echo esc_url(add_query_arg('wiki_action', 'create')); ?>" class="button">Create New Page</a>
        <?php endif; ?>
    </div>
    
    <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
        <div class="jotunheim-wiki-notice success">
            <p>Operation completed successfully.</p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="jotunheim-wiki-notice error">
            <p><?php echo esc_html($_GET['error']); ?></p>
        </div>
    <?php endif; ?>
    
    <div class="jotunheim-wiki-content">
        <?php if (!$wiki_query->have_posts()): ?>
            <p>No wiki pages have been created yet.</p>
        <?php else: ?>
            <ul class="jotunheim-wiki-page-list">
                <?php while ($wiki_query->have_posts()): $wiki_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>
