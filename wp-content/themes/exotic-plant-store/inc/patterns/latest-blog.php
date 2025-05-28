<?php
/**
 * Latest Blogs
 */
return array(
	'title'      => esc_html__( 'Latest Blogs', 'exotic-plant-store' ),
	'categories' => array( 'exotic-plant-store', 'Latest Blogs' ),
	'content'    => '<!-- wp:group {"tagName":"main","style":{"color":{"background":"#f4f4f4"}}} -->
<main class="wp-block-group has-background" style="background-color:#f4f4f4"><!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:query {"queryId":38,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":true},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"}} -->
<div class="wp-block-query"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"25px"},"elements":{"link":{"color":{"text":"#ee344e"}}},"color":{"text":"#ee344e"}},"fontFamily":"exotic-plant-store-inter"} -->
<h3 class="wp-block-heading has-text-align-center has-text-color has-link-color has-exotic-plant-store-inter-font-family" style="color:#ee344e;font-size:25px">News &amp; Articles</h3>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":3,"style":{"typography":{"fontSize":"40px","lineHeight":"1.3"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"exotic-plant-store-inter"} -->
<h3 class="wp-block-heading has-text-align-center has-primary-color has-text-color has-link-color has-exotic-plant-store-inter-font-family" style="font-size:40px;line-height:1.3">Garden News Headlines</h3>
<!-- /wp:heading -->

<!-- wp:query {"queryId":59,"query":{"perPage":12,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts","name":"Grid"},"className":"blog-area","layout":{"type":"default"}} -->
<div class="wp-block-query blog-area"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":null}} -->
<!-- wp:group {"className":"post-main-area","style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}},"border":{"radius":"10px","color":"#e7e7e7","width":"1px"}},"backgroundColor":"foreground","layout":{"inherit":false}} -->
<div class="wp-block-group post-main-area has-border-color has-foreground-background-color has-background" style="border-color:#e7e7e7;border-width:1px;border-radius:10px;padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:post-title {"isLink":true,"style":{"typography":{"fontSize":"22px"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"exotic-plant-store-inter"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"style":{"elements":{"link":{"color":{"text":"#747474"}}},"color":{"text":"#747474"},"typography":{"fontSize":"16px"}},"fontFamily":"exotic-plant-store-inter"} /-->

<!-- wp:post-date {"style":{"elements":{"link":{"color":{"text":"#ee344e"}}},"color":{"text":"#ee344e"}},"fontFamily":"exotic-plant-store-inter"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:query -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></main>
<!-- /wp:group -->',
);