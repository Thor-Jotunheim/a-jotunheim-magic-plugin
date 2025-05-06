<?php

/*
 *	Core Theming functions
 */
// Exit if called directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Function to check if the single product mode is activated
 *
 * @since 2.3.0
 *
 * @return bool
 */
function basepress_is_single_kb() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    return ( isset( $options['single_product_mode'] ) ? true : false );
}

/**
 * Gets all knowledge base objects
 *
 * @since 2.3.0
 *
 * @return mixed
 */
function basepress_kbs() {
    global $basepress_utils;
    return $basepress_utils->get_products();
}

/**
 * Gets single current product
 *
 * @since 2.3.0
 *
 * @return mixed
 */
function basepress_kb() {
    global $basepress_utils;
    return $basepress_utils->get_product();
}

/**
 * Get the text for the KB selection button
 *
 * @since 2.3.0
 *
 * @return string|void
 */
function basepress_choose_kb_btn_text() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    $text = ( isset( $options['kbs_choose_text'] ) ? $options['kbs_choose_text'] : '' );
    return ( !empty( $text ) ? $text : esc_html__( 'Choose', 'basepress' ) );
}

/**
 * Get the sidebar position from settings
 *
 * @since 2.3.0
 *
 * @return string
 */
function basepress_sidebar_position(  $reverse = false  ) {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    $position = ( isset( $options['sidebar_position'] ) && $options['sidebar_position'] ? $options['sidebar_position'] : 'right' );
    if ( $reverse && 'none' != $position ) {
        $position = ( 'right' == $position ? 'left' : 'right' );
    }
    return $position;
}

/**
 * Gets sections for current product
 *
 * @since 1.0.0
 *
 * @return mixed
 */
function basepress_sections() {
    global $basepress_utils;
    return $basepress_utils->get_sections();
}

/**
 * Returns sub-section style for the current product
 *
 * @since 1.3.0
 *
 * @return mixed
 */
function basepress_subsection_style() {
    global $basepress_utils;
    $product = $basepress_utils->get_product();
    $sections_style = get_term_meta( $product->id, 'sections_style', true );
    return $sections_style['sub_sections'];
}

/**
 * Echos the "View all articles" text for the section
 *
 * @since 2.6.7
 *
 * @param string $number
 *
 */
function basepress_section_view_all(  $number = ''  ) {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    $text = ( isset( $options['sections_view_all_text'] ) && !empty( $options['sections_view_all_text'] ) ? $options['sections_view_all_text'] : '' );
    $text = sanitize_text_field( $text );
    if ( $text ) {
        $strings = explode( '|', $text );
        $singular = $strings[0];
        $plural = ( count( $strings ) > 1 ? $strings[1] : $strings[0] );
        $string = ( 1 == $number ? $singular : $plural );
        echo esc_html( str_replace( '%number%', $number, trim( $string ) ) );
    } else {
        printf( esc_attr( _n(
            'View %d article',
            'View all %d articles',
            $number,
            'basepress'
        ) ), esc_html( $number ) );
    }
}

/**
 * Gets the list of articles for the current tag
 *
 * @since 2.7.0
 *
 * @return mixed
 */
function basepress_tag() {
    return array();
}

/**
 * Gets the current tag title and it echoes it by default
 *
 * @since 2.7.0
 *
 * @param bool $echo
 * @return mixed
 */
function basepress_tag_title(  $echo = true  ) {
    return '';
}

/**
 * Returns true if the current article has any tag
 *
 * @since 2.7.0
 *
 * @return bool|WP_Error
 */
function basepress_article_has_tags() {
    return false;
}

/**
 * Renders the title for the list of tags in a article
 *
 * @since 2.7.0
 */
function basepress_tag_list_title() {
    return;
}

/**
 * Renders the list of tags for the current post
 *
 * @since 2.7.0
 *
 * @param string $before
 * @param string $sep
 * @param string $after
 */
function basepress_article_tags(  $before = '', $sep = ', ', $after = ''  ) {
    return;
}

