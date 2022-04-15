<?php
namespace BlankElementsPro\Modules\Testimonial\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Testimonials_Carousel extends Widget_Base {
    
    public function get_name() {
        return 'blank-testimonials-carousel';
    }

    public function get_title() {
		return __( 'Testimonials Carousel', 'blank-elements-pro' );
	}

    public function get_categories() {
        return [ 'configurator-template-kits-blocks-widgets'];
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }
    
    public function get_script_depends() {
        return [
            'blank-slick',
            'blank-js'
        ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_slides',
            [
                'label'             => __( 'Slides', 'blank-elements-pro' ),
            ]
        );
        
        $repeater = new Repeater();
        
        $repeater->add_control(
			'content',
			[
				'label'                 => __( 'Content', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'                 => __( 'Image', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::MEDIA,
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
			]
		);

		$repeater->add_control(
			'name',
			[
				'label'                 => __( 'Name', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => __( 'John Doe', 'blank-elements-pro' ),
			]
		);

		$repeater->add_control(
			'location',
			[
				'label'                 => __( 'Location', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::TEXT,
				'default'               => __( 'California', 'blank-elements-pro' ),
			]
		);
        
        $this->add_control(
            'testimonials',
            [
                'label'                 => '',
                'type'                  => Controls_Manager::REPEATER,
                'default'               => [
                    [
                        'name'      => __( 'John Doe', 'blank-elements-pro' ),
                        'location'  => __( 'California', 'blank-elements-pro' ),
                        'content'   => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
                        'image'     => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name'      => __( 'John Doe', 'blank-elements-pro' ),
                        'location'  => __( 'California', 'blank-elements-pro' ),
                        'content'   => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
                        'image'     => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name'      => __( 'John Doe', 'blank-elements-pro' ),
                        'location'  => __( 'California', 'blank-elements-pro' ),
                        'content'   => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
                        'image'     => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name'      => __( 'John Doe', 'blank-elements-pro' ),
                        'location'  => __( 'California', 'blank-elements-pro' ),
                        'content'   => __( 'I am slide content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
                        'image'     => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                ],
                'fields'                => array_values( $repeater->get_controls() ),
                'title_field'           => '{{{ name }}}',
            ]
        );
        
        $this->end_controls_section();

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => __( 'Additional Options', 'blank-elements-pro' ),
			]
		);
        
        $this->add_responsive_control(
            'slides_per_view',
            [
                'label'                 => __( 'Visible Items', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 3 ],
                'tablet_default'        => [ 'size' => 2 ],
                'mobile_default'        => [ 'size' => 1 ],
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'frontend_available'    => true,
            ]
        );
        
        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Yes', 'blank-elements-pro' ),
                'label_off'             => __( 'No', 'blank-elements-pro' ),
                'return_value'          => 'yes',
				'frontend_available'    => true,
            ]
        );

		$this->add_control(
			'dots',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( 'Dots', 'blank-elements-pro' ),
				'default' => 'no',
				'label_off' => __( 'Hide', 'blank-elements-pro' ),
				'label_on' => __( 'Show', 'blank-elements-pro' ),
				'frontend_available' => true,
				'prefix_class' => 'elementor-dots-',
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Transition Duration', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'blank-elements-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Infinite Loop', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'blank-elements-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

        /**
         * STYLE TAB
         * -------------------------------------------------
         * Add all style related settings below
         */

        /**
         * Style Tab: Slide
         */
        $this->start_controls_section(
            'section_slide_style',
            [
                'label'             => __( 'Slide', 'blank-elements-pro' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'slides_spacing',
            [
                'label'             => __( 'Spacing', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonials-carousel .slick-slide' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blank-testimonials-carousel .slick-list' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'slide_border_normal',
				'label'             => __( 'Border', 'blank-elements-pro' ),
				'placeholder'       => '1px',
				'default'           => '',
				'selector'          => '{{WRAPPER}} .blank-slide-content',
			]
		);
        
        $this->add_control(
			'slide_border_radius',
			[
				'label'             => __( 'Border Radius', 'blank-elements-pro' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'selectors'         => [
					'{{WRAPPER}} .blank-slide-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'slide_padding',
			[
				'label'      => __( 'Padding', 'blank-elements-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blank-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_image_style',
            [
                'label'             => __( 'Image', 'blank-elements-pro' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'image_margin_bottom',
            [
                'label'             => __( 'Spacing', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
				'default'           => [
                    'size' => 20,
                    'unit' => 'px',
                ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonial-photo' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_content_style',
            [
                'label'             => __( 'Content', 'blank-elements-pro' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'tabs_content_style' );

        $this->start_controls_tab(
            'slider_button_normal',
            [
                'label'             => __( 'Normal', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
            'content_color',
            [
                'label'             => __( 'Text Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonial-content' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'content_typography',
                'label'             => __( 'Typography', 'blank-elements-pro' ),
                'selector'          => '{{WRAPPER}} .blank-testimonial-content',
            ]
        );
        
        $this->add_responsive_control(
            'content_margin_bottom',
            [
                'label'             => __( 'Margin Bottom', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
				'default'           => [
                    'size' => 40,
                    'unit' => 'px',
                ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .blank-slide-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'name_heading',
            [
                'label'                 => __( 'Name', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'name_color',
            [
                'label'             => __( 'Text Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonial-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'name_typography',
                'label'             => __( 'Typography', 'blank-elements-pro' ),
                'selector'          => '{{WRAPPER}} .blank-testimonial-name',
            ]
        );
        
        $this->add_responsive_control(
            'name_margin_bottom',
            [
                'label'             => __( 'Margin Bottom', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
				'default'           => [
                    'size' => 5,
                    'unit' => 'px',
                ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonial-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'location_heading',
            [
                'label'                 => __( 'Location', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'location_color',
            [
                'label'             => __( 'Text Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-testimonial-location' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'location_typography',
                'label'             => __( 'Typography', 'blank-elements-pro' ),
                'selector'          => '{{WRAPPER}} .blank-testimonial-location',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'slider_button_hover',
            [
                'label'             => __( 'Hover', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'slider_background_color_hover',
            [
                'label'             => __( 'Background Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .slide-inner:hover .blank-testimonial-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => __( 'Arrows', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_control(
			'arrow',
			[
				'label'                 => __( 'Choose Arrow', 'power-pack' ),
				'type'                  => Controls_Manager::ICON,
				'include'               => [
					'fa fa-angle-right',
                    'fa fa-angle-double-right',
                    'fa fa-chevron-right',
                    'fa fa-chevron-circle-right',
                    'fa fa-arrow-right',
                    'fa fa-long-arrow-right',
                    'fa fa-caret-right',
                    'fa fa-caret-square-o-right',
                    'fa fa-arrow-circle-right',
                    'fa fa-arrow-circle-o-right',
                    'fa fa-toggle-right',
                    'fa fa-hand-o-right',
				],
				'default'               => 'fa fa-arrow-right',
				'frontend_available'    => true,
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);
        
        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => __( 'Arrows Size', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-slider-arrow' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'arrows_position',
            [
                'label'                 => __( 'Align Arrows', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .blank-arrow-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .blank-arrow-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => __( 'Normal', 'power-pack' ),
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ff1744',
                'selectors'             => [
                    '{{WRAPPER}} .blank-slider-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .blank-slider-arrow' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-slider-arrow',
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-slider-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => __( 'Hover', 'power-pack' ),
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#000000',
                'selectors'             => [
                    '{{WRAPPER}} .blank-slider-arrow:hover' => 'background-color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#ffffff',
                'selectors'             => [
                    '{{WRAPPER}} .blank-slider-arrow:hover' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-slider-arrow:hover',
                ],
                'condition'             => [
                    'arrows'        => 'yes',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => __( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'default'               => [
                    'top'       => '25',
                    'right'     => '25',
                    'bottom'    => '25',
                    'left'      => '25',
                    'unit'      => 'px',
                    'isLinked'  => true,
                ],
				'selectors'             => [
					'{{WRAPPER}} .blank-slider-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'             => 'before',
                'condition'             => [
                    'arrows'        => 'yes',
                ],
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Style Tab: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label'             => __( 'Dots', 'blank-elements-pro' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'dots_normal',
            [
                'label'             => __( 'Normal', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'dots_color',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#C0C0C0',
                'selectors'         => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_font_size',
            [
                'label'             => __( 'Font Size', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 15,
                ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_margin_right',
            [
                'label'             => __( 'Spacing', 'blank-elements-pro' ),
                'type'              => Controls_Manager::SLIDER,
                'default'               => [
                    'size'  => 5,
                ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .slick-dots li' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'dots_border_normal',
				'label'             => __( 'Border', 'blank-elements-pro' ),
				'placeholder'       => '1px',
				'default'           => '',
				'selector'          => '{{WRAPPER}} .slick-dots li button:before',
			]
		);
        
        $this->add_control(
			'dots_border_radius',
			[
				'label'             => __( 'Border Radius', 'blank-elements-pro' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'selectors'         => [
					'{{WRAPPER}} .slick-dots li button:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'dots_hover',
            [
                'label'             => __( 'Hover', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'dots_color_active',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#1246B8',
                'selectors'         => [
                    '{{WRAPPER}} .slick-dots li:hover button:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'dots_active',
            [
                'label'             => __( 'Active', 'blank-elements-pro' ),
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'             => __( 'Color', 'blank-elements-pro' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#1246B8',
                'selectors'         => [
                    '{{WRAPPER}} .slick-dots li.slick-active button::before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        
        $this->add_render_attribute( 'slider', 'class', 'blank-testimonials-carousel' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
            <?php foreach ( $settings['testimonials'] as $index => $slide ) : ?>
                <?php
                    $slide_number = $index + 1;
                ?>
                <div>
                    <div class="blank-slide-inner blank-slide-<?php echo $slide_number; ?>">
                        <div class="blank-slide-content">
                            <div class="blank-testimonial-content">
                                <?php echo $slide['content']; ?>
                            </div>
                        </div>
                        <div class="blank-slide-content-inner">
                            <div class="blank-testimonial-photo">
                                <?php
                                    if ( ! empty( $slide['image']['url'] ) ) {
                                        echo Group_Control_Image_Size::get_attachment_image_html( $slide );
                                    }
                                ?>
                            </div>
                            <div class="blank-testimonial-bio">
                                <div class="blank-testimonial-name">
                                    <?php echo $slide['name']; ?>
                                </div>
                                <div class="blank-testimonial-location">
                                    <?php echo $slide['location']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function _content_template() {}

}