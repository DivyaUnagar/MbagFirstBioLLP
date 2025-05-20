<?php

use QuiqOwl\Admin\Helper\Quiqowl_Table;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	exit;
}

$search_column_args = array(
	'columns'  => array(
		'product_id'          => esc_html__( '#UniqueID', 'quiqowl' ),
		'product_title'       => esc_html__( 'Product Name', 'quiqowl' ),
		'product_views'       => esc_html__( 'Views via Plugin', 'quiqowl' ),
		'added_to_cart_count' => esc_html__( 'Added to Cart Count', 'quiqowl' ),
		'product_log'         => esc_html__( 'Cart Log', 'quiqowl' ),
	),
	'sortable' => array(
		'product_views'       => array(
			'product_views',
			true,
			__( 'Views via Plugin', 'quiqowl' ),
			__( 'Table order by Views.', 'quiqowl' ),
		),
		'added_to_cart_count' => array(
			'added_to_cart_count',
			true,
			__( 'Add to Cart Count', 'quiqowl' ),
			__( 'Table order by Added to Cart Count.', 'quiqowl' ),
		),
	),
	'primary'  => 'product_title',
);

$args = array(
	'post_type'      => 'product', // Replace with your custom post type if different.
	'meta_query'     => array(
		array(
			'key'     => 'quiqowl_product_data',
			'compare' => 'EXISTS', // Use 'EXISTS' if you just want products with this meta key.
		),
	),
	'posts_per_page' => -1,
);

$product_query = new \WP_Query( $args );
$products      = $product_query->get_posts();

// Convert products to an array
$product_data_array = array();

foreach ( $products as $product ) {
	$product_id           = $product->ID;
	$quiqowl_product_data = get_post_meta( $product_id, 'quiqowl_product_data', true );
	$product_views        = isset( $quiqowl_product_data['product_history']['views'] ) ? sanitize_text_field( wp_unslash( $quiqowl_product_data['product_history']['views'] ) ) : '0';

	$product = wc_get_product( $product_id );

	// Product added to cart count.
	$total_interactions = 0;

	// Count interactions for logged-in users.
	if ( isset( $quiqowl_product_data['cart_details']['_logged_in_data'] ) && is_array( $quiqowl_product_data['cart_details']['_logged_in_data'] ) ) {
		foreach ( $quiqowl_product_data['cart_details']['_logged_in_data'] as $user_id => $user_data ) {
			// Count the number of timestamps for each user (each timestamp represents one interaction).
			$total_interactions += count( $user_data ); // Each entry in $user_data corresponds to an interaction.
		}
	}

	// Count interactions for non-logged-in users.
	if ( isset( $quiqowl_product_data['cart_details']['_not_logged_in_data'] ) && is_array( $quiqowl_product_data['cart_details']['_not_logged_in_data'] ) ) {
		// Each entry in _not_logged_in_data represents an interaction (one per user ID).
		$total_interactions += count( $quiqowl_product_data['cart_details']['_not_logged_in_data'] );
	}

	$product_data_array[] = array(
		'product_id'          => $product_id,
		'product_title'       => $product->get_title(),
		'product_views'       => $product_views,
		'added_to_cart_count' => $total_interactions,
		'product_log'         => wp_kses(
			'<svg width="16" height="16" viewBox="0 0 25 17" fill="var(--quiqowl-primary-color)" xmlns="http://www.w3.org/2000/svg">
			<path d="M24.8489 7.69965C22.4952 3.1072 17.8355 0 12.5 0C7.16447 0 2.50345 3.10938 0.151018 7.70009C0.0517306 7.89649 0 8.11348 0 8.33355C0 8.55362 0.0517306 8.77061 0.151018 8.96701C2.50475 13.5595 7.16447 16.6667 12.5 16.6667C17.8355 16.6667 22.4965 13.5573 24.8489 8.96658C24.9482 8.77018 25 8.55319 25 8.33312C25 8.11304 24.9482 7.89605 24.8489 7.69965ZM12.5 14.5833C11.2638 14.5833 10.0555 14.2168 9.02766 13.53C7.99985 12.8433 7.19878 11.8671 6.72573 10.7251C6.25268 9.58307 6.12891 8.3264 6.37007 7.11402C6.61123 5.90164 7.20648 4.78799 8.08056 3.91392C8.95464 3.03984 10.0683 2.44458 11.2807 2.20343C12.493 1.96227 13.7497 2.08604 14.8917 2.55909C16.0338 3.03213 17.0099 3.83321 17.6967 4.86102C18.3834 5.88883 18.75 7.0972 18.75 8.33333C18.7504 9.15421 18.589 9.96711 18.275 10.7256C17.9611 11.484 17.5007 12.1732 16.9203 12.7536C16.3398 13.3341 15.6507 13.7944 14.8922 14.1084C14.1338 14.4223 13.3208 14.5837 12.5 14.5833ZM12.5 4.16667C12.1281 4.17186 11.7586 4.22719 11.4015 4.33116C11.6958 4.73119 11.8371 5.22347 11.7996 5.71873C11.7621 6.21398 11.5484 6.6794 11.1972 7.0306C10.846 7.38179 10.3806 7.5955 9.88537 7.63297C9.39012 7.67043 8.89784 7.52917 8.49781 7.23481C8.27001 8.07404 8.31113 8.96357 8.61538 9.77821C8.91962 10.5928 9.47167 11.2916 10.1938 11.776C10.916 12.2605 11.7719 12.5063 12.641 12.4788C13.5102 12.4514 14.3489 12.152 15.039 11.623C15.7291 11.0939 16.236 10.3617 16.4882 9.52951C16.7404 8.69729 16.7253 7.80693 16.445 6.98376C16.1647 6.16058 15.6333 5.44602 14.9256 4.94067C14.2179 4.43532 13.3696 4.16462 12.5 4.16667Z" />
			</svg>
			',
			array(
				'svg'  => array(
					'fill'    => true,
					'viewbox' => true,
					'width'   => true,
					'height'  => true,
					'xmlns'   => true,
				),
				'path' => array(
					'd' => true,
				),
			)
		),
	);
}