/**
 * Gets breadcrumbs
 *
 * @since 2.17
 *
 * @return mixed
 */
function basepress_breadcrumbs() {
    global $basepress_utils;
    $bpbreadcrumbs = $basepress_utils->is_breadcrumbs_enabled();
    if ( $bpbreadcrumbs ) {
        return $basepress_utils->get_breadcrumbs();
    }
}

/**
 * Gets bylines
 *
 * @since 2.17
 *
 * @return mixed
 */
function basepress_byline() {
    global $basepress_utils;
    $show_byline = $basepress_utils->get_option( 'show_byline' );
    if ( $show_byline ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Replaces WP get_template part function.
 * Retrieves template part inside the currently used theme
 *
 * @since 1.0.0
 *
 * @param $slug
 * @param null $name
 * @return mixed
 */
function basepress_get_template_part(  $slug, $name = null  ) {
    global $basepress_utils;
    return $basepress_utils->get_template_part( $slug, null );
}

/**
 * Echos the number of columns set in the options for the products page
 *
 * @since 2.3.0
 */
function basepress_kb_cols() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    echo esc_html( $options['products_cols'] );
}

/**
 * Echos the number of columns set in the options for the sections page
 *
 * @since 1.0.0
 */
function basepress_section_cols() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    echo esc_html( $options['sections_cols'] );
}

/**
 * Returns whether section icons should be displayed or not according to options
 *
 * @since 1.0.0
 *
 * @return bool
 */
function basepress_show_section_icon() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    return ( isset( $options['show_section_icon'] ) ? true : false );
}

/**
 * Returns whether post icons should be displayed or not according to options
 *
 * @since 1.0.0
 *
 * @return bool
 */
function basepress_show_post_icon() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    return ( isset( $options['show_post_icon'] ) ? true : false );
}

/**
 * Returns the array of post meta icons
 *
 * @since 1.7.8
 *
 * @return mixed
 */
function basepress_get_post_meta_icons() {
    global $basepress_utils;
    $icons = $basepress_utils->icons;
    return $icons->postmeta->icon;
}

/**
 * Returns post icon if set or default one
 *
 * @since 1.0.0
 *
 * @updated 1.7.8
 *
 * @param string $post_id
 * @return mixed|string
 */
function basepress_post_icon(  $post_id = ''  ) {
    global $basepress_utils;
    $icon = '';
    if ( $post_id ) {
        $icon = get_post_meta( $post_id, 'basepress_post_icon', true );
    }
    $icon = ( !empty( $icon ) ? $icon : $basepress_utils->icons->post->default );
    return $icon;
}

/**
 * Returns all post meta data
 *
 * @since 1.3.0
 *
 * @param string $post_id
 * @return array|bool
 */
function basepress_get_post_meta(  $post_id = ''  ) {
    global $basepress_utils;
    if ( $post_id ) {
        $metas = get_post_meta( $post_id, '', true );
        $post_metas = array();
        $post_metas['icon'] = ( !empty( $metas['basepress_post_icon'][0] ) ? $metas['basepress_post_icon'][0] : $basepress_utils->icons->post->default );
        $post_metas['views'] = ( isset( $metas['basepress_views'][0] ) ? $metas['basepress_views'][0] : 0 );
        return $post_metas;
    }
    return false;
}

/**
 * Returns whether post count in section should be displayed or not according to options
 *
 * @since 1.0.0
 *
 * @return bool
 */
function basepress_show_section_post_count() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    return ( isset( $options['show_section_post_count'] ) ? true : false );
}

/**
 * Renders the section pagination
 *
 * @since 1.0.0
 *
 * @updated 1.7.8
 */
