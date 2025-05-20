<?php 
if (isset($_GET['import-demo']) && $_GET['import-demo'] == true) {

 // Function to install and activate plugins
    function food_grocery_hub_import_demo_content() {

        // Display the preloader only for plugin installation
        echo '<div id="plugin-loader" style="display: flex; align-items: center; justify-content: center; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.4); z-index: 9999;">
                <img src="' . esc_url(get_template_directory_uri()) . '/assets/images/loader.png" alt="Loading..." width="60" height="60" />
              </div>';

        // Define the plugins you want to install and activate
        $plugins = array(
            array(
                'slug' => 'woocommerce',
                'file' => 'woocommerce/woocommerce.php',
                'url'  => 'https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip'
            ),
            array(
                'slug' => 'gtranslate',
                'file' => 'gtranslate/gtranslate.php',
                'url'  => 'https://downloads.wordpress.org/plugin/gtranslate.latest-stable.zip' // Correct GTranslate URL
            ),
        );

        // Include required files for plugin installation
        include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        include_once(ABSPATH . 'wp-admin/includes/file.php');
        include_once(ABSPATH . 'wp-admin/includes/misc.php');
        include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

        // Loop through each plugin
        foreach ($plugins as $plugin) {
            $plugin_file = WP_PLUGIN_DIR . '/' . $plugin['file'];

            // Check if the plugin is installed
            if (!file_exists($plugin_file)) {
                // If the plugin is not installed, download and install it
                $upgrader = new Plugin_Upgrader();
                $result = $upgrader->install($plugin['url']);

                // Check for installation errors
                if (is_wp_error($result)) {
                    error_log('Plugin installation failed: ' . $plugin['slug'] . ' - ' . $result->get_error_message());
                    echo 'Error installing plugin: ' . esc_html($plugin['slug']) . ' - ' . esc_html($result->get_error_message());
                    continue;
                }
            }

            // If the plugin exists but is not active, activate it
            if (file_exists($plugin_file) && !is_plugin_active($plugin['file'])) {
                $result = activate_plugin($plugin['file']);

                // Check for activation errors
                if (is_wp_error($result)) {
                    error_log('Plugin activation failed: ' . $plugin['slug'] . ' - ' . $result->get_error_message());
                    echo 'Error activating plugin: ' . esc_html($plugin['slug']) . ' - ' . esc_html($result->get_error_message());
                }
            }
        }

        // Hide the preloader after the process is complete
        echo '<script type="text/javascript">
                window.onload = function() {
                    document.getElementById("plugin-loader").style.display = "none"; // Hide only plugin preloader
                };
              </script>';
    }

    // Call the import function
    food_grocery_hub_import_demo_content();

    // ------- Create Nav Menu --------
$food_grocery_hub_menuname = 'Main Menus';
$food_grocery_hub_bpmenulocation = 'primary-menu';
$food_grocery_hub_menu_exists = wp_get_nav_menu_object($food_grocery_hub_menuname);

if (!$food_grocery_hub_menu_exists) {
    $food_grocery_hub_menu_id = wp_create_nav_menu($food_grocery_hub_menuname);

    // Create Home Page
    $food_grocery_hub_home_title = 'Home';
    $food_grocery_hub_home = array(
        'post_type' => 'page',
        'post_title' => $food_grocery_hub_home_title,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'home'
    );
    $food_grocery_hub_home_id = wp_insert_post($food_grocery_hub_home);

    // Assign Home Page Template
    add_post_meta($food_grocery_hub_home_id, '_wp_page_template', 'page-template/front-page.php');

    // Update options to set Home Page as the front page
    update_option('page_on_front', $food_grocery_hub_home_id);
    update_option('show_on_front', 'page');

    // Add Home Page to Menu
    wp_update_nav_menu_item($food_grocery_hub_menu_id, 0, array(
        'menu-item-title' => __('Home', 'food-grocery-hub'),
        'menu-item-classes' => 'home',
        'menu-item-url' => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $food_grocery_hub_home_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create About Us Page with Dummy Content
    $food_grocery_hub_about_title = 'About Us';
    $food_grocery_hub_about_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $food_grocery_hub_about = array(
        'post_type' => 'page',
        'post_title' => $food_grocery_hub_about_title,
        'post_content' => $food_grocery_hub_about_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'about-us'
    );
    $food_grocery_hub_about_id = wp_insert_post($food_grocery_hub_about);

    // Add About Us Page to Menu
    wp_update_nav_menu_item($food_grocery_hub_menu_id, 0, array(
        'menu-item-title' => __('About Us', 'food-grocery-hub'),
        'menu-item-classes' => 'about-us',
        'menu-item-url' => home_url('/about-us/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $food_grocery_hub_about_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Services Page with Dummy Content
    $food_grocery_hub_services_title = 'Services';
    $food_grocery_hub_services_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $food_grocery_hub_services = array(
        'post_type' => 'page',
        'post_title' => $food_grocery_hub_services_title,
        'post_content' => $food_grocery_hub_services_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'services'
    );
    $food_grocery_hub_services_id = wp_insert_post($food_grocery_hub_services);

    // Add Services Page to Menu
    wp_update_nav_menu_item($food_grocery_hub_menu_id, 0, array(
        'menu-item-title' => __('Services', 'food-grocery-hub'),
        'menu-item-classes' => 'services',
        'menu-item-url' => home_url('/services/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $food_grocery_hub_services_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Pages Page with Dummy Content
    $food_grocery_hub_pages_title = 'Pages';
    $food_grocery_hub_pages_content = '<h2>Our Pages</h2>
    <p>Explore all the pages we have on our website. Find information about our services, company, and more.</p>';
    $food_grocery_hub_pages = array(
        'post_type' => 'page',
        'post_title' => $food_grocery_hub_pages_title,
        'post_content' => $food_grocery_hub_pages_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'pages'
    );
    $food_grocery_hub_pages_id = wp_insert_post($food_grocery_hub_pages);

    // Add Pages Page to Menu
    wp_update_nav_menu_item($food_grocery_hub_menu_id, 0, array(
        'menu-item-title' => __('Pages', 'food-grocery-hub'),
        'menu-item-classes' => 'pages',
        'menu-item-url' => home_url('/pages/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $food_grocery_hub_pages_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Create Contact Page with Dummy Content
    $food_grocery_hub_contact_title = 'Contact';
    $food_grocery_hub_contact_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

             Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> 

                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br> 

                All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
    $food_grocery_hub_contact = array(
        'post_type' => 'page',
        'post_title' => $food_grocery_hub_contact_title,
        'post_content' => $food_grocery_hub_contact_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'post_slug' => 'contact'
    );
    $food_grocery_hub_contact_id = wp_insert_post($food_grocery_hub_contact);

    // Add Contact Page to Menu
    wp_update_nav_menu_item($food_grocery_hub_menu_id, 0, array(
        'menu-item-title' => __('Contact', 'food-grocery-hub'),
        'menu-item-classes' => 'contact',
        'menu-item-url' => home_url('/contact/'),
        'menu-item-status' => 'publish',
        'menu-item-object-id' => $food_grocery_hub_contact_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type'
    ));

    // Set the menu location if it's not already set
    if (!has_nav_menu($food_grocery_hub_bpmenulocation)) {
        $locations = get_theme_mod('nav_menu_locations'); // Use 'nav_menu_locations' to get locations array
        if (empty($locations)) {
            $locations = array();
        }
        $locations[$food_grocery_hub_bpmenulocation] = $food_grocery_hub_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

        //---Header--//
        set_theme_mod('food_grocery_hub_delivery_time', 'Delivery on next day from 10:00 am to 08:00 pm');
        set_theme_mod('food_grocery_hub_call', '+1 23456789');
        set_theme_mod('food_grocery_hub_instagram_url', '#');
        set_theme_mod('food_grocery_hub_facebook_url', '#');
        set_theme_mod('food_grocery_hub_linkedin_url', '#');
        set_theme_mod('food_grocery_hub_twitter_url', '#');

         // Slider Section
        set_theme_mod('food_grocery_hub_slider_arrows', true);
        set_theme_mod('food_grocery_hub_slider_short_heading', '2500+ Fresh Products');

        for ($i = 1; $i <= 4; $i++) {
            $food_grocery_hub_title = 'Order Tasty Fruits and Get Free Delivery!';

            // Create post object
            $my_post = array(
                'post_title'    => wp_strip_all_tags($food_grocery_hub_title),
                'post_status'   => 'publish',
                'post_type'     => 'page',
            );

            /// Insert the post into the database
            $post_id = wp_insert_post($my_post);

            if ($post_id) {
                // Set the theme mod for the slider page
                set_theme_mod('food_grocery_hub_slider_page' . $i, $post_id);

                $image_url = get_template_directory_uri() . '/assets/images/slider-img.png';
                $image_id = media_sideload_image($image_url, $post_id, null, 'id');

                if (!is_wp_error($image_id)) {
                    // Set the downloaded image as the post's featured image
                    set_post_thumbnail($post_id, $image_id);
                }
            }
        }

        // Banner Section
        set_theme_mod('food_grocery_hub_banner_main_show', 'true');

        // banner1
        set_theme_mod('food_grocery_hub_product_banner_one',  get_template_directory_uri().'/assets/images/banner1.png' );

        set_theme_mod('food_grocery_hub_product_banner_one_title1', 'Fresh Seafood Everyday!');
        set_theme_mod('food_grocery_hub_product_banner_one_btn_text1', 'shop now');
        set_theme_mod('food_grocery_hub_product_banner_one_btn_link1', '#');

        // banner2
        set_theme_mod('food_grocery_hub_product_banner_two',  get_template_directory_uri().'/assets/images/banner2.png' );

        set_theme_mod('food_grocery_hub_product_banner_two_title1', 'Sweet Organic Drinks');
        set_theme_mod('food_grocery_hub_product_banner_two_btn_text1', 'shop now');
        set_theme_mod('food_grocery_hub_product_banner_two_btn_link1', '#');

        // banner3
        set_theme_mod('food_grocery_hub_product_banner_three',  get_template_directory_uri().'/assets/images/banner3.png' );

        set_theme_mod('food_grocery_hub_product_banner_three_title1', 'For Steak Lovers');
        set_theme_mod('food_grocery_hub_product_banner_three_btn_text1', 'shop now');
        set_theme_mod('food_grocery_hub_product_banner_three_btn_link1', '#');

    }
?>