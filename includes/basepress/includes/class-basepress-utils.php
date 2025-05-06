<?php
/**
 * This is the class contains core functions used by all other classes
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Basepress_Utils' ) ) {

	class Basepress_Utils {

		private $kb_slug = null;
		private $products = null;
		private $product = null;
		private $sections = null;
		private $single_section = null;
		private $tag = null;
		public $is_knowledgebase = false;
		public $is_single_product_mode = false;
		public $is_products_page = false;
		public $is_product = false;
		public $is_section = false;
		public $is_tag = false;
		public $is_search = false;
		public $is_global_search = false;
		public $is_article = false;
		public $is_kb_404 = false;
		private $options = false;
		private $icons_options = false;
		public	$icons = '';
		public  $icons_form = '';
		private $regex_word_boundary = null;


		/**
		 * basepress_utils constructor.
		 *
		 * @since 1.0.0
		 *
		 * @updated 1.7.8
		 */
		public function __construct() {

			//Add knowledge base custom template
			add_filter( 'template_include', array( $this, 'basepress_page_template' ), 99 );

			//Set knowledge base variables
			add_filter( 'request', array( $this, 'set_page_variables' ), 10 );

			//Initialize options variables;
			$this->load_options();
			add_action( 'init', array( $this, 'load_options' ), 10 );

			//Change WP query for sections
			add_action( 'pre_get_posts', array( $this, 'sections_query' ), 999 );

			//Changes the request for knowledgebase entry page to different ones depending on cases.
			add_filter( 'request', array( $this, 'change_request' ), 30 );

			//Load icons
			add_action( 'init', array( $this, 'load_icons' ));

			//Enable comments for knowledge base
			add_filter( 'comments_open', array( $this, 'enable_comments' ) );

			//Redirect comments template for knowledge base
			add_filter( 'comments_template', array( $this, 'comments_template' ), 90 );

			//Include theme functions.php if it exists
			add_action( 'setup_theme', array( $this, 'load_theme_functions' ) );

			//Load theme settings in admin
			if ( is_admin() ) {
				$this->load_theme_settings();
			}

			//Enqueue public scripts and styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ), 10 );


			add_filter( 'document_title_parts', array( $this, 'set_title' ), 10 );

			//Make KB menu item active when visiting any KB page
			add_filter( 'nav_menu_css_class', array( $this, 'set_menu_item_active') , 10, 2 );

			//If Build Mode is enabled load our class
			if( isset( $this->options['build_mode'] ) ){
				require_once BASEPRESS_DIR . 'includes/class-basepress-build-mode.php';
			}
		}



		/**
		 * Fixes titles for entry page and global searches
		 *
		 * @since 1.7.6
		 * @updated 1.7.7
		 *
		 * @param mixed $parts
		 * @return mixed 
		 */
		public function set_title( $parts ){
			if( ( isset( $this->options['single_product_mode'] ) && $this->is_product ) || $this->is_global_search ){
				$options = $this->get_options();
				$entry_page = $options['entry_page'];
				/**
				 * This filter allows to modify the entry page ID
				 */
				$entry_page = apply_filters( 'basepress_entry_page', $entry_page );

				$title = $entry_page ? get_the_title( $options['entry_page'] ) : '';
				
				$parts['title'] = $title;
			}
			return $parts;
		}


		/**
		 * Loads and caches plugin options
		 *
		 * @since 1.5.0
		 */
		public function load_options() {
			$options = get_option( 'basepress_settings' );
			if ( ! $options && is_multisite() ) {
				$options = get_site_option( 'basepress_settings' );
			}
			$this->options = $options;
		}

		public function is_breadcrumbs_enabled(){

			if(isset( $this->options['hide_breadcrumbs'] )){
				return false;
			}else{
				return true;
			}

		}

		/**
		 * Loads the active theme functions.php if it exists
		 *
		 * @since 1.3.0
		 */
		public function load_theme_functions() {
			//Include theme functions.php if it exists
			$theme_functions = $this->get_theme_file_path( 'functions.php' );
			if ( $theme_functions ) {
				include_once( $theme_functions );
			}
		}


		/**
		 * Loads the theme settings page on admin screen
		 *
		 * @since 1.3.1
		 */
		private function load_theme_settings() {
			//Include theme theme-settings.php if it exists
			$theme_settings = $this->get_theme_file_path( 'settings/theme-settings.php' );
			if ( $theme_settings ) {
				include_once( $theme_settings );
			}
		}


		/**
		 * Enqueue scripts for front end
		 *
		 * @since 1.0.0
		 *
		 * @updated 1.7.8, 1.7.10, 1.7.12
		 */
		public function enqueue_public_scripts() {

			global $basepress, $post;

			//Retrieve the active theme css and icons URLs.
			/**
			 * This filter allows to change the css file name
			 */
			$stylesheet = apply_filters( 'basepress_theme_style', 'style.css' );

			$theme_css = $this->get_theme_file_uri( 'css/' . $stylesheet );

			$theme_icons = $this->get_icons_uri();

			$theme_path = $this->get_theme_file_path( 'css/' . $stylesheet );
			$theme_ver = filemtime( $theme_path );

			//Always register scripts and styles as they might be needed for shortcodes as well
			$minified = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || isset( $_REQUEST['script_debug'] ) ? '' : 'min.';
			$front_js_ver = filemtime( BASEPRESS_DIR . "public/js/basepress.{$minified}js");
			wp_register_script( 'basepress-js', plugins_url( "public/js/basepress.{$minified}js", __DIR__ ), array( 'jquery' ), $front_js_ver, true );

			wp_register_style( 'basepress-styles', $theme_css, array(), $theme_ver );
			wp_register_style( 'basepress-icons', $theme_icons, array(), $basepress->ver );

			//Enqueue scripts and styles inside the knowledge base pages
			if( $this->is_knowledgebase || apply_filters( 'basepress_force_script_loading', false ) ){

				$kb_post_id = is_singular('knowledgebase') ? $kb_post_id = $post->ID : '';
				$product = $this->get_product();
				$minimum_char_length = $this->get_option( 'search_min_chars' );
				$minimum_char_length = $minimum_char_length ? $minimum_char_length : 3;

				//Enqueue scripts
				wp_enqueue_script( 'basepress-js' );

				$js_vars = array(
					'ajax_url'   => admin_url( 'admin-ajax.php' ),
					'postID'     => $kb_post_id,
					'productID'  => $product->id,
					'premium'    => BASEPRESS_PLAN == 'premium' ? true : '',
					'log_search' => isset( $this->options['activate_insights'] ),
					'min_chars'  => apply_filters( 'basepress_search_min_char_length', $minimum_char_length )
				);

				wp_localize_script( 'basepress-js', 'basepress_vars', $js_vars );

				//Enqueue the theme styles
				wp_enqueue_style( 'basepress-styles', $theme_css );

				if( ! isset( $this->icons_options['form']['skip-enqueue'] ) ){
					wp_enqueue_style( 'basepress-icons', $theme_icons );
				}

			}
		}


		/**
		 * Get the icon URI for enqueueing
		 *
		 * @since 1.7.8
		 *
		 * @return bool|string
		 */
		public function get_icons_uri(){
			$icons_options = $this->icons_options;
			$css_uri = $icons_options && !apply_filters( 'basepress_legacy_icons', false ) ? $icons_options['form']['css-uri'] : '';
			$is_default_font = empty( $css_uri ) ? true : false;
			$is_cdn = filter_var( $css_uri, FILTER_VALIDATE_URL ) !== false;

			if( $is_cdn && !apply_filters( 'basepress_legacy_icons', false )){
				$theme_icons = $css_uri;
			}
			else{
				$theme_icons = $is_default_font ? $this->get_default_icons_css_uri() : get_template_directory_uri() . '/' . $css_uri;
			}

			return $theme_icons;
		}


		/**
		 * Loads xml icons file from active theme
		 *
		 * @since 1.0.0
		 *
		 * @updated 1.7.8
		 */
		public function load_icons(){

			$icons_options = $this->get_icons_options();

			if( $icons_options && !apply_filters( 'basepress_legacy_icons', false )){
				$this->icons = json_decode( json_encode( $icons_options['icons-sets'] ));
				$this->icons_form = $icons_options['form'];
			}
			else{
				$icons = $this->get_default_icons_xml_path();
				if( $icons ){
					$this->icons = simplexml_load_file( $icons );
				}
				else{
					$this->icons = basepress_icons_manager::get_empty_icons_data();
				}
				$this->icons_form = array( 'css-uri' => '', 'extra-classes' => '' );
			}
		}


		/**
		 * Returns the icons options from DB
		 *
		 * @since 1.7.8
		 *
		 * @return bool
		 */
		public function get_icons_options(){
			if( ! $this->icons_options ){
				$icons_options = get_option( 'basepress_icons_sets' );
				$this->icons_options = $icons_options;
			}
			return $this->icons_options;
		}


		/**
		 * Returns the icons css uri
		 *
		 * @since 1.7.8
		 *
		 * @return string
		 */
		public function get_default_icons_css_uri(){
			if( apply_filters( 'basepress_legacy_icons', false ) ){
				$css_uri = $this->get_theme_file_uri( 'css/icons.css' );
			}
			else{
				$css_uri = BASEPRESS_URI . 'icons/icons.css';
			}
			return $css_uri;
		}


		/**
		 * Returns the icons css path
		 *
		 * @since 1.7.8
		 *
		 * @return string
		 */
		public function get_default_icons_css_path(){
			if( apply_filters( 'basepress_legacy_icons', false ) ){
				$css_path = $this->get_theme_file_path( 'css/icons.css' );
			}
			else{
				$css_path = BASEPRESS_DIR . 'icons/icons.css';
			}
			return $css_path;
		}



		/**
		 * Returns the icons xml path
		 *
		 * @since 1.7.8
		 *
		 * @return string
		 */
		public function get_default_icons_xml_path(){
			if( apply_filters( 'basepress_legacy_icons', false ) ){
				$xml_path = $this->get_theme_file_path( 'icons/icons.xml' );
				$xml_path = $xml_path ? $xml_path : BASEPRESS_DIR . 'icons/fonts/icons.xml';
			}
			else{
				$xml_path = BASEPRESS_DIR . 'icons/fonts/icons.xml';
			}
			return $xml_path;
		}


		/**
		 * Gets the KB slug including parents pages if exists
		 *
		 * @since 1.7.9
		 *
		 * @return string
		 */
		public function get_kb_slug( $refresh = false ){

			if( ! $refresh && $this->kb_slug ){
				return $this->kb_slug;
			}

			$entry_page = isset( $this->options['entry_page'] ) ? $this->options['entry_page'] : 0;

			/**
			 * Filters the entry page ID before use
			 */
			$entry_page = apply_filters( 'basepress_entry_page', $entry_page );

			$parents = get_ancestors( $entry_page, 'page' );
			$kb_slug = get_post_field( 'post_name', $entry_page );

			foreach( $parents as $parent ){
				$parent_slug = get_post_field( 'post_name', $parent );
				$kb_slug = $parent_slug . '/' . $kb_slug;
			}
			$this->kb_slug = $kb_slug;
			return $kb_slug;
		}

		/**
		 * Gets the KB slug including parents pages if exists
		 *
		 * @since 2.6
		 *
		 * @return string
		 */

		public function get_kb_title( $refresh = false ){

			if( ! $refresh && $this->kb_title ){
				return $this->kb_title;
			}

			$entry_page = isset( $this->options['entry_page'] ) ? $this->options['entry_page'] : 0;

			/**
			 * Filters the entry page ID before use
			 */
			$entry_page = apply_filters( 'basepress_entry_page', $entry_page );

			$parents = get_ancestors( $entry_page, 'page' );
			$kb_title = get_post_field( 'post_title', $entry_page );

			foreach( $parents as $parent ){
				$parent_slug = get_post_field( 'post_title', $parent );
				$kb_title = $parent_slug . '/' . $kb_slug;
			}
			$this->kb_title = $kb_title;
			return $kb_title;
		}



		/**
		 * Sets all the variables for the Knowledge base pages
		 *
		 * @since 2.2.0
		 *
		 * @param $query
		 * @return mixed
		 */
		public function set_page_variables( $query ){
			new Basepress_Variables( $query );
			return $query;
		}


		/**
		 * Changes the request for knowledgebase entry page to different ones depending on cases.
		 *
		 * @since 1.0.0
		 *
		 * @param $value
		 * @return mixed
		 */
		public function change_request( $request ) {

			$options = $this->get_options();

			//Unset unwanted variables for global searches. This is necessary if the search var is used in the URL
			//If page_id is left unset the pagination won't work
			if( $this->is_global_search ){
				if( isset( $request['page_id'] ) ){
					unset( $request['page_id'] );
				}
			}

			//If in single product mode change the request to show the list of sections
			if ( ! isset( $options['single_product_mode'] ) ) {
				return $request;
			}

			if ( $this->is_product	|| ( empty( $request ) && $this->is_kb_on_front_page() ) ) {

				$product = get_terms(
					array(
						'taxonomy'      => 'knowledgebase_cat',
						'parent'        => 0,
						'hide_empty'    => false,
						'meta_key'      => 'basepress_position',
						'orderby'       => 'meta_value_num',
						'order'         => 'ASC',
						'number'        => 1,
					)
				);

				if( isset( $request['page_id'] ) ){
					unset( $request['page_id'] );
				}
				$request['knowledgebase_cat'] = $product[0]->slug;
			}

			return $request;
		}


		/**
		 * Returns an array of orderby and order for sections list
		 *
		 * @since 2.10.0
		 *
		 * @return array
		 */
		public function get_posts_order(){

			$posts_order = isset( $this->options['posts_orderby'] ) ? $this->options['posts_orderby'] : 'date_asc';

			switch( $posts_order ){
				case 'date_asc':
					$orderby = array( 'menu_order' => 'ASC', 'date' => 'ASC' );
					break;
				case 'date_desc':
					$orderby = array( 'menu_order' => 'ASC', 'date' => 'DESC' );;
					break;
				case 'alpha_asc':
					$orderby = array( 'menu_order' => 'ASC', 'title' => 'ASC' );;
					break;
				case 'alpha_desc':
					$orderby = array( 'menu_order' => 'ASC', 'title' => 'DESC' );;
					break;
			}
			return apply_filters( 'basepress_posts_order', array( 'orderby' => $orderby, 'order' => '' ) );
		}


		/**
		 * Limit the number of posts in the main query for archive pages.
		 *
		 * @since 1.0.0
		 * @updated 1.6.0, 2.0.1
		 *
		 * @param $query
		 */
		public function sections_query( $query ) {
			if ( is_admin() || ! $query->is_main_query()) {
				return;
			}

			//Check if we are on a basepress archive page
			if( $this->is_section || $this->is_product || $this->is_search || $this->is_global_search || $this->is_tag ){

				$posts_per_page = isset( $this->options['section_post_limit'] ) ? $this->options['section_post_limit'] : -1;

				//If this is a search result page
				if ( isset( $query->query['s'] ) ) {

					$query->set( 'post_type', 'knowledgebase' );
					$query->set( 'posts_per_page', $posts_per_page );

					return;
				}

				$queried_object = get_queried_object();

				//If we have no queried object return. This can happen if articles have not product or sections.
				if ( ! $queried_object ) {
					return;
				}

				if ( $this->is_section || $this->is_tag ) {
					$posts_order = $this->get_posts_order();
					$orderby = $posts_order['orderby'];
					$order = $posts_order['order'];

					$query->set( 'posts_per_page', $posts_per_page );
					$query->set( 'orderby', $orderby );
					$query->set( 'order', $order );

					// if section_post_limit value is 0 then result will be 0.
					if ( empty( $this->options['section_post_limit'] ) ) {
						$query->set( 'post__in', [0] );
					}

					if( $this->is_section ){
						$query->set(
							'tax_query',
							array(
								array(
									'taxonomy'         => 'knowledgebase_cat',
									'field'            => 'slug',
									'terms'            => $query->query_vars['knowledgebase_cat'],
									'include_children' => false,
								),
							)
						);
						/**
						 * Action filter to modify the query for a single section
						 */
						do_action( 'basepress_single_section_query', $query );
					}
					if( $this->is_tag ){
						/**
						 * Action filter to modify the query for a tag
						 */
						do_action( 'basepress_tag_query', $query );
					}
				} else {
					//If this is a multi section page (is_product) we don't need posts from the main query so we reduce it to 0 results
					//since the main query cannot be eliminated completely without side effects
					$query->set( 'posts_per_page', 1 );
					$query->set( 'post__in', array(0) );
				}
			}
		}



		/**
		 * Get list of all products with their data
		 *
		 * @since 1.0.0
		 * @updated 1.7.10.1
		 *
		 * @return array
		 */
		public function get_products() {

			if( $this->products ){
				return $this->products;
			}

			$products = array();

			$terms_args = array(
				'taxonomy'   => 'knowledgebase_cat',
				'hide_empty' => true,
				'parent'     => 0,
				'meta_key'   => 'basepress_position',
				'orderby'    => 'meta_value_num',
				'order'      => 'ASC',
			);

			/**
			 * Filters the list of found knowledge bases
			 */
			$terms_args = apply_filters( 'basepress_products_terms_args', $terms_args );

			$products_terms = get_terms( $terms_args );

			foreach ( $products_terms as $product ) {

				//If the product has visibility off skip it
				$visibility = get_term_meta( $product->term_id, 'visibility', true );
				if ( ! $visibility ) {
					continue;
				}

				//Get product image
				$image = get_term_meta( $product->term_id, 'image', true );

				$image_url = isset( $image['image_url'] ) ? $image['image_url'] : '';
				$image_width = isset( $image['image_width'] ) ? $image['image_width'] : '';
				$image_height = isset( $image['image_height'] ) ? $image['image_height'] : '';

				//Get product permalink
				$permalink = get_term_link( $product->term_id, 'knowledgebase_cat' );

				$products[] = (object) array(
					'id'             => $product->term_id,
					'name'           => $product->name,
					'slug'           => $product->slug,
					'permalink'      => $permalink,
					'description'    => $product->description,
					'image'          => (object) array(
						'url'        => set_url_scheme( $image_url ),
						'width'      => $image_width,
						'height'     => $image_height,
					),
				);
			}

			$this->products = $products;

			return $products;
		}

		/**
		 * Outputs the message for when there are no products yet in the KB
		 *
		 * @since 2.1.0
		 *
		 * @return string
		 */
		public function no_products_message(){
			$output = '<div style="padding:15px;background:#c92c2c;color:white;font-family:sans-serif;font-size:16px">';
			$output .=  __( 'There are no Knowledge Bases yet!<br>Once you have at least a Knowledge Base with some content it will appear here.' , 'basepress');
			$output .= '</div>';
			return $output;
		}


		/**
		 * This function collects and returns all data for the current product
		 *
		 * @since 1.0.0
		 *
		 * @param $term_id
		 *
		 * @return null|object|void
		 */
		public function get_product( $term_id = '' ) {
			global $wp_query;

			if( empty( $term_id ) && !isset($_POST['form_key'])){

				// If we already created the product we return the cached copy
				if( $this->product ){
					return $this->product;
				}

				$queried_object = get_queried_object();

				$term = null;

				if( is_a( $queried_object, 'WP_Term' ) ){
					$term = $this->get_top_term( $queried_object );
				}

				if( is_a( $queried_object, 'WP_Post' ) ){
					$terms = wp_get_post_terms( get_the_ID(), 'knowledgebase_cat' );

					if( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						$term = $this->get_top_term( $terms[0] );
					}
				}

				if( is_search() && isset( $wp_query->query['knowledgebase_cat'] ) ){
					$term = get_terms(
						array(
							'taxonomy' => 'knowledgebase_cat',
							'slug'     => $wp_query->query['knowledgebase_cat'],
							'number'   => 1,
						)
					);
					$term = ! is_wp_error( $term ) && isset( $term[0] ) ? $term[0] : '';
				}
			}
			else{
				$term = get_term( $term_id, 'knowledgebase_cat' );
				if( empty( $term ) || is_wp_error( $term ) || 0 != $term->parent ){
					$term = null;
				}
			}

			if( ! $term || is_wp_error( $term ) ){
				$product = (object) array(
					'id'          => '',
					'name'        => '',
					'slug'        => '',
					'permalink'   => '',
					'description' => '',
					'image'       => (object) array(
						'url'    => '',
						'width'  => '',
						'height' => '',
					),
				);
				return $product;
			}

			//We also need to get the image for the product
			$image = get_term_meta( $term->term_id, 'image', true );
			$image = $image ? $image : array(
				'image_url' => '',
				'image_width' => '',
				'image_height' => '',
			);

			//Once we have all data we can join it in a single object
			$product = (object) array(
				'id'          => $term->term_id,
				'name'        => $term->name,
				'slug'        => $term->slug,
				'permalink'   => get_term_link( $term->term_id, 'knowledgebase_cat' ),
				'description' => $term->description,
				'image'       => (object) array(
					'url'    => set_url_scheme( $image['image_url'] ),
					'width'  => $image['image_width'],
					'height' => $image['image_height'],
				),
			);

			$this->product = $product;
			return $product;
		}


		/**
		 * Returns the active product on single product mode
		 *
		 * @since 1.7.6
		 * 
		 * @return mixed
		 */
		public function get_active_product_id(){
			
			$active_product_id = false;

			if( isset( $this->options['single_product_mode'] ) ){
				$active_product = get_terms(
					array(
						'taxonomy'   => 'knowledgebase_cat',
						'parent'     => 0,
						'hide_empty' => false,
						'meta_key'   => 'basepress_position',
						'orderby'    => 'meta_value',
						'order'      => 'ASC',
						'number'     => 1,
						'fields'     => 'ids',
					)
				);
				if( $active_product && ! is_wp_error( $active_product )){
					$active_product_id = $active_product[0];
				}
			}
			
			return $active_product_id;
		}


		/**
		 * Recursive function to find the top level term which is the Product
		 *
		 * @since 1.0.0
		 * @updated 1.7.6
		 *
		 * @param $term
		 * @return mixed
		 */
		public function get_top_term( $term ) {
			if( ! is_a( $term, 'WP_Term' ) ){
				return null;
			}

			if( 'knowledgebase_cat' != $term->taxonomy ){
				return null;
			}

			if( 0 == $term->parent ) return $term;
			
			while( 0 != $term->parent ){
				$term = get_term( $term->parent, 'knowledgebase_cat' );
			}
			
			return $term;
		}




		/**
		 * This function collects and returns all sections for a product including the posts for each section.
		 * The posts collected will be no more than the limit set on the option screen.
		 *
		 * @since 1.0.0
		 *
		 * @return array|null
		 */
		public function get_sections() {

			//Get the queried object
			$queried_object = get_queried_object();

			if ( $this->is_product ) {
				if ( $this->sections ) {
					return $this->sections;
				}
				return $this->get_multi_sections( $queried_object );
			} else {
				if ( $this->single_section ) {
					return $this->sections;
				}
				return $this->get_single_section( $queried_object );
			}
		}



		/**
		 * Builds the sections for a multi sections view.
		 *
		 * @since 1.0.0
		 *
		 * @updated 1.7.8, 1.7.11, 1.8.10, 2.0.1
		 *
		 * @param $term
		 * @return array
		 */
		public function get_multi_sections( $term ){

			if( ! $term ){
				return array();
			}

			$sections = array();
			$options = get_option( 'basepress_settings' );

			//Get the sections(s)
			$terms_args = array(
				'taxonomy'    => 'knowledgebase_cat',
				'hide_empty'  => true,
				'parent'      => $term->term_id,
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
				'orderby'     => 'meta_value_num',
				'order'       => 'ASC'
			);

			/**
			 * Filters the list of found knowledge bases
			 */
			$terms_args = apply_filters( 'basepress_sections_terms_args', $terms_args );

			$terms = get_terms( $terms_args );

			//We can now iterate over each section and load its data
			foreach( $terms as $section ){

				$sections[$section->slug] = $this->get_section_data( $section );
				$posts_order = $this->get_posts_order();
				$orderby = $posts_order['orderby'];
				$order = $posts_order['order'];

				//Get section's posts
				$args = array(
					'post_type'      => 'knowledgebase',
					'posts_per_page' => $options[ 'sections_post_limit' ],
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

				// if sections_post_limit value is 0 then result will be 0.
				if ( empty( $options[ 'sections_post_limit' ] ) ) {
					$args['post__in'] = [0];
				}

				/**
				 * Filter to modify the query for multi sections
				 */
				$args = apply_filters( 'basepress_multi_section_query', $args );

				$section_posts = new WP_Query( $args );

				//Get section's posts count including sub-sections
				$sections[$section->slug]->posts_count = $this->get_section_post_count( $section );

				//Determine the number of sub-sections to list
				$children_terms_count_limit = ( ! empty( $options['sections_post_limit'] ) ? $options['sections_post_limit'] - $section_posts->found_posts : 0 );

				if( $children_terms_count_limit > 0 ){
					//Get direct sub-sections
					$children_terms = get_terms(
						array(
							'taxonomy'   => 'knowledgebase_cat',
							'hide_empty' => true,
							'parent'     => $section->term_id,
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
							'orderby'    => 'meta_value_num',
							'order'      => 'ASC',
							'number'     => $children_terms_count_limit
						)
					);
				}
				else{
					$children_terms = array();
				}

				//Add the list of sub-sections to the parent section
				$sub_sections = array();
				foreach( $children_terms as $sub_section ){
					$sub_section_post_count = $this->get_section_post_count( $sub_section );
					if( $sub_section_post_count ){
						//Get the sub-section data
						$sub_sections[ $sub_section->slug ] = $this->get_section_data( $sub_section );
					}
				}

				$sections[ $section->slug ]->subsections = $sub_sections;

				if( empty( $sections[$section->slug]->posts_count ) && empty( $sections[ $section->slug ]->subsections ) ){
					unset( $sections[$section->slug] );
					continue;
				}

				//Get section's posts
				if( $section_posts->have_posts() ){

					while( $section_posts->have_posts() ){
						$section_posts->the_post();

						//Get the post object
						$the_post = get_post();

						//Add the icon to the post object
						$post_icon = get_post_meta( get_the_ID(), 'basepress_post_icon', true );
						$the_post->icon = $post_icon ? $post_icon : $this->icons->post->default;
						//Add the post object to the section
						$sections[ $section->slug ]->posts[] = $the_post;
					}
				}
				wp_reset_postdata();
			}

			return $this->sections = $sections;
		}



		/**
		 * Builds the section for a single section view
		 *
		 * @since 1.0.0
		 *
		 * @updated 1.7.8, 1.7.11, 1.8.10, 2.0.1
		 */
		public function get_single_section( $term ){

			//If the term is a product return. This can happen if articles have no section set.
			if( ! $term || $term->parent == 0 ){
				return array();
			}

			$section[$term->slug] = $this->get_section_data( $term );
			$section[$term->slug]->sub_sections = $this->get_multi_sections( $term );
			$section[$term->slug]->posts_count = $term->count;

			if( have_posts() ){
				while( have_posts() ){
					the_post();
					//Get the post object
					$the_post = get_post();

					//Add the icon to the post object
					$post_icon = get_post_meta( get_the_ID(), 'basepress_post_icon', true );
					$the_post->icon = $post_icon ? $post_icon : $this->icons->post->default;

					//Add the post object to the section
					$section[$term->slug]->posts[] = $the_post;
				}
				wp_reset_postdata();
			}
			$this->sections = $section[$term->slug]->sub_sections;
			return $this->single_section = $section;
		}


		/**
		 * Retrives the WP_Term for the current tag
		 *
		 * @since 2.7.0
		 *
		 * @return array|false|WP_Term
		 */
		public function get_tag(){
			$tag_slug = get_query_var( 'knowledgebase_tag' );
			$term = get_term_by( 'slug', $tag_slug, 'knowledgebase_tag' );

			return $term;
		}

		/**
		 * Builds the Tag for a single tag view
		 *
		 * @since 2.7.0
		 *
		 * @return object|null
		 */
		public function get_articles_by_tag(){

			if( $this->is_tag ){

				if( isset( $this->tag ) ){
					return $this->tag;
				}

				$term = $this->get_tag();

				if( $term ){
					$tag = ( object )array(
						'id'          => $term->term_id,
						'name'        => $term->name,
						'slug'        => $term->slug,
						'permalink'   => get_term_link( $term->term_id, 'knowledgebase_tag' ),
						'description' => $term->description,
						'posts_count' => $term->count,
						'posts'       => array(),
					);

					$args = array(
						'post_type' => 'knowledgebase',
						'tax_query' => array(
							array(
								'taxonomy' => 'knowledgebase_tag',
								'field' => 'term_id',
								'terms' => $term->term_id
							)
						)
					);
					$term_posts = new WP_Query( $args );

					if( $term_posts->have_posts() ){
						while( $term_posts->have_posts() ){
							$term_posts->the_post();
							//Get the post object
							$the_post = get_post();

							//Add the icon to the post object
							$post_icon = get_post_meta( get_the_ID(), 'basepress_post_icon', true );
							$the_post->icon = $post_icon ? $post_icon : $this->icons->post->default;

							//Add the post object to the section
							$tag->posts[] = $the_post;
						}
						wp_reset_postdata();
					}
				}
				else{
					$tag = ( object )array(
						'id'          => '',
						'name'        => '',
						'slug'        => '',
						'permalink'   => '',
						'description' => '',
						'posts_count' => '',
						'posts'       => array(),
					);
				}
				return $this->tag = $tag;
			}

		}


		/**
		 * Get all section data in one object
		 *
		 * @since 1.8.10
		 *
		 * @param $section
		 * @return object
		 */
		private function get_section_data( $section ){

			$meta = get_term_meta( $section->term_id );
			$icon = isset( $meta['icon'][0] )  && $meta['icon'][0] ? $meta['icon'][0] : $this->icons->sections->default;
			$image = isset( $meta['image'][0] ) ? $meta['image'][0] : '';
			$image = maybe_unserialize( $image);
			$image['image_url'] = isset( $image['image_url'] ) ? set_url_scheme( $image['image_url'] ) : [];

			return ( object ) array(
				'id'           => $section->term_id,
				'name'         => $section->name,
				'slug'         => $section->slug,
				'permalink'    => get_term_link( $section->term_id, 'knowledgebase_cat'),
				'description'  => $section->description,
				'icon'         => $icon,
				'default_icon' => $this->icons->sections->default,
				'image'        => $image,
				'posts_count'  => $section->count,
				'posts'        => array(),
			);

		}



		/**
		 * Returns the amount of posts in a section including the sub-sections articles
		 *
		 * @since 1.8.10
		 *
		 * @param $section
		 * @return mixed
		 */
		private function get_section_post_count( $section ){
			//Count section's posts including sub-sections
			$post_count_args = array(
				'post_type'       => 'knowledgebase',
				'posts_per_page'	=> -1,
				'fields'          => 'ids',
				'tax_query'       => array(
					array(
						'taxonomy' => 'knowledgebase_cat',
						'field'    => 'term_id',
						'terms'    => $section->term_id,
						'include_children' => true,
					)
				)
			);

			$posts_count_query = new WP_Query( $post_count_args );
			$post_count = $posts_count_query->found_posts;

			/**
			 * Filter the number of posts for the current query
			 * @since 2.3.0
			 */
			$post_count = apply_filters( 'get_section_post_count_args', $post_count, $section );
			return $post_count;
		}


		/**
		 * Generates the breadcrumbs
		 *
		 * @since 1.0.0
		 *
		 * @updated 2.5.0
		 */
		public function get_breadcrumbs(){

			//if the breadcrumbs are used outside of the knowledge base return;
			if( ! $this->is_knowledgebase ) return;

			$entry_page_id = isset( $this->options['entry_page'] ) ? $this->options['entry_page'] : false;

			$breadcrumbs_list = array();
			$entry_page_link = $entry_page_id ?	get_page_link( $entry_page_id ) : '';
			$entry_page_title = isset( $this->options['breadcrumbs_kb_name'] ) ? sanitize_text_field( $this->options['breadcrumbs_kb_name'] ) : '';
			$separator = isset( $this->icons->breadcrumbs->icon ) ? $this->icons->breadcrumbs->icon : '';
			if( is_array( $separator ) ){
				$separator = ! empty( $separator ) ? $separator[0] : '';
			}

			//Home link
			if( isset( $this->options['breadcrumbs_include_home'] ) ){
				$home_link = get_home_url();
				$home_title = isset( $this->options['breadcrumbs_home_text'] ) && $this->options['breadcrumbs_home_text'] ? $this->options['breadcrumbs_home_text'] : 'Home';
				$breadcrumbs_list[] = array( 'link' => $home_link, 'title' => $home_title, 'context' => 'home' );
			}

			//Parent pages
			if( isset( $this->options['breadcrumbs_include_parent'] ) ){
				$parents = get_ancestors( $entry_page_id, 'page' );

				foreach( $parents as $parent_id ){
					$parent_link = get_permalink( $parent_id );
					$parent_title = get_post_field( 'post_title', $parent_id );
					$breadcrumbs_list[] = array( 'link' => $parent_link, 'title' => $parent_title, 'context' => 'parent-pages' );
				}
			}

			//Entry page
			$breadcrumbs_list[] = array( 'link' => $entry_page_link, 'title' => $entry_page_title, 'context' => 'entry-page' );

			//Taxonomies Terms
			$queried_object = get_queried_object();

			if( $queried_object ){
				if( is_a( $queried_object, 'WP_Term' ) && 'knowledgebase_tag' !== $queried_object->taxonomy ){
					$tax_term = $queried_object;
				}
				if( is_a( $queried_object, 'WP_Post' ) ){
					$tax_term = get_the_terms( get_the_ID(), 'knowledgebase_cat' );
					$tax_term = ! empty( $tax_term )? $tax_term[0] : false;
				}

				if( ! empty( $tax_term ) ){
					$terms = $this->get_sections_tree( $tax_term );

					foreach( $terms as $index => $term ){
						//If single product mode is used skip the product
						if( $term->parent == 0 && isset( $this->options['single_product_mode'] ) )
							continue;
						$term_link = get_term_link( $term->term_id, 'knowledgebase_cat' );
						$term_title = $term->name;
						$term_context = $term->parent == 0 ? 'kb' : 'section-' . $index;
						$breadcrumbs_list[] = array( 'link' => $term_link, 'title' => $term_title, 'context' => $term_context );
					}
				}
			}

			//Articles
			if( is_single() ){
				$breadcrumbs_list[] = array( 'link' => get_the_permalink(), 'title' => get_the_title(), 'context' => 'article' );
			}

			//Tags
			if( $this->is_tag ){
				$tag = $this->get_tag();
				if( ! empty ( $tag) ){
					$tag_link = get_term_link( $tag->term_id, 'knowledgebase_tag' );
					$breadcrumbs_list[] = array( 'link' => $tag_link, 'title' => $tag->name, 'context' => 'tag' );
				}
			}

			/**
			 * Filter the breadcrumbs items
			 */
			$breadcrumbs_list = apply_filters( 'basepress_breadcrumbs_items', $breadcrumbs_list );

			/**
			 * Action to output the breadcrumbs with custom functions. If the output is empty we'll use our default.
			 */
			ob_start();
			do_action( 'basepress_breadcrumbs_output', $breadcrumbs_list, $separator );
			$breadcrumbs_output = ob_get_clean();

			//Output the breadcrumbs
			if( ! empty( $breadcrumbs_output ) ){
				echo wp_kses_post( $breadcrumbs_output );
			}
			else{
				echo '<ul class="bpress-crumbs">';

				foreach( $breadcrumbs_list as $index => $breadcrumb ){
					echo '<li>';
					if( $index ){
						echo '<span class="bpress-breadcrumb-arrow ' . esc_html( $separator ) . '"></span>';
					}
					echo '<a href="' . esc_url( $breadcrumb['link'] ) . '">' . esc_html( $breadcrumb['title'] ) . '</a>';
					echo '</li>';
				}

				echo '</ul>';
			}
		}



		/**
		 * Generates an array of sections from product to subsections
		 *
		 * @since 1.0.0
		 */
		public function get_sections_tree( $term ) {
			$tree = array();
			$tree[] = $term;

			while ( 0 != $term->parent ) {
				$term = get_term( $term->parent, 'knowledgebase_cat' );
				$tree[] = $term;
			}
			return array_reverse( $tree );
		}



		/**
		 * Replaces theme template with BasePress custom template
		 * This is a router function which will determine the correct template
		 *
		 * @since 1.0.0
		 * @updated 1.4.0
		 *
		 * @param $template
		 * @return bool|mixed
		 */
		public function basepress_page_template( $template ) {
			global $post;
			$template_name = '';

			if( ! $this->is_knowledgebase ){
				return $template;
			}

			if( $this->is_kb_404 || is_404() ){
				$template_name = '404';
			}
			else{

				$product = $this->get_product();

				//Set the template if it is an archive page
				if( $this->is_product && ! $this->is_search ){
					$sections_style = get_term_meta( $product->id, 'sections_style', true );
					if( 'list' == $sections_style['sections'] ){
						$template_name = 'sections';
					}else{
						$template_name = 'sections-boxed';
					}
				}

				if( $this->is_section && ! $this->is_search ){
					//This is the template to list all articles in a section
					$template_name = 'single-section';
				}

				if( $this->is_tag ){
					$template_name = 'tag';
				}

				if( $this->is_article || isset( $_REQUEST['preview'] ) ){
					//Set the template if is a post page
					//Get template name from post meta field
					//If it was not set we will use the full width template
					$template_name = get_post_meta( $post->ID, 'basepress_template_name', true ) ?: 'full-width';
					$options = $this->get_options();
					if( isset( $options['sidebar_position'] ) && isset( $options['force_sidebar_position'] ) ){
						$sidebar_position = $options['sidebar_position'];
						switch( $sidebar_position ){
							case 'right':
								$template_name = 'two-columns-right';
								break;
							case 'left':
								$template_name = 'two-columns-left';
								break;
							case 'none':
								$template_name = 'full-width';
								break;
						}
					}

				}
				if( $this->is_search ){
					//Set the template if is a search result page
					if( $this->is_global_search ){
						$template_name = 'global-search';
					}else{
						$template_name = 'search';
					}
				}
			}

			/**
			 * Filter to modify the template file
			 */
			$template_name = apply_filters( 'basepress_page_template', $template_name, $template );

			//If the template file exists we can load it
			$basepress_template = $this->get_theme_file_path( $template_name . '.php' );

			if ( $basepress_template ) {
				return $basepress_template;
			} else {
				return $template;
			}
		}



		/**
		 * Enables comment on articles
		 *
		 * @since 1.3.0
		 *
		 * @param $open
		 * @return bool
		 */
		public function enable_comments( $open ) {
			if ( ! ( is_singular( 'knowledgebase' ) || is_page( 'knowledgebase' )) ) {
				return $open;
			}

			if ( isset( $this->options['enable_comments'] ) ) {
				return $open;
			}
			return false;
		}



		/**
		 * Replaces theme template with BasePress custom template for comments
		 *
		 * @since 1.3.0
		 *
		 * @param $theme_template
		 * @return bool|mixed|void
		 */
		public function comments_template( $theme_template ) {

			if ( ! ( is_singular( 'knowledgebase' ) || is_page( 'knowledgebase' )) ) {
				return $theme_template;
			}

			if ( isset( $this->options['use_default_comments_template'] ) ) {
				return $theme_template;
			}

			$template = $this->get_theme_file_path( 'comments.php' );
			if ( $template ) {
				$theme_template = $template;
			}
			return $theme_template;
		}

		/*
		 *
		 * Utility functions
		 *
		 */


		/**
		 * Get Basepress template part
		 *
		 * @since 1.0.0
		 *
		 * @param $slug
		 * @param null $name
		 * @return bool
		 */
		public function get_template_part( $slug, $name = null ) {
			//Check if there is a slug for the template
			if ( $slug ) {

				$templates = array();
				$name = (string) $name;
				if ( '' !== $name ) {
					$templates[] = "{$slug}-{$name}.php";
				}

				$templates[] = "{$slug}.php";

				foreach ( $templates as $template ) {
					$template_part = $this->get_theme_file_path( 'template-parts/' . $template );
					if ( $template_part ) {
							require $template_part;
							break;
					}
				}
			}
		}


		/**
		 * Finds the path for the file
		 * It looks first in the main theme directory and then in the plugin theme directory
		 *
		 * @since 1.3.0
		 *
		 * @param $file_name
		 * @return bool|mixed
		 */
		public function get_theme_file_path( $file_name ) {
			$options = $this->options;
			$theme_name = isset( $options['theme_style'] ) ? $options['theme_style'] : '';
			$theme_file_paths = array();
			$upload_dir = wp_upload_dir();

			//Collect the possible file path for the files
			//First we check if it exists in the main theme directory then in the plugin themes directory
			$theme_file_paths [] = get_stylesheet_directory() . '/basepress/' . $theme_name . '/' . $file_name;
			$theme_file_paths [] = $upload_dir['basedir'] . '/basepress/' . $theme_name . '/' . $file_name;
			$theme_file_paths [] = BASEPRESS_DIR . 'themes/' . $theme_name . '/' . $file_name;

			foreach ( $theme_file_paths as $theme_file_path ) {
				if ( file_exists( $theme_file_path ) ) {
					return $theme_file_path;
				}
			}

			return false;
		}


		/**
		 * Finds the url for the file
		 * It looks first in the main theme directory and then in the plugin theme directory
		 *
		 * @since 1.3.0
		 *
		 * @param $file_name
		 * @return bool
		 */
		public function get_theme_file_uri( $file_name ) {
			$options = $this->options;
			$theme_name = isset( $options['theme_style'] ) ? $options['theme_style'] : '';
			$theme_file_paths = array();
			$upload_dir = wp_upload_dir();

			//Collect the possible file path for the files
			//First we check if it exists in the main theme directory then in the plugin themes directory
			$theme_file_paths [] = array( get_stylesheet_directory() . '/basepress/' . $theme_name . '/' . $file_name, get_stylesheet_directory_uri() . '/basepress/' . $theme_name . '/' . $file_name );
			$theme_file_paths [] = array( $upload_dir['basedir'] . '/basepress/' . $theme_name . '/' . $file_name, $upload_dir['baseurl'] . '/basepress/' . $theme_name . '/' . $file_name );
			$theme_file_paths [] = array( BASEPRESS_DIR . 'themes/' . $theme_name . '/' . $file_name, BASEPRESS_URI . 'themes/' . $theme_name . '/' . $file_name );

			foreach ( $theme_file_paths as $theme_file_path ) {
				if ( file_exists( $theme_file_path[0] ) ) {
					return $theme_file_path[1];
				}
			}

			return false;
		}

		/**
		 * Returns BasePress options array
		 *
		 * @since 1.0.0
		 */
		public function get_options() {
			return $this->options;
		}


		/**
		 * Returns a single option value requested by name
		 *
		 * @since 2.7.0
		 *
		 * @param $option_name
		 * @return null
		 */
		public function get_option( $option_name ){
			if( ! empty( $option_name ) ){
				return isset( $this->options[ $option_name ] ) ? $this->options[ $option_name ] : null;
			}
			return null;
		}

		/**
		 * Sets a BasePress option value
		 *
		 * @since 2.7.0
		 *
		 * @param $name
		 * @param $value
		 */
		public function set_option( $name, $value ){
			if( ! empty( $name ) ){
				$this->options[$name] = $value;
			}
		}

		/**
		 * Make KB menu item active when visiting any KB page
		 *
		 * @since 1.8.3
		 *
		 * @param $classes
		 * @param $item
		 * @return array
		 */
		public function set_menu_item_active( $classes, $item ){

			//Get Knowledge base main page ID
			$options = $this->get_options();
			$entry_page = isset( $options['entry_page'] ) ? $options['entry_page'] : '';
			$entry_page = apply_filters( 'basepress_entry_page', $entry_page );

			//If we are in any KB page
			if( $this->is_knowledgebase ){
				//Make KB menu active
				if( $item->object_id == $entry_page ){
					$classes[] = 'current-menu-item';
				}
				else{
					//And make sure no other menu item is active
					$classes = array_diff( $classes, array( 'current_page_parent' ) );
				}
			}

			// Return the corrected set of classes to be added to the menu item
			return $classes;
		}


		/**
		 * Returns true if the KB is running from the front page
		 *
		 * @since 2.0.0
		 *
		 * @return bool
		 */
		public function is_kb_on_front_page(){
			return isset( $this->options['entry_page'] ) && (int)apply_filters( 'basepress_entry_page', $this->options['entry_page'] ) == (int)get_option('page_on_front');
		}


		/**
		 * Get word boundary to use on search queries
		 * Since version 8.0.4 MySQL REGEX has changed so we need to test which implementation is using
		 *
		 * @since 2.3.0
		 *
		 * @return mixed|string|void|null
		 */
		public function get_regex_word_boundary(){
			if( $this->regex_word_boundary ){
				return $this->regex_word_boundary;
			}

			global $wpdb;

			$this->regex_word_boundary = get_option( 'basepress_regex_word_boundary', false );
			if( ! $this->regex_word_boundary ){
				$is_icu_regexp = $wpdb->query("SELECT 1 FROM DUAL WHERE 'icu regex' REGEXP '\\\\bregex';");
				$this->regex_word_boundary = $is_icu_regexp	?	'\\\\b' : '[[:<:]]';
				update_option( 'basepress_regex_word_boundary', $this->regex_word_boundary, true );
			}
			return $this->regex_word_boundary;
		}

	}


	global $basepress_utils;
	$basepress_utils = new Basepress_Utils();
}
