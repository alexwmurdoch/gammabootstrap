<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package alphabootstrap
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alphabootstrap_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'alphabootstrap_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function alphabootstrap_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'alphabootstrap_pingback_header' );

/**
 * Custom Read More Button
 */
function modify_read_more_link() {

    $read_txt = alphabootstrap_option('read_more_text', 'Read More');
    $btn_block = (alphabootstrap_option('read_more_block') == '1' ? 'btn-block' : '');
    $btn_size = 'btn-' . alphabootstrap_option('read_more_size');
    $btn_color = 'btn-' . alphabootstrap_option('read_more_color');


    return '<p><a class="more-link btn '. $btn_color .' '. $btn_size .' '. $btn_block .'" href="' . get_permalink() . '">'. $read_txt .'</a></p>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );
/**
 * Custom Edit Button
 */
function alphabootstrap_custom_edit_post_link($output) {

    $output = str_replace('class="post-edit-link"', 'class="post-edit-link btn btn-default btn-xs"', $output);
    return $output;
}

add_filter('edit_post_link', 'alphabootstrap_custom_edit_post_link');

/**
 * Editing the Tag Widget
 * note: make the largest and smallest args the same for same sizing!
 */
function alphabootstrap_my_widget_tag_cloud_args($args) {
    $args['largest'] = 14;
    $args['smallest'] = 14;
    $args['unit'] = 'px';
    return $args;
}

add_filter('widget_tag_cloud_args', 'alphabootstrap_my_widget_tag_cloud_args');