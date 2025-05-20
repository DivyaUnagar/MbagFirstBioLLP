<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$client_id = ! empty( $attributes['clientId'] ) ? str_replace( array( ';', '=', '(', ')', ' ' ), '', $attributes['clientId'] ) : '';
$block_id  = 'quiqowlBlock_' . str_replace( '-', '_', sanitize_key( $client_id ) );

$wrapper_styles = array(
	'desktop' => array(
		'padding' => isset( $attributes['styles']['responsive']['desktop']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['styles']['responsive']['desktop']['padding'] ) : '',
		'width'   => isset( $attributes['styles']['responsive']['desktop']['width'] ) ? esc_attr( $attributes['styles']['responsive']['desktop']['width'] ) : '',
	),
	'tablet'  => array(
		'padding' => isset( $attributes['styles']['responsive']['tablet']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['styles']['responsive']['tablet']['padding'] ) : '',
		'width'   => isset( $attributes['styles']['responsive']['tablet']['width'] ) ? esc_attr( $attributes['styles']['responsive']['tablet']['width'] ) : '',
	),
	'mobile'  => array(
		'padding' => isset( $attributes['styles']['responsive']['mobile']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['styles']['responsive']['mobile']['padding'] ) : '',
		'width'   => isset( $attributes['styles']['responsive']['mobile']['width'] ) ? esc_attr( $attributes['styles']['responsive']['mobile']['width'] ) : '',
	),
	'margin'  => array(
		'top'    => isset( $attributes['styles']['margin']['top'] ) ? esc_attr( $attributes['styles']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['styles']['margin']['bottom'] ) ? esc_attr( $attributes['styles']['margin']['bottom'] ) : '',
	),
	'color'   => array(
		'text' => isset( $attributes['styles']['color']['text'] ) ? esc_attr( $attributes['styles']['color']['text'] ) : '',
	),
);

