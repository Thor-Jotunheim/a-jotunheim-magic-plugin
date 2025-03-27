<?php
// Prevent direct access
if (!defined('ABSPATH')) exit;

// Check if user can edit
if (!Jotunheim_Wiki_Permissions::current_user_can_edit_wiki()) {
    echo '<div class="jotunheim-wiki-notice error"><p>You do not have permission to create wiki pages. You need the "Wiki Editor" role on Discord.</p></div>';
    return;
}
?>

<div class="jotunheim-wiki-container">
    <div class="jotunheim-wiki-header">
        <h2>Create New Wiki Page</h2>
    </div>
    
    <form id="jotunheim-wiki-form" class="jotunheim-wiki-form">
        <?php wp_nonce_field('jotunheim_wiki_nonce', 'wiki_nonce'); ?>
        <input type="hidden" name="action" value="jotunheim_save_wiki_page">
        
        <div class="jotunheim-wiki-form-group">
            <label for="wiki-title">Title</label>
            <input type="text" id="wiki-title" name="title" required>
        </div>
        
        <div class="jotunheim-wiki-form-group">
            <label for="wiki-content">Content (Supports Markdown)</label>
            <textarea id="wiki-content" name="content" rows="15" required></textarea>
        </div>
        
        <div class="jotunheim-wiki-form-actions">
            <button type="submit" class="button button-primary">Create Page</button>
            <a href="<?php echo esc_url(get_post_type_archive_link('jotunheim_wiki')); ?>" class="button button-secondary">Cancel</a>
        </div>
    </form>
    
    <div id="jotunheim-wiki-message" class="jotunheim-wiki-notice" style="display: none;"></div>
</div>
