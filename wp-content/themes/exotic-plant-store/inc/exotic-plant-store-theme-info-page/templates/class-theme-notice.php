<?php
/**
 * Theme Info Page
 *
 * @package Exotic Plant Store
 */

namespace Exotic_Plant_Store;

use const DAY_IN_SECONDS;

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

new Exotic_Plant_Store_Theme_Notice();

class Exotic_Plant_Store_Theme_Notice {

	/** @var \WP_Theme */
	private $exotic_plant_store_theme;

	private $exotic_plant_store_url = 'https://www.themescarts.com/';

	/**
	 * Class construct.
	 */
	public function __construct() {
		$this->exotic_plant_store_theme = wp_get_theme();

		add_action( 'init', array( $this, 'handle_dismiss_notice' ) );

		if ( ! \get_transient( 'exotic_plant_store_notice_dismissed' ) ) {
			add_action( 'admin_notices', array( $this, 'exotic_plant_store_render_notice' ) );
		}

		add_action( 'switch_theme', array( $this, 'show_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'exotic_plant_store_enqueue_notice_assets' ) );
	}

	/**
	 * Delete notice on theme switch.
	 *
	 * @return void
	 */
	public function show_notice() {
		\delete_transient( 'exotic_plant_store_notice_dismissed' );
	}

	/**
	 * Enqueue admin styles and scripts.
	 */
	public function exotic_plant_store_enqueue_notice_assets() {
		wp_enqueue_style(
			'exotic-plant-store-theme-notice-css',
			get_template_directory_uri() . '/inc/exotic-plant-store-theme-info-page/css/theme-details.css',
			array(),
			'1.0.0'
		);

		wp_enqueue_script(
			'exotic-plant-store-theme-notice-js',
			get_template_directory_uri() . '/inc/exotic-plant-store-theme-info-page/js/theme-details.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		// Pass dynamic URL to JS
		wp_localize_script( 'exotic-plant-store-theme-notice-js', 'ExoticPlantsStoreTheme', array(
			'admin_url' => esc_url( admin_url( 'admin.php?page=themescarts' ) ),
		));
	}

	/**
	 * Render the admin notice.
	 */
	public function exotic_plant_store_render_notice() {
		?>
		<div id="exotic-plant-store-theme-notice" class="notice notice-info is-dismissible">
			<div class="exotic-plant-store-content-wrap">
				<div class="exotic-plant-store-notice-left">
					<?php
					$this->exotic_plant_store_render_title();
					$this->exotic_plant_store_render_content();
					$this->exotic_plant_store_render_actions();
					?>
				</div>
				<div class="exotic-plant-store-notice-right">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr_e( 'Theme Notice Image', 'exotic-plant-store' ); ?>">
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render title.
	 */
	protected function exotic_plant_store_render_title() {
		?>
		<h2>
			<?php
			printf(
				// translators: %s is the theme name
				esc_html__( 'Thank you for installing %s!', 'exotic-plant-store' ),
				'<span>' . esc_html( $this->exotic_plant_store_theme->get( 'Name' ) ) . '</span>'
			);
			?>
		</h2>
		<?php
	}

	/**
	 * Render content.
	 */
	protected function exotic_plant_store_render_content() {
		$exotic_plant_store_link = '<a href="' . esc_url( $this->exotic_plant_store_url ) . '" target="_blank">' . esc_html__( 'ThemesCarts', 'exotic-plant-store' ) . '</a>';

		$exotic_plant_store_text = sprintf(
			/* translators: %1$s: Author Name, %2$s: Link */
			esc_html__( 'Unlock the full potential of your new store with %1$s! Get started today by visiting %2$s to explore a wide range of ready-to-use patterns and demo templates, designed to enhance your online shopping experience.', 'exotic-plant-store' ),
			esc_html__( 'ThemesCarts', 'exotic-plant-store' ),
			$exotic_plant_store_link
		);

		echo wp_kses_post( wpautop( $exotic_plant_store_text ) );
	}

	/**
	 * Render action buttons.
	 */
	protected function exotic_plant_store_render_actions() {
		$exotic_plant_store_more_info_url = admin_url( 'themes.php?page=exotic-plant-store-theme-info-page' );
		?>
		<div class="notice-actions">
			<a href="<?php echo esc_url( $exotic_plant_store_more_info_url ); ?>" id="btn-install-activate">
				<?php esc_html_e( 'Click Here For Theme Info', 'exotic-plant-store' ); ?>
			</a>
			<form class="exotic-plant-store-notice-dismiss-form" method="post">
				<button type="submit" name="notice-dismiss" value="true" id="btn-dismiss">
					<?php esc_html_e( 'Dismiss', 'exotic-plant-store' ); ?>
				</button>
			</form>
		</div>
		<?php
	}

	/**
	 * Handle dismiss action.
	 */
	public function handle_dismiss_notice() {
		if ( isset( $_POST['notice-dismiss'] ) ) {
			set_transient( 'exotic_plant_store_notice_dismissed', true, DAY_IN_SECONDS * 3 );
			wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
			exit;
		}
	}
}
?>