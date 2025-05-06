<?php
/**
 * This is the class that creates and handles the Knowledge Bases widget
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Basepress_Products_Widget extends WP_Widget {

	/**
	 * Basepress_Products_Widget constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			'basepress_products_widget', // Base ID
			esc_html__( 'Knowledge Base - KB Selector', 'basepress' ), // Name
			array( 'description' => esc_html__( 'Lists all available knowledge bases', 'basepress' ) )
		);

	}




	/**
	 * Front-end display of widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $basepress_utils;

		if( defined( 'REST_REQUEST' ) ){
			return '';
		}

		$options = $basepress_utils->get_options();

		if ( isset( $options['single_product_mode'] ) ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo esc_html( apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) );
			echo $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( $instance['dropdown'] ) {
			$this->get_products_dropdown( $instance );
		} else {
			$this->get_products_list( $instance );
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}




	/**
	 * Back-end widget form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance
	 * @return string|void
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? sanitize_text_field( $instance['title'] ) : '';
		$count = ! empty( $instance['count'] ) ? sanitize_text_field( $instance['count'] ) : '';
		$order_by = ! empty( $instance['order-by'] ) ? sanitize_text_field( $instance['order-by'] ) : 'custom';
		$dropdown = ! empty( $instance['dropdown'] ) ? sanitize_text_field( $instance['dropdown'] ) : 0;
		$exclude = ! empty( $instance['exclude'] ) ? sanitize_text_field( $instance['exclude'] ) : 0;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'basepress' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_attr_e( 'Number of products to show:', 'basepress' ); ?></label> 
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>" size="3">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order-by' ) ); ?>"><?php esc_attr_e( 'Order by:', 'basepress' ); ?></label> 
			<select class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'order-by' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order-by' ) ); ?>" type="number" value="<?php echo esc_attr( $order_by ); ?>">
				<option value="custom"<?php echo ( 'custom' == $order_by ? ' selected' : '' ); ?>><?php echo esc_attr_e( 'Custom', 'basepress' ); ?></option>
				<option value="date-asc"<?php echo ( 'date-asc' == $order_by ? ' selected' : '' ); ?>><?php echo esc_attr_e( 'Date Ascending', 'basepress' ); ?></option>
				<option value="date-desc"<?php echo ( 'date-desc' == $order_by ? ' selected' : '' ); ?>><?php echo esc_attr_e( 'Date Descending', 'basepress' ); ?></option>
			</select>
		</p>

		<p>
			<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dropdown' ) ); ?>" type="checkbox" value="1" <?php checked( $dropdown, 1 ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"><?php esc_attr_e( 'Display as dropdown', 'basepress' ); ?></label>
		</p>
		
		<p>
		<input class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" type="checkbox" value="1" <?php checked( $exclude, 1 ); ?>">
		<label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_attr_e( 'Exclude current product', 'basepress' ); ?></label>
		</p>
		<?php
	}




	/**
	 * Sanitizes widget form values as they are saved.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['order-by'] = ( ! empty( $new_instance['order-by'] ) ) ? strip_tags( $new_instance['order-by'] ) : 'custom';
		$instance['dropdown'] = ( ! empty( $new_instance['dropdown'] ) ) ? strip_tags( $new_instance['dropdown'] ) : 0;
		$instance['exclude'] = ( ! empty( $new_instance['exclude'] ) ) ? strip_tags( $new_instance['exclude'] ) : 0;

		return $instance;
	}




	/**
	 * Generates the products list
	 *
	 * @since 1.0.0
	 *
	 * @param $instance
	 */
	private function get_products_list( $instance ) {
		global $basepress_utils;
		$current_product = $basepress_utils->get_product();
		$exclude = $instance['exclude'] ? $current_product->id : '';

		switch ( $instance['order-by'] ) {

			case 'date-asc':
				$meta_key = '';
				$order_by = 'term_id';
				$order    = 'ASC';
				break;

			case 'date-desc':
				$meta_key = '';
				$order_by = 'term_id';
				$order    = 'DESC';
				break;

			case 'custom':
			default:
				$meta_key = 'basepress_position';
				$order_by = 'meta_value_num';
				$order    = 'ASC';
				break;
		}

		$terms_args =	array(
			'taxonomy' => 'knowledgebase_cat',
			'hide_empty' => false,
			'parent'     => 0,
			'meta_key'   => $meta_key,
			'orderby'    => $order_by,
			'order'      => $order,
			'number'     => $instance['count'],
			'exclude'    => $exclude,
		);

		$terms_args = apply_filters( 'basepress_products_widget_terms_args', $terms_args );

		$products = get_terms( $terms_args );

		echo '<ul class="bpress-widget-list">';

		foreach ( $products as $product ) {
			$permalink = get_term_link( (int) $product->term_id, 'knowledgebase_cat' );
			$active = $product->term_id === $current_product->id ? ' active' : '';

			echo '<li class="bpress-widget-item knowledge-base' . esc_attr( $active ) . '">';
			echo '<a href="' . esc_url( $permalink ) . '">';
			echo '<span>' . esc_html( $product->name ) . '</span>';
			echo '</a>';
			echo '</li>';
		}

		echo '</ul>';
	}




	/**
	 * Generates the products drop-down menu
	 *
	 * @since 1.0.0
	 *
	 * @param $instance
	 */
	private function get_products_dropdown( $instance ) {
		global $basepress_utils;
		$exclude = $instance['exclude'] ? $basepress_utils->get_product()->id : '';

		switch ( $instance['order-by'] ) {

			case 'date-asc':
				$meta_key = '';
				$order_by = 'term_id';
				$order    = 'ASC';
				break;

			case 'date-desc':
				$meta_key = '';
				$order_by = 'term_id';
				$order    = 'DESC';
				break;

			case 'custom':
			default:
				$meta_key = 'basepress_position';
				$order_by = 'meta_value_num';
				$order    = 'ASC';
				break;
		}

		$products = get_terms(
			'knowledgebase_cat',
			array(
				'hide_empty' => true,
				'parent'     => 0,
				'meta_key'   => $meta_key,
				'orderby'    => $order_by,
				'order'      => $order,
				'number'     => $instance['count'],
				'exclude'    => $exclude,
			)
		);

		echo '<select class="bpress-widget-products-dropdown" onchange="location = this.value">';
		echo '<option value="" disabled selected>' . esc_html__( 'Select Knowledge Base', 'basepress' ) . '</option>';

		foreach ( $products as $product ) {
			$permalink = get_term_link( (int) $product->term_id, 'knowledgebase_cat' );

			echo '<option value="' . esc_url( $permalink ) . '">';

			echo esc_html( $product->name );

			echo '</option>';
		}

		echo '</select>';
	}
}
?>
