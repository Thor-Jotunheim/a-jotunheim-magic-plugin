<?php
function handle_gallery_submission() {
    // Verify Nonce
    if (!isset($_POST['gallery_submission_nonce']) || !wp_verify_nonce($_POST['gallery_submission_nonce'], 'gallery_submission')) {
        wp_die('Nonce verification failed.');
    }

    // Validate Input
    if (empty($_POST['build_name']) || empty($_POST['description']) || empty($_FILES['photos']['name'])) {
        wp_die('All fields are required, and you must upload at least 4 photos.');
    }

    if (count(array_filter($_FILES['photos']['name'])) < 4) {
        wp_die('You must upload at least 4 photos.');
    }

    // Process Uploaded Photos
    $photo_ids = [];
    foreach ($_FILES['photos']['name'] as $index => $photo_name) {
        if ($_FILES['photos']['error'][$index] === UPLOAD_ERR_OK) {
            $file = [
                'name'     => $_FILES['photos']['name'][$index],
                'type'     => $_FILES['photos']['type'][$index],
                'tmp_name' => $_FILES['photos']['tmp_name'][$index],
                'error'    => $_FILES['photos']['error'][$index],
                'size'     => $_FILES['photos']['size'][$index],
            ];

            $upload = wp_handle_upload($file, ['test_form' => false]);
            if (isset($upload['file'])) {
                // Insert Attachment
                $attachment = [
                    'post_mime_type' => $upload['type'],
                    'post_title'     => sanitize_file_name($photo_name),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                ];
                $attachment_id = wp_insert_attachment($attachment, $upload['file']);

                // Generate Attachment Metadata
                require_once ABSPATH . 'wp-admin/includes/image.php';
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                wp_update_attachment_metadata($attachment_id, $attachment_data);

                $photo_ids[] = $attachment_id;
            }
        }
    }

    // Create Gallery Post
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($_POST['build_name']),
        'post_content' => sanitize_textarea_field($_POST['description']),
        'post_status'  => 'draft',
        'post_type'    => 'gallery',
        'post_author'  => get_current_user_id(),
        'meta_input'   => [
            '_wp_attached_file' => $photo_ids,
        ],
    ]);

    if ($post_id) {
        // Add custom field for 'Created By'
        update_post_meta($post_id, 'created_by', sanitize_text_field($_POST['created_by']));

        // Force the correct template
        update_post_meta($post_id, '_wp_page_template', 'page-photo-gallery-submissions.php');

        // Redirect to a Thank-You Page
        wp_redirect(home_url('/thank-you/'));
        exit;
    } else {
        // Handle the error, e.g., display an error message or log the error
        wp_die('Error saving your submission. Please try again later.');
    }
}

function my_plugin_locate_template( $template ) {
    $template = locate_template(
        array(
            'page-photo-gallery-submissions.php',
        ),
        false,
        plugin_dir_path( __FILE__ ) . 'includes/Gallery/'
    );

    return $template;
}

add_action('admin_post_submit_gallery', 'handle_gallery_submission');
add_action('admin_post_nopriv_submit_gallery', 'handle_gallery_submission');
add_filter( 'template_include', 'my_plugin_locate_template', 10, 1 );