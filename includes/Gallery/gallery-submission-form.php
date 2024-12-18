<?php
function render_gallery_submission_form() {
    if (!is_user_logged_in()) {
        echo '<p>You must be logged in to submit a gallery.</p>';
        return;
    }

    ?>
    <form id="gallery-submission-form" enctype="multipart/form-data" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <?php wp_nonce_field('gallery_submission', 'gallery_submission_nonce'); ?>

        <label for="build_name">Build Name:</label>
        <input type="text" id="build_name" name="build_name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="created_by">Created By:</label>
        <input type="text" id="created_by" name="created_by" required><br>

        <label for="photos">Attach Photos (minimum 4):</label>
        <input type="file" id="photos" name="photos[]" multiple accept="image/*" required><br>

        <button type="submit" name="action" value="submit_gallery">Submit</button>
    </form>
    <?php
}
add_shortcode('gallery_submission_form', 'render_gallery_submission_form');