$category_filter = array(
	'label'      => isset( $attributes['categoryFilter']['label'] ) ? sanitize_text_field( $attributes['categoryFilter']['label'] ) : '',
	'desktop'    => array(
		'padding' => isset( $attributes['categoryFilter']['desktop']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['categoryFilter']['desktop']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['categoryFilter']['desktop']['font']['size'] ) ? esc_attr( $attributes['categoryFilter']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'     => array(
		'padding' => isset( $attributes['categoryFilter']['tablet']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['categoryFilter']['tablet']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['categoryFilter']['tablet']['font']['size'] ) ? esc_attr( $attributes['categoryFilter']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'     => array(
		'padding' => isset( $attributes['categoryFilter']['mobile']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['categoryFilter']['mobile']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['categoryFilter']['mobile']['font']['size'] ) ? esc_attr( $attributes['categoryFilter']['mobile']['font']['size'] ) : '',
		),
	),
	'border'     => isset( $attributes['categoryFilter']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['categoryFilter']['border'] ) : '',
	'shadow'     => array(
		'horizontal' => isset( $attributes['categoryFilter']['shadow']['horizontal'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['horizontal'] ) : '0',
		'vertical'   => isset( $attributes['categoryFilter']['shadow']['vertical'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['vertical'] ) : '0',
		'blur'       => isset( $attributes['categoryFilter']['shadow']['blur'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['blur'] ) : '0',
		'spread'     => isset( $attributes['categoryFilter']['shadow']['spread'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['spread'] ) : '0',
		'color'      => isset( $attributes['categoryFilter']['shadow']['color'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['color'] ) : '',
		'position'   => isset( $attributes['categoryFilter']['shadow']['position'] ) ? esc_attr( $attributes['categoryFilter']['shadow']['position'] ) : '',
	),
	'typography' => array(
		'font'           => array(
			'family' => isset( $attributes['categoryFilter']['typography']['font']['family'] ) ? esc_attr( $attributes['categoryFilter']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['categoryFilter']['typography']['lineHeight'] ) ? esc_attr( $attributes['categoryFilter']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['categoryFilter']['typography']['letterSpacing'] ) ? esc_attr( $attributes['categoryFilter']['typography']['letterSpacing'] ) : '',
	),
	'color'      => array(
		'text' => isset( $attributes['categoryFilter']['color']['text'] ) ? esc_attr( $attributes['categoryFilter']['color']['text'] ) : '',
		'bg'   => isset( $attributes['categoryFilter']['color']['bg'] ) ? esc_attr( $attributes['categoryFilter']['color']['bg'] ) : '',
	),
);

$price_filter = array(
	'start' => isset( $attributes['priceFilter']['range']['start'] ) ? sanitize_text_field( $attributes['priceFilter']['range']['start'] ) : '',
	'end'   => isset( $attributes['priceFilter']['range']['end'] ) ? sanitize_text_field( $attributes['priceFilter']['range']['end'] ) : '',
);

$search_bar = array(
	'label'      => isset( $attributes['searchBar']['label'] ) ? sanitize_text_field( $attributes['searchBar']['label'] ) : '',
	'border'     => isset( $attributes['searchBar']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['searchBar']['border'] ) : '',
	'radius'     => isset( $attributes['searchBar']['radius'] ) ? quiqowl_render_trbl( 'radius', $attributes['searchBar']['radius'] ) : '',
	'desktop'    => array(
		'width'   => isset( $attributes['searchBar']['desktop']['width'] ) ? esc_attr( $attributes['searchBar']['desktop']['width'] ) : '',
		'height'  => isset( $attributes['searchBar']['desktop']['height'] ) ? esc_attr( $attributes['searchBar']['desktop']['height'] ) : '',
		'padding' => isset( $attributes['searchBar']['desktop']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['searchBar']['desktop']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['searchBar']['desktop']['typography']['font']['size'] ) ? esc_attr( $attributes['searchBar']['desktop']['typography']['font']['size'] ) : '',
		),
	),
	'tablet'     => array(
		'width'   => isset( $attributes['searchBar']['tablet']['width'] ) ? esc_attr( $attributes['searchBar']['tablet']['width'] ) : '',
		'height'  => isset( $attributes['searchBar']['tablet']['height'] ) ? esc_attr( $attributes['searchBar']['tablet']['height'] ) : '',
		'padding' => isset( $attributes['searchBar']['tablet']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['searchBar']['tablet']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['searchBar']['tablet']['typography']['font']['size'] ) ? esc_attr( $attributes['searchBar']['tablet']['typography']['font']['size'] ) : '',
		),
	),
	'mobile'     => array(
		'width'   => isset( $attributes['searchBar']['mobile']['width'] ) && ! empty( $attributes['searchBar']['mobile']['width'] ) ? esc_attr( $attributes['searchBar']['mobile']['width'] ) : '100%',
		'height'  => isset( $attributes['searchBar']['mobile']['height'] ) ? $attributes['searchBar']['mobile']['height'] : '',
		'padding' => isset( $attributes['searchBar']['mobile']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['searchBar']['mobile']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['searchBar']['mobile']['typography']['font']['size'] ) ? esc_attr( $attributes['searchBar']['mobile']['typography']['font']['size'] ) : '',
		),
	),
	'typography' => array(
		'font'           => array(
			'family' => isset( $attributes['searchBar']['typography']['font']['family'] ) ? esc_attr( $attributes['searchBar']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['searchBar']['typography']['lineHeight'] ) ? esc_attr( $attributes['searchBar']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['searchBar']['typography']['letterSpacing'] ) ? esc_attr( $attributes['searchBar']['typography']['letterSpacing'] ) : '',
	),
	'color'      => array(
		'text'         => isset( $attributes['searchBar']['color']['text'] ) ? esc_attr( $attributes['searchBar']['color']['text'] ) : '',
		'text_focus'   => isset( $attributes['searchBar']['color']['textFocus'] ) ? esc_attr( $attributes['searchBar']['color']['textFocus'] ) : '',
		'bg'           => isset( $attributes['searchBar']['color']['bg'] ) ? esc_attr( $attributes['searchBar']['color']['bg'] ) : '',
		'border_focus' => isset( $attributes['searchBar']['color']['borderFocus'] ) ? esc_attr( $attributes['searchBar']['color']['borderFocus'] ) : '',
	),
);

$search_icon = array(
	'margin'  => array(
		'top'    => isset( $attributes['searchButton']['margin']['top'] ) ? esc_attr( $attributes['searchButton']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['searchButton']['margin']['bottom'] ) ? esc_attr( $attributes['searchButton']['margin']['bottom'] ) : '',
	),
	'border'  => isset( $attributes['seachButton']['box']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['seachButton']['box']['border'] ) : '',
	'radius'  => isset( $attributes['seachButton']['box']['radius'] ) ? quiqowl_render_trbl( 'radius', $attributes['seachButton']['box']['radius'] ) : '',
	'desktop' => array(
		'size'       => isset( $attributes['searchButton']['desktop']['size'] ) ? esc_attr( $attributes['searchButton']['desktop']['size'] ) : '',
		'box_width'  => isset( $attributes['searchButton']['desktop']['boxWidth'] ) ? esc_attr( $attributes['searchButton']['desktop']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['searchButton']['desktop']['boxHeight'] ) ? esc_attr( $attributes['searchButton']['desktop']['boxHeight'] ) : '',
	),
	'tablet'  => array(
		'size'       => isset( $attributes['searchButton']['tablet']['size'] ) ? esc_attr( $attributes['searchButton']['tablet']['size'] ) : '',
		'box_width'  => isset( $attributes['searchButton']['tablet']['boxWidth'] ) ? esc_attr( $attributes['searchButton']['tablet']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['searchButton']['tablet']['boxHeight'] ) ? esc_attr( $attributes['searchButton']['tablet']['boxHeight'] ) : '',
	),
	'mobile'  => array(
		'size'       => isset( $attributes['searchButton']['mobile']['size'] ) ? esc_attr( $attributes['searchButton']['mobile']['size'] ) : '',
		'box_width'  => isset( $attributes['searchButton']['mobile']['boxWidth'] ) ? esc_attr( $attributes['searchButton']['mobile']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['searchButton']['mobile']['boxHeight'] ) ? esc_attr( $attributes['searchButton']['mobile']['boxHeight'] ) : '',
	),
	'color'   => array(
		'text'         => isset( $attributes['searchButton']['color']['text'] ) ? esc_attr( $attributes['searchButton']['color']['text'] ) : '',
		'text_hover'   => isset( $attributes['searchButton']['color']['textHover'] ) ? esc_attr( $attributes['searchButton']['color']['textHover'] ) : '',
		'bg'           => isset( $attributes['searchButton']['color']['bg'] ) ? esc_attr( $attributes['searchButton']['color']['bg'] ) : '',
		'bg_hover'     => isset( $attributes['searchButton']['color']['bgHover'] ) ? esc_attr( $attributes['searchButton']['color']['bgHover'] ) : '',
		'border_hover' => isset( $attributes['searchButton']['color']['borderHover'] ) ? esc_attr( $attributes['searchButton']['color']['borderHover'] ) : '',
	),
);

$box = array(
	'desktop'   => array(
		'container'  => array(
			'padding' => isset( $attributes['productBox']['desktop']['container']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['desktop']['container']['padding'] ) : '',
			'width'   => isset( $attributes['productBox']['desktop']['container']['width'] ) ? esc_attr( $attributes['productBox']['desktop']['container']['width'] ) : '',
			'height'  => isset( $attributes['productBox']['desktop']['container']['height'] ) ? esc_attr( $attributes['productBox']['desktop']['container']['height'] ) : '',
		),
		'item'       => array(
			'padding' => isset( $attributes['productBox']['desktop']['item']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['desktop']['item']['padding'] ) : '',
			'font'    => array(
				'size' => isset( $attributes['productBox']['item']['desktop']['font']['size'] ) ? esc_attr( $attributes['productBox']['item']['desktop']['font']['size'] ) : '',
			),
		),
		'filter_box' => array(
			'width' => isset( $attributes['filterBox']['desktop']['width'] ) ? $attributes['filterBox']['desktop']['width'] : '',
		),
	),
	'tablet'    => array(
		'container'  => array(
			'padding' => isset( $attributes['productBox']['tablet']['container']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['tablet']['container']['padding'] ) : '',
			'width'   => isset( $attributes['productBox']['tablet']['container']['width'] ) ? esc_attr( $attributes['productBox']['tablet']['container']['width'] ) : '',
			'height'  => isset( $attributes['productBox']['tablet']['container']['height'] ) ? esc_attr( $attributes['productBox']['tablet']['container']['height'] ) : '',
		),
		'item'       => array(
			'padding' => isset( $attributes['productBox']['tablet']['item']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['tablet']['item']['padding'] ) : '',
			'font'    => array(
				'size' => isset( $attributes['productBox']['item']['tablet']['font']['size'] ) ? esc_attr( $attributes['productBox']['item']['tablet']['font']['size'] ) : '',
			),
		),
		'filter_box' => array(
			'width' => isset( $attributes['filterBox']['tablet']['width'] ) ? $attributes['filterBox']['tablet']['width'] : '',
		),
	),
	'mobile'    => array(
		'container'  => array(
			'padding' => isset( $attributes['productBox']['mobile']['container']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['mobile']['container']['padding'] ) : '',
			'width'   => isset( $attributes['productBox']['mobile']['container']['width'] ) ? esc_attr( $attributes['productBox']['mobile']['container']['width'] ) : '',
			'height'  => isset( $attributes['productBox']['mobile']['container']['height'] ) ? esc_attr( $attributes['productBox']['mobile']['container']['height'] ) : '',
		),
		'item'       => array(
			'padding' => isset( $attributes['productBox']['mobile']['item']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['productBox']['mobile']['item']['padding'] ) : '',
			'font'    => array(
				'size' => isset( $attributes['productBox']['item']['mobile']['font']['size'] ) ? esc_attr( $attributes['productBox']['item']['mobile']['font']['size'] ) : '',
			),
		),
		'filter_box' => array(
			'width' => isset( $attributes['filterBox']['mobile']['width'] ) ? $attributes['filterBox']['mobile']['width'] : '',
		),
	),
	'container' => array(
		'margin' => array(
			'top'    => isset( $attributes['productBox']['container']['margin']['top'] ) ? esc_attr( $attributes['productBox']['container']['margin']['top'] ) : '',
			'bottom' => isset( $attributes['productBox']['container']['margin']['bottom'] ) ? esc_attr( $attributes['productBox']['container']['margin']['bottom'] ) : '',
		),
		'border' => isset( $attributes['productBox']['container']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['productBox']['container']['border'] ) : '',
		'radius' => isset( $attributes['productBox']['container']['radius'] ) ? esc_attr( $attributes['productBox']['container']['radius'] ) : '',
		'shadow' => array(
			'horizontal' => isset( $attributes['productBox']['container']['shadow']['horizontal'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['horizontal'] ) : '',
			'vertical'   => isset( $attributes['productBox']['container']['shadow']['vertical'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['vertical'] ) : '',
			'blur'       => isset( $attributes['productBox']['container']['shadow']['blur'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['blur'] ) : '',
			'spread'     => isset( $attributes['productBox']['container']['shadow']['spread'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['spread'] ) : '',
			'color'      => isset( $attributes['productBox']['container']['shadow']['color'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['color'] ) : '',
			'position'   => isset( $attributes['productBox']['container']['shadow']['position'] ) ? esc_attr( $attributes['productBox']['container']['shadow']['position'] ) : '',
		),
		'color'  => array(
			'bg'                => isset( $attributes['productBox']['container']['color']['bg'] ) ? esc_attr( $attributes['productBox']['container']['color']['bg'] ) : '',
			'spinner_primary'   => isset( $attributes['productBox']['container']['color']['spinnerPrimary'] ) ? esc_attr( $attributes['productBox']['container']['color']['spinnerPrimary'] ) : '',
			'spinner_secondary' => isset( $attributes['productBox']['container']['color']['spinnerSecondary'] ) ? esc_attr( $attributes['productBox']['container']['color']['spinnerSecondary'] ) : '',
		),
	),
	'item'      => array(
		'border'       => isset( $attributes['productBox']['item']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['productBox']['item']['border'] ) : '',
		'radius'       => isset( $attributes['productBox']['item']['radius'] ) ? esc_attr( $attributes['productBox']['item']['radius'] ) : '',
		'shadow'       => array(
			'horizontal' => isset( $attributes['productBox']['item']['shadow']['horizontal'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['horizontal'] ) : '',
			'vertical'   => isset( $attributes['productBox']['item']['shadow']['vertical'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['vertical'] ) : '',
			'blur'       => isset( $attributes['productBox']['item']['shadow']['blur'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['blur'] ) : '',
			'spread'     => isset( $attributes['productBox']['item']['shadow']['spread'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['spread'] ) : '',
			'color'      => isset( $attributes['productBox']['item']['shadow']['color'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['color'] ) : '',
			'position'   => isset( $attributes['productBox']['item']['shadow']['position'] ) ? esc_attr( $attributes['productBox']['item']['shadow']['position'] ) : '',
		),
		'shadow_hover' => array(
			'horizontal' => isset( $attributes['productBox']['item']['shadowHover']['horizontal'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['horizontal'] ) : '',
			'vertical'   => isset( $attributes['productBox']['item']['shadowHover']['vertical'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['vertical'] ) : '',
			'blur'       => isset( $attributes['productBox']['item']['shadowHover']['blur'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['blur'] ) : '',
			'spread'     => isset( $attributes['productBox']['item']['shadowHover']['spread'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['spread'] ) : '',
			'color'      => isset( $attributes['productBox']['item']['shadowHover']['color'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['color'] ) : '',
			'position'   => isset( $attributes['productBox']['item']['shadowHover']['position'] ) ? esc_attr( $attributes['productBox']['item']['shadowHover']['position'] ) : '',
		),
		'typography'   => array(
			'font'           => array(
				'family' => isset( $attributes['productBox']['item']['typography']['font']['family'] ) ? esc_attr( $attributes['productBox']['item']['typography']['font']['family'] ) : '',
			),
			'line_height'    => isset( $attributes['productBox']['item']['typography']['lineHeight'] ) ? esc_attr( $attributes['productBox']['item']['typography']['lineHeight'] ) : '',
			'letter_spacing' => isset( $attributes['productBox']['item']['typography']['letterSpacing'] ) ? esc_attr( $attributes['productBox']['item']['typography']['letterSpacing'] ) : '',
		),
		'color'        => array(
			'text'         => isset( $attributes['productBox']['item']['color']['text'] ) ? esc_attr( $attributes['productBox']['item']['color']['text'] ) : '',
			'bg'           => isset( $attributes['productBox']['item']['color']['bg'] ) ? esc_attr( $attributes['productBox']['item']['color']['bg'] ) : '',
			'bg_hover'     => isset( $attributes['productBox']['item']['color']['bgHover'] ) ? esc_attr( $attributes['productBox']['item']['color']['bgHover'] ) : '',
			'border_hover' => isset( $attributes['productBox']['item']['color']['borderHover'] ) ? esc_attr( $attributes['productBox']['item']['color']['borderHover'] ) : '',
		),
	),
);

$product_image = array(
	'desktop' => array(
		'width'  => isset( $attributes['productImage']['desktop']['width'] ) ? esc_attr( $attributes['productImage']['desktop']['width'] ) : '',
		'height' => isset( $attributes['productImage']['desktop']['height'] ) ? esc_attr( $attributes['productImage']['desktop']['height'] ) : '',
	),
	'tablet'  => array(
		'width'  => isset( $attributes['productImage']['tablet']['width'] ) ? esc_attr( $attributes['productImage']['tablet']['width'] ) : '',
		'height' => isset( $attributes['productImage']['tablet']['height'] ) ? esc_attr( $attributes['productImage']['tablet']['height'] ) : '',
	),
	'mobile'  => array(
		'width'  => isset( $attributes['productImage']['mobile']['width'] ) ? esc_attr( $attributes['productImage']['mobile']['width'] ) : '',
		'height' => isset( $attributes['productImage']['mobile']['height'] ) ? esc_attr( $attributes['productImage']['mobile']['height'] ) : '',
	),
	'radius'  => isset( $attributes['productImage']['radius'] ) ? quiqowl_render_trbl( 'radius', $attributes['productImage']['radius'] ) : '',
);

$sale_badge = array(
	'desktop'    => array(
		'padding' => isset( $attributes['saleBadge']['desktop']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['saleBadge']['desktop']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['saleBadge']['desktop']['font']['size'] ) ? esc_attr( $attributes['saleBadge']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'     => array(
		'padding' => isset( $attributes['saleBadge']['tablet']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['saleBadge']['tablet']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['saleBadge']['tablet']['font']['size'] ) ? esc_attr( $attributes['saleBadge']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'     => array(
		'padding' => isset( $attributes['saleBadge']['mobile']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['saleBadge']['mobile']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['saleBadge']['mobile']['font']['size'] ) ? esc_attr( $attributes['saleBadge']['mobile']['font']['size'] ) : '',
		),
	),
	'top'        => isset( $attributes['saleBadge']['top'] ) ? esc_attr( $attributes['saleBadge']['top'] ) : '',
	'left'       => isset( $attributes['saleBadge']['left'] ) ? esc_attr( $attributes['saleBadge']['left'] ) : '',
	'right'      => isset( $attributes['saleBadge']['right'] ) ? esc_attr( $attributes['saleBadge']['right'] ) : '',
	'rotate'     => isset( $attributes['saleBadge']['rotate'] ) ? esc_attr( $attributes['saleBadge']['rotate'] ) : '',
	'border'     => isset( $attributes['saleBadge']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['saleBadge']['border'] ) : '',
	'radius'     => isset( $attributes['saleBadge']['radius'] ) ? quiqowl_render_trbl( 'radius', $attributes['saleBadge']['radius'] ) : '',
	'typography' => array(
		'font'           => array(
			'family' => isset( $attributes['saleBadge']['typography']['font']['family'] ) ? esc_attr( $attributes['saleBadge']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['saleBadge']['typography']['lineHeight'] ) ? esc_attr( $attributes['saleBadge']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['saleBadge']['typography']['letterSpacing'] ) ? esc_attr( $attributes['saleBadge']['typography']['letterSpacing'] ) : '',
	),
	'color'      => array(
		'text' => isset( $attributes['saleBadge']['color']['text'] ) ? esc_attr( $attributes['saleBadge']['color']['text'] ) : '',
		'bg'   => isset( $attributes['saleBadge']['color']['bg'] ) ? esc_attr( $attributes['saleBadge']['color']['bg'] ) : '',
	),
);

$product_title = array(
	'margin'     => array(
		'top'    => isset( $attributes['productTitle']['margin']['top'] ) ? esc_attr( $attributes['productTitle']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['productTitle']['margin']['bottom'] ) ? esc_attr( $attributes['productTitle']['margin']['bottom'] ) : '',
	),
	'desktop'    => array(
		'font' => array(
			'size' => isset( $attributes['productTitle']['desktop']['font']['size'] ) ? esc_attr( $attributes['productTitle']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'     => array(
		'font' => array(
			'size' => isset( $attributes['productTitle']['tablet']['font']['size'] ) ? esc_attr( $attributes['productTitle']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'     => array(
		'font' => array(
			'size' => isset( $attributes['productTitle']['mobile']['font']['size'] ) ? esc_attr( $attributes['productTitle']['mobile']['font']['size'] ) : '',
		),
	),
	'typography' => array(
		'font'           => array(
			'family' => isset( $attributes['productTitle']['typography']['font']['family'] ) ? esc_attr( $attributes['productTitle']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['productTitle']['typography']['lineHeight'] ) ? esc_attr( $attributes['productTitle']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['productTitle']['typography']['letterSpacing'] ) ? esc_attr( $attributes['productTitle']['typography']['letterSpacing'] ) : '',
	),
	'color'      => array(
		'text'       => isset( $attributes['productTitle']['color']['text'] ) ? esc_attr( $attributes['productTitle']['color']['text'] ) : '',
		'text_hover' => isset( $attributes['productTitle']['color']['textHover'] ) ? esc_attr( $attributes['productTitle']['color']['textHover'] ) : '',
	),
);

$product_price = array(
	'desktop'    => array(
		'font' => array(
			'size' => isset( $attributes['productPrice']['desktop']['font']['size'] ) ? esc_attr( $attributes['productPrice']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'     => array(
		'font' => array(
			'size' => isset( $attributes['productPrice']['tablet']['font']['size'] ) ? esc_attr( $attributes['productPrice']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'     => array(
		'font' => array(
			'size' => isset( $attributes['productPrice']['mobile']['font']['size'] ) ? esc_attr( $attributes['productPrice']['mobile']['font']['size'] ) : '',
		),
	),
	'typography' => array(
		'font'           => array(
			'family' => isset( $attributes['productPrice']['typography']['font']['family'] ) ? esc_attr( $attributes['productPrice']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['productPrice']['typography']['lineHeight'] ) ? esc_attr( $attributes['productPrice']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['productPrice']['typography']['letterSpacing'] ) ? esc_attr( $attributes['productPrice']['typography']['letterSpacing'] ) : '',
	),
	'color'      => array(
		'text'        => isset( $attributes['productPrice']['color']['text'] ) ? esc_attr( $attributes['productPrice']['color']['text'] ) : '',
		'text_active' => isset( $attributes['productPrice']['color']['textActive'] ) ? esc_attr( $attributes['productPrice']['color']['textActive'] ) : '',
		'text_fade'   => isset( $attributes['productPrice']['color']['textFade'] ) ? esc_attr( $attributes['productPrice']['color']['textFade'] ) : '',
	),
);

$util_icon = array(
	'desktop' => array(
		'size'       => isset( $attributes['utilIcon']['desktop']['size'] ) ? esc_attr( $attributes['utilIcon']['desktop']['size'] ) : '',
		'box_width'  => isset( $attributes['utilIcon']['desktop']['boxWidth'] ) ? esc_attr( $attributes['utilIcon']['desktop']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['utilIcon']['desktop']['boxHeight'] ) ? esc_attr( $attributes['utilIcon']['desktop']['boxHeight'] ) : '',
	),
	'tablet'  => array(
		'size'       => isset( $attributes['utilIcon']['tablet']['size'] ) ? esc_attr( $attributes['utilIcon']['tablet']['size'] ) : '',
		'box_width'  => isset( $attributes['utilIcon']['tablet']['boxWidth'] ) ? esc_attr( $attributes['utilIcon']['tablet']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['utilIcon']['tablet']['boxHeight'] ) ? esc_attr( $attributes['utilIcon']['tablet']['boxHeight'] ) : '',
	),
	'mobile'  => array(
		'size'       => isset( $attributes['utilIcon']['mobile']['size'] ) ? esc_attr( $attributes['utilIcon']['mobile']['size'] ) : '',
		'box_width'  => isset( $attributes['utilIcon']['mobile']['boxWidth'] ) ? esc_attr( $attributes['utilIcon']['mobile']['boxWidth'] ) : '',
		'box_height' => isset( $attributes['utilIcon']['mobile']['boxHeight'] ) ? esc_attr( $attributes['utilIcon']['mobile']['boxHeight'] ) : '',
	),
	'margin'  => array(
		'top'    => isset( $attributes['utilIcon']['margin']['top'] ) ? esc_attr( $attributes['utilIcon']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['utilIcon']['margin']['bottom'] ) ? esc_attr( $attributes['utilIcon']['margin']['bottom'] ) : '',
	),
	'gap'     => isset( $attributes['utilIcon']['gap'] ) ? esc_attr( $attributes['utilIcon']['gap'] ) : '',
	'border'  => isset( $attributes['utilIcon']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['utilIcon']['border'] ) : '',
	'radius'  => isset( $attributes['utilIcon']['radius'] ) ? quiqowl_render_trbl( 'radius', $attributes['utilIcon']['radius'] ) : '',
	'color'   => array(
		'cart'                    => isset( $attributes['utilIcon']['color']['cart'] ) ? esc_attr( $attributes['utilIcon']['color']['cart'] ) : '',
		'cart_hover'              => isset( $attributes['utilIcon']['color']['cartHover'] ) ? esc_attr( $attributes['utilIcon']['color']['cartHover'] ) : '',
		'cart_bg'                 => isset( $attributes['utilIcon']['color']['cartBg'] ) ? esc_attr( $attributes['utilIcon']['color']['cartBg'] ) : '',
		'cart_bg_hover'           => isset( $attributes['utilIcon']['color']['cartBgHover'] ) ? esc_attr( $attributes['utilIcon']['color']['cartBgHover'] ) : '',
		'cart_border_hover'       => isset( $attributes['utilIcon']['color']['cartBorderHover'] ) ? esc_attr( $attributes['utilIcon']['color']['cartBorderHover'] ) : '',
		'quick_view'              => isset( $attributes['utilIcon']['color']['quickView'] ) ? esc_attr( $attributes['utilIcon']['color']['quickView'] ) : '',
		'quick_view_hover'        => isset( $attributes['utilIcon']['color']['quickViewHover'] ) ? esc_attr( $attributes['utilIcon']['color']['quickViewHover'] ) : '',
		'quick_view_bg'           => isset( $attributes['utilIcon']['color']['quickViewBg'] ) ? esc_attr( $attributes['utilIcon']['color']['quickViewBg'] ) : '',
		'quick_view_bg_hover'     => isset( $attributes['utilIcon']['color']['quickViewBgHover'] ) ? esc_attr( $attributes['utilIcon']['color']['quickViewBgHover'] ) : '',
		'quick_view_border_hover' => isset( $attributes['utilIcon']['color']['quickViewBorderHover'] ) ? esc_attr( $attributes['utilIcon']['color']['quickViewBorderHover'] ) : '',
		'star_primary'            => isset( $attributes['utilIcon']['color']['starPrimary'] ) ? esc_attr( $attributes['utilIcon']['color']['starPrimary'] ) : '#fcb900',
		'star_secondary'          => isset( $attributes['utilIcon']['color']['starSecondary'] ) ? esc_attr( $attributes['utilIcon']['color']['starSecondary'] ) : '#989898',
	),
);

$ajax_loader = array(
	'label'        => isset( $attributes['ajaxLoader']['label'] ) ? sanitize_text_field( $attributes['ajaxLoader']['label'] ) : 'Load More',
	'loading_text' => isset( $attributes['ajaxLoader']['loadingText'] ) ? sanitize_text_field( $attributes['ajaxLoader']['loadingText'] ) : '',
	'desktop'      => array(
		'width'   => isset( $attributes['ajaxLoader']['desktop']['width'] ) ? esc_attr( $attributes['ajaxLoader']['desktop']['width'] ) : '',
		'padding' => isset( $attributes['ajaxLoader']['desktop']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['ajaxLoader']['desktop']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['ajaxLoader']['desktop']['font']['size'] ) ? esc_attr( $attributes['ajaxLoader']['desktop']['font']['size'] ) : '',
		),
	),
	'tablet'       => array(
		'width'   => isset( $attributes['ajaxLoader']['tablet']['width'] ) ? esc_attr( $attributes['ajaxLoader']['tablet']['width'] ) : '',
		'padding' => isset( $attributes['ajaxLoader']['tablet']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['ajaxLoader']['tablet']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['ajaxLoader']['tablet']['font']['size'] ) ? esc_attr( $attributes['ajaxLoader']['tablet']['font']['size'] ) : '',
		),
	),
	'mobile'       => array(
		'width'   => isset( $attributes['ajaxLoader']['mobile']['width'] ) ? esc_attr( $attributes['ajaxLoader']['mobile']['width'] ) : '',
		'padding' => isset( $attributes['ajaxLoader']['mobile']['padding'] ) ? quiqowl_render_trbl( 'padding', $attributes['ajaxLoader']['mobile']['padding'] ) : '',
		'font'    => array(
			'size' => isset( $attributes['ajaxLoader']['mobile']['font']['size'] ) ? esc_attr( $attributes['ajaxLoader']['mobile']['font']['size'] ) : '',
		),
	),
	'margin'       => array(
		'top'    => isset( $attributes['ajaxLoader']['margin']['top'] ) ? esc_attr( $attributes['ajaxLoader']['margin']['top'] ) : '',
		'bottom' => isset( $attributes['ajaxLoader']['margin']['bottom'] ) ? esc_attr( $attributes['ajaxLoader']['margin']['bottom'] ) : '',
	),
	'border'       => isset( $attributes['ajaxLoader']['border'] ) ? quiqowl_render_trbl( 'border', $attributes['ajaxLoader']['border'] ) : '',
	'radius'       => isset( $attributes['ajaxLoader']['radius'] ) ? esc_attr( $attributes['ajaxLoader']['radius'] ) : '',
	'typography'   => array(
		'font'           => array(
			'family' => isset( $attributes['ajaxLoader']['typography']['font']['family'] ) ? esc_attr( $attributes['ajaxLoader']['typography']['font']['family'] ) : '',
		),
		'line_height'    => isset( $attributes['ajaxLoader']['typography']['lineHeight'] ) ? esc_attr( $attributes['ajaxLoader']['typography']['lineHeight'] ) : '',
		'letter_spacing' => isset( $attributes['ajaxLoader']['typography']['letterSpacing'] ) ? esc_attr( $attributes['ajaxLoader']['typography']['letterSpacing'] ) : '',
	),
	'color'        => array(
		'text'              => isset( $attributes['ajaxLoader']['color']['text'] ) ? esc_attr( $attributes['ajaxLoader']['color']['text'] ) : '',
		'text_hover'        => isset( $attributes['ajaxLoader']['color']['textHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['textHover'] ) : '',
		'spinner_primary'   => isset( $attributes['ajaxLoader']['color']['spinnerPrimary'] ) ? esc_attr( $attributes['ajaxLoader']['color']['spinnerPrimary'] ) : '',
		'spinner_secondary' => isset( $attributes['ajaxLoader']['color']['spinnerSecondary'] ) ? esc_attr( $attributes['ajaxLoader']['color']['spinnerSecondary'] ) : '',
		'bg'                => isset( $attributes['ajaxLoader']['color']['bg'] ) ? esc_attr( $attributes['ajaxLoader']['color']['bg'] ) : '',
		'bg_hover'          => isset( $attributes['ajaxLoader']['color']['bgHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['bgHover'] ) : '',
		'border_hover'      => isset( $attributes['ajaxLoader']['color']['borderHover'] ) ? esc_attr( $attributes['ajaxLoader']['color']['borderHover'] ) : '',
	),
);

$tablet_col = isset( $attributes['productOptions']['layout']['tablet']['columns'] ) && ! empty( $attributes['productOptions']['layout']['tablet']['columns'] ) ? esc_attr( $attributes['productOptions']['layout']['tablet']['columns'] ) : 3;
$mobile_col = isset( $attributes['productOptions']['layout']['mobile']['columns'] ) && ! empty( $attributes['productOptions']['layout']['mobile']['columns'] ) ? esc_attr( $attributes['productOptions']['layout']['mobile']['columns'] ) : 2;

$block_styles = "
#$block_id {
	margin-top: {$wrapper_styles['margin']['top']};
	margin-bottom: {$wrapper_styles['margin']['bottom']};
	{$wrapper_styles['desktop']['padding']}
	color: {$wrapper_styles['color']['text']};
}
#$block_id.layout-full {
	text-align: {$attributes['justify']};
}
@media only screen and (min-width: 768px) and (max-width: 1024px) {
	#$block_id {
		{$wrapper_styles['tablet']['padding']}
	}
}
@media only screen and (max-width: 767px) {
	#$block_id {
		{$wrapper_styles['mobile']['padding']}
	}
}

#$block_id .category__dropdown {
	{$category_filter['desktop']['padding']}
	{$category_filter['border']}
	border-radius: {$attributes['categoryFilter']['radius']};
	font-size: {$category_filter['desktop']['font']['size']};
	font-weight: {$attributes['categoryFilter']['typography']['font']['weight']};
	font-family: {$category_filter['typography']['font']['family']};
	text-transform: {$attributes['categoryFilter']['typography']['letterCase']};
	text-decoration: {$attributes['categoryFilter']['typography']['decoration']};
	line-height: {$category_filter['typography']['line_height']};
	letter-spacing: {$category_filter['typography']['letter_spacing']};
	background-color: {$category_filter['color']['bg']};
	color: {$category_filter['color']['text']};
}
#$block_id .category__dropdown.has-box-shadow {
	box-shadow: {$category_filter['shadow']['horizontal']}px {$category_filter['shadow']['vertical']}px {$category_filter['shadow']['blur']}px {$category_filter['shadow']['spread']}px {$category_filter['shadow']['color']} {$category_filter['shadow']['position']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .category__dropdown {
		{$category_filter['tablet']['padding']}
		font-size: {$category_filter['tablet']['font']['size']};
	}
}

@media only screen and (max-width:767px) {
	#$block_id .category__dropdown {
		{$category_filter['mobile']['padding']}
		font-size: {$category_filter['mobile']['font']['size']};
	}
}

#$block_id form {
    gap: {$attributes['filterGap']};
	justify-content: {$attributes['justify']};
}

#$block_id .search-bar__wrapper {
    width: {$search_bar['desktop']['width']};
	justify-content: {$attributes['justify']};
}
#$block_id .search-bar__wrapper .search-bar {
	height: {$search_bar['desktop']['height']};
	max-height: {$search_bar['desktop']['height']};
	{$search_bar['desktop']['padding']}
	{$search_bar['border']}
	{$search_bar['radius']}
	font-size: {$search_bar['desktop']['font']['size']};
	font-family: {$search_bar['typography']['font']['family']};
	font-weight: {$attributes['searchBar']['typography']['font']['weight']};
	text-transform: {$attributes['searchBar']['typography']['letterCase']};
	text-decoration: {$attributes['searchBar']['typography']['decoration']};
	line-height: {$search_bar['typography']['line_height']};
	letter-spacing: {$search_bar['typography']['letter_spacing']};
	color: {$search_bar['color']['text']};
	background-color: {$search_bar['color']['bg']};
}
#$block_id .search-bar__wrapper:focus, #$block_id .search-bar__wrapper:focus-within {
	color: {$search_bar['color']['text_focus']};
	box-shadow: 0 0 0 1px {$search_bar['color']['border_focus']} inset;
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .search-bar__wrapper {
		width: {$search_bar['tablet']['width']};
	}
	#$block_id .search-bar__wrapper .search-bar {
		height: {$search_bar['tablet']['height']};
		{$search_bar['tablet']['padding']}
		font-size: {$search_bar['tablet']['font']['size']};
	}
}
	
@media only screen and (max-width:767px) {
	#$block_id .search-bar__wrapper {
		width: {$search_bar['mobile']['width']};
	}
	#$block_id .search-bar__wrapper .search-bar {
		height: {$search_bar['mobile']['height']};
		{$search_bar['mobile']['padding']}
		font-size: {$search_bar['mobile']['font']['size']};
	}
}

#$block_id .search-icon__wrapper {
	margin-top: {$search_icon['margin']['top']};
	margin-bottom: {$search_icon['margin']['bottom']};
	width: {$search_icon['desktop']['box_width']};
	height: {$search_icon['desktop']['box_height']};
	{$search_icon['border']}
	{$search_icon['radius']}
	background-color: {$search_icon['color']['bg']};
}
#$block_id .search-icon__wrapper .search-icon {
	width: {$search_icon['desktop']['size']};
	height: {$search_icon['desktop']['size']};
	fill: {$search_icon['color']['text']};
	stroke: none;
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .search-icon__wrapper {
		width: {$search_icon['tablet']['box_width']};
		height: {$search_icon['tablet']['box_height']};
	}
	#$block_id .search-icon__wrapper .search-icon {
		width: {$search_icon['tablet']['size']};
		height: {$search_icon['tablet']['size']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .search-icon__wrapper {
		width: {$search_icon['mobile']['box_width']};
		height: {$search_icon['mobile']['box_height']};
	}
	#$block_id .search-icon__wrapper .search-icon {
		width: {$search_icon['mobile']['size']};
		height: {$search_icon['mobile']['size']};
	}
}
#$block_id .search-icon__wrapper:hover {
	background-color: {$search_icon['color']['bg_hover']};
	border-color: {$search_icon['color']['border_hover']};
}
#$block_id .search-icon__wrapper:hover svg {
	fill: {$search_icon['color']['text_hover']};
}

#$block_id .quiqowl-block__search-modal {
	height: {$box['desktop']['container']['height']};
}
#$block_id.layout-default .quiqowl-block__search-modal.has-box-shadow {
	box-shadow: {$box['container']['shadow']['horizontal']}px {$box['container']['shadow']['vertical']}px {$box['container']['shadow']['blur']}px {$box['container']['shadow']['spread']}px {$box['container']['shadow']['color']} {$box['container']['shadow']['position']};
}

#$block_id .search__filters {
	width: {$box['desktop']['filter_box']['width']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .search__filters {
		width: {$box['tablet']['filter_box']['width']};
	}
}

@media only screen and (max-width:767px) {
	#$block_id .search__filters {
		width: {$box['mobile']['filter_box']['width']};
	}
}

#$block_id .search-results__product-collection {
	gap: {$attributes['productOptions']['gap']};
}
#$block_id .search-results__product-collection {
	grid-template-columns: repeat({$attributes['productOptions']['layout']['desktop']['columns']}, 1fr);
}
#$block_id .search-results__product-collection li {
	gap: {$attributes['productOptions']['layout']['contentGap']};
}
@media only screen and (max-width: 1024px) {
	#$block_id .search-results__product-collection {
		grid-template-columns: repeat({$tablet_col}, 1fr) !important;
	}
}
@media only screen and (max-width: 767px) {
	#$block_id .search-results__product-collection {
		grid-template-columns: repeat({$mobile_col}, 1fr) !important;
	}
}
@media only screen and (max-width: 420px) {
	#$block_id .search-results__product-collection {
		grid-template-columns: repeat(1, 1fr) !important;
	}
}

#$block_id .quiqowl-block__search-modal, #$block_id .qo-lightbox__body, #$block_id.layout-default.has-full-screen form, #$block_id.has-full-screen, .quiqowl-block__quick-view-body {
	background-color: {$box['container']['color']['bg']};
}
#$block_id #search-results__wrapper {
	{$box['desktop']['container']['padding']}
	margin-top: {$box['container']['margin']['top']};
	margin-bottom: {$box['container']['margin']['bottom']};
	{$box['container']['border']}
	border-radius: {$box['container']['radius']};
	background-color: {$box['container']['color']['bg']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id #search-results__wrapper {
		{$box['tablet']['container']['padding']}
	}
}
@media only screen and (max-width:767px) {
	#$block_id #search-results__wrapper {
		{$box['mobile']['container']['padding']}
	}
}

#$block_id .spinner, .quiqowl-block__product-quick-view .spinner {
	border-color: {$box['container']['color']['spinner_secondary']};
	border-top-color: {$box['container']['color']['spinner_primary']};
}

#$block_id .product-collection__item {
	{$box['desktop']['item']['padding']}
	{$box['item']['border']}
	font-size: {$box['desktop']['item']['font']['size']};
	font-family: {$box['item']['typography']['font']['family']};
	font-weight: {$attributes['productBox']['item']['typography']['font']['family']};
	text-transform: {$attributes['productBox']['item']['typography']['letterCase']};
	text-decoration: {$attributes['productBox']['item']['typography']['decoration']};
	line-height: {$box['item']['typography']['line_height']};
	letter-spacing: {$box['item']['typography']['letter_spacing']};
	border-radius: {$box['item']['radius']};
	color: {$box['item']['color']['text']};
	background-color: {$box['item']['color']['bg']};
}
#$block_id .product-collection__item:hover {
	background-color: {$box['item']['color']['bg_hover']};
	border-color: {$box['item']['color']['border_hover']};
}
#$block_id .product-collection__item.has-box-shadow {
	box-shadow: {$box['item']['shadow']['horizontal']}px {$box['item']['shadow']['vertical']}px {$box['item']['shadow']['blur']}px {$box['item']['shadow']['spread']}px {$box['item']['shadow']['color']} {$box['item']['shadow']['position']};
}
#$block_id .product-collection__item.has-hover-box-shadow:hover {
	box-shadow: {$box['item']['shadow_hover']['horizontal']}px {$box['item']['shadow_hover']['vertical']}px {$box['item']['shadow_hover']['blur']}px {$box['item']['shadow_hover']['spread']}px {$box['item']['shadow_hover']['color']} {$box['item']['shadow_hover']['position']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .product-collection__item {
		{$box['tablet']['item']['padding']}
		font-size: {$box['tablet']['item']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .product-collection__item {
		{$box['mobile']['item']['padding']}
		font-size: {$box['mobile']['item']['font']['size']};
	}
}

#$block_id .product__featured-image {
	max-width: {$product_image['desktop']['width']};
	max-height: {$product_image['desktop']['height']};
	border-radius: {$product_image['radius']};
}
#$block_id .product__featured-image img {
	height: {$product_image['desktop']['height']};
	border-radius: {$product_image['radius']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .product__featured-image {
		width: {$product_image['tablet']['width']};
		max-height: {$product_image['tablet']['height']};
	}
	#$block_id .product__featured-image img {
		height: {$product_image['tablet']['height']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .product__featured-image {
		width: {$product_image['mobile']['width']};
		max-height: {$product_image['mobile']['height']};
	}
	#$block_id .product__featured-image img {
		height: {$product_image['mobile']['height']};
	}
}

#$block_id .product__sale-badge {
	margin-top: {$sale_badge['top']};
	{$sale_badge['desktop']['padding']}
	{$sale_badge['border']}
	{$sale_badge['radius']}
	transform: rotate({$sale_badge['rotate']}deg);
	font-size: {$sale_badge['desktop']['font']['size']};
	font-family: {$sale_badge['typography']['font']['family']};
	font-weight: {$attributes['saleBadge']['typography']['font']['weight']};
	text-transform: {$attributes['saleBadge']['typography']['letterCase']};
	text-decoration: {$attributes['saleBadge']['typography']['decoration']};
	line-height: {$sale_badge['typography']['line_height']};
	letter-spacing: {$sale_badge['typography']['letter_spacing']};
	color: {$sale_badge['color']['text']};
	background-color: {$sale_badge['color']['bg']};
}	
#$block_id .product__sale-badge.position-left {
	margin-left: {$sale_badge['left']};
}

