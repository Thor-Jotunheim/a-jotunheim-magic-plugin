<?php
/*
 *	This template lists all top sections with a boxed style
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

	<div class="bpress-col bpress-col-<?php basepress_section_cols(); ?>">
		<div class="bpress-section-boxed">
			<a href="<?php echo esc_url( $bpkb_section->permalink ); ?>">

				<!-- Section Title icon -->
				<?php if ( $bpkb_section->image['image_url'] ) { ?>
					<div class="bpress-section-image">
						<img src="<?php echo esc_url( $bpkb_section->image['image_url'] ); ?>" alt="<?php echo esc_attr( $bpkb_section->name ); ?>">
					</div>
				<?php } else { ?>
					<span aria-hidden="true" class="bpress-section-icon <?php echo esc_attr( $bpkb_section->icon ); ?>"></span>
				<?php } ?>

				<!-- Section Title -->
				<h2 class="bpress-section-title"><?php echo esc_html( $bpkb_section->name ); ?></h2>

				<!-- Section Description -->
				<?php if ( $bpkb_section->description ) { ?>
				<p><?php echo wp_kses_post( $bpkb_section->description ); ?></p>
				<?php } ?>

				<!-- Section View All -->
				<span class="bpress-viewall">
					<?php basepress_section_view_all( $bpkb_section->posts_count ); ?>
				</span>

			</a>

		</div><!-- End Section -->
	</div><!-- End col -->

<?php endforeach; ?>

</div><!-- End grid -->