function basepress_pagination() {
    global $wp_query, $basepress_utils;
    $icons = $basepress_utils->icons->pagination;
    $prev_icon = ( isset( $icons->icon[0] ) ? $icons->icon[0] : '' );
    $next_icon = ( isset( $icons->icon[1] ) ? $icons->icon[1] : '' );
    $base = html_entity_decode( str_replace( 99999999, '%#%', get_pagenum_link( 99999999 ) ) );
    $format = '%#%';
    if ( $wp_query->is_search && isset( $basepress_utils->get_options()['search_use_url_parameters'] ) ) {
        $base = @add_query_arg( 'paged', '%#%' );
        $format = '';
    }
    $args = array(
        'base'               => $base,
        'format'             => $format,
        'total'              => $wp_query->max_num_pages,
        'current'            => max( 1, get_query_var( 'paged' ) ),
        'show_all'           => true,
        'prev_next'          => true,
        'prev_text'          => '<span class="' . $prev_icon . '"></span>',
        'next_text'          => '<span class="' . $next_icon . '"></span>',
        'type'               => 'array',
        'add_args'           => false,
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => '',
    );
    $links = paginate_links( $args );
    if ( is_array( $links ) ) {
        echo '<ul>';
        foreach ( $links as $link ) {
            echo '<li>';
            echo wp_kses_post( $link );
            // phpcs:ignore Standard.Category.SniffName.ErrorCode
            echo '</li>';
        }
        echo '</ul>';
    }
}

/**
 * Renders the article pagination
 *
 * @since 1.2.0
 *
 * @updated 1.7.8
 */
function basepress_post_pagination() {
    global $basepress_utils;
    global 
        $page,
        $numpages,
        $multipage,
        $more,
        $post,
        $wp_rewrite
    ;
    $icons = $basepress_utils->icons->pagination;
    $prev_icon = ( isset( $icons->icon[0] ) ? $icons->icon[0] : '' );
    $next_icon = ( isset( $icons->icon[1] ) ? $icons->icon[1] : '' );
    $permalink = get_permalink();
    if ( $multipage ) {
        echo '<ul>';
        if ( $page != 1 ) {
            //Previous arrow
            echo '<li><a class="prev page-numbers" href="' . esc_url( $permalink . ($page - 1) ) . '/"><span class="' . esc_attr( $prev_icon ) . '"></span></a></li>';
        }
        for ($i = 1; $i <= $numpages; $i++) {
            if ( $i == $page ) {
                $url = $permalink;
            } else {
                if ( '' == get_option( 'permalink_structure' ) || in_array( $post->post_status, array('draft', 'pending') ) ) {
                    $url = add_query_arg( 'page', $i, $permalink );
                } elseif ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
                    $url = trailingslashit( get_permalink() ) . user_trailingslashit( "{$wp_rewrite->pagination_base}/" . $i, 'single_paged' );
                } else {
                    $url = trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' );
                }
            }
            echo '<li>';
            if ( $i == $page ) {
                echo '<span class="page-numbers current">' . esc_html( $i ) . '</span>';
            } else {
                echo '<a class="page-numbers" href="' . esc_url( $url ) . '">' . esc_html( $i ) . '</a>';
            }
            echo '</li>';
        }
        if ( $page != $numpages ) {
            //Next arrow
            echo '<li><a class="next page-numbers" href="' . esc_url( $permalink . ($page + 1) ) . '/"><span class="' . esc_attr( $next_icon ) . '"></span></a></li>';
        }
    }
    echo '</ul>';
}

/*
 * Search
 */
/**
 * Calls the render function on search bar class
 *
 * @since 1.0.0
 */
function basepress_searchbar() {
    global $basepress_search;
    basepress_search_description();
    $basepress_search->render_searchbar();
}

/*
*
* Calls the render function for search description
*/
function basepress_search_description() {
    global $basepress_utils;
    $bpkb_knowledge_base = basepress_kb();
    $options = $basepress_utils->get_options();
    if ( isset( $options['show_search_description'] ) && $bpkb_knowledge_base->description != '' ) {
        echo "<p class='bpdescription'>";
        echo apply_filters( 'bp_search_description', esc_html( $bpkb_knowledge_base->description ) );
        echo "</p>";
    }
}

/**
 * Returns search term escaped for front end
 *
 * @since 1.0.0
 *
 * @return string
 */
function basepress_search_term() {
    return stripslashes( get_search_query( true ) );
}

/**
 * Returns search result page title from options
 *
 * @since 1.2.0
 *
 * @return string
 */
