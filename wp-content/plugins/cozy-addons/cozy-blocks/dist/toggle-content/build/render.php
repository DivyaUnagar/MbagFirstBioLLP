<?php
$client_id = isset( $attributes['clientId'] ) ? str_replace( '-', '_', sanitize_key( wp_unslash( $attributes['clientId'] ) ) ) : '';

$block_id = 'cozyBlock_' . $client_id;

wp_localize_script( 'cozy-block--toggle-content--frontend-script', $block_id, $attributes );
wp_add_inline_script( 'cozy-block--toggle-content--frontend-script', 'document.addEventListener("DOMContentLoaded", function(event) { window.cozyBlockToggleContent( "' . esc_html( $block_id ) . '" ) }) ' );

$styles = array(
	'padding' => isset( $attributes['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['padding'] ) : '',
	'margin'  => array(
		'top'    => isset( $attributes['margin']['top'] ) ? $attributes['margin']['top'] : '',
		'bottom' => isset( $attributes['margin']['bottom'] ) ? $attributes['margin']['bottom'] : '',
	),
	'border'  => isset( $attributes['border'] ) ? cozy_render_TRBL( 'border', $attributes['border'] ) : '',
	'radius'  => isset( $attributes['radius'] ) ? cozy_render_TRBL( 'border-radius', $attributes['radius'] ) : '',
	'shadow'  => array(
		'horizontal' => isset( $attributes['shadow']['horizontal'] ) ? $attributes['shadow']['horizontal'] : '',
		'vertical'   => isset( $attributes['shadow']['vertical'] ) ? $attributes['shadow']['vertical'] : '',
		'blur'       => isset( $attributes['shadow']['blur'] ) ? $attributes['shadow']['blur'] : '',
		'spread'     => isset( $attributes['shadow']['spread'] ) ? $attributes['shadow']['spread'] : '',
		'color'      => isset( $attributes['shadow']['color'] ) ? $attributes['shadow']['color'] : '',
		'position'   => isset( $attributes['shadow']['position'] ) ? $attributes['shadow']['position'] : '',
	),
	'color'   => array(
		'text' => isset( $attributes['color']['text'] ) ? $attributes['color']['text'] : '',
		'bg'   => isset( $attributes['color']['bg'] ) ? $attributes['color']['bg'] : '',
	),
	'font'    => array(
		'size'   => isset( $attributes['font']['size'] ) ? $attributes['font']['size'] : '',
		'family' => isset( $attributes['font']['family'] ) ? $attributes['font']['family'] : '',
	),
);

$wrapper_styles = array(
	'content_gap' => isset( $attributes['wrapperStyles']['contentGap'] ) ? $attributes['wrapperStyles']['contentGap'] : '',
	'padding'     => isset( $attributes['wrapperStyles']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['wrapperStyles']['padding'] ) : '',
	'margin'      => array(
		'top'    => isset( $attributes['wrapperStyles']['margin']['top'] ) ? $attributes['wrapperStyles']['margin']['top'] : '',
		'bottom' => isset( $attributes['wrapperStyles']['margin']['bottom'] ) ? $attributes['wrapperStyles']['margin']['bottom'] : '',
	),
	'border'      => isset( $attributes['wrapperStyles']['border'] ) ? cozy_render_TRBL( 'border', $attributes['wrapperStyles']['border'] ) : '',
	'radius'      => isset( $attributes['wrapperStyles']['radius'] ) ? cozy_render_TRBL( 'radius', $attributes['wrapperStyles']['radius'] ) : '',
	'color'       => array(
		'bg' => isset( $attributes['wrapperStyles']['color']['bg'] ) ? $attributes['wrapperStyles']['color']['bg'] : '',
	),
);

$tab_styles = array(
	'default'        => array(
		'padding' => isset( $attributes['tabStyles']['default']['padding'] ) ? cozy_render_TRBL( 'padding', $attributes['tabStyles']['default']['padding'] ) : '',
		'border'  => isset( $attributes['tabStyles']['default']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['default']['border'] ) : '',
		'radius'  => isset( $attributes['tabStyles']['default']['radius'] ) ? $attributes['tabStyles']['default']['radius'] : '',
	),
	'active'         => array(
		'margin' => array(
			'top'    => isset( $attributes['tabStyles']['active']['margin']['top'] ) ? $attributes['tabStyles']['active']['margin']['top'] : '',
			'bottom' => isset( $attributes['tabStyles']['active']['margin']['bottom'] ) ? $attributes['tabStyles']['active']['margin']['bottom'] : '',
		),
		'border' => isset( $attributes['tabStyles']['active']['border'] ) ? cozy_render_TRBL( 'border', $attributes['tabStyles']['active']['border'] ) : '',
		'radius' => isset( $attributes['tabStyles']['active']['radius'] ) ? $attributes['tabStyles']['active']['radius'] : '',
	),
	'font'           => array(
		'size'   => isset( $attributes['tabStyles']['font']['size'] ) ? $attributes['tabStyles']['font']['size'] : '',
		'family' => isset( $attributes['tabStyles']['font']['family'] ) ? $attributes['tabStyles']['font']['family'] : '',
	),
	'line_height'    => isset( $attributes['tabStyles']['lineHeight'] ) ? $attributes['tabStyles']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['tabStyles']['letterSpacing'] ) ? $attributes['tabStyles']['letterSpacing'] : '',
	'color'          => array(
		'text'         => isset( $attributes['tabStyles']['color']['text'] ) ? $attributes['tabStyles']['color']['text'] : '',
		'text_active'  => isset( $attributes['tabStyles']['color']['textActive'] ) ? $attributes['tabStyles']['color']['textActive'] : '',
		'text_hover'   => isset( $attributes['tabStyles']['color']['textHover'] ) ? $attributes['tabStyles']['color']['textHover'] : '',
		'bg'           => isset( $attributes['tabStyles']['color']['bg'] ) ? $attributes['tabStyles']['color']['bg'] : '',
		'bg_active'    => isset( $attributes['tabStyles']['color']['bgActive'] ) ? $attributes['tabStyles']['color']['bgActive'] : '',
		'bg_hover'     => isset( $attributes['tabStyles']['color']['bgHover'] ) ? $attributes['tabStyles']['color']['bgHover'] : '',
		'border_hover' => isset( $attributes['tabStyles']['color']['borderHover'] ) ? $attributes['tabStyles']['color']['borderHover'] : '',
	),
);

$toggle_styles = array(
	'font'           => array(
		'size'   => isset( $attributes['toggleStyles']['font']['size'] ) ? $attributes['toggleStyles']['font']['size'] : '',
		'family' => isset( $attributes['toggleStyles']['font']['family'] ) ? $attributes['toggleStyles']['font']['family'] : '',
	),
	'line_height'    => isset( $attributes['toggleStyles']['lineHeight'] ) ? $attributes['toggleStyles']['lineHeight'] : '',
	'letter_spacing' => isset( $attributes['toggleStyles']['letterSpacing'] ) ? $attributes['toggleStyles']['letterSpacing'] : '',
	'color'          => array(
		'button'        => isset( $attributes['toggleStyles']['color']['button'] ) ? $attributes['toggleStyles']['color']['button'] : '',
		'button_active' => isset( $attributes['toggleStyles']['color']['buttonActive'] ) ? $attributes['toggleStyles']['color']['buttonActive'] : '',
		'bg'            => isset( $attributes['toggleStyles']['color']['bg'] ) ? $attributes['toggleStyles']['color']['bg'] : '',
		'bg_active'     => isset( $attributes['toggleStyles']['color']['bgActive'] ) ? $attributes['toggleStyles']['color']['bgActive'] : '',
	),
);

$block_styles = "
#$block_id {
    {$styles['padding']}
    margin-top: {$styles['margin']['top']};
    margin-bottom: {$styles['margin']['bottom']};
    {$styles['border']}
    {$styles['radius']}
    background-color: {$styles['color']['bg']};
    color: {$styles['color']['text']};
    font-size: {$styles['font']['size']};
    font-weight: {$attributes['font']['weight']};
    font-family: {$styles['font']['family']};
}
#$block_id.has-box-shadow {
    box-shadow: {$styles['shadow']['horizontal']} {$styles['shadow']['vertical']} {$styles['shadow']['blur']} {$styles['shadow']['spread']} {$styles['shadow']['color']} {$styles['shadow']['position']};
}