#$block_id .product__sale-badge.position-right {
	margin-right: {$sale_badge['right']};
}

@media only screen and (min-width: 768px) and (max-width: 1024px) {
	#$block_id .product__sale-badge {
		{$sale_badge['tablet']['padding']}
		font-size: {$sale_badge['tablet']['font']['size']};
	}
}
@media only screen and (max-width: 767px) {
	#$block_id .product__sale-badge {
		{$sale_badge['mobile']['padding']}
		font-size: {$sale_badge['mobile']['font']['size']};
	}
}

#$block_id .product__title-price-wrapper {
	margin-top: {$product_title['margin']['top']};
	margin-bottom: {$product_title['margin']['bottom']};
}
#$block_id .product__title-price-wrapper .product__title {
	font-size: {$product_title['desktop']['font']['size']};
	font-weight: {$attributes['productTitle']['typography']['font']['weight']};
	font-family: {$product_title['typography']['font']['family']};
	text-transform: {$attributes['productTitle']['typography']['letterCase']};
	text-decoration: {$attributes['productTitle']['typography']['decoration']};
	line-height: {$product_title['typography']['line_height']};
	letter-spacing: {$product_title['typography']['letter_spacing']};
}
#$block_id .product__title-price-wrapper .product__title a {
	color: {$product_title['color']['text']};
	text-decoration: {$attributes['productTitle']['typography']['decoration']};
}
#$block_id .product__title-price-wrapper .product__title a:hover {
	color: {$product_title['color']['text_hover']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .product__title-price-wrapper .product__title {
		font-size: {$product_title['tablet']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .product__title-price-wrapper .product__title {
		font-size: {$product_title['mobile']['font']['size']};
	}
}

#$block_id .product__title-price-wrapper .product__price {
	font-size: {$product_price['desktop']['font']['size']};
	font-weight: {$attributes['productPrice']['typography']['font']['weight']};
	font-family: {$product_price['typography']['font']['family']};
	text-transform: {$attributes['productPrice']['typography']['letterCase']};
	text-decoration: {$attributes['productPrice']['typography']['decoration']};
	line-height: {$product_price['typography']['line_height']};
	letter-spacing: {$product_price['typography']['letter_spacing']};
	color: {$product_price['color']['text']};
}
#$block_id .product__title-price-wrapper .product__price ins {
	color: {$product_price['color']['text_active']};
}

