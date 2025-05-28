<?php
/**
 * Theme Info Page
 *
 * @package Exotic Plant Store
 */

function exotic_plant_store_theme_details() {
	add_theme_page( 'Themes', 'Exotic Plant Store Theme', 'edit_theme_options', 'exotic-plant-store-theme-info-page', 'theme_details_display', null );
}
add_action( 'admin_menu', 'exotic_plant_store_theme_details' );

function theme_details_display() {

	include_once 'templates/theme-details.php';

}

add_action( 'admin_enqueue_scripts', 'exotic_plant_store_theme_details_style' );

function exotic_plant_store_theme_details_style() {
    wp_register_style( 'exotic_plant_store_theme_details_css', get_template_directory_uri() . '/inc/exotic-plant-store-theme-info-page/css/theme-details.css', false, '1.0.0' );
    wp_enqueue_style( 'exotic_plant_store_theme_details_css' );
}