#$block_id .toggle-content__header {
    margin-top: {$wrapper_styles['margin']['top']};
    margin-bottom: {$wrapper_styles['margin']['bottom']};
}

#$block_id .toggle-content__tabs, #$block_id .toggle-content__slider {
    width: {$attributes['wrapperStyles']['width']};
    {$wrapper_styles['padding']}
    {$wrapper_styles['border']}
    {$wrapper_styles['radius']}
    justify-content: {$attributes['wrapperStyles']['contentAlign']};
    gap: {$wrapper_styles['content_gap']};
    background-color: {$wrapper_styles['color']['bg']};
}

#$block_id .toggle-content__tabs .tab-item {
    {$tab_styles['default']['padding']}
    {$tab_styles['default']['border']}
    border-radius: {$tab_styles['default']['radius']};
    color: {$tab_styles['color']['text']};
    background-color: {$tab_styles['color']['bg']};
    font-size: {$tab_styles['font']['size']};
    font-weight: {$attributes['tabStyles']['font']['weight']};
    font-family: {$tab_styles['font']['family']};
    text-transform: {$attributes['tabStyles']['letterCase']};
    text-decoration: {$attributes['tabStyles']['decoration']};
    line-height: {$tab_styles['line_height']};
    letter-spacing: {$tab_styles['letter_spacing']};
}
#$block_id .toggle-content__tabs .tab-item.active-tab {
    margin-top: {$tab_styles['active']['margin']['top']};
    margin-bottom: {$tab_styles['active']['margin']['bottom']};
    {$tab_styles['active']['border']}
    border-radius: {$tab_styles['active']['radius']};
    color: {$tab_styles['color']['text_active']};
    background-color: {$tab_styles['color']['bg_active']};
}
#$block_id .toggle-content__tabs .tab-item:hover {
    color: {$tab_styles['color']['text_hover']};
    background-color: {$tab_styles['color']['bg_hover']};
    border-color: {$tab_styles['color']['border_hover']};
}

