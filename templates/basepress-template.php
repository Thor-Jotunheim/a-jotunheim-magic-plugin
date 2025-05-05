<?php
/**
 * Custom BasePress Template to force site editor header
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Use WordPress core header - this will use block template header if available
get_header();
?>

<main id="primary" class="site-main basepress-main">
    <?php 
    // Output BasePress content - we're just forcing the header and footer to be different
    if (function_exists('basepress_get_template_part')) {
        basepress_get_template_part('content', 'knowledgebase'); 
    } else {
        // Fallback if BasePress templates are not available
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</main>

<?php
// Use WordPress core footer - this will use block template footer if available
get_footer();
?>