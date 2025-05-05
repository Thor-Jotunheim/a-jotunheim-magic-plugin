<?php
/**
 * Custom BasePress header template that uses Zeever theme header
 * Based on official BasePress documentation
 */

// Load the Zeever block header
echo do_blocks('<!-- wp:template-part {"slug":"header","theme":"zeever"} /-->');

// Add wrapper for KB content
echo '<div id="jotunheim-kb-content" class="jotunheim-kb-content-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 20px; margin-top: 40px;">';
?>