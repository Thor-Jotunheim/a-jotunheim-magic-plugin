<?php
/**
 * Functions to extend the Zen Theme
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Basepress_Zen_Theme {

	private $settings = '';

	public function __construct() {
		//Replace sidebar to iclude the card class
		add_action( 'widgets_init', array( $this, 'theme_widget_areas' ), 100 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'init', array( $this, 'load_theme_settings' ) );
	}


	public function load_theme_settings() {
		$this->settings = get_option( 'basepress_zen_theme' );
	}

	/**
	 * Defines new widget areas for the theme
	 */
	public function theme_widget_areas() {
		unregister_sidebar( 'basepress-sidebar' );

		register_sidebar( array(
			'name'          => esc_html__( 'Knowledge Base Sidebar', 'basepress' ),
			'id'            => 'basepress-sidebar',
			'description'   => esc_html__( 'Add here the widgets to appear on the knowledge base pages', 'basepress' ),
			'class'         => '',
			'before_widget' => '<section id="%1$s" class="bpress-widget bpress-card %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="bpress-card-header small">',
			'after_title'   => '</h2>',
		));
	}


	public function enqueue_scripts() {
		global $wp_query,$basepress_utils;

		$options = $basepress_utils->get_options();
		$entry_page = isset( $options['entry_page'] ) ? $options['entry_page'] : '';

		if ( $basepress_utils->is_knowledgebase )	{
			$minified = isset( $_REQUEST['basepress_debug'] ) ? '': 'min.';
			$js_path = $basepress_utils->get_theme_file_path( 'js/zen.js' );
			$js_url = $basepress_utils->get_theme_file_uri( 'js/zen.' . $minified . 'js' );
			$fixed_sticky_url = $basepress_utils->get_theme_file_uri( 'js/fixedsticky.' . $minified . 'js' );
			$js_ver = filemtime( $js_path );
			wp_enqueue_script( 'stickyfixed-js', $fixed_sticky_url, array( 'jquery' ), $js_ver, true );
			wp_enqueue_script( 'basepress-zen-js', $js_url, array( 'stickyfixed-js' ), $js_ver, true );

			//Settings Styles
			$settings = $this->settings;

			if( empty( $settings ) || ( isset( $settings['enable_settings'] ) && ! $settings['enable_settings'] ) ){
				return;
			}

			$styles = '';

			if ( $settings['font_family'] ) {
				$styles .= stripslashes( $settings['font_family'] );
			}

			if ( $settings['font_size'] || $settings['font_family'] ) {

				if ( $settings['font_size'] ) {
					$styles .= '.bpress-wrap{font-size:' . $settings['font_size'] . 'px;}';
				}
				if ( $settings['font_family'] ) {
					$styles .= '.bpress-wrap *{';
					preg_match( '/family=([a-zA-Z+]*)/', $settings['font_family'], $font_family );
					$font_family = str_replace( '+', ' ', $font_family[1] );
					$styles .= isset( $font_family ) ? 'font-family:"' . $font_family . '";' : '';
					$styles .= '}';
				}
			}

			$sidebar_threshold = isset( $settings['sidebar_threshold'] ) && '' != $settings['sidebar_threshold'] ? $settings['sidebar_threshold'] : 0;

			//Sidebar
			if ( isset( $settings['sticky_sidebar'] ) ) {
				$styles .= '.bpress-sidebar{position:sticky;top:' . $sidebar_threshold . ';}';
			}

			//Sticky ToC
			if ( isset( $settings['sticky_toc'] ) && ! empty( $basepress_utils->get_option( 'show_toc' ) ) ) {
				$styles .= ".bpress-toc{position:sticky;top:{$sidebar_threshold}; max-height:calc(100vh - {$sidebar_threshold} - 10px)}";
				$styles .= 'a[name="bp-toc-top"]{position:relative; top:-' . $sidebar_threshold . ';}';
				
				//Add the body classes to trigger the sticky ToC
				add_filter( 'body_class', array( $this, 'add_body_classes' ) );
			}

			//Custom colors
			if( isset( $settings['enable_custom_colors'] ) && $settings['enable_custom_colors'] ){
				$accent_color = $settings['accent_color'];
				$accent_color_dk = basepress_color_brightness( $accent_color, -30 );
				$buttons_text_color = $settings['buttons_text_color'];
				$cards_color = '#dddddd';

				$colors = array(
					'accent_color'        => $accent_color,
					'accent_color_dk'     => $accent_color_dk,
					'buttons_text_color'  => $buttons_text_color,
					'cards_color'         => $cards_color,
				);

				$color_styles = array(
					'accent_color' => array(
						'color'              => array(
							'.bpress-comments-area a',
							'.bpress-crumbs li a:hover',
							'.bpress-totop:hover',
							'.bpress-search-suggest ul li b',
							'.bpress-copy-link',
							'.bpress-copy-link:hover',
							'.bpress-copy-link:focus'
						),
						'background-color'   => array(
							'button.bpress-btn',
							'button.bpress-btn:disabled:hover',
							'.bpress-pagination .page-numbers.current',
							'.bpress-pagination .page-numbers:hover',
							'.bpress-pagination .page-numbers.next:hover',
							'.bpress-pagination .page-numbers.prev:hover',
							'.bpress-post-link.search .bpress-search-section:hover',
							'.bpress-comments-area .comment-reply-link',
							'.bpress-comments-area .comment-respond #submit'
						),
						'border-left-color'  => array(
							'h1.bpress-card-header',
							'h2.bpress-card-header',
							'.bpress-widget ul li.bpress-widget-item.active',
							'.bpress-widget ul a.bpress-widget-item.active',
							'.bpress-widget ol a.bpress-widget-item.active',
							'.widget ul li.bpress-widget-item.active',
							'.widget ol a.bpress-widget-item.active',
							'.bpress-widget ul a.bpress-widget-item:hover',
							'.bpress-widget ul li.bpress-widget-item:hover',
							'.bpress-widget ol a.bpress-widget-item:hover',
							'.widget ul li.bpress-widget-item:hover',
							'.widget ul li .bpress-widget-item:hover',
							'.widget ol a.bpress-widget-item:hover',
							'.bpress-toc li a:hover',
							'.bpress-comment-list .comment-body:hover',
							'.bpress-prev-post:hover',
							'.bpress-post-link:hover',
							'.bpress-sidebar .wp-tag-cloud li:hover',
							'.bpress-nav-section.active > a.bpress-nav-item',
							'.bpress-nav-section a.bpress-nav-item:hover',
							'.bpress-nav-article.active > a.bpress-nav-item',
							'.bpress-nav-article a.bpress-nav-item:hover',
							'.bpress-nav-section.active > span.bpress-nav-item',
							'.bpress-nav-section span.bpress-nav-item:hover',
							'.bpress-nav-article.active > span.bpress-nav-item',
							'.bpress-nav-article span.bpress-nav-item:hover'
						),
						'border-right-color' => array(
							'.bpress-next-post:hover'
						),
						'border-top-color' => array(
							'.bpress-search-form.searching:before'
						)
					),
					'accent_color_dk' => array(
						'background-color' => array(
							'.bpress-btn-product:hover',
							'.bpress-btn-kb:hover',
							'button.bpress-btn:hover',
							'.bpress-submit-feedback:hover',
							'.bpress-submit-feedback:disabled:hover',
							'.bpress-comments-area a.comment-reply-link:hover',
							'.bpress-comments-area .comment-respond #submit:hover'
						),
						'border_color' => array(
							'.bpress-pagination .page-numbers.current',
							'.bpress-pagination .page-numbers:hover',
							'.bpress-pagination .page-numbers.next:hover',
							'.bpress-pagination .page-numbers.prev:hover'
						)
					),
					'buttons_text_color' => array(
						'color' => array(
							'.bpress-btn-product',
							'.bpress-btn-kb',
							'.bpress-submit-feedback',
							'.bpress-comments-area a.comment-reply-link',
							'.bpress-comments-area .comment-respond #submit'
						)
					),
					'cards_color' => array(
						'background-color' => array(
							'.bpress-card .bpress-card-top-image.no-image'
						)
					)
				);
				foreach( $color_styles as $color => $atts ){
					foreach( $atts as $att => $elements ){
						if( empty( $elements ) ) continue;
						$css_elements = implode( ',', $elements );
						$styles .= "\n" . $css_elements . '{' . $att . ':' . $colors[$color] . ';}';
					}
				}
			}

			//Custom Css
			$styles .= $settings['custom_css'];

			wp_add_inline_style( 'basepress-styles', $styles );
		}
	}


	/**
	 * Adds body class to handle floating ToC
	 *
	 * @since 2.11.0
	 *
	 * @param $classes
	 * @return array
	 */
	public function add_body_classes( $classes ){
		global $post, $basepress_utils;
		if( is_singular( 'knowledgebase') ){
			preg_match_all( '/<h[1-6].*>/i', $post->post_content, $post_headings );
			$skip_toc = get_post_meta( $post->ID, 'basepress_toc_toggle', true );

			if( isset( $this->settings['sticky_toc'] ) && count( $post_headings[0] ) && ! (bool)$skip_toc ){
				$template_name = get_post_meta( $post->ID, 'basepress_template_name', true );
				$sidebar_position = 'left';
				switch( $template_name ){
					case 'two-columns-right':
						$sidebar_position = 'right';
						break;
					case 'two-columns-left':
						$sidebar_position = 'left';
						break;
				}

				$options = $basepress_utils->get_options();
				if( isset( $options['sidebar_position'] ) && isset( $options['force_sidebar_position'] ) ){
					$sidebar_position = 'none' == $options['sidebar_position'] ? $sidebar_position : $options['sidebar_position'];
				}

				$toc_position = 'left' == $sidebar_position ? 'right' : 'left';
				$toc_position = apply_filters( 'basepress_article_toc_position', $toc_position );

				$classes[] = 'bpress-sticky-toc bpress-sticky-toc-' . $toc_position;
			}
		}
		return $classes;
	}

} //End Class

new Basepress_Zen_Theme();
