<?php
/**
 * Customizer
 * 
 * @package WordPress
 * @subpackage Exotic Plant Store
 * @since Exotic Plant Store 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function exotic_plant_store_customize_register( $wp_customize ) {
    // Check for existence of WP_Customize_Manager before proceeding
	if ( ! class_exists( 'WP_Customize_Manager' ) ) {
        return;
    }
    
	$wp_customize->add_section( new Exotic_Plant_Store_Customizer_Pro_Button( $wp_customize, 'upsell_premium_section', array(
		'title'       => __( 'Exotic Plant Store Pro', 'exotic-plant-store' ),
		'button_text' => __( 'Buy Pro Theme', 'exotic-plant-store' ),
		'url'         => esc_url( EXOTIC_PLANT_STORE_BUY_NOW ),
		'priority'    => 0,
	)));

}
add_action( 'customize_register', 'exotic_plant_store_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) ) {
	class Exotic_Plant_Store_Customizer_Pro_Button extends WP_Customize_Section {
		public $type = 'exotic-plant-store-buynow';
		public $button_text = '';
		public $url = '';

		protected function render() {
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="exotic_plant_store_customizer_pro_button accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title premium-details">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}

/**
 * Enqueue script for custom customize control.
 */
function exotic_plant_store_custom_control_scripts() {
	wp_enqueue_script( 'exotic-plant-store-custom-controls-js', get_template_directory_uri() . '/assets/js/custom-controls.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0', true );

    wp_enqueue_style( 'exotic-plant-store-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', array(), '1.0' );
}
add_action( 'customize_controls_enqueue_scripts', 'exotic_plant_store_custom_control_scripts' );
