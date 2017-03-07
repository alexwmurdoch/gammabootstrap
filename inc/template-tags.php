<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package alphabootstrap
 */

if (!function_exists('alphabootstrap_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function alphabootstrap_posted_on() {

        if (alphabootstrap_option('disable_meta') =='1') {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
            if (get_the_time('U') !== get_the_modified_time('U')) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
            );

            $posted_on = sprintf(
                esc_html_x(' %s', 'post date', 'alphabootstrap'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
            );

            $byline = sprintf(
                esc_html_x(' %s', 'post author', 'alphabootstrap'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
            );

            echo '<span class="posted-on"><i class="fa fa-calendar" aria-hidden="true"></i> ' . $posted_on . '</span><span class="byline"><i class="fa fa-user" aria-hidden="true"></i> ' . $byline . '</span>'; // WPCS: XSS OK.
        }
    }

endif;

if (!function_exists('alphabootstrap_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function alphabootstrap_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */

            if (alphabootstrap_option('enable_disable_tags') =='1') {

                $categories_list = get_the_category_list(esc_html__(', ', 'alphabootstrap'));
                if ($categories_list && alphabootstrap_categorized_blog()) {
                    printf('<span class="cat-links"><i class="fa fa-folder-open" aria-hidden="true"></i>' . esc_html__(' %1$s', 'alphabootstrap') . '</span>', $categories_list); // WPCS: XSS OK.
                }
            }

            if (alphabootstrap_option('enable_disable_tags') == '1'){
                /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list('', esc_html__(', ', 'alphabootstrap'));
                if ($tags_list) {
                    printf('<span class="tags-links"><i class="fa fa-tags" aria-hidden="true"></i>' . esc_html__(' %1$s', 'alphabootstrap') . '</span>', $tags_list); // WPCS: XSS OK.
                }
            }
        }


            if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                echo '<span class="comments-link"><i class="fa fa-comments"></i>';
                /* translators: %s: post title */
                comments_popup_link(sprintf(wp_kses(__(' Leave a Comment<span class="sr-only"> on %s</span>', 'alphabootstrap'), array('span' => array('class' => array()))), get_the_title()));
                echo '</span>';
            }


        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                esc_html__('Edit %s', 'alphabootstrap'), the_title('<span class="sr-only">"', '"</span>', false)
            ), '<span class="edit-link">', '</span>'
        );
    }

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function alphabootstrap_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'alphabootstrap_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'alphabootstrap_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        // This blog has more than 1 category so alphabootstrap_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so alphabootstrap_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in alphabootstrap_categorized_blog.
 */
function alphabootstrap_category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient( 'alphabootstrap_categories' );
}
add_action( 'edit_category', 'alphabootstrap_category_transient_flusher' );
add_action( 'save_post',     'alphabootstrap_category_transient_flusher' );


function alphabootstrap_author_bio() {
    // Display author bio if post isn't password protected
    if (!post_password_required() && is_single()) {
        if (get_the_author_meta('description') != '') {
            echo '<div class="author-meta well well-lg"><div class="media"><div class="media-object pull-left">';
            // Display author avatar if author has a Gravatar
            if ( alphabootstrap_validate_gravatar( get_the_author_meta( 'ID' ) ) ) {
                echo get_avatar(get_the_author_meta('ID'), 80);
            }
            echo '</div><div class="media-body"><h3 class="media-heading">';
            the_author_posts_link();
            echo '</h3><p>';
            the_author_meta('description');
            echo '</p>';
            // Retrieve a custom field value
            $twitterHandle = get_the_author_meta('twitter');
            $fbHandle = get_the_author_meta('facebook');
            $gHandle = get_the_author_meta('gplus');
            echo '<p class="author-social">';
            if (get_the_author_meta('twitter') != '') {
                echo '<a href="http://twitter.com/' . esc_html($twitterHandle) . '" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>';
            }
            if (get_the_author_meta('facebook') != '') {
                echo '<a href="' . esc_url($fbHandle) . '" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>';
            }
            if (get_the_author_meta('gplus') != '') {
                echo '<a href="' . esc_url($gHandle) . '" target="_blank"><i class="fa fa-google-plus fa-lg"></i></a>';
            }
            echo '</p></div></div></div>';
        }
    }
}

/**
 * Utility function to check if a gravatar exists for a given email or id
 * Original source: https://gist.github.com/justinph/5197810
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */

