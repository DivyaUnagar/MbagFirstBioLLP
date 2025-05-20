<?php
if ( ! function_exists( 'cozy_addons_activation_admin_notice' ) ) :
	/**
	 * Displays an admin notice upon activation of the Cozy Blocks plugin.
	 *
	 * This notice welcomes the user to Cozy Blocks and promotes the plugin’s advanced features.
	 * It encourages the user to explore the 30+ advanced blocks and provides an option to upgrade
	 * to the premium version for additional benefits like ad-free editing, regular updates, and priority support.
	 *
	 * The notice is only shown under the following conditions:
	 * - The user is in the admin area (not network admin).
	 * - The user has the 'manage_options' capability.
	 * - The notice has not been dismissed (based on the 'cozy_dashboard_dismissed_notice' option).
	 *
	 * Links to explore Cozy Blocks and the Pro version are included, along with an image for visual appeal.
	 *
	 * @since 1.0.0
	 */
	function cozy_addons_activation_admin_notice() {
		if ( is_admin() ) {
			if ( is_network_admin() ) {
				return;
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			if ( get_option( 'cozy_dashboard_dismissed_notice' ) ) {
				return;
			} ?>
			<div class="notice notice-info is-dismissible cozy-addons-admin-notice">
				<div class="notice-content">
					<div class="notice-holder">
						<h4><?php esc_html_e( 'Welcome to the Cozy Blocks!', 'cozy-addons' ); ?></h4>
						<!-- plugins list need to be install -->
						<h1>
							<?php esc_html_e( 'Optimize your workflow effortlessly! Cozy Blocks pairs perfectly with our 50+ Advanced Blocks.', 'cozy-addons' ); ?>
						</h1>
						<p>
							<?php esc_html_e( 'Supercharge your website design with Cozy Blocks Premium! Access up to 50+ advanced blocks, enjoy regular updates, and receive priority support. Upgrade now for an ad-free, seamless editing experience! ', 'cozy-addons' ); ?> 🚀</p>
						<a href="<?php echo esc_url( admin_url() ); ?>admin.php?page=_cozy_companions" class="cozy-btns btns-more"><?php esc_html_e( 'Explore Cozy Blocks', 'cozy-addons' ); ?></a>
						<a href="https://cozythemes.com/cozy-addons/" class="cozy-btns btns-more checkout-btn" target="_blank"><?php esc_html_e( 'Checkout Pro', 'cozy-addons' ); ?></a>
					</div>
				</div>
				<div class="pluign-screen">
					<img src="<?php echo esc_url( COZY_ADDONS_PLUGIN_URL . '/admin/images/cozy-blocks-notice-image.png' ); ?>" />
				</div>
			</div>
			<?php
		}
	}

endif;
add_action( 'admin_notices', 'cozy_addons_activation_admin_notice' );

if ( ! function_exists( 'cozy_addons_invalid_theme_type_notice' ) ) :
	/**
	 * Displays an admin notice if the active theme is not a block theme (FSE-compatible).
	 *
	 * This notice informs the admin that Cozy Blocks is designed for Full Site Editing (FSE).
	 * It suggests switching to a block theme but also mentions that Elementor-compatible addons are available.
	 *
	 * The notice will only appear under the following conditions:
	 * - The current theme is not a block/FSE-compatible theme.
	 * - The user is in the admin area (not the network admin).
	 * - The user has the 'manage_options' capability.
	 * - The notice has not been dismissed via the 'cozy_addons_block_theme' option.
	 */
	function cozy_addons_invalid_theme_type_notice() {
		if ( is_admin() ) {
			if ( cozy_addons_is_block_theme() ) {
				return;
			}

			if ( is_network_admin() ) {
				return;
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			if ( get_option( 'cozy_addons_block_theme' ) ) {
				return;
			}
			?>
			<div class="fs-notice notice fs-has-title notice-warning is-dismissible cozy-blocks-admin-notice">
				<label class="fs-plugin-title"><?php esc_html_e( 'Cozy Blocks', 'cozy-addons' ); ?></label>
				<div class="notice-content">
					<div class="notice-holder">
						<p>
							<strong><?php esc_html_e( 'Uh-oh!', 'cozy-addons' ); ?></strong><?php esc_html_e( ' Cozy Blocks is tailored for Full Site Editing (FSE).', 'cozy-addons' ); ?>
						</p>
					</div>
				</div>
			</div>
			<?php
		}
	}
endif;
add_action( 'admin_notices', 'cozy_addons_invalid_theme_type_notice' );