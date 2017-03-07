<?php
/**
 * Plugin Name: Custom Portfolio Post Type and Taxonomy
 * Plugin URI: http://yoursite.com
 * Description: A simple plugin that adds portfolio custom post type and taxonomy
 * Version: 0.1
 * Author: Your Name
 * Author URI: http://yoursite.com
 * License: GPL2
 */

/*  Copyright YEAR  YOUR_NAME  (email : your@email.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function my_custom_posttypes() {

    $labels = array(
        'name'               => 'Portfolio',
        'singular_name'      => 'Portfolio',
        'menu_name'          => 'Portfolio',
        'name_admin_bar'     => 'Portfolio',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Portfolio',
        'new_item'           => 'New Portfolio',
        'edit_item'          => 'Edit Portfolio',
        'view_item'          => 'View Portfolio',
        'all_items'          => 'All Portfolios',
        'search_items'       => 'Search Portfolio',
        'parent_item_colon'  => 'Parent Portfolios:',
        'not_found'          => 'No Portfolios found.',
        'not_found_in_trash' => 'No Portfolios found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'portfolio' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'thumbnail','comments' )
    );
    register_post_type( 'portfolio', $args );
}
add_action( 'init', 'my_custom_posttypes' );

// Custom Taxonomies
function my_custom_taxonomies() {

    // Portfolio tag taxonomy (non-hierarchical)
    $labels = array(
        'name'                       => 'Portfolio Tag',
        'singular_name'              => 'Portfolio Tag',
        'search_items'               => 'Search Portfolio Tags',
        'popular_items'              => 'Popular Portfolio Tags',
        'all_items'                  => 'All Portfolio Tags',
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit Portfolio Tag',
        'update_item'                => 'Update Portfolio Tag',
        'add_new_item'               => 'Add New Portfolio Tag',
        'new_item_name'              => 'New Portfolio Tag Name',
        'separate_items_with_commas' => 'Separate portfolio tags with commas',
        'add_or_remove_items'        => 'Add or remove Portfolio Tags',
        'choose_from_most_used'      => 'Choose from the most used portfolio tags',
        'not_found'                  => 'No portfolio tags found.',
        'menu_name'                  => 'Portfolio Tags',
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'portfolio-tag' ),
    );

    register_taxonomy( 'portfolio_tags', array( 'portfolio'), $args );
}

add_action( 'init', 'my_custom_taxonomies' );


// Flush rewrite rules to add "portfolio" as a permalink slug
function my_rewrite_flush() {
    my_custom_posttypes();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );
