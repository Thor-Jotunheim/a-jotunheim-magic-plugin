<?php
// File: eventzones-goto-output.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

// Function to generate the event zone "goto" output
function generate_eventzone_goto_output() {
    ob_start(); // Start output buffering

    // Include CSS and JavaScript for styling and copying functionality
    echo '
    <style>
        .zone-output {
            font-family: monospace;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        .zone-output:hover {
            background: #f4f4f4;
        }
        .zone-name {
            font-weight: bold;
        }
        .goto-command {
            color: #555;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".goto-command").forEach(function (element) {
                element.addEventListener("click", function () {
                    navigator.clipboard.writeText(this.innerText).then(function () {
                        // Copy success - no popup
                    }).catch(function (error) {
                        console.error("Failed to copy text: ", error);
                    });
                });
            });
        });
    </script>
    ';

    // REST API endpoint for event zones
    $api_url = "https://JOTUNHEIM_BASE_URL/wp-json/jotunheim-magic/v1/eventzones";
    $response = @file_get_contents($api_url);

    if ($response === FALSE) {
        return "<div style='color: red;'>Error fetching data from the API. Please check if the API endpoint is accessible.</div>";
    }

    $zones = json_decode($response, true);
    if (!is_array($zones) || empty($zones)) {
        return "<div style='color: red;'>No zones found or invalid API response.</div>";
    }

    // Prepare zones, applying the same sorting logic as the original output
    $grouped_zones = [];
    foreach ($zones as $zone) {
        // Skip zones that are not enabled
        if (!isset($zone['eventzone_status']) || $zone['eventzone_status'] !== 'enabled') {
            continue;
        }

        $zone_type = $zone['zone_type'] ?? 'Unknown';
        $grouped_zones[$zone_type][] = $zone;
    }

    // Sort zones within each group by their names, ensuring 'spawn' is always first
    foreach ($grouped_zones as $zone_type => &$zones) {
        usort($zones, function ($a, $b) {
            $nameA = strtolower($a['name'] ?? '');
            $nameB = strtolower($b['name'] ?? '');

            // Ensure 'spawn' comes first
            if ($nameA === 'spawn') return -1;
            if ($nameB === 'spawn') return 1;

            // Otherwise, sort alphabetically
            return strcasecmp($nameA, $nameB);
        });
    }
    unset($zones); // Break reference after sorting

    // Output the "goto" commands in single column format
    foreach ($grouped_zones as $zone_type => $zones) {
        foreach ($zones as $zone) {
            $string_name = $zone['string_name'] ?? $zone['name'] ?? 'Unknown';
            $position = $zone['position'] ?? '0.0, 0.0, 0.0';

            // Format position to ensure it's in the desired floating-point format
            $coordinates = explode(",", $position);
            if (count($coordinates) === 3) {
                $x = (strpos($coordinates[0], '.') === false) ? "{$coordinates[0]}.0" : $coordinates[0];
                $y = (strpos($coordinates[1], '.') === false) ? "{$coordinates[1]}.0" : $coordinates[1];
                $z = (strpos($coordinates[2], '.') === false) ? "{$coordinates[2]}.0" : $coordinates[2];
                $position = "$x, $y, $z";
            }

            // Output string name and position in the desired format
            echo "<div class='zone-output'>
                    <div class='zone-name'>$string_name</div>
                    <div class='goto-command'>goto $position</div>
                  </div>";
        }
    }

    return ob_get_clean(); // Return the buffer contents
}

// Register shortcode for the event zone goto output
add_shortcode('eventzone_goto_output', 'generate_eventzone_goto_output');
?>