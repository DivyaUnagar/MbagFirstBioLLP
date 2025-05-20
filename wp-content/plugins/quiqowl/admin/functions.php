<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the premium status of the plugin version.
 */
function quiqowl_premium_access() {
	$premium_status = qui_fs()->is__premium_only() && qui_fs()->can_use_premium_code();

	return filter_var( $premium_status, FILTER_VALIDATE_BOOLEAN );
}

/**
 * Return the style render for padding, border, and border radius.
 *
 * *
 *
 * @param string $type       The type of style to render ('padding', 'border', or 'radius').
 * @param array  $attributes An associative array of style attributes.
 *                           For 'border', this may include 'width', 'style', 'color', and per-side values (e.g., 'top', 'right', 'bottom', 'left').
 *                           For 'radius', per-side radius values (e.g., 'top', 'right', 'bottom', 'left').
 *                           For 'padding', per-side padding values (e.g., 'top', 'right', 'bottom', 'left').
 *
 * @return string            The generated CSS string for the specified type, with appropriate properties and values.
 */
function quiqowl_render_trbl( $type, $attributes ) {
	$sides = array( 'top', 'right', 'bottom', 'left' );

	if ( ! function_exists( 'quiqowl_generate_property' ) ) {
		/**
		 * Helper function to generate CSS properties conditionally.
		 *
		 * @param string $prop       The CSS property to generate (e.g., 'padding', 'border').
		 * @param string $side       The side of the element to apply the property (e.g., 'top', 'right', 'bottom', 'left').
		 * @param array  $attributes An associative array of style attributes for the element.
		 *                           Contains the values for the corresponding CSS property for each side.
		 *
		 * @return string            The generated CSS rule for the specified property and side, or an empty string if the attribute is not set.
		 */
		function quiqowl_generate_property( $prop, $side, $attributes ) {
			$attr_side = esc_attr( $attributes[ $side ] );
			return ! empty( $attributes[ $side ] ) ? "{$prop}-{$side}: {$attr_side};" : '';
		}
	}

	switch ( $type ) {
		case 'border':
			// Check if any global border property exists.
			if ( isset( $attributes['width'] ) || isset( $attributes['style'] ) || isset( $attributes['color'] ) ) {
				$width = esc_attr( $attributes['width'] );
				$style = esc_attr( $attributes['style'] );
				$color = esc_attr( $attributes['color'] );
				return ( ! empty( $attributes['width'] ) ? "border-width: {$width};" : '' ) .
					( ! empty( $attributes['style'] ) ? "border-style: {$style};" : '' ) .
					( ! empty( $attributes['color'] ) ? "border-color: {$color};" : '' );
			}

			// Handle individual borders for each side.
			$css = '';
			foreach ( $sides as $side ) {
				$border_value =
				( ! empty( $attributes[ $side ]['width'] ) ? "{$attributes[$side]['width']} " : '' ) .
				( ! empty( $attributes[ $side ]['style'] ) ? "{$attributes[$side]['style']} " : '' ) .
				( ! empty( $attributes[ $side ]['color'] ) ? "{$attributes[$side]['color']}" : '' );

				if ( ! empty( $border_value ) ) {
					$css .= "border-{$side}: {$border_value};\n";
				}
			}
			return $css;

		case 'radius':
			// Handle individual border radius for each side.
			$top    = esc_attr( $attributes['top'] );
			$right  = esc_attr( $attributes['right'] );
			$bottom = esc_attr( $attributes['bottom'] );
			$left   = esc_attr( $attributes['left'] );

			return ( ! empty( $attributes['top'] ) ? "border-top-left-radius: {$top};" : '' ) .
				( ! empty( $attributes['right'] ) ? "border-top-right-radius: {$right};" : '' ) .
				( ! empty( $attributes['bottom'] ) ? "border-bottom-right-radius: {$bottom};" : '' ) .
				( ! empty( $attributes['left'] ) ? "border-bottom-left-radius: {$left};" : '' );

		case 'padding':
			// Handle padding for each side
			$css = '';
			foreach ( $sides as $side ) {
				$css .= quiqowl_generate_property( 'padding', $side, $attributes ) . "\n";
			}
			return $css;

		default:
			return '';
	}
}

/**
 * Creates an excerpt from the provided content by truncating it to a specified word length.
 *
 * This function removes all HTML tags and shortcodes from the content, splits the content
 * into words, and returns a truncated version with a '...' appended if the content exceeds
 * the specified word length.
 *
 * @param string $content The content to be converted into an excerpt.
 * @param int    $length  Optional. The number of words to include in the excerpt. Default is 20.
 *
 * @return string The sanitized and truncated excerpt, escaped for safe output.
 */
function quiqowl_create_excerpt( $content, $length = 20 ) {
	// Strip HTML tags and shortcodes.
	$content = wp_strip_all_tags( strip_shortcodes( $content ) );

	// Split the content into words.
	$words = explode( ' ', $content );

	// Truncate to the specified length.
	if ( count( $words ) > $length ) {
		$words   = array_slice( $words, 0, $length );
		$content = implode( ' ', $words ) . '...';
	} else {
		$content = implode( ' ', $words );
	}

	return esc_html( $content );
}

function quiqowl_set_product_unique_key( $post_id, $type ) {
	$quiqowl_product_key = 'quiqowl_product_data';

	// Get the product object.
	$product = wc_get_product( intval( $post_id ) );

	$product_data = get_post_meta( intval( $post_id ), $quiqowl_product_key, true );

	if ( ! is_array( $product_data ) ) {
		$product_data = array();
	}

	if ( $product ) {
		switch ( $type ) {
			case 'PRODUCT_VIEWS':
				if ( isset( $product_data['product_history']['views'] ) ) {
					$product_data['product_history']['views'] = intval( $product_data['product_history']['views'] ) + 1;
				} else {
					$product_data['product_history']['views'] = 1;
				}

				break;

			default:
				return;
		}

		update_post_meta( $post_id, 'quiqowl_product_data', $product_data );
	}
}

/**
 * Modify and update the cart details for a product for the 'quiqowl_quiqowl_product_data' meta key.
 *
 * This function tracks and stores the product price, quantity added to the cart,
 * and additional data (like the plugin trigger) either for logged-in users or
 * non-logged-in users (using transient data). It saves this information in the
 * post meta for the product.
 *
 * @param int|string $post_id The ID of the product to update. This value is sanitized.
 * @param int|string $quantity The quantity of the product added to the cart.
 * @param bool       $plugin_trigger Optional. Indicates if the action was triggered by the plugin. Default is false.
 */
function quiqowl_modify_cart_details( $post_id, $quantity, $plugin_trigger = false ) {
	$post_id = sanitize_key( wp_unslash( $post_id ) );

	// Validate post_id to ensure it is a valid product ID (positive integer).
	if ( ! is_numeric( $post_id ) || $post_id <= 0 ) {
		return; // Exit the function if the post_id is invalid.
	}

	$quiqowl_product_key = 'quiqowl_product_data';

	$product = wc_get_product( $post_id );

	$product_data = get_post_meta( intval( $post_id ), $quiqowl_product_key, true );

	if ( ! is_array( $product_data ) ) {
		$product_data = array();
	}

	if ( $product ) {
		if ( ! isset( $product_data['cart_details'] ) || ! is_array( $product_data['cart_details'] ) ) {
			$product_data['cart_details'] = array();
		}

		$cart_data = array();

		$product_price = $product->get_price();

		if ( isset( $product_data['cart_details'] ) && is_array( $product_data['cart_details'] ) ) {
			$cart_data = $product_data['cart_details'];
		}

		$user_data = array();

		// Set the key to timestamp.
		$current_time = current_time( 'd F Y, H:i:s' );

		// Price at the moment.
		$user_data[ $current_time ]['product_price'] = $product_price;
		// Quantity added.
		$user_data[ $current_time ]['product_quantity'] = sanitize_text_field( wp_unslash( $quantity ) );

		if ( $plugin_trigger ) {
			$user_data[ $current_time ]['plugin_trigger'] = 'true';
		} else {
			$user_data[ $current_time ]['plugin_trigger'] = '-';
		}

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();

			if ( isset( $cart_data['_logged_in_data'][ $user_id ] ) ) {
				$cart_data['_logged_in_data'][ $user_id ] = array_merge( $cart_data['_logged_in_data'][ $user_id ], $user_data );
			} else {
				$cart_data['_logged_in_data'][ $user_id ] = $user_data;
			}
		} else {
			$user_id = 'QO' . time();

			set_transient( $user_id, $user_data, DAY_IN_SECONDS );

			$cart_data['_not_logged_in_data'][] = $user_id;

			$cart_data['_not_logged_in_data'] = array_values( array_unique( $cart_data['_not_logged_in_data'] ) );
		}

		$product_data['cart_details'] = $cart_data;

		update_post_meta( intval( $post_id ), $quiqowl_product_key, $product_data );
	}
}
add_filter( 'quiqowl_update_cart_details', 'quiqowl_modify_cart_details', 10, 3 );

