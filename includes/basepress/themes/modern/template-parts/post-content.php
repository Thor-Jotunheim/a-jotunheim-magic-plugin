<?php
/*
 * The template part for displaying content
 */

//Get Post meta icons

$bpkb_post_meta_icons = basepress_get_post_meta_icons();
$bpkb_post_views_icon = isset( $bpkb_post_meta_icons[0] ) ? $bpkb_post_meta_icons[0] : '';
$bpkb_post_post_like_icon = isset( $bpkb_post_meta_icons[1] ) ? $bpkb_post_meta_icons[1] : '';
$bpkb_post_post_dislike_icon = isset( $bpkb_post_meta_icons[2] ) ? $bpkb_post_meta_icons[2] : '';
$bpkb_post_post_date_icon = isset( $bpkb_post_meta_icons[3] ) ? $bpkb_post_meta_icons[3] : '';
?>

<article id="post-<?php the_ID(); ?>">
	<header class="bpress-post-header">
		<h1><?php the_title(); ?></h1>

		<?php


		if( basepress_byline() ){
		?>
		<div class="bpress-post-meta">
			<?php $bpkb_post_metas = basepress_get_post_meta( get_the_ID() ); ?>

			<span class="bpress-post-views"><span class="<?php echo esc_attr( $bpkb_post_views_icon ); ?>"></span><?php echo esc_html( $bpkb_post_metas['views'] ); ?></span>

			<?php if( basepress_show_post_votes() ){ ?>
			<span class="bpress-post-likes"><span class="<?php echo esc_attr( $bpkb_post_post_like_icon ); ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['like'] ); ?></span>
				<?php if( ! basepress_dislike_button_is_hidden() ){ ?>
				<span class="bpress-post-dislikes"><span class="<?php echo esc_attr( $bpkb_post_post_dislike_icon ); ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['dislike'] ); ?></span>
				<?php } ?>
			<?php } ?>
			<span class="bpress-post-date"><span class="<?php echo esc_attr( $bpkb_post_post_date_icon ); ?>"></span><?php echo esc_html( get_the_date() ); ?></span>
			<span class="bpress-post-date"><span class="<?php echo esc_attr( $bpkb_post_post_date_icon ); ?>"></span><?php echo esc_html( get_the_modified_date() ); ?></span>
		</div>
		<?php 
	} ?>
	</header>

	<?php
	//Add the table of content
	basepress_get_template_part( 'table-of-content' );
	?>

	<div class="bpress-article-content">
			<?php the_content(); ?>
	</div>

	<?php
	//Articles tag list
	if( basepress_article_has_tags() ) :
	?>
	<p><?php basepress_tag_list_title(); basepress_article_tags(); ?></p>

	<?php endif; ?>

	<!-- Pagination -->
	<nav class="bpress-pagination">
		<?php basepress_post_pagination(); ?>
	</nav>

</article>
