<?php

/**
 * This is the class that adds and handles BasePress custom post type and taxonomies
 */
// Exit if called directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !class_exists( 'Basepress_CPT' ) ) {
    class Basepress_CPT {
        private $options;

        private $kb_slug;

        private $bulk_edit_id_counter = 1;

        /**
         * basepress_cpt constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {
            global $basepress_utils;
            add_filter( 'request', array($this, 'set_correct_request_for_item'), 5 );
            //Add rewrite rules to handle links properly
            add_filter( 'rewrite_rules_array', array($this, 'rewrite_rules') );
            $this->add_rewrite_tags();
            add_filter( 'knowledgebase_cat_rewrite_rules', array($this, 'clean_rewrite_rules') );
            add_filter( 'knowledgebase_rewrite_rules', array($this, 'clean_rewrite_rules') );
            //Add the product and section name on the post permalink
            add_filter(
                'post_type_link',
                array($this, 'post_permalinks'),
                1,
                2
            );
            //Canonical redirections
            add_filter( 'request', array($this, 'canonical_redirect'), 10 );
            //Add the product name on the archive permalink
            add_filter(
                'term_link',
                array($this, 'sections_permalink'),
                99,
                3
            );
            add_filter(
                'term_link',
                array($this, 'tag_permalink'),
                99,
                3
            );
            //Add Product filter dropdown on post list table
            add_action( 'restrict_manage_posts', array($this, 'filter_list_dropdowns') );
            //Filter Articles by products and sections
            add_filter( 'parse_query', array($this, 'filter_list_query') );
            //Add and manage Product and Section columns
            add_filter( 'manage_knowledgebase_posts_columns', array($this, 'add_custom_columns') );
            add_action(
                'manage_knowledgebase_posts_custom_column',
                array($this, 'manage_custom_columns'),
                10,
                2
            );
            //Add views, votes and score metafields default values on post save
            add_action(
                'save_post_knowledgebase',
                array($this, 'save_articles_data'),
                10,
                2
            );
            // Add Bulk actions for Quick Edit
            add_action(
                'bulk_edit_custom_box',
                array($this, 'quick_edit_custom_box_kb'),
                10,
                2
            );
            add_action(
                'quick_edit_custom_box',
                array($this, 'quick_edit_custom_box_kb'),
                10,
                2
            );
            //Add admin notice for articles with missing data
            add_action( 'admin_notices', array($this, 'missing_data_notice') );
            //Remove Feeds and oEmbed links in site header
            add_action( 'template_redirect', array($this, 'remove_cpt_feeds') );
            //Add Knowledge Base state to entry page in page list screen
            add_filter(
                'display_post_states',
                array($this, 'set_display_post_states'),
                10,
                2
            );
            add_action( 'wp_ajax_basepress_get_sections_filter', array($this, 'basepress_get_sections_filter') );
            $this->options = get_option( 'basepress_settings' );
            $this->kb_slug = $basepress_utils->get_kb_slug();
            $this->register_taxonomies();
            $this->register_post_type();
        }

        /**
         * Add rewrite tag for is_knowledgebase_product
         *
         * @since 2.2.0
         */
        public function add_rewrite_tags() {
            add_rewrite_tag( '%is_knowledgebase_product%', '([^/]+)' );
            add_rewrite_tag( '%knowledgebase_tax_term%', '([^/]+)' );
            add_rewrite_tag( '%knowledgebase_items%', '([^/]+)' );
        }

        /**
         * Removes default rewrite rules for our CPT and Taxonomy
         *
         * @since 1.9.0
         *
         * @param $rules
         * @return array
         */
        public function clean_rewrite_rules() {
            return array();
        }

        /**
         * Adds rewrite rules for Basepress post type
         * Called by flush_rewrite rules
         *
         * @since 1.0.0
         * @updated 1.4.0
         *
         * @param $rules
         * @return array
         */
        public function rewrite_rules( $rules ) {
            global $wp_rewrite, $basepress_utils;
            $options = get_option( 'basepress_settings' );
            //If the entry page has not been set skip the rewrite rules
            if ( !isset( $options['entry_page'] ) ) {
                return $rules;
            }
            //Force Utils to refresh the options to make sure we have updated ones when creating our rewrite rules
            //Essential for the Wizard
            $basepress_utils->load_options();
            $kb_slug = $basepress_utils->get_kb_slug( true );
            $entry_page = ( isset( $this->options['entry_page'] ) ? $this->options['entry_page'] : '' );
            /**
             * Filter the kb_slug before generating the rewrite rules
             * @since 1.5.0
             */
            $kb_slug = apply_filters( 'basepress_rewrite_rules_kb_slug', $kb_slug, $entry_page );
            $search_base = $wp_rewrite->search_base;
            $page_base = $wp_rewrite->pagination_base;
            $comments_pagination_base = $wp_rewrite->comments_pagination_base;
            $tag_base = ( isset( $options['tags_slug'] ) ? sanitize_key( $options['tags_slug'] ) : 'tag' );
            $new_rules = array();
            $product = get_terms( array(
                'taxonomy'   => 'knowledgebase_cat',
                'parent'     => 0,
                'hide_empty' => false,
                'meta_key'   => 'basepress_position',
                'orderby'    => 'meta_value_num',
                'order'      => 'ASC',
                'number'     => 1,
            ) );
            $product_slug = '';
            if ( !empty( $product ) && !is_a( $product, 'WP_Error' ) ) {
                $product_slug = $product[0]->slug;
            }
            $uncategorized_slug = apply_filters( 'basepress_uncategorized_section', 'uncategorized' );
            //General rules for uncategorized articles
            $new_rules[$kb_slug . '/' . $uncategorized_slug . '/?$'] = 'index.php?is_knowledgebase_product=true&knowledgebase_cat=' . $uncategorized_slug;
            $new_rules[$kb_slug . '/' . $uncategorized_slug . '/(.+)/([0-9]+)?/?$'] = 'index.php?post_type=knowledgebase&knowledgebase=$matches[1]&page=$matches[2]&knowledgebase_tax_term=' . $uncategorized_slug;
            $new_rules[$kb_slug . '/' . $uncategorized_slug . '/(.+)/?$'] = 'index.php?post_type=knowledgebase&knowledgebase=$matches[1]&knowledgebase_tax_term=' . $uncategorized_slug;
            if ( isset( $options['single_product_mode'] ) ) {
                //entry page
                $new_rules[$kb_slug . '/?$'] = 'index.php?is_knowledgebase_product=true&knowledgebase_cat=' . $product_slug;
                //Search
                $new_rules[$kb_slug . '/' . $search_base . '/(.+)/page/?([0-9]{1,})/?$'] = 'index.php?s=$matches[1]&post_type=knowledgebase&knowledgebase_cat=' . $product_slug . '&paged=$matches[2]';
                $new_rules[$kb_slug . '/' . $search_base . '/(.+)/?$'] = 'index.php?s=$matches[1]&post_type=knowledgebase&knowledgebase_cat=' . $product_slug;
                $new_rules[$kb_slug . '/' . $search_base . '/?$'] = 'index.php?s=&post_type=knowledgebase&knowledgebase_cat=' . $product_slug;
                //Paged sections
                $new_rules[$kb_slug . '/(.+?)/' . $page_base . '/([0-9]+)/?$'] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&paged=$matches[2]';
                //Paged Comments
                $new_rules[$kb_slug . '/(.+?)/' . $comments_pagination_base . '-([0-9]{1,})/?$'] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&cpage=$matches[2]';
                //Paged articles
                $new_rules[$kb_slug . "/(.+?)(?:/([0-9]+))/?\$"] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&page=$matches[2]';
                //Catch all rule for sections and articles
                $new_rules[$kb_slug . "/(.+?)/?\$"] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]';
            } else {
                //entry page
                $new_rules[$kb_slug . '/?$'] = 'index.php?page_id=' . $options['entry_page'];
                //Search
                //Empty searches
                $new_rules[$kb_slug . '/(.+)/' . $search_base . '/?$'] = 'index.php?s=&post_type=knowledgebase&knowledgebase_cat=$matches[1]';
                $new_rules[$kb_slug . '/' . $search_base . '/?$'] = 'index.php?s=&post_type=knowledgebase&knowledgebase_cat=$matches[1]';
                //Global searches
                $new_rules[$kb_slug . '/' . $search_base . '/(.+)/page/?([0-9]{1,})/?$'] = 'index.php?s=$matches[1]&post_type=knowledgebase&paged=$matches[2]';
                $new_rules[$kb_slug . '/' . $search_base . '/(.+)/?$'] = 'index.php?s=$matches[1]&post_type=knowledgebase';
                //All other cases
                $new_rules[$kb_slug . '/(.+)/' . $search_base . '/(.+)/page/?([0-9]{1,})/?$'] = 'index.php?s=$matches[2]&post_type=knowledgebase&knowledgebase_cat=$matches[1]&paged=$matches[3]';
                $new_rules[$kb_slug . '/(.+)/' . $search_base . '/(.+)/?$'] = 'index.php?s=$matches[2]&post_type=knowledgebase&knowledgebase_cat=$matches[1]';
                //Paged sections
                $new_rules[$kb_slug . '/(.+?)/' . $page_base . '/([0-9]+)/?$'] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&paged=$matches[2]';
                //Paged Comments
                $new_rules[$kb_slug . '/(.+?)/' . $comments_pagination_base . '-([0-9]{1,})/?$'] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&cpage=$matches[2]';
                //Paged articles
                $new_rules[$kb_slug . "/(.+?)(?:/([0-9]+))/?\$"] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]&page=$matches[2]';
                //Catch all rule for products, sections and articles
                $new_rules[$kb_slug . "/(.+?)/?\$"] = 'index.php?post_type=knowledgebase&knowledgebase_items=$matches[1]';
            }
            $new_rules = apply_filters( 'basepress_rewrite_rules', $new_rules, array(
                'entry_page'               => $options['entry_page'],
                'kb_slug'                  => $kb_slug,
                'uncategorized_slug'       => $uncategorized_slug,
                'product_slug'             => $product_slug,
                'search_base'              => $search_base,
                'page_base'                => $page_base,
                'comments_pagination_base' => $comments_pagination_base,
            ) );
            //IMPORTANT: the new rules must be added at the top of the array to have higher priority
            return array_merge( $new_rules, $rules );
        }

        /**
         * Registers the taxonomy 'knowledgebase_cat'
         *
         * @since version 1.0.0
         */
        public function register_taxonomies() {
            //We need to disable the REST API for the articles edit screen otherwise the category metabox would display
            //Setting the 'meta_box_cb' to false is not enough for Gutenberg
            $not_rest_api_pages = array('post-new.php', 'post.php');
            $show_in_rest = ( isset( $GLOBALS['pagenow'] ) && in_array( $GLOBALS['pagenow'], $not_rest_api_pages ) ? false : true );
            register_taxonomy( 'knowledgebase_cat', 'knowledgebase', array(
                'labels'            => array(
                    'name'          => esc_html__( 'Knowledge Base categories', 'basepress' ),
                    'singular_name' => esc_html__( 'Knowledge Base category', 'basepress' ),
                    'menu_name'     => esc_html__( 'Knowledge Base categories', 'basepress' ),
                ),
                'hierarchical'      => true,
                'query_var'         => true,
                'public'            => true,
                'show_ui'           => false,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_in_rest'      => $show_in_rest,
                'meta_box_cb'       => false,
                'rewrite'           => array(
                    'slug'       => $this->kb_slug . '/%terms%',
                    'with_front' => false,
                    'feeds'      => false,
                ),
            ) );
        }

        /**
         * Registers Basepress post type
         *
         * @since version 1.0.0
         */
        public function register_post_type() {
            global $basepress_utils;
            $options = $basepress_utils->get_options();
            $exclude_from_search = ( isset( $options['exclude_from_wp_search'] ) ? true : false );
            //TODO: this has been disabled for testing as it may create confusion
            $show_ui = true;
            //get_option( 'basepress_run_wizard' ) ? false : true;
            register_post_type( 'knowledgebase', array(
                'label'               => esc_html__( 'Knowledge Base', 'basepress' ),
                'labels'              => array(
                    'name'          => esc_html__( 'Knowledge Base', 'basepress' ),
                    'singular_name' => esc_html__( 'Knowledge Base Article', 'basepress' ),
                    'all_items'     => esc_html__( 'All Articles', 'basepress' ),
                    'edit_item'     => esc_html__( 'Edit Article', 'basepress' ),
                    'view_item'     => esc_html__( 'View Article', 'basepress' ),
                    'search_items'  => esc_html__( 'Search Articles', 'basepress' ),
                    'add_new'       => esc_html__( 'Add New Article', 'basepress' ),
                ),
                'description'         => esc_html__( 'These are the Knowledge base articles from BasePress.', 'basepress' ),
                'supports'            => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                    'trackbacks',
                    'revisions',
                    'comments'
                ),
                'taxonomies'          => array('knowledgebase_cat'),
                'hierarchical'        => false,
                'query_var'           => true,
                'public'              => true,
                'show_ui'             => $show_ui,
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 25,
                'menu_icon'           => 'data:image/svg+xml;base64,' . base64_encode( '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill="rgb(135,135,135)" d="M 13.65 1 L 17.756 1 L 17.756 1 L 17.756 6.008 L 15.784 3.089 L 13.65 6.008 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 L 13.65 1 Z  M 2.768 22.951 C 1.463 22.951 1.05 22.221 1.05 20.911 L 1.05 3.089 C 1.05 1.578 1.428 1.049 2.768 1.049 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 L 2.768 22.951 Z  M 5 9 L 17.756 9 L 17.756 11 L 5 11 L 5 9 L 5 9 L 5 9 L 5 9 L 5 9 L 5 9 L 5 9 L 5 9 Z  M 5 12 L 12 12 L 12 14 L 5 14 L 5 12 L 5 12 L 5 12 L 5 12 L 5 12 L 5 12 L 5 12 Z  M 13.65 0 L 2.415 0 L 2.415 0 L 2.415 0 L 2.415 0 L 2.415 0 C 1.082 0 0 1.031 0 2.3 L 0 21.7 C 0 22.969 1.082 24 2.415 24 L 18.585 24 C 19.918 24 21 22.969 21 21.7 L 21 2.3 C 21 1.031 19.918 0 18.585 0 L 17.756 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 L 13.65 0 Z"/></svg>' ),
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => $exclude_from_search,
                'publicly_queryable'  => true,
                'capability'          => 'edit_post',
                'show_in_rest'        => true,
                'rewrite'             => array(
                    'slug'       => $this->kb_slug . '/%taxonomies%',
                    'with_front' => false,
                    'feeds'      => false,
                ),
            ) );
        }

        /**
         * Takes the request generated from our rewrite rules and determines if the request is for an article or section
         * The reuqest is then updated accordingly
         *
         * @since 2.14.0
         *
         * @param $request
         * @return mixed
         */
        public function set_correct_request_for_item( $request ) {
            global $wp, $wpdb, $basepress_utils;
            $request_items = ( isset( $request['knowledgebase_items'] ) && !empty( $request['knowledgebase_items'] ) ? explode( '/', wp_unslash( $request['knowledgebase_items'] ) ) : false );
            if ( isset( $request['post_type'] ) && 'knowledgebase' == $request['post_type'] && $request_items ) {
                $request_item = array_pop( $request_items );
                $parent_item = array_pop( $request_items );
                //Check if a post exists with the passed slug
                $post_exists = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = 'knowledgebase' LIMIT 1", $request_item ) );
                //Check if a section exists with the passed slug
                $maybe_section = get_term_by( 'slug', $request_item, 'knowledgebase_cat' );
                $section_exists = !empty( $maybe_section ) && is_a( $maybe_section, 'WP_Term' );
                if ( $section_exists ) {
                    if ( 0 == $maybe_section->parent ) {
                        $request['is_knowledgebase_product'] = true;
                        $request['knowledgebase_cat'] = $request_item;
                        return $request;
                    }
                }
                if ( $post_exists && !$section_exists || !$post_exists && !$section_exists ) {
                    $request['knowledgebase'] = $request_item;
                    $request['name'] = $request_item;
                    $request['knowledgebase_tax_term'] = $parent_item;
                } elseif ( $post_exists && $section_exists ) {
                    $kb_slug = $basepress_utils->get_kb_slug( true );
                    $kb_slug = apply_filters( 'basepress_rewrite_rules_kb_slug', $kb_slug, $this->options['entry_page'] );
                    $post_permalink = get_the_permalink( $post_exists );
                    $section_permalink = get_term_link( $maybe_section, 'knowledgebase_cat' );
                    $_request_items = str_replace( $kb_slug . '/', '', $wp->request );
                    //First check if the section slug matches
                    if ( false !== strpos( $section_permalink, $_request_items ) ) {
                        $request['knowledgebase_cat'] = $request_item;
                    } elseif ( false !== strpos( $post_permalink, $_request_items ) ) {
                        $request['knowledgebase'] = $request_item;
                        $request['name'] = $request_item;
                        $request['knowledgebase_tax_term'] = $parent_item;
                    } else {
                        $request['knowledgebase_cat'] = $request_item;
                    }
                } elseif ( !$post_exists && $section_exists ) {
                    $request['knowledgebase_cat'] = $request_item;
                }
            }
            return $request;
        }

        /**
         * Canonical redirection for articles and uncategorized section
         *
         * @since 2.7.0
         *
         * @param $request
         * @return mixed
         */
        public function canonical_redirect( $request ) {
            global $basepress_utils;
            if ( is_admin() || isset( $request['rest_route'] ) ) {
                return $request;
            }
            if ( !apply_filters( 'basepress_canonical_redirect', true, $request ) ) {
                return $request;
            }
            //Entry page
            if ( isset( $request['is_knowledgebase_product'] ) ) {
                return $request;
            }
            //Tags
            if ( isset( $request['knowledgebase_tag'] ) ) {
                return $request;
            }
            if ( !isset( $request['knowledgebase_items'] ) || empty( $request['knowledgebase_items'] ) ) {
                return $request;
            }
            $uncategorized_slug = apply_filters( 'basepress_uncategorized_section', 'uncategorized' );
            $wrong_product = false;
            $wrong_section = false;
            //Prevent access to the uncategorized section
            if ( isset( $request['is_knowledgebase_product'] ) && isset( $request['knowledgebase_tax_term'] ) && $uncategorized_slug == $request['knowledgebase_tax_term'] ) {
                $options = $basepress_utils->get_options();
                $entry_page = ( isset( $options['entry_page'] ) ? $options['entry_page'] : '' );
                /**
                 * This filter allows to modify the entry page ID
                 */
                $entry_page = apply_filters( 'basepress_entry_page', $entry_page );
                $entry_page_url = get_permalink( $entry_page );
                wp_redirect( $entry_page_url, 301, 'BasePress [1]' );
                die;
            }
            //Redirect for wrong section URL
            if ( isset( $request['knowledgebase_cat'] ) && !empty( $request['knowledgebase_cat'] ) ) {
                $section = get_term_by( 'slug', $request['knowledgebase_cat'], 'knowledgebase_cat' );
                $taxonomy_tree = $this->get_taxonomies( $section, 'section' );
                $taxonomy_tree = ( !empty( $taxonomy_tree ) ? explode( '/', $taxonomy_tree ) : array() );
                $request_tree = explode( '/', $request['knowledgebase_items'] );
                //Remove last item which is the requested section slug
                array_pop( $request_tree );
                $wrong_section = $taxonomy_tree !== $request_tree;
                if ( $wrong_section ) {
                    add_action( 'template_redirect', function () use($request, $section) {
                        global $wp_rewrite;
                        $term_link = get_term_link( $section, 'knowledgebase_cat' );
                        if ( isset( $request['paged'] ) && !empty( $request['paged'] ) ) {
                            $page_base = $wp_rewrite->pagination_base;
                            $term_link = untrailingslashit( $term_link ) . '/' . $page_base . '/' . $request['paged'] . '/';
                        }
                        wp_redirect( $term_link, 301, 'BasePress [2]' );
                        die;
                    }, 999 );
                }
            }
            //Redirection for wrong article URL
            if ( isset( $request['knowledgebase'] ) && isset( $request['post_type'] ) && 'knowledgebase' == $request['post_type'] && isset( $request['knowledgebase_tax_term'] ) ) {
                $_post = get_posts( array(
                    'post_type' => 'knowledgebase',
                    'name'      => $request['knowledgebase'],
                    'nopaging'  => true,
                    'fields'    => 'ids',
                ) );
                if ( empty( $_post ) ) {
                    return $request;
                }
                $post_section = get_the_terms( $_post[0], 'knowledgebase_cat' );
                //Redirects articles if the URL contains the uncategorized section but the article has a section
                if ( $uncategorized_slug == $request['knowledgebase_tax_term'] ) {
                    $wrong_section = !empty( $post_section );
                } else {
                    //Redirect all other cases where the section or the product are incorrect
                    $term = get_term_by( 'slug', $request['knowledgebase_tax_term'], 'knowledgebase_cat' );
                    if ( is_a( $term, 'WP_Term' ) ) {
                        $taxonomy_tree = $this->get_taxonomies( $post_section[0], 'article' );
                        $taxonomy_tree = explode( '/', $taxonomy_tree );
                        $request_tree = explode( '/', $request['knowledgebase_items'] );
                        //Remove last item which is the post slug
                        array_pop( $request_tree );
                        //Wrong Section?
                        $wrong_section = $taxonomy_tree !== $request_tree;
                        //Wrong Product?
                        $terms = $this->get_taxonomies( $post_section[0], 'article' );
                        $terms = ( !empty( $terms ) ? explode( '/', $terms ) : array() );
                        $wrong_product = false == stripos( $_SERVER['REQUEST_URI'], $terms[0] );
                        // phpcs:ignore
                    } else {
                        $wrong_section = true;
                    }
                }
                if ( $wrong_section || $wrong_product ) {
                    $_post = $_post[0];
                    add_action( 'template_redirect', function () use($_post, $request) {
                        $post_permalink = get_permalink( $_post );
                        if ( isset( $request['page'] ) && !empty( $request['page'] ) ) {
                            $post_permalink = untrailingslashit( $post_permalink ) . '/' . $request['page'] . '/';
                        }
                        wp_redirect( $post_permalink, 301, 'BasePress [3]' );
                        die;
                    }, 9 );
                }
            }
            return $request;
        }

        /**
         * Gets the permalink structure from the settings and sets the default when necessary
         *
         * @since 2.14.0
         *
         * @param $source
         * @return string|string[]
         */
        public function get_permalink_structure( $source ) {
            global $basepress_utils;
            $permalink_structure = $basepress_utils->get_option( "{$source}_permalink_structure" );
            switch ( $source ) {
                case 'article':
                    $default_permalink_structure = '%knowledge_base%/%article_section%';
                    break;
                case 'section':
                    $default_permalink_structure = '%knowledge_base%';
                    break;
                default:
                    $default_permalink_structure = '%knowledge_base%';
            }
            if ( '%none%' == $permalink_structure ) {
                $permalink_structure = '';
            } else {
                $permalink_structure = ( !empty( $permalink_structure ) ? $permalink_structure : $default_permalink_structure );
            }
            if ( (bool) $basepress_utils->get_option( 'single_product_mode' ) ) {
                // The knowledgebase tag might be followed by a slash or not so we need to consider both options
                $permalink_structure = str_replace( array('%knowledge_base%/', '%knowledge_base%'), '', $permalink_structure );
            }
            return $permalink_structure;
        }

        /**
         * Adds the product and section name on the post permalink
         *
         * @since version 1.0.0
         *
         * @param $link
         * @param $post
         * @return mixed
         */
        public function post_permalinks( $link, $post ) {
            //Return if this is not a basepress post
            if ( 'knowledgebase' != $post->post_type ) {
                return $link;
            }
            $terms = get_the_terms( $post->ID, 'knowledgebase_cat' );
            if ( !empty( $terms ) and !is_wp_error( $terms ) ) {
                //replace '%taxonomies%' with the appropriate terms hierarchy
                $taxonomies = $this->get_taxonomies( $terms[0], 'article' );
                $taxonomies = ( !empty( $taxonomies ) ? '/' . $taxonomies : '' );
                $link = str_replace( '/%taxonomies%', $taxonomies, $link );
            } else {
                $uncategorized_section = apply_filters( 'basepress_uncategorized_section', 'uncategorized' );
                $link = str_replace( '%taxonomies%', $uncategorized_section, $link );
            }
            /**
             * Filters the section permalink before returning it
             */
            $link = apply_filters( 'basepress_post_permalink', $link, $post );
            return $link;
        }

        /**
         * Adds the product name on the archive permalink
         *
         * @since version 1.0.0
         *
         * @param $termlink
         * @param $term
         * @param $taxonomy
         * @return mixed
         */
        public function sections_permalink( $termlink, $term, $taxonomy ) {
            //If this term is not a basepress product return the $termlink unchanged
            if ( 'knowledgebase_cat' != $taxonomy ) {
                return $termlink;
            }
            if ( 0 == $term->parent ) {
                $termlink = str_replace( '/%terms%', '', $termlink );
                return $termlink;
            }
            $permastructure = $this->get_permalink_structure( 'section' );
            if ( empty( $permastructure ) ) {
                $termlink = str_replace( '/%terms%', '', $termlink );
            } else {
                $taxonomies = $this->get_taxonomies( $term, 'section' );
                $taxonomies = ( !empty( $taxonomies ) ? '/' . $taxonomies : '' );
                $termlink = str_replace( '/%terms%', $taxonomies, $termlink );
            }
            /**
             * Filters the section permalink before returning it
             */
            $termlink = apply_filters( 'basepress_sections_permalink', $termlink, $term );
            return $termlink;
        }

        /**
         *
         * @since version 1.0.0
         *
         * @param $terms
         * @return string
         */
        public function get_taxonomies( $term, $source ) {
            global $basepress_utils;
            $hierarchy = $basepress_utils->get_sections_tree( $term );
            $terms = wp_list_pluck( $hierarchy, 'slug' );
            $kb = array_shift( $terms );
            $section = array_pop( $terms );
            $parent_sections = implode( '/', $terms );
            $taxonomies = str_replace( array('%knowledge_base%', '%parent_sections%', '%article_section%'), array($kb, $parent_sections, $section), $this->get_permalink_structure( $source ) );
            $taxonomies = ltrim( $taxonomies, '/' );
            $taxonomies = rtrim( $taxonomies, '/' );
            $taxonomies = preg_replace( '/\\/+/', '/', $taxonomies );
            return $taxonomies;
        }

        public function tag_permalink( $termlink, $term, $taxonomy ) {
            global $basepress_utils;
            if ( 'knowledgebase_tag' != $taxonomy ) {
                return $termlink;
            }
            if ( !get_option( 'permalink_structure' ) ) {
                $product = $basepress_utils->get_product();
                $termlink = add_query_arg( 'knowledgebase_cat', $product->slug, $termlink );
            } else {
                if ( $basepress_utils->is_single_product_mode ) {
                    $termlink = str_replace( '%kb_product%/', '', $termlink );
                } else {
                    $product = $basepress_utils->get_product();
                    if ( !empty( $product->slug ) ) {
                        $termlink = str_replace( '%kb_product%', $product->slug, $termlink );
                    } else {
                        $termlink = str_replace( '%kb_product%/', '', $termlink );
                    }
                }
            }
            return $termlink;
        }

        /**
         * Adds articles filtering on post list table
         *
         * @since 1.0.0
         *
         * @updated 2.1.0
         */
        public function filter_list_dropdowns() {
            global $typenow;
            if ( 'knowledgebase' == $typenow ) {
                $selected_product = ( isset( $_GET['kb_product'] ) ? sanitize_text_field( wp_unslash( $_GET['kb_product'] ) ) : '' );
                wp_dropdown_categories( array(
                    'show_option_all' => esc_html__( 'Show all Knowledge Bases', 'basepress' ),
                    'taxonomy'        => 'knowledgebase_cat',
                    'name'            => 'kb_product',
                    'orderby'         => 'name',
                    'selected'        => $selected_product,
                    'show_count'      => true,
                    'hide_empty'      => false,
                    'hierarchical'    => true,
                    'depth'           => 1,
                ) );
                $this->get_sections_dropdown_filter( $selected_product );
                $this->echo_filter_script();
            }
        }

        /**
         * Get sections dropdown list. This is used during Ajax as well
         *
         * @since 2.1.0
         *
         * @param $selected_product
         */
        private function get_sections_dropdown_filter( $selected_product ) {
            $selected_product = ( $selected_product ? $selected_product : -1 );
            $selected_section = ( isset( $_GET['kb_section'] ) ? sanitize_text_field( wp_unslash( $_GET['kb_section'] ) ) : '' );
            $list = wp_dropdown_categories( array(
                'taxonomy'     => 'knowledgebase_cat',
                'name'         => 'kb_section',
                'child_of'     => $selected_product,
                'orderby'      => 'name',
                'selected'     => $selected_section,
                'show_count'   => true,
                'pad_counts'   => false,
                'hide_empty'   => false,
                'hierarchical' => true,
                'depth'        => 10,
                'echo'         => 0,
            ) );
            $option_all_text = esc_html__( 'Show all sections', 'basepress' );
            $selected = ( !$selected_section ? ' selected' : '' );
            $list = preg_replace( '/(<select.*>)/', "\$0\n\t<option value='0'{$selected}>{$option_all_text}</option>", $list );
            echo $list;
        }

        /**
         * Get sections dropdown list during Ajax
         *
         * @since 2.1.0
         */
        public function basepress_get_sections_filter() {
            $selected_product = ( isset( $_REQUEST['selected_product'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['selected_product'] ) ) : '' );
            ob_start();
            $this->get_sections_dropdown_filter( $selected_product );
            echo ob_get_clean();
            wp_die();
        }

        /**
         * Echoes the JS for the articles filtering
         *
         * @since 2.1.0
         */
        private function echo_filter_script() {
            ?>
			<script type="text/javascript">
				jQuery( '#kb_product' ).change( function(){
					jQuery( '#kb_section option:first').attr('selected','selected');

					var product = jQuery( this ).val();

					jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'basepress_get_sections_filter',
							selected_product: product
						},
						success: function( response ){
							jQuery( '#kb_section' ).replaceWith( response );
						}
					});
				});
			</script>
			<?php 
        }

        /**
         * Filters articles by products on post list table
         *
         * @since version 1.0.0
         *
         * @updated 2.1.0
         *
         * @param $query
         * @return mixed
         */
        public function filter_list_query( $query ) {
            global $pagenow;
            $post_type = 'knowledgebase';
            $taxonomy = 'knowledgebase_cat';
            $q_vars =& $query->query_vars;
            if ( 'edit.php' == $pagenow && isset( $q_vars['post_type'] ) && $q_vars['post_type'] == $post_type && (isset( $_REQUEST['kb_section'] ) || isset( $_REQUEST['kb_product'] )) ) {
                $product = ( isset( $_REQUEST['kb_product'] ) && 0 != (int) $_REQUEST['kb_product'] ? (int) $_REQUEST['kb_product'] : 0 );
                $section = ( isset( $_REQUEST['kb_section'] ) && 0 != (int) $_REQUEST['kb_section'] ? (int) $_REQUEST['kb_section'] : 0 );
                if ( $product || $section ) {
                    $term_id = ( $section ? $section : $product );
                    $include_children = ( $section ? false : true );
                    $q_vars['tax_query'] = array(array(
                        'taxonomy'         => $taxonomy,
                        'field'            => 'term_id',
                        'terms'            => $term_id,
                        'include_children' => $include_children,
                    ));
                }
            }
            return $query;
        }

        /**
         * Adds the Product and Section columns
         *
         * @since version 1.0.0
         *
         * @param $columns
         * @return array
         */
        public function add_custom_columns( $columns ) {
            unset($columns['taxonomy-knowledgebase_cat']);
            $first_columns = array_slice(
                $columns,
                0,
                3,
                true
            );
            $last_columns = array_slice(
                $columns,
                3,
                null,
                true
            );
            $new_columns = array();
            $new_columns['basepress-product'] = esc_html__( 'Knowledge Base', 'basepress' );
            $new_columns['basepress-section'] = esc_html__( 'Section', 'basepress' );
            $columns = array_merge( $first_columns, $new_columns, $last_columns );
            return $columns;
        }

        /**
         * Generates the values for the Product and Section columns
         *
         * @since version 1.0.0
         *
         * @updated 2.1.0
         *
         * @param $column
         * @param $post_id
         */
        public function manage_custom_columns( $column, $post_id ) {
            switch ( $column ) {
                case 'basepress-product':
                    $term = get_the_terms( $post_id, 'knowledgebase_cat' );
                    if ( $term ) {
                        $product = $this->get_product( $term[0] );
                        $link = get_admin_url() . 'edit.php?post_type=knowledgebase&kb_product=' . $product->term_id;
                        $link .= '&kb_section=0';
                        echo '<a href="' . esc_url( $link ) . '">' . esc_html( $product->name ) . '</a>';
                    }
                    break;
                case 'basepress-section':
                    $term = wp_get_post_terms( $post_id, 'knowledgebase_cat', array() );
                    if ( empty( $term ) ) {
                        break;
                    }
                    //Skip terms with parent 0 as they are products
                    if ( 0 == $term[0]->parent ) {
                        break;
                    }
                    $product = $this->get_product( $term[0] );
                    $link = get_admin_url() . 'edit.php?post_type=knowledgebase&kb_product=' . $product->term_id;
                    $link .= '&kb_section=' . $term[0]->term_id;
                    echo '<a href="' . esc_url( $link ) . '">' . esc_html( $term[0]->name ) . '</a>';
                    break;
            }
        }

        /**
         * Finds the product from the section
         *
         * @since version 1.0.0
         *
         * @param $term
         * @return array|null|WP_Error|WP_Term
         */
        private function get_product( $term ) {
            while ( 0 != $term->parent ) {
                $term = get_term( $term->parent, 'knowledgebase_cat' );
            }
            return $term;
        }

        /**
         * Saves knowledge base post metas and checks the assigned section
         *
         * @since version 1.0.0
         * @updated 2.14.11
         *
         * @param $post_id
         * @param $post
         */
        public function save_articles_data( $post_id, $post ) {
            //Make sure the article is assigned to a single section. This is necessary for the quick/bulk edits
            if ( isset( $_REQUEST['tax_input'] ) && isset( $_REQUEST['tax_input']['knowledgebase_cat'] ) ) {
                if ( in_array( 'none', $_REQUEST['tax_input']['knowledgebase_cat'] ) ) {
                    wp_delete_object_term_relationships( $post_id, 'knowledgebase_cat' );
                } else {
                    if ( count( $_REQUEST['tax_input']['knowledgebase_cat'] ) > 1 ) {
                        wp_delete_object_term_relationships( $post_id, 'knowledgebase_cat' );
                        wp_set_post_terms( $post_id, end( $_REQUEST['tax_input']['knowledgebase_cat'] ), 'knowledgebase_cat' );
                    }
                }
            }
            //Save all metadata
            if ( 'publish' == $post->post_status ) {
                $views = get_post_meta( $post_id, 'basepress_views', true );
                if ( !$views ) {
                    update_post_meta( $post_id, 'basepress_views', 0 );
                }
            }
        }

        /**
         * Outputs the custom box for articles quick edit
         *
         * @since 2.14.11
         *
         * @param $column_name
         * @param $post_type
         */
        public function quick_edit_custom_box_kb( $column_name, $post_type ) {
            if ( 'knowledgebase' !== $post_type ) {
                return;
            }
            if ( !in_array( $column_name, array('basepress-section') ) ) {
                return;
            }
            ?>
			<fieldset class="inline-edit-col-right inline-edit-knowledgebase">
				<div class="inline-edit-col inline-edit-<?php 
            echo esc_attr( $column_name );
            ?>">
					<label class="inline-edit-group">
						<span class="title"><?php 
            esc_html_e( 'Section', 'basepress' );
            ?></span>
						<?php 
            echo $this->get_bulk_edit_sections_list();
            //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            ?>
					</label>
				</div>
			</fieldset>
			<?php 
        }

        /**
         * Get list of sections for quick edit
         *
         * @since 2.14.11
         *
         * @return string|string[]|null
         */
        public function get_bulk_edit_sections_list() {
            $list = wp_dropdown_categories( array(
                'taxonomy'     => 'knowledgebase_cat',
                'child_of'     => '',
                'hide_empty'   => 0,
                'echo'         => 0,
                'hierarchical' => 1,
                'class'        => 'basepress_section_mb',
                'name'         => 'tax_input[knowledgebase_cat][]',
                'id'           => 'quick_edit_kb_cat_' . $this->bulk_edit_id_counter++,
                'selected'     => '',
            ) );
            $extra_options = "\n\t<option disabled selected>" . esc_html__( '&mdash; No Change &mdash;' ) . '</option><option disabled>─────────</option>';
            $extra_options .= '<option value="none">' . esc_html__( 'None', 'basepress' ) . '</option>';
            $list = preg_replace( '/(<select.*>)/', "\$0{$extra_options}", $list );
            $list = str_replace( 'level-0"', 'level-0" disabled ', $list );
            return $list;
        }

        /**
         * Add admin notice if the articles has missing data like section and template
         *
         * @since 1.7.6
         *
         * @return mixed 
         */
        public function missing_data_notice() {
            global $post, $basepress_utils;
            $action = ( isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '' );
            if ( 'edit' == $action && $post && 'knowledgebase' == $post->post_type && 'auto-draft' != $post->post_status ) {
                $post_type = $post->post_type;
                if ( 'edit' == $action && 'knowledgebase' == $post_type ) {
                    $options = $basepress_utils->get_options();
                    $missing_options = array();
                    $post_terms = get_the_terms( $post->ID, 'knowledgebase_cat' );
                    $post_terms = ( !empty( $post_terms ) ? $post_terms[0] : false );
                    $post_meta = get_post_meta( $post->ID, 'basepress_template_name', true );
                    /* if( empty( $post_terms ) && ! apply_filters( 'basepress_remove_missing_section_notice', false ) ){
                    				$missing_options[] = esc_html__( 'Section', 'basepress' );
                    			} */
                    if ( empty( $post_meta ) && !apply_filters( 'basepress_remove_missing_template_notice', false ) ) {
                        if ( !isset( $options['force_sidebar_position'] ) ) {
                            $missing_options[] = esc_html__( 'Template', 'basepress' );
                        }
                    }
                    if ( !empty( $missing_options ) ) {
                        $class = 'notice notice-error is-dismissible';
                        $message = esc_html__( 'This article was saved without the following data:', 'basepress' ) . ' ';
                        $missing_options = implode( ', ', $missing_options );
                        printf(
                            '<div class="%1$s"><p>%2$s%3$s</p></div>',
                            esc_attr( $class ),
                            esc_html( $message ),
                            esc_html( $missing_options )
                        );
                    }
                }
            }
        }

        /**
         * Removes Feeds and oEmbed links in site header
         *
         * @since 1.8.9
         */
        public function remove_cpt_feeds() {
            global $wp_query;
            if ( 'knowledgebase' == get_post_type() || isset( $wp_query->query_vars['post_type'] ) && 'knowledgebase' == $wp_query->query_vars['post_type'] || is_tax( 'knowledgebase_cat' ) ) {
                remove_action( 'wp_head', 'feed_links_extra', 3 );
                remove_action( 'wp_head', 'feed_links', 2 );
                remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
            }
        }

        /**
         * Add Knowledge Base state to entry page in page list screen
         *
         * @since 2.1.0
         *
         * @param $post_states
         * @param $post
         * @return mixed
         */
        public function set_display_post_states( $post_states, $post ) {
            global $basepress_utils;
            $options = $basepress_utils->get_options();
            if ( isset( $options['entry_page'] ) && $options['entry_page'] == $post->ID ) {
                $post_states['basepress_entry_page'] = esc_html__( 'Knowledge Base Page', 'basepress' );
            }
            return $post_states;
        }

    }

    //End Class
    new Basepress_CPT();
}