#$block_id .product__title-price-wrapper .product__price del {
	color: {$product_price['color']['text_fade']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .product__title-price-wrapper .product__price {
		font-size: {$product_price['tablet']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .product__title-price-wrapper .product__price {
		font-size: {$product_price['mobile']['font']['size']};
	}
}


#$block_id .product__icon-rating-wrapper {
	margin-top: {$util_icon['margin']['top']};
	margin-bottom: {$util_icon['margin']['bottom']};
}
#$block_id .util-icon__wrapper {
	gap: {$util_icon['gap']};
}
#$block_id .icon__wrapper {
	width: {$util_icon['desktop']['box_width']};
	height: {$util_icon['desktop']['box_height']};
	{$util_icon['border']}
	{$util_icon['radius']}
}
#$block_id .icon__wrapper svg {
	width: {$util_icon['desktop']['size']};
	height: {$util_icon['desktop']['size']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .icon__wrapper {
		width: {$util_icon['tablet']['box_width']};
		height: {$util_icon['tablet']['box_height']};
	}
	#$block_id .icon__wrapper svg {
		width: {$util_icon['tablet']['size']};
		height: {$util_icon['tablet']['size']};
	}
}
@media only screen and (max-width:767px) {
	#$block_id .icon__wrapper {
		width: {$util_icon['mobile']['box_width']};
		height: {$util_icon['mobile']['box_height']};
	}
	#$block_id .icon__wrapper svg {
		width: {$util_icon['mobile']['size']};
		height: {$util_icon['mobile']['size']};
	}
}
#$block_id .cart-icon__wrapper {
	background-color: {$util_icon['color']['cart_bg']};
}
#$block_id .cart-icon__wrapper svg {
	fill: {$util_icon['color']['cart']};
}
#$block_id .cart-icon__wrapper:hover {
	background-color: {$util_icon['color']['cart_bg_hover']};
	border-color: {$util_icon['color']['cart_border_hover']};
}
#$block_id .cart-icon__wrapper:hover svg {
	fill: {$util_icon['color']['cart_hover']};
}
#$block_id .quick-view-icon__wrapper {
	background-color: {$util_icon['color']['quick_view_bg']};
}
#$block_id .quick-view-icon__wrapper svg {
	fill: {$util_icon['color']['quick_view']};
}
#$block_id .quick-view-icon__wrapper:hover {
	background-color: {$util_icon['color']['quick_view_bg_hover']};
	border-color: {$util_icon['color']['quick_view_border_hover']};
}
#$block_id .quick-view-icon__wrapper:hover svg {
	fill: {$util_icon['color']['quick_view_hover']};
}

