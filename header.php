<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "main" tag.
 *
 * @package solo
 * @since   1.0
 */

?><!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" aria-label="first content" href="#sitecontent">
        <?php esc_html_e( 'Skip to content', 'solo' ); ?>
    </a>

    

        <header class="page-header" aria-label="Banner">
            <div class="solo-logo-container">
                <?php 
                if( has_custom_logo() ) : ?>

                <div class="site-logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                        rel="bookmark"><?php echo wp_kses_post( 
                        force_balance_tags( solo_theme_custom_logo() ) ); ?></a>
                </div>
                <?php 
                endif; ?>
                <div class="solo-mobi-descr-logo">
                    <div class="site-description">

                        <?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>

                    </div>            
                </div>
            </div>
                <div class="page-header-inner solo-logo-container">
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" 
                        rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <div class="solo-mobi-descr-desk">
                        <div class="site-description">

                            <?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>

                        </div>            
                    </div>  
                </div>

                    <div class="page-header-declare solo-logo-container">

                        <?php do_action( 'solo_header_declaration' ); ?>
                    
                    </div>

        </header>
            <div class="nav-container">
               <div class="nav-button-wrapper">
                    <button id="nav_button" aria-expanded="true" aria-controls="page_nav">
                        <div></div>
                        <div></div>
                        <div></div>
            </button>
                </div>
                    <nav class="page-nav-wrapper" aria-label="Primary" style="">
                        <div id="page_nav" class="nav-wrapper">

                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'primary-menu',
                                'depth'          => 3,
                                'container'     => 'div',
                                'menu_class'   => 'page-nav',
                                'fallback_cb' => 'wp_page_menu',
                            )
                        ); ?>
                            
                        </div>
                    </nav>
            </div>  

    <div class="page-wrap"><!-- ends in footer template part -->