function alphabootstrap_validate_gravatar($id_or_email) {
    //id or email code borrowed from wp-includes/pluggable.php
    $email = '';
    if ( is_numeric($id_or_email) ) {
        $id = (int) $id_or_email;
        $user = get_userdata($id);
        if ( $user )
            $email = $user->user_email;
    } elseif ( is_object($id_or_email) ) {
        // No avatar for pingbacks or trackbacks
        $allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
        if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
            return false;

        if ( !empty($id_or_email->user_id) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_userdata($id);
            if ( $user)
                $email = $user->user_email;
        } elseif ( !empty($id_or_email->comment_author_email) ) {
            $email = $id_or_email->comment_author_email;
        }
    } else {
        $email = $id_or_email;
    }

    $hashkey = md5(strtolower(trim($email)));
    $uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

    $data = wp_cache_get($hashkey);
    if (false === $data) {
        $response = wp_remote_head($uri);
        if( is_wp_error($response) ) {
            $data = 'not200';
        } else {
            $data = $response['response']['code'];
        }
        wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);

    }
    if ($data == '200'){
        return true;
    } else {
        return false;
    }
}




/**
 * Customise the excerpt read-more indicator.
 *
 */
function alphabootstrap_excerpt_more($more){
    return " ...";
}
add_filter('excerpt_more','alphabootstrap_excerpt_more' );


if ( ! function_exists( 'alphabootstrap_attachment_nav' ) ) :
    /**
     * Display navigation to next/previous image in attachment pages.
     */
    function alphabootstrap_attachment_nav() {
        ?>
        <nav class="navigation post-navigation" role="navigation">
            <div class="post-nav-box clear">
                <h2 class="sr-only"><?php _e( 'Attachment post navigation', 'alphabootstrap' ); ?></h2>
                <ul class="pager">
                    <li class="previous">
                        <?php previous_image_link( false, '<span class="post-title">Previous image</span>' ); ?>
                    </li>
                    <li class="next">
                        <?php next_image_link( false, '<span class="post-title">Next image</span>' ); ?>
                    </li>
                </ul><!-- .nav-links -->


            </div>
        </nav>


        <?php
    }
endif;



if ( ! function_exists( 'alphabootstrap_the_attached_image' ) ) :
    /**
     * Print the attached image with a link to the next attached image.
     * Appropriated from Twenty Fourteen 1.0
     */
    function alphabootstrap_the_attached_image() {
        $post = get_post();
        /**
         * Filter the default attachment size.
         */
        $attachment_size = apply_filters( 'alphabootstrap_attachment_size', array( 810, 810 ) );
        $next_attachment_url = wp_get_attachment_url();
        /*
         * Grab the IDs of all the image attachments in a gallery so we can get the URL
         * of the next adjacent image in a gallery, or the first image (if we're
         * looking at the last image in a gallery), or, in a gallery of one, just the
         * link to that image file.
         */
        $attachment_ids = get_posts( array(
            'post_parent'    => $post->post_parent,
            'fields'         => 'ids',
            'numberposts'    => -1,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'ASC',
            'orderby'        => 'menu_order ID',
        ) );
        // If there is more than 1 attachment in a gallery...
        if ( count( $attachment_ids ) > 1 ) {
            foreach ( $attachment_ids as $attachment_id ) {
                if ( $attachment_id == $post->ID ) {
                    $next_id = current( $attachment_ids );
                    break;
                }
            }
            // get the URL of the next image attachment...
            if ( $next_id ) {
                $next_attachment_url = get_attachment_link( $next_id );
            }
            // or get the URL of the first image attachment.
            else {
                $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
            }
        }


        printf( '<a href="%1$s" rel="attachment">%2$s</a>',
            esc_url( $next_attachment_url ),
            wp_get_attachment_image( $post->ID, $attachment_size )
        );
    }
endif;



if (!function_exists('alphabootstrap_the_custom_logo')) :
    /**
     * Displays the optional custom logo.
     *
     * Does nothing if the custom logo is not available.
     *
     */
    function alphabootstrap_the_custom_logo() {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            echo '<img src="'. esc_url( $logo[0] ) .'">';
        }
    }
endif;

if (!function_exists('alphabootstrap_logo_sitetitle')) :
    /**
     * Displays the optional custom logo if exists or site title
     *
     *
     */
    function alphabootstrap_logo_sitetitle() {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            echo '<img src="'. esc_url( $logo[0] ) .'">';
        } else {
            echo  esc_attr( get_bloginfo( 'name' ) );
        }
    }
endif;