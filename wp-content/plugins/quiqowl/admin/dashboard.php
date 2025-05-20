<?php

namespace QuiqOwl\Admin;

use QuiqOwl\Admin\Helper\Quiqowl_Table;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	wp_die( 'Sorry! Content not available.' );
}

$user = wp_get_current_user();

$username = ucfirst( $user->display_name );

function get_sales_data() {
	global $wpdb;

	// Calculate dates for the previous and current month
	$current_month_start  = gmdate( 'Y-m-01' );
	$current_month_end    = gmdate( 'Y-m-t' );
	$previous_month_start = gmdate( 'Y-m-01', strtotime( 'first day of last month' ) );
	$previous_month_end   = gmdate( 'Y-m-t', strtotime( 'last day of last month' ) );

	// Sales for the previous month
	$previous_month_sales = $wpdb->get_row(
		$wpdb->prepare(
			"
        SELECT 
            COUNT(*) AS sales_count, 
            SUM(product_net_revenue + product_gross_revenue + shipping_amount + tax_amount + shipping_tax_amount - coupon_amount) AS total_sales_amount
        FROM {$wpdb->prefix}wc_order_product_lookup
        WHERE date_created BETWEEN %s AND %s
        ",
			$previous_month_start,
			$previous_month_end
		)
	);

	// Sales for the current month
	$current_month_sales = $wpdb->get_row(
		$wpdb->prepare(
			"
        SELECT 
            COUNT(*) AS sales_count, 
            SUM(product_net_revenue + product_gross_revenue + shipping_amount + tax_amount + shipping_tax_amount - coupon_amount) AS total_sales_amount
        FROM {$wpdb->prefix}wc_order_product_lookup
        WHERE date_created BETWEEN %s AND %s
        ",
			$current_month_start,
			$current_month_end
		)
	);

	return array(
		'previous_month' => array(
			'total_sales_amount' => $previous_month_sales->total_sales_amount ? sanitize_text_field( $previous_month_sales->total_sales_amount ) : 0,
		),
		'current_month'  => array(
			'sales_count'        => $current_month_sales->sales_count ? sanitize_text_field( $current_month_sales->sales_count ) : 0,
			'total_sales_amount' => $current_month_sales->total_sales_amount ? sanitize_text_field( $current_month_sales->total_sales_amount ) : 0,
		),
	);
}

$sales_data = get_sales_data();