$table_args = array(
	'core'       => array(
		'singular' => 'product_table',
		'plural'   => 'product_tables',
	),
	'pagination' => true,
);

?>

<div class="quiqowl-admin__dashboard product-analytics">
	<div class="quiqowl-admin__modal display-none">
		<div class="quiqowl-modal__body">
			<div class="close-icon__wrapper">
				<svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M10.9449 9.66003C11.3049 10.02 11.3049 10.58 10.9449 10.94C10.7649 11.12 10.5449 11.2 10.3049 11.2C10.0649 11.2 9.84493 11.12 9.66493 10.94L6.00492 7.28004L2.34491 10.94C2.16491 11.12 1.94492 11.2 1.70492 11.2C1.46492 11.2 1.24493 11.12 1.06493 10.94C0.704932 10.58 0.704932 10.02 1.06493 9.66003L4.72492 6.00004L1.06493 2.34004C0.704932 1.98004 0.704932 1.42004 1.06493 1.06004C1.42493 0.700037 1.98491 0.700037 2.34491 1.06004L6.00492 4.72003L9.66493 1.06004C10.0249 0.700037 10.5849 0.700037 10.9449 1.06004C11.3049 1.42004 11.3049 1.98004 10.9449 2.34004L7.2849 6.00004L10.9449 9.66003Z" />
				</svg>
			</div>

			<div id="quiqowl-spinner" class="display-none"></div>

			<div class="quiqowl-modal__product-data"></div>
		</div>
	</div>

	<h3 class="table__caption"><?php esc_html_e( 'Product Analytics', 'quiqowl' ); ?></h3>
	<?php
	$product_table = new Quiqowl_Table( $table_args );

	$product_table->search_box( 'product_search', 'quiqowl_product_search' );

	$product_table->prepare_items( $search_column_args, $product_data_array );
	$product_table->display();
	?>
</div>

<?php
