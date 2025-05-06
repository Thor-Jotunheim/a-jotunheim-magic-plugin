<?php
/*
 * This id the template for the restricted content page
 */

//Get Knowledge Base object
$bpkb_knowledge_base = basepress_kb();
$bpkb_is_single_kb = basepress_is_single_kb();
$bpkb_sidebar_position = basepress_sidebar_position( true );
$bpkb_show_sidebar = is_active_sidebar( 'basepress-sidebar' ) && $bpkb_sidebar_position != 'none';
$bpkb_content_classes = $bpkb_show_sidebar ? ' show-sidebar' : '';

//Get active theme header
basepress_get_header( 'basepress' );

?>

<!-- Main BasePress wrap -->
<div class="bpress-wrap">
	
	<div class="bpress-page-header">
		<div class="bpress-content-wrap">
			<!-- Knowledge Base title -->
			<header>
				<h2><?php echo esc_html( apply_filters( 'basepress_modern_theme_header_title', 'Knowledge Base' ) ); ?><br>
				<?php echo ( esc_html( $bpkb_is_single_kb ) ? '' : esc_html( $bpkb_knowledge_base->name ) ); ?>
				</h2>
			</header>

			<!-- Add searchbar -->
			<div class="bpress-searchbar-wrap">
				<?php 
				basepress_searchbar(); ?>
			</div>
		</div>
	</div>
		
	<!-- Add breadcrumbs -->
	<div class="bpress-crumbs-wrap">
		<div class="bpress-content-wrap">
			<?php basepress_breadcrumbs(); ?>
		</div>
	</div>

	<div class="bpress-content-wrap">
		<div class="bpress-content-area bpress-float-<?php echo esc_attr( $bpkb_sidebar_position ) . esc_attr( $bpkb_content_classes ); ?>">

			<!-- Add main content -->
			<main class="bpress-main" role="main">
				<header class="bpress-post-header">
					<h1><?php the_title(); ?></h1>

					<?php

					if( basepress_byline() ){

					?>

					<div class="bpress-post-meta">
						<?php $bpkb_post_metas = basepress_get_post_meta( get_the_ID() ); ?>

						<span class="bpress-post-views"><span class="bp-eye"></span><?php echo esc_html( $bpkb_post_metas['views'] ) ; ?></span>
						<?php if ( basepress_show_post_votes() ) { ?>
						<span class="bpress-post-likes"><span class="bp-thumbs-up"></span><?php echo esc_html( $bpkb_post_metas['votes']['like'] ) ; ?></span>
						<span class="bpress-post-dislikes"><span class="bp-thumbs-down"></span><?php echo esc_html( $bpkb_post_metas['votes']['dislike'] ) ; ?></span>
						<?php } ?>

						<span class="bpress-post-date"><span class="bp-clock"></span><?php echo esc_html( get_the_date() ) ; ?></span>
						<span class="bpress-post-date"><span class="bp-clock"></span><?php echo esc_html( get_the_modified_date() ) ; ?></span>
					</div>
					<?php

					} ?>
				</header>

				<?php if ( basepress_show_restricted_teaser() ) { ?>
				<div class="article-teaser">
				<?php echo basepress_article_teaser();  //phpcs:ignore ?>
				</div>
				<?php } ?>

				<div class="bpress-restricted-notice"><?php echo esc_html( basepress_restricted_notice() ); ?></div>

				<?php if ( ! is_user_logged_in() && basepress_show_restricted_login() ) { ?>
				<div class="bpress-login">
				<?php
				$bpkb_form_args = array(
					'echo'           => true,
					'remember'       => true,
					'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], // phpcs:ignore
					'form_id'        => 'bpress-loginform',
					'id_username'    => 'user_login',
					'id_password'    => 'user_pass',
					'id_remember'    => 'rememberme',
					'id_submit'      => 'bpress-restricted-login-submit',
					'value_username' => '',
					'value_remember' => false,
				);
				wp_login_form( $bpkb_form_args );
				?>
				</div>
				<?php } ?>
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

	</div>
</div><!-- wrap -->

<?php basepress_get_footer( 'basepress' ); ?>
