<?php
/**
 * Template for displaying single wiki pages
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
    
    <?php
    while ( have_posts() ) :
        the_post();
        
        // Load the wiki page content template
        include(plugin_dir_path(dirname(__FILE__)) . 'templates/wiki-single.php');
        
    endwhile; // End of the loop.
    ?>
    
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
