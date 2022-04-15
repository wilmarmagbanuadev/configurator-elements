<?php

/**
 * Main Blankelements Header Footer Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Blankelements_Pro_Extension_Init {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.7.3';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 * 
	 *
	 * @var Blankelements Header Footer Extension The single instance of the class.
	 */
	private static $elementor_instance;

	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Blankelements Header Footer Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

		$this->includes();

		add_action('admin_footer', [$this, 'admin_form_view']);

	if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
		self::$elementor_instance = Elementor\Plugin::instance();
		}

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'front_enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [$this, 'enqueue_styles'] );
		add_action( 'admin_enqueue_scripts', [$this, 'enqueue_scripts'], 100 );		

		add_action('admin_print_scripts', [$this, 'admin_js']);		

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'blank-elements-pro' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		require Configurator_Template_Kits_Blocks_INCLUDES_PATH . '/custom-post-links.php';

		require Configurator_Template_Kits_Blocks_INCLUDES_PATH . '/connector.php';

		Pro_Custom_Post_links::instance();

		Pro_Connector::instance();


		include_once Configurator_Template_Kits_Blocks_INCLUDES_PATH . '/custom-post-screen.php';

		require_once Configurator_Template_Kits_Blocks_PATH . 'library/library.php';

		Pro_Template_Library::instance();

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		//add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

		add_action('elementor/editor/after_enqueue_styles', array( $this, 'template_lib_content' ) );

	}

	public function template_lib_content() { 
		ob_start(); ?>
		<div class="template_lib_modal">
			<?php include 'template-lib-modal.php'; ?>
		</div>
		<?php
			$output = ob_get_contents();
			ob_end_clean();
	
			echo $output;
	}


	public function admin_form_view(){
		$screen = get_current_screen();
		if($screen->id == 'edit-blank_elements'){
			include_once Configurator_Template_Kits_Blocks_PATH . 'admin/modal-box.php';
		}
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'blankelements-framework', Configurator_Template_Kits_Blocks_URL . 'assets/css/framework.css', false, Configurator_Template_Kits_Blocks_VERSION );
		wp_enqueue_style( 'blankelements-fonts', Configurator_Template_Kits_Blocks_URL . 'assets/fonts/stylesheet.css', false, Configurator_Template_Kits_Blocks_VERSION );
		$screen = get_current_screen();
		if($screen->id == 'edit-blank_elements'){
			wp_enqueue_style( 'select2', Configurator_Template_Kits_Blocks_URL . 'assets/css/select2.min.css', false, Configurator_Template_Kits_Blocks_VERSION );
			wp_enqueue_style( 'blankelements-menu-admin-style', Configurator_Template_Kits_Blocks_URL . 'assets/css/admin-style.css', false, Configurator_Template_Kits_Blocks_VERSION );
		}

	}

	public function enqueue_scripts() {
		$screen = get_current_screen();
		if($screen->id == 'edit-blank_elements'){
			wp_enqueue_script( 'select2', Configurator_Template_Kits_Blocks_URL . 'assets/js/select2.min.js', array( 'jquery'), true, Configurator_Template_Kits_Blocks_VERSION );
			wp_enqueue_script( 'blankelements-menu-admin-script', Configurator_Template_Kits_Blocks_URL . 'assets/js/admin-script.js', array( 'jquery'), true, Configurator_Template_Kits_Blocks_VERSION );
		}

		wp_enqueue_script( 'blankelements-coreui', Configurator_Template_Kits_Blocks_URL . 'assets/js/core-ui.min.js', array( 'jquery'), true, Configurator_Template_Kits_Blocks_VERSION );

		wp_register_script('blankelements-admin-script', Configurator_Template_Kits_Blocks_URL . 'assets/js/custom-script.js',array( 'jquery'), true, Configurator_Template_Kits_Blocks_VERSION );

		wp_enqueue_script( 'blankelements-admin-script' );

	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'blank-elements-pro' ),
			'<strong>' . esc_html__( 'Configurator Elements', 'blank-elements-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'blank-elements-pro' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'blank-elements-pro' ),
			'<strong>' . esc_html__( 'Configurator Elements', 'blank-elements-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'blank-elements-pro' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
			'<strong>' . esc_html__( 'Configurator Elements', 'blank-elements-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'blank-elements-pro' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {


		$blank_elements_options = get_option( 'blank-elements-pro', false );
		
		if( false === $blank_elements_options ) {
			$blank_elements_options = $this->get_default_options();
		}

		if( empty( $blank_elements_options['widgets-list'] ) ) {
			return;
		}

		$active_widget_list = $blank_elements_options['widgets-list'];

		foreach( $active_widget_list as $widget ) {
			if( file_exists( Configurator_Template_Kits_Blocks_PATH . '/modules/' . $widget . '/module.php' ) ) {
				require_once( Configurator_Template_Kits_Blocks_PATH . '/modules/' . $widget . '/module.php' );
			}
		}

	}

	/**
	 * Get default plugin options 
	 *
	 * @since 1.0.0
	 * 
	 * @access public
	*/
	public function get_default_options() {
		
		$default_options = array();
		
		$default_widgets = Blank_Elements_Pro_Admin_Settings::default_widgets();
		if( ! empty( $default_widgets ) ) {
			$default_options['widgets-list'] = $default_widgets;
		}
		
		$default_module = Blank_Elements_Pro_Admin_Settings::default_modules();
		if( ! empty( $default_module ) ) {
			$default_options['module-list'] = $default_module;
		}

		//single shop page
		$default_layout = Configurator_Template_Kits_Blocks_Admin_Settings::product_page_style();
		if( ! empty( $default_layout ) ) {
			$default_options['product_page_style-list'] = $default_layout;
		}
		
		$breadcrumb_option = Configurator_Template_Kits_Blocks_Admin_Settings::display_breadcrumb();
		if( ! empty( $breadcrumb_option ) ) {
			$default_options['display_breadcrumb-option'] = $breadcrumb_option;
		}
		$related_products_option = Configurator_Template_Kits_Blocks_Admin_Settings::related_products();
		if( ! empty( $related_products_option ) ) {
			$default_options['related_products-option'] = $related_products_option;
		}

			//shop page
		$shop_page_style = Configurator_Template_Kits_Blocks_Admin_Settings::shop_page_style();
		if( ! empty( $shop_page_style ) ) {
			$default_options['shop_page_style'] = $shop_page_style;
		}
		$product_per_page = Configurator_Template_Kits_Blocks_Admin_Settings::product_per_page();
		if( ! empty( $product_per_page ) ) {
			$default_options['product_per_page-count'] = $product_per_page;
		}

		$display_pagination = Configurator_Template_Kits_Blocks_Admin_Settings::display_pagination();
		if( ! empty( $display_pagination ) ) {
			$default_options['display_pagination'] = $display_pagination;
		}
		

		//advanced
		$advanced_f = Configurator_Template_Kits_Blocks_Admin_Settings::advanced_f();
		if( ! empty( $advanced_f ) ) {
			$default_options['advanced_f'] = $advanced_f;
		}

		
		return $default_options;
	}

	/**
	 * Loads the globally required files for the plugin.
	 */
	public function includes() {
		//require_once Configurator_Template_Kits_Blocks_PATH . 'admin/class-blankelements-admin.php';

		require_once Configurator_Template_Kits_Blocks_INCLUDES_PATH . '/configurator-template-kits-blocks-functions.php';

	}

	public function common_js(){
		ob_start(); ?>

        //console.log(window.blankelements);

		var blankelements = {
            resturl: '<?php echo get_rest_url() . 'blankelements/v1/'; ?>',
        }

        //console.log(blankelements);
		<?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function admin_js(){
        echo "<script type='text/javascript'>\n";
        echo $this->common_js();
        echo "\n</script>";
    }


	/**
	 * Enqueue styles and scripts.
	 */
	public function front_enqueue_styles() {
		wp_enqueue_style( 'blankelements-style', Configurator_Template_Kits_Blocks_URL . 'assets/css/blankelements-style.css', [], Configurator_Template_Kits_Blocks_VERSION );

		if ( class_exists( '\Elementor\Plugin' ) ) {
			$elementor = \Elementor\Plugin::instance();
			$elementor->frontend->enqueue_styles();
		}

		if ( class_exists( '\ElementorPro\Plugin' ) ) {
			$elementor_pro = \ElementorPro\Plugin::instance();
			$elementor_pro->enqueue_styles();
		}

		if ( class_exists( 'Connector' ) ) {
		$activate = new Pro_Connector();
		$template = $activate -> template_ids();
		$instance = $activate -> instance();

		if($instance->header_template != null){
            render_pro_elementor_content_css($instance->header_template);
        }

        if($instance->footer_template != null){
            render_pro_elementor_content_css($instance->footer_template);
        }
       } 
        
	}

}

Blankelements_Pro_Extension_Init::instance();