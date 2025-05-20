<?php
/**
 * Custom header implementation
 *
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package Food Grocery Hub
 * @subpackage food_grocery_hub
 */

function food_grocery_hub_custom_header_setup() {
   
    register_default_headers( array(
        'default-image' => array(
            'url'           => get_template_directory_uri() . '/assets/images/sliderimage.png',
            'thumbnail_url' => get_template_directory_uri() . '/assets/images/sliderimage.png',
            'description'   => __( 'Default Header Image', 'food-grocery-hub' ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'food_grocery_hub_custom_header_setup' );

/**
 * Styles the header image based on Customizer settings.
 */
function food_grocery_hub_header_style() {
    $food_grocery_hub_header_image = get_header_image() ? get_header_image() : get_template_directory_uri() . '/assets/images/sliderimage.png';

    $food_grocery_hub_height     = get_theme_mod( 'food_grocery_hub_header_image_height', 400 );
    $food_grocery_hub_position   = get_theme_mod( 'food_grocery_hub_header_background_position', 'center' );
    $food_grocery_hub_attachment = get_theme_mod( 'food_grocery_hub_header_background_attachment', 1 ) ? 'fixed' : 'scroll';

    $food_grocery_hub_custom_css = "
        .header-img, .single-page-img, .external-div .box-image-page img, .external-div {
            background-image: url('" . esc_url( $food_grocery_hub_header_image ) . "');
            background-size: cover;
            height: " . esc_attr( $food_grocery_hub_height ) . "px;
            background-position: " . esc_attr( $food_grocery_hub_position ) . ";
            background-attachment: " . esc_attr( $food_grocery_hub_attachment ) . ";
        }

        @media (max-width: 1000px) {
            .header-img, .single-page-img, .external-div .box-image-page img,.external-div,.featured-image{
                height: 250px !important;
            }
            .box-text h2{
                font-size: 27px;
            }
        }
    ";

    wp_add_inline_style( 'food-grocery-hub-style', $food_grocery_hub_custom_css );
}
add_action( 'wp_enqueue_scripts', 'food_grocery_hub_header_style' );

/**
 * Enqueue the main theme stylesheet.
 */
function food_grocery_hub_enqueue_styles() {
    wp_enqueue_style( 'food-grocery-hub-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'food_grocery_hub_enqueue_styles' );