function basepress_search_page_title() {
    global $basepress_utils, $wp_the_query;
    $options = $basepress_utils->get_options();
    $title = '';
    if ( isset( $options['search_page_title'] ) ) {
        $title = str_replace( '%number%', $wp_the_query->found_posts, $options['search_page_title'] );
    }
    return $title;
}

function basepress_search_page_no_results_title() {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    $title = ( isset( $options['search_page_no_results_title'] ) ? $options['search_page_no_results_title'] : '' );
    return $title;
}

/**
 * Echos the post snippets for the search page results
 *
 * @since 1.2.1
 * @updated 1.8.5
 */
function basepress_search_post_snippet() {
    global $basepress_utils, $basepress_search, $post;
    $terms = $basepress_search->get_search_term();
    $snippet_length = apply_filters( 'basepress_search_snippet_length', 300 );
    $minimum_char_length = $basepress_utils->get_option( 'search_min_chars' );
    $minimum_char_length = ( $minimum_char_length ? (int) $minimum_char_length : 3 );
    if ( isset( $_REQUEST['action'] ) && 'basepress_smart_search' == $_REQUEST['action'] ) {
        $snippet_length = apply_filters( 'basepress_smart_search_snippet_length', 200 );
    }
    if ( '' != $terms ) {
        $terms = $basepress_search->filter_terms( $terms );
        $search_terms = explode( ' ', $terms );
        $content = $post->post_content;
        //Strip shortcodes from content
        $content = $basepress_search->strip_shortcodes( $content );
        //Strip html tags from content
        $content = wp_strip_all_tags( $content );
        $snippet = $basepress_search->get_snippet( $terms, $content, $snippet_length );
        $disable_word_boundaries = $basepress_utils->get_option( 'search_disable_word_boundary' );
        $word_boundary = ( $disable_word_boundaries ? '' : apply_filters( 'basepress_snippet_word_boundary', '\\b' ) );
        foreach ( $search_terms as $term ) {
            if ( strlen( $term ) >= apply_filters( 'basepress_search_min_char_length', $minimum_char_length ) ) {
                $snippet = preg_replace( '@(' . $word_boundary . preg_quote( $term, '@' ) . ')@i', "<b>\\1</b>", $snippet );
            }
        }
        echo apply_filters( 'basepress_search_snippet', $snippet, get_post() );
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/*
 *	Votes
 */
/**
 * Calls the render function on the vote class
 *
 * @since 1.0.0
 */
function basepress_votes() {
}

/**
 * Return true if Votes are active. False otherwise.
 *
 * @since 2.3.2
 *
 * @return bool
 */
function basepress_show_post_votes() {
    return false;
}

function basepress_dislike_button_is_hidden() {
    return false;
}

/*
 *  Previous and next articles
 */
/**
 * Checks if Previous and Next article links should be shown
 *
 * @since 1.2.0
 *
 * @return bool
 */
function basepress_show_adjacent_articles() {
    return false;
}

/**
 * Return the previous article object
 *
 * @since 1.2.0
 *
 * @return mixed
 */
function basepress_prev_article() {
}

/**
 * Return the next article object
 *
 * @since 1.2.0
 *
 * @return mixed
 */
function basepress_next_article() {
}

/**
 * Return the title to display on previous article link as per options
 *
 * @since 1.2.0
 *
 * @return string
 */
function basepress_prev_article_text() {
}

/**
 * Return the title to display on next article link as per options
 *
 * @since 1.2.0
 *
 * @return string
 */
function basepress_next_article_text() {
}

/*
 *  Table of Content
 */
/**
 * Check if the Table of Content should be displayed according to options
 *
 * @since 1.2.0
 *
 * @return bool
 */
function basepress_show_table_of_content() {
    return false;
}

/**
 * Renders the Table of Content title as specified in the options
 *
 * @since 1.2.0
 */
function basepress_table_of_content_title() {
}

/**
 * Renders the Table of Content which is stored already in $GLOBALS
 */
function basepress_table_of_content() {
}

/*
 * Restricted Content
 */
/**
 * Return the restricted content notice set in the options
 *
 * @since 1.6.0
 *
 * @return mixed
 */
function basepress_restricted_notice() {
}

/**
 * Checks if the restricted content teaser should be shown
 *
 * @since 1.6.0
 *
 * @return mixed
 */
function basepress_show_restricted_teaser() {
    return false;
}

/**
 * Return the restricted content teaser
 *
 * @since 1.6.0
 *
 * @updated 2.9.2
 *
 * @return mixed
 */
function basepress_article_teaser() {
}

/**
 * Truncates HTML content to the length
 *
 * @since 2.3.0
 *
 * @param $content
 * @param $length
 * @return string
 */
function basepress_truncate_HTML(  $content, $length  ) {
    $trimmed_length = 0;
    $trimmed_content = '';
    preg_match_all(
        '/(<\\/?([\\w+]+)[^>]*>)?([^<>]*)/',
        $content,
        $tags,
        PREG_SET_ORDER
    );
    foreach ( $tags as $tag ) {
        //If the tag has no content continue
        $cleaned_tag = trim( $tag[3], "\n.\r.\n\r.\r\n." );
        if ( !empty( $cleaned_tag ) ) {
            $tag_stack = explode( ' ', $cleaned_tag );
            foreach ( $tag_stack as $index => $word ) {
                $trimmed_length += mb_strlen( $word );
                //If we are over the length break out
                if ( $trimmed_length > $length ) {
                    break 2;
                }
                $trimmed_content .= ( !$index ? $tag[1] : '' );
                $trimmed_content .= ' ' . $word;
            }
        } else {
            $trimmed_content .= $tag[0];
        }
    }
    return $trimmed_content;
}

/**
 * Closes all HTML tags
 *
 * @since 2.3.0
 *
 * @param $html
 * @return string
 */
function basepress_close_HTML_tags(  $html  ) {
    preg_match_all( '#<(?!meta|img|br|hr|input\\b)\\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result );
    $openedtags = $result[1];
    preg_match_all( '#</([a-z]+)>#iU', $html, $result );
    $closedtags = $result[1];
    $len_opened = count( $openedtags );
    if ( count( $closedtags ) == $len_opened ) {
        return $html;
    }
    $openedtags = array_reverse( $openedtags );
    for ($i = 0; $i < $len_opened; $i++) {
        if ( !in_array( $openedtags[$i], $closedtags ) ) {
            $html .= '</' . $openedtags[$i] . '>';
        } else {
            unset($closedtags[array_search( $openedtags[$i], $closedtags )]);
        }
    }
    return $html;
}

/**
 * Checks if the login form should be shown on restricted content
 * @since 1.6.0
 * @return mixed
 */
function basepress_show_restricted_login() {
    return false;
}

/**
 * Loads the header according to settings
 *
 * @since 2.4.1
 *
 * @param $name
 */
function basepress_get_header(  $name  ) {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    if ( !isset( $options['skip_header_footer'] ) ) {
        get_header( $name );
    }
}

/**
 * Loads the footer according to settings
 *
 * @since 2.4.1
 *
 * @param $name
 */
function basepress_get_footer(  $name  ) {
    global $basepress_utils;
    $options = $basepress_utils->get_options();
    if ( !isset( $options['skip_header_footer'] ) ) {
        get_footer( $name );
    }
}

function basepress_color_brightness(  $hex, $value  ) {
    // Normalize into a six character long hex string
    $hex = str_replace( '#', '', $hex );
    if ( strlen( $hex ) == 3 ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }
    //Split into R, G, B and add the value to change the color by
    $color_parts = str_split( $hex, 2 );
    $r = hexdec( $color_parts[0] ) + $value;
    $g = hexdec( $color_parts[1] ) + $value;
    $b = hexdec( $color_parts[2] ) + $value;
    //Make values within range 0-255
    $r = max( min( $r, 255 ), 0 );
    $g = max( min( $g, 255 ), 0 );
    $b = max( min( $b, 255 ), 0 );
    //Convert RGB to HEX
    $new_hex = sprintf(
        "#%02x%02x%02x",
        $r,
        $g,
        $b
    );
    return $new_hex;
}

/**
 * Utility function to change brightness of a color from hex to hsl format
 * Not used yet
 *
 * @since 2.8.0
 *
 * @param $hex
 * @param $steps
 * @return string
 */
function _basepress_color_brightness(  $hex, $method, $value  ) {
    $rgb = basepress_hex_2_rgb( $hex );
    $hsl = basepress_rgb_2_hsl( $rgb );
    if ( 'relative' == $method ) {
        $hsl['h'] = ( false === $value[0] ? $hsl['h'] : $hsl['h'] + $value[0] );
        $hsl['h'] = ( $hsl['l'] >= 359 ? 359 : $hsl['h'] );
        $hsl['h'] = ( $hsl['l'] <= 0 ? 0 : $hsl['h'] );
        $hsl['s'] = ( false === $value[1] ? $hsl['s'] : $hsl['s'] + $value[1] );
        $hsl['s'] = ( $hsl['s'] >= 100 ? 100 : $hsl['s'] );
        $hsl['s'] = ( $hsl['s'] <= 0 ? 0 : $hsl['s'] );
        $hsl['l'] = ( false === $value[2] ? $hsl['l'] : $hsl['l'] + $value[2] );
        $hsl['l'] = ( $hsl['l'] >= 100 ? 96 : $hsl['l'] );
        $hsl['l'] = ( $hsl['l'] <= 0 ? 4 : $hsl['l'] );
    } else {
        $hsl['h'] = ( false === $value[0] ? $hsl['h'] : $value[0] );
        $hsl['s'] = ( false === $value[1] ? $hsl['s'] : $value[1] );
        $hsl['l'] = ( false === $value[2] ? $hsl['l'] : $value[2] );
    }
    $color = "hsl({$hsl['h']}, {$hsl['s']}%, {$hsl['l']}%)";
    return $color;
}

/**
 * Utility function to convert hexadecimal color to RGB
 *
 * @since 2.8.0
 *
 * @param $hex
 * @return array
 */
function basepress_hex_2_rgb(  $hex  ) {
    // Normalize into a six character long hex string
    $hex = str_replace( '#', '', $hex );
    if ( strlen( $hex ) == 3 ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }
    // Split into three parts: R, G and B
    $color_parts = str_split( $hex, 2 );
    $rgb = array();
    $rgb['r'] = hexdec( $color_parts[0] );
    // Convert to decimal
    $rgb['g'] = hexdec( $color_parts[1] );
    // Convert to decimal
    $rgb['b'] = hexdec( $color_parts[2] );
    // Convert to decimal
    return $rgb;
}

/**
 * Utility function to convert RGB color to HSL
 *
 * @since 2.8.0
 *
 * @param $rgb
 * @return array
 */
function basepress_rgb_2_hsl(  $rgb  ) {
    $r = $rgb['r'] / 255;
    $g = $rgb['g'] / 255;
    $b = $rgb['b'] / 255;
    $max = max( $r, $g, $b );
    $min = min( $r, $g, $b );
    $h = 0;
    $l = ($max + $min) / 2;
    $d = $max - $min;
    if ( $d == 0 ) {
        $h = $s = 0;
        // achromatic
    } else {
        $s = $d / (1 - abs( 2 * $l - 1 ));
        switch ( $max ) {
            case $r:
                $h = 60 * fmod( ($g - $b) / $d, 6 );
                if ( $b > $g ) {
                    $h += 360;
                }
                break;
            case $g:
                $h = 60 * (($b - $r) / $d + 2);
                break;
            case $b:
                $h = 60 * (($r - $g) / $d + 4);
                break;
        }
    }
    $h = ($h + 360) % 360;
    $s = round( $s * 100 );
    $l = round( $l * 100 );
    return array(
        'h' => $h,
        's' => $s,
        'l' => $l,
    );
}

/**
 * Include deprecated functions
 */
require_once 'public-functions-deprecated.php';