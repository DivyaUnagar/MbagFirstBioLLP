<?php
/**
 * Title: 404
 * Slug: nas-organic-food-store/404
 * Categories: nas-organic-food-store
 *
 * @package Organic Food Store
 * @since 1.0.0
 */

?>
<!-- wp:group {"tagName":"main","align":"full","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"30px","bottom":"0","left":"var:preset|spacing|30","right":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|40"}},"className":"wp-block-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide wp-block-section" style="padding-top:30px;padding-right:var(--wp--preset--spacing--30);padding-bottom:0;padding-left:var(--wp--preset--spacing--30)"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"200px"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-size:200px">404</h2>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'Page not found', 'nas-organic-food-store' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center"><?php echo esc_html__( 'It looks like nothing was found at this location. Click button below to return to homepage.', 'nas-organic-food-store' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"style":{"border":{"radius":"10px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ));?>" style="border-radius:10px"><?php echo esc_html__( 'Back to Home', 'nas-organic-food-store' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:spacer {"height":"80px"} -->
<div style="height:80px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group --></main>
<!-- /wp:group -->