.quiqowl-lightbox__product-details .product__sale-badge {
	{$sale_badge['desktop']['padding']}
	font-size: {$sale_badge['desktop']['font']['size']};
	font-family: {$sale_badge['typography']['font']['family']};
	font-weight: {$attributes['saleBadge']['typography']['font']['weight']};
	text-transform: {$attributes['saleBadge']['typography']['letterCase']};
	text-decoration: {$attributes['saleBadge']['typography']['decoration']};
	line-height: {$sale_badge['typography']['line_height']};
	letter-spacing: {$sale_badge['typography']['letter_spacing']};
	color: {$sale_badge['color']['text']};
	background-color: {$sale_badge['color']['bg']};
}
@media only screen and (min-width:768px) and (max-width:1024px) {
	.quiqowl-lightbox__product-details .product__sale-badge {
		font-size: {$sale_badge['tablet']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	.quiqowl-lightbox__product-details .product__sale-badge {
		font-size: {$sale_badge['mobile']['font']['size']};
	}
}

.quiqowl-lightbox__product-details .product__title {
	font-size: {$product_title['desktop']['font']['size']};
	font-weight: {$attributes['productTitle']['typography']['font']['weight']};
	font-family: {$product_title['typography']['font']['family']};
	text-transform: {$attributes['productTitle']['typography']['letterCase']};
	text-decoration: {$attributes['productTitle']['typography']['decoration']};
	line-height: {$product_title['typography']['line_height']};
	letter-spacing: {$product_title['typography']['letter_spacing']};
}
.quiqowl-lightbox__product-details .product__title a {
	color: {$product_title['color']['text']};
	text-decoration: {$attributes['productTitle']['typography']['decoration']};
}
.quiqowl-lightbox__product-details .product__title a:hover {
	color: {$product_title['color']['text_hover']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	.quiqowl-lightbox__product-details .product__title {
		font-size: {$product_title['tablet']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	.quiqowl-lightbox__product-details .product__title {
		font-size: {$product_title['mobile']['font']['size']};
	}
}

.quiqowl-lightbox__product-details .product__price {
	font-size: {$product_price['desktop']['font']['size']};
	font-weight: {$attributes['productPrice']['typography']['font']['weight']};
	font-family: {$product_price['typography']['font']['family']};
	text-transform: {$attributes['productPrice']['typography']['letterCase']};
	text-decoration: {$attributes['productPrice']['typography']['decoration']};
	line-height: {$product_price['typography']['line_height']};
	letter-spacing: {$product_price['typography']['letter_spacing']};
	color: {$product_price['color']['text']};
}
.quiqowl-lightbox__product-details .product__price ins {
	color: {$product_price['color']['text_active']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	.quiqowl-lightbox__product-details .product__price {
		font-size: {$product_price['tablet']['font']['size']};
	}
}
@media only screen and (max-width:767px) {
	.quiqowl-lightbox__product-details .product__price {
		font-size: {$product_price['mobile']['font']['size']};
	}
}

#$block_id .qo-lightbox__body {
	max-width: {$box['desktop']['container']['width']};
	max-height: {$box['desktop']['container']['height']};
}
#$block_id.layout-full .qo-lightbox__body.has-box-shadow {
	box-shadow: {$box['container']['shadow']['horizontal']}px {$box['container']['shadow']['vertical']}px {$box['container']['shadow']['blur']}px {$box['container']['shadow']['spread']}px {$box['container']['shadow']['color']} {$box['container']['shadow']['position']};
}

#$block_id.layout-full .qo-lightbox__header {
	background-color: {$box['container']['color']['bg']};
}

@media only screen and (min-width: 768px) and (max-width: 1024px) {
	#$block_id .qo-lightbox__body {
		max-width: {$box['tablet']['container']['width']};
		max-height: {$box['tablet']['container']['height']};
	}
}
@media only screen and (max-width: 767px) {
	#$block_id .qo-lightbox__body {
		max-width: {$box['mobile']['container']['width']};
		max-height: {$box['mobile']['container']['height']};
	}
}
#$block_id .qo-lightbox__search-icon {
	fill: {$search_bar['color']['text']};
}

#$block_id .qb__ajax-loader {
	min-width: {$ajax_loader['desktop']['width']};
	{$ajax_loader['desktop']['padding']};
	margin-top: {$ajax_loader['margin']['top']};
	margin-bottom: {$ajax_loader['margin']['bottom']};
	{$ajax_loader['border']}
	border-radius: {$ajax_loader['radius']};
	font-size: {$ajax_loader['desktop']['font']['size']};
	font-family: {$ajax_loader['typography']['font']['family']};
	text-decoration: {$attributes['ajaxLoader']['typography']['decoration']};
	text-transform: {$attributes['ajaxLoader']['typography']['letterCase']};
	line-height: {$ajax_loader['typography']['line_height']};
	letter-spacing: {$ajax_loader['typography']['letter_spacing']};
	background-color: {$ajax_loader['color']['bg']};
	color: {$ajax_loader['color']['text']};
}
#$block_id .qb__ajax-loader .ajax-loader__spinner {
	border-color: {$ajax_loader['color']['spinner_secondary']};
	border-top-color: {$ajax_loader['color']['spinner_primary']};
}

@media only screen and (min-width:768px) and (max-width:1024px) {
	#$block_id .qb__ajax-loader {
		min-width: {$ajax_loader['tablet']['width']};
		{$ajax_loader['tablet']['padding']}
		font-size: {$ajax_loader['tablet']['font']['size']};
	}
}

@media only screen and (max-width:767px) {
	#$block_id .qb__ajax-loader {
		min-width: {$ajax_loader['mobile']['width']};
		{$ajax_loader['mobile']['padding']}
		font-size: {$ajax_loader['mobile']['font']['size']};
	}
}
#$block_id .qb__ajax-loader:hover {
	background-color: {$ajax_loader['color']['bg_hover']};
	color: {$ajax_loader['color']['text_hover']};
	border-color: {$ajax_loader['color']['border_hover']};
}
";

