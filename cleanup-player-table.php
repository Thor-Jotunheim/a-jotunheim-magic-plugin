<?php
/**
 * One-time cleanup script to remove redundant player_name column data
 * Run this script once via WordPress admin or direct execution
 * This will set all player_name values to NULL since we're now using playerName/activePlayerName
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // If not in WordPress, try to load WordPress
    require_once('../../../wp-config.php');
}

function cleanup_player_table_redundancy() {
    global $wpdb;
    
    $table_name = 'jotun_playerlist';
    
    // First, let's see what we're working with
    $count_query = "SELECT COUNT(*) as total, 
                           COUNT(CASE WHEN player_name IS NOT NULL AND player_name != '' THEN 1 END) as with_player_name,
                           COUNT(CASE WHEN playerName IS NOT NULL AND playerName != '' THEN 1 END) as with_playerName
                    FROM $table_name";
    
    $stats = $wpdb->get_row($count_query);
    
    echo "<h3>Player Table Cleanup Analysis</h3>\n";
    echo "<p>Total players: " . $stats->total . "</p>\n";
    echo "<p>Players with 'player_name' data: " . $stats->with_player_name . "</p>\n";
    echo "<p>Players with 'playerName' data: " . $stats->with_playerName . "</p>\n";
    
    // Show sample data
    $sample_query = "SELECT id, player_name, playerName, activePlayerName FROM $table_name LIMIT 5";
    $samples = $wpdb->get_results($sample_query);
    
    echo "<h4>Sample Data (first 5 rows):</h4>\n";
    echo "<table border='1' style='border-collapse: collapse;'>\n";
    echo "<tr><th>ID</th><th>player_name (legacy)</th><th>playerName (current)</th><th>activePlayerName</th></tr>\n";
    foreach ($samples as $sample) {
        echo "<tr>";
        echo "<td>" . $sample->id . "</td>";
        echo "<td>" . ($sample->player_name ?: 'NULL') . "</td>";
        echo "<td>" . ($sample->playerName ?: 'NULL') . "</td>";
        echo "<td>" . ($sample->activePlayerName ?: 'NULL') . "</td>";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    // Option to clean up (commented out for safety)
    /*
    // Uncomment this section to actually perform the cleanup
    if (isset($_GET['confirm_cleanup']) && $_GET['confirm_cleanup'] === 'yes') {
        // Clear the redundant player_name column
        $cleanup_query = "UPDATE $table_name SET player_name = NULL WHERE player_name IS NOT NULL";
        $result = $wpdb->query($cleanup_query);
        
        if ($result !== false) {
            echo "<p style='color: green;'>✅ Successfully cleaned up $result rows - removed redundant player_name data</p>\n";
        } else {
            echo "<p style='color: red;'>❌ Cleanup failed: " . $wpdb->last_error . "</p>\n";
        }
    } else {
        echo "<p><strong>To perform cleanup:</strong> Add ?confirm_cleanup=yes to the URL</p>\n";
        echo "<p style='color: orange;'>⚠️ This will set all 'player_name' values to NULL (redundant data removal)</p>\n";
    }
    */
    
    echo "<h4>Manual Cleanup SQL (if you prefer to run directly in database):</h4>\n";
    echo "<code>UPDATE $table_name SET player_name = NULL WHERE player_name IS NOT NULL;</code>\n";
}

// Run the analysis
cleanup_player_table_redundancy();
?>