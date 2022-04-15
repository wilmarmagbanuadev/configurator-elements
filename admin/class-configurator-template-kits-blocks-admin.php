<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Blank_Elements_Pro_Admin_Settings setup
 *
 */
class Blank_Elements_Pro_Admin_Settings {

	/**
	 * 
	 *
	 * @var Blank_Elements_Pro_Admin_Settings
	 */
	private static $_instance = null;

	const PACKAGE_TYPE = 'free';


	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self();
		}

		add_action( 'elementor/init', __CLASS__ . '::blankelements_admin_scripts', 0 );
		add_action( 'wp_ajax_blankelements_save_as_favourite', __CLASS__ . '::mark_as_favourite' );

		return self::$_instance;
	}


	public static function blankelements_admin_scripts() {
		add_action( 'elementor/editor/after_enqueue_styles', __CLASS__ . '::blankelements_admin_enqueue_scripts' );
	}

	/**
	 * Enqueue admin scripts
	 *
	 */
	public static function blankelements_admin_enqueue_scripts( $hook ) {

		wp_register_style('blankelements-admin-style', Configurator_Template_Kits_Blocks_URL . 'assets/css/style.css',[], Configurator_Template_Kits_Blocks_VERSION );

		wp_enqueue_style( 'blankelements-admin-style' );

	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'blankelements_posttype' ] );
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 50 );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_filter( 'admin_body_class', [ $this, 'blank_admin_body_class' ] );		
		add_action('admin_init', [ $this, 'blankelements_register_options' ] );
	}

	public function blankelements_register_options() {
		// get plugin options settings
	
		$options = $this->blankelements_get_options_settings();
		
		// loop over settings
		foreach( $options['settings'] as $setting ):
		
			// register this setting
			register_setting($options['group'], $setting);
			
		endforeach;
	}

	public function blankelements_get_options_settings() {
		// setup our return data
		$settings = array( 
			'group'=>'blank-elements-pro-options',
			'settings'=>array(
				'blank-elements-pro',

			),
		);
		
		// return option data
		return $settings;
	}

	/**
	 * Script for Elementor Pro full site editing support.
	 *
	 * @since 1.4.0
	 *
	 * @return void
	 */
	public function register_blankelements_pro_script() {
		$ids_array = [
			[
				'id'    => get_blankelements_pro_header_id(),
				'value' => 'Header',
			],
			[
				'id'    => get_blankelements_pro_footer_id(),
				'value' => 'Footer',
			],
		];

		wp_enqueue_script( 'blankelements-elementor-pro-compatibility', Configurator_Template_Kits_Blocks_URL . 'inc/js/blankelements-elementor-pro-compatibility.js', [ 'jquery' ], BLANK_ELEMENTS_PRO_VERSION, true );

		wp_localize_script(
			'blankelements-elementor-pro-compatibility',
			'blankelements_admin',
			[
				'ids_array' => wp_json_encode( $ids_array ),
			]
		);
	}


	/**
	 * Register Post type for header footer templates
	 */
	public function blankelements_posttype() {
		$labels = [
			'name'               => __( 'Configurator Elements', 'blank-elements-pro' ),
			'singular_name'      => __( 'Configurator Elements', 'blank-elements-pro' ),
			'menu_name'          => __( 'Configurator Elements', 'blank-elements-pro' ),
			'name_admin_bar'     => __( 'Configurator Elements', 'blank-elements-pro' ),
			'add_new'            => __( 'Add New', 'blank-elements-pro' ),
			'add_new_item'       => __( 'Add New Template', 'blank-elements-pro' ),
			'new_item'           => __( 'New Template', 'blank-elements-pro' ),
			'edit_item'          => __( 'Edit Template', 'blank-elements-pro' ),
			'view_item'          => __( 'View Template', 'blank-elements-pro' ),
			'all_items'          => __( 'All Templates', 'blank-elements-pro' ),
			'search_items'       => __( 'Search Templates', 'blank-elements-pro' ),
			'parent_item_colon'  => __( 'Parent Templates:', 'blank-elements-pro' ),
			'not_found'          => __( 'No Templates found.', 'blank-elements-pro' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'blank-elements-pro' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-editor-kitchensink',
			'supports'            => [ 'title', 'thumbnail', 'elementor' ],
		];

		register_post_type( 'blank_elements', $args );
	}

    public static function key(){
        return 'configurator-elements';
    }	

	/**
	 * Register the admin menu.
	 *
	 * @since  1.0.0
	 * @since  1.0.1
	 *     
	 */
	public function register_admin_menu() {
		$menu_icon = Configurator_Template_Kits_Blocks_URL . 'assets/images/configurator-icon.png';
		add_menu_page(
            esc_html__( 'Configurator Elements', 'blank-elements-pro' ),
            esc_html__( 'Configurator Elements', 'blank-elements-pro' ),
            'manage_options',
            self::key(),
            [$this, 'register_admin_screen__settings'],
            $menu_icon
        );

        $blank_elements_options = get_option( 'blank-elements-pro', array() );

        $module_list = isset( $blank_elements_options["module-list"] ) ? $blank_elements_options["module-list"] : '';

    if(!empty($module_list)) {
        if($module_list[0] == 'header-footer') {
	        add_submenu_page( 
	        	self::key(), 
	        	esc_html__( 'All Templates', 'blank-elements-pro' ), 
	        	esc_html__( 'All Templates', 'blank-elements-pro' ), 
	            'manage_options',
	        	'edit.php?post_type=blank_elements'
			);
    	}
    }

	// add_submenu_page( 
    // 	self::key(), 
    // 	esc_html__( 'License', 'blank-elements-pro' ), 
    // 	esc_html__( 'License', 'blank-elements-pro' ), 
    //     'manage_options',
    //     self::key().'-license',
    // 	[$this, 'register_admin_license_settings']
	// );

    	$support_url = 'https://configurator.wpconfigurator.com/support/';	
	add_submenu_page( 
		self::key(), 
		esc_html__( 'Support', 'blank-elements-pro' ), 
		esc_html__( 'Support', 'blank-elements-pro' ), 
		'manage_options',
		$support_url
	);
		
	}


    public function register_admin_screen__settings(){
        include Configurator_Template_Kits_Blocks_INCLUDES_PATH . 'configurator-template-kits-blocks-admin-screen.php';
	}

    public function register_admin_license_settings(){
        include Configurator_Template_Kits_Blocks_INCLUDES_PATH . 'configurator-template-kits-blocks-license-screen.php';
	}

    public function blank_admin_body_class( $classes ) {
    	$screen = get_current_screen();
    	if($screen->base == 'toplevel_page_configurator-elements' || $screen->base == 'blank-elements_page_blankelementspro-license' ) {
	    	$classes .= ' blank_panel ';
	 	}
	    return $classes;

	}	

    /* Loading the page in the elementor edit screen */
	function load_canvas_template( $single_template ) {

		global $post;

		if ( 'blank_elements' == $post->post_type ) {

			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	public static function mark_as_favourite() {
		
		check_admin_referer( 'elemenitfy_ajax_nonce', 'security' );
		
		if( is_user_logged_in() && ! empty( $_REQUEST['template_id'] ) ) {
			$template_id         = $_REQUEST['template_id'];
			$user_id 	         = get_current_user_id();
			$favourite_templates = get_user_meta( $user_id, 'blankelements_favourites_templates', true );
			if( empty( $favourite_templates ) ) {
				$favourite_templates = array();
			}
			$favourite_acton     = ! empty( $_REQUEST['favourite_acton'] ) ? $_REQUEST['favourite_acton'] : 'do_favourite';
			if( 'add_to_favourite' === $favourite_acton ) {
				if( array_search( $template_id, $favourite_templates ) === false ) {
					$favourite_templates[] = $template_id;
				}
			} else if( 'remove_from_favourite' === $favourite_acton ) {
				if ( ( $template_index = array_search( $template_id, $favourite_templates ) ) !== false ) {
					unset( $favourite_templates[ $template_index ] );
				}
			}
			update_user_meta( $user_id, 'blankelements_favourites_templates', $favourite_templates );
			wp_send_json_success();
		}
	}

	public static function default_widgets($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		$cf7    = is_plugin_active( 'contact-form-7/wp-contact-form-7.php' );
		$default_list = [
			'breadcrumbs', // This should match the name of the folder located inside the Modules folder - Your widget/element name!
			'button',
			//'counter',need to rework
			//'countdown',need to rework
            'contact-form-seven',
            'heading',
            'navigation',
            'posts',
            'site-logo',
            'site-title',
            'slider',
            'testimonial',		
		];
		//check if cf7 is installed or active
		if(!$cf7){
			//unset($default_list[4]);
			$default_list = array_diff($default_list, array("contact-form-seven"));
		}
		return $default_list;
	}

	
	//single shop page
	public static function product_page_style($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'style1'=>['style1',Configurator_Template_Kits_Blocks_URL . 'assets/images/style1.jpg'], 
			'style2'=>['style2',Configurator_Template_Kits_Blocks_URL . 'assets/images/style2.jpg'], 
			'style3'=>['style3',Configurator_Template_Kits_Blocks_URL . 'assets/images/style3.jpg'], 
		];
		
		return $default_list;
	}
	
	public static function display_breadcrumb($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'show', 
			'hide', 
		];
		
		return $default_list;
	}
	public static function related_products($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'show', 
			'hide', 
		];
		
		return $default_list;
	}
	
	
	public static function default_modules($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		$default_list = [
			'header-footer',
		];
        
		return $default_list;
	}


	//shop page

	public static function shop_page_style($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'2', 
			'3', 
			'4',
			'6',  
		];
		
		return $default_list;
	}
	public static function product_per_page($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'product_per_page', 

		];
		
		return $default_list;
	}
	public static function display_pagination($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'show', 
			'hide', 
		];
		
		return $default_list;
	}


	//advance
	public static function advanced_f($package = null){
		$package = ($package != null) ? $package : self::PACKAGE_TYPE;
		
		$default_list = [
			'a m p',			 
		];
		
		return $default_list;
	}


	public function input($input_options){
        $defaults = [
            'type' => null,
            'name' => '',
            'value' => '',
            'class' => '',
            'label' => '',
            'info' => '',
            'options' => [],
        ];
        $input_options = array_merge($defaults, $input_options);
        //d($input_options);
        if(file_exists(Configurator_Template_Kits_Blocks_PATH . '/controls/settings/' . $input_options['type'] . '.php')){
            extract($input_options);
            include Configurator_Template_Kits_Blocks_PATH . 'controls/settings/' . $input_options['type'] . '.php';
        }
    }

    public static function strify($str){
        return strtolower(preg_replace("/[^A-Za-z0-9]/", "__", $str));
    }

}

Blank_Elements_Pro_Admin_Settings::instance();