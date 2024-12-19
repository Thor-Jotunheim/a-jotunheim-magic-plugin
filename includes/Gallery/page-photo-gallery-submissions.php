<?php
/*
Template Name: Photo Gallery Submissions
*/

get_header(); ?>

<div class="gallery-container">
    <?php the_content(); ?>
</div>

<p>Created By: <?php echo esc_html(get_post_meta(get_the_ID(), 'created_by', true)); ?></p>

<?php get_footer(); ?>