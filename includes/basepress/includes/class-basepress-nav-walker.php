<?php

class BasePress_Nav_Walker extends Walker_Category {

	/**
	 * Stores an array of section IDs with the output for the corresponding articles
	 *
	 * @since 2.9.0
	 *
	 * @var array
	 */
	private $section_articles = array();


	/**
	 * Renders the opening element for a section
	 *
	 * @since 2.9.0
	 *
	 * @param string $output
	 * @param object $section
	 * @param int $depth
	 * @param array $args
	 * @param int $id
	 */
	public function start_el( &$output, $section, $depth = 0, $args = array(), $id = 0 ) {
		global $basepress_utils;

		// Set default Section name if not present.
		if ( ! $section->name ) {
			$section->name = 'Untitled';
		}

		//Get section children
		$term_args = apply_filters( 'basepress_nav_term_args', array(
			'taxonomy' => 'knowledgebase_cat',
			'child_of' => $section->term_id,
			'fields'   => 'ids'
		) );

		$term_children = get_terms(	$term_args );

		$section_articles = $this->get_articles( $section, $args );

		//If this section has not children we don't render it
		if( empty( $section_articles ) && empty( $term_children ) ){
			return;
		}

		// Set item classes
		$css_classes = array(
			'bpress-nav-section',
		);

		if ( ! empty( $args['current_category'] ) ) {
			if( $section->term_id == $args['current_category'] ){
				$css_classes[] = 'active';
			}
		}

		if( ! empty( $args['open_categories'] ) ){
			if( in_array( $section->term_id, $args['open_categories'] ) ){
				$css_classes[] = 'open';
			}
		}

		//Start Output
		$classes = implode( ' ', $css_classes );
		$output .= "\t<li class='{$classes}'>";

		$show_icons = apply_filters( 'basepress_nav_show_section_icon', basepress_show_section_icon() );

		if( isset( $args['link_sections'] ) && $args['link_sections'] ){
			$link = '<a class="bpress-nav-item-title" href="' . esc_url( get_term_link( $section ) ) . '">' . $section->name . '</a>';
		}
		else{
			$link = '<span class="bpress-nav-item-title">' . esc_html( $section->name ) . '</span>';
		}

		$output .= "<span class='bpress-nav-item'>";

		if( $show_icons ){
			$icon_meta = get_term_meta( $section->term_id, 'icon', true );
			$icon = ! empty( $icon_meta ) ? $icon_meta : $basepress_utils->icons->sections->default;
		}
		$output .= $show_icons ? "<span class='bpress-nav-widget-icon {$icon}'></span>" : '';
		$output .= "{$link}</span>";

		$this->section_articles[] = $section_articles;
		if( empty( $term_children ) && ! empty( $section_articles ) ){
			$this->start_lvl( $output, $depth, $args );
			$this->end_lvl( $output, $depth, $args );
		}
	}


	/**
	 * Renders the closing element for a section
	 *
	 * @since 2.9.0
	 *
	 * @param string $output
	 * @param object $page
	 * @param int $depth
	 * @param array $args
	 */
	public function end_el( &$output, $section, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}


	/**
	 * Renders the opening elements for the section children
	 *
	 * @since 2.9.0
	 *
	 * @param string $output
	 * @param int $depth
	 * @param array $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent<ul class='children'>\n";

		if( isset( $args['articles_first'] ) && $args['articles_first'] ){
			$articles_index = count( $this->section_articles ) - 1;
			if( $articles_index >= 0 ){
				$output .= $this->section_articles[ $articles_index ];
				unset( $this->section_articles[ $articles_index ] );
				$this->section_articles = array_values( $this->section_articles );
			}
		}
	}


	/**
	 * Renders the closing elements for the section children
	 *
	 * @since 2.9.0
	 *
	 * @param string $output
	 * @param int $depth
	 * @param array $args
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if( ( isset( $args['articles_first'] ) && ! $args['articles_first'] ) || ! isset( $args['articles_first'] ) ){
			$articles_index = count( $this->section_articles ) - 1;
			if( $articles_index >= 0 ){
				$output .= $this->section_articles[ $articles_index ];
				unset( $this->section_articles[ $articles_index ] );
				$this->section_articles = array_values( $this->section_articles );
			}
		}
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}


	/**
	 * Gets the articles for a section
	 *
	 * @since 2.9.0
	 *
	 * @param $section
	 * @param $args
	 * @return string
	 */
	public function get_articles( $section, $args ){
		global $basepress_utils;

		$output = '';
		$post_icons = $basepress_utils->icons->post;
		$show_icons = apply_filters( 'basepress_nav_show_post_icon', basepress_show_post_icon() );

		$posts_order = $basepress_utils->get_posts_order();
		$orderby = $posts_order['orderby'];
		$order = $posts_order['order'];

		//Get section's posts
		$query_args = array(
			'post_type'      => 'knowledgebase',
			'posts_per_page' => -1,
			'orderby'        => $orderby,
			'order'          => $order,
			'tax_query'      => array(
				array(
					'taxonomy'         => 'knowledgebase_cat',
					'field'            => 'term_id',
					'terms'            => $section->term_id,
					'include_children' => false,
				)
			)
		);

		/**
		 * Filter post args
		 */
		$query_args = apply_filters( 'basepress_nav_post_args', $query_args );

		$section_posts = new WP_Query( $query_args );

		if( $section_posts->have_posts() ){

			while( $section_posts->have_posts() ){
				$section_posts->the_post();

				//Get the post object
				$the_post = get_post();
				$permalink = get_post_permalink( $the_post );
				$active = isset( $args['basepress_current_article'] ) && $args['basepress_current_article'] == $the_post->ID ? ' active' : '';

				$output .= "<li class='bpress-nav-article{$active}'>";

				$output .= "<span class='bpress-nav-item'>";

				if( $show_icons ){
					//Add the icon to the post object
					$post_icon = get_post_meta( get_the_ID(), 'basepress_post_icon', true );
					$post_icon = $post_icon ? $post_icon : $post_icons->default;
					$output .= '<span class="bpress-nav-widget-icon ' . $post_icon . '"></span>';
				}
				$output .= "<a href='{$permalink}' class='bpress-nav-item-title'>" . esc_html( $the_post->post_title ) . '</a></span>';
				$output .= '</li>';
			}
			wp_reset_postdata();
		}
		return $output;
	}
}
