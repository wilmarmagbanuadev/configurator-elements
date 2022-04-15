<?php
namespace BlankElementsPro;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Manager {

	private $_modules = null;

	private function is_module_active( $module_id ) {
		$module_data = $this->get_module_data( $module_id );
		if ( $module_data['required'] ) {
			return true;
		}

		$options = get_option( 'blank_elements_active_modules', [] );
		if ( ! isset( $options[ $module_id ] ) ) {
			return $module_data['default_activation'];
		}

		return 'true' === $options[ $module_id ];
	}

	private function get_module_data( $module_id ) {
		return isset( $this->_modules[ $module_id ] ) ? $this->_modules[ $module_id ] : false;
	}

	public function __construct() {
				
		$blank_elements_options = get_option( 'blank-elements-pro', array() );

		if( empty( $blank_elements_options['widgets-list'] ) ) {
			return;
		}

		$active_widget_list = $blank_elements_options['widgets-list'];

		// Fetch all modules data
		foreach ( $active_widget_list as $module ) {
			if( file_exists( Configurator_Template_Kits_Blocks_MODULES_PATH . $module . '/module.php' ) ) {
			$this->_modules[ $module ] = require Configurator_Template_Kits_Blocks_MODULES_PATH . $module . '/module.info.php';
			}
		}
		if (is_array($this->_modules)){
			foreach ( $this->_modules as $module_id => $module_data ) {
				if ( ! $this->is_module_active( $module_id ) ) {
					continue;
				}

				$class_name = str_replace( '-', ' ', $module_id );
				$class_name = str_replace( ' ', '', ucwords( $class_name ) );
				$class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\Module';

				$class_name::instance();
			}
		}
	}
}