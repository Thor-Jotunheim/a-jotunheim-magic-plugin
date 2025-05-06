<?php
/*
 *	This template displays articles from a specific tag
 *
 */

//Get the tag object
$bpkb_tag = basepress_tag();
?>

<div class="bpress-single-section">

	<!-- Tag Title -->
	<div class="bpress-heading">
		<h1><?php basepress_tag_title(); ?></h1>
	</div>

	<!-- Post list -->
	<ul class="bpress-section-list">
		<?php
		foreach ( $bpkb_tag->posts as $bpkb_article ) :
			$bpkb_show_post_icon = basepress_show_post_icon();
			$bpkb_post_class = $bpkb_show_post_icon ? ' show-icon' : '';
		?>
		<li class="bpress-post-link single-section">

			<div class="bpress-heading<?php echo esc_attr( $bpkb_post_class ); ?>">
				<!-- Post icon -->
				<?php if ( $bpkb_show_post_icon ) { ?>
					<span aria-hidden="true" class="bpress-heading-icon <?php echo esc_attr( $bpkb_article->icon ); ?>"></span>
				<?php } ?>

				<h3>
					<!-- Post permalink -->
					<a href="<?php echo esc_url( get_the_permalink( $bpkb_article->ID ) ); ?>"><?php echo esc_html( $bpkb_article->post_title ); ?></a>
				</h3>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>

	<!-- Pagination -->
	<nav class="bpress-pagination">
		<?php basepress_pagination(); ?>
	</nav>

</div><!-- End section -->