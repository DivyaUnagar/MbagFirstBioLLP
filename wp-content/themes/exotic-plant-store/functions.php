<?php
/**
 * Exotic Plant Store functions and definitions
 *
 * @package Exotic Plant Store
 * @since 1.0
 */

if ( ! function_exists( 'exotic_plant_store_support' ) ) :
	function exotic_plant_store_support() {

		load_theme_textdomain( 'exotic-plant-store', get_template_directory() . '/languages' );

		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-background', apply_filters( 'exotic_plant_store_custom_background', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
		
		add_theme_support( 'wp-block-styles' );

		add_editor_style( 'style.css' );
		
		define('EXOTIC_PLANT_STORE_BUY_NOW',__('https://www.themescarts.com/products/exotic-plant-wordpress-theme/','exotic-plant-store'));
		define('EXOTIC_PLANT_STORE_FOOTER_BUY_NOW',__('https://www.themescarts.com/products/free-plant-wordpress-theme/','exotic-plant-store'));

	}
endif;
add_action( 'after_setup_theme', 'exotic_plant_store_support' );

/*-------------------------------------------------------------
 Enqueue Styles
--------------------------------------------------------------*/

if ( ! function_exists( 'exotic_plant_store_styles' ) ) :
	function exotic_plant_store_styles() {
		// Register theme stylesheet.
		wp_enqueue_style('exotic-plant-store-style', get_stylesheet_uri(), array(), wp_get_theme()->get('version') );
		wp_enqueue_style('exotic-plant-store-style-blocks', get_template_directory_uri(). '/assets/css/blocks.css');
		wp_enqueue_style('exotic-plant-store-style-responsive', get_template_directory_uri(). '/assets/css/responsive.css');
		wp_style_add_data( 'exotic-plant-store-basic-style', 'rtl', 'replace' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'exotic_plant_store_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

require_once get_theme_file_path( 'inc/exotic-plant-store-theme-info-page/templates/class-theme-notice.php' );
require_once get_theme_file_path( 'inc/exotic-plant-store-theme-info-page/class-theme-info.php' );

require_once get_theme_file_path( '/inc/customizer.php' );

?>