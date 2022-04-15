<?php

use Elementor\Core\Editor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class Pro_Template_Library {
    private $dir;
    private $url;

	public static $instance = null;

    public function __construct(){

        // get current directory path.
        $this->dir = dirname(__FILE__) . '/';

        // get current module's url.
        $this->url = trailingslashit(plugin_dir_url( __FILE__ ));

        // enqueue editor js for elementor.
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ), 1);

        // print views and tab variables on footer.
        add_action( 'elementor/editor/footer', array($this, 'admin_inline_js') );
        add_action( 'elementor/editor/footer', array( $this, 'print_views' ) );

        // enqueue editor css.
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

        // enqueue modal's preview css.
        add_action( 'elementor/preview/enqueue_styles', array( $this, 'preview_styles' ) );

        // call library handler.
        include $this->dir . 'manager/lib-handler.php';
    }

    public function editor_scripts(){
		wp_enqueue_script( 
			'blankelements-library-editor-script', 
			$this->url . 'assets/js/editor.js', 
			array('jquery', 'underscore', 'backbone-marionette',), 
			Configurator_Template_Kits_Blocks_VERSION,
			true
		);
		$user_id 	         = get_current_user_id();
		$favourite_templates = get_user_meta( $user_id, 'blankelements_favourites_templates', true );
		if( empty( $favourite_templates ) ) {
			$favourite_templates = array();
		}
		$blankelements_js_data  = array(
			'security' => wp_create_nonce( 'elemenitfy_ajax_nonce' ),
			'favourite_templates' => array_values( $favourite_templates ),
		);
		wp_localize_script( 'blankelements-library-editor-script', 'blankelements_js_data', $blankelements_js_data );
	}

	public function editor_styles(){
		wp_enqueue_style( 'blankelements-library-editor-style', $this->url . 'assets/css/editor.css', array(), Configurator_Template_Kits_Blocks_VERSION );

		wp_enqueue_style( 'blankelements-fonts-preview', $this->url . 'assets/fonts/stylesheet.css', array(), Configurator_Template_Kits_Blocks_VERSION );
		
		wp_enqueue_style( 'font-awesome', $this->url . 'assets/fonts/font-awesome/css/font-awesome.css', array(), '4.6.3' );
		
	}

	public function preview_styles(){
		wp_enqueue_style( 'blankelements-library-preview-style', $this->url . 'assets/css/preview.css', array(), Configurator_Template_Kits_Blocks_VERSION );
	}

	public function admin_inline_js() { ?>
		<script type="text/javascript" >

		var BlankelementsLibData = {
			"libraryButton": "Elements Button",
			"modalRegions": {
				"modalHeader": ".dialog-header",
				"modalContent": ".dialog-message"
			},
			"tabs": {
				"blankelements_page": {
					"title": "Ready Pages",
					"data": [],
					"sources": ["blankelements_api"],
					"settings": {
						"show_title": true,
						"show_keywords": true
					}
				},
				"blankelements_hero": {
					"title": "Hero",
					"data": [],
					"sources": ["blankelements_api"],
					"settings": {
						"show_title": true,
						"show_keywords": true
					}
				},
				"blankelements_header": {
					"title": "Headers",
					"data": [],
					"sources": ["blankelements_api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				"blankelements_footer": {
					"title": "Footers",
					"data": [],
					"sources": ["blankelements_api"],
					"settings": {
						"show_title": false,
						"show_keywords": true
					}
				},
				// "blankelements_section": {
				// 	"title": "Sections",
				// 	"data": [],
				// 	"sources": ["blankelements_api"],
				// 	"settings": {
				// 		"show_title": false,
				// 		"show_keywords": true
				// 	}
				// },
				// "local": {
				// 	"title": "My Library",
				// 	"data": [],
				// 	"sources": ["blankelements-local"],
				// 	"settings": []
				// }
			},
			"defaultTab": "blankelements_page"
		};

		</script> <?php
	}

	public function print_views(){
		foreach ( glob( $this->dir . 'views/editor/*.php' ) as $file ) {
			$name = basename( $file, '.php' );
			ob_start();
			include $file;
			printf( '<script type="text/html" id="view-blankelements-%1$s">%2$s</script>', $name, ob_get_clean() );
		}
	}

    public static function instance() {
        if ( is_null( self::$instance ) ) {

            // Fire the class instance
            self::$instance = new self();
        }

        return self::$instance;
    }

}