<?php
/**
 * Food Grocery Hub Theme Page
 *
 * @package Food Grocery Hub
 */

function food_grocery_hub_admin_scripts() {
	wp_dequeue_script('food-grocery-hub-custom-scripts');
}
add_action( 'admin_enqueue_scripts', 'food_grocery_hub_admin_scripts' );

if ( ! defined( 'FOOD_GROCERY_HUB_FREE_THEME_URL' ) ) {
	define( 'FOOD_GROCERY_HUB_FREE_THEME_URL', 'https://www.themespride.com/products/free-grocery-wordpress-theme' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_PRO_THEME_URL' ) ) {
	define( 'FOOD_GROCERY_HUB_PRO_THEME_URL', 'https://www.themespride.com/products/grocery-store-wordpress-theme' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_DEMO_THEME_URL' ) ) {
	define( 'FOOD_GROCERY_HUB_DEMO_THEME_URL', 'https://page.themespride.com/food-grocery-hub-pro/' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_DOCS_THEME_URL' ) ) {
    define( 'FOOD_GROCERY_HUB_DOCS_THEME_URL', 'https://page.themespride.com/demo/docs/food-grocery-hub-lite/' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_RATE_THEME_URL' ) ) {
    define( 'FOOD_GROCERY_HUB_RATE_THEME_URL', 'https://wordpress.org/support/theme/food-grocery-hub/reviews/#new-post' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_CHANGELOG_THEME_URL' ) ) {
    define( 'FOOD_GROCERY_HUB_CHANGELOG_THEME_URL', get_template_directory() . '/readme.txt' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_SUPPORT_THEME_URL' ) ) {
    define( 'FOOD_GROCERY_HUB_SUPPORT_THEME_URL', 'https://wordpress.org/support/theme/food-grocery-hub/' );
}
if ( ! defined( 'FOOD_GROCERY_HUB_THEME_BUNDLE' ) ) {
    define( 'FOOD_GROCERY_HUB_THEME_BUNDLE', 'https://www.themespride.com/products/wordpress-theme-bundle' );
}
/**
 * Add theme page
 */
function food_grocery_hub_menu() {
	add_theme_page( esc_html__( 'About Theme', 'food-grocery-hub' ), esc_html__( 'Begin Installation - Import Demo', 'food-grocery-hub' ), 'edit_theme_options', 'food-grocery-hub-about', 'food_grocery_hub_about_display' );
}
add_action( 'admin_menu', 'food_grocery_hub_menu' );


/**
 * Display About page
 */
function food_grocery_hub_about_display() {
	$food_grocery_hub_theme = wp_get_theme();
	?>
	<div class="wrap about-wrap full-width-layout">
		<h1><?php echo esc_html( $food_grocery_hub_theme ); ?></h1>
		<div class="about-theme">
			<div class="theme-description">
				<p class="about-text">
					<?php
					// Remove last sentence of description.
					$food_grocery_hub_description = explode( '. ', $food_grocery_hub_theme->get( 'Description' ) );

					array_pop( $food_grocery_hub_description );

					$food_grocery_hub_description = implode( '. ', $food_grocery_hub_description );

					echo esc_html( $food_grocery_hub_description . '.' );
				?></p>
				<p class="actions">
					<a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_FREE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'food-grocery-hub' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_DEMO_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'View Demo', 'food-grocery-hub' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_DOCS_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Instructions', 'food-grocery-hub' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_RATE_THEME_URL ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Rate this theme', 'food-grocery-hub' ); ?></a>

					<a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_PRO_THEME_URL ); ?>" class="green button button-secondary" target="_blank"><?php esc_html_e( 'Upgrade to pro', 'food-grocery-hub' ); ?></a>
				</p>
			</div>

			<div class="theme-screenshot">
				<img src="<?php echo esc_url( $food_grocery_hub_theme->get_screenshot() ); ?>" />
			</div>

		</div>

		<nav class="nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu', 'food-grocery-hub' ); ?>">

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'food-grocery-hub-about' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['page'] ) && 'food-grocery-hub-about' === $_GET['page'] && ! isset( $_GET['tab'] ) ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'One Click Demo Import', 'food-grocery-hub' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'food-grocery-hub-about', 'tab' => 'about_theme' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'about_theme' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'About', 'food-grocery-hub' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'food-grocery-hub-about', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Compare free Vs Pro', 'food-grocery-hub' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'food-grocery-hub-about', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>" class="nav-tab<?php echo ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Changelog', 'food-grocery-hub' ); ?></a>

			<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'food-grocery-hub-about', 'tab' => 'get_bundle' ), 'themes.php' ) ) ); ?>" class="blink wp-bundle nav-tab<?php echo ( isset( $_GET['tab'] ) && 'get_bundle' === $_GET['tab'] ) ?' nav-tab-active' : ''; ?>"><?php esc_html_e( 'Get WordPress Theme Bundle', 'food-grocery-hub' ); ?></a>

		</nav>

		<?php
			food_grocery_hub_demo_import();

			food_grocery_hub_main_screen();

			food_grocery_hub_changelog_screen();

			food_grocery_hub_free_vs_pro();

			food_grocery_hub_get_bundle();

		?>

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? esc_html_e( 'Return to Updates', 'food-grocery-hub' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'food-grocery-hub' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'food-grocery-hub' ) : esc_html_e( 'Go to Dashboard', 'food-grocery-hub' ); ?></a>
		</div>
	</div>
	<?php
}

