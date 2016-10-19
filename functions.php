<?php

/*------------------------------------------------------------
 * Include child-theme css styles
 *------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'sleek_child_load_styles', 11 );
function sleek_child_load_styles() {
    wp_enqueue_style( 'sleek_child_main_style', get_stylesheet_uri() );
}

/*------------------------------------------------------------
 * Include child-theme language files
 *------------------------------------------------------------*/

add_action( 'after_setup_theme', 'sleek_child_load_textdomain' );
function sleek_child_load_textdomain() {
    load_child_theme_textdomain( 'sleek', get_stylesheet_directory() . '/languages' );
}

/*------------------------------------------------------------
 * Custom functions start here
 *------------------------------------------------------------*/

/***
* Network visualization widget
***/

include('network-visualization-widget.php');

/***
* Category page teaser widget
***/

include('category-teaser-widget.php');
