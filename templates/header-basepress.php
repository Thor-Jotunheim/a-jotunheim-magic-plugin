<?php
/**
 * Custom header template for BasePress integration
 *
 * This template is used by the BasePress integration to override the default header.
 */

// Get the normal theme header
get_header();

// Add a custom wrapper for the knowledge base content
?>
<div class="jotunheim-kb-container">
    <?php do_action('jotunheim_kb_before_content'); ?>
</div>
<?php
// No closing HTML tag because the content and footer will follow