if ( $user ) {
	?>
	<h2>
		<?php
		esc_html_e( 'Hey ', 'quiqowl' );
		echo esc_html( $username );
		esc_html_e( ' !', 'quiqowl' );
		?>
	</h2>

	<div class="quiqowl-admin__dashboard">

		<div class="sales-comparison__card">
			<div class="card-header">
				<p><?php esc_html_e( 'Gross Amount', 'quiqowl' ); ?></p>

				<?php
				if ( floatval( $sales_data['previous_month']['total_sales_amount'] ) != 0 ) {
					$growth_rate = (string) number_format(
						(
							( floatval( $sales_data['current_month']['total_sales_amount'] ) - floatval( $sales_data['previous_month']['total_sales_amount'] ) )
							/ floatval( $sales_data['previous_month']['total_sales_amount'] )
						) * 100,
						1
					);
				} elseif ( floatval( $sales_data['current_month']['total_sales_amount'] ) > 0 ) {
						$growth_rate = '100.0';
				} else {
					$growth_rate = '0.0';

				}

				$positive = $growth_rate >= 0 ? true : false;

				$classes   = array();
				$classes[] = 'growth-rate';
				$classes[] = $positive ? 'success' : 'warning';
				?>
				<p class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
									<?php
									echo $positive ? esc_html__( '+', 'quiqowl' ) : '';
									printf( /* translators: %s: Growth percentage */ esc_html__( '%s', 'quiqowl' ), esc_html( $growth_rate ) );
									esc_html_e( '%', 'quiqowl' );
									?>
				</p>
			</div>
			<div class="card-body">
				<p class="current-month"><?php echo wc_price( esc_html( $sales_data['current_month']['total_sales_amount'] ) ); ?></p>
				<p class="previous-month"><?php echo wc_price( esc_html( $sales_data['previous_month']['total_sales_amount'] ) ); ?> </p>

			</div>

			<div class="card-footer">
				<span class="sales-count"><?php echo esc_html( $sales_data['current_month']['sales_count'] ) . esc_html__( ' Sold', 'quiqowl' ); ?></span>
			</div>
		</div>

		<div class="quiqowl-admin__table-wrap">
			<div class="quiqowl-admin__content-item table__search-analytics">
				<?php if ( quiqowl_premium_access() ) : ?>
					<div style="display:flex;justify-content:space-between;gap:6px;flex-wrap:wrap;">
					<?php
				endif;
				?>

					<h3 class="table__caption"><?php esc_html_e( 'Latest Keyword Analytics', 'quiqowl' ); ?></h3>
					<?php if ( quiqowl_premium_access() ) : ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=_quiqowl-search-keyword' ) ); ?>"><?php esc_html_e( 'View All', 'quiqowl' ); ?></a>
					</div>
						<?php
					endif;
					?>
				<?php
				$search_column_args = array(
					'columns' => array(
						'quiqowl_search_keyword' => esc_html__( 'Search Keyword', 'quiqowl' ),
						'quiqowl_search_count'   => esc_html__( 'Search Count', 'quiqowl' ),
					),
					'primary' => 'quiqowl_search_keyword',
				);

				$qo_db       = new \QuiqOwl\Quiqowl_Database();
				$args        = array(
					'order_clause'  => array(
						'created_at',
						'DESC',
					),
					'select_clause' => 'id, keyword as quiqowl_search_keyword, search_count as quiqowl_search_count',
					'limit'         => 5,
				);
				$search_data = $qo_db->read( $args );

				$table_args = array(
					'core' => array(
						'singular' => 'dashboard_search_keyword_table',
						'plural'   => 'dashboard_search_keyword_tables',
					),
				);

				$search_table = new Quiqowl_Table( $table_args );

				$search_table->prepare_items( $search_column_args, $search_data );
				$search_table->display();
				?>
			</div>

			<div class="quiqowl-admin__content-item table__product-analytics">
				<?php
				if ( quiqowl_premium_access() ) :
					?>
					<div style="display:flex;justify-content:space-between;gap:6px;flex-wrap:wrap;">
					<?php
				endif;
				?>

					<h3 class="table__caption"><?php esc_html_e( 'Latest Product Analytics', 'quiqowl' ); ?></h3>

					<?php
					if ( quiqowl_premium_access() ) :
						?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=_quiqowl-product' ) ); ?>"><?php esc_html_e( 'View All', 'quiqowl' ); ?></a>
					</div>
						<?php
					endif;
					?>
				<?php
				$search_column_args = array(
					'columns' => array(
						'product_title'       => esc_html__( 'Product Name', 'quiqowl' ),
						'product_views'       => esc_html__( 'Views via Plugin', 'quiqowl' ),
						'added_to_cart_count' => esc_html__( 'Added to Cart Count', 'quiqowl' ),
					),
					'primary' => 'product_title',
				);

				$args = array(
					'post_type'      => 'product', // Replace with your custom post type if different.
					'meta_query'     => array(
						array(
							'key'     => 'quiqowl_product_data',
							'compare' => 'EXISTS', // Use 'EXISTS' if you just want products with this meta key.
						),
					),
					'posts_per_page' => 5,
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
						'id'                  => $product_id,
						'product_title'       => $product->get_title(),
						'product_views'       => $product_views,
						'added_to_cart_count' => $total_interactions,
					);
				}

				$table_args = array(
					'core' => array(
						'singular' => 'product_table',
						'plural'   => 'product_tables',
					),
				);

				$product_table = new Quiqowl_Table( $table_args );

				// $product_table->search_box( 'product_search', 'quiqowl_product_search' );

				$product_table->prepare_items( $search_column_args, $product_data_array );
				$product_table->display();
				?>
			</div>

		</div>

		<?php if ( ! quiqowl_premium_access() ) : ?>
			<div id="quiqowl-admin__button-wrap">
				<?php
				$pricing_url = 'https://untapwp.com/quiqowl/#quiqowl-pricing';
				?>
				<a class="quiqowl-admin__upsell-button size-large" href="<?php echo esc_url( $pricing_url ); ?>" target="_blank"><?php esc_html_e( 'Upgrade to view all data!', 'quiqowl' ); ?></a>
			</div>
		<?php endif; ?>

	</div>
	<?php

}