/**
 * Output the Demo Import screen.
 */

function food_grocery_hub_demo_import() {
    if (isset($_GET['page']) && 'food-grocery-hub-about' === $_GET['page'] && !isset($_GET['tab'])) {

        require_once get_template_directory() . '/inc/whizzie.php';

        if (isset($_GET['import-demo']) && $_GET['import-demo'] == true) { ?>
            <div class="col card success-demo">
                <p class="imp-success"><?php echo esc_html__('Imported Successfully', 'food-grocery-hub'); ?></p><br>
                <a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>" target="_blank">
                    <?php echo esc_html__('Go to Customizer', 'food-grocery-hub'); ?>
                </a>
            </div>
            <script type="text/javascript">
                // Redirect after success
                window.onload = function() {
                    setTimeout(function() {
                        window.location.href = "<?php echo esc_url(admin_url('customize.php')); ?>";
                    }, 1000); // 1 second delay to show success message
                };
            </script>
        <?php } else { ?>
            <div class="col card demo-btn text-center">
                <form id="demo-importer-form" action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php" method="POST">
                    <p class="demo-title"><?php echo esc_html__('Demo Importer', 'food-grocery-hub'); ?></p>
                    <p class="demo-des"><?php echo esc_html__('This theme supports importing demo content with a single click. Use the button below to quickly set up your site. You can easily customize or deactivate the imported content later through the Customizer.', 'food-grocery-hub'); ?></p>
                    <i class="fas fa-long-arrow-alt-down"></i>

                    <button type="submit" class="button button-primary with-icon" id="begin-install-btn">
                        <?php echo esc_html__('Begin Installation - Import Demo', 'food-grocery-hub'); ?>
                        <span id="loader" style="display:none;margin-left:10px;">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/loader.png" alt="Loading..." width="20" height="20" />
                        </span>
                    </button>
                </form>
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#demo-importer-form').on('submit', function (e) {
                        e.preventDefault();

                        if (confirm("Are you sure you want to proceed with the demo import?")) {
                            // Show loader inside button
                            $('#loader').show();

                            // Redirect to import demo (add ?import-demo=true)
                            var url = new URL(window.location.href);
                            url.searchParams.append('import-demo', 'true');
                            window.location.href = url;
                        } else {
                            return false;
                        }
                    });
                });
            </script>
        <?php }
    }
}

/**
 * Output the main about screen.
 */
function food_grocery_hub_main_screen() {
	if ( isset( $_GET['tab'] ) && 'about_theme' === $_GET['tab'] ) {
	?>
		<div class="feature-section two-col">
			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Theme Customizer', 'food-grocery-hub' ); ?></h2>
				<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'food-grocery-hub' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Customize', 'food-grocery-hub' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Got theme support question?', 'food-grocery-hub' ); ?></h2>
				<p><?php esc_html_e( 'Get genuine support from genuine people. Whether it\'s customization or compatibility, our seasoned developers deliver tailored solutions to your queries.', 'food-grocery-hub' ) ?></p>
				<p><a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_SUPPORT_THEME_URL ); ?>" class="button button-primary"><?php esc_html_e( 'Support Forum', 'food-grocery-hub' ); ?></a></p>
			</div>

			<div class="col card">
				<h2 class="title"><?php esc_html_e( 'Upgrade To Premium With Straight 20% OFF.', 'food-grocery-hub' ); ?></h2>
				<p><?php esc_html_e( 'Get our amazing WordPress theme with exclusive 20% off use the coupon', 'food-grocery-hub' ) ?>"<input type="text" value="GETPro20" id="myInput">".</p>
				<button class="button button-primary"><?php esc_html_e( 'GETPro20', 'food-grocery-hub' ); ?></button>
			</div>
		</div>
	<?php
	}
}

