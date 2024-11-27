<?php
// File: eventzones-code-output.php

// Prevent direct access to this file
if (!defined('ABSPATH')) exit;

// Function to generate the event zone code output with organized headers
function generate_eventzones_code_output() {
    ob_start(); // Start output buffering

    // Include Highlight.js and button styling only once
    echo '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <style>
        /* Additional custom CSS for finer control */
        .hljs-keyword, .hljs-built_in { color: #569cd6; font-weight: bold; }
        .hljs-string { color: #ce9178; }
        .hljs-number { color: #b5cea8; }
        .hljs-title { color: #dcdcaa; }
    </style>

    <button id="copy-button">Copy to Clipboard</button>
    ';

    // JavaScript to copy code to clipboard
    echo '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const codeBlock = document.querySelector("pre code");
            if (codeBlock) {
                codeBlock.innerHTML = codeBlock.innerHTML
                    .replace(/\\bZone\\b/g, "<span class=\'hljs-keyword\'>Zone</span>")
                    .replace(/\\bnew Zone\\b/g, "<span class=\'hljs-keyword\'>new Zone</span>")
                    .replace(/\\bnew Vector3\\b/g, "<span class=\'hljs-keyword\'>new Vector3</span>");
            }
            document.getElementById("copy-button").addEventListener("click", function () {
                var code = document.querySelector("pre code").innerText;
                navigator.clipboard.writeText(code).then(function () {
                    alert("Code copied to clipboard!");
                }).catch(function (error) {
                    alert("Failed to copy code: " + error);
                });
            });
        });
    </script>
    ';

    // REST API endpoint for event zones
    $api_url = "https://jotun.games/wp-json/jotunheim-magic/v1/eventzones";
    $response = @file_get_contents($api_url);

    if ($response === FALSE) {
        return "<div style='color: red;'>Error fetching data from the API. Please check if the API endpoint is accessible.</div>";
    }

    $zones = json_decode($response, true);
    if (!is_array($zones) || empty($zones)) {
        return "<div style='color: red;'>No zones found or invalid API response.</div>";
    }

    // Group zones by zone_type and prepare list for enabled zones
    $grouped_zones = [];
    $enabled_zone_names = []; // To store names of enabled zones

    foreach ($zones as $zone) {
        $zone_type = $zone['zone_type'] ?? 'Unknown'; // Default to 'Unknown' if not set
        $grouped_zones[$zone_type][] = $zone;

        // If the zone is enabled, add it to the list of enabled zones
        if (isset($zone['eventzone_status']) && $zone['eventzone_status'] === 'enabled') {
            $enabled_zone_names[] = $zone['name'];
        }
    }

    // Define header width
    $header_width = 60; // Fixed width for headers
    echo "<pre><code class='language-csharp'>\n";

    // Output zones organized by zone_type
    foreach ($grouped_zones as $zone_type => $zones) {
        // Center-align zone_type within header
        $zone_type_length = strlen($zone_type);
        $padding_slashes = str_repeat("/", ($header_width - $zone_type_length - 6) / 2); // 6 for spaces around the zone_type
        $header = "$padding_slashes  $zone_type  $padding_slashes";
        
        // Ensure header fills entire width by adjusting for odd padding results
        $header = str_pad($header, $header_width, "/");

        // Header for each zone type
        echo "$header\n\n";

        foreach ($zones as $zone) {
            // Define zone variables
            $name = $zone['name'] ?? 'Unknown';
            $priority = $zone['priority'] ?? 0;
            $radius = isset($zone['radius']) ? (strpos($zone['radius'], '.') === false ? "{$zone['radius']}.0f" : "{$zone['radius']}f") : "0.0f";

            // Define location based on "position" field or "spawn"
            if (strtolower($name) === 'spawn') {
                $location = "JotunheimClient.SpawnLocation";
            } else {
                if (!empty($zone['position'])) {
                    $coordinates = explode(",", $zone['position']);
                    if (count($coordinates) === 3) {
                        $x = (strpos($coordinates[0], '.') === false) ? "{$coordinates[0]}.0f" : "{$coordinates[0]}f";
                        $y = (strpos($coordinates[1], '.') === false) ? "{$coordinates[1]}.0f" : "{$coordinates[1]}f";
                        $z = (strpos($coordinates[2], '.') === false) ? "{$coordinates[2]}.0f" : "{$coordinates[2]}f";
                        $location = "new Vector3($x, $y, $z)";
                    } else {
                        $location = "new Vector3(0.0f, 0.0f, 0.0f)";
                    }
                } else {
                    $location = "new Vector3(0.0f, 0.0f, 0.0f)";
                }
            }

            $shape = isset($zone['shape']) && $zone['shape'] === 'Circle' ? 'ZoneShape.Circle' : 'ZoneShape.Square';

            // Start of Zone definition
            $string_name = $zone['string_name'] ?? $name; // Use string_name if available, fallback to name
            echo "Zone $name = new Zone(\"$string_name\", $priority, $radius, $location, $shape)\n{\n";

            // Optional attributes (display these first)
            if (!empty($zone['enterText'])) echo "    enterText = \"{$zone['enterText']}\",\n";
            if (!empty($zone['leaveText'])) echo "    leaveText = \"{$zone['leaveText']}\",\n";
            
            // Handle other fields except respawnAtLocation and respawnLocation
            foreach ($zone as $field => $value) {
                if (in_array($field, ['id', 'name', 'priority', 'radius', 'position', 'shape', 'zone_type', 'enterText', 'leaveText', 'respawnLocation', 'respawnAtLocation', 'onlyLeaveViaTeleport'])) {
                    continue; // Skip already processed or irrelevant fields
                }
                if ($value === "1") {
                    echo "    $field = true,\n";
                } elseif ($value === "0") {
                    continue; // Skip false values
                } elseif (is_numeric($value) && $value != 0) {
                    echo "    $field = " . (strpos($value, '.') === false ? "{$value}.0f" : "{$value}f") . ",\n";
                }
            }

            // Display `respawnAtLocation` or `onlyLeaveViaTeleport` if either is true, followed by `respawnLocation` if formatted correctly
            $respawnAtLocation = isset($zone['respawnAtLocation']) && $zone['respawnAtLocation'] === "1";
            $onlyLeaveViaTeleport = isset($zone['onlyLeaveViaTeleport']) && $zone['onlyLeaveViaTeleport'] === "1";

            if ($respawnAtLocation) {
                echo "    respawnAtLocation = true,\n";
            }

            if ($onlyLeaveViaTeleport) {
                echo "    onlyLeaveViaTeleport = true,\n";
            }

            if (($respawnAtLocation || $onlyLeaveViaTeleport) && !empty($zone['respawnLocation'])) {
                $coordinates = explode(",", $zone['respawnLocation']);
                if (count($coordinates) === 3 && $zone['respawnLocation'] !== '0,0,0') {
                    $x = (strpos($coordinates[0], '.') === false) ? "{$coordinates[0]}.0f" : "{$coordinates[0]}f";
                    $y = (strpos($coordinates[1], '.') === false) ? "{$coordinates[1]}.0f" : "{$coordinates[1]}f";
                    $z = (strpos($coordinates[2], '.') === false) ? "{$coordinates[2]}.0f" : "{$coordinates[2]}f";
                    echo "    respawnLocation = new Vector3($x, $y, $z),\n";
                }
            }

            
            echo "};\n\n"; // End of Zone definition
        }
    }

    // Output enabled zones at the bottom
    echo "\n// Add zones to the Zones collection\n";
    foreach ($enabled_zone_names as $zone_name) {
        echo "Zones.Add($zone_name);\n";
    }

    echo "</code></pre>\n"; // Close tags for highlight.js
    return ob_get_clean(); // Return the buffer contents
}

// Register shortcode for the event zone code output
add_shortcode('eventzones_code_output', 'generate_eventzones_code_output');
?>