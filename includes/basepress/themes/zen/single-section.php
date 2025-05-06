<?php
/*
 *	This is BasePress archive page for a single section.
 */


//Get Knowledge Base object
$bpkb_knowledge_base = basepress_kb();
$bpkb_is_single_kb = basepress_is_single_kb();
$bpkb_sidebar_position = basepress_sidebar_position( true );
$bpkb_show_sidebar = is_active_sidebar( 'basepress-sidebar' ) && $bpkb_sidebar_position != 'none';

//Get active theme header
basepress_get_header( 'basepress' );
?>

<!-- Main BasePress wrap -->
<div class="bpress-wrap">

	<!-- Knowledge Base title -->
	<?php if( ! $bpkb_is_single_kb ) :?>
		<header class="bpress-main-header">
			<h2 class="bpress-product-title bpress-kb-title"><?php echo esc_html( $bpkb_knowledge_base->name ); ?></h2>
		</header>
	<?php endif; ?>

	<!-- Add breadcrumbs -->
	<div class="bpress-crumbs-wrap">
		<?php basepress_breadcrumbs(); ?>
	</div>

	<div class="bpress-content-area bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ); ?>">
		
		<!-- Add searchbar -->
		<div class="bpress-card">
			<?php basepress_searchbar(); ?>
		</div>
		
		<!-- Add main content -->
		<main role="main">
			<?php	basepress_get_template_part( 'single-section-content' ); ?>

			<!-- Pagination -->
			<nav class="bpress-pagination">
			<?php basepress_pagination(); ?>
			</nav>

			<!-- Sub Sections -->
			<?php
			if ( basepress_subsection_style() == 'boxed' ) {
				basepress_get_template_part( 'sections-content-boxed' );
			} else {
				ob_start();
					basepress_get_template_part( 'sections-content' );
				$sections_content = ob_get_clean();
				echo apply_filters( 'basepress_sections_content', $sections_content, $bpkb_knowledge_base ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscape
			}
			?>

		</main>
		

		
	</div><!-- content area -->
	
	<!-- Sidebar -->
	<?php if ( $bpkb_show_sidebar ) : ?>
	<aside class="bpress-sidebar bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ); ?>" role="complementary">
		<div class="hide-scrollbars">
		<?php dynamic_sidebar( 'basepress-sidebar' ); ?>
		</div>
	</aside>
	<?php endif; ?>
	
	
</div><!-- wrap -->
<?php basepress_get_footer( 'basepress' ); ?>
