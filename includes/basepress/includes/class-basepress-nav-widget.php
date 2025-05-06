<?php
/**
 * This is the class that creates and handles the Accordion menu widget
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( 'class-basepress-nav-walker.php' );

class Basepress_Nav_Widget extends WP_Widget {


	/**
	 * Basepress_Nav_Widget constructor.
	 *
	 * @since 2.9.0
	 */
	public function __construct() {
		parent::__construct(
			'basepress_nav_widget', // Base ID
			esc_html__( 'Knowledge Base - Accordion Menu', 'basepress' ), // Name
			array( 'description' => esc_html__( 'A single accordion menu to move inside the Knowledge Base', 'basepress' ) ) // Args
		);
	}


	/**
	 * Front-end display of widget.
	 *
	 * @since 2.9.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if( defined( 'REST_REQUEST' ) ){
			return '';
		}

		if( ! class_exists( 'Basepress') ){
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo esc_html( apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) );
			echo $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$this->render( $instance );

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}




	/**
	 * Back-end widget form.
	 *
	 * @since 2.9.0
	 *
	 * @param array $instance
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$link_sections = ! empty( $instance['link_sections'] ) ? $instance['link_sections'] : false;
		$articles_first = ! empty( $instance['articles_first'] ) ? $instance['articles_first'] : false;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'basepress' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'link_sections' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link_sections' ) ); ?>" type="checkbox" value="1" <?php checked( $link_sections, 1 ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'link_sections' ) ); ?>"><?php esc_attr_e( 'Add link to sections', 'basepress' ); ?></label>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'articles_first' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'articles_first' ) ); ?>" type="checkbox" value="1" <?php checked( $articles_first, 1 ); ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'articles_first' ) ); ?>"><?php esc_attr_e( 'Display articles before sub-sections', 'basepress' ); ?></label>
		</p>
		<?php
	}


	/**
	 * Sanitizes widget form values as they are saved.
	 *
	 * @since 2.9.0
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['link_sections'] = ! empty( $new_instance['link_sections'] ) ? $new_instance['link_sections'] : false;
		$instance['articles_first'] = ! empty( $new_instance['articles_first'] ) ? $new_instance['articles_first'] : false;

		return $instance;
	}


	/**
	 * Renders the widget using the BasePress_Nav_Walker
	 *
	 * @since 2.9.0
	 *
	 * @param $instance
	 */
	public function render( $instance ){
		global $basepress_utils;

		$product = $basepress_utils->get_product();

		$queried_object = get_queried_object();

		$current_term_id = '';
		$current_article_id = '';
		$ancestor_terms = '';
		$articles_first = ! empty( $instance['articles_first'] ) ? $instance['articles_first'] : false;
		$link_sections = ! empty( $instance['link_sections'] ) ? $instance['link_sections'] : false;

		if ( is_a( $queried_object, 'WP_Post' ) && 'knowledgebase' == $queried_object->post_type ) {
			$current_article_id = $queried_object->ID;
			$terms = get_the_terms( $queried_object->ID, 'knowledgebase_cat' );
			if( ! empty( $terms ) ){
				foreach( $terms as $term ){
					if( 0 == $term->parent ){
						continue;
					}
					$ancestor_terms = get_ancestors( $term->term_id, 'knowledgebase_cat', 'taxonomy' );
					array_push( $ancestor_terms, $term->term_id );
				}
			}
		} elseif ( is_a( $queried_object, 'WP_Term' ) ) {
			$current_term_id = $queried_object->term_id;
			$ancestor_terms = get_ancestors( $current_term_id, 'knowledgebase_cat', 'taxonomy' );
			array_push( $ancestor_terms, $current_term_id );
		}

		$args = array(
			'show_option_all'           => '',
			'style'                     => 'list',
			'show_count'                => 0,
			'hide_empty'                => 1,
			'exclude'                   => '',
			'exclude_tree'              => '',
			'include'                   => '',
			'hierarchical'              => 1,
			'title_li'                  => '',
			'show_option_none'          => '',
			'number'                    => null,
			'echo'                      => 1,
			'depth'                     => 0,
			'pad_counts'                => 0,
			'taxonomy'                  => 'knowledgebase_cat',
			'child_of'                  => $product->id,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'basepress_position',
				),
				array(
					'key' => 'basepress_position',
					'compare' => 'NOT EXISTS'
				)
			),
			'orderby'                   => 'meta_value_num',
			'order'                     => 'ASC',
			'open_categories'           => $ancestor_terms,
			'current_category'          => $current_term_id,
			'basepress_current_article' => $current_article_id,
			'articles_first'            => $articles_first,
			'link_sections'             => $link_sections,
			'walker'                    => new BasePress_Nav_Walker(),
		);

		/**
		 * Filter arguments before generating the items list
		 */
		$args = apply_filters( 'basepress_nav_term_args', $args );

		echo '<ul class="bpress-nav-accordion">';
		wp_list_categories( $args );
		echo '</ul>';
	}
}
?>
