<?php
// Load WordPress to access the existing database connection
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-config.php');
global $wpdb;

/**
 * Runs the image import process and saves images as physical files in uploads/Jotunheim-magic/icons.
 */
function run_prefab_image_import($batch_size = 100) {
    global $wpdb;
    ob_start();

    echo "Starting image import process...<br>";

    // Define the table name without any prefix
    $table_name = 'prefablist';
    $offset = 0;

    // Define upload directory for Jotunheim-magic icons
    $upload_dir = wp_upload_dir();
    $icons_dir = $upload_dir['basedir'] . '/Jotunheim-magic/icons';

    // Create the Jotunheim-magic/icons directory if it doesn't exist
    if (!file_exists($icons_dir)) {
        mkdir($icons_dir, 0755, true);
    }

    do {
        // Fetch a batch of rows
        $prefabs = $wpdb->get_results($wpdb->prepare(
            "SELECT id, icon_prefab, image_url FROM $table_name 
             WHERE image_url IS NOT NULL 
             AND image_url != '' 
             AND (icon_image IS NULL OR icon_image = '') 
             LIMIT %d OFFSET %d",
            $batch_size, $offset
        ));

        if (empty($prefabs)) {
            echo "No more entries found with image URLs that need importing.<br>";
            break;
        }

        foreach ($prefabs as $prefab) {
            $image_url = $prefab->image_url;
            $prefab_id = $prefab->id;
            $prefab_name = $prefab->icon_prefab;

            // Validate URL before attempting to fetch
            if (!filter_var($image_url, FILTER_VALIDATE_URL)) {
                echo "<b>Invalid URL for prefab ID $prefab_id: $image_url</b><br>";
                error_log("Invalid URL for prefab ID $prefab_id: $image_url");
                ob_flush();
                flush();
                continue;
            }

            echo "Processing prefab ID $prefab_id with image URL: $image_url<br>";
            ob_flush();
            flush();

            // Fetch the image data from the URL
            $response = wp_remote_get($image_url, [
                'timeout' => 15,
                'redirection' => 5,
                'sslverify' => false,
            ]);

            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "<b>Failed to fetch image for prefab ID $prefab_id from URL: $image_url</b><br>";
                echo "Error: $error_message<br>";
                error_log("Failed to fetch image for prefab ID $prefab_id from URL: $image_url - Error: $error_message");
                ob_flush();
                flush();
                continue;
            }

            $image_data = wp_remote_retrieve_body($response);
            if (empty($image_data)) {
                echo "<b>No image data retrieved for prefab ID $prefab_id</b><br>";
                error_log("No image data retrieved for prefab ID $prefab_id from URL: $image_url");
                ob_flush();
                flush();
                continue;
            }

            // Sanitize the prefab name for use in the filename
            $sanitized_name = preg_replace('/[^a-zA-Z0-9_-]/', '', $prefab_name);
            if (empty($sanitized_name)) {
                $sanitized_name = 'prefab'; // Default if name is empty or fully sanitized away
            }

            // Generate a unique file name and save image as a file
            $file_extension = pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $file_name = $sanitized_name . '-' . $prefab_id . '-' . md5($image_url) . '.' . $file_extension;
            $file_path = $icons_dir . '/' . $file_name;

            // Save image data to the file
            file_put_contents($file_path, $image_data);

            // Store the relative file path (URL) in the database, not the binary data
            $relative_file_path = $upload_dir['baseurl'] . '/Jotunheim-magic/icons/' . $file_name;
            $result = $wpdb->update(
                $table_name,
                ['icon_image' => $relative_file_path], // Save the file path as a string
                ['id' => $prefab_id],
                ['%s'],
                ['%d']
            );

            if ($result === false) {
                echo "<b>Database update failed for prefab ID $prefab_id</b><br>";
                echo "SQL Error: " . $wpdb->last_error . "<br>";
                error_log("Database update failed for prefab ID $prefab_id - SQL Error: " . $wpdb->last_error);
            } else {
                echo "Image for prefab ID $prefab_id successfully saved as $file_name and path updated in database.<br>";
            }
            ob_flush();
            flush();
        }

        $offset += $batch_size;
    } while (!empty($prefabs));

    echo "Image import process completed.<br>";
    ob_flush();
    flush();
    ob_end_flush();
}

//Shortcode to trigger the image import process.
function prefabdb_image_import_shortcode() {
    run_prefab_image_import();
}

// Register the shortcode [prefabdb_image_import] to run the import manually
add_shortcode('prefabdb_image_import', 'prefabdb_image_import_shortcode');
?>