#$block_id .toggle-content__slider {
	font-size: {$toggle_styles['font']['size']};
    font-weight: {$attributes['toggleStyles']['font']['weight']};
    font-family: {$toggle_styles['font']['family']};
    text-transform: {$attributes['toggleStyles']['letterCase']};
    text-decoration: {$attributes['toggleStyles']['decoration']};
    line-height: {$toggle_styles['line_height']};
    letter-spacing: {$toggle_styles['letter_spacing']};
}
#$block_id .toggle-content__slider .slider {
    background-color: {$toggle_styles['color']['bg']};
}
#$block_id .toggle-content__slider .slider:before {
    background-color: {$toggle_styles['color']['button']};
}
#$block_id .toggle-content__slider #toggle-switch:checked + .slider {
    background-color: {$toggle_styles['color']['bg_active']};
}
#$block_id .toggle-content__slider #toggle-switch:checked + .slider:before {
    background-color: {$toggle_styles['color']['button_active']};
}
";

$wrapper_attributes = get_block_wrapper_attributes();

// Extract the existing class attribute
preg_match( '/<div[^>]*\bclass=["\']([^"\']*\bcozy-block-toggle-content-item\b[^"\']*)["\']/', $content, $matches );
$existing_class = isset( $matches[1] ) ? $matches[1] : '';

