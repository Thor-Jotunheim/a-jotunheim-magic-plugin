<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Test Dashboard Page
 * This is a test page to verify that the dashboard scanning system works correctly
 */

function render_test_dashboard_page() {
    ?>
    <div class="wrap">
        <h1>
            <span class="dashicons dashicons-admin-tools"></span>
            Test Dashboard Page
        </h1>
        
        <div class="notice notice-success">
            <p><strong>Success!</strong> This test page was successfully detected by the dashboard scanning system.</p>
        </div>
        
        <div class="card">
            <h2>Test Page Information</h2>
            <p>This page demonstrates that the auto-detection system is working correctly. Here are some details:</p>
            
            <ul>
                <li><strong>Function Name:</strong> <code>render_test_dashboard_page</code></li>
                <li><strong>Expected Page ID:</strong> <code>test_dashboard</code></li>
                <li><strong>Detection Pattern:</strong> <code>render_*_page</code></li>
                <li><strong>Created:</strong> <?php echo date('Y-m-d H:i:s'); ?></li>
            </ul>
        </div>
        
        <div class="card">
            <h2>Test Actions</h2>
            <p>You can use this page to test various dashboard features:</p>
            
            <div class="test-actions">
                <button type="button" class="button button-primary" onclick="alert('Test button clicked!')">
                    Test Button
                </button>
                <button type="button" class="button" onclick="console.log('Test console output')">
                    Log to Console
                </button>
                <button type="button" class="button" onclick="location.reload()">
                    Reload Page
                </button>
            </div>
        </div>
        
        <div class="card">
            <h2>System Information</h2>
            <table class="form-table">
                <tr>
                    <th>WordPress Version</th>
                    <td><?php echo get_bloginfo('version'); ?></td>
                </tr>
                <tr>
                    <th>PHP Version</th>
                    <td><?php echo PHP_VERSION; ?></td>
                </tr>
                <tr>
                    <th>Current User</th>
                    <td><?php echo wp_get_current_user()->display_name; ?></td>
                </tr>
                <tr>
                    <th>Current Time</th>
                    <td><?php echo current_time('mysql'); ?></td>
                </tr>
            </table>
        </div>
        
        <style>
        .test-actions {
            margin: 15px 0;
        }
        .test-actions .button {
            margin-right: 10px;
            margin-bottom: 5px;
        }
        .card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
        }
        .card h2 {
            margin-top: 0;
            color: #23282d;
        }
        </style>
    </div>
    <?php
}
?>