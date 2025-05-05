<?php
/**
 * Custom BasePress header template for Full Site Editor themes (FSE)
 */

// Get the site's content wrapper opening tags by using output buffering with get_header()
ob_start();
get_header();
$header_content = ob_get_clean();

// Output the header content
echo $header_content;

// Add KB content wrapper
echo '<div class="kb-content-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 20px;">';

// Add script to ensure proper styling
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide any BasePress headers
    const bpHeaders = document.querySelectorAll('.bpress-header');
    bpHeaders.forEach(header => header.style.display = 'none');
    
    // Make sure the site header is visible
    const siteHeader = document.querySelector('.wp-site-blocks header');
    if (siteHeader) {
        siteHeader.style.display = 'block';
        siteHeader.style.visibility = 'visible';
    }
});
</script>
<style>
/* Fix for block theme headers */
.wp-site-blocks header {
    display: block !important;
    visibility: visible !important;
}
/* Hide BasePress header */
.bpress-header {
    display: none !important;
}
</style>
<?php
?>