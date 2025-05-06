<?php
/*
 * The template part for displaying content
 */

$bpkb_show_icon = basepress_show_post_icon();
$bpkb_header_class = $bpkb_show_icon ? ' class="show-icon"' : '';
?>

<article id="post-<?php the_ID(); ?>">
	<header class="bpress-post-header">
		<h1<?php echo $bpkb_header_class; //phpcs:ignore ?>>
			<?php if ( basepress_show_post_icon() ) { ?>
				<span aria-hidden="true" class="<?php echo esc_attr( basepress_post_icon( get_the_ID() ) ); ?>"></span>
			<?php } ?>
			<?php the_title(); ?>
		</h1>
	</header>

	<div class="bpress-card">
		<div class="bpress-article-content">
				<?php
				//Add the table of content
				basepress_get_template_part( 'table-of-content' );
				?>

				<div class="bpress-card-body">
					<?php the_content(); ?>


				<?php
				//Articles tag list
				if( basepress_article_has_tags() ) : ?>
					<p><?php basepress_tag_list_title(); basepress_article_tags(); ?></p>
				<?php endif; ?>
				</div>
		</div>

		<!-- Pagination -->
		<nav class="bpress-pagination">
			<?php basepress_post_pagination(); ?>
		</nav>

		<!-- Get Polls Items -->
		<?php basepress_votes(); ?>

		<!-- Add previous and next articles navigation -->
		<?php basepress_get_template_part( 'adjacent-articles' ); ?>
	</div>
</article>
