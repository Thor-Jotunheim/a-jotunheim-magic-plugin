<?php
function render_gallery_submission_form() {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to submit a gallery.</p>';
    }

    ob_start();
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
        <div id="photo-upload-container">
            <input type="file" name="photos[]" accept="image/*">
        </div>
        <button type="button" id="add-photo-upload">Add Another Photo</button><br>
        
        <button type="submit" name="action" value="submit_gallery">Submit</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addPhotoButton = document.getElementById('add-photo-upload');
            const container = document.getElementById('photo-upload-container');
            
            addPhotoButton.addEventListener('click', function () {
                const input = document.createElement('input');
                input.type = 'file';
                input.name = 'photos[]';
                input.accept = 'image/*';
                container.appendChild(input);
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('gallery_submission_form', 'render_gallery_submission_form');