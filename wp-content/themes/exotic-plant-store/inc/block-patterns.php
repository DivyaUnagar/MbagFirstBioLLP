<?php   
/**
 * Block Patterns
 *
 * @package Exotic Plant Store
 * @since 1.0
 */

/**
 * Registers block patterns and categories.
 *
 * @since 1.0
 *
 * @return void
 */
function exotic_plant_store_register_block_patterns() {
	$block_pattern_categories = array(
		'exotic-plant-store' => array( 'label' => esc_html__( 'Exotic Plant Store Patterns', 'exotic-plant-store' ) ),
		'pages'    => array( 'label' => esc_html__( 'Pages', 'exotic-plant-store' ) ),
	);

	$block_pattern_categories = apply_filters( 'exotic_plant_store_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	$block_patterns = array(
		'header-default',
		'header-banner',
		'garden-section',
		'inner-banner',
		'latest-blog',
		'hidden-404',
		'sidebar',
		'footer-default',	
	);

	$block_patterns = apply_filters( 'exotic_plant_store_block_patterns', $block_patterns );

	foreach ( $block_patterns as $block_pattern ) {
		$pattern_file = get_parent_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );

		register_block_pattern(
			'exotic-plant-store/' . $block_pattern,
			require $pattern_file
		);
	}
}
add_action( 'init', 'exotic_plant_store_register_block_patterns', 9 );