<?php
/**
 * This is the class that adds the products page on admin
 */

// Exit if called directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Basepress_Products_Page' ) ) {

	class Basepress_Products_Page {

		/**
			* basepress_products_page constructor.
			*
			* @since 1.0.0
			*/
		public function __construct() {
				add_action( 'admin_menu', array( $this, 'add_products_page' ) );

				add_action( 'init', array( $this, 'add_ajax_callbacks' ) );

				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		}


		/**
			* Add Products page
			*
			* @since 1.0.0
			*/
		public function add_products_page() {
			//Add the sub menu 'Products' on knowledgebase post type
			add_submenu_page( 'edit.php?post_type=knowledgebase', 'BasePress' . esc_html__( 'Manage KBs', 'basepress' ), esc_html__( 'Manage KBs', 'basepress' ), 'manage_categories', 'basepress_manage_kbs', array( $this, 'display_screen' ), 2 );
		}



		/**
			* Define the ajax calls for this screen
			*
			* @since 1.0.0
			*/
		public function add_ajax_callbacks() {
			add_action( 'wp_ajax_basepress_get_product_data', array( $this, 'basepress_get_product_data' ) );
			add_action( 'wp_ajax_basepress_new_product', array( $this, 'basepress_new_product' ) );
			add_action( 'wp_ajax_basepress_delete_product', array( $this, 'basepress_delete_product' ) );
			add_action( 'wp_ajax_basepress_update_product', array( $this, 'basepress_update_product' ) );
			add_action( 'wp_ajax_basepress_update_product_order', array( $this, 'basepress_update_product_order' ) );
		}



		/**
			* Enqueue admin scripts for this screen
			*
			* @since 1.0.0
			*
			* @param $hook
			*/
		public function enqueue_admin_scripts( $hook ) {
			//Enqueue admin script for Products screen only
			if ( 'knowledgebase_page_basepress_manage_kbs' == $hook ) {
				wp_enqueue_media();
				wp_register_script( 'basepress-products-js', plugins_url( 'js/basepress-products.js', __FILE__ ), array( 'jquery' ), BASEPRESS_VER, true );
				wp_enqueue_script( 'basepress-products-js' );
				wp_enqueue_script( 'jquery-ui-sortable' );
			}
		}



		/**
			* Generate the page content
			*
			* @since 1.0.0
			*
			*/
		public function display_screen() {
			?>
			<div class="wrap">
				<h1><?php echo esc_html_e( 'Manage Knowledge Bases', 'basepress' ); ?></h1>
				
				<div id="col-container" class="wp-clearfix">

					<!-- Add New Product -->
					
					<div id="col-left">
						<div class="col-wrap">
							<div class="form-wrap">
								<h2><?php echo esc_html_e( 'Add New Knowledge Base', 'basepress' ); ?></h2>
								
								<form id="new-basepress-product">
									
									<div class="form-field form-required term-name-wrap">
										<label for="product-name"><?php echo esc_html_e( 'Name', 'basepress' ); ?></label>
										<input name="product-name" id="product-name" type="text" value="" size="40" aria-required="true">
										<p class="description"><?php echo esc_html_e( 'The name is how it appears on your site.', 'basepress' ); ?></p>
									</div>
									
									<div class="form-field term-slug-wrap">
										<label for="product-slug"><?php echo esc_html_e( 'Slug', 'basepress' ); ?></label>
										<input name="slug" id="product-slug" type="text" value="" size="40">
										<p class="description"><?php echo esc_html_e( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'basepress' ); ?></p>
									</div>
									
									<div class="form-field term-description-wrap">
										<label for="product-description"><?php echo esc_html_e( 'Description', 'basepress' ); ?></label>
										<textarea name="description" id="product-description" rows="5" cols="40"></textarea>
										<p class="description"><?php echo esc_html_e( 'The description is not prominent by default; however, some themes may show it.', 'basepress' ); ?></p>
									</div>
									
									<div class="form-field term-image-wrap">
										<label for="product-image-url"><?php echo esc_html_e( 'Knowledge Base image', 'basepress' ); ?></label>
										<div id="product-image"><img src=""></div>
										<input id='product-image-url' value='' type='text' name='product-image-url' hidden="hidden">
										<input id='product-image-width' value='' type='text' name='product-image-width' hidden="hidden">
										<input id='product-image-height' value='' type='text' name='product-image-height' hidden="hidden">
										<p class="description"><?php echo esc_html_e( 'Choose an image for this Knowledge Base.', 'basepress' ); ?></p>

										<p id="product-buttons">
										<a id="select-image" class="button button-primary"><?php echo esc_html_e( 'Select image', 'basepress' ); ?></a>
										<a id="remove-image" class="button button-primary"><?php echo esc_html_e( 'Remove image', 'basepress' ); ?></a>
										</p>
									</div>
														
									<div id="product-section-styles">
										<p><?php echo esc_html_e( 'Sections style', 'basepress' ); ?></p>
										<select name="section-style" id="section-style">
										<option value="list"><?php echo esc_html_e( 'List', 'basepress' ); ?></option>
										<option value="boxed"><?php echo esc_html_e( 'Boxed', 'basepress' ); ?></option>
										</select>
										
										<br>
										<p><?php echo esc_html_e( 'Sub-Sections style', 'basepress' ); ?></p>
										<select name="subsection-style" id="subsection-style">
										<option value="list"><?php echo esc_html_e( 'List', 'basepress' ); ?></option>
										<option value="boxed"><?php echo esc_html_e( 'Boxed', 'basepress' ); ?></option>
										</select>
									</div>

									<?php do_action( 'basepress_after_new_product_fields' ); ?>

									<p class="submit">
										<?php wp_nonce_field( 'bp-kb-nonce', 'nonce' ); ?>
										<a id="add-product" class="button button-primary">
										<?php echo esc_html_e( 'Add New Knowledge Base', 'basepress' ); ?>
										</a>
									</p>
								</form>
							</div>
						</div>
					</div>

					<!-- Products Table -->

					<div id="col-right">
						<div class="col-wrap">
							<div id="basepress-products">
								
								<div class="table-nav top">
									<div class="alignright">
										<a id="save-product-order" class="button button-primary" data-nonce="<?php echo esc_attr( wp_create_nonce( 'bp-kb-nonce' ) ); ?>"><?php echo esc_html_e( 'Save Order', 'basepress' ); ?></a>
									</div>
								</div>
								
								<br class="clear">
								
								<div class="products-header">
									<div class="product-image-th"><?php echo esc_html_e( 'Image', 'basepress' ); ?></div>
									<div class="product-name"><?php echo esc_html_e( 'Name', 'basepress' ); ?></div>
									<div class="product-description"><?php echo esc_html_e( 'Description', 'basepress' ); ?></div>
									<div class="product-slug"><?php echo esc_html_e( 'Slug', 'basepress' ); ?></div>
									<div class="product-count"><?php echo esc_html_e( 'Count', 'basepress' ); ?></div>
									<div class="product-actions"></div>
								</div>
								
								<div id="products-table">
									<ul>
										<?php $this->get_products_list(); ?>
									</ul>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Edit Product -->
			
			<?php
			$product_id = '';
			if ( isset( $_GET['product'] ) && '' != $_GET['product'] ) {
				$product_id = intval( $_GET['product'] );
			}
			?>
			<div id="edit-product-wrap">
				<form id="edit-basepress-product">
					<input id="product-id"  value="<?php echo esc_attr( $product_id ); ?>" name="product-id" hidden="hidden">
					<?php wp_nonce_field( 'bp-kb-nonce', 'nonce' ); ?>
					<h2>
						<?php echo esc_html_e( 'Edit Knowledge Base', 'basepress' ); ?>
						<input type="checkbox" value="1" name="product-visibility" id="product-visibility" checked="checked">
						<label for="product-visibility"></label>
					
					</h2>
					<div class="form-field form-required term-name-wrap">
						<label for="product-name"><?php echo esc_html_e( 'Name', 'basepress' ); ?></label>
						<input name="product-name" id="product-name-edit" type="text" value="" size="40" aria-required="true">
					</div>
					<br>
					
					<div class="form-field term-slug-wrap">
						<label for="product-slug"><?php echo esc_html_e( 'Slug', 'basepress' ); ?></label>
						<input name="slug" id="product-slug-edit" type="text" value="" size="40">
					</div>
					<br>
					
					<div class="form-field term-description-wrap">
						<label for="product-description"><?php echo esc_html_e( 'Description', 'basepress' ); ?></label>
						<textarea name="description" id="product-description-edit" rows="5" cols="40"></textarea>
					</div>
					<br>
					
					<div class="form-field term-image-wrap">
						<label for="product-image-url-edit"><?php echo esc_html_e( 'Knowledge Base image', 'basepress' ); ?></label>
						<div id="product-image-edit"><img src=""></div>
						<input id='product-image-url-edit' value='' type='text' name='product-image-url' hidden="hidden">
						<input id='product-image-width-edit' value='' type='text' name='product-image-width' hidden="hidden">
						<input id='product-image-height-edit' value='' type='text' name='product-image-height' hidden="hidden">

						<p id="product-buttons">
						<a id="select-image-edit" class="button button-primary"><?php echo esc_html_e( 'Select image', 'basepress' ); ?></a>
						<a id="remove-image-edit" class="button button-primary"><?php echo esc_html_e( 'Remove image', 'basepress' ); ?></a>
						</p>
					</div>
					
					<div id="product-section-styles">
						<p><?php echo esc_html_e( 'Sections style', 'basepress' ); ?></p>
						<select name="section-style-edit" id="section-style-edit">
							<option value="list"><?php echo esc_html_e( 'List', 'basepress' ); ?></option>
							<option value="boxed"><?php echo esc_html_e( 'Boxed', 'basepress' ); ?></option>
						</select>
						
						<br>
						<p><?php echo esc_html_e( 'Sub-Sections style', 'basepress' ); ?></p>
						<select name="subsection-style-edit" id="subsection-style-edit">
							<option value="list"><?php echo esc_html_e( 'List', 'basepress' ); ?></option>
							<option value="boxed"><?php echo esc_html_e( 'Boxed', 'basepress' ); ?></option>
						</select>
					</div>

					<?php do_action( 'basepress_after_edit_product_fields' ); ?>

					<div id="default-category-edit">
						<a href="#" target="_blank">View More</a>
					</div>

					<p class="submit">
						<a id="save-change" class="button button-primary">
						<?php echo esc_html_e( 'Save changes', 'basepress' ); ?>
						</a>
						<a id="cancel-change" class="button button-primary">
						<?php echo esc_html_e( 'Cancel', 'basepress' ); ?>
						</a>
					</p>
				</form>
			</div>
			
			<!-- Ajax Loader -->
			<div id="ajax-loader"></div>
		<?php
		}



		/**
			* Generates the product list to show on products table
			*
			* @since 1.0.0
			*/
		public function get_products_list() {
			global $wp_version;

			//Get all terms in knowledgebase_cat
			$args = array(
				'taxonomy'   => 'knowledgebase_cat',
				'hide_empty' => false,
				'meta_query' => array(
					'position' => array(
						'relation' => 'OR',
						array(
							'key'    => 'basepress_position',
						),
						array(
							'key'    => 'basepress_position',
							'compare' => 'NOT EXISTS',
						)
					)
				),
				'orderby'    => 'meta_value_num',
				'order'      => 'ASC',
				'pad_counts' => true,
			);

			if ( $wp_version <= 4.5 ) {
				$product_terms = get_terms( 'knowledgebase_cat', $args );
			} else {
				$product_terms = get_terms( $args );
			}

			//Filter out only the product categories
			$product_terms = wp_list_filter( $product_terms, array( 'parent' => 0 ) );

			//Iterate over each product
			foreach ( $product_terms as $product ) {

				//Get the HTML row for this product
				$this->get_product_row( $product );

			}
		}



		/**
			* Generates the HTML row for the product
			*
			* @since 1.0.0
			*
			* @param $product
			*/
		public function get_product_row( $product ) {

			//Get the product image
			$image = get_term_meta( $product->term_id, 'image', true );
			$image_url = isset( $image['image_url'] ) ? $image['image_url'] : '';

			//Get the product position
			$pos = get_term_meta( $product->term_id, 'basepress_position', true );

			//Get product visibility and sett row class
			$visibility = get_term_meta( $product->term_id, 'visibility', true );
			$row_class = $visibility ? '' : ' invisible';

			//Truncate long descriptions
			$max_length = mb_strlen( $product->description ) != strlen( $product->description ) ? 60 : 180;
			$description = mb_strlen( $product->description ) > $max_length ?
				mb_substr( $product->description, 0, $max_length ) . '&hellip;' :
				$product->description;

			$children_sections = get_term_children( $product->term_id, 'knowledgebase_cat' );

			?>
			<li class="product-row<?php echo esc_attr( $row_class ); ?>" data-product="<?php echo esc_attr( $product->term_id ); ?>" data-productname="<?php echo esc_attr( $product->name ); ?>" data-pos="<?php echo esc_attr( $pos ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'bp-kb-nonce' ) ); ?>">
				<div class="product-image" style="background-image:url(<?php echo esc_url( $image_url ); ?>)"></div>
				<div class="product-name"><div><?php echo esc_html( $product->name ); ?></div></div>
				<div class="product-description"><div><?php echo esc_html( $description ); ?></div></div>
				<div class="product-slug"><div><?php echo esc_html( $product->slug ); ?></div></div>
				<div class="product-count"><?php echo esc_html( $product->count ); ?></div>
				<div class="product-actions">
					<span class="dashicons dashicons-edit"></span>
					<?php if ( 0 == count( $children_sections ) ) { ?>
					<span class="dashicons dashicons-trash"></span>
					<?php } ?>
				</div>
			</li>
		<?php
		}


		/*
			*	Ajax call functions for Products page
			*
			*/


		/**
			* Adds a new Product
			*
			* @since 1.0.0
			*/
		public function basepress_new_product() {
			$form = array();
			//Get the product quantity. This value represents the position of the new product
			$term_position = wp_count_terms( 'knowledgebase_cat', array(
				'hide_empty' => false,
				'parent'     => 0,
			) );

			//Extract the form data we received via ajax
			parse_str( $_POST['form'], $form ); // phpcs:ignore

			//nonce verification
			if ( ! isset( $form['nonce'] ) || ! wp_verify_nonce( $form['nonce'], 'bp-kb-nonce' ) ) {
				header( 'Content-type: application/json' );
				echo json_encode( array(
					'error' => true,
					'data'  => 'Nonce authentication issue',
				));
				wp_die();
			}

			//Insert new term
			$term = wp_insert_term(
				sanitize_text_field( $form['product-name'] ),
				'knowledgebase_cat',
				array(
					'description' => sanitize_text_field( $form['description'] ),
					'slug'        => sanitize_text_field( $form['slug'] ),
					'parent'      => 0,
				)
			);

			//If there was a problem we return a wp_error
			if ( is_wp_error( $term ) ) {
				header( 'Content-type: application/json' );
				echo json_encode( array(
					'error' => true,
					'data' => $term->get_error_message(),
				) );
				wp_die();
			}

			$default_image = BASEPRESS_URI . 'assets/img/image-placeholder.png';

			$product_image = array(
				'image_url'    => $form['product-image-url'] ? sanitize_text_field( $form['product-image-url'] ) : $default_image,
				'image_width'  => $form['product-image-url'] ? sanitize_text_field( $form['product-image-width'] ) : 400,
				'image_height' => $form['product-image-url'] ? sanitize_text_field( $form['product-image-height'] ) : 400,
			);
			//Add product image
			update_term_meta(
				$term['term_id'],
				'image',
				$product_image
			);

			//Add product visibility
			update_term_meta(
				$term['term_id'],
				'visibility',
				1
			);

			//Add product position
			update_term_meta(
				$term['term_id'],
				'basepress_position',
				$term_position
			);

			//Add product sections style
			update_term_meta(
				$term['term_id'],
				'sections_style',
				array(
					'sections'     => sanitize_text_field( $form['section-style'] ),
					'sub_sections' => sanitize_text_field( $form['subsection-style'] ),
				)
			);

			//Get new term data and generate HTML row to add to product list table
			$product = get_term( $term['term_id'] );

			/**
			 * Fires when a new product is added
			 */
			do_action( 'basepress_product_added', $product );

			ob_start();
			$this->get_product_row( $product );
			$product_row = ob_get_clean();

			//Return HTML row
			header( 'Content-type: application/json' );
			echo json_encode( array( 'error' => false, 'data' => $product_row ) );

			wp_die();
		}




		/**
			* Deletes a product
			*
			* @since 1.0.0
			*/
		public function basepress_delete_product() {
			//nonce verification
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'bp-kb-nonce' ) ) {
				echo 'The kb cannot be deleted';
				wp_die();
			}

			//Get product id from ajax POST
			$product_id = sanitize_text_field( wp_unslash( $_POST['product'] ) );

			//Get the term for this product
			$term = get_term( $product_id, 'knowledgebase_cat' );

			//If there was a problem exit
			if ( is_wp_error( $term ) || null == $term ) {
				echo 'The Knowledge Base cannot be deleted';
				wp_die();
			}

			//If the term has some articles exit
			if ( $term->count > 0 ) {
				echo 'This knowledge Base has some articles. You must delete the articles first.';
				wp_die();
			} else {
				//If we had no problems we can delete the product term
				//Get the product sections
				$sections = get_terms( 'knowledgebase_cat', array(
					'hide_empty' => false,
					'parent'     => $product_id,
				) );

				if ( ! empty( $sections ) && ! is_wp_error( $sections ) ) {
					foreach ( $sections as $section ) {
						wp_delete_term(
							$section->term_id,
							'knowledgebase_cat'
						);
					}
				}

				$delete = wp_delete_term(
					$product_id,
					'knowledgebase_cat'
				);

				echo esc_html( $delete );
				wp_die();
			}
		}



		/**
			* Updates a product data
			*
			* @since 1.0.0
			*/
		public function basepress_update_product() {
			$form = array();

			//Extract the form data we received via ajax
			parse_str( $_POST['form'], $form ); // phpcs:ignore

			//nonce verification
			if ( ! isset( $form['nonce'] ) || ! wp_verify_nonce( $form['nonce'], 'bp-kb-nonce' ) ) {
				header( 'Content-type: application/json' );
				echo json_encode( array(
					'error' => true,
					'data'  => 'Nonce authentication issue',
				));
				wp_die();
			}

			//Update product data
			$term = wp_update_term(
				sanitize_text_field( $form['product-id'] ),
				'knowledgebase_cat',
				array(
					'name'        => sanitize_text_field( $form['product-name'] ),
					'description' => sanitize_text_field( $form['description'] ),
					'slug'        => sanitize_text_field( $form['slug'] ),
					'parent'      => 0,
				)
			);

			//If there was a problem exit
			if ( is_wp_error( $term ) ) {
				header( 'Content-type: application/json' );
				echo json_encode( array(
					'error' => true,
					'data' => $term->get_error_message(),
				) );
				wp_die();
			}

			//update product image
			update_term_meta(
				$term['term_id'],
				'image',
				array(
					'image_url'    => sanitize_text_field( $form['product-image-url'] ),
					'image_width'  => sanitize_text_field( $form['product-image-width'] ),
					'image_height' => sanitize_text_field( $form['product-image-height'] ),
				)
			);

			//update product visibility
			$visibility = isset( $form['product-visibility'] ) ? 1 : 0;
			update_term_meta(
				$term['term_id'],
				'visibility',
				$visibility
			);

			//Update product sections style
			update_term_meta(
				$term['term_id'],
				'sections_style',
				array(
					'sections' => sanitize_text_field( $form['section-style-edit'] ),
					'sub_sections' => sanitize_text_field( $form['subsection-style-edit'] ),
				)
			);

			//Get the new data from DB
			$term = get_term( $term['term_id'], 'knowledgebase_cat' );

			//Get image
			$term_image = get_term_meta( $term->term_id, 'image', true );

			//Get visibility status
			$term_visibility = get_term_meta( $term->term_id, 'visibility', true );

			//Get sections and sub-section styles
			$sections_style = get_term_meta( $term->term_id, 'sections_style', true );

			//Get position
			$term_position = get_term_meta( $term->term_id, 'basepress_position', true );

			/**
				* Fires after the product and its metadata have been saved
				*/
			do_action( 'basepress_product_updated', $term, $term_image, $sections_style, $term_position );

			//Return the new product
			//We return the data from DB to make sure everything worked
			header( 'Content-type: application/json' );

			//Truncate long descriptions
			$max_length = mb_strlen( $term->description ) != strlen( $term->description ) ? 60 : 180;
			$description = mb_strlen( $term->description ) > $max_length ?
				mb_substr( $term->description, 0, $max_length ) . '&hellip;' :
				$term->description;

			echo json_encode( array(
				'id'             => $term->term_id,
				'name'           => $term->name,
				'slug'           => $term->slug,
				'description'    => $description,
				'image'          => $term_image,
				'visibility'     => $term_visibility,
				'sections_style' => $sections_style,
			) );

			wp_die();
		}




		/**
			* Gets a product data
			*
			* @since 1.0.0
			*/
		public function basepress_get_product_data() {
			//nonce verification
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'bp-kb-nonce' ) ) {
				echo 'The kb cannot be edited';
				wp_die();
			}

			//Get product id from ajax POST
			$product_id = sanitize_text_field( wp_unslash( $_POST['product'] ) );

			//Get the term for this product
			$term = get_term( $product_id, 'knowledgebase_cat' );

			//Get  the image for this product
			$term_image = get_term_meta( $term->term_id, 'image', true );

			//Get the visibility for this product
			$term_visibility = get_term_meta( $term->term_id, 'visibility', true );

			//Get sections and sub-section styles
			$sections_style = get_term_meta( $term->term_id, 'sections_style', true );

			//If there is no image construct an empty image object
			if ( empty( $term_image ) ) {
				$term_image = array(
					(object) array(
						'image_url'    => '',
						'image_width'  => '',
						'image_height' => '',
					),
				);
			}

			$product_data = array(
				'id'                => $term->term_id,
				'name'              => $term->name,
				'slug'              => $term->slug,
				'description'       => $term->description,
				'image'             => $term_image,
				'visibility'        => $term_visibility,
				'sections_style'    => $sections_style,
				'default_edit_link' => get_edit_term_link( $term->term_id, 'knowledgebase_cat' ),
			);

			/**
			 * Filter the product data before sending it.
			 */
			$product_data = apply_filters( 'basepress_product_data_args_edit', $product_data );

			//Return product data
			header( 'Content-type: application/json' );
			echo json_encode( $product_data );

			wp_die();
		}



		/**
		 * Updates the products order
		 *
		 * @since 1.0.0
		 * @updated 1.7.6
		 */
		public function basepress_update_product_order() {
			//nonce verification
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'bp-kb-nonce' ) ) {
				echo 'The kb order cannot be Updated';
				wp_die();
			}

			//Get the array of products order
			$order = $_POST['order']; // phpcs:ignore

			//Update the order of every product
			foreach ( $order as $position => $term_id ) {
				if( is_numeric( $position ) && is_numeric( $term_id ) ){
					update_term_meta( $term_id, 'basepress_position', $position );
				}
			}

			/**
			 * Fires after the Product order has been updated
			 * This filter can be used to do further processing after products order has been saved
			 */
			do_action( 'basepress_product_order_updated', $order );

			flush_rewrite_rules();
			
			wp_die();
		}

	} //End Class

	new Basepress_Products_Page;

}
