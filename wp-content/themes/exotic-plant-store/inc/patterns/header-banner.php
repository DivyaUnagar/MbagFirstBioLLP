<?php 
/**
 * Default Header Banner
 */
return array(
	'title'      => esc_html__( 'Header Banner', 'exotic-plant-store' ),
	'categories' => array( 'exotic-plant-store', 'Header Banner' ),
	'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}},"color":{"background":"#568b58"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-background" style="background-color:#568b58;padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"></div>
<!-- /wp:group -->
<!-- wp:cover {"url":"' . esc_url( get_theme_file_uri( '/assets/images/banner.jpg' ) ) . '","id":8,"dimRatio":20,"overlayColor":"primary","isUserOverlayColor":true,"minHeight":700,"minHeightUnit":"px","className":"banner-wrap","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"top":"0","bottom":"0","right":"0","left":"0"}}}} -->
<div class="wp-block-cover banner-wrap" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;min-height:700px"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-20 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-8" alt="" src="' . esc_url( get_theme_file_uri( '/assets/images/banner.jpg' ) ) . '" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"60%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%"><!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}}},"textColor":"foreground","fontFamily":"exotic-plant-store-inter"} -->
<p class="has-text-align-left has-foreground-color has-text-color has-link-color has-exotic-plant-store-inter-font-family" style="font-size:22px;font-style:normal;font-weight:700">LETS GO GARDEN</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"left","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground"}}},"typography":{"fontSize":"52px","lineHeight":"1.5","textTransform":"uppercase"}},"textColor":"foreground","fontFamily":"exotic-plant-store-inter"} -->
<h2 class="wp-block-heading has-text-align-left has-foreground-color has-text-color has-link-color has-exotic-plant-store-inter-font-family" style="font-size:52px;line-height:1.5;text-transform:uppercase">Where Flowers Bloom, So Does Joy.</h2>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"center","backgroundColor":"foreground","textColor":"primary","style":{"typography":{"fontSize":"17px","fontStyle":"normal","fontWeight":"400"},"border":{"radius":"30px"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"padding":{"left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}},"fontFamily":"exotic-plant-store-inter"} -->
<div class="wp-block-button has-custom-font-size has-exotic-plant-store-inter-font-family" style="font-size:17px;font-style:normal;font-weight:400"><a class="wp-block-button__link has-primary-color has-foreground-background-color has-text-color has-background has-link-color has-text-align-center wp-element-button" style="border-radius:30px;padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">Read More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"40%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->',
);