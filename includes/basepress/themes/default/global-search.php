<?php
/*
 *	This is the archive page for global search results.
 */

//Get Knowledge Base object

$bpkb_knowledge_base = basepress_kb();

//Get the class for displaying the sidebar
$bpkb_sidebar_position = basepress_sidebar_position( true );
$bpkb_show_sidebar = is_active_sidebar( 'basepress-sidebar' ) && $bpkb_sidebar_position != 'none';
$bpkb_content_classes = $bpkb_show_sidebar ? ' show-sidebar' : '';

//Get Post meta icons
$bpkb_post_meta_icons = basepress_get_post_meta_icons();
$bpkb_post_views_icon = isset( $bpkb_post_meta_icons[0] ) ? $bpkb_post_meta_icons[0] : '';
$bpkb_post_post_like_icon = isset( $bpkb_post_meta_icons[1] ) ? $bpkb_post_meta_icons[1] : '';
$bpkb_post_post_dislike_icon = isset( $bpkb_post_meta_icons[2] ) ? $bpkb_post_meta_icons[2] : '';
$bpkb_post_post_date_icon = isset( $bpkb_post_meta_icons[3] ) ? $bpkb_post_meta_icons[3] : '';

//Get active theme header
basepress_get_header( 'basepress' );
?>

	<div class="bpress-wrap">
		<!-- Add breadcrumbs -->
		<div class="bpress-crumbs-wrap">
			<?php basepress_breadcrumbs(); ?>
		</div>

		<div class="bpress-content-area bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ) . esc_attr( $bpkb_content_classes ); ?>">

			<!-- Add searchbar -->
			<div class="bpress-searchbar-wrap">
				
				<?php 
				basepress_searchbar(); ?>
			</div>

			<main class="bpress-main" role="main">

				<?php if ( have_posts() ) { ?>

					<h1><?php echo esc_html( basepress_search_page_title() ) . ' ' . esc_html( basepress_search_term() ); ?></h1>
					<ul class="bpress-post-list">

						<?php
						while ( have_posts() ) {
							the_post();
							$bpkb_show_post_icon = basepress_show_post_icon();
							$bpkb_post_class = $bpkb_show_post_icon ? ' show-icon' : '';
							?>

							<li class="bpress-post-link search<?php echo esc_attr( $bpkb_post_class ) ; ?>">

								<!-- Post permalink -->
								<a href="<?php the_permalink(); ?>">
									<h3>
										<!-- Post icon -->
										<?php if ( basepress_show_post_icon() ) { ?>
											<span aria-hidden="true" class="<?php echo esc_attr( basepress_post_icon( get_the_ID() ) ) ; ?>"></span>
										<?php } ?>

										<?php the_title(); ?>
									</h3>
									<p class="bpress-search-excerpt"><?php basepress_search_post_snippet(); ?></p>
								</a>

								<?php 

								

								if( 'knowledgebase' == get_post_type() && basepress_byline()) { ?>
									<!-- Post Meta -->
									<div class="bpress-post-meta">
										<?php $bpkb_post_metas = basepress_get_post_meta( get_the_ID() ); ?>

										<span class="bpress-post-views"><span class="<?php echo esc_attr( $bpkb_post_views_icon ) ; ?>"></span><?php echo esc_html( $bpkb_post_metas['views'] ) ; ?></span>
										<?php if ( basepress_show_post_votes() ) { ?>
											<span class="bpress-post-likes"><span class="<?php echo esc_attr( $bpkb_post_post_like_icon ) ; ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['like'] ) ; ?></span>
											<span class="bpress-post-dislikes"><span class="<?php echo esc_attr( $bpkb_post_post_dislike_icon ) ; ?>"></span><?php echo esc_html( $bpkb_post_metas['votes']['dislike'] ) ; ?></span>
										<?php } ?>
										<span class="bpress-post-date"><span class="<?php echo esc_attr( $bpkb_post_post_date_icon ); ?>"></span><?php echo esc_html( get_the_date() ); ?></span>
										<span class="bpress-post-date"><span class="<?php echo esc_attr( $bpkb_post_post_date_icon ); ?>"></span><?php echo esc_html( get_the_modified_date() ); ?></span>
									</div>
								<?php } ?>
							</li>

						<?php	} //End while ?>

					</ul>
				<?php } else {
					echo '<h3>' . esc_html( basepress_search_page_no_results_title() )  . '</h3>';
				}
				?>

			</main>

			<!-- Pagination -->
			<nav class="bpress-pagination">
				<?php basepress_pagination(); ?>
			</nav>

		</div><!-- content area -->

		<!-- BasePress Sidebar -->
		<?php if ( $bpkb_show_sidebar ) : ?>
			<aside class="bpress-sidebar bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ); ?>" role="complementary">
				<div class="hide-scrollbars">
				<?php dynamic_sidebar( 'basepress-sidebar' ); ?>
				</div>
			</aside>
		<?php endif; ?>


	</div><!-- wrap -->
<?php basepress_get_footer( 'basepress' ); ?>