/**
 * Output the changelog screen.
 */
function food_grocery_hub_changelog_screen() {
	if ( isset( $_GET['tab'] ) && 'changelog' === $_GET['tab'] ) {
		global $wp_filesystem;
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'food-grocery-hub' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'food_grocery_hub_changelog_file', FOOD_GROCERY_HUB_CHANGELOG_THEME_URL );
				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = food_grocery_hub_parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
	<?php
	}
}

/**
 * Parse changelog from readme file.
 * @param  string $content
 * @return string
 */
function food_grocery_hub_parse_changelog( $content ) {
	// Explode content with ==  to juse separate main content to array of headings.
	$content = explode ( '== ', $content );

	$changelog_isolated = '';

	// Get element with 'Changelog ==' as starting string, i.e isolate changelog.
	foreach ( $content as $key => $value ) {
		if (strpos( $value, 'Changelog ==') === 0) {
	    	$changelog_isolated = str_replace( 'Changelog ==', '', $value );
	    }
	}

	// Now Explode $changelog_isolated to manupulate it to add html elements.
	$changelog_array = explode( '= ', $changelog_isolated );

	// Unset first element as it is empty.
	unset( $changelog_array[0] );

	$changelog = '<pre class="changelog">';

	foreach ( $changelog_array as $value) {
		// Replace all enter (\n) elements with </span><span> , opening and closing span will be added in next process.
		$value = preg_replace( '/\n+/', '</span><span>', $value );

		// Add openinf and closing div and span, only first span element will have heading class.
		$value = '<div class="block"><span class="heading">= ' . $value . '</span></div>';

		// Remove empty <span></span> element which newr formed at the end.
		$changelog .= str_replace( '<span></span>', '', $value );
	}

	$changelog .= '</pre>';

	return wp_kses_post( $changelog );
}

/**
 * Import Demo data for theme using catch themes demo import plugin
 */
function food_grocery_hub_free_vs_pro() {
	if ( isset( $_GET['tab'] ) && 'free_vs_pro' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'View Free vs Pro Table below:', 'food-grocery-hub' ); ?></p>
			<div class="vs-theme-table">
				<table>
					<thead>
						<tr><th scope="col"></th>
							<th class="head" scope="col"><?php esc_html_e( 'Free Theme', 'food-grocery-hub' ); ?></th>
							<th class="head" scope="col"><?php esc_html_e( 'Pro Theme', 'food-grocery-hub' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><span><?php esc_html_e( 'Theme Demo Set Up', 'food-grocery-hub' ); ?></span></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Templates, Color options and Fonts', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Included Demo Content', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Section Ordering', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Multiple Sections', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Additional Plugins', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Premium Technical Support', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Access to Support Forums', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Free updates', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-no-alt"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Unlimited Domains', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Responsive Design', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td headers="features" class="feature"><?php esc_html_e( 'Live Customizer', 'food-grocery-hub' ); ?></td>
							<td><span class="dashicons dashicons-saved"></span></td>
							<td><span class="dashicons dashicons-saved"></span></td>
						</tr>
						<tr class="odd" scope="row">
							<td class="feature feature--empty"></td>
							<td class="feature feature--empty"></td>
							<td headers="comp-2" class="td-btn-2"><a class="sidebar-button single-btn" href="<?php echo esc_url(FOOD_GROCERY_HUB_PRO_THEME_URL);?>" target="_blank"><?php esc_html_e( 'Go For Premium', 'food-grocery-hub' ); ?></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}
}

function food_grocery_hub_get_bundle() {
	if ( isset( $_GET['tab'] ) && 'get_bundle' === $_GET['tab'] ) {
	?>
		<div class="wrap about-wrap">

			<p class="about-description"><?php esc_html_e( 'Get WordPress Theme Bundle', 'food-grocery-hub' ); ?></p>
			<div class="col card">
				<h2 class="title"><?php esc_html_e( ' WordPress Theme Bundle of 100+ Themes At 15% Discount. ', 'food-grocery-hub' ); ?></h2>
				<p><?php esc_html_e( 'Spring Offer Is To Get WP Bundle of 100+ Themes At 15% Discount use the coupon', 'food-grocery-hub' ) ?>"<input type="text" value=" TPRIDE15 "  id="myInput">".</p>
				<p><a target="_blank" href="<?php echo esc_url( FOOD_GROCERY_HUB_THEME_BUNDLE ); ?>" class="button button-primary"><?php esc_html_e( 'Theme Bundle', 'food-grocery-hub' ); ?></a></p>
			</div>
		</div>
	<?php
	}
}