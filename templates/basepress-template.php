<?php
/**
 * Template Name: BasePress Full Template
 * 
 * A complete template for BasePress pages that uses the Zeever theme header and footer.
 */

// Output doctype and head
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
    /* Fix for FSE theme headers and footers */
    .wp-site-blocks header,
    header.wp-block-template-part,
    .wp-site-blocks footer,
    footer.wp-block-template-part {
        display: block !important;
        visibility: visible !important;
    }
    /* Hide BasePress header */
    .bpress-header {
        display: none !important;
    }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Try to output the site header using FSE template parts
$header_template = get_block_template('zeever//header', 'wp_template_part');
if ($header_template && !empty($header_template->content)) {
    echo do_blocks($header_template->content);
} else {
    // Fallback to regular header
    get_header();
}
?>

<div class="kb-site-content">
    <div class="kb-content-area" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <?php
        // Main content area where BasePress content will be displayed
        ?>
        <main id="primary" class="site-main">
            <?php
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                    <?php
                endwhile;
            endif;
            ?>
        </main>
    </div>
</div>

<?php
// Try to output the site footer using FSE template parts
$footer_template = get_block_template('zeever//footer', 'wp_template_part');
if ($footer_template && !empty($footer_template->content)) {
    echo do_blocks($footer_template->content);
} else {
    // Fallback to regular footer
    get_footer();
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide any BasePress headers that might appear
    const bpHeaders = document.querySelectorAll('.bpress-header');
    bpHeaders.forEach(header => header.style.display = 'none');
});
</script>

<?php wp_footer(); ?>
</body>
</html>