$updated_class = trim( $existing_class ) . ' show-content';
$content       = preg_replace(
	'/(<div[^>]*\bid=["\'][^"\']*["\'][^>]*\bclass=["\'])cozy-block-toggle-content-item([^"\']*)(["\'])/',
	'${1}' . esc_attr( $updated_class ) . '${3}',
	$content,
	1
);


$font_families = array();

if ( isset( $attributes['tabStyles']['font']['family'] ) && ! empty( $attributes['tabStyles']['font']['family'] ) ) {
	$font_families[] = $attributes['tabStyles']['font']['family'];
}

if ( isset( $attributes['toggleStyles']['font']['family'] ) && ! empty( $attributes['toggleStyles']['font']['family'] ) ) {
	$font_families[] = $attributes['toggleStyles']['font']['family'];
}

if ( isset( $attributes['font']['family'] ) && ! empty( $attributes['font']['family'] ) ) {
	$font_families[] = $attributes['font']['family'];
}

// Remove duplicate font families.
$font_families = array_unique( $font_families );

$font_query = '';

// Add other fonts.
foreach ( $font_families as $key => $family ) {
	if ( 0 === $key ) {
		$font_query .= 'family=' . $family . ':wght@100;200;300;400;500;600;700;800;900';
	} else {
		$font_query .= '&family=' . $family . ':wght@100;200;300;400;500;600;700;800;900';
	}
}

if ( ! empty( $font_query ) ) {
	// Generate the inline style for the Google Fonts link.
	$google_fonts_url = 'https://fonts.googleapis.com/css2?' . rawurlencode( $font_query );

	// Add the Google Fonts URL as an inline style.
	wp_add_inline_style( 'cozy-block--toggle-content--style', '@import url("' . rawurldecode( esc_url( $google_fonts_url ) ) . '");' );
}

add_action(
	'wp_enqueue_scripts',
	function () use ( $block_styles ) {
		wp_add_inline_style( 'cozy-block--toggle-content--style', esc_html( $block_styles ) );
	}
);

$classes   = array();
$classes[] = 'cozy-block-toggle-content';
$classes[] = $attributes['shadow']['enabled'] ? 'has-box-shadow' : '';
?>

<div class="cozy-block-wrapper">
	<div <?php echo $wrapper_attributes; ?>>
		<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
			<?php
			$classes   = array();
			$classes[] = 'toggle-content__header';
			$classes[] = 'content-width-' . $attributes['wrapperStyles']['width'];
			$classes[] = 'content-align-' . $attributes['wrapperStyles']['contentAlign'];
			?>
			<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>">
				<?php
				if ( 'tab' === $attributes['type'] && ! empty( $attributes['tabs'] ) ) {
					?>
					<ul class="toggle-content__tabs">
						<?php
						foreach ( $attributes['tabs'] as $key => $tab_item ) {
							$classes   = array();
							$classes[] = 'tab-item';
							$classes[] = 0 === $key ? 'active-tab' : '';
							?>
							<li class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', array_values( $classes ) ) ) ); ?>" data-index="<?php echo esc_attr( $key ); ?>" data-client-id="<?php echo esc_attr( $tab_item['clientId'] ); ?>"><?php echo esc_html( $tab_item['tabLabel'] ); ?></li>
							<?php
						}
						?>
					</ul>
					<?php
				}

				if ( 'toggle' === $attributes['type'] && count( $attributes['tabs'] ) >= 2 ) {
					?>
					<div class="toggle-content__slider">
						<p class="tab-item" data-index="0"><?php echo esc_html( $attributes['tabs'][0]['tabLabel'] ); ?></p>
						<label class="switch">
							<input id="toggle-switch" type="checkbox" />
							<span class="slider"></span>
						</label>
						<p class="tab-item" data-index="1"><?php echo esc_html( $attributes['tabs'][1]['tabLabel'] ); ?></p>
					</div>
					<?php
				}
				?>
			</div>

			<?php echo $content; ?>
		</div>
	</div>
</div>