<?php
/**
 * Custom BasePress header template with direct inclusion of site header
 */

// Load the theme's standard header
get_header();

// Add a wrapper div for KB content
echo '<div id="jotunheim-kb-content" class="jotunheim-kb-content-wrapper site-main" style="max-width: 1200px; margin: 0 auto; padding: 20px;">';

// Remove any duplicate BasePress content
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide any BasePress headers
    var bpressHeaders = document.querySelectorAll('.bpress-header');
    if (bpressHeaders) {
        for (var i = 0; i < bpressHeaders.length; i++) {
            bpressHeaders[i].style.display = 'none';
        }
    }
});
</script>
<?php
?>