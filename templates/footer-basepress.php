<?php
/**
 * Custom footer template for BasePress integration
 *
 * This template is used by the BasePress integration to override the default footer.
 */

// Add a hook before the footer
do_action('jotunheim_kb_before_footer');

// Close the knowledge base container that was opened in the header
?>
</div><!-- .jotunheim-kb-container -->
<?php

// Get the normal theme footer
get_footer();