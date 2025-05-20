<?php
/**
* 
* @since Flectine 1.0
*/
function flectine_child_css() {
	$flectine_parent_theme_css = 'flixita-style';
	wp_enqueue_style( 
		$flectine_parent_theme_css, 
		get_template_directory_uri() . '/style.css' 
	);
	wp_enqueue_style( 
		'flectine-style', 
		get_stylesheet_uri(), 
		array( $flectine_parent_theme_css )
	);
}
add_action( 'wp_enqueue_scripts', 'flectine_child_css',999);

require get_stylesheet_directory() . '/core/customizer/custom-controls/customize-upgrade-control.php';

/**
 * Import Options From Parent Theme
 *
 */
function flectine_parent_theme_options() {
    $flixita_mods = get_option( 'theme_mods_flixita' );
    if ( ! empty( $flixita_mods ) ) {
        foreach ( $flixita_mods as $flixita_mod_k => $flixita_mod_v ) {
            set_theme_mod( $flixita_mod_k, $flixita_mod_v );
        }
    }
}
add_action( 'after_switch_theme', 'flectine_parent_theme_options' );
