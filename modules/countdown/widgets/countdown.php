<?php namespace BlankElementsPro\Modules\Countdown\Widgets;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Countdown.
 */
class Countdown extends Widget_Base {

	public function get_name() {
		return 'blank-countdown';
	}

	public function get_title() {
		return __( 'Countdown', 'blank-elements' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}
    
	public function get_script_depends() {
		return array( 'blank-cookie-lib', 'blank-countdown' );
	}


	/**
	 * Register Countdown controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore 

		// Content Tab.
		$this->register_countdown_general_controls();
		$this->register_after_countdown_expire_controls();
		$this->register_countdown_label_controls();
		$this->register_countdown_style_controls();

		$this->register_style_controls();
		$this->register_digits_style_controls();
		$this->register_label_style_controls();
		$this->register_message_style_controls();
	}


	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_general_controls() {

		$this->start_controls_section(
			'countdown_content',
			array(
				'label' => __( 'General', 'blank-elements' ),
			)
		);

		$this->add_control(
			'countdown_type',
			array(
				'label'   => __( 'Type', 'blank-elements' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'fixed'     => __( 'Fixed Timer', 'blank-elements' ),
					'evergreen' => __( 'Evergreen Timer', 'blank-elements' ),
					'recurring' => __( 'Recurring Timer', 'blank-elements' ),
				),
				'default' => 'fixed',
			)
		);

		$this->add_control(
			'due_date',
			array(
				'label'       => __( 'Due Date and Time', 'blank-elements' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => gmdate( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) ) ),
				/* translators: %s: Time zone. */
				'description' => sprintf( __( 'Date set according to your timezone: %s.', 'blank-elements' ), Utils::get_timezone_string() ),
				'condition'   => array(
					'countdown_type' => array( 'fixed' ),
				),
				'label_block' => false,
			)
		);

		$this->add_control(
			'start_date',
			array(
				'label'       => __( 'Start Date and Time', 'blank-elements' ),
				'description' => __( 'Select the date & time when you want to make your countdown timer go live on your site.', 'blank-elements' ),
				'type'        => Controls_Manager::DATE_TIME,
				'label_block' => false,
				'default'     => gmdate( 'Y-m-d H:i' ),
				'condition'   => array(
					'countdown_type' => 'recurring',
				),
			)
		);

		$this->add_control(
			'evg_days',
			array(
				'label'     => __( 'Days', 'blank-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => array(
					'active' => true,
				),
				'min'       => '0',
				'default'   => '1',
				'condition' => array(
					'countdown_type' => array( 'evergreen', 'recurring' ),
				),

			)
		);

		$this->add_control(
			'evg_hours',
			array(
				'label'     => __( 'Hours', 'blank-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'dynamic'   => array(
					'active' => true,
				),
				'min'       => '0',
				'max'       => '23',
				'default'   => '5',
				'condition' => array(
					'countdown_type' => array( 'evergreen', 'recurring' ),
				),
			)
		);

		$this->add_control(
			'evg_minutes',
			array(
				'label'       => __( 'Minutes', 'blank-elements' ),
				'description' => __( 'Set the above Days, Hours, Minutes fields for the amount of time you want the timer to display.', 'blank-elements' ),
				'type'        => Controls_Manager::NUMBER,
				'dynamic'     => array(
					'active' => true,
				),
				'min'         => '0',
				'max'         => '59',
				'default'     => '30',
				'condition'   => array(
					'countdown_type' => array( 'evergreen', 'recurring' ),
				),
			)
		);

		$this->add_control(
			'reset_days',
			array(
				'label'       => __( 'Repeat Timer after ( Days )', 'blank-elements' ),
				'description' => __( 'Note: This option will repeat the timer after sepcified number of days.', 'blank-elements' ),
				'type'        => Controls_Manager::NUMBER,
				'dynamic'     => array(
					'active' => true,
				),
				'min'         => '1',
				'default'     => '7',
				'condition'   => array(
					'countdown_type' => 'recurring',
				),
			)
		);

		$this->add_control(
			'display_days',
			array(
				'label'        => __( 'Display Days', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'blank-elements' ),
				'label_off'    => __( 'Hide', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'display_hours',
			array(
				'label'        => __( 'Display Hours', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'blank-elements' ),
				'label_off'    => __( 'Hide', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'display_minutes',
			array(
				'label'        => __( 'Display Minutes', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'blank-elements' ),
				'label_off'    => __( 'Hide', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'display_seconds',
			array(
				'label'        => __( 'Display Seconds', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'blank-elements' ),
				'label_off'    => __( 'Hide', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'reset_evergreen',
			array(
				'label'        => __( 'Reset Timer', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'blank-elements' ),
				'label_off'    => __( 'No', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'countdown_type' => 'evergreen',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Register After Expire Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_after_countdown_expire_controls() {

		$this->start_controls_section(
			'countdown_expire_actions',
			array(
				'label'      => __( 'Action after expire', 'blank-elements' ),
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'relation' => 'and',
							'terms'    => array(
								array(
									'name'     => 'countdown_type',
									'operator' => '==',
									'value'    => 'evergreen',
								),
								array(
									'name'     => 'reset_evergreen',
									'operator' => '!==',
									'value'    => 'yes',
								),
							),
						),
						array(
							'name'     => 'countdown_type',
							'operator' => '!==',
							'value'    => 'evergreen',
						),
					),
				),
			)
		);

		$this->add_control(
			'expire_actions',
			array(
				'label'       => __( 'Select Action', 'blank-elements' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'hide'         => __( 'Hide', 'blank-elements' ),
					'redirect'     => __( 'Redirect', 'blank-elements' ),
					'show_message' => __( 'Show Message', 'blank-elements' ),
					'none'         => __( 'None', 'blank-elements' ),
				),
				'label_block' => false,
				'default'     => 'hide',
			)
		);

		$this->add_control(
			'message_after_expire',
			array(
				'label'       => __( 'Message', 'blank-elements' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'condition'   => array(
					'expire_actions' => 'show_message',
				),
				'default'     => __( 'Sale has ended!!', 'blank-elements' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'expire_redirect_url',
			array(
				'label'         => __( 'Redirect URL', 'blank-elements' ),
				'type'          => Controls_Manager::URL,
				'label_block'   => true,
				'show_external' => false,
				'default'       => array(
					'url' => '#',
				),
				'condition'     => array(
					'expire_actions' => 'redirect',
				),
				'dynamic'       => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'preview_expire_message',
			array(
				'label'        => __( 'Preview after expire message', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'blank-elements' ),
				'label_off'    => __( 'No', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'expire_actions' => 'show_message',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register labels Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_label_controls() {

		$this->start_controls_section(
			'countdown_labels',
			array(
				'label' => __( 'Labels', 'blank-elements' ),
			)
		);

		$this->add_control(
			'display_timer_labels',
			array(
				'label'   => __( 'Display Labels', 'blank-elements' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => __( 'Default', 'blank-elements' ),
					'custom'  => __( 'Custom', 'blank-elements' ),
					'none'    => __( 'None', 'blank-elements' ),
				),
			)
		);

		$this->add_control(
			'custom_days',
			array(
				'label'       => __( 'Label for Days', 'blank-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Days', 'blank-elements' ),
				'condition'   => array(
					'display_timer_labels' => 'custom',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'custom_hours',
			array(
				'label'       => __( 'Label for Hours', 'blank-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Hours', 'blank-elements' ),
				'condition'   => array(
					'display_timer_labels' => 'custom',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'custom_minutes',
			array(
				'label'       => __( 'Label for Minutes', 'blank-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Minutes', 'blank-elements' ),
				'condition'   => array(
					'display_timer_labels' => 'custom',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'custom_seconds',
			array(
				'label'       => __( 'Label for Seconds', 'blank-elements' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => __( 'Seconds', 'blank-elements' ),
				'condition'   => array(
					'display_timer_labels' => 'custom',
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_countdown_style_controls() {

		$this->start_controls_section(
			'style',
			array(
				'label' => __( 'Layout', 'blank-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'countdown_style',
			array(
				'label'        => __( 'Select Style', 'blank-elements' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'square'  => 'Square',
					'circle'  => 'Circle',
					'rounded' => 'Rounded',
					'none'    => 'None',
				),
				'default'      => 'square',
				'prefix_class' => 'be-countdown-shape-',
			)
		);

		$this->add_control(
			'rounded_border_radius',
			array(
				'label'      => __( 'Border Radius', 'blank-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'condition'  => array(
					'countdown_style' => 'rounded',
				),
				'selectors'  => array(
					'{{WRAPPER}} .be-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'    => '10',
					'bottom' => '10',
					'left'   => '10',
					'right'  => '10',
					'unit'   => 'px',
				),
			)
		);

		$this->add_control(
			'countdown_separator',
			array(
				'label'        => __( 'Separator', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'blank-elements' ),
				'label_off'    => __( 'Disable', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'be-countdown-separator-wrapper-',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'countdown_separator_color',
			array(
				'label'     => __( 'Separator Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .be-countdown-wrapper .be-countdown-separator' => 'color:{{VALUE}};',
				),
				'condition' => array(
					'countdown_separator' => 'yes',
				),
			)
		);

		$this->add_control(
			'animation',
			array(
				'label'        => __( 'Flash Animation', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'blank-elements' ),
				'label_off'    => __( 'Disable', 'blank-elements' ),
				'return_value' => 'yes',
				'prefix_class' => 'be-countdown-anim-',
			)
		);

		$this->add_control(
			'start_animation',
			array(
				'label'     => __( 'Start Animation Before (Minutes)', 'blank-elements' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'condition' => array(
					'animation' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Countdown General Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_style_controls() {

		$this->start_controls_section(
			'countdown_timer_style',
			array(
				'label' => __( 'Countdown items', 'blank-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'size',
			array(
				'label'      => __( 'Container Width', 'blank-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 240,
					),
				),
				'default'    => array(
					'size' => '90',
					'unit' => 'px',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .be-countdown-items-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-countdown-show-message .be-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .be-preview-message .be-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .be-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-item-label'     => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-item'           => 'height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-shape-none .be-item' => 'height:calc({{SIZE}}{{UNIT}}*1.3);',
					'{{WRAPPER}}.be-countdown-shape-none .be-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-shape-none .be-item-label' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-border-none .be-item' => 'height:calc({{SIZE}}{{UNIT}}*1.3);',
					'{{WRAPPER}}.be-countdown-border-none .be-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-border-none .be-item-label' => 'width:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'countdown_style!' => array( 'circle' ),
				),
			)
		);

		$this->add_responsive_control(
			'bg_size',
			array(
				'label'      => __( 'Container Width ( PX )', 'blank-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 180,
					),
				),
				'default'    => array(
					'size' => '85',
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .be-item'           => 'padding: calc({{SIZE}}{{UNIT}}/4); height:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-border-none .be-item' => 'padding: calc({{SIZE}}{{UNIT}}/4); height:calc({{SIZE}}{{UNIT}}*1.5);',
					'{{WRAPPER}} .be-countdown-items-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-border-none .be-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.be-countdown-border-none .be-item-label' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-countdown-item' => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-item-label'     => 'width:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .be-countdown-show-message .be-countdown-items-wrapper' => 'max-width:100%;',
					'{{WRAPPER}} .be-preview-message .be-countdown-items-wrapper' => 'max-width:100%;',
				),
				'condition'  => array(
					'countdown_style' => 'circle',
				),
			)
		);

		$this->add_responsive_control(
			'distance_betn_countdown_items',
			array(
				'label'      => __( 'Spacing between items', 'blank-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'max' => 230,
						'min' => 0,
					),
					'%'  => array(
						'max' => 300,
						'min' => 0,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .be-item:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .be-item:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .be-item:last-of-type' => 'margin-right: 0px;',
					'(mobile){{WRAPPER}}.be-countdown-responsive-yes .be-item:not(:first-child)' => 'margin-left: 0;margin-top: calc( {{SIZE}}{{UNIT}} / 2 );',
					'(mobile){{WRAPPER}}.be-countdown-responsive-yes .be-item:not(:last-child)' => 'margin-right: 0;margin-bottom: calc( {{SIZE}}{{UNIT}} / 2 );',
				),
			)
		);

		$this->add_responsive_control(
			'distance_betn_items_and_labels',
			array(
				'label'      => __( 'Spacing between digits and labels', 'blank-elements' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'max' => 110,
						'min' => 0,
					),
					'%'  => array(
						'max' => 50,
						'min' => 0,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .be-countdown-wrapper .be-countdown-item' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'display_timer_labels' => array( 'default', 'custom' ),
				),
			)
		);

		$this->add_control(
			'items_background_color',
			array(
				'label'     => __( 'Background Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'default'   => '#f5f5f5',
				'selectors' => array(
					'{{WRAPPER}} .be-item' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.be-countdown-shape-none .be-item' => 'background-color:unset',
				),
				'condition' => array(
					'countdown_style!' => 'none',
				),
			)
		);

		$this->add_control(
			'items_border_style',
			array(
				'label'        => __( 'Border Style', 'blank-elements' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'solid',
				'options'      => array(
					'none'   => __( 'None', 'blank-elements' ),
					'solid'  => __( 'Solid', 'blank-elements' ),
					'double' => __( 'Double', 'blank-elements' ),
					'dotted' => __( 'Dotted', 'blank-elements' ),
					'dashed' => __( 'Dashed', 'blank-elements' ),
				),
				'selectors'    => array(
					'{{WRAPPER}} .be-item' => 'border-style: {{VALUE}};',
				),
				'prefix_class' => 'be-countdown-border-',
				'condition'    => array(
					'countdown_style!' => 'none',
				),
			)
		);

		$this->add_control(
			'items_border_color',
			array(
				'label'     => __( 'Border Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'default'   => '#eaeaea',
				'selectors' => array(
					'{{WRAPPER}} .be-item' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'items_border_style!' => 'none',
					'countdown_style!'    => 'none',
				),
			)
		);

		$this->add_control(
			'items_border_size',
			array(
				'label'      => __( 'Border Width', 'blank-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => '1',
					'bottom' => '1',
					'left'   => '1',
					'right'  => '1',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .be-item' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
				),
				'condition'  => array(
					'items_border_style!' => 'none',
					'countdown_style!'    => 'none',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => __( 'Padding', 'blank-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .be-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'responsive_support',
			array(
				'label'        => __( 'Responsive Support', 'blank-elements' ),
				'description'  => __( 'Enable this option to stack the Countdown items on mobile.', 'blank-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'blank-elements' ),
				'label_off'    => __( 'Off', 'blank-elements' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'prefix_class' => 'be-countdown-responsive-',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Digit Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_digits_style_controls() {

		$this->start_controls_section(
			'countdown_digits_style',
			array(
				'label' => __( 'Digits', 'blank-elements' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'digits_typography',
				'selector' => '{{WRAPPER}} .be-countdown-wrapper .be-countdown-item,{{WRAPPER}} .be-countdown-wrapper .be-countdown-separator',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'items_color',
			array(
				'label'     => __( 'Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'default'   => '#050054',
				'selectors' => array(
					'{{WRAPPER}} .be-countdown-item,{{WRAPPER}} .be-countdown-separator' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Register Digit Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_label_style_controls() {

		$this->start_controls_section(
			'countdown_labels_style',
			array(
				'label'     => __( 'Labels', 'blank-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'display_timer_labels!' => 'none',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'labels_typography',
				'selector' => '{{WRAPPER}} .be-item-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			)
		);

		$this->add_control(
			'labels_color',
			array(
				'label'     => __( 'Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'default'   => '#3d424d;',
				'selectors' => array(
					'{{WRAPPER}} .be-item-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Register Message Style Controls.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function register_message_style_controls() {

		$this->start_controls_section(
			'countdown_message_style',
			array(
				'label'     => __( 'Expire Message', 'blank-elements' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'expire_actions' => 'show_message',
				),
			)
		);

		$this->add_responsive_control(
			'message_align',
			array(
				'label'     => __( 'Alignment', 'blank-elements' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'blank-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'blank-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'blank-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .be-expire-message-wrapper' => 'text-align:{{VALUE}};',
				),
				'condition' => array(
					'expire_actions' => 'show_message',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'message_typography',
				'selector'  => '{{WRAPPER}} .be-expire-show-message',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => array(
					'expire_actions' => 'show_message',
				),
			)
		);

		$this->add_control(
			'message_color',
			array(
				'label'     => __( 'Color', 'blank-elements' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .be-expire-show-message' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'expire_actions' => 'show_message',
				),
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Display countdown labels
	 *
	 * @param array $settings specifies string for the time fraction.
	 * @since 1.14.0
	 * @access protected
	 */
	protected function total_interval( $settings ) {
		$total_time  = 0;
		$cnt_days    = empty( $settings['evg_days'] ) ? 0 : ( $settings['evg_days'] * 24 * 60 * 60 * 1000 );
		$cnt_hours   = empty( $settings['evg_hours'] ) ? 0 : ( $settings['evg_hours'] * 60 * 60 * 1000 );
		$cnt_minutes = empty( $settings['evg_minutes'] ) ? 0 : ( $settings['evg_minutes'] * 60 * 1000 );
		$total_time  = $cnt_days + $cnt_hours + $cnt_minutes;
		return $total_time;
	}

	/**
	 * Render output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.14.0
	 * @access protected
	 */
	protected function render() {
		$settings        = $this->get_settings_for_display();
		$id              = $this->get_id();
		$labels          = array( 'days', 'hours', 'minutes', 'seconds' );
		$length          = count( $labels );
		$edit_mode       = \Elementor\Plugin::instance()->editor->is_edit_mode();
		$data_attributes = array( 'data-countdown-type', 'data-timer-labels', 'data-animation' );
		$data_values     = array( $settings['countdown_type'], $settings['display_timer_labels'], $settings['start_animation'] );

		$this->add_render_attribute( 'countdown-wrapper', 'class', 'be-countdown-items-wrapper' );

		$this->add_render_attribute( 'countdown', 'class', array( 'be-countdown-wrapper', 'countdown-active' ) );

		$this->add_render_attribute( 'digits', 'class', 'be-countdown-item' );

		for ( $i = 0; $i < 3; $i++ ) {
			$this->add_render_attribute( 'countdown', $data_attributes[ $i ], $data_values[ $i ] );
		}

		if ( $edit_mode && 'yes' === $settings['preview_expire_message'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-preview-message' );
		}

		if ( 'custom' === $settings['display_timer_labels'] ) {
			for ( $i = 0; $i < $length; $i++ ) {
				$this->add_render_attribute( 'countdown', 'data-timer-' . $labels[ $i ], $settings[ 'custom_' . $labels[ $i ] ] );
			}
		}

		$due_date = $settings['due_date'];
		$gmt      = get_gmt_from_date( $due_date . ':00' );
		$due_date = strtotime( $gmt );

		if ( 'fixed' === $settings['countdown_type'] ) {
			$this->add_render_attribute( 'countdown', 'data-due-date', $due_date );
		} else {
			$this->add_render_attribute( 'countdown', 'data-evg-interval', $this->total_interval( $settings ) );
		}

		if ( 'recurring' === $settings['countdown_type'] ) {

			$reset_date      = $settings['start_date'];
			$reset_date_gmt  = get_gmt_from_date( $reset_date . ':00' );
			$reset_date_time = strtotime( $reset_date_gmt );
			$this->add_render_attribute( 'countdown', 'data-start-date', $reset_date_time );
			$this->add_render_attribute( 'countdown', 'data-reset-days', $settings['reset_days'] );
		}

		if ( 'redirect' === $settings['expire_actions'] ) {
			$this->add_render_attribute( 'countdown', 'data-redirect-url', $settings['expire_redirect_url']['url'] );
			$this->add_render_attribute( 'url', 'href', $settings['expire_redirect_url']['url'] );
		} elseif ( 'show_message' === $settings['expire_actions'] ) {
			$this->add_render_attribute( 'countdown', 'data-countdown-expire-message', $settings['preview_expire_message'] );
		}

		if ( 'evergreen' === $settings['countdown_type'] && 'yes' === $settings['reset_evergreen'] ) {

			$this->add_render_attribute( 'countdown', 'data-expire-action', 'reset' );
		} elseif ( 'evergreen' === $settings['countdown_type'] && 'yes' !== $settings['reset_evergreen'] ) {

			$this->add_render_attribute( 'countdown', 'data-expire-action', $settings['expire_actions'] );
		} elseif ( 'fixed' === $settings['countdown_type'] || 'recurring' === $settings['countdown_type'] ) {

			$this->add_render_attribute( 'countdown', 'data-expire-action', $settings['expire_actions'] );
		}

		if ( isset( $_COOKIE[ 'be-timer-distance-' . $id ] ) ) {
			if ( 'hide' === $settings['expire_actions'] && 0 > $_COOKIE[ 'be-timer-distance-' . $id ] && false === $edit_mode ) {
				$this->add_render_attribute( 'countdown', 'class', 'be-countdown-hide' );
			}
		}

		if ( 'none' === $settings['display_timer_labels'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-countdown-labels-hide' );
		}

		if ( 'yes' !== $settings['display_days'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-countdown-show-days-no' );
		}

		if ( 'yes' !== $settings['display_hours'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-countdown-show-hours-no' );
		}

		if ( 'yes' !== $settings['display_minutes'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-countdown-show-minutes-no' );
		}

		if ( 'yes' !== $settings['display_seconds'] ) {
			$this->add_render_attribute( 'countdown', 'class', 'be-countdown-show-seconds-no' );
		}

		?>		
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'countdown' ) ); ?>>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'countdown-wrapper' ) ); ?> >
					<?php for ( $i = 0; $i < $length; $i++ ) { ?>
						<div class="be-countdown-<?php echo esc_attr( $labels[ $i ] ); ?> be-item">
							<span id="<?php echo esc_attr( $labels[ $i ] ); ?>-wrapper-<?php echo esc_attr( $id ); ?>"<?php echo wp_kses_post( $this->get_render_attribute_string( 'digits' ) ); ?> >
								<?php if ( true === $edit_mode ) { ?>
									<?php echo esc_html_e( '00', 'blank-elements' ); ?>
								<?php } ?> 
							</span>
							<?php if ( 'none' !== $settings['display_timer_labels'] ) { ?>
								<span id="<?php echo esc_attr( $labels[ $i ] ); ?>-label-wrapper-<?php echo esc_attr( $id ); ?>" class='be-countdown-<?php echo esc_attr( $labels[ $i ] ); ?>-label-<?php echo esc_attr( $id ); ?> be-item-label'>
								</span>
							<?php } ?>
						</div>
						<?php if ( 'yes' === $settings['countdown_separator'] && $i < $length - 1 ) { ?>
							<div class="be-countdown-separator be-countdown-<?php echo esc_attr( $labels[ $i ] ); ?>-separator"> : </div>
						<?php } ?>
					<?php } ?>				
					<div class="be-expire-message-wrapper">
						<div class='be-expire-show-message'><?php echo wp_kses_post( $settings['message_after_expire'] ); ?></div>
					</div>				
			</div>
		</div>
		<?php
	}
}

