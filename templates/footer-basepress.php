<?php
/**
 * Custom BasePress footer template that uses Zeever theme footer
 * Based on official BasePress documentation
 */

// Close the content wrapper
echo '</div><!-- .jotunheim-kb-content-wrapper -->';

// Load the Zeever block footer
echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"zeever"} /-->');
?>