<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Check if user can edit
$can_edit = Jotunheim_Wiki_Permissions::current_user_can_edit_wiki();
?>

<div class="jotunheim-wiki-container">
    <div class="jotunheim-wiki-header">
        <h2><?php the_title(); ?></h2>
        <div class="jotunheim-wiki-actions">
            <?php if ($can_edit): ?>
                <a href="<?php echo esc_url(add_query_arg('wiki_action', 'edit')); ?>" class="button button-secondary">Edit</a>
                <button type="button" class="button button-delete" data-post-id="<?php the_ID(); ?>">Delete</button>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_post_type_archive_link('jotunheim_wiki')); ?>" class="button">Back to Wiki</a>
        </div>
    </div>
    
    <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
        <div class="jotunheim-wiki-notice success">
            <p>Wiki page updated successfully.</p>
        </div>
    <?php endif; ?>
    
    <div class="jotunheim-wiki-content">
        <?php the_content(); ?>
    </div>
    
    <div class="jotunheim-wiki-meta">
        <p>
            Created: <?php echo get_the_date('F j, Y'); ?> by <?php the_author(); ?><br>
            Last updated: <?php echo get_the_modified_date('F j, Y'); ?>
        </p>
    </div>
</div>

<?php if ($can_edit): ?>
<div id="delete-wiki-modal" class="jotunheim-wiki-modal" style="display: none;">
    <div class="jotunheim-wiki-modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this wiki page? This action cannot be undone.</p>
        <div class="jotunheim-wiki-modal-actions">
            <button id="confirm-delete" class="button button-primary">Delete</button>
            <button id="cancel-delete" class="button button-secondary">Cancel</button>
        </div>
    </div>
</div>
<?php endif; ?>
