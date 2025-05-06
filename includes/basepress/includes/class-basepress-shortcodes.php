<?php

/**
 * This class declares and handles the shortcodes.
 */
// Exit if called directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !class_exists( 'Basepress_Shortcodes' ) ) {
    class Basepress_Shortcodes {
        /**
         * basepress_shortcodes constructor.
         *
         * @since 1.0.0
         */
        public function __construct() {
            // register basepress shortcode
            add_shortcode( 'basepress', array($this, 'shortcodes_router') );
            // register articles list shortcode
            add_shortcode( 'basepress-articles', array($this, 'articles_list_shortcodes') );
            //Add shortcode to bottom of entry page if not present
            add_filter( 'the_content', array($this, 'add_products'), 10 );
        }

        /**
         * Add shortcode to bottom of entry page if not present
         *
         * @since 2.7.0
         *
         * @param $content
         * @return string
         */
        public function add_products( $content ) {
            global $basepress_utils, $post;
            if ( apply_filters( 'basepress_skip_auto_shortcode', false ) ) {
                return $content;
            }
            $entry_page = $basepress_utils->get_option( 'entry_page' );
            $entry_page = apply_filters( 'basepress_entry_page', $entry_page );
            if ( empty( $entry_page ) || empty( $post ) ) {
                return $content;
            }
            if ( isset( $post->ID ) && (int) $entry_page != (int) $post->ID ) {
                return $content;
            }
            $has_block = ( function_exists( 'has_block' ) ? has_block( 'basepress-kb/products-block' ) : false );
            if ( !has_shortcode( $content, 'basepress' ) && !$has_block ) {
                $content = rtrim( $content, PHP_EOL );
                $content .= PHP_EOL . "[basepress]";
            }
            return $content;
        }

        /**
         * Calls the shortcode function according to the short code attributes
         * If there are not attributes it will generate the product list
         *
         * @since 1.0.0
         *
         * @param $atts
         * @param $content
         * @param $tag
         * @return string
         */
        public function shortcodes_router( $atts, $content, $tag ) {
            global $post, $basepress_shortcode_editor;
            if ( empty( $atts ) ) {
                return $this->show_products();
            } else {
                return;
            }
        }

        public function articles_list_shortcodes( $atts ) {
            return;
        }

        /**
         * Generates the products page calling the products.php template in the theme
         *
         * @since 1.0.0
         *
         * @updaed 2.1.0
         *
         * @return string
         */
        public function show_products() {
            global $basepress_utils;
            $products = $basepress_utils->get_products();
            if ( empty( $products ) ) {
                //We may not get any product if they are restricted to the public by the content restriction
                //We should not output the "no products message" in that case so we will run a new query not affected by Content restriction
                if ( $basepress_utils->get_option( 'activate_restrictions' ) ) {
                    $terms_args = array(
                        'taxonomy'   => 'knowledgebase_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'fields'     => 'ids',
                    );
                    $products_terms = get_terms( $terms_args );
                    if ( empty( $products_terms ) ) {
                        return $basepress_utils->no_products_message();
                    } else {
                        return '';
                    }
                }
                return $basepress_utils->no_products_message();
            }
            $products_template = $basepress_utils->get_theme_file_path( 'products.php' );
            ob_start();
            if ( $products_template ) {
                include $products_template;
            }
            return ob_get_clean();
        }

    }

    // End class
    new basepress_shortcodes();
}