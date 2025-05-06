<?php
/*
 *	This template displays articles from a specific tag
 *
 */

//Get the tag object
$bpkb_tag = basepress_tag();
?>

<!-- Section Title -->
<header class="bpress-post-header">
	<h1><?php basepress_tag_title(); ?></h1>
</header>

<!-- Post list -->
<div class="bpress-card">
	<ul class="bpress-card-body">

		<?php
		foreach ( $bpkb_tag->posts as $bpkb_article ) :
			$bpkb_show_post_icon = basepress_show_post_icon();
			$bpkb_post_class = $bpkb_show_post_icon ? ' show-icon' : '';
			?>
			<li class="bpress-post-link single-section<?php echo esc_attr( $bpkb_post_class ); ?>">

				<!-- Post icon -->
				<?php if ( basepress_show_post_icon() ) { ?>
					<span aria-hidden="true" class="bp-icon <?php echo esc_attr( $bpkb_article->icon ); ?>"></span>
				<?php } ?>

				<!-- Post permalink -->
				<a href="<?php echo esc_url( get_the_permalink( $bpkb_article->ID ) ); ?>">
					<?php echo esc_html( $bpkb_article->post_title ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>