<?php
/**
 * Alpha Bootstrap functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Alpha_Bootstrap
 */

if ( ! function_exists( 'alphabootstrap_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function alphabootstrap_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Alpha Bootstrap, use a find and replace
	 * to change 'alphabootstrap' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'alphabootstrap', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
        'primary' => esc_html__('Primary', 'alphabootstrap'),
        'footer-menu' => __('Footer Menu', 'alphabootstrap'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'alphabootstrap_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

    // Add theme support for Custom Logo
    add_theme_support( 'custom-logo', array(
        'width' => 90,
        'height' => 90,
        'flex-width' => true,
    ));

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'alphabootstrap_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function alphabootstrap_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'alphabootstrap_content_width', 640 );
}
add_action( 'after_setup_theme', 'alphabootstrap_content_width', 0 );

/**
 * Register custom fonts.
 */
function alphabootstrap_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Source Sans Pro and PT Serif, translate this to 'off'. Do not translate
     * into your own language.
     */

    $raleway = _x( 'on', 'Raleway font: on or off', 'alphabootstrap' );
//    $pt_serif = _x( 'on', 'PT Serif font: on or off', 'alphabootstrap' );

    $font_families = array();

    if ( 'off' !== $raleway ) {
        $font_families[] = 'Raleway:200,300,600,700';
    }

//    if ( 'off' !== $pt_serif ) {
//        $font_families[] = 'PT Serif:400,400i,700,700i';
//    }

//    if ( in_array( 'on', array($raleway,$pt_serif ) ) ) {
    if ( in_array( 'on', array($raleway) ) ) {

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}


/**
 * Add preconnect for Google Fonts.
 *
 * @since alphabootstrap 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function alphabootstrap_resource_hints( $urls, $relation_type ) {
    if ( wp_style_is( 'alphabootstrap-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'alphabootstrap_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alphabootstrap_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'alphabootstrap'),
        'id' => 'sidebar-blog',
        'description' => esc_html__('Add widgets here.', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Page Sidebar', 'alphabootstrap'),
        'id' => 'sidebar-page',
        'description' => esc_html__('Add widgets here.', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Widget 1', 'alphabootstrap'),
        'id' => 'footer-widget-1',
        'description' => esc_html__('Used for footer widget area', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Widget 2', 'alphabootstrap'),
        'id' => 'footer-widget-2',
        'description' => esc_html__('Used for footer widget area', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Widget 3', 'alphabootstrap'),
        'id' => 'footer-widget-3',
        'description' => esc_html__('Used for footer widget area', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer Widget 4', 'alphabootstrap'),
        'id' => 'footer-widget-4',
        'description' => esc_html__('Used for footer widget area', 'alphabootstrap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'Home 1', 'alphabootstrap' ),
        'id'            => 'home-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Home 2', 'alphabootstrap' ),
        'id'            => 'home-2',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Home 3', 'alphabootstrap' ),
        'id'            => 'home-3',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

}
add_action( 'widgets_init', 'alphabootstrap_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function alphabootstrap_scripts() {
    //enqueue Google fonts: Source Sans Pro and PT Serif
    wp_enqueue_style('alphabootstrap-fonts',alphabootstrap_fonts_url());

    wp_enqueue_style('alphabootstrap-style', get_stylesheet_uri());

    wp_enqueue_style( 'bootstrap-styles', get_template_directory_uri() . '/css/'. alphabootstrap_option('css_style', 'bootstrap.min.css'), array(), '3.3.0', 'all' );



    //wp_enqueue_script( 'alphabootstrap-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script('alphabootstrap-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    /**
     * addd respond.js and html5shiv.js for IE9
     */
    global $wp_scripts;
    wp_register_script('alphabootstrap-html5_shiv', 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', '', '', false);
    wp_register_script('alphabootstrap-respond_js', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', '', '', false);
    $wp_scripts->add_data('alphabootstrap-html5_shiv', 'conditional', 'lt IE 9');
    $wp_scripts->add_data('alphabootstrap-respond_js', 'conditional', 'lt IE 9');

    wp_enqueue_script('alphabootstrap-bootstrap-script', get_template_directory_uri() . '/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js', array('jquery'), '3.3.7', true);

    wp_enqueue_script('alphabootstrap-bootstrap-dropdown-hover-script', get_template_directory_uri() . '/bower_components/bootstrap-dropdown-hover/dist/jquery.bootstrap-dropdown-hover.min.js',
        array('jquery', 'alphabootstrap-bootstrap-script'), '3.3.7', true);
    wp_enqueue_script('alphabootstrap-bootstrap-select-script', get_template_directory_uri() . '/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js',
        array('jquery', 'alphabootstrap-bootstrap-script'), '3.3.7', true);

    wp_enqueue_script( 'isotope-js', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery'), '2.0.1', true );
    wp_enqueue_script( 'imagesloaded-js', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), '3.1.8', true );

    wp_enqueue_script('alphabootstrap-custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery', 'alphabootstrap-bootstrap-script', 'alphabootstrap-bootstrap-select-script'), '1.0.0', true);


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action( 'wp_enqueue_scripts', 'alphabootstrap_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Bootstrap navigation and paging tags.
 */
require get_template_directory() . '/inc/posts-nav-page.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Recommend the Kirki plugin
 */
require get_template_directory() . '/inc/include-kirki.php';

/**
 * Load the Kirki Fallback class
 */
require get_template_directory() . '/inc/kirki-fallback.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Bootstrap custom nav walker class.
 */
require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Comments Callback.
 */

require get_template_directory() . '/inc/comments-callback.php';

/**
 * Author Meta.
 */
require get_template_directory() . '/inc/author-meta.php';

/**
 * Search Results - Highlight.
 */
require get_template_directory() . '/inc/search-highlight.php';

/**
 * Plugin activation.
 */
require get_template_directory() . '/inc/plugin-activation.php';

/**
 * Redux Framework.
 */
require get_template_directory() . '/inc/theme-options.php';
require get_template_directory() . '/inc/alphabootstrap-options.php';

/**
 * Theme Options - Custom CSS.
 */
require get_template_directory() . '/inc/custom-css.php';