function quiqowl_remove_html_semantics( $render ) {
	$allowed_html_tags = array(
		'div'      => array(
			'class'           => true,
			'id'              => true,
			'style'           => true,
			'data-product-id' => true,
		),
		'span'     => array(
			'class' => true,
			'id'    => true,
			'style' => true,
		),
		'a'        => array(
			'class'           => true,
			'id'              => true,
			'data-product-id' => true,
			'href'            => true,
			'target'          => true,
			'rel'             => true,
		),
		'p'        => array(
			'class' => true,
			'style' => true,
			'id'    => true,
		),
		'ul'       => array(
			'class' => true,
			'id'    => true,
		),
		'li'       => array(
			'class'           => true,
			'id'              => true,
			'data-product-id' => true,
		),
		'svg'      => array(
			'width'       => true,
			'height'      => true,
			'xmlns'       => true,
			'viewbox'     => true,
			'aria-hidden' => true,
		),
		'path'     => array(
			'd' => true,
		),
		'figure'   => array(
			'class' => true,
			'id'    => true,
		),
		'img'      => array(
			'class'   => true,
			'id'      => true,
			'src'     => true,
			'loading' => true,
		),
		'table'    => array(
			'class' => true,
			'id'    => true,
		),
		'caption'  => array(),
		'colgroup' => array(),
		'col'      => array(
			'style' => true,
		),
		'tr'       => array(
			'class' => true,
			'id'    => true,
		),
		'th'       => array(
			'class' => true,
			'id'    => true,
			'style' => true,
		),
		'td'       => array(
			'class' => true,
			'id'    => true,
			'style' => true,
		),
		'strong'   => array(),
		'bdi'      => array(),
		'del'      => array(
			'aria-hidden' => true,
		),
		'ins'      => array(
			'aria-hidden' => true,
		),
		'form'     => array(
			'role'   => true,
			'method' => true,
			'action' => true,
		),

	);

	return wp_kses( $render, $allowed_html_tags );
}
add_filter( 'quiqowl_apply_html_render_sanitization', 'quiqowl_remove_html_semantics', 10, 1 );

/**
 * Apply cart filter when a product is added to the cart from a different page source.
 *
 * This function triggers a filter (`quiqowl_update_cart_details`) to update cart details
 * whenever a product is added to the cart, with a specific focus on tracking the source
 * from which the product was added to the cart (i.e., different page sources).
 *
 * @param string $cart_item_key The unique key for the cart item.
 * @param int    $product_id The ID of the product being added to the cart.
 * @param int    $quantity The quantity of the product being added to the cart.
 */
function quiqowl_apply_cart_filter( $cart_item_key, $product_id, $quantity ) {
	apply_filters( 'quiqowl_update_cart_details', $product_id, $quantity );
}
add_action( 'woocommerce_add_to_cart', 'quiqowl_apply_cart_filter', 10, 3 );

/**
 * Renders the default sale badge HTML output.
 *
 * This function generates a span element containing the default sale label.
 * It includes optional prefix and suffix labels specified in the attributes.
 *
 * @param array $classes An array of CSS classes to apply to the badge.
 * @param array $attributes The attributes array containing labelBefore and labelAfter keys.
 *
 * @return string The generated HTML string for the default sale badge.
 */
function quiqowl_sale_badge_fallback( $classes, $attributes ) {
	$output = '<span class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';

	// Check if labelBefore is not empty and append it with an extra space.
	if ( ! empty( $attributes['saleBadge']['labelBefore'] ) ) {
		$label_before = sanitize_text_field( $attributes['saleBadge']['labelBefore'] );
		$output      .= sprintf(
			/* translators: %s: Label before text */
			esc_html__( '%s', 'quiqowl' ),
			esc_html( $label_before )
		) . ' ';
	}

	$output .= '<span>';
	$output .= esc_html__( 'Sale', 'quiqowl' );
	$output .= '</span>';

	// Check if labelAfter is not empty and append it with an extra space.
	if ( ! empty( $attributes['saleBadge']['labelAfter'] ) ) {
		$label_after = sanitize_text_field( $attributes['saleBadge']['labelAfter'] );
		$output     .= ' ' . sprintf(
			/* translators: %s: Label after text */
			esc_html__( '%s', 'quiqowl' ),
			esc_html( $label_after )
		);
	}

	$output .= '</span>';

	return $output;
}

/**
 * Sanitizes a specific item based on the provided key.
 *
 * This function sanitizes the item differently depending on the key. It ensures that
 * certain fields are sanitized as text, while others (such as 'value') are validated
 * as arrays.
 *
 * @param mixed  $item The item to be sanitized. This is passed by reference.
 * @param string $key  The key that determines how the item should be sanitized.
 */
function quiqowl_sanitize_pa( &$item, $key ) {

	switch ( $key ) {

		case 'attribute_name':
			$item = sanitize_text_field( $item );

			break;

		case 'value':
			if ( ! is_array( $item ) ) {
				$item = null;
			}

			break;

		default:
			$item = sanitize_text_field( $item );

	}
}

/**
 * Checks if the active theme is a block based theme.
 *
 * @return boolean True if the active theme is a block based theme.
 */
function quiqowl_is_block_theme() {
	$active_theme = wp_get_theme();

	return $active_theme->is_block_theme();
}

/**
 * Render the QuiqOwl search results with sanitized strings and optional attributes.
 *
 * This function processes a collection of products, sanitizes product information
 * by removing special characters and HTML tags, and renders the search results.
 * You can optionally exclude `<ul>` tags from being rendered.
 *
 * @param array $products   The collection of products to render in search results.
 * @param array $attributes Optional. Array of block attributes for customizing output.
 * @param bool  $exclude_ul Optional. Whether to exclude the wrapping `<ul>` tags.
 *                          Default false.
 *
 * @return string The rendered HTML string with sanitized product data.
 */
