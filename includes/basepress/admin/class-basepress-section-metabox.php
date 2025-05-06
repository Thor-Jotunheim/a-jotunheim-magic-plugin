<?php
/**
 * This is the class that adds the product metabox on edit screen
 */

// Exit if called directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Basepress_Section_Metabox' ) ) {

	class Basepress_Section_Metabox {

		/**
		 * basepress_section_metabox constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'sections_scripts' ) );
			add_action( 'wp_ajax_basepress_get_product_sections', array( $this, 'basepress_get_product_sections' ) );
		}



		/**
		 * Adds the Sections metabox on post edit
		 *
		 * @since 1.0.0
		 *
		 * @param $post_type
		 */
		public function add_meta_box( $post_type ) {

			if ( 'knowledgebase' == $post_type ) {

				//Add BasePress section( sub category ) selector
				add_meta_box(
					'basepress_section',
					esc_html__( 'Section', 'basepress' ),
					array( $this, 'render_meta_box' ),
					$post_type,
					'side',
					'default'
				);
			}
		}



		/**
		 * Finds the product from the section
		 *
		 * @since 1.0.0
		 * @updated 1.7.6
		 *
		 * @param $term
		 * @return int
		 */
		private function get_product( $term ) {
			global $basepress_utils;
			
			$options = $basepress_utils->get_options();

			if( ! $term && isset( $options['single_product_mode'] ) ){
				$active_product_id = $basepress_utils->get_active_product_id();

				return $active_product_id;
			}

			if( $term && $term->parent != 0 ){
				$parent_term = get_term( $term->parent, 'knowledgebase_cat' );

				if( $parent_term->parent != 0 ){
					return $this->get_product( $parent_term );
				}
				else{
					return $parent_term->term_id;
				}
			}
		}



		/**
		 * Renders the metabox on post edit screen
		 * 
		 * @since 1.0.0
		 * @updated 2.11.1
		 *
		 * @param $post
		 */
		public function render_meta_box( $post ) {

			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'basepress_section_meta', 'basepress_section_meta_nonce' );

			//Get taxonomy terms for the post
			$terms = get_the_terms( $post->ID, 'knowledgebase_cat' );
			$section = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0] : 0;
			$product = $this->get_product( $section );

			// Display the form, using the current value.
			if ( ! empty( $product ) ) {
				$list = basepress_section_metabox::get_section_categories( $product, $section );
				echo $list; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
			?>
				<select id="tax_input[knowledgebase_cat][]" name="tax_input[knowledgebase_cat][]" class="basepress_section_mb">
				<option selected><?php esc_html_e( 'Choose Section', 'basepress' ); ?></option>
				<option disabled>─────────</option>
				</select>
			<?php
			}
		}




		/**
		 * Generates the list of Sections for the selected product
		 *
		 * @since 1.0.0
		 *
		 * @param $product
		 * @param $value
		 * @return array
		 */
		public static function get_section_categories( $product, $section ) {

			$section_id = is_a( $section, 'WP_Term' ) ? $section->term_id : $section;

			$list = wp_dropdown_categories(
				array(
					'taxonomy'     => 'knowledgebase_cat',
					'child_of'     => $product,
					'hide_empty'   => 0,
					'echo'         => 0,
					'hierarchical' => 1,
					'class'        => 'basepress_section_mb smb_not_empty',
					'name'         => 'tax_input[knowledgebase_cat][]',
					'id'           => 'tax_input[knowledgebase_cat][]',
					'selected'     => esc_attr( $section_id ),
				)
			);
			$selected = ! $section_id ? ' selected' : '';
			$choose_section = esc_html__( 'Choose Section', 'basepress' );
			$list = preg_replace( '/(<select.*>)/', "$0\n\t<option disabled{$selected}>{$choose_section}</option><option disabled>─────────</option>", $list );

			return $list;
		}



		/**
		 * Enqueues the scripts to handle the sections metabox
		 *
		 * @since 1.0.0
		 */
		public function sections_scripts( $hook ) {
			if ( in_array( $hook, array('post.php', 'post-new.php') ) ){
				$screen = get_current_screen();
				if( is_object( $screen ) && 'knowledgebase' == $screen->post_type ){
					wp_enqueue_script( 'basepress-section-metabox-js', plugins_url( '/js/basepress-section-metabox.js', __FILE__ ), array( 'jquery' ), BASEPRESS_VER, true );
				}
			}
		}



		/**
		 * Ajax call function to get sections list
		 *
		 * @since 1.0.0
		 */
		public function basepress_get_product_sections() {

			$product = isset( $_POST['product'] ) ? sanitize_text_field( wp_unslash( $_POST['product'] ) ) : '';
			$value = 0;

			$list = basepress_section_metabox::get_section_categories( $product, $value );

			echo $list; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			wp_die();
		}
	}

	new Basepress_Section_Metabox();

}
