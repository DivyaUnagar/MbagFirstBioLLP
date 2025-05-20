<?php

/**
 * Title: PRO: About Modern Layout
 * Slug: cozy-essential-addons/saaslauncher-about
 * Categories: saaslauncher-about
 */
$ct_patterns_media = array(
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/about_2.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/about.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/users_face.png',
);
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|40","left":"var:preset|spacing|40","top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"light-color","layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-light-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--40)"><!-- wp:group {"layout":{"type":"constrained","contentSize":"780px"}} -->
    <div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1} -->
        <h1 class="wp-block-heading has-text-align-center"><?php esc_html_e('Building Future-Ready Brands with Creativity &amp; Technology', 'cozy-essential-addons') ?></h1>
        <!-- /wp:heading -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"style":{"spacing":{"margin":{"top":"60px"},"blockGap":{"left":"44px"}}}} -->
    <div class="wp-block-columns" style="margin-top:60px"><!-- wp:column {"width":"44%"} -->
        <div class="wp-block-column" style="flex-basis:44%"><!-- wp:cover {"url":"<?php echo esc_url($ct_patterns_media[0]) ?>","id":11919,"dimRatio":0,"customOverlayColor":"#b9b6b5","isUserOverlayColor":false,"minHeight":580,"isDark":false,"style":{"border":{"radius":"20px"}},"layout":{"type":"constrained"}} -->
            <div class="wp-block-cover is-light" style="border-radius:20px;min-height:580px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#b9b6b5"></span><img class="wp-block-cover__image-background wp-image-11919" alt="" src="<?php echo esc_url($ct_patterns_media[0]) ?>" data-object-fit="cover" />
                <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
                    <p class="has-text-align-center has-large-font-size"></p>
                    <!-- /wp:paragraph -->
                </div>
            </div>
            <!-- /wp:cover -->

            <!-- wp:group {"style":{"border":{"radius":"12px"},"spacing":{"margin":{"top":"44px","bottom":"0"},"padding":{"top":"40px","bottom":"40px","left":"54px","right":"54px"}}},"backgroundColor":"primary","layout":{"type":"constrained"}} -->
            <div class="wp-block-group has-primary-background-color has-background" style="border-radius:12px;margin-top:44px;margin-bottom:0;padding-top:40px;padding-right:54px;padding-bottom:40px;padding-left:54px"><!-- wp:group {"style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
                <div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:image {"id":11631,"width":"auto","height":"40px","sizeSlug":"full","linkDestination":"none"} -->
                    <figure class="wp-block-image size-full is-resized"><img src="<?php echo esc_url($ct_patterns_media[2]) ?>" alt="" class="wp-image-11631" style="width:auto;height:40px" /></figure>
                    <!-- /wp:image -->

                    <!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
                    <div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
                        <div class="wp-block-group"><!-- wp:cozy-block/counter {"blockClientId":"aae30a84-c252-41a1-a18c-1a5ae678870b","endNumber":"20000","textAlign":"left","styles":{"fontFamily":"Public Sans","fontSize":"40px","color":"#FFFFFE","fontWeight":700}} -->
                            <div class="cozy-block-counter" id="cozyBlock_aae30a84_c252_41a1_a18c_1a5ae678870b"><span><?php esc_html_e('0', 'cozy-essential-addons') ?></span></div>
                            <!-- /wp:cozy-block/counter -->

                            <!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontStyle":"normal","fontWeight":"500"}},"textColor":"background","fontSize":"x-large"} -->
                            <h2 class="wp-block-heading has-background-color has-text-color has-link-color has-x-large-font-size" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;font-style:normal;font-weight:500"><?php esc_html_e('+', 'cozy-essential-addons') ?></h2>
                            <!-- /wp:heading -->
                        </div>
                        <!-- /wp:group -->

                        <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color"} -->
                        <p class="has-light-color-color has-text-color has-link-color"><?php esc_html_e('Satisfied Clients Across the Globe', 'cozy-essential-addons') ?></p>
                        <!-- /wp:paragraph -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|heading-color"}}}},"textColor":"heading-color","fontSize":"medium"} -->
            <p class="has-heading-color-color has-text-color has-link-color has-medium-font-size"><?php esc_html_e('Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.', 'cozy-essential-addons') ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|heading-color"}}}},"textColor":"heading-color","fontSize":"medium"} -->
            <p class="has-heading-color-color has-text-color has-link-color has-medium-font-size"><?php esc_html_e('From its medieval origins to the digital era, learn everything there is to know about the ubiquitous lorem ipsum passage. Lorem ipsum dolor sit amet, consectetur adipiscing elit tempor incididunt ut labore.', 'cozy-essential-addons') ?></p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"className":"is-style-button-transofom-on-hover","style":{"spacing":{"margin":{"top":"28px"}}}} -->
            <div class="wp-block-buttons is-style-button-transofom-on-hover" style="margin-top:28px"><!-- wp:button {"gradient":"gradient-twelve","style":{"border":{"radius":"60px"}},"fontSize":"normal"} -->
                <div class="wp-block-button has-custom-font-size has-normal-font-size"><a class="wp-block-button__link has-gradient-twelve-gradient-background has-background wp-element-button" style="border-radius:60px"><?php esc_html_e('Explore More', 'cozy-essential-addons') ?></a></div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->

            <!-- wp:cover {"url":"<?php echo esc_url($ct_patterns_media[1]) ?>","id":12245,"dimRatio":0,"customOverlayColor":"#bfbdbc","isUserOverlayColor":false,"minHeight":422,"isDark":false,"style":{"border":{"radius":"20px"},"spacing":{"margin":{"top":"48px"}}},"layout":{"type":"constrained"}} -->
            <div class="wp-block-cover is-light" style="border-radius:20px;margin-top:48px;min-height:422px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-0 has-background-dim" style="background-color:#bfbdbc"></span><img class="wp-block-cover__image-background wp-image-12245" alt="" src="<?php echo esc_url($ct_patterns_media[1]) ?>" data-object-fit="cover" />
                <div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
                    <p class="has-text-align-center has-large-font-size"></p>
                    <!-- /wp:paragraph -->
                </div>
            </div>
            <!-- /wp:cover -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->