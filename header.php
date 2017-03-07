<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alphabootstrap
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'alphabootstrap'); ?></a>

    <header id="masthead" class="site-header" role="banner">

        <?php
            $fixed = (alphabootstrap_option('disable_fixed_navbar') == '1' ? 'navbar-fixed-top' : 'navbar-static-top');
            $inverse = (alphabootstrap_option('disable_inverse_navbar') == '1' ? 'navbar-inverse' : 'navbar-default');
        ?>

        <nav role=navigation" id="site-navigation" class="navbar <?php echo $fixed; ?> <?php echo $inverse; ?> ">
                <div class="container">
                    <!-- note: when we use custom logo in navbar having a row pulls the logo too far left.  Lines up perfect without logo
                         Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#main-menu"
                                aria-expanded="false" aria-controls="primary-menu">
                            <span class="sr-only">Toggle navigation</span><?php esc_html_e('Menu', 'alphabootstrap'); ?> <i
                                    class="fa fa-bars"></i>
                        </button>

                        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home" title="<?php bloginfo( 'name' ) ?>"><?php alphabootstrap_logo_sitetitle(); ?></a>


                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="main-menu">
                        <?php
                        $args = array(
                            'theme_location' => 'primary',
                            'menu_id' => 'primary-menu',
                            'depth' => 2,
                            'container' => false,
                            'menu_class' => 'nav navbar-nav navbar-right',
                            'walker' => new wp_bootstrap_navwalker()
                        );
                        if (has_nav_menu('primary')) {
                            wp_nav_menu($args);
                        }
                        ?>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container -->
            </nav><!-- #site-navigation -->

    </header><!-- #masthead -->
    <div id="content" class="site-content">
