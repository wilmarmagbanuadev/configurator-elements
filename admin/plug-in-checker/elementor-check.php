<?php
function configurator_template_kits_blocks_load_plugin() {
	load_plugin_textdomain( 'configurator-template-kits-blocks' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'configurator_template_kits_blocks_fail_load' );
		return;
	}

	$elementor_version_required = '1.0.6';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'configurator_template_kits_blocks_fail_load_out_of_date' );
		return;
	}

	require_once Configurator_Template_Kits_Blocks_PATH . 'plugin.php';
}
add_action( 'plugins_loaded', 'configurator_template_kits_blocks_load_plugin' );

/**
 * Show in WP Dashboard notice about the plugin is not activated.
 *
 * @since 1.0.0
 *
 * @return void
 */
function configurator_template_kits_blocks_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );

		$message  = '<p>' . __( 'Configurator Elements is not working because you need to activate the Elementor plugin.', 'configurator-template-kits-blocks' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'configurator-template-kits-blocks' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );

		$message  = '<p>' . __( 'Configurator Elements is not working because you need to install the Elementor plugin', 'configurator-template-kits-blocks' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'configurator-template-kits-blocks' ) ) . '</p>';
	}

	echo '<div class="error"><p>' . $message . '</p></div>';
}

function configurator_template_kits_blocks_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message      = '<p>' . __( 'Configurator Elements is not working because you are using an old version of Elementor.', 'configurator-template-kits-blocks' ) . '</p>';
	$message     .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'configurator-template-kits-blocks' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}

if ( ! function_exists( '_is_elementor_installed' ) ) {

	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}
