<?php
/*
*	This template lists all top sections with a list style
 *
 */

//Get the sections object
$bpkb_sections = basepress_sections();

?>
<div class="bpress-grid">

	<?php
	//We can iterate through the sections
	foreach ( $bpkb_sections as $bpkb_section ) :
		?>

		<div class="bpress-section bpress-col bpress-col-<?php basepress_section_cols(); ?>">

			<!-- Section Title -->
			<?php
			$bpkb_show_icon = basepress_show_section_icon();
			$bpkb_section_class = $bpkb_show_icon ? ' show-icon' : '';
			?>
			<h2 class="bpress-section-title<?php echo esc_attr( $bpkb_section_class ); ?>">
				<?php if ( $bpkb_show_icon ) { ?>
					<span aria-hidden="true" class="bpress-section-icon <?php echo esc_attr( $bpkb_section->icon ); ?>"></span>
				<?php } ?>

				<a href="<?php echo esc_url( $bpkb_section->permalink ); ?>">
					<?php echo esc_html( $bpkb_section->name ); ?>
					<!-- Posts count -->
					<?php if ( basepress_show_section_post_count() ) { ?>
						<span class="bpress-post-count">(<?php echo esc_html( $bpkb_section->posts_count ); ?>)</span>
					<?php } ?>
				</a>
			</h2>


			<!-- Post list -->
			<ul class="bpress-section-list">
				<?php
				foreach ( $bpkb_section->posts as $bpkb_article ) :

					$bpkb_show_post_icon = basepress_show_post_icon();
					$bpkb_post_class = $bpkb_show_post_icon ? ' show-icon' : '';
					?>

					<li class="bpress-post-link<?php echo esc_attr( $bpkb_post_class ); ?>">

						<!-- Post permalink -->
						<a href="<?php echo esc_url( get_the_permalink( $bpkb_article->ID ) ); ?>">

							<!-- Post icon -->
							<?php if ( $bpkb_show_post_icon ) { ?>
								<span aria-hidden="true" class="<?php echo esc_attr( $bpkb_article->icon ); ?>"></span>
							<?php } ?>

							<!-- Post title -->
							<?php echo esc_html( $bpkb_article->post_title ); ?>
						</a>
					</li>

				<?php endforeach; ?>

				<?php
				//Sub-sections list
				foreach( $bpkb_section->subsections as $bpkb_subsection ) :
					?>
					<li class="bpress-post-link show-icon">
						<!-- Sub-section permalink -->
						<a href="<?php echo esc_url( $bpkb_subsection->permalink ); ?>">

							<!-- Sub-section icon -->
							<span aria-hidden="true" class="<?php echo esc_attr( $bpkb_subsection->default_icon ); ?>"></span>

							<!-- Sub-section title -->
							<?php echo esc_html( $bpkb_subsection->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>

			<!-- Section View All -->
				<br>
				<a href="<?php echo esc_url( $bpkb_section->permalink ); ?>" class="bpress-viewall">
					<?php basepress_section_view_all( $bpkb_section->posts_count ); ?>
				</a>

		</div><!-- End section -->

	<?php endforeach; ?>

</div><!-- End grid -->
