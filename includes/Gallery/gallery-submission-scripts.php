<?php
function handle_gallery_submission() {
    if (!isset($_POST['gallery_submission_nonce']) || !wp_verify_nonce($_POST['gallery_submission_nonce'], 'gallery_submission')) {
        wp_die('Nonce verification failed.');
    }

    // Validate input
    if (empty($_POST['build_name']) || empty($_POST['description']) || empty($_POST['created_by']) || empty($_FILES['photos']['name']) || count($_FILES['photos']['name']) < 4) {
        wp_die('All fields are required, and you must upload at least 4 photos.');
    }

    // Process uploaded photos
    $photo_ids = [];
    foreach ($_FILES['photos']['name'] as $index => $photo_name) {
        $file = [
            'name'     => $_FILES['photos']['name'][$index],
            'type'     => $_FILES['photos']['type'][$index],
            'tmp_name' => $_FILES['photos']['tmp_name'][$index],
            'error'    => $_FILES['photos']['error'][$index],
            'size'     => $_FILES['photos']['size'][$index],
        ];

        $upload = wp_handle_upload($file, ['test_form' => false]);
        if (isset($upload['file'])) {
            $attachment = [
                'post_mime_type' => $upload['type'],
                'post_title'     => sanitize_file_name($photo_name),
                'post_content'   => '',
                'post_status'    => 'inherit',
            ];
            $photo_ids[] = wp_insert_attachment($attachment, $upload['file']);
        }
    }

    // Create draft post
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($_POST['build_name']),
        'post_content' => sanitize_textarea_field($_POST['description']),
        'post_status'  => 'draft',
        'post_type'    => 'post', // Or a custom post type like 'gallery'
        'meta_input'   => [
            'created_by' => sanitize_text_field($_POST['created_by']),
            'photo_ids'  => $photo_ids,
        ],
        'page_template' => 'page-photo-gallery-submissions.php', // Assign your custom template
    ]);

    if ($post_id) {
        wp_redirect(home_url('/thank-you/')); // Redirect after submission
        exit;
    } else {
        wp_die('Error saving your submission.');
    }
}
add_action('admin_post_submit_gallery', 'handle_gallery_submission');
add_action('admin_post_nopriv_submit_gallery', 'handle_gallery_submission');