<?php

/**
 * This is the class that handles BasePress Settings in the admin area
 */

// Exit if called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'BasePress_Settings' ) ) {

	class BasePress_Settings {
		private $options = '';

		/**
		* Admin_Settings constructor
		*
		* @since 1.0.0
		*/
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_admin_settings_page' ), 10 );

			//Initialize options variables;
			add_action( 'init', array( $this, 'load_options' ), 10 );

			//Enqueue scripts
			add_action( 'load-toplevel_page_basepress', array( $this, 'enqueue_admin_scripts' ) );
		}

		/**
		 * Redirects to the Wizard page
		 *
		 * @since 2.7.0
		 */
		public function redirect_to_wizard(){
				wp_redirect( admin_url( '/admin.php?page=basepress_wizard' ), 302, 'BasePress Settings' );
				exit;
		}

		/**
		*  Loads and caches plugin options
		*
		*  @since 1.5.0
		*/
		public function load_options() {
			global $basepress;

			$options = get_option( 'basepress_settings' );
			if ( ! $options && is_multisite() ) {
				$basepress->init_options();
			}
			$this->options = $options;
		}


		public function enqueue_admin_scripts(){
			wp_enqueue_script( 'basepress-settings-js', plugins_url( 'js/basepress-settings.js', __FILE__ ), array(), BASEPRESS_VER, true );
		}

		/**
		* Adds BasePress settings page on admin menu
		*
		* @since 1.0.0
		*/
		public function add_admin_settings_page() {
			//Check that the user has the required capability
			if ( current_user_can( 'manage_options' ) ) {

				if( isset( $_REQUEST['basepress_enable_wizard'] ) ){
					update_option( 'basepress_run_wizard', true, true );
					$this->redirect_to_wizard();
				}
				//Add top level menu and 'Settings' submenu on admin screen
				add_menu_page( 'BasePress ' . esc_html__( 'Settings', 'basepress' ), 'BasePress', 'manage_options', 'basepress', '', 4 );
				add_submenu_page( 'basepress', 'BasePress ' . esc_html__( 'Settings', 'basepress' ), esc_html__( 'Settings', 'basepress' ), 'manage_options', 'basepress', array( $this, 'display_screen' ) );
				//Initialize the administration settings with WP settings API
				add_action( 'admin_init', array( $this, 'settings_init' ) );
			}
		}


		/**
		* Declares all settings sections and fields and fetches all options
		*
		* @since 1.0.0
		*
		* @updated 2.0.1
		*/
		public function settings_init() {

			// Check if there is a transient set during options sanitation to remind us that the knowledge base options have been changed
			// If it exist we flush the rewrite rules and delete the transient
			if( delete_transient( 'basepress_flush_rules' ) ){
				add_action( 'shutdown', function(){
					flush_rewrite_rules();
				});
			}

			//Register plugin settings
			register_setting( 'basepress_settings', 'basepress_settings', array( $this, 'basepress_settings_validate' ) );

			//Add general settings
			add_settings_section( 'basepress_general_settings', esc_html__( 'General', 'basepress' ), '', 'basepress' );

			//Add theme settings
			add_settings_section( 'basepress_theme_settings', esc_html__( 'Appearance', 'basepress' ), '', 'basepress' );

			//Add breadcrumbs settings
			add_settings_section( 'basepress_breadcrumbs_settings', esc_html__( 'Breadcrumbs', 'basepress' ), '', 'basepress' );

			//Add search settings
			add_settings_section( 'basepress_search_settings', esc_html__( 'Search', 'basepress' ), '', 'basepress' );

			//Add article comments settings
			add_settings_section( 'basepress_comments_settings', esc_html__( 'Comments', 'basepress' ), '', 'basepress' );

			/**
			 * Action to add extra settings sections
			 */
			 do_action( 'basepress_settings_sections' );

			//Add article comments settings
			add_settings_section( 'basepress_settings_import_export', esc_html__( 'Import/Export', 'basepress' ), '', 'basepress' );

			//Add settings fields for GENERAL settings
			add_settings_field( 'entry_page', esc_html__( 'Knowledge Base page', 'basepress' ), array( $this, 'entry_page_render' ), 'basepress', 'basepress_general_settings' );
			add_settings_field( 'post_count_ip_exclude', esc_html__( 'Exclude IPs from article view counter', 'basepress' ), array( $this, 'post_count_ip_exclude_render' ), 'basepress', 'basepress_general_settings' );
			add_settings_field( 'single_product_mode', esc_html__( 'Single Knowledge Base mode', 'basepress' ), array( $this, 'single_product_mode_render' ), 'basepress', 'basepress_general_settings' );
			add_settings_field( 'article_permalink_structure', esc_html__( 'Articles permalink structure', 'basepress' ), array( $this, 'article_permalink_structure_render' ), 'basepress', 'basepress_general_settings' );
			add_settings_field( 'section_permalink_structure', esc_html__( 'Sections permalink structure', 'basepress' ), array( $this, 'section_permalink_structure_render' ), 'basepress', 'basepress_general_settings' );
			add_settings_field( 'build_mode', esc_html__( 'Enable build mode', 'basepress' ), array( $this, 'build_mode_render' ), 'basepress', 'basepress_general_settings' );
			if ( ! is_multisite() ) {
				add_settings_field( 'remove_all_uninstall', esc_html__( 'Remove all content on uninstall', 'basepress' ), array( $this, 'remove_all_uninstall_render' ), 'basepress', 'basepress_general_settings' );
			}

			//Add settings fields for APPEARANCE settings
			add_settings_field( 'theme_style', esc_html__( 'Theme', 'basepress' ), array( $this, 'theme_style_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'skip_header_footer', esc_html__( 'Skip loading of header and footer', 'basepress' ), array( $this, 'skip_header_footer_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'sidebar_position', esc_html__( 'Default Sidebar Position', 'basepress' ), array( $this, 'sidebar_position_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'force_sidebar_position', esc_html__( 'Force Sidebar Position on Articles', 'basepress' ), array( $this, 'force_sidebar_position_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'kbs_choose_text', esc_html__( 'Knowledge Base "Choose" Button Text', 'basepress' ), array( $this, 'kbs_choose_text_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'sections_view_all_text', esc_html__( '"View all articles" link text', 'basepress' ), array( $this, 'sections_view_all_text_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'products_cols', esc_html__( 'Knowledge Bases Columns', 'basepress' ), array( $this, 'products_columns_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'sections_cols', esc_html__( 'Sections Columns', 'basepress' ), array( $this, 'sections_columns_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'sections_post_limit', esc_html__( 'Limit Articles count on multi sections page', 'basepress' ), array( $this, 'sections_post_limit_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'section_post_limit', esc_html__( 'Limit Articles count on single section page', 'basepress' ), array( $this, 'section_post_limit_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'show_section_icon', esc_html__( 'Show Section Icons', 'basepress' ), array( $this, 'show_section_icon_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'show_post_icon', esc_html__( 'Show Articles Icons', 'basepress' ), array( $this, 'show_post_icon_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'show_byline', esc_html__( 'Show Article byline', 'basepress' ), array( $this, 'show_byline_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'show_section_post_count', esc_html__( 'Show Articles count on Sections', 'basepress' ), array( $this, 'show_section_post_count_render' ), 'basepress', 'basepress_theme_settings' );
			add_settings_field( 'posts_orderby', esc_html__( 'Articles Order', 'basepress' ), array( $this, 'posts_orderby_render' ), 'basepress', 'basepress_theme_settings' );

			//Add settings fields for BREADCRUMBS settings

			add_settings_field( 'enable_breadcrumbs', esc_html__( 'Enable Breadcrumbs', 'basepress' ), array( $this, 'showhide_breadcrumbs_render' ), 'basepress', 'basepress_breadcrumbs_settings' );
			add_settings_field( 'breadcrumbs_kb_name', esc_html__( 'Breadcrumbs name', 'basepress' ), array( $this, 'breadcrumbs_kb_name_render' ), 'basepress', 'basepress_breadcrumbs_settings' );
			add_settings_field( 'breadcrumbs_include_home', esc_html__( 'Include Home link', 'basepress' ), array( $this, 'breadcrumbs_include_home_render' ), 'basepress', 'basepress_breadcrumbs_settings' );
			add_settings_field( 'breadcrumbs_home_text', esc_html__( 'Text for Home link', 'basepress' ), array( $this, 'breadcrumbs_home_text_render' ), 'basepress', 'basepress_breadcrumbs_settings' );
			add_settings_field( 'breadcrumbs_include_parent', esc_html__( 'Include parent pages link', 'basepress' ), array( $this, 'breadcrumbs_include_parent_render' ), 'basepress', 'basepress_breadcrumbs_settings' );

			//Add settings fields for SEARCH settings
			add_settings_field( 'show_search_suggest', esc_html__( 'Enable live search results', 'basepress' ), array( $this, 'show_search_suggest_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'min_search_suggest_screen', esc_html__( 'Disable live search results on devices smaller than', 'basepress' ), array( $this, 'min_search_suggest_screen_render' ), 'basepress', 'basepress_search_settings' ); //Since version 1.2.0
			add_settings_field( 'search_suggest_count', esc_html__( 'Max live search results', 'basepress' ), array( $this, 'search_suggest_count_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_min_chars', esc_html__( 'Minimum word length', 'basepress' ), array( $this, 'search_min_chars_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_disable_word_boundary', esc_html__( 'Enable wildcard before search terms', 'basepress' ), array( $this, 'search_disable_word_boundary_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_field_placeholder', esc_html__( 'Search field placeholder', 'basepress' ), array( $this, 'search_field_placeholder_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_submit_text', esc_html__( 'Submit button text', 'basepress' ), array( $this, 'search_submit_text_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'show_search_submit', esc_html__( 'Show search submit button', 'basepress' ), array( $this, 'show_search_submit_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'show_search_description', esc_html__( 'Show search description', 'basepress' ), array( $this, 'show_search_description_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_page_title', esc_html__( 'Search result page title', 'basepress' ), array( $this, 'search_page_title_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_page_no_results_title', esc_html__( "'No search result found' page title", 'basepress' ), array( $this, 'search_page_no_results_title_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'smartsearch_no_results_message', esc_html__( "'No search result found' message for live search", 'basepress' ), array( $this, 'smartsearch_no_results_message_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_suggest_more_text', esc_html__( 'Show all results text', 'basepress' ), array( $this, 'search_suggest_more_text_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'searchbar_style', esc_html__( 'Load css with shortcode', 'basepress' ), array( $this, 'searchbar_style_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'search_use_url_parameters', esc_html__( 'Use search parameter on URL', 'basepress' ), array( $this, 'search_use_url_parameters_render' ), 'basepress', 'basepress_search_settings' );
			add_settings_field( 'exclude_from_wp_search', esc_html__( 'Exclude KB articles from other WordPress searches', 'basepress' ), array( $this, 'exclude_from_wp_search_render' ), 'basepress', 'basepress_search_settings' );

			//Add settings fields for COMMENTS
			add_settings_field( 'enable_comments', esc_html__( 'Enable Comments', 'basepress' ), array( $this, 'enable_comments_render' ), 'basepress', 'basepress_comments_settings' );
			add_settings_field( 'use_default_comments_template', esc_html__( 'Use main theme template', 'basepress' ), array( $this, 'use_default_comments_template_render' ), 'basepress', 'basepress_comments_settings' );

			/**
			 * Action to add extra features settings fileds
			 */
			do_action( 'basepress_settings_fields' );

			add_settings_field( 'settings_import_export_notice', '', array( $this, 'settings_import_export_notice_render' ), 'basepress', 'basepress_settings_import_export' );
			add_settings_field( 'settings_import', esc_html__( 'Import Settings', 'basepress' ), array( $this, 'settings_import_render' ), 'basepress', 'basepress_settings_import_export' );
			add_settings_field( 'settings_export', esc_html__( 'Export Settings', 'basepress' ), array( $this, 'settings_export_render' ), 'basepress', 'basepress_settings_import_export' );

		}


		/*
		* General settings fields
		*/

		public function entry_page_render() {
			$options = $this->options;

			$ID = isset( $options['entry_page'] ) ? $options['entry_page'] : '';
			$ID = apply_filters( 'basepress_entry_page', $ID );

			$pages = get_pages(
				array(
					'sort_order'   => 'asc',
					'sort_column'  => 'post_title',
					'hierarchical' => 1,
					'child_of'     => 0,
					'parent'       => -1,
					'post_type'    => 'page',
					'post_status'  => 'publish',
				)
			);

			echo '<select name="basepress_settings[entry_page]">';
			echo '<option ' . selected( '', $ID, false ) . ' disabled>' . esc_html__( 'Select page', 'basepress' ) . '</option>';
			foreach ( $pages as $page ) {
				$selected = selected( $page->ID, $ID, false );
				echo '<option value="' . esc_attr( $page->ID ) . '"' . esc_html( $selected ) . '>' . esc_html( $page->post_title ) . '</option>';
			}
			echo '</select>';
			echo '<p class="description">' . esc_html__( 'Select the page containing the knowledge base shortcode.', 'basepress' ) . '</p>';
		}

		public function post_count_ip_exclude_render() {
			$options = $this->options;

			$excludes = isset( $options['post_count_ip_exclude'] ) ? $options['post_count_ip_exclude'] : '';
			echo '<textarea name="basepress_settings[post_count_ip_exclude]" rows="3" cols="50" style="resize:none;">' . esc_textarea( $excludes ) . '</textarea>';
			echo '<p class="description">' . esc_html__( 'Add multiple IP addresses separated by a space.', 'basepress' ) . '</p>';
		}

		public function single_product_mode_render() {
			$options = $this->options;

			$value = isset( $options['single_product_mode'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[single_product_mode]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function article_permalink_structure_render(){
			$options = $this->options;

			// Possible options are %knowledge_base%, %parent_sections%, %article_section%
			// Default value is '%knowledge_base%/%section%' for backward compatibility
			$value = isset( $options['article_permalink_structure'] ) ? $options['article_permalink_structure'] : '%knowledge_base%/%article_section%';
			echo '<input type="text" name="basepress_settings[article_permalink_structure]" value="' . esc_attr( $value ) . '">';
			echo '/' . esc_html__( 'article-slug', 'basepress' ) . '/';
			echo '<p class="description">' . __( 'Available tags are <code>%knowledge_base%</code>, <code>%parent_sections%</code>, <code>%article_section%</code> or <code>%none%</code>.<br>Add a forward slash between each tag. If left empty it defaults to <code>%knowledgebase%/$article_section%</code>.', 'basepress' ) . '</p>'; // phpcs:ignore
		}

		public function section_permalink_structure_render(){
			$options = $this->options;

			// Possible options are %knowledge_base%, %parent_sections%
			// Default value is '%knowledge_base%' for backward compatibility
			$value = isset( $options['section_permalink_structure'] ) ? $options['section_permalink_structure'] : '%parent_sections%';
			echo '<input type="text" name="basepress_settings[section_permalink_structure]" value="' . esc_attr( $value ) . '">';
			echo '/' . esc_html__( 'section-slug', 'basepress' ) . '/';
			echo '<p class="description">' . __( 'Available tags are <code>%knowledge_base%</code>, <code>%parent_sections%</code> or <code>%none%</code>.<br>Add a forward slash between each tag. If left empty it defaults to <code>%knowledgebase%</code>.', 'basepress' ) . '</p>'; // phpcs:ignore
		}

		public function build_mode_render() {
			$options = $this->options;

			$value = isset( $options['build_mode'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[build_mode]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . esc_html__( 'When enabled only admin users can access the knowledge base in the front end.', 'basepress' ) . '</p>';
		}

		public function remove_all_uninstall_render() {
			$options = $this->options;

			$value = isset( $options['remove_all_uninstall'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[remove_all_uninstall]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . esc_html__( 'If enabled all plugin content including Knowledge Bases, sections and articles will be deleted when the plugin is unistalled.', 'basepress' ) . '</p>';
		}


		/*
		*	Appearance settings fields
		*/

		public function theme_style_render() {
			$unique_themes = apply_filters('bp_unique_themes',array());
			$base_theme_dir = get_stylesheet_directory() . '/basepress/';
			$uploads_theme_dir = wp_upload_dir()['basedir'] . '/basepress/';
			$plugin_theme_dir = BASEPRESS_DIR . 'themes/';

			$options = $this->options;

			$set_theme = isset( $options['theme_style'] ) ? $options['theme_style'] : 0;

			$base_themes = array();
			$upload_themes = array();

			if ( file_exists( $base_theme_dir ) ) {
				$base_themes = glob( $base_theme_dir . '*', GLOB_ONLYDIR );
			}
			if ( file_exists( $uploads_theme_dir ) ) {
				$upload_themes = glob( $uploads_theme_dir . '*', GLOB_ONLYDIR );
			}
			$plugin_themes = glob( $plugin_theme_dir . '*', GLOB_ONLYDIR );
			$themes = array_merge( $plugin_themes, $base_themes, $upload_themes );

			echo '<select name="basepress_settings[theme_style]">';
			echo '<option ' . ( 0 == $set_theme ? 'selected' : '' ) . ' disabled>' . esc_html__( 'Select Theme', 'basepress' ) . '</option>';

			foreach ( $themes as $theme ) {
				$theme_dir = basename( $theme );

				if ( ! in_array( $theme_dir, $unique_themes ) ) {

					$style_css = $theme . '/css/style.css';
					$style_css_relative = str_replace( get_home_path(), home_url( '/' ), $style_css );
					if( ! file_exists( $style_css ) ) continue;
					$theme_css_response_args = array( 'limit_response_size' => 200 );
					$theme_css_response = wp_safe_remote_get( $style_css_relative, $theme_css_response_args );
					$theme_css = wp_remote_retrieve_body( $theme_css_response );
					preg_match( '/Theme Name:\s*(.+)/i', $theme_css, $theme_name );
					$selected = selected( $theme_dir, $set_theme, false );

					echo '<option value="' . esc_attr( $theme_dir ) . '"' . esc_html( $selected ) . '>' . esc_html( $theme_dir ) . '</option>';
					$unique_themes[] = $theme_dir;
				}
			}
			echo '</select>';
			echo '<p class="description">' . esc_html__( 'After saving the settings, further customizations for the selected theme are available under the BasePress menu.', 'basepress' ) . '</p>';
		}

		public function skip_header_footer_render(){
			$options = $this->options;

			$value = isset( $options['skip_header_footer'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[skip_header_footer]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . esc_html__( "BasePress templates load the header and footer from your theme using WordPress functions get_header() and get_footer(). If your theme already loads the header and footer use this option to prevent BasePress from loading them again.", 'basepress' ) . '</p>';
		}

		public function sidebar_position_render() {
			$options = $this->options;

			$value = isset( $options['sidebar_position'] ) ? $options['sidebar_position'] : '';
			echo '<select name="basepress_settings[sidebar_position]" id="basepress_sidebar_position">';
			echo '<option value ="" ' . selected( '', $value, false ) . '>' . esc_html__( 'Select sidebar position', 'basepress' ) . '</option>';
			echo '<option value="right" ' . selected( 'right', $value, false ) . '>' . esc_html__( 'Right', 'basepress' ) . '</option>';
			echo '<option value="left" ' . selected( 'left', $value, false ) . '>' . esc_html__( 'Left', 'basepress' ) . '</option>';
			echo '<option value="none" ' . selected( 'none', $value, false ) . '>' . esc_html__( 'None', 'basepress' ) . '</option>';
			echo '</select>';
		}

		public function force_sidebar_position_render(){
			$options = $this->options;

			$enabled = isset( $options['sidebar_position'] ) && '' !== $options['sidebar_position'];
			$value = isset( $options['force_sidebar_position'] ) && $enabled ? 1 : 0;

			echo '<input id="basepress_force_sidebar" type="checkbox" name="basepress_settings[force_sidebar_position]" value="1"' . checked( $value, 1, false ) . disabled( ! $enabled, true, false ) . '>';
			echo '<p class="description">' . __( 'By default you can choose a different sidebar position for each article.<br>When this option is enabled all articles will be displayed with the default sidebar position.', 'basepress' ) . '</p>';
			?>
			<script>
				jQuery( '#basepress_sidebar_position' ).change( function(){
					$selection = jQuery( this ).val();
					$disabled = '' == $selection ? true : false;
					jQuery( '#basepress_force_sidebar' ).prop('disabled', $disabled );
				});
			</script>
			<?php
		}

		public function kbs_choose_text_render() {
			$options = $this->options;

			$value = isset( $options['kbs_choose_text'] ) ? $options['kbs_choose_text'] : '';
			echo '<input type="text" name="basepress_settings[kbs_choose_text]" value="' . esc_attr( $value ) . '">';
		}

		public function sections_view_all_text_render(){
			$options = $this->options;

			$value = isset( $options['sections_view_all_text'] ) ? $options['sections_view_all_text'] : '';
			echo '<input type="text" name="basepress_settings[sections_view_all_text]" value="' . esc_attr( $value ) . '">';
			echo '<p class="description">' . __( 'The text appears under the list of articles in the section. Type the singular and plural form for "View all articles" separated by a vertical bar "|".<br>Use %number% to show the number of articles.<br>Default: View %number% article | View all %number% articles.', 'basepress' ) . '</p>'; //phpcs:ignore
		}

		public function products_columns_render() {
			$options = $this->options;

			$value = isset( $options['products_cols'] ) ? $options['products_cols'] : '';
			echo '<input type="number" name="basepress_settings[products_cols]" value="' . esc_attr( $value ) . '" min="1" max="4">';
		}

		public function sections_columns_render() {
			$options = $this->options;

			$value = isset( $options['sections_cols'] ) ? $options['sections_cols'] : '';
			echo '<input type="number" name="basepress_settings[sections_cols]" value="' . esc_attr( $value ) . '" min="1" max="4">';
		}

		public function sections_post_limit_render() {
			$options = $this->options;

			$value = isset( $options['sections_post_limit'] ) ? $options['sections_post_limit'] : 0;
			echo '<input type="number" name="basepress_settings[sections_post_limit]" value="' . ( ! empty( esc_attr( $value ) ) ? esc_attr( $value ) : 0 ) . '" min="-1" max="999">';
		}

		public function section_post_limit_render() {
			$options = $this->options;

			$value = isset( $options['section_post_limit'] ) ? $options['section_post_limit'] : 0;
			echo '<input type="number" name="basepress_settings[section_post_limit]" value="' . ( ! empty( esc_attr( $value ) ) ? esc_attr( $value ) : 0 ) . '" min="-1" max="999">';
		}

		public function show_section_icon_render() {
			$options = $this->options;

			$value = isset( $options['show_section_icon'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_section_icon]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function show_post_icon_render() {
			$options = $this->options;

			$value = isset( $options['show_post_icon'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_post_icon]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function show_byline_render() {
			$options = $this->options;

			$value = isset( $options['show_byline'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_byline]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function show_section_post_count_render() {
			$options = $this->options;

			$value = isset( $options['show_section_post_count'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_section_post_count]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function posts_orderby_render(){
			$options = $this->options;

			$value = isset( $options['posts_orderby'] ) ? $options['posts_orderby'] : 'date_asc';
			echo '<select name="basepress_settings[posts_orderby]">';
			echo '<option value ="date_asc" ' . selected( 'date_asc', $value, false ) . '>' . esc_html__( 'Date ascending', 'basepress' ) . '</option>';
			echo '<option value="date_desc" ' . selected( 'date_desc', $value, false ) . '>' . esc_html__( 'Date descending', 'basepress' ) . '</option>';
			echo '<option value="alpha_asc" ' . selected( 'alpha_asc', $value, false ) . '>' . esc_html__( 'Alphabetical ascending', 'basepress' ) . '</option>';
			echo '<option value="alpha_desc" ' . selected( 'alpha_desc', $value, false ) . '>' . esc_html__( 'Alphabetical descending', 'basepress' ) . '</option>';
			echo '</select>';
		}


		/*
		 * Breadcrumbs settings
		 */
		public function breadcrumbs_kb_name_render() {
			$options = $this->options;

			$name = isset( $options['breadcrumbs_kb_name'] ) ? $options['breadcrumbs_kb_name'] : '';
			echo '<input type="text" name="basepress_settings[breadcrumbs_kb_name]" value="' . esc_attr( $name ) . '">';
			echo '<p class="description">' . esc_html__( 'This is the name used in the breadcrumbs for the knowledge base entry page.', 'basepress' ) . '</p>';
		}

		public function showhide_breadcrumbs_render(){
			$options = $this->options;

			$value = isset( $options['showhide_breadcrumbs'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[showhide_breadcrumbs]" value="1"' . checked( $value, 1, false ) . '>';
		}


		public function breadcrumbs_include_home_render(){
			$options = $this->options;

			$value = isset( $options['breadcrumbs_include_home'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[breadcrumbs_include_home]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function breadcrumbs_home_text_render(){
			$options = $this->options;

			$name = isset( $options['breadcrumbs_home_text'] ) ? $options['breadcrumbs_home_text'] : '';
			echo '<input type="text" name="basepress_settings[breadcrumbs_home_text]" value="' . esc_attr( $name ) . '">';
			echo '<p class="description">' . esc_html__( 'This is the name used in the breadcrumbs for the Home page. Default is Home.', 'basepress' ) . '</p>';
		}

		public function breadcrumbs_include_parent_render(){
			$options = $this->options;

			$value = isset( $options['breadcrumbs_include_parent'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[breadcrumbs_include_parent]" value="1"' . checked( $value, 1, false ) . '>';
		}

		/*
		*	Search settings fields
		*/

		public function show_search_suggest_render() {
			$options = $this->options;

			$value = isset( $options['show_search_suggest'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_search_suggest]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . esc_html__( 'Display live search results while typing on the search bar.', 'basepress' ) . '</p>';
		}


		/**
		* @since version 1.2.0
		*/
		public function min_search_suggest_screen_render() {
			$options = $this->options;

			$value = isset( $options['min_search_suggest_screen'] ) ? $options['min_search_suggest_screen'] : '';
			echo '<input type="number" name="basepress_settings[min_search_suggest_screen]" value="' . esc_attr( $value ) . '" min="1">';
			echo '<p class="description">' . __( 'Insert the minimum screen <u>height</u> in px.', 'basepress' ) . '</p>'; //phpcs:ignore
		}

		public function search_suggest_count_render() {
			$options = $this->options;

			$value = isset( $options['search_suggest_count'] ) ? $options['search_suggest_count'] : '';
			echo '<input type="number" name="basepress_settings[search_suggest_count]" value="' . esc_attr( $value ) . '" min="1">';
			echo '<p class="description">' . esc_html__( 'Maximum number of results to display during a live search.', 'basepress' ) . '</p>';
		}

		public function search_min_chars_render(){
			$options = $this->options;

			$value = isset( $options['search_min_chars'] ) ? $options['search_min_chars'] : 3;
			echo '<input type="number" name="basepress_settings[search_min_chars]" value="' . esc_attr( $value ) . '" min="1" max="9">';
			echo '<p class="description">' . esc_html__( 'Any search term shorter than this value will be omitted from the search.', 'basepress' ) . '</p>';
		}

		public function show_search_submit_render() {
			$options = $this->options;

			$value = isset( $options['show_search_submit'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[show_search_submit]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function show_search_description_render() {
			$options = $this->options;

			$value = isset( $options['show_search_description'] ) ? 1 : 0;
			
			echo '<input type="checkbox" name="basepress_settings[show_search_description]" value="1"'.checked( $value, 1, false ) . '>';
		}

		public function search_submit_text_render() {
			$options = $this->options;

			$value = isset( $options['search_submit_text'] ) ? $options['search_submit_text'] : '';
			echo '<input type="text" name="basepress_settings[search_submit_text]" value="' . esc_attr( $value ) . '">';
		}

		public function search_field_placeholder_render() {
			$options = $this->options;

			$value = isset( $options['search_field_placeholder'] ) ? $options['search_field_placeholder'] : '';
			echo '<input type="text" name="basepress_settings[search_field_placeholder]" value="' . esc_attr( $value ) . '">';
		}

		/**
		* @since 1.2.0
		*/
		public function search_page_title_render() {
			$options = $this->options;

			$value = isset( $options['search_page_title'] ) ? $options['search_page_title'] : '';
			echo '<input type="text" name="basepress_settings[search_page_title]" value="' . esc_attr( $value ) . '">';
			echo '<p class="description">' . esc_html__( 'This is the title for the search page. Use %number% to include the number of found articles in the text.', 'basepress' ) . '</p>';
		}

		/**
		* @since 1.2.1
		*/
		public function search_page_no_results_title_render() {
			$options = $this->options;

			$value = isset( $options['search_page_no_results_title'] ) ? $options['search_page_no_results_title'] : '';
			echo '<input type="text" name="basepress_settings[search_page_no_results_title]" value="' . esc_attr( $value ) . '">';
			echo '<p class="description">' . esc_html__( 'This is the title for the search page when no results are found.', 'basepress' ) . '</p>';
		}

		public function smartsearch_no_results_message_render() {
			$options = $this->options;

			$value = isset( $options['smartsearch_no_results_message'] ) ? $options['smartsearch_no_results_message'] : '';
			echo '<input type="text" name="basepress_settings[smartsearch_no_results_message]" value="' . esc_attr( $value ) . '">';
			echo '<p class="description">' . esc_html__( 'This is the message for the Smart search when no results are found.', 'basepress' ) . '</p>';
		}



		/**
		* @since 1.2.0
		*/
		public function search_suggest_more_text_render() {
			$options = $this->options;

			$value = isset( $options['search_suggest_more_text'] ) ? $options['search_suggest_more_text'] : '';
			echo '<input type="text" name="basepress_settings[search_suggest_more_text]" value="' . esc_attr( $value ) . '">';
			echo '<p class="description">' . esc_html__( 'This text appears at the bottom of the search bar suggestions. Use %number% to include the number of found articles in the text.', 'basepress' ) . '</p>';
		}

		/**
		* Since 1.4.0
		*/
		public  function searchbar_style_render() {
			$options = $this->options;

			$value = isset( $options['searchbar_style'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[searchbar_style]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . __( 'You can add a search bar anywhere in your website using the shortcode [basepress-search].<br>Check this option to load the CSS style for the search bar or leave it unchecked to use your own CSS style.', 'basepress' ) . '</p>'; //phpcs:ignore
		}


		public function search_disable_word_boundary_render(){
			$options = $this->options;

			$value = isset( $options['search_disable_word_boundary'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[search_disable_word_boundary]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . __( 'By default searches are performed with a wildcard after each term. Searching for "<b><u>app</u></b>" will find "<b><u>app</u></b>le" but not "pine<b><u>app</u></b>le". If you want to include a wildcard before each term as well or your content is in a language that uses no spaces between words, like Chinese or Japanese, enable this option.', 'basepress' ) . '</p>'; //phpcs:ignore
		}

		public function search_use_url_parameters_render(){
			$options = $this->options;

			$value = isset( $options['search_use_url_parameters'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[search_use_url_parameters]" value="1"' . checked( $value, 1, false ) . '>';
			echo '<p class="description">' . esc_html__( 'When enabled the URL will contain the search parameters instead of the search base. Like http://www.your-domain.com/knowledge-base/?s=search+term', 'basepress' ) . '</p>';
		}

		public function exclude_from_wp_search_render(){
			$options = $this->options;

			$value = isset( $options['exclude_from_wp_search'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[exclude_from_wp_search]" value="1"' . checked( $value, 1, false ) . '>';
		}

		/*
		* Comments fields
		*/

		public function enable_comments_render() {
			$options = $this->options;

			$value = isset( $options['enable_comments'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[enable_comments]" value="1"' . checked( $value, 1, false ) . '>';
		}

		public function use_default_comments_template_render() {
			$options = $this->options;

			$value = isset( $options['use_default_comments_template'] ) ? 1 : 0;
			echo '<input type="checkbox" name="basepress_settings[use_default_comments_template]" value="1"' . checked( $value, 1, false ) . '>';
		}


		public function settings_import_export_notice_render(){
			echo '<p class="description">' . esc_html__( 'Here you can transfer the BasePress settings. If you need to migrate the whole knowledge base content please use the', 'basepress' ) . ' <a href="https://wordpress.org/plugins/basepress-migration-tools/" target="_blank">BasePress Migration tools</p>';
		}

		public function settings_import_render(){
			?>
			<textarea name="basepress_settings_import" rows="8" placeholder="<?php esc_attr_e( 'Paste your settings and click Import. This action cannot be undone.', 'basepress' ); ?>"></textarea>
			<br>
			<button type="submit" class="button button-primary"><?php esc_html_e( 'Import', 'basepress' ); ?></button>
		<?php
		}

		public function settings_export_render(){
			$options = $this->options;
			?>
			<textarea rows="8" onclick="this.focus();this.select()" readonly="readonly"><?php echo esc_textarea( wp_json_encode( $options ) ) ; ?></textarea>
			<?php
		}


		/**
		* This function validates all options fields before saving them on DB
		*
		* @since 1.0.0
		* @updated 1.7.6, 1.8.0
		*
		* @param $input
		* @return mixed
		*/
		public function basepress_settings_validate( $input ) {

			if( isset( $_REQUEST['basepress_settings_import'] ) && ! empty( $_REQUEST['basepress_settings_import'] ) ){
				$import = json_decode( stripslashes( $_REQUEST['basepress_settings_import'] ), true ); // phpcs:ignore

				if( ! empty( $import ) ){
					$input = $import;
				}
			}

			// Sanitize all settings values
			foreach( $input as $index => $value ){
				if( empty( $value ) ){
					$input[$index] = '';
				}
				else{
					switch( $index ){
						case 'feedback_privacy_notice':
						case 'feedback_submit_success_text':
						case 'feedback_submit_fail_text':
						case 'feedback_notify_admin':
						case 'feedback_notice_email_message':
							$input[ $index ] = $value;
							break;
						default: $input[ $index ] = $value;
					}
				}
			}

			//Get new entry page and filter it if necessary
			$new_entry_page = isset( $input['entry_page'] ) ? $input['entry_page'] : 0;
			$new_entry_page = apply_filters( 'basepress_settings_entry_page_save', $new_entry_page );

			//Update new entry page
			$input['entry_page'] = $new_entry_page;

			//Set a transient to flush rewrite rules on reload
			set_transient( 'basepress_flush_rules', 1 );

			//Disable the Wizard as the setup was done manually
			delete_option( 'basepress_run_wizard' );

			//Clear the regex word boundary option so it can be updated on next load.
			//This will resolve cases where the DB version has changed.
			delete_option( 'basepress_regex_word_boundary' );

			do_action( 'basepress_after_settings_validate', $input );

			return $input;
		}



		/**
		* Displays the settings page in the admin area
		*
		* @since 1.0.0
		*/
		public function display_screen() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'basepress' ) );
			}

			echo '<div class="wrap">';
			echo '<h1>BasePress ' . esc_html__( 'Settings', 'basepress' ) . '</h1>';

			echo '<form method="post" action="options.php">';

			settings_fields( 'basepress_settings' );

			echo '<div class="basepress-tabs">';
			// We use a custom function to render the sections
			$this->do_settings_sections( 'basepress' );
			echo '</div>';

			$attr_options = [];
			$other_attributes = apply_filters( 'basepress_save_settings', $attr_options );
			submit_button( esc_html__( 'Save Settings', 'basepress' ), 'primary', 'submit', true, $other_attributes );
			echo '</form>';
			echo '</div>';
		}


		/**
		* Custom function based on WP do_settings_page function
		*
		* @since 1.0.0
		*
		* @param $page
		*/
		private function do_settings_sections( $page ) {
			global $wp_settings_sections, $wp_settings_fields;

			if ( ! isset( $wp_settings_sections[ $page ] ) ) {
				return;
			}

			settings_errors();
			
			foreach ( (array) $wp_settings_sections[ $page ] as $section ) {

				if( isset( $_REQUEST['tab'] ) && ! empty( $_REQUEST['tab'] ) ){
					$checked = $_REQUEST['tab'] == $section['id'] ? ' checked="checked" ' : '';
				}
				else{
					$checked = 'basepress_general_settings' == $section['id'] ? ' checked="checked" ' : '';
				}

				echo '<div class="basepress-tab">';
				echo '<input name="css-tabs" id="' . esc_attr( $section['id'] ) . '"' . esc_attr( $checked ) . 'class="basepress-tab-switch" type="radio">';
				echo '<label for="' . esc_attr( $section['id'] ) . '" class="basepress-tab-label">' . esc_html( $section['title'] ) . '</label>';

				if ( $section['callback'] ) {
					call_user_func( $section['callback'], $section );
				}

				if ( ! isset( $wp_settings_fields )
					|| ! isset( $wp_settings_fields[ $page ] )
					|| ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
					continue;
				}
				echo '<div class="basepress-tab-content">';
				echo '<h2 class="settings-title">' . esc_html( $section['title'] ) . '</h2>';
				echo '<table class="form-table">';
				do_settings_fields( $page, $section['id'] );
				echo '</table>';
				echo '</div>';
				echo '</div>';
			}
		}
	}

	new BasePress_Settings();
}
