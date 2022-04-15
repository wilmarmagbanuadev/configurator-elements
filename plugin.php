<?php
namespace BlankElementsPro;

use Elementor\Utils;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {	exit; } // Exit if accessed directly

/**
 * Main class pro_plugin
 */
class Pro_Plugin {

	/**
	 * @var Pro_Plugin
	 */
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	/**
	 * @var array
	 */
	private $_localize_settings = [];

	/**
	 * @return string
	 */
	public function get_version() {
		return Configurator_Template_Kits_Blocks_VERSION;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'configurator-template-kits-blocks' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'configurator-template-kits-blocks' ), '1.0.0' );
	}

	/**
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function _includes() {
		require Configurator_Template_Kits_Blocks_PATH . 'admin/class-configurator-template-kits-blocks-admin.php';
		require Configurator_Template_Kits_Blocks_PATH . 'includes/modules-manager.php';
		require Configurator_Template_Kits_Blocks_PATH . 'classes/class-posts-helper.php';
	}

	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$filename = strtolower(
			preg_replace(
				[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
				[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
				$class
			)
		);
		$filename = Configurator_Template_Kits_Blocks_PATH . $filename . '.php';

		if ( is_readable( $filename ) ) {
			include( $filename );
		}
	}

	public function get_localize_settings() {
		return $this->_localize_settings;
	}

	public function add_localize_settings( $setting_key, $setting_value = null ) {
		if ( is_array( $setting_key ) ) {
			$this->_localize_settings = array_replace_recursive( $this->_localize_settings, $setting_key );

			return;
		}

		if ( ! is_array( $setting_value ) || ! isset( $this->_localize_settings[ $setting_key ] ) || ! is_array( $this->_localize_settings[ $setting_key ] ) ) {
			$this->_localize_settings[ $setting_key ] = $setting_value;

			return;
		}

		$this->_localize_settings[ $setting_key ] = array_replace_recursive( $this->_localize_settings[ $setting_key ], $setting_value );
	}

	public function enqueue_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style(
			'odometer',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/odometer/odometer-theme-default.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
        
        wp_enqueue_style(
			'blank-slick',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/slick/slick.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
        
        wp_enqueue_style(
			'blank-font-css',
			Configurator_Template_Kits_Blocks_URL . 'assets/fonts/flaticon.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
        
		wp_enqueue_style(
			'blank-elements-pro',
			Configurator_Template_Kits_Blocks_URL . 'assets/css/frontend.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
		wp_enqueue_style(
			'video-slider',
			Configurator_Template_Kits_Blocks_URL . 'assets/css/video-slider.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
	}

	public function enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        
        wp_register_script(
			'waypoints',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/waypoints/waypoints' . $suffix . '.js',
			[
				'jquery',
			],
			'4.0.1',
			true
		);

		wp_register_script(
			'odometer',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/odometer/odometer.min.js',
			[
				'jquery',
			],
			'0.4.8',
			true
		);
        
        wp_register_script(
			'instafeed',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/instafeed/instafeed.min.js',
			[
				'jquery',
			],
			'1.4.1',
			true
		);
        
        wp_register_script(
			'blank-slick',
			Configurator_Template_Kits_Blocks_URL . 'assets/lib/slick/slick.min.js',
			[
				'jquery',
			],
			'1.8.1',
			true
		);
        
        wp_register_script(
			'selectFx',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/selectFx.js',
			[
				'jquery',
			],
			'1.0.0',
			true
		);
        
        wp_register_script(
			'blank-posts-js',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/blank-posts.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
        
        wp_register_script(
			'blank-portfolio-js',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/blank-portfolio.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);        
        
        wp_register_script(
			'blank-cookie-lib',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/js_cookie.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
        
        wp_register_script(
			'blank-countdown',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/blank-countdown.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
        
        wp_register_script(
			'blank-mini-cart-js',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/frontend-mini-cart.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
        
		wp_register_script(
			'blank-js',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/frontend.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
		wp_register_script(
			'video-slider-js',
			Configurator_Template_Kits_Blocks_URL . 'assets/js/video-slider.js',
			[
				'jquery',
			],
			Pro_Plugin::instance()->get_version(),
			true
		);
		wp_register_script(
			'jquery2x',
			'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js',
			'2.2.4',
			true
		);
		wp_localize_script(
			'blank-js',
			'BlankElementsFrontendConfig', // This is used in the js file to group all of your scripts together
			[
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'blank-js' ),
			]
		);
	}

	public function enqueue_panel_scripts() {}

	public function enqueue_panel_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}

	public function enqueue_admin_styles() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
        
		wp_enqueue_style(
			'blank-elements-framework',
			Configurator_Template_Kits_Blocks_URL . 'assets/css/framework.css',
			[],
			Pro_Plugin::instance()->get_version()
		);
	}

	public function elementor_init() {
		$this->_modules_manager = new Manager();

		// Add element category in panel
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'configurator-template-kits-blocks-widgets', // This is the name of your addon's category and will be used to group your widgets/elements in the Edit sidebar pane!
			[
				'title' => __( 'Configurator Elements', 'configurator-template-kits-blocks' ), // The title of your modules category - keep it simple and short!
				'icon' => 'font',
			],
			1
		);
	}

	protected function add_actions() {
		add_action( 'elementor/init', [ $this, 'elementor_init' ] );

		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_scripts' ], 998 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 998 );
		add_action( 'admin_enqueue_scripts', [$this, 'enqueue_admin_styles'] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Pro_Plugin constructor.
	 */
	private function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );

		$this->_includes();
		$this->add_actions();
	}
	
}

if ( ! defined( 'BLANK_ELEMENTS_TESTS' ) ) {
	// In tests we run the instance manually.
	Pro_Plugin::instance();
}