if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	if ( isset( $_POST, $_POST['quiqowl_search_query'] ) ) {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'quiqowl_product_search' ) ) {
			wp_die( 'Access denied!' );
		}

		$search_query = esc_html( sanitize_text_field( wp_unslash( $_POST['quiqowl_search_query'], true ) ) );

		// Prepare arguments for WP_Query.
		$args = array(
			'limit'  => 10, // Get all products.
			'status' => 'publish',
		);

		if ( ! empty( $search_query ) ) {
			$args['s'] = $search_query;
		}

		// Create a new query.
		$products = wc_get_products( $args );

		if ( empty( $search_query ) || ( is_array( $products ) && 1 !== count( $products ) ) ) {
			$home_url = home_url( '/?s=' . rawurlencode( $search_query ) . '&post_type=product' );

			wp_safe_redirect( esc_url_raw( $home_url ) );
			exit;
		}

		$product = $products[0];

		$home_url = home_url( '/?product=' . rawurlencode( $product->get_name() ) );

		wp_safe_redirect( esc_url( $home_url ) );
		exit;
	}
}

$attributes['ajaxUrl']            = admin_url( 'admin-ajax.php' );
$attributes['nonce']              = wp_create_nonce( 'quiqowl_product_search' );
$attributes['cartNonce']          = wp_create_nonce( 'quiqowl__add_to_cart' );
$attributes['lightboxNonce']      = wp_create_nonce( 'quiqowl__lightbox' );
$attributes['ajaxLoaderNonce']    = wp_create_nonce( 'quiqowl__ajax_loader' );
$attributes['wooCurrency']        = get_woocommerce_currency_symbol();
$attributes['productLinkHandler'] = wp_create_nonce( 'quiqowl__product_data' );

wp_localize_script( 'quiqowl--product-search--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'quiqowl--product-search--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.quiqOwlProductSearch( "' . esc_attr( $client_id ) . '" ) }) ' );

