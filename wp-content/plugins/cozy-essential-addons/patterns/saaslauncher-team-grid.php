<?php

/**
 * Title: PRO: Team Grid
 * Slug: cozy-essential-addons/saaslauncher-team-grid
 * Categories: saaslauncher-team
 */
$ct_patterns_media = array(
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_1.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_2.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_3.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_4.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_5.jpg',
    COZY_ESSENTIAL_ADDONS_ASSETS_URL . 'admin/images/saaslauncher/team_6.jpg',
);
?>
<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|40","left":"var:preset|spacing|40","top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"black-color","layout":{"type":"constrained","contentSize":"1260px"}} -->
<div class="wp-block-group has-black-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--40)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"60px"}}},"layout":{"type":"constrained","contentSize":"740px","justifyContent":"center"}} -->
    <div class="wp-block-group" style="margin-bottom:60px"><!-- wp:heading {"textAlign":"center","level":1,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color"} -->
        <h1 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color"><?php esc_html_e('Meet Our Team', 'cozy-essential-addons') ?></h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}}},"textColor":"foreground-alt"} -->
        <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color"><?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'cozy-essential-addons') ?></p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->

    <!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"64px"}}}} -->
    <div class="wp-block-columns"><!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":6089,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[0]) ?>" alt="" class="wp-image-6089" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('John Doe', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('Founder - Doe Industries', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":6090,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[1]) ?>" alt="" class="wp-image-6090" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('Liana Potmen', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('CEO - Potmen Technology', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":6091,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[2]) ?>" alt="" class="wp-image-6091" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('Matt Robert', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('COO - Matt Software', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->

    <!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"64px"},"margin":{"top":"64px","bottom":"0"}}}} -->
    <div class="wp-block-columns" style="margin-top:64px;margin-bottom:0"><!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":10928,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[3]) ?>" alt="" class="wp-image-10928" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('Alexa M', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('CEO - M Technology', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":11535,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[4]) ?>" alt="" class="wp-image-11535" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('Robin L', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('CFO - RL Industries', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->

        <!-- wp:column -->
        <div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
            <div class="wp-block-group"><!-- wp:image {"id":10929,"width":"240px","height":"240px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","style":{"border":{"radius":"50%"},"spacing":{"margin":{"bottom":"24px"}}}} -->
                <figure class="wp-block-image aligncenter size-full is-resized has-custom-border" style="margin-bottom:24px"><img src="<?php echo esc_url($ct_patterns_media[5]) ?>" alt="" class="wp-image-10929" style="border-radius:50%;object-fit:cover;width:240px;height:240px" /></figure>
                <!-- /wp:image -->

                <!-- wp:heading {"textAlign":"center","level":4,"style":{"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}},"textColor":"light-color","fontSize":"big"} -->
                <h4 class="wp-block-heading has-text-align-center has-light-color-color has-text-color has-link-color has-big-font-size"><?php esc_html_e('Lexi P', 'cozy-essential-addons') ?></h4>
                <!-- /wp:heading -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontSize":"small"} -->
                <p class="has-text-align-center has-primary-color has-text-color has-link-color has-small-font-size"><?php esc_html_e('Manager - Lexi Technology', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|foreground-alt"}}},"spacing":{"margin":{"top":"20px"}}},"textColor":"foreground-alt"} -->
                <p class="has-text-align-center has-foreground-alt-color has-text-color has-link-color" style="margin-top:20px"><?php esc_html_e('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore', 'cozy-essential-addons') ?></p>
                <!-- /wp:paragraph -->

                <!-- wp:social-links {"iconColor":"heading-color","iconColorValue":"#1E262A","iconBackgroundColor":"light-color","iconBackgroundColorValue":"#FFFFFE","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"},"margin":{"top":"24px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
                <ul class="wp-block-social-links has-icon-color has-icon-background-color" style="margin-top:24px"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

                    <!-- wp:social-link {"url":"#","service":"x"} /-->

                    <!-- wp:social-link {"url":"#","service":"youtube"} /-->

                    <!-- wp:social-link {"url":"#","service":"whatsapp"} /-->
                </ul>
                <!-- /wp:social-links -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
</div>
<!-- /wp:group -->