function quiqowl_render_search_results( $products, $attributes, $exclude_ul = false ) {
	if ( ! empty( $products ) ) {
		$output = '';

		if ( ! $exclude_ul ) {
			$classes   = array();
			$classes[] = 'search-results__product-collection';
			$output   .= '<ul class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
		}
		foreach ( $products as $post ) {
			$product_id = $post->ID;

			$product = wc_get_product( $product_id );

			$product_link        = $product->get_permalink();
			$product_name        = $product->get_name();
			$product_image_url   = wp_get_attachment_image_url( $product->get_image_id(), 'full' );
			$product_price       = '';
			$discount_amt        = '';
			$discount_percentage = '';
			if ( $product->is_on_sale() ) {
				$product_price = wc_format_sale_price( $product->get_regular_price(), $product->get_sale_price() );
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();

				// Check if both regular and sale prices are numeric before calculating discount amount
				if ( is_numeric( $regular_price ) && is_numeric( $sale_price ) ) {
					$discount_amt        = wc_price( $regular_price - $sale_price );
					$discount_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
					$discount_percentage = number_format( $discount_percentage, 1 );
					$discount_percentage = preg_replace( '/\.0+$/', '', $discount_percentage ) . '%';
				}
			} else {
				$product_price = wc_price( $product->get_regular_price() );
			}
			$product_summary      = $product->get_description();
			$product_avg_rating   = $product->get_average_rating();
			$product_review_count = $product->get_review_count();

			$classes   = array();
			$classes[] = 'product-collection__item';
			$classes[] = $attributes['productBox']['item']['shadow']['enabled'] ? 'has-box-shadow' : '';
			$classes[] = $attributes['productBox']['item']['shadowHover']['enabled'] ? 'has-hover-box-shadow' : '';
			$output   .= '<li id="product-' . $product_id . '" class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';

			// Toast Message.
			$output .= '<div class="quiqowl__toast" style="display:none;">';
			$output .= '<div id="tick-icon" style="display:none;">';
			$output .= '<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">';
			$output .= '<path d="M6.66668 10.1133L12.7947 3.986L13.7373 4.92867L6.66668 11.9993L2.42401 7.75667L3.36668 6.814L6.66668 10.1133Z" />';
			$output .= '</svg>';
			$output .= '</div>';
			$output .= '<div id="cross-icon" style="display:none;">';
			$output .= '<svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">';
			$output .= '<path d="M7.99999 7.058L11.3 3.758L12.2427 4.70067L8.94266 8.00067L12.2427 11.3007L11.2993 12.2433L7.99932 8.94334L4.69999 12.2433L3.75732 11.3L7.05732 8L3.75732 4.7L4.69999 3.75867L7.99999 7.058Z" />';
			$output .= '</svg>';
			$output .= '</div>';
			$output .= '<div class="toast__message"></div>';
			$output .= '</div>';

			if ( filter_var( $attributes['productOptions']['productImage'], FILTER_VALIDATE_BOOLEAN ) ) {
				$classes   = array();
				$classes[] = 'product__featured-image';
				$classes[] = filter_var( $attributes['productImage']['hoverEffect'], FILTER_VALIDATE_BOOLEAN ) ? 'has-hover-effect' : '';
				$output   .= '<figure class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
				$anchor    = array();
				$anchor[]  = filter_var( $attributes['productImage']['linkProduct'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $product_link ) . '"' : '';
				$anchor[]  = filter_var( $attributes['productImage']['openLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? 'target="_blank"' : '';
				$output   .= '<a class="product-view__link" data-product-id="' . esc_html( $product_id ) . '" rel="noopener" ' . implode( ' ', $anchor ) . '>';
				$output   .= '<img src="' . esc_url( $product_image_url ) . '" loading="lazy" />';
				if ( $product->is_on_sale() && filter_var( $attributes['productOptions']['saleBadge'], FILTER_VALIDATE_BOOLEAN ) ) {
					$classes   = array();
					$classes[] = 'product__sale-badge';
					$classes[] = 'position-' . sanitize_text_field( $attributes['saleBadge']['position'] );
					switch ( $attributes['saleBadge']['content'] ) {
						case 'amount':
							if ( quiqowl_premium_access() && isset( $discount_amt ) && ! empty( $discount_amt ) ) {
								$output .= '<span class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
								// Check if labelBefore is not empty and append it with an extra space.
								if ( ! empty( $attributes['saleBadge']['labelBefore'] ) ) {
									$label_before = sanitize_text_field( $attributes['saleBadge']['labelBefore'] );
									$output      .= sprintf(
										/* translators: %s: Label before text */
										esc_html__( '%s', 'quiqowl' ),
										esc_html( $label_before )
									) . ' ';
								}
								$output .= '<span>';
								$output .= $discount_amt;
								$output .= '</span>';
								// Check if labelAfter is not empty and append it with an extra space.
								if ( ! empty( $attributes['saleBadge']['labelAfter'] ) ) {
									$label_after = sanitize_text_field( $attributes['saleBadge']['labelAfter'] );
									$output     .= ' ' . sprintf(
										/* translators: %s: Label after text */
										esc_html__( '%s', 'quiqowl' ),
										esc_html( $label_after )
									);
								}
								$output .= '</span>';
							} else {
								$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
							}
							break;

						case 'percentage':
							if ( quiqowl_premium_access() && isset( $discount_percentage ) && ! empty( $discount_percentage ) ) {
								$output .= '<span class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
								// Check if labelBefore is not empty and append it with an extra space.
								if ( ! empty( $attributes['saleBadge']['labelBefore'] ) ) {
									$label_before = sanitize_text_field( $attributes['saleBadge']['labelBefore'] );
									$output      .= sprintf(
										/* translators: %s: Label before text */
										esc_html__( '%s', 'quiqowl' ),
										esc_html( $label_before )
									) . ' ';
								}
								$output .= '<span>';
								$output .= $discount_percentage;
								$output .= '</span>';
								// Check if labelAfter is not empty and append it with an extra space.
								if ( ! empty( $attributes['saleBadge']['labelAfter'] ) ) {
									$label_after = sanitize_text_field( $attributes['saleBadge']['labelAfter'] );
									$output     .= ' ' . sprintf(
										/* translators: %s: Label after text */
										esc_html__( '%s', 'quiqowl' ),
										esc_html( $label_after )
									);
								}
								$output .= '</span>';
							} else {
								$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
							}
							break;

						default:
							$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
					}
				}
				$output .= '</a>';
				$output .= '</figure>';
			}

			$output .= '<div class="product__details">'; /* <-- Product Details Wrapper --> */

			if ( filter_var( $attributes['productOptions']['productTitle'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['productOptions']['productPrice'], FILTER_VALIDATE_BOOLEAN ) ) {
				$output .= '<div class="product__title-price-wrapper">';

				$output  .= '<h4 class="product__title">';
				$anchor   = array();
				$anchor[] = filter_var( $attributes['productTitle']['linkProduct'], FILTER_VALIDATE_BOOLEAN ) ? 'href="' . esc_url( $product_link ) . '"' : '';
				$anchor[] = filter_var( $attributes['productTitle']['openLinkNewTab'], FILTER_VALIDATE_BOOLEAN ) ? 'target="_blank"' : '';
				$output  .= '<a class="product-view__link" data-product-id="' . esc_html( $product_id ) . '" rel="noopener" ' . implode( ' ', $anchor ) . '>';
				$output  .= esc_html( $product_name );
				$output  .= '</a>';
				$output  .= '</h4>';

				if ( $product->get_price() && filter_var( $attributes['productOptions']['productPrice'], FILTER_VALIDATE_BOOLEAN ) ) {
					$output .= '<div class="product__price">';
					$output .= $product_price;
					$output .= '</div>';
				}

				$output .= '</div>';
			}

			if ( filter_var( $attributes['productOptions']['productSummary'], FILTER_VALIDATE_BOOLEAN ) && ! empty( $product_summary ) ) {
				$output .= '<div class="product__summary">';
				$output .= quiqowl_create_excerpt( $product_summary, intval( $attributes['productOptions']['excerpt'] ) );
				$output .= '</div>';
			}

			if ( filter_var( $attributes['productOptions']['cartButton'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['productOptions']['quickView'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['productOptions']['productRating'], FILTER_VALIDATE_BOOLEAN ) ) {
				$output .= '<div class="product__icon-rating-wrapper">'; // <-- Icon/Rating Wrapper -->

				if ( quiqowl_premium_access() && ( filter_var( $attributes['productOptions']['cartButton'], FILTER_VALIDATE_BOOLEAN ) || filter_var( $attributes['productOptions']['quickView'], FILTER_VALIDATE_BOOLEAN ) ) ) {
					$output .= '<div class="util-icon__wrapper">';  /* <-- Util Icon Wrapper --> */

					if ( filter_var( $attributes['productOptions']['cartButton'], FILTER_VALIDATE_BOOLEAN ) ) {
						if ( $product->is_in_stock() && $product->get_price() ) {
							$output .= '<div class="cart-icon__wrapper icon__wrapper" data-product-id="' . esc_attr( $product_id ) . '">';
							$output .= '<svg viewBox="0 0 8 8" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
							$output .= '<path d="M7.26635 4.4701L7.88216 1.76056C7.92662 1.56492 7.77792 1.37863 7.5773 1.37863H2.46066L2.34126 0.794903C2.31151 0.649409 2.18348 0.544922 2.03497 0.544922H0.699358C0.52669 0.544922 0.386719 0.684893 0.386719 0.857561V1.06599C0.386719 1.23866 0.52669 1.37863 0.699358 1.37863H1.6097L2.5248 5.85243C2.30587 5.97834 2.15834 6.21441 2.15834 6.48507C2.15834 6.88796 2.48495 7.21457 2.88783 7.21457C3.29072 7.21457 3.61733 6.88796 3.61733 6.48507C3.61733 6.28089 3.53334 6.09642 3.39817 5.96401H6.12916C5.994 6.09642 5.91002 6.28089 5.91002 6.48507C5.91002 6.88796 6.23662 7.21457 6.63951 7.21457C7.0424 7.21457 7.369 6.88796 7.369 6.48507C7.369 6.19625 7.20111 5.94666 6.95763 5.82846L7.0295 5.51223C7.07396 5.3166 6.92526 5.1303 6.72464 5.1303H3.22805L3.14279 4.71345H6.96149C7.10746 4.71345 7.23401 4.61244 7.26635 4.4701Z" />';
							$output .= '</svg>';
							$output .= '</div>';
						} elseif ( ! $product->is_in_stock() ) {
							$output .= '<div class="product__stock-error">';
							$output .= esc_html__( 'Sold out!', 'quiqowl' );
							$output .= '</div>';
						}
					}

					if ( filter_var( $attributes['productOptions']['quickView'], FILTER_VALIDATE_BOOLEAN ) ) {
						$output .= '<div class="quick-view-icon__wrapper icon__wrapper" data-product-id="' . esc_attr( $product_id ) . '">';
						$output .= '<svg viewBox="0 0 25 17" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" >';
						$output .= '<path d="M24.8489 7.69965C22.4952 3.1072 17.8355 0 12.5 0C7.16447 0 2.50345 3.10938 0.151018 7.70009C0.0517306 7.89649 0 8.11348 0 8.33355C0 8.55362 0.0517306 8.77061 0.151018 8.96701C2.50475 13.5595 7.16447 16.6667 12.5 16.6667C17.8355 16.6667 22.4965 13.5573 24.8489 8.96658C24.9482 8.77018 25 8.55319 25 8.33312C25 8.11304 24.9482 7.89605 24.8489 7.69965ZM12.5 14.5833C11.2638 14.5833 10.0555 14.2168 9.02766 13.53C7.99985 12.8433 7.19878 11.8671 6.72573 10.7251C6.25268 9.58307 6.12891 8.3264 6.37007 7.11402C6.61123 5.90164 7.20648 4.78799 8.08056 3.91392C8.95464 3.03984 10.0683 2.44458 11.2807 2.20343C12.493 1.96227 13.7497 2.08604 14.8917 2.55909C16.0338 3.03213 17.0099 3.83321 17.6967 4.86102C18.3834 5.88883 18.75 7.0972 18.75 8.33333C18.7504 9.15421 18.589 9.96711 18.275 10.7256C17.9611 11.484 17.5007 12.1732 16.9203 12.7536C16.3398 13.3341 15.6507 13.7944 14.8922 14.1084C14.1338 14.4223 13.3208 14.5837 12.5 14.5833ZM12.5 4.16667C12.1281 4.17186 11.7586 4.22719 11.4015 4.33116C11.6958 4.73119 11.8371 5.22347 11.7996 5.71873C11.7621 6.21398 11.5484 6.6794 11.1972 7.0306C10.846 7.38179 10.3806 7.5955 9.88537 7.63297C9.39012 7.67043 8.89784 7.52917 8.49781 7.23481C8.27001 8.07404 8.31113 8.96357 8.61538 9.77821C8.91962 10.5928 9.47167 11.2916 10.1938 11.776C10.916 12.2605 11.7719 12.5063 12.641 12.4788C13.5102 12.4514 14.3489 12.152 15.039 11.623C15.7291 11.0939 16.236 10.3617 16.4882 9.52951C16.7404 8.69729 16.7253 7.80693 16.445 6.98376C16.1647 6.16058 15.6333 5.44602 14.9256 4.94067C14.2179 4.43532 13.3696 4.16462 12.5 4.16667Z" />';
						$output .= '</svg>';
						$output .= '</div>';
					}

					$output .= '</div>'; /* <!-- Util Icon Wrapper> */

				}

				if ( $product_review_count > 0 && filter_var( $attributes['productOptions']['productRating'], FILTER_VALIDATE_BOOLEAN ) ) {
					$output      .= '<div class="product__rating" style="display:inline-flex;align-items:center;gap:4px;">';
					$rating_color = isset( $attributes['utilIcon']['color']['starPrimary'] ) ? $attributes['utilIcon']['color']['starPrimary'] : '#fcb900';
					$output      .= '<svg width="16" height="16" viewBox="0 0 24 23" fill="' . $rating_color . '" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
					$output      .= '<path d="M10.3646 0.77312L7.5304 6.51965L1.18926 7.44413C0.052104 7.60906 -0.403625 9.01097 0.421028 9.81392L5.0087 14.2844L3.92363 20.5995C3.72832 21.741 4.93058 22.596 5.93752 22.0622L11.6103 19.0804L17.283 22.0622C18.29 22.5917 19.4922 21.741 19.2969 20.5995L18.2118 14.2844L22.7995 9.81392C23.6242 9.01097 23.1684 7.60906 22.0313 7.44413L15.6901 6.51965L12.8559 0.77312C12.3481 -0.251186 10.8768 -0.264207 10.3646 0.77312Z" />';
					$output      .= '</svg>';
					$output      .= '<p>';
					$output      .= esc_html( number_format( $product_avg_rating, 1 ) );
					$output      .= ' (' . $product_review_count . ' ' . _n( 'Review', 'Reviews', $product_review_count, 'quiqowl' ) . ')';
					$output      .= '</p>';
					$output      .= '</div>';
				}

				$output .= '</div>'; // <--! Icon/Rating Wrapper -->

				$cart_url     = wc_get_cart_url();
				$open_new_tab = filter_var( $attributes['utilIcon']['openCartNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
				$output      .= '<div class="product__cart-page-link display-none">';
				$output      .= '<a href="' . esc_url( $cart_url ) . '" target="' . $open_new_tab . '" rel="noopener">';
				$output      .= esc_html__( 'View my cart', 'quiqowl' );
				$output      .= '</a>';
				$output      .= '</div>';
			}

			$output .= '</div>'; /* <!-- Product Details Wrapper> */

			$output .= '</li>';
		}

		if ( ! $exclude_ul ) {
			$output .= '</ul>';
		}

		// return apply_filters( 'quiqowl_apply_html_render_sanitization', $output );
		return $output;
	} else {
		$output = '<p style="text-align:center;color:#000;">' . esc_html__( 'Sorry! No results found.', 'quiqowl' ) . '</p>';
		// return apply_filters( 'quiqowl_apply_html_render_sanitization', $output );
		return $output;
	}
}

add_action( 'wp_ajax_quiqowl_product_search_results', 'quiqowl_product_search_results' );
add_action( 'wp_ajax_nopriv_quiqowl_product_search_results', 'quiqowl_product_search_results' );
/**
 * Callback for ajax search results.
 */
function quiqowl_product_search_results() {
	check_ajax_referer( 'quiqowl_product_search', 'nonce', true );

	$attributes = isset( $_POST['attributes'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['attributes'] ) ), true ) : array();

	if ( empty( $attributes ) ) {
		wp_send_json_success( array() );
		return;
	}

	$query              = isset( $_POST['search'] ) && ! empty( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
	$category           = isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '';
	$min_price          = isset( $_POST['minPrice'] ) ? sanitize_text_field( wp_unslash( $_POST['minPrice'] ) ) : '';
	$max_price          = isset( $_POST['maxPrice'] ) ? sanitize_text_field( wp_unslash( $_POST['maxPrice'] ) ) : '';
	$product_tags       = isset( $_POST['tags'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['tags'] ) ), true ) : array();
	$product_tags       = map_deep( $product_tags, 'sanitize_text_field' );
	$rating             = isset( $_POST['rating'] ) ? sanitize_text_field( wp_unslash( $_POST['rating'] ) ) : '';
	$product_attributes = isset( $_POST['wcProductAttributes'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['wcProductAttributes'] ) ), true ) : array();
	array_walk_recursive( $product_attributes, 'quiqowl_sanitize_pa' );

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => isset( $attributes['productOptions']['perPage'] ) ? min( $attributes['productOptions']['perPage'], 10 ) : 10,
		'post_status'    => 'publish',
		'meta_query'     => array( 'relation' => 'AND' ),
	);

	if ( ! empty( $query ) ) {
		$args['s'] = $query;

		global $wpdb;

		// Check if the keyword exists in the wp_quiqowl_search_keywords table.
		$existing_keyword = $wpdb->get_row(
			$wpdb->prepare( "SELECT id, search_count FROM {$wpdb->prefix}quiqowl_search_keywords WHERE keyword = %s", $query )
		);

		if ( $existing_keyword ) {
			// Keyword exists, update the search count
			$search_count = $existing_keyword->search_count + 1;
			$wpdb->update(
				"{$wpdb->prefix}quiqowl_search_keywords",
				array( 'search_count' => $search_count ),
				array( 'id' => $existing_keyword->id ),
				array( '%d' ),
				array( '%d' )
			);
		} else {
			// Keyword doesn't exist, insert a new keyword.
			$wpdb->insert(
				"{$wpdb->prefix}quiqowl_search_keywords",
				array(
					'keyword'      => $query,
					'search_count' => 1,
				),
				array( '%s', '%d' )
			);
		}
	}

	if ( isset( $category ) && ! empty( $category ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',  // Use WooCommerce product category.
			'field'    => 'slug',         // Change 'slug' to 'id' if you're passing category IDs.
			'terms'    => $category,
		);
	}

	if ( ! empty( $min_price ) && ! empty( $max_price ) ) {
		$args['meta_query'][] = array(
			'key'     => '_price',
			'value'   => $min_price,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
		$args['meta_query'][] = array(
			'key'     => '_price',
			'value'   => $max_price,
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
		$args['meta_query'][] = array(
			'key'     => '_price',
			'compare' => 'EXISTS',
		);
	}

	if ( is_array( $product_tags ) && ! empty( $product_tags ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_tag',  // Use WooCommerce product tag.
			'field'    => 'slug',         // Change 'slug' to 'id' if you're passing tag IDs.
			'terms'    => $product_tags,
		);
	}

	if ( isset( $attributes['stockFilter']['enabled'] ) && filter_var( $attributes['stockFilter']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$args['meta_query'][] = array(
			array(
				'key'     => '_stock_status',
				'value'   => 'instock', // Only get products that are in stock.
				'compare' => '=',       // Ensure exact match.
			),
		);
	}

	if ( isset( $rating ) && ! empty( $rating ) ) {
		$args['meta_query'][] = array(
			'key'     => '_wc_average_rating',  // WooCommerce stores the average rating in this meta key.
			'value'   => $rating,
			'compare' => '>=',
			'type'    => 'DECIMAL',             // Use 'DECIMAL' to handle floating-point numbers.
		);
	}

	if ( isset( $product_attributes ) && ! empty( $product_attributes ) ) {
		foreach ( $product_attributes as $pa_attr ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'pa_' . $pa_attr['attribute_name'],
				'field'    => 'slug',
				'terms'    => $pa_attr['value'],
			);
		}
	}

	// Create a new query.
	$product_query = new WP_Query( $args );
	$products      = $product_query->posts;

	// Extract all product IDs into a separate array.
	$product_ids = array_map(
		function ( $product ) {
			return $product->ID;
		},
		$products
	);

	$render = quiqowl_render_search_results( $products, $attributes );

	$has_ajax_loader = false;
	$count           = 0;

	if ( quiqowl_premium_access() && filter_var( $attributes['ajaxLoader']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$args['posts_per_page'] = $attributes['ajaxLoader']['loadContent'];
		$args['post__not_in']   = $product_ids;
		$product_query          = new WP_Query( $args );
		if ( count( $product_query->posts ) > 0 ) {
			$has_ajax_loader = true;
		}
		$count = count( $product_query->posts );
	}

	$return_data = array(
		// 'render'          => apply_filters( 'quiqowl_apply_html_render_sanitization', $render ),
		'render'          => $render,
		'products_count'  => count( $products ),
		'has_ajax_loader' => $has_ajax_loader,
		'count'           => $count,
	);

	wp_send_json_success( $return_data );
}

/* Add product to cart */
add_action( 'wp_ajax_quiqowl_add_to_cart', 'quiqowl_add_to_cart_callback' );
add_action( 'wp_ajax_nopriv_quiqowl_add_to_cart', 'quiqowl_add_to_cart_callback' );
/**
 * Callback for WC add to cart.
 */
function quiqowl_add_to_cart_callback() {
	check_ajax_referer( 'quiqowl__add_to_cart', 'cartNonce', true );

	$product_id = isset( $_POST['productId'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['productId'] ) ) ) : '';

	$quantity = isset( $_POST['productQuantity'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['productQuantity'] ) ) ) : 1;

	$added = WC()->cart->add_to_cart( $product_id, $quantity );

	if ( $added ) {
		apply_filters( 'quiqowl_update_cart_details', $product_id, $quantity, true );

		wp_send_json_success( 'Product added to cart' );

	} else {
		wp_send_json_error( 'Could not add product to cart' );
	}
}

/* Lightbox Render Data */
add_action( 'wp_ajax_quiqowl_lightbox_data', 'quiqowl_lightbox_render_callback' );
add_action( 'wp_ajax_nopriv_quiqowl_lightbox_data', 'quiqowl_lightbox_render_callback' );
/**
 * Callback for lightbox render data.
 */
function quiqowl_lightbox_render_callback() {
	check_ajax_referer( 'quiqowl__lightbox', 'lightboxNonce', true );

	$attributes = isset( $_POST['attributes'] ) ? json_decode( wp_unslash( $_POST['attributes'] ), true ) : array();

	if ( empty( $attributes ) ) {
		wp_send_json_success( array() );
		return;
	}

	$product_id = isset( $_POST['productId'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['productId'], true ) ) ) : '';

	$product = wc_get_product( $product_id );

	if ( $product ) {
		$product_title = $product->get_title();
		// Get product link (permalink).
		$product_link = get_permalink( $product_id );

		// Get product price.
		$product_price       = ''; // Gets the sale price if applicable.
		$discount_amt        = '';
		$discount_percentage = '';
		if ( $product->is_on_sale() ) {
			$product_price = wc_format_sale_price( $product->get_regular_price(), $product->get_sale_price() );
			$regular_price = $product->get_regular_price();
			$sale_price    = $product->get_sale_price();

			// Check if both regular and sale prices are numeric before calculating discount amount
			if ( is_numeric( $regular_price ) && is_numeric( $sale_price ) ) {
				$discount_amt        = wc_price( $regular_price - $sale_price );
				$discount_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
				$discount_percentage = number_format( $discount_percentage, 1 );
				$discount_percentage = preg_replace( '/\.0+$/', '', $discount_percentage ) . '%';
			}
		} else {
			$product_price = wc_price( $product->get_regular_price() );
		}

		// Get all product images.
		$product_images    = $product->get_gallery_image_ids(); // Array of attachment IDs for gallery images.
		$product_thumbnail = $product->get_image_id(); // Get the ID of the featured image.

		// Prepare an array to hold image URLs.
		$image_urls = array();

		// Get the URLs for the gallery images.
		foreach ( $product_images as $image_id ) {
			$image_urls[] = wp_get_attachment_url( $image_id );
		}

		// Get the URL for the featured image.
		$thumbnail_url = wp_get_attachment_url( $product_thumbnail );

		$product_short_desc = $product->get_description();

		$output  = '<figure class="quiqowl-lightbox__product-image">'; /* <-- Product Image --> */
		$output .= '<a class="product-view__link" data-product-id="' . esc_html( $product_id ) . '" href="' . esc_url( $product_link ) . '" target="_blank" rel="noopener">';
		$output .= '<img src="' . esc_url( $thumbnail_url ) . '" loading="lazy" />';
		$output .= '</a>';
		$output .= '</figure>';/* <!-- Product Image --> */

		$output .= '<div class="quiqowl-lightbox__product-details">'; /* <-- Product Details --> */

		$output .= '<div style="display:flex;align-items:center;gap:16px;">';
		/* <-- Heading --> */
		$output .= '<h4 class="product__title">';
		$output .= '<a class="product-view__link" data-product-id="' . esc_html( $product_id ) . '" href="' . esc_url( $product_link ) . '" target="_blank" rel="noopener">';
		$output .= sprintf(
			/* translators: %s: Product Title */
			esc_html__( '%s', 'quiqowl' ),
			esc_html( $product_title )
		);
		$output .= '</a>';
		$output .= '</h4>';
		/* <!-- Heading --> */

		if ( $product->is_on_sale() && filter_var( $attributes['productOptions']['saleBadge'], FILTER_VALIDATE_BOOLEAN ) ) {
			$classes   = array();
			$classes[] = 'product__sale-badge';
			$classes[] = 'position-' . sanitize_text_field( $attributes['saleBadge']['position'] );
			switch ( $attributes['saleBadge']['content'] ) {
				case 'amount':
					if ( quiqowl_premium_access() && isset( $discount_amt ) && ! empty( $discount_amt ) ) {
						$output .= '<span class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
						// Check if labelBefore is not empty and append it with an extra space.
						if ( ! empty( $attributes['saleBadge']['labelBefore'] ) ) {
							$label_before = sanitize_text_field( $attributes['saleBadge']['labelBefore'] );
							$output      .= sprintf(
								/* translators: %s: Label before text */
								esc_html__( '%s', 'quiqowl' ),
								esc_html( $label_before )
							) . ' ';
						}

						$output .= '<span>';
						$output .= $discount_amt;
						$output .= '</span>';
						// Check if labelAfter is not empty and append it with an extra space.
						if ( ! empty( $attributes['saleBadge']['labelAfter'] ) ) {
							$label_after = sanitize_text_field( $attributes['saleBadge']['labelAfter'] );
							$output     .= ' ' . sprintf(
								/* translators: %s: Label before text */
								esc_html__( '%s', 'quiqowl' ),
								esc_html( $label_after )
							);
						}
						$output .= '</span>';
					} else {
						$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
					}
					break;

				case 'percentage':
					if ( quiqowl_premium_access() && isset( $discount_percentage ) && ! empty( $discount_percentage ) ) {
						$output .= '<span class="' . esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ) . '">';
						// Check if labelBefore is not empty and append it with an extra space.
						if ( ! empty( $attributes['saleBadge']['labelBefore'] ) ) {
							$label_before = sanitize_text_field( $attributes['saleBadge']['labelBefore'] );
							$output      .= sprintf(
								/* translators: %s: Label before text */
								esc_html__( '%s', 'quiqowl' ),
								esc_html( $label_before )
							) . ' ';
						}
						$output .= '<span>';
						$output .= $discount_percentage;
						$output .= '</span>';
						// Check if labelAfter is not empty and append it with an extra space.
						if ( ! empty( $attributes['saleBadge']['labelAfter'] ) ) {
							$label_after = sanitize_text_field( $attributes['saleBadge']['labelAfter'] );
							$output     .= ' ' . sprintf(
								/* translators: %s: Label before text */
								esc_html__( '%s', 'quiqowl' ),
								esc_html( $label_after )
							);
						}
						$output .= '</span>';
					} else {
						$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
					}
					break;

				default:
					$output .= quiqowl_sale_badge_fallback( $classes, $attributes );
			}
		}
		$output .= '</div>';

		$output .= '<div style="margin-top:12px;margin-bottom:8px;">';
		$output .= quiqowl_create_excerpt( $product_short_desc, 30 );
		$output .= '</div>';

		$output .= '<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;margin:16px 0;">';
		/* <-- Price --> */
		$output .= '<div class="product__price">';
		$output .= $product_price;
		$output .= '</div>';
		/* <!-- Price --> */

		$product_avg_rating   = $product->get_average_rating();
		$product_review_count = $product->get_review_count();
		$rating_percent       = number_format( ( $product_avg_rating / 5 ) * 100, 1 ) . '%';
		$star_primary         = isset( $attributes['utilIcon']['color']['starPrimary'] ) ? sanitize_text_field( $attributes['utilIcon']['color']['starPrimary'] ) : '#fcb900';
		$star_secondary       = isset( $attributes['utilIcon']['color']['starSecondary'] ) ? sanitize_text_field( $attributes['utilIcon']['color']['starSecondary'] ) : '#989898';
		if ( $product_avg_rating > 0 ) {
			/* <-- Rating --> */
			$output .= '<div class="quiqowl-lightbox__product-rating-wrapper">';
			$output .= '<div class="quiqowl-lightbox__product-rating" style="background: linear-gradient(90deg, ' . $star_primary . ' ' . $rating_percent . ', ' . $star_secondary . ' ' . $rating_percent . ');">';
			$output .= '★★★★★';
			$output .= '</div>';
			$output .= '<div>';
			$output .= esc_html( number_format( $product_avg_rating, 1 ) ) . esc_html__( ' out of ', 'quiqowl' ) . $product_review_count . ' ' . _n( 'review', 'reviews', $product_review_count, 'quiqowl' ) . '.';
			$output .= '</div>';
			$output .= '</div>';
			/* <!-- Rating --> */
		}
		$output .= '</div>';

		/* Add to Cart */
		$output .= '<div class="quiqowl-lightbox__cart-wrapper">';
		$output .= '<div class="quiqowl-lightbox__quantity">';
		$output .= '<span class="quantity__increase"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M17.3051 12.1C17.3051 12.6 16.9051 13 16.4051 13H12.8051V16.4C12.8051 16.9 12.4051 17.3 11.9051 17.3C11.4051 17.3 11.0051 16.9 11.0051 16.4V13H7.60511C7.10511 13 6.70511 12.6 6.70511 12.1C6.70511 11.6 7.10511 11.2 7.60511 11.2H11.0051V7.6C11.0051 7.1 11.4051 6.7 11.9051 6.7C12.4051 6.7 12.8051 7.1 12.8051 7.6V11.2H16.4051C16.9051 11.2 17.3051 11.6 17.3051 12.1Z" />
		</svg></span>';
		$output .= '<input class="quiqowl-lightbox__quantity-input" type="text" value="1" disabled />';
		$output .= '<span class="quantity__decrease opacity-50"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<path d="M5 11.25h14v1.5H5z" />
		</svg></span>';
		$output .= '</div>';

		$output .= '<div class="quiqowl-lightbox__cart-tooltip quiqowl__visibility-hidden">';
		$output .= '<div id="tick-icon">';
		$output .= '<svg style="display:inline-block;" width="14" height="14" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">';
		$output .= '<path d="M6.66668 10.1133L12.7947 3.986L13.7373 4.92867L6.66668 11.9993L2.42401 7.75667L3.36668 6.814L6.66668 10.1133Z" />';
		$output .= '</svg>';
		$output .= '</div>';
		$output .= esc_html__( 'Cart Updated!', 'quiqowl' );
		$output .= '</div>';

		$output       .= '<div class="quiqowl-lightbox__cart-buttons">';
		$output       .= '<div class="quiqowl-lightbox__cart-button"><span>' . esc_html__( 'Add to cart', 'quiqowl' ) . '</span></div>';
		$cart_page_url = wc_get_cart_url();
		$open_new_tab  = filter_var( $attributes['utilIcon']['openCartNewTab'], FILTER_VALIDATE_BOOLEAN ) ? '_blank' : '';
		$output       .= '<a class="quiqowl-lightbox__cart-view" href="' . esc_url( $cart_page_url ) . '" rel="noopener" target="' . $open_new_tab . '">' . esc_html__( 'View my cart', 'quiqowl' ) . '</a>';
		$output       .= '</div>';

		$output .= '</div>';
		/* End Add to Cart */

		if ( $product_review_count > 0 ) {
			/* Product Rating Carousel */
			$output .= '<div class="quiqowl-lightbox__review swiper__container">';
			$output .= '<div class="swiper-wrapper">';
			$args    = array(
				'post_type' => 'product',
				'post_id'   => $product_id,
				'status'    => 'approve', // Only get approved comments.
				'orderby'   => 'date',
				'order'     => 'DESC',
			);

			$reviews = get_comments( $args );

			foreach ( $reviews as $review ) {
				$user_avatar    = get_avatar_url( $review->user_id );
				$timestamp      = strtotime( $review->comment_date );
				$comment_rating = get_comment_meta( $review->comment_ID, 'rating', true );
				$rating_percent = $comment_rating / 5 * 100 . '%';

				$output .= '<div class="quiqowl-lightbox__review-item swiper-slide">';

				$output .= '<figure class="quiqowl-lightbox__user-avatar">'; /* User Avatar */
				$output .= '<img src="' . esc_url( $user_avatar ) . '" />';
				$output .= '</figure>'; /* End User Avatar */

				$output .= '<div style="display:inline-block;margin-left:10px;">'; /* Rating details */
				$output .= '<p class="review-author">' . esc_html( $review->comment_author ) . '</p>';
				$output .= '<p class="review-date">' . gmdate( 'd M, Y', $timestamp ) . '</p>';
				$output .= '<div class="quiqowl-lightbox__product-rating" style="display:inline;background: linear-gradient(90deg, ' . esc_attr( $star_primary ) . ' ' . esc_attr( $rating_percent ) . ', ' . esc_attr( $star_secondary ) . ' ' . esc_attr( $rating_percent ) . ');">★★★★★</div>';

				$output .= '</div>'; /* End Rating Details */
				$output .= '<div class="review-content"><span style="font-size:22px;">&#x201C</span>' . quiqowl_create_excerpt( $review->comment_content ) . '</div>';

				$output .= '</div>'; /* End Swiper Slide */
			}
			$output .= '</div>';

			$output .= '<div class="swiper-pagination"></div>';

			$output .= '</div>';
			/* End Product Rating Carousel */
		}

		$output .= '</div>'; /* <!-- Product Details --> */

		wp_send_json_success(
			array(
				// 'render' => apply_filters( 'quiqowl_apply_html_render_sanitization', $output ),
				'render' => $output,
			)
		);

	} else {
		wp_send_json_error( 'Unable to fetch product details!' );
	}
}

/* Ajax Loader Data */
add_action( 'wp_ajax_quiqowl_ajax_load_data', 'quiqowl_ajax_load_data_callback' );
add_action( 'wp_ajax_nopriv_quiqowl_ajax_load_data', 'quiqowl_ajax_load_data_callback' );
/**
 * Callback for ajax loader.
 */
function quiqowl_ajax_load_data_callback() {
	check_ajax_referer( 'quiqowl__ajax_loader', 'nonce', true );

	$quota                = isset( $_POST['quota'] ) ? sanitize_text_field( wp_unslash( $_POST['quota'] ) ) : 10;
	$offset               = isset( $_POST['offset'] ) ? sanitize_text_field( wp_unslash( $_POST['offset'] ) ) : 10;
	$content_loaded_count = isset( $_POST['contentLoaded'] ) ? sanitize_text_field( wp_unslash( $_POST['contentLoaded'] ) ) : 0;

	$attributes = isset( $_POST['attributes'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['attributes'] ) ), true ) : array();

	if ( empty( $attributes ) ) {
		wp_send_json_success( array() );
		return;
	}

	$query        = isset( $_POST['search'] ) && ! empty( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
	$category     = isset( $_POST['category'] ) ? sanitize_text_field( wp_unslash( $_POST['category'] ) ) : '';
	$min_price    = isset( $_POST['minPrice'] ) ? sanitize_text_field( wp_unslash( $_POST['minPrice'] ) ) : '';
	$max_price    = isset( $_POST['maxPrice'] ) ? sanitize_text_field( wp_unslash( $_POST['maxPrice'] ) ) : '';
	$product_tags = isset( $_POST['tags'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['tags'] ) ), true ) : array();
	$product_tags = map_deep( $product_tags, 'sanitize_text_field' );
	$rating       = isset( $_POST['rating'] ) ? sanitize_text_field( wp_unslash( $_POST['rating'] ) ) : '';

	$product_attributes = isset( $_POST['wcProductAttributes'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['wcProductAttributes'] ) ), true ) : array();
	array_walk_recursive( $product_attributes, 'quiqowl_sanitize_pa' );

	$product_ids = isset( $_POST['productIds'] ) ? json_decode( sanitize_text_field( wp_unslash( $_POST['productIds'] ) ) ) : array();
	$product_ids = array_unique( array_map( 'absint', (array) $product_ids ) );

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => intval( $quota ) <= intval( $offset ) && 0 !== intval( $quota ) ? $quota : $offset,
		'post_status'    => 'publish',
		'meta_query'     => array( 'relation' => 'AND' ),
	);

	if ( ! empty( $query ) ) {
		$args['s'] = $query;
	}

	if ( isset( $category ) && ! empty( $category ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',  // Use WooCommerce product category
			'field'    => 'slug',         // Change 'slug' to 'id' if you're passing category IDs
			'terms'    => $category,
		);
	}

	if ( ! empty( $min_price ) && ! empty( $max_price ) ) {
		$args['meta_query'][] = array(
			'key'     => '_price',
			'value'   => $min_price,
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
		$args['meta_query'][] = array(
			'key'     => '_price',
			'value'   => $max_price,
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
		$args['meta_query'][] = array(
			'key'     => '_price',
			'compare' => 'EXISTS',
		);
	}

	if ( is_array( $product_tags ) && ! empty( $product_tags ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_tag',  // Use WooCommerce product tag
			'field'    => 'slug',         // Change 'slug' to 'id' if you're passing tag IDs
			'terms'    => $product_tags,
		);
	}

	if ( isset( $attributes['stockFilter']['enabled'] ) && filter_var( $attributes['stockFilter']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
		$args['meta_query'][] = array(
			array(
				'key'     => '_stock_status',
				'value'   => 'instock', // Only get products that are in stock.
				'compare' => '=',       // Ensure exact match.
			),
		);
	}

	if ( isset( $rating ) && ! empty( $rating ) ) {
		$args['meta_query'][] = array(
			'key'     => '_wc_average_rating',  // WooCommerce stores the average rating in this meta key
			'value'   => $rating,
			'compare' => '>=',
			'type'    => 'DECIMAL',             // Use 'DECIMAL' to handle floating-point numbers
		);
	}

	if ( isset( $product_attributes ) && ! empty( $product_attributes ) ) {
		foreach ( $product_attributes as $pa_attr ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'pa_' . $pa_attr['attribute_name'],
				'field'    => 'slug',
				'terms'    => $pa_attr['value'],
			);
		}
	}

	$args['post__not_in'] = $product_ids;

	// Create a new query.
	$product_query = new WP_Query( $args );
	$products      = $product_query->posts;

	$render = quiqowl_render_search_results( $products, $attributes, true );

	// Check for the next slot.
	$rendered_product_ids = array_map(
		function ( $product ) {
			return $product->ID;
		},
		$products
	);
	$current_product_ids  = array_merge( $product_ids, $rendered_product_ids );

	$content_loaded_count = count( $rendered_product_ids );

	$quota -= $content_loaded_count;

	$args['post__not_in'] = $current_product_ids;
	// Create a new query.
	$product_query = new WP_Query( $args );
	$next_products = $product_query->posts;
	$has_next      = false;
	if ( count( $next_products ) > 0 && $quota > 0 ) {
		$has_next = true;
	}

	if ( $quota < 0 ) {
		$render = '';
	}

	$return_data = array(
		// 'render'   => apply_filters( 'quiqowl_apply_html_render_sanitization', $render ),
		'render'   => $render,
		'has_next' => $has_next,
		'quota'    => $quota,
	);

	wp_send_json_success( $return_data );
}

/* Product views */
add_action( 'wp_ajax_quiqowl_update_product_view', 'quiqowl_update_product_view_callback' );
add_action( 'wp_ajax_nopriv_quiqowl_update_product_view', 'quiqowl_update_product_view_callback' );
/**
 * Callback for product views.
 */
function quiqowl_update_product_view_callback() {
	check_ajax_referer( 'quiqowl__product_data', 'nonce', true );

	$product_id = isset( $_POST['productId'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['productId'] ) ) ) : '';

	quiqowl_set_product_unique_key( $product_id, 'PRODUCT_VIEWS' );

	$product_data = get_post_meta( $product_id, 'quiqowl_product_data' );

	wp_send_json_success(
		array(
			'post_meta' => $product_data,
		)
	);
}

/* Product views */
add_action( 'wp_ajax_quiqowl_admin_render_product_cart_data', 'quiqowl_admin_render_product_cart_data_callback' );
add_action( 'wp_ajax_nopriv_quiqowl_admin_render_product_cart_data', 'quiqowl_admin_render_product_cart_data_callback' );
/**
 * Callback for Admin product analytics page.
 */
function quiqowl_admin_render_product_cart_data_callback() {
	check_ajax_referer( 'quiqowl-admin__product_cart_data', 'nonce', true );

	$post_id = isset( $_POST['productID'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['productID'] ) ) ) : 0;

	if ( $post_id <= 0 ) {
		wp_send_json_error();
		return;
	}

	$quiqowl_product_key = 'quiqowl_product_data';

	$product_data = get_post_meta( $post_id, $quiqowl_product_key, true );

	if ( ! isset( $product_data['cart_details'] ) || ! is_array( $product_data['cart_details'] ) || empty( $product_data['cart_details'] ) ) {
		wp_send_json_error();
		return;
	}

	$cart_details = $product_data['cart_details'];

	$output = '';

	/* Logged In Data */
	if ( isset( $cart_details['_logged_in_data'] ) && ! empty( $cart_details['_logged_in_data'] ) ) {
		$output .= '<table class="user-data">';

		$output .= '<caption>' . esc_html__( 'Logged in data', 'quiqowl' ) . '</caption>';

		$output .= '<colgroup>';
		$output .= '<col style="width: 15%;">';
		$output .= '<col style="width: 20%;">';
		$output .= '<col style="width: 65%;">';
		$output .= '</colgroup>';

		// Table headers.
		$output .= '<tr>';
		$output .= '<th>' . esc_html__( '#ID', 'quiqowl' ) . '</th>';
		$output .= '<th>' . esc_html__( 'Username', 'quiqowl' ) . '</th>';
		$output .= '<th>' . esc_html__( 'Logs', 'quiqowl' ) . '</th>';
		$output .= '</tr>';

		// Table data.
		foreach ( $cart_details['_logged_in_data'] as $user_id => $data ) {
			$user    = get_user( $user_id );
			$output .= '<tr>';
			$output .= '<td><p>' . esc_html( $user_id ) . '</p></td>';
			$output .= '<td><p>' . esc_html( $user->user_nicename ) . '</p></td>';
			$output .= '<td><ul class="log-list">';
			if ( ! empty( $cart_details['_logged_in_data'][ $user_id ] ) ) {
				uksort(
					$cart_details['_logged_in_data'][ $user_id ],
					function ( $a, $b ) {
						return strtotime( $b ) - strtotime( $a );
					}
				);

				foreach ( $cart_details['_logged_in_data'][ $user_id ] as $date => $log ) {
					$output               .= '<li>';
					$output               .= '<div class="log-header">';
					$output               .= '<span class="log-date">' . esc_html( $date ) . '</span>';
					$plugin_trigger_string = ! empty( $log['plugin_trigger'] ) ? esc_html__( 'Yes', 'quiqowl' ) : esc_html__( 'No', 'quiqowl' );
					$output               .= '<span class="log-plugin-trigger">' . esc_html__( 'Plugin Trigger: ', 'quiqowl' ) . $plugin_trigger_string . '</span>';
					$output               .= '</div>';
					$output               .= '<div class="log-details">';
					$output               .= '<p>' . esc_html__( 'Product Price: ', 'quiqowl' ) . wc_price( esc_html( $log['product_price'] ) ) . '</p>';
					$output               .= '<p>' . esc_html__( 'Quantity Added: ', 'quiqowl' ) . esc_html( $log['product_quantity'] ) . '</p>';
					$output               .= '</div>';
					$output               .= '</li>';
				}
			}
			$output .= '</ul></td>';
			$output .= '</tr>';
		}
		$output .= '</table>';
	}

	// Table data.
	if ( isset( $cart_details['_not_logged_in_data'] ) && ! empty( $cart_details['_not_logged_in_data'] ) ) {
		/* Not Logged In Data */
		$output .= '<table class="session-data">';

		$output .= '<caption>' . esc_html__( 'Session data', 'quiqowl' ) . '</caption>';

		$output .= '<colgroup>';
		$output .= '<col style="width: 30%;">';
		$output .= '<col style="width: 70%;">';
		$output .= '</colgroup>';

		// Table headers.
		$output .= '<tr>';
		$output .= '<th>' . esc_html__( '#Tracking Number', 'quiqowl' ) . '</th>';
		$output .= '<th>' . esc_html__( 'Logs', 'quiqowl' ) . '</th>';
		$output .= '</tr>';

		// Remove empty transients.
		foreach ( $cart_details['_not_logged_in_data'] as $key => $session_id ) {
			$session_data = get_transient( $session_id );

			if ( empty( $session_data ) ) {
				unset( $cart_details['_not_logged_in_data'][ $key ] );
			}
		}

		if ( isset( $product_data['cart_details']['_not_logged_in_data'] ) && ( array_diff( $product_data['cart_details']['_not_logged_in_data'], $cart_details['_not_logged_in_data'] ) || array_diff( $cart_details['_not_logged_in_data'], $product_data['cart_details']['_not_logged_in_data'] ) ) ) {
			$product_data['cart_details']['_not_logged_in_data'] = $cart_details['_not_logged_in_data'];

			update_post_meta( $post_id, $quiqowl_product_key, $product_data );
		}

		krsort( $cart_details['_not_logged_in_data'] );

		foreach ( $cart_details['_not_logged_in_data'] as $session_id ) {
			$session_data = get_transient( $session_id );

			$output .= '<tr>';
			$output .= '<td><p>' . esc_html( $session_id ) . '</p></td>';
			if ( ! empty( $session_data ) ) {
				$output .= '<td><ul class="log-list">';
				foreach ( $session_data as $date => $log ) {
					$output               .= '<li>';
					$output               .= '<div class="log-header">';
					$output               .= '<span class="log-date">' . esc_html( $date ) . '</span>';
					$plugin_trigger_string = ! empty( $log['plugin_trigger'] ) ? esc_html__( 'Yes', 'quiqowl' ) : esc_html__( 'No', 'quiqowl' );
					$output               .= '<span class="log-plugin-trigger">' . esc_html__( 'Plugin Trigger: ', 'quiqowl' ) . $plugin_trigger_string . '</span>';
					$output               .= '</div>';
					$output               .= '<div class="log-details">';
					$output               .= '<p>' . esc_html__( 'Product Price: ', 'quiqowl' ) . wc_price( esc_html( $log['product_price'] ) ) . '</p>';
					$output               .= '<p>' . esc_html__( 'Quantity Added: ', 'quiqowl' ) . esc_html( $log['product_quantity'] ) . '</p>';
					$output               .= '</div>';
					$output               .= '</li>';
				}
				$output .= '</ul></td>';
			} else {
				$output .= '<td>' . esc_html__( 'N/A', 'quiqowl' ) . '</td>';
			}
			$output .= '</tr>';
		}

		$output .= '</table>';
	}

	wp_send_json_success(
		array(
			// 'render' => apply_filters( 'quiqowl_apply_html_render_sanitization', $output ),
			'render' => $output,
		)
	);
}
