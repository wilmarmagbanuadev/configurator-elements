<?php
namespace BlankElementsPro\Modules\Navigation\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use \BlankElementsPro\Classes\Menu_Walker;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Navigation extends Widget_Base {
    
    /**
	 * Menu index.
	 *
	 * @access protected
	 * @var $nav_menu_index
	 */
	protected $nav_menu_index = 1;
	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-navigation';
	}

	public function get_title() {
		return __( 'Navigation', 'blank-elements-pro' );
	}

	public function get_icon() {
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}
    
    /**
	 * Retrieve the list of scripts the logo carousel widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
            'blank-js'
        ];
    }
    
    /**
	 * Retrieve the menu index.
	 *
	 * Used to get index of nav menu.
	 *
	 * @since 1.3.0
	 * @access protected
	 *
	 * @return string nav index.
	 */
	protected function get_nav_menu_index() {
		return $this->nav_menu_index++;
	}

	/**
	 * Retrieve the list of available menus.
	 *
	 * Used to get the list of available menus.
	 *
	 * @since 1.3.0
	 * @access private
	 *
	 * @return array get WordPress menus list.
	 */
	private function get_available_menus() {

		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	/**
	 * Check if the Elementor is updated.
	 *
	 * @since 1.3.0
	 *
	 * @return boolean if Elementor updated.
	 */
	public static function is_elementor_updated() {
		if ( class_exists( 'Elementor\Icons_Manager' ) ) {
			return true;
		} else {
			return false;
		}
	}


	
	/**
	 * Register Nav Menu controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->register_general_content_controls();
		$this->register_style_content_controls();
		$this->register_dropdown_content_controls();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_general_content_controls() {

		$this->start_controls_section(
			'section_menu',
			[
				'label' => __( 'Menu', 'blank-elements-pro' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'blank-elements-pro' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					/* translators: %s Nav menu URL */
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'blank-elements-pro' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: %s Nav menu URL */
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'blank-elements-pro' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'menu_last_item',
			[
				'label'   => __( 'Last Menu Item', 'blank-elements-pro' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'Default', 'blank-elements-pro' ),
					'cta'  => __( 'Button', 'blank-elements-pro' ),
				],
				'default' => 'none',
			]
		);

		$this->end_controls_section();

			$this->start_controls_section(
				'section_layout',
				[
					'label' => __( 'Layout', 'blank-elements-pro' ),
				]
			);

			$this->add_control(
				'layout',
				[
					'label'   => __( 'Layout', 'blank-elements-pro' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => __( 'Horizontal', 'blank-elements-pro' ),
						'vertical'   => __( 'Vertical', 'blank-elements-pro' ),
						'expandible' => __( 'Expanded', 'blank-elements-pro' ),
						'flyout'     => __( 'Flyout', 'blank-elements-pro' ),
					],
				]
			);

			$this->add_control(
				'navmenu_align',
				[
					'label'        => __( 'Alignment', 'blank-elements-pro' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => __( 'Left', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'  => [
							'title' => __( 'Center', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'   => [
							'title' => __( 'Right', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-right',
						],
						'justify' => [
							'title' => __( 'Justify', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-stretch',
						],
					],
					'default'      => 'left',
					'condition'    => [
						'layout' => [ 'horizontal', 'vertical' ],
					],
					'prefix_class' => 'be-nav-menu__align-',
				]
			);

			$this->add_control(
				'flyout_layout',
				[
					'label'     => __( 'Flyout Orientation', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'  => __( 'Left', 'blank-elements-pro' ),
						'right' => __( 'Right', 'blank-elements-pro' ),
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'flyout_type',
				[
					'label'       => __( 'Appear Effect', 'blank-elements-pro' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'normal',
					'label_block' => false,
					'options'     => [
						'normal' => __( 'Slide', 'blank-elements-pro' ),
						'push'   => __( 'Push', 'blank-elements-pro' ),
					],
					'render_type' => 'template',
					'condition'   => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_responsive_control(
				'hamburger_align',
				[
					'label'                => __( 'Hamburger Align', 'blank-elements-pro' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'center',
					'options'              => [
						'left'   => [
							'title' => __( 'Left', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors_dictionary' => [
						'left'   => 'margin-right: auto',
						'center' => 'margin: 0 auto',
						'right'  => 'margin-left: auto',
					],
					'selectors'            => [
						'{{WRAPPER}} .be-nav-menu__toggle,
						{{WRAPPER}} .be-nav-menu-icon' => '{{VALUE}}',
					],
					'default'              => 'center',
					'condition'            => [
						'layout' => [ 'expandible', 'flyout' ],
					],
					'label_block'          => false,
				]
			);

			$this->add_responsive_control(
				'hamburger_menu_align',
				[
					'label'        => __( 'Menu Items Align', 'blank-elements-pro' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'flex-start'    => [
							'title' => __( 'Left', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'        => [
							'title' => __( 'Center', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'      => [
							'title' => __( 'Right', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-right',
						],
						'space-between' => [
							'title' => __( 'Justify', 'blank-elements-pro' ),
							'icon'  => 'eicon-h-align-stretch',
						],
					],
					'default'      => 'space-between',
					'condition'    => [
						'layout' => [ 'expandible', 'flyout' ],
					],
					'selectors'    => [
						'{{WRAPPER}} li.menu-item a' => 'justify-content: {{VALUE}};',
						'{{WRAPPER}} li.elementor-button-wrapper' => 'text-align: {{VALUE}};',
						'{{WRAPPER}}.be-menu-item-flex-end li.elementor-button-wrapper' => 'text-align: right;',
					],
					'prefix_class' => 'be-menu-item-',
				]
			);

			$this->add_control(
				'submenu_icon',
				[
					'label'        => __( 'Submenu Icon', 'blank-elements-pro' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'arrow',
					'options'      => [
						'arrow'   => __( 'Arrows', 'blank-elements-pro' ),
						'plus'    => __( 'Plus Sign', 'blank-elements-pro' ),
						'classic' => __( 'Classic', 'blank-elements-pro' ),
					],
					'prefix_class' => 'be-submenu-icon-',
				]
			);

			$this->add_control(
				'submenu_animation',
				[
					'label'        => __( 'Submenu Animation', 'blank-elements-pro' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'none',
					'options'      => [
						'none'     => __( 'Default', 'blank-elements-pro' ),
						'slide_up' => __( 'Slide Up', 'blank-elements-pro' ),
					],
					'prefix_class' => 'be-submenu-animation-',
					'condition'    => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_control(
				'heading_responsive',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => __( 'Responsive', 'blank-elements-pro' ),
					'separator' => 'before',
					'condition' => [
						'layout' => [ 'horizontal', 'vertical' ],
					],
				]
			);

		$this->add_control(
			'dropdown',
			[
				'label'        => __( 'Breakpoint', 'blank-elements-pro' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tablet',
				'options'      => [
					'mobile' => __( 'Mobile (768px >)', 'blank-elements-pro' ),
					'tablet' => __( 'Tablet (1025px >)', 'blank-elements-pro' ),
					'none'   => __( 'None', 'blank-elements-pro' ),
				],
				'prefix_class' => 'be-nav-menu__breakpoint-',
				'condition'    => [
					'layout' => [ 'horizontal', 'vertical' ],
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'resp_align',
			[
				'label'                => __( 'Alignment', 'blank-elements-pro' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => __( 'Left', 'blank-elements-pro' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'              => 'center',
				'description'          => __( 'This is the alignement of menu icon on selected responsive breakpoints.', 'blank-elements-pro' ),
				'condition'            => [
					'layout'    => [ 'horizontal', 'vertical' ],
					'dropdown!' => 'none',
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .be-nav-menu__toggle' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'full_width_dropdown',
			[
				'label'        => __( 'Full Width', 'blank-elements-pro' ),
				'description'  => __( 'Enable this option to stretch the Sub Menu to Full Width.', 'blank-elements-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'blank-elements-pro' ),
				'label_off'    => __( 'No', 'blank-elements-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'dropdown!' => 'none',
					'layout!'   => 'flyout',
				],
				'render_type'  => 'template',
			]
		);

		if ( $this->is_elementor_updated() ) {
			$this->add_control(
				'dropdown_icon',
				[
					'label'       => __( 'Menu Icon', 'blank-elements-pro' ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => 'true',
					'default'     => [
						'value'   => 'fas fa-align-justify',
						'library' => 'fa-solid',
					],
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		} else {
			$this->add_control(
				'dropdown_icon',
				[
					'label'       => __( 'Icon', 'blank-elements-pro' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => 'true',
					'default'     => 'fa fa-align-justify',
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		}

		if ( $this->is_elementor_updated() ) {
			$this->add_control(
				'dropdown_close_icon',
				[
					'label'       => __( 'Close Icon', 'blank-elements-pro' ),
					'type'        => Controls_Manager::ICONS,
					'label_block' => 'true',
					'default'     => [
						'value'   => 'far fa-window-close',
						'library' => 'fa-regular',
					],
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		} else {
			$this->add_control(
				'dropdown_close_icon',
				[
					'label'       => __( 'Close Icon', 'blank-elements-pro' ),
					'type'        => Controls_Manager::ICON,
					'label_block' => 'true',
					'default'     => 'fa fa-close',
					'condition'   => [
						'dropdown!' => 'none',
					],
				]
			);
		}

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label'     => __( 'Main Menu', 'blank-elements-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'expandible',
				],
			]
		);

		$this->add_responsive_control(
			'width_flyout_menu_item',
			[
				'label'       => __( 'Flyout Box Width', 'blank-elements-pro' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'max' => 500,
						'min' => 100,
					],
				],
				'default'     => [
					'size' => 300,
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .be-flyout-wrapper .be-side' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .be-flyout-open.left'  => 'left: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .be-flyout-open.right' => 'right: -{{SIZE}}{{UNIT}}',
				],
				'condition'   => [
					'layout' => 'flyout',
				],
				'render_type' => 'template',
			]
		);

			$this->add_responsive_control(
				'padding_flyout_menu_item',
				[
					'label'     => __( 'Flyout Box Padding', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'default'   => [
						'size' => 30,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .be-flyout-content' => 'padding: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_menu_item',
				[
					'label'      => __( 'Horizontal Padding', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.be-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .menu-item a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 20px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-nav-menu__layout-vertical .menu-item ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 40px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-nav-menu__layout-vertical .menu-item ul ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 60px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-nav-menu__layout-vertical .menu-item ul ul ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 80px );padding-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_menu_item',
				[
					'label'      => __( 'Vertical Padding', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.be-menu-item, {{WRAPPER}} .menu-item a.be-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'menu_space_between',
				[
					'label'      => __( 'Space Between', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'body:not(.rtl) {{WRAPPER}} .be-nav-menu__layout-horizontal .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
						'body.rtl {{WRAPPER}} .be-nav-menu__layout-horizontal .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} nav:not(.be-nav-menu__layout-horizontal) .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'(tablet)body:not(.rtl) {{WRAPPER}}.be-nav-menu__breakpoint-tablet .be-nav-menu__layout-horizontal .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px',
						'(mobile)body:not(.rtl) {{WRAPPER}}.be-nav-menu__breakpoint-mobile .be-nav-menu__layout-horizontal .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-right: 0px',
						'(tablet)body {{WRAPPER}} nav.be-nav-menu__layout-vertical .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: 0px',
						'(mobile)body {{WRAPPER}} nav.be-nav-menu__layout-vertical .be-nav-menu > li.menu-item:not(:last-child)' => 'margin-bottom: 0px',
					],
					'condition'  => [
						'layout!' => 'expandible',
					],
				]
			);

			$this->add_responsive_control(
				'menu_row_space',
				[
					'label'      => __( 'Row Spacing', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'body:not(.rtl) {{WRAPPER}} .be-nav-menu__layout-horizontal .be-nav-menu > li.menu-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_responsive_control(
				'menu_top_space',
				[
					'label'      => __( 'Menu Item Top Spacing', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .be-flyout-wrapper .be-nav-menu > li.menu-item:first-child' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'bg_color_flyout',
				[
					'label'     => __( 'Background Color', 'blank-elements-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#FFFFFF',
					'selectors' => [
						'{{WRAPPER}} .be-flyout-content' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'layout' => 'flyout',
					],
				]
			);

			$this->add_control(
				'pointer',
				[
					'label'     => __( 'Link Hover Effect', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'        => __( 'None', 'blank-elements-pro' ),
						'underline'   => __( 'Underline', 'blank-elements-pro' ),
						'overline'    => __( 'Overline', 'blank-elements-pro' ),
						'double-line' => __( 'Double Line', 'blank-elements-pro' ),
						'framed'      => __( 'Framed', 'blank-elements-pro' ),
						'text'        => __( 'Text', 'blank-elements-pro' ),
					],
					'condition' => [
						'layout' => [ 'horizontal' ],
					],
				]
			);

		$this->add_control(
			'animation_line',
			[
				'label'     => __( 'Animation', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'     => 'Fade',
					'slide'    => 'Slide',
					'grow'     => 'Grow',
					'drop-in'  => 'Drop In',
					'drop-out' => 'Drop Out',
					'none'     => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label'     => __( 'Frame Animation', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'    => 'Fade',
					'grow'    => 'Grow',
					'shrink'  => 'Shrink',
					'draw'    => 'Draw',
					'corners' => 'Corners',
					'none'    => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label'     => __( 'Animation', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'grow',
				'options'   => [
					'grow'   => 'Grow',
					'shrink' => 'Shrink',
					'sink'   => 'Sink',
					'float'  => 'Float',
					'skew'   => 'Skew',
					'rotate' => 'Rotate',
					'none'   => 'None',
				],
				'condition' => [
					'layout'  => [ 'horizontal' ],
					'pointer' => 'text',
				],
			]
		);

		$this->add_control(
			'style_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'menu_typography',
				//'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'separator' => 'before',
				'selector'  => '{{WRAPPER}} a.be-menu-item, {{WRAPPER}} a.be-sub-menu-item',
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

				$this->start_controls_tab(
					'tab_menu_item_normal',
					[
						'label' => __( 'Normal', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'color_menu_item',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							// 'scheme'    => [
							// 	'type'  => Scheme_Color::get_type(),
							// 	'value' => Scheme_Color::COLOR_3,
							// ],
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item, {{WRAPPER}} .sub-menu a.be-sub-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item',
						[
							'label'     => __( 'Background Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item, {{WRAPPER}} .sub-menu, {{WRAPPER}} nav.be-dropdown, {{WRAPPER}} .be-dropdown-expandible' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_menu_item_hover',
					[
						'label' => __( 'Hover', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'color_menu_item_hover',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							// 'scheme'    => [
							// 	'type'  => Scheme_Color::get_type(),
							// 	'value' => Scheme_Color::COLOR_4,
							// ],
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item:hover,
								{{WRAPPER}} .sub-menu a.be-sub-menu-item:hover,
								{{WRAPPER}} .menu-item.current-menu-item a.be-menu-item,
								{{WRAPPER}} .menu-item a.be-menu-item.highlighted,
								{{WRAPPER}} .menu-item a.be-menu-item:focus' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item_hover',
						[
							'label'     => __( 'Background Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item:hover,
								{{WRAPPER}} .sub-menu a.be-sub-menu-item:hover,
								{{WRAPPER}} .menu-item.current-menu-item a.be-menu-item,
								{{WRAPPER}} .menu-item a.be-menu-item.highlighted,
								{{WRAPPER}} .menu-item a.be-menu-item:focus' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

					$this->add_control(
						'pointer_color_menu_item_hover',
						[
							'label'     => __( 'Link Hover Effect Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							// 'scheme'    => [
							// 	'type'  => Scheme_Color::get_type(),
							// 	'value' => Scheme_Color::COLOR_4,
							// ],
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .be-nav-menu-layout:not(.be-pointer__framed) .menu-item.parent a.be-menu-item:before,
								{{WRAPPER}} .be-nav-menu-layout:not(.be-pointer__framed) .menu-item.parent a.be-menu-item:after' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .be-nav-menu-layout:not(.be-pointer__framed) .menu-item.parent .sub-menu .be-has-submenu-container a:after' => 'background-color: unset',
								'{{WRAPPER}} .be-pointer__framed .menu-item.parent a.be-menu-item:before,
								{{WRAPPER}} .be-pointer__framed .menu-item.parent a.be-menu-item:after' => 'border-color: {{VALUE}}',
							],
							'condition' => [
								'pointer!' => [ 'none', 'text' ],
								'layout!'  => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_menu_item_active',
					[
						'label' => __( 'Active', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'color_menu_item_active',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item.current-menu-item a.be-menu-item,
								{{WRAPPER}} .menu-item.current-menu-ancestor a.be-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'bg_color_menu_item_active',
						[
							'label'     => __( 'Background Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item.current-menu-item a.be-menu-item,
								{{WRAPPER}} .menu-item.current-menu-ancestor a.be-menu-item' => 'background-color: {{VALUE}}',
							],
							'condition' => [
								'layout!' => 'flyout',
							],
						]
					);

					$this->add_control(
						'pointer_color_menu_item_active',
						[
							'label'     => __( 'Link Hover Effect Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .be-nav-menu:not(.be-pointer__framed) .menu-item.parent.current-menu-item a.be-menu-item:before,
								{{WRAPPER}} .be-nav-menu:not(.be-pointer__framed) .menu-item.parent.current-menu-item a.be-menu-item:after' => 'background-color: {{VALUE}}',
								'{{WRAPPER}} .be-nav-menu:not(.be-pointer__framed) .menu-item.parent .sub-menu .be-has-submenu-container a.current-menu-item:after' => 'background-color: unset',
								'{{WRAPPER}} .be-pointer__framed .menu-item.parent.current-menu-item a.be-menu-item:before,
								{{WRAPPER}} .be-pointer__framed .menu-item.parent.current-menu-item a.be-menu-item:after' => 'border-color: {{VALUE}}',
							],
							'condition' => [
								'pointer!' => [ 'none', 'text' ],
								'layout!'  => 'flyout',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Nav Menu General Controls.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function register_dropdown_content_controls() {

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label' => __( 'Dropdown', 'blank-elements-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'dropdown_description',
				[
					'raw'             => __( '<b>Note:</b> On desktop, below style options will apply to the submenu. On mobile, this will apply to the entire menu.', 'blank-elements-pro' ),
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
					'condition'       => [
						'layout!' => [
							'expandible',
							'flyout',
						],
					],
				]
			);

			$this->start_controls_tabs( 'tabs_dropdown_item_style' );

				$this->start_controls_tab(
					'tab_dropdown_item_normal',
					[
						'label' => __( 'Normal', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'color_dropdown_item',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .sub-menu a.be-sub-menu-item, 
								{{WRAPPER}} .elementor-menu-toggle,
								{{WRAPPER}} nav.be-dropdown li a.be-menu-item,
								{{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-sub-menu-item' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'background_color_dropdown_item',
						[
							'label'     => __( 'Background Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#fff',
							'selectors' => [
								'{{WRAPPER}} .sub-menu,
								{{WRAPPER}} nav.be-dropdown,
								{{WRAPPER}} nav.be-dropdown-expandible,
								{{WRAPPER}} nav.be-dropdown .menu-item a.be-menu-item,
								{{WRAPPER}} nav.be-dropdown .menu-item a.be-sub-menu-item' => 'background-color: {{VALUE}}',
							],
							'separator' => 'after',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_dropdown_item_hover',
					[
						'label' => __( 'Hover', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'color_dropdown_item_hover',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .sub-menu a.be-sub-menu-item:hover, 
								{{WRAPPER}} .elementor-menu-toggle:hover,
								{{WRAPPER}} nav.be-dropdown li a.be-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-sub-menu-item:hover' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'background_color_dropdown_item_hover',
						[
							'label'     => __( 'Background Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .sub-menu a.be-sub-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown li a.be-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item:hover,
								{{WRAPPER}} nav.be-dropdown-expandible li a.be-sub-menu-item:hover' => 'background-color: {{VALUE}}',
							],
							'separator' => 'after',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_dropdown_item_active',
					[
						'label' => __( 'Active', 'blank-elements-pro' ),
					]
				);

				$this->add_control(
					'color_dropdown_item_active',
					[
						'label'     => __( 'Text Color', 'blank-elements-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .sub-menu .menu-item.current-menu-item a.be-sub-menu-item.be-sub-menu-item-active,	
							{{WRAPPER}} nav.be-dropdown .menu-item.current-menu-item a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown .menu-item.current-menu-ancestor a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown .sub-menu .menu-item.current-menu-item a.be-sub-menu-item.be-sub-menu-item-active
							' => 'color: {{VALUE}}',

						],
					]
				);

				$this->add_control(
					'background_color_dropdown_item_active',
					[
						'label'     => __( 'Background Color', 'blank-elements-pro' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .sub-menu .menu-item.current-menu-item a.be-sub-menu-item.be-sub-menu-item-active,	
							{{WRAPPER}} nav.be-dropdown .menu-item.current-menu-item a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown .menu-item.current-menu-ancestor a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown .sub-menu .menu-item.current-menu-item a.be-sub-menu-item.be-sub-menu-item-active' => 'background-color: {{VALUE}}',
						],
						'separator' => 'after',
					]
				);

				$this->end_controls_tabs();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'dropdown_typography',
					//'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
					'separator' => 'before',
					'selector'  => '
							{{WRAPPER}} .sub-menu li a.be-sub-menu-item,
							{{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item,
							{{WRAPPER}} nav.be-dropdown li a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item,
							{{WRAPPER}} nav.be-dropdown-expandible li a.be-sub-menu-item',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'dropdown_border',
					'selector' => '{{WRAPPER}} nav.be-nav-menu__layout-horizontal .sub-menu, 
							{{WRAPPER}} nav:not(.be-nav-menu__layout-horizontal) .sub-menu.sub-menu-open,
							{{WRAPPER}} nav.be-dropdown,
						 	{{WRAPPER}} nav.be-dropdown-expandible',
				]
			);

			$this->add_responsive_control(
				'dropdown_border_radius',
				[
					'label'      => __( 'Border Radius', 'blank-elements-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .sub-menu'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .sub-menu li.menu-item:first-child' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};overflow:hidden;',
						'{{WRAPPER}} .sub-menu li.menu-item:last-child' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};overflow:hidden',
						'{{WRAPPER}} nav.be-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} nav.be-dropdown li.menu-item:first-child' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};overflow:hidden',
						'{{WRAPPER}} nav.be-dropdown li.menu-item:last-child' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};overflow:hidden',
						'{{WRAPPER}} nav.be-dropdown-expandible' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} nav.be-dropdown-expandible li.menu-item:first-child' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};overflow:hidden',
						'{{WRAPPER}} nav.be-dropdown-expandible li.menu-item:last-child' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};overflow:hidden',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'dropdown_box_shadow',
					'exclude'   => [
						'box_shadow_position',
					],
					'selector'  => '{{WRAPPER}} .be-nav-menu .sub-menu,
								{{WRAPPER}} nav.be-dropdown,
						 		{{WRAPPER}} nav.be-dropdown-expandible',
					'separator' => 'after',
				]
			);

			$this->add_responsive_control(
				'width_dropdown_item',
				[
					'label'     => __( 'Dropdown Width (px)', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'default'   => [
						'size' => '220',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} ul.sub-menu' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'layout' => 'horizontal',
					],
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_dropdown_item',
				[
					'label'      => __( 'Horizontal Padding', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'selectors'  => [
						'{{WRAPPER}} .sub-menu li a.be-sub-menu-item,
						{{WRAPPER}} nav.be-dropdown li a.be-menu-item,
						{{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} nav.be-dropdown-expandible a.be-sub-menu-item,
						{{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 20px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-dropdown .menu-item ul ul a.be-sub-menu-item,
						{{WRAPPER}} .be-dropdown-expandible .menu-item ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 40px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-dropdown .menu-item ul ul ul a.be-sub-menu-item,
						{{WRAPPER}} .be-dropdown-expandible .menu-item ul ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 60px );padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .be-dropdown .menu-item ul ul ul ul a.be-sub-menu-item,
						{{WRAPPER}} .be-dropdown-expandible .menu-item ul ul ul ul a.be-sub-menu-item' => 'padding-left: calc( {{SIZE}}{{UNIT}} + 80px );padding-right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_dropdown_item',
				[
					'label'      => __( 'Vertical Padding', 'blank-elements-pro' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default'    => [
						'size' => 15,
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sub-menu a.be-sub-menu-item,
						 {{WRAPPER}} nav.be-dropdown li a.be-menu-item,
						 {{WRAPPER}} nav.be-dropdown li a.be-sub-menu-item,
						 {{WRAPPER}} nav.be-dropdown-expandible li a.be-menu-item,
						 {{WRAPPER}} nav.be-dropdown-expandible li a.be-sub-menu-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'distance_from_menu',
				[
					'label'     => __( 'Top Distance', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} nav.be-nav-menu__layout-horizontal ul.sub-menu, {{WRAPPER}} nav.be-nav-menu__layout-expandible.menu-is-active' => 'margin-top: {{SIZE}}px;',
						'{{WRAPPER}} .be-dropdown.menu-is-active' => 'margin-top: {{SIZE}}px;',
					],
					'condition' => [
						'layout' => [ 'horizontal', 'vertical', 'expandible' ],
					],
				]
			);

			$this->add_control(
				'heading_dropdown_divider',
				[
					'label'     => __( 'Divider', 'blank-elements-pro' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'dropdown_divider_border',
				[
					'label'       => __( 'Border Style', 'blank-elements-pro' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'solid',
					'label_block' => false,
					'options'     => [
						'none'   => __( 'None', 'blank-elements-pro' ),
						'solid'  => __( 'Solid', 'blank-elements-pro' ),
						'double' => __( 'Double', 'blank-elements-pro' ),
						'dotted' => __( 'Dotted', 'blank-elements-pro' ),
						'dashed' => __( 'Dashed', 'blank-elements-pro' ),
					],
					'selectors'   => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.be-dropdown li.menu-item:not(:last-child),
						{{WRAPPER}} nav.be-dropdown-expandible li.menu-item:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'divider_border_color',
				[
					'label'     => __( 'Border Color', 'blank-elements-pro' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#c4c4c4',
					'selectors' => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.be-dropdown li.menu-item:not(:last-child),
						{{WRAPPER}} nav.be-dropdown-expandible li.menu-item:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);

			$this->add_control(
				'dropdown_divider_width',
				[
					'label'     => __( 'Border Width', 'blank-elements-pro' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'default'   => [
						'size' => '1',
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .sub-menu li.menu-item:not(:last-child), 
						{{WRAPPER}} nav.be-dropdown li.menu-item:not(:last-child),
						{{WRAPPER}} nav.be-dropdown-expandible li.menu-item:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'dropdown_divider_border!' => 'none',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_toggle',
			[
				'label' => __( 'Menu Trigger & Close Icon', 'blank-elements-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'toggle_style_normal',
			[
				'label' => __( 'Normal', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.be-nav-menu-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_background_color',
			[
				'label'     => __( 'Background Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .be-nav-menu-icon' => 'background-color: {{VALUE}}; padding: 0.35em;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_hover',
			[
				'label' => __( 'Hover', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'toggle_hover_color',
			[
				'label'     => __( 'Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.be-nav-menu-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'toggle_hover_background_color',
			[
				'label'     => __( 'Background Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .be-nav-menu-icon:hover' => 'background-color: {{VALUE}}; padding: 0.35em;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_size',
			[
				'label'     => __( 'Icon Size', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .be-nav-menu-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'toggle_border_width',
			[
				'label'     => __( 'Border Width', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .be-nav-menu-icon' => 'border-width: {{SIZE}}{{UNIT}}; padding: 0.35em;',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius',
			[
				'label'      => __( 'Border Radius', 'blank-elements-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .be-nav-menu-icon' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'close_color_flyout',
			[
				'label'     => __( 'Close Icon Color', 'blank-elements-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .be-flyout-close' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout' => 'flyout',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'close_flyout_size',
			[
				'label'     => __( 'Close Icon Size', 'blank-elements-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .be-flyout-close' => 'height: {{SIZE}}px; width: {{SIZE}}px; font-size: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
				'condition' => [
					'layout' => 'flyout',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'style_button',
			[
				'label'     => __( 'Button', 'blank-elements-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'menu_last_item' => 'cta',
				],
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'all_typography',
					'label'    => __( 'Typography', 'blank-elements-pro' ),
					//'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button',
				]
			);
			$this->add_responsive_control(
				'padding',
				[
					'label'      => __( 'Padding', 'blank-elements-pro' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .menu-item a.be-menu-item.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs( '_button_style' );

				$this->start_controls_tab(
					'_button_normal',
					[
						'label' => __( 'Normal', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'all_text_color',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item.elementor-button' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_color',
							'label'          => __( 'Background Color', 'blank-elements-pro' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button',
							'fields_options' => [
								'color' => [
									// 'scheme' => [
									// 	'type'  => Scheme_Color::get_type(),
									// 	'value' => Scheme_Color::COLOR_4,
									// ],
								],
							],
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'     => 'all_border',
							'label'    => __( 'Border', 'blank-elements-pro' ),
							'selector' => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button',
						]
					);

					$this->add_control(
						'all_border_radius',
						[
							'label'      => __( 'Border Radius', 'blank-elements-pro' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [ 'px', '%' ],
							'selectors'  => [
								'{{WRAPPER}} .menu-item a.be-menu-item.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'     => 'all_button_box_shadow',
							'selector' => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button',
						]
					);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'all_button_hover',
					[
						'label' => __( 'Hover', 'blank-elements-pro' ),
					]
				);

					$this->add_control(
						'all_hover_color',
						[
							'label'     => __( 'Text Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item.elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'all_background_hover_color',
							'label'          => __( 'Background Color', 'blank-elements-pro' ),
							'types'          => [ 'classic', 'gradient' ],
							'selector'       => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button:hover',
							'fields_options' => [
								'color' => [
									// 'scheme' => [
									// 	'type'  => Scheme_Color::get_type(),
									// 	'value' => Scheme_Color::COLOR_4,
									// ],
								],
							],
						]
					);

					$this->add_control(
						'all_border_hover_color',
						[
							'label'     => __( 'Border Hover Color', 'blank-elements-pro' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '',
							'selectors' => [
								'{{WRAPPER}} .menu-item a.be-menu-item.elementor-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'all_button_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .menu-item a.be-menu-item.elementor-button:hover',
							'separator' => 'after',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render Nav Menu output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$args = [
			'echo'        => false,
			'menu'        => $settings['menu'],
			'menu_class'  => 'be-nav-menu',
			'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
			'walker'      => new Menu_Walker,
		];

		$menu_html = wp_nav_menu( $args );

		if ( 'flyout' === $settings['layout'] ) {

			$this->add_render_attribute( 'be-flyout', 'class', 'be-flyout-wrapper' );
			if ( 'cta' === $settings['menu_last_item'] ) {

				$this->add_render_attribute( 'be-flyout', 'data-last-item', $settings['menu_last_item'] );
			}

			?>
			<div class="be-nav-menu__toggle elementor-clickable be-flyout-trigger" tabindex="0">
					<div class="be-nav-menu-icon">
						<?php if ( $this->is_elementor_updated() ) { ?>
							<i class="<?php echo esc_attr( $settings['dropdown_icon']['value'] ); ?>" aria-hidden="true" tabindex="0"></i>
						<?php } else { ?>
							<i class="<?php echo esc_attr( $settings['dropdown_icon'] ); ?>" aria-hidden="true" tabindex="0"></i>
						<?php } ?>
					</div>
				</div>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'be-flyout' ) ); ?> >
				<div class="be-flyout-overlay elementor-clickable"></div>
				<div class="be-flyout-container">
					<div id="be-flyout-content-id-<?php echo esc_attr( $this->get_id() ); ?>" class="be-side be-flyout-<?php echo esc_attr( $settings['flyout_layout'] ); ?> be-flyout-open" data-width="<?php echo esc_attr( $settings['width_flyout_menu_item']['size'] ); ?>" data-layout="<?php echo wp_kses_post( $settings['flyout_layout'] ); ?>" data-flyout-type="<?php echo wp_kses_post( $settings['flyout_type'] ); ?>">
						<div class="be-flyout-content push">						
							<nav <?php echo wp_kses_post( $this->get_render_attribute_string( 'be-nav-menu' ) ); ?>><?php echo $menu_html; ?></nav>
							<div class="elementor-clickable be-flyout-close" tabindex="0">
								<?php if ( $this->is_elementor_updated() ) { ?>
									<i class="<?php echo esc_attr( $settings['dropdown_close_icon']['value'] ); ?>" aria-hidden="true"></i>
								<?php } else { ?>
									<i class="<?php echo esc_attr( $settings['dropdown_close_icon'] ); ?>" aria-hidden="true"></i>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>				
			<?php
		} else {
			$this->add_render_attribute(
				'be-main-menu',
				'class',
				[
					'be-nav-menu',
					'be-layout-' . $settings['layout'],
				]
			);

			$this->add_render_attribute( 'be-main-menu', 'class', 'be-nav-menu-layout' );

			$this->add_render_attribute( 'be-main-menu', 'class', $settings['layout'] );

			$this->add_render_attribute( 'be-main-menu', 'data-layout', $settings['layout'] );

			if ( 'cta' === $settings['menu_last_item'] ) {

				$this->add_render_attribute( 'be-main-menu', 'data-last-item', $settings['menu_last_item'] );
			}

			if ( $settings['pointer'] ) {
				if ( 'horizontal' === $settings['layout'] || 'vertical' === $settings['layout'] ) {
					$this->add_render_attribute( 'be-main-menu', 'class', 'be-pointer__' . $settings['pointer'] );

					if ( in_array( $settings['pointer'], [ 'double-line', 'underline', 'overline' ], true ) ) {
						$key = 'animation_line';
						$this->add_render_attribute( 'be-main-menu', 'class', 'be-animation__' . $settings[ $key ] );
					} elseif ( 'framed' === $settings['pointer'] || 'text' === $settings['pointer'] ) {
						$key = 'animation_' . $settings['pointer'];
						$this->add_render_attribute( 'be-main-menu', 'class', 'be-animation__' . $settings[ $key ] );
					}
				}
			}

			if ( 'expandible' === $settings['layout'] ) {
				$this->add_render_attribute( 'be-nav-menu', 'class', 'be-dropdown-expandible' );
			}

			$this->add_render_attribute(
				'be-nav-menu',
				'class',
				[
					'be-nav-menu__layout-' . $settings['layout'],
					'be-nav-menu__submenu-' . $settings['submenu_icon'],
				]
			);

			$this->add_render_attribute( 'be-nav-menu', 'data-toggle-icon', $settings['dropdown_icon'] );

			$this->add_render_attribute( 'be-nav-menu', 'data-close-icon', $settings['dropdown_close_icon'] );

			$this->add_render_attribute( 'be-nav-menu', 'data-full-width', $settings['full_width_dropdown'] );

			?>
			<div <?php echo $this->get_render_attribute_string( 'be-main-menu' ); ?>>
				<div class="be-nav-menu__toggle elementor-clickable">
					<div class="be-nav-menu-icon">
						<?php
						if ( $this->is_elementor_updated() ) {
							$dropdown_icon_value = isset( $settings['dropdown_icon']['value'] ) ? $settings['dropdown_icon']['value'] : '';
							?>
							<i class="<?php echo esc_attr( $dropdown_icon_value ); ?>" aria-hidden="true" tabindex="0"></i>
						<?php } else { ?>
							<i class="<?php echo esc_attr( $settings['dropdown_icon'] ); ?>" aria-hidden="true" tabindex="0"></i>
						<?php } ?>
					</div>
				</div>
				<nav <?php echo $this->get_render_attribute_string( 'be-nav-menu' ); ?>><?php echo $menu_html; ?></nav>              
			</div>
			<?php
		}
	}
}