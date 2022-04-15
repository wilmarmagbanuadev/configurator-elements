<?php
function cf7_template_kits_blocks_load_plugin() {
	if ( ! did_action( 'cf7/loaded' ) ) {
		add_action( 'admin_notices', 'cf7_fail_load' );
		return;
	}

	$cf7_version_required = '1.0.6';
	if ( ! version_compare( ELEMENTOR_VERSION, $cf7_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'cf7_fail_load_out_of_date' );
		return;
	}

	require_once Configurator_Template_Kits_Blocks_PATH . 'plugin.php';
}
add_action( 'plugins_loaded', 'cf7_template_kits_blocks_load_plugin' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function cf7_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'contact-form-7/wp-contact-form-7.php';

	if ( _is_cf7_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message  = '<p>' . __( 'Contact Form 7 is required in order to use Contact form element', 'configurator-template-kits-blocks' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Contact Form 7', 'configurator-template-kits-blocks' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=contact-form-7' ), 'install-plugin_contact-form-7' );

		$message  = '<p>' . __( 'Contact Form 7 is required in order to use Contact form element', 'configurator-template-kits-blocks' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Contact Form 7', 'configurator-template-kits-blocks' ) ) . '</p>';
	}

	echo '<div class="error"';
	echo (is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ))?"style=display:none":"style=display:block";
	//echo "style=display:block";
	echo '>';
	echo '<p>' . $message . '</p></div>';
}

function cf7_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'contact-form-7/wp-contact-form-7.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . __( 'Please Update Contact Form 7', 'configurator-template-kits-blocks' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Contact Form 7', 'configurator-template-kits-blocks' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}

if ( ! function_exists( '_is_cf7_installed' ) ) {

	function _is_cf7_installed() {
		$file_path         = 'contact-form-7/wp-contact-form-7.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}