if ( ! function_exists( 'quiqowl_block_product_search_google_fonts' ) ) {
	/**
	 * Enqueues Google Fonts for the Quiqowl Block Product Search.
	 *
	 * This function dynamically generates a Google Fonts URL based on the typography settings
	 * specified in the block attributes and enqueues the corresponding stylesheet. It ensures
	 * that only unique font families are included and adds a default font family (Public Sans) if none
	 * are explicitly provided.
	 *
	 * @param array $attributes The block attributes containing typography settings.
	 *                          Expected structure:
	 *                          - 'categoryFilter' => [ 'typography' => [ 'font' => [ 'family' => string ] ] ]
	 *                          - 'searchBar'      => [ 'typography' => [ 'font' => [ 'family' => string ] ] ]
	 *                          - 'productBox'     => [ 'item' => [ 'typography' => [ 'font' => [ 'family' => string ] ] ] ]
	 *                          - 'saleBadge'      => [ 'typography' => [ 'font' => [ 'family' => string ] ] ]
	 *                          - 'productTitle'   => [ 'typography' => [ 'font' => [ 'family' => string ] ] ]
	 *                          - 'productPrice'   => [ 'typography' => [ 'font' => [ 'family' => string ] ] ]
	 *
	 * @return void
	 *
	 * @uses wp_enqueue_style() Enqueues the dynamically generated Google Fonts stylesheet.
	 * @uses array_unique() Ensures no duplicate font families are added to the request.
	 * @uses urlencode() Encodes font family names to make them URL-safe.
	 */
	function quiqowl_block_product_search_google_fonts( $attributes ) {
		$font_families = array();

		// Collect unique font families.
		if ( isset( $attributes['categoryFilter']['typography']['font']['family'] ) && ! empty( $attributes['categoryFilter']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['categoryFilter']['typography']['font']['family'];
		}
		if ( isset( $attributes['searchBar']['typography']['font']['family'] ) && ! empty( $attributes['searchBar']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['searchBar']['typography']['font']['family'];
		}
		if ( isset( $attributes['productBox']['item']['typography']['font']['family'] ) && ! empty( $attributes['productBox']['item']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['productBox']['item']['typography']['font']['family'];
		}
		if ( isset( $attributes['saleBadge']['typography']['font']['family'] ) && ! empty( $attributes['saleBadge']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['saleBadge']['typography']['font']['family'];
		}
		if ( isset( $attributes['productTitle']['typography']['font']['family'] ) && ! empty( $attributes['productTitle']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['productTitle']['typography']['font']['family'];
		}
		if ( isset( $attributes['productPrice']['typography']['font']['family'] ) && ! empty( $attributes['productPrice']['typography']['font']['family'] ) ) {
			$font_families[] = $attributes['productPrice']['typography']['font']['family'];
		}

		// Remove duplicate font families.
		$font_families = array_unique( $font_families );

		// Base Google Fonts URL.
		$font_query = 'family=Public+Sans:wght@100;200;300;400;500;600;700;800;900';

		// Add other fonts.
		foreach ( $font_families as $family ) {
			$font_query .= '&family=' . urlencode( $family ) . ':wght@100;200;300;400;500;600;700;800;900';
		}

		// Generate the inline style for the Google Fonts link.
		$google_fonts_url = 'https://fonts.googleapis.com/css2?' . $font_query;

		// Add the Google Fonts URL as an inline style.
		wp_add_inline_style( 'quiqowl--product-search--style', '@import url("' . esc_url( $google_fonts_url ) . '");' );
	}
}

$wrapper_attributes = get_block_wrapper_attributes();

$classes   = array();
$classes[] = 'quiqowl-block__wrapper';
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" data-block-id="<?php echo esc_attr( $block_id ); ?>">
	<div <?php echo $wrapper_attributes; ?>>
		<?php
		add_action(
			'wp_enqueue_scripts',
			function () use ( $block_styles, $attributes ) {
				quiqowl_block_product_search_google_fonts( $attributes );

				wp_add_inline_style( 'quiqowl--product-search--style', esc_html( $block_styles ) );
			}
		);

		// add_action( 'wp_enqueue_scripts', 'quiqowl_block_product_search_google_fonts' );


		$classes   = array();
		$classes[] = 'quiqowl-block__product-search';
		$classes[] = 'layout-' . $attributes['layout'];
		?>

		<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" id="<?php echo esc_attr( $block_id ); ?>">
			<?php
			if ( 'default' === $attributes['layout'] ) {
				if ( $attributes['categoryFilter']['enabled'] ) {
					echo '<div class="category-search__wrapper" style="display:flex;gap:12px;">';
					$args = array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => true,
						// 'number'     => $request->get_param( 'per_page' ) ?? 10,
						'order'      => 'DESC',
						'orderby'    => 'count',
					);

					$categories = get_terms( $args );

					if ( $attributes['categoryFilter']['enabled'] && ! empty( $categories ) ) {
						$classes   = array();
						$classes[] = 'category__dropdown';
						$classes[] = isset( $attributes['categoryFilter']['shadow']['enabled'] ) && $attributes['categoryFilter']['shadow']['enabled'] ? 'has-box-shadow' : '';
						?>
						<!-- Default Layout -->

						<div class="category__filter">
							<select class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" name="quiqowl_product_category">
								<option value="" selected>
									<?php
									echo esc_html( $category_filter['label'] )
									?>
								</option>
								<?php
								foreach ( $categories as $product_cat ) {
									?>
									<option class="product-category__item" value="<?php echo esc_html( $product_cat->slug ); ?>"><?php echo esc_html( $product_cat->name ); ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<?php
					}
				}
				?>
				<form role="search" method="POST" action="">
					<?php
					$classes   = array();
					$classes[] = 'search-bar__wrapper';
					$classes[] = $attributes['searchButton']['enabled'] && 'outside' === $attributes['searchButton']['variation'] && $attributes['searchBar']['showOnClick'] ? 'show-on-click' : '';
					?>
					<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
						<?php
						$classes   = array();
						$classes[] = 'search-bar';
						$classes[] = $attributes['searchButton']['enabled'] && 'outside' === $attributes['searchButton']['variation'] && $attributes['searchBar']['showOnClick'] ? 'width-none' : '';
						?>
						<input class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" name="quiqowl_search_query" type="text" placeholder="<?php echo esc_html( $search_bar['label'] ); ?>" autocomplete="off" />

						<?php
						if ( $attributes['searchButton']['enabled'] ) {
							$classes   = array();
							$classes[] = 'search-icon__wrapper';
							$classes[] = 'variation-' . $attributes['searchButton']['variation'];
							$classes[] = 'position-' . $attributes['searchButton']['position'];
							?>
							<button type="submit" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
								<svg
									class="search-icon"
									width="16"
									height="16"
									viewBox="0 0 16 16"
									xmlns="http://www.w3.org/2000/svg"
									aria-hidden="true">
									<path d="M12.0206 11.078L14.876 13.9327L13.9326 14.876L11.078 12.0207C10.0158 12.8722 8.69465 13.3353 7.33331 13.3333C4.02131 13.3333 1.33331 10.6453 1.33331 7.33334C1.33331 4.02134 4.02131 1.33334 7.33331 1.33334C10.6453 1.33334 13.3333 4.02134 13.3333 7.33334C13.3352 8.69468 12.8721 10.0158 12.0206 11.078ZM10.6833 10.5833C11.5292 9.71315 12.0017 8.54692 12 7.33334C12 4.75534 9.91131 2.66668 7.33331 2.66668C4.75531 2.66668 2.66665 4.75534 2.66665 7.33334C2.66665 9.91134 4.75531 12 7.33331 12C8.54689 12.0017 9.71312 11.5292 10.5833 10.6833L10.6833 10.5833Z" />
								</svg>
							</button>
							<?php
						}
						?>

					</div>

					<?php wp_nonce_field( 'quiqowl_product_search' ); ?>

					<!-- Close Modal in responsive view -->
					<div id="back__arr">
						<svg width="16" height="16" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.9449 9.66003C11.3049 10.02 11.3049 10.58 10.9449 10.94C10.7649 11.12 10.5449 11.2 10.3049 11.2C10.0649 11.2 9.84493 11.12 9.66493 10.94L6.00492 7.28004L2.34491 10.94C2.16491 11.12 1.94492 11.2 1.70492 11.2C1.46492 11.2 1.24493 11.12 1.06493 10.94C0.704932 10.58 0.704932 10.02 1.06493 9.66003L4.72492 6.00004L1.06493 2.34004C0.704932 1.98004 0.704932 1.42004 1.06493 1.06004C1.42493 0.700037 1.98491 0.700037 2.34491 1.06004L6.00492 4.72003L9.66493 1.06004C10.0249 0.700037 10.5849 0.700037 10.9449 1.06004C11.3049 1.42004 11.3049 1.98004 10.9449 2.34004L7.2849 6.00004L10.9449 9.66003Z" />
						</svg>
					</div>
				</form>


				<?php
				if ( $attributes['categoryFilter']['enabled'] ) {
					echo '</div>';
				}

				$classes   = array();
				$classes[] = 'quiqowl-block__search-modal';
				$classes[] = 'display-none';
				$classes[] = $attributes['productBox']['container']['shadow']['enabled'] ? 'has-box-shadow' : '';
				?>

				<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
					<?php
					if ( quiqowl_premium_access() && ( $attributes['priceFilter']['enabled'] || $attributes['tagFilter']['enabled'] || $attributes['ratingFilter']['enabled'] || $attributes['attrFilter']['enabled'] ) ) {
						?>
						<div class="search__filters">

							<?php
							if ( quiqowl_premium_access() && $attributes['priceFilter']['enabled'] ) {
								?>
								<div class="price__filter">
									<h6 style="margin-bottom:10px;"><?php esc_html_e( 'Filter by Price', 'quiqowl' ); ?></h6>

									<div class="filter__range" aria-hidden="false">
										<div class="quiqowl__range-progress"></div>
										<!-- Min Range Input -->
										<input id="quiqowl__min-range" class="quiqowl__price-range" name="quiqowl_min_price" type="range"
											value="<?php echo esc_attr( $price_filter['start'] ); ?>"
											min="<?php echo esc_attr( $price_filter['start'] ); ?>"
											max="<?php echo esc_attr( $price_filter['end'] ); ?>" step="1" />

										<!-- Max Range Input -->
										<input id="quiqowl__max-range" class="quiqowl__price-range" name="quiqowl_max_price" type="range"
											value="<?php echo esc_attr( $price_filter['end'] ); ?>"
											min="<?php echo esc_attr( $price_filter['start'] ); ?>"
											max="<?php echo esc_attr( $price_filter['end'] ); ?>" step="1" />
									</div>

									<div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center;">
										<span id="quiqowl__min-price"><?php echo wc_price( esc_html( $price_filter['start'] ), array( 'decimals' => 0 ) ); ?></span>
										<span id="quiqowl__max-price"><?php echo wc_price( esc_html( $price_filter['end'] ), array( 'decimals' => 0 ) ); ?></span>
									</div>
								</div>
								<?php
							}
							?>

							<?php
							$args = array(
								'taxonomy'   => 'product_tag', // Use 'product_tag'.
								'hide_empty' => true,          // Only show tags with products assigned to them.
								'order'      => 'DESC',
								'orderby'    => 'count',
							);

							$tags = get_terms( $args );

							if ( quiqowl_premium_access() && $attributes['tagFilter']['enabled'] && ! empty( $tags ) ) {
								?>
								<div class="tags__filter">
									<h6 style="margin-bottom:6px;"><?php esc_html_e( 'Filter by Tags', 'quiqowl' ); ?></h6>
									<ul class="product__tags">

										<?php
										foreach ( $tags as $product_tag ) {
											?>
											<li class="product-tag__item" id="<?php echo esc_attr( $product_tag->term_id ); ?>"><label><input type="checkbox" name="product_tags[]" value="<?php echo esc_attr( $product_tag->slug ); ?>" /><?php echo esc_html( $product_tag->name ); ?></label></li>
											<?php
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>

							<?php
							if ( quiqowl_premium_access() && $attributes['ratingFilter']['enabled'] ) {
								?>
								<div class="rating__filter">
									<h6 style="margin-bottom:6px;">
										<?php esc_html_e( 'Filter by Rating', 'quiqowl' ); ?>
										<span class="reset__icon">
											<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.6667 8.00001C14.6667 11.682 11.682 14.6667 8.00004 14.6667C4.31804 14.6667 1.33337 11.682 1.33337 8.00001C1.33337 4.31801 4.31804 1.33334 8.00004 1.33334V2.66668C6.74588 2.66678 5.53187 3.10885 4.57132 3.91523C3.61076 4.72161 2.96511 5.84071 2.7478 7.07589C2.53049 8.31108 2.75542 9.58334 3.38308 10.6691C4.01074 11.7549 5.00097 12.5848 6.17979 13.013C7.35861 13.4411 8.6506 13.4401 9.82876 13.0102C11.0069 12.5802 11.9959 11.7489 12.6219 10.6621C13.2479 9.57535 13.4709 8.30275 13.2517 7.06789C13.0325 5.83304 12.3852 4.71493 11.4234 3.91001L10 5.33334V1.33334H14L12.3687 2.96468C13.0907 3.58987 13.6696 4.36318 14.0662 5.23204C14.4627 6.1009 14.6675 7.04494 14.6667 8.00001Z" />
											</svg>
										</span>
									</h6>
									<ul>
										<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 5 ? ' selected' : ''; ?>" data-rating="5">
											<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 100%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 100%);">★★★★★</div>
										</li>
										<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 4 ? ' selected' : ''; ?>" data-rating="4">
											<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 80%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 80%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
										</li>
										<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 3 ? ' selected' : ''; ?>" data-rating="3">
											<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 60%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 60%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
										</li>
										<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 2 ? ' selected' : ''; ?>" data-rating="2">
											<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 40%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 40%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
										</li>
										<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 1 ? ' selected' : ''; ?>" data-rating="1">
											<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 20%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 20%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
										</li>
									</ul>

								</div>
								<?php
							}
							?>

							<?php
							if ( quiqowl_premium_access() && $attributes['attrFilter']['enabled'] && ! empty( $attributes['attrFilter']['collection'] ) && is_array( $attributes['attrFilter']['collection'] ) ) {
								?>
								<div class="attribute__filters">
									<ul>
										<?php
										foreach ( $attributes['attrFilter']['collection'] as $attr ) {
											$terms = get_terms(
												array(
													'taxonomy' => 'pa_' . $attr['attribute_name'],
													'hide_empty' => true,
												)
											);

											if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
												?>
												<li id="<?php echo esc_html( $attr['attribute_name'] ); ?>" class="attribute-filter__item">
													<h6>
														<?php
														esc_html_e( 'Filter By ', 'quiqowl' );
														echo esc_html( $attr['attribute_label'] );
														?>
														<span id="<?php echo esc_html( $attr['attribute_name'] ); ?>" class="reset__icon quiqowl__visibility-hidden">
															<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
																<path d="M14.6667 8.00001C14.6667 11.682 11.682 14.6667 8.00004 14.6667C4.31804 14.6667 1.33337 11.682 1.33337 8.00001C1.33337 4.31801 4.31804 1.33334 8.00004 1.33334V2.66668C6.74588 2.66678 5.53187 3.10885 4.57132 3.91523C3.61076 4.72161 2.96511 5.84071 2.7478 7.07589C2.53049 8.31108 2.75542 9.58334 3.38308 10.6691C4.01074 11.7549 5.00097 12.5848 6.17979 13.013C7.35861 13.4411 8.6506 13.4401 9.82876 13.0102C11.0069 12.5802 11.9959 11.7489 12.6219 10.6621C13.2479 9.57535 13.4709 8.30275 13.2517 7.06789C13.0325 5.83304 12.3852 4.71493 11.4234 3.91001L10 5.33334V1.33334H14L12.3687 2.96468C13.0907 3.58987 13.6696 4.36318 14.0662 5.23204C14.4627 6.1009 14.6675 7.04494 14.6667 8.00001Z" />
															</svg>
														</span>
													</h6>

													<?php
													foreach ( $terms as $pa_term ) {
														?>
														<label>
															<input class="<?php echo esc_html( $attr['attribute_name'] ); ?>" type="checkbox" name="<?php echo 'selected_' . esc_attr( $attr['attribute_name'] ) . '[]'; ?>" value="<?php echo esc_attr( $pa_term->slug ); ?>" />
															<?php echo esc_html( $pa_term->name ); ?>
														</label>
														<br />
														<?php
													}
													?>
													<br />
												</li>
												<?php
											}
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>

						</div>
						<?php
					}
					?>
					<div id="search-results__wrapper">
						<div class="spinner display-none"></div>
						<h4 class="display-none" id="search-results__label"></h4>
						<div id="search-results">
						</div>

						<?php
						if ( quiqowl_premium_access() && $attributes['ajaxLoader']['enabled'] ) :
							$classes   = array();
							$classes[] = 'qb__ajax-loader';
							$classes[] = 'variation-' . $attributes['ajaxLoader']['variation'];
							?>
							<div class="qb__ajax-loader-wrapper display-none">
								<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
									<?php
									if ( 'default' === $attributes['ajaxLoader']['variation'] ) :
										?>
										<span class="ajax-loader__label"><?php echo esc_html( $ajax_loader['label'] ); ?></span>
										<?php
									endif;
									?>

									<div class="ajax-loader__container display-none">
										<?php
										if ( ! empty( $ajax_loader['loading_text'] ) ) {
											?>
											<div class="ajax-loader__loading-wrapper">
												<span class="ajax-loader__loading-text"><?php echo esc_html( $ajax_loader['loading_text'] ); ?></span>
												<span class="ajax-loader__dots"></span>
											</div>
											<?php
										} else {
											?>
											<div class="ajax-loader__spinner display__inline-block"></div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						endif;
						?>
					</div>
				</div>
				<!-- End Default Layout -->
			<?php } ?>

			<?php
			if ( 'full' === $attributes['layout'] ) {
				$classes   = array();
				$classes[] = 'search-icon__wrapper';
				?>
				<!-- Full Layout -->
				<button class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
					<svg
						class="search-icon"
						width="16"
						height="16"
						viewBox="0 0 16 16"
						xmlns="http://www.w3.org/2000/svg"
						aria-hidden="true">
						<path d="M12.0206 11.078L14.876 13.9327L13.9326 14.876L11.078 12.0207C10.0158 12.8722 8.69465 13.3353 7.33331 13.3333C4.02131 13.3333 1.33331 10.6453 1.33331 7.33334C1.33331 4.02134 4.02131 1.33334 7.33331 1.33334C10.6453 1.33334 13.3333 4.02134 13.3333 7.33334C13.3352 8.69468 12.8721 10.0158 12.0206 11.078ZM10.6833 10.5833C11.5292 9.71315 12.0017 8.54692 12 7.33334C12 4.75534 9.91131 2.66668 7.33331 2.66668C4.75531 2.66668 2.66665 4.75534 2.66665 7.33334C2.66665 9.91134 4.75531 12 7.33331 12C8.54689 12.0017 9.71312 11.5292 10.5833 10.6833L10.6833 10.5833Z" />
					</svg>
				</button>

				<div class="qo__lightbox display-none">
					<div class="qo-lightbox__close-icon-wrapper">
						<svg width="26" height="26" viewBox="0 0 16 16" fill="#fff" xmlns="http://www.w3.org/2000/svg">
							<path d="M7.99999 7.058L11.3 3.758L12.2427 4.70067L8.94266 8.00067L12.2427 11.3007L11.2993 12.2433L7.99932 8.94334L4.69999 12.2433L3.75732 11.3L7.05732 8L3.75732 4.7L4.69999 3.75867L7.99999 7.058Z" />
						</svg>
					</div>

					<?php
					$classes   = array();
					$classes[] = 'qo-lightbox__body';
					$classes[] = $attributes['productBox']['container']['shadow']['enabled'] ? 'has-box-shadow' : '';
					?>
					<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
						<div class="qo-lightbox__header">
							<?php
							if ( $attributes['categoryFilter']['enabled'] ) {
								$args = array(
									'taxonomy'   => 'product_cat',
									'hide_empty' => true,
									// 'number'     => $request->get_param( 'per_page' ) ?? 10,
									'order'      => 'DESC',
									'orderby'    => 'count',
								);

								$categories = get_terms( $args );

								if ( $attributes['categoryFilter']['enabled'] && ! empty( $categories ) ) {
									$classes   = array();
									$classes[] = 'category__dropdown';
									$classes[] = isset( $attributes['categoryFilter']['shadow']['enabled'] ) && $attributes['categoryFilter']['shadow']['enabled'] ? 'has-box-shadow' : '';
									?>
									<div class="category__filter">
										<select class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" name="quiqowl_product_category">
											<option value="" selected><?php echo esc_html( $category_filter['label'] ); ?></option>
											<?php
											foreach ( $categories as $product_cat ) {
												?>
												<option class="product-category__item" value="<?php echo esc_attr( $product_cat->slug ); ?>"><?php echo esc_html( $product_cat->name ); ?></option>
												<?php
											}
											?>
										</select>
									</div>
									<?php
								}
							}
							?>
							<form role="search" method="POST" action="">
								<?php
								$classes   = array();
								$classes[] = 'search-bar__wrapper';
								?>
								<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" style="display:flex;align-items:center;gap:4px;">
									<svg
										width="16"
										height="16"
										class="qo-lightbox__search-icon"
										viewBox="0 0 16 16"
										xmlns="http://www.w3.org/2000/svg"
										aria-hidden="true">
										<path d="M12.0206 11.078L14.876 13.9327L13.9326 14.876L11.078 12.0207C10.0158 12.8722 8.69465 13.3353 7.33331 13.3333C4.02131 13.3333 1.33331 10.6453 1.33331 7.33334C1.33331 4.02134 4.02131 1.33334 7.33331 1.33334C10.6453 1.33334 13.3333 4.02134 13.3333 7.33334C13.3352 8.69468 12.8721 10.0158 12.0206 11.078ZM10.6833 10.5833C11.5292 9.71315 12.0017 8.54692 12 7.33334C12 4.75534 9.91131 2.66668 7.33331 2.66668C4.75531 2.66668 2.66665 4.75534 2.66665 7.33334C2.66665 9.91134 4.75531 12 7.33331 12C8.54689 12.0017 9.71312 11.5292 10.5833 10.6833L10.6833 10.5833Z" />
									</svg>
									<input list="search_values" class="search-bar" name="quiqowl_search_query" type="text" placeholder="<?php echo esc_html( $search_bar['label'] ); ?>" autocomplete="off" />
								</div>

								<?php wp_nonce_field( 'quiqowl_product_search' ); ?>
							</form>
						</div>

						<div style="display:flex;flex-wrap:wrap;padding:8px 26px 0;">
							<?php
							if ( quiqowl_premium_access() && ( $attributes['priceFilter']['enabled'] || $attributes['tagFilter']['enabled'] || $attributes['ratingFilter']['enabled'] || $attributes['attrFilter']['enabled'] ) ) {
								?>
								<div class="search__filters">

									<?php
									if ( quiqowl_premium_access() && $attributes['priceFilter']['enabled'] ) {
										?>
										<div class="price__filter">
											<h6 style="margin-bottom:10px;"><?php esc_html_e( 'Filter by Price', 'quiqowl' ); ?></h6>

											<div class="filter__range" aria-hidden="false">
												<div class="quiqowl__range-progress"></div>
												<!-- Min Range Input -->
												<input id="quiqowl__min-range" class="quiqowl__price-range" name="quiqowl_min_price" type="range"
													value="<?php echo esc_attr( $price_filter['start'] ); ?>"
													min="<?php echo esc_attr( $price_filter['start'] ); ?>"
													max="<?php echo esc_attr( $price_filter['end'] ); ?>" step="1" />

												<!-- Max Range Input -->
												<input id="quiqowl__max-range" class="quiqowl__price-range" name="quiqowl_max_price" type="range"
													value="<?php echo esc_attr( $price_filter['end'] ); ?>"
													min="<?php echo esc_attr( $price_filter['start'] ); ?>"
													max="<?php echo esc_attr( $price_filter['end'] ); ?>" step="1" />
											</div>

											<div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center;">
												<span id="quiqowl__min-price"><?php echo wc_price( esc_html( $price_filter['start'] ), array( 'decimals' => 0 ) ); ?></span>
												<span id="quiqowl__max-price"><?php echo wc_price( esc_html( $price_filter['end'] ), array( 'decimals' => 0 ) ); ?></span>
											</div>
										</div>
										<?php
									}
									?>

									<?php
									$args = array(
										'taxonomy'   => 'product_tag', // Use 'product_tag'.
										'hide_empty' => true,          // Only show tags with products assigned to them.
										'order'      => 'DESC',
										'orderby'    => 'count',
									);

									$tags = get_terms( $args );

									if ( quiqowl_premium_access() && $attributes['tagFilter']['enabled'] && ! empty( $tags ) ) {
										?>
										<div class="tags__filter">
											<h6 style="margin-bottom:6px;"><?php esc_html_e( 'Filter by Tags', 'quiqowl' ); ?></h6>
											<ul class="product__tags">

												<?php
												foreach ( $tags as $product_tag ) {
													?>
													<li class="product-tag__item" id="<?php echo esc_attr( $product_tag->term_id ); ?>"><label><input type="checkbox" name="product_tags[]" value="<?php echo esc_attr( $product_tag->slug ); ?>" /><?php echo esc_html( $product_tag->name ); ?></label></li>
													<?php
												}
												?>
											</ul>
										</div>
										<?php
									}
									?>

									<?php
									if ( quiqowl_premium_access() && $attributes['ratingFilter']['enabled'] ) {
										?>
										<div class="rating__filter">
											<h6 style="margin-bottom:6px;">
												<?php esc_html_e( 'Filter by Rating', 'quiqowl' ); ?>
												<span class="reset__icon">
													<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
														<path d="M14.6667 8.00001C14.6667 11.682 11.682 14.6667 8.00004 14.6667C4.31804 14.6667 1.33337 11.682 1.33337 8.00001C1.33337 4.31801 4.31804 1.33334 8.00004 1.33334V2.66668C6.74588 2.66678 5.53187 3.10885 4.57132 3.91523C3.61076 4.72161 2.96511 5.84071 2.7478 7.07589C2.53049 8.31108 2.75542 9.58334 3.38308 10.6691C4.01074 11.7549 5.00097 12.5848 6.17979 13.013C7.35861 13.4411 8.6506 13.4401 9.82876 13.0102C11.0069 12.5802 11.9959 11.7489 12.6219 10.6621C13.2479 9.57535 13.4709 8.30275 13.2517 7.06789C13.0325 5.83304 12.3852 4.71493 11.4234 3.91001L10 5.33334V1.33334H14L12.3687 2.96468C13.0907 3.58987 13.6696 4.36318 14.0662 5.23204C14.4627 6.1009 14.6675 7.04494 14.6667 8.00001Z" />
													</svg>
												</span>
											</h6>
											<ul>
												<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 5 ? ' selected' : ''; ?>" data-rating="5">
													<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 100%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 100%);">★★★★★</div>
												</li>
												<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 4 ? ' selected' : ''; ?>" data-rating="4">
													<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 80%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 80%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
												</li>
												<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 3 ? ' selected' : ''; ?>" data-rating="3">
													<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 60%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 60%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
												</li>
												<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 2 ? ' selected' : ''; ?>" data-rating="2">
													<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 40%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 40%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
												</li>
												<li class="rating__filter-option<?php echo intval( $attributes['ratingFilter']['minRating'] ) === 1 ? ' selected' : ''; ?>" data-rating="1">
													<div class="star" style="display:inline;background:linear-gradient(90deg, <?php echo esc_html( $util_icon['color']['star_primary'] ); ?> 20%, <?php echo esc_html( $util_icon['color']['star_secondary'] ); ?> 20%);">★★★★★</div> & <?php esc_html_e( 'Above', 'quiqowl' ); ?>
												</li>
											</ul>

										</div>
										<?php
									}
									?>

									<?php
									if ( quiqowl_premium_access() && $attributes['attrFilter']['enabled'] && ! empty( $attributes['attrFilter']['collection'] ) && is_array( $attributes['attrFilter']['collection'] ) ) {
										?>
										<div class="attribute__filters">
											<ul>
												<?php
												foreach ( $attributes['attrFilter']['collection'] as $attr ) {
													$terms = get_terms(
														array(
															'taxonomy' => 'pa_' . $attr['attribute_name'],
															'hide_empty' => true,
														)
													);

													if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
														?>
														<li id="<?php echo esc_html( $attr['attribute_name'] ); ?>" class="attribute-filter__item">
															<h6>
																<?php
																esc_html_e( 'Filter By ', 'quiqowl' );
																echo esc_html( $attr['attribute_label'] );
																?>
																<span id="<?php echo esc_html( $attr['attribute_name'] ); ?>" class="reset__icon quiqowl__visibility-hidden">
																	<svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
																		<path d="M14.6667 8.00001C14.6667 11.682 11.682 14.6667 8.00004 14.6667C4.31804 14.6667 1.33337 11.682 1.33337 8.00001C1.33337 4.31801 4.31804 1.33334 8.00004 1.33334V2.66668C6.74588 2.66678 5.53187 3.10885 4.57132 3.91523C3.61076 4.72161 2.96511 5.84071 2.7478 7.07589C2.53049 8.31108 2.75542 9.58334 3.38308 10.6691C4.01074 11.7549 5.00097 12.5848 6.17979 13.013C7.35861 13.4411 8.6506 13.4401 9.82876 13.0102C11.0069 12.5802 11.9959 11.7489 12.6219 10.6621C13.2479 9.57535 13.4709 8.30275 13.2517 7.06789C13.0325 5.83304 12.3852 4.71493 11.4234 3.91001L10 5.33334V1.33334H14L12.3687 2.96468C13.0907 3.58987 13.6696 4.36318 14.0662 5.23204C14.4627 6.1009 14.6675 7.04494 14.6667 8.00001Z" />
																	</svg>
																</span>
															</h6>

															<?php
															foreach ( $terms as $pa_term ) {
																?>
																<label>
																	<input class="<?php echo esc_html( $attr['attribute_name'] ); ?>" type="checkbox" name="<?php echo 'selected_' . esc_attr( $attr['attribute_name'] ) . '[]'; ?>" value="<?php echo esc_attr( $pa_term->slug ); ?>" />
																	<?php echo esc_html( $pa_term->name ); ?>
																</label>
																<br />
																<?php
															}
															?>
															<br />
														</li>
														<?php
													}
												}
												?>
											</ul>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}

							$classes   = array();
							$classes[] = $attributes['productBox']['container']['shadow']['enabled'] ? 'has-box-shadow' : '';
							?>

							<div id="search-results__wrapper" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>" style="position:relative;">
								<div class="spinner display-none"></div>
								<h4 class="display-none" id="search-results__label"></h4>
								<div id="search-results">
								</div>

								<?php
								if ( quiqowl_premium_access() && $attributes['ajaxLoader']['enabled'] ) :
									$classes   = array();
									$classes[] = 'qb__ajax-loader';
									$classes[] = 'variation-' . $attributes['ajaxLoader']['variation'];
									?>
									<div class="qb__ajax-loader-wrapper display-none">
										<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_filter( $classes ) ) ) ); ?>">
											<?php
											if ( 'default' === $attributes['ajaxLoader']['variation'] ) :
												?>
												<span class="ajax-loader__label"><?php echo esc_html( $ajax_loader['label'] ); ?></span>
												<?php
											endif;
											?>

											<div class="ajax-loader__container display-none">
												<?php
												if ( ! empty( $ajax_loader['loading_text'] ) ) {
													?>
													<div class="ajax-loader__loading-wrapper">
														<span class="ajax-loader__loading-text"><?php echo esc_html( $ajax_loader['loading_text'] ); ?></span>
														<span class="ajax-loader__dots"></span>
													</div>
													<?php
												} else {
													?>
													<div class="ajax-loader__spinner display__inline-block"></div>
													<?php
												}
												?>
											</div>
										</div>
									</div>
									<?php
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End Full Layout -->
			<?php } ?>
		</div>
	</div>
</div>

<?php
