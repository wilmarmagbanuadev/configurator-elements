<?php
namespace BlankElementsPro\Modules\Counter\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Counter Widget
 */
class Counter extends Widget_Base {
    
    /**
	 * Retrieve counter widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-counter';
    }

    /**
	 * Retrieve counter widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Counter', 'blank-elements-pro' );
    }

    /**
	 * Retrieve the list of categories the counter widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'configurator-template-kits-blocks-widgets'];
    }

    /**
	 * Retrieve counter widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-counter';
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
            'waypoints',
            'odometer',
            'blank-js'
        ];
    }

    /**
	 * Register counter widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Counter
         */
        $this->start_controls_section(
            'section_counter',
            [
                'label'                 => __( 'Counter', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_control(
			'icon_type',
			[
				'label'                 => esc_html__( 'Icon Type', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'options'               => [
					'none'        => [
						'title'   => esc_html__( 'None', 'blank-elements-pro' ),
						'icon'    => 'fa fa-ban',
					],
					'icon'        => [
						'title'   => esc_html__( 'Icon', 'blank-elements-pro' ),
						'icon'    => 'fa fa-info-circle',
					],
					'image'       => [
						'title'   => esc_html__( 'Image', 'blank-elements-pro' ),
						'icon'    => 'fa fa-picture-o',
					],
				],
				'default'               => 'none',
			]
		);
        
        $this->add_control(
            'counter_icon',
            [
                'label'                 => __( 'Icon', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::ICON,
                'condition'             => [
                    'icon_type'  => 'icon',
                ],
            ]
        );
        
        $this->add_control(
            'icon_image',
            [
                'label'                 => __( 'Image', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::MEDIA,
                'default'               => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
				'condition'             => [
					'icon_type'  => 'image',
				],
            ]
        );
        
        $this->add_control(
            'number',
            [
                'label'                 => __( 'Number', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::NUMBER,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => __( '250', 'blank-elements-pro' ),
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'counter_title',
            [
                'label'                 => __( 'Title', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => __( 'Counter Title', 'blank-elements-pro' ),
                'separator'             => 'before',
            ]
        );
        
        $this->add_control(
            'title_html_tag',
            [
                'label'                => __( 'Title HTML Tag', 'blank-elements-pro' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'div',
                'options'              => [
                    'h1'     => __( 'H1', 'blank-elements-pro' ),
                    'h2'     => __( 'H2', 'blank-elements-pro' ),
                    'h3'     => __( 'H3', 'blank-elements-pro' ),
                    'h4'     => __( 'H4', 'blank-elements-pro' ),
                    'h5'     => __( 'H5', 'blank-elements-pro' ),
                    'h6'     => __( 'H6', 'blank-elements-pro' ),
                    'div'    => __( 'div', 'blank-elements-pro' ),
                    'span'   => __( 'span', 'blank-elements-pro' ),
                    'p'      => __( 'p', 'blank-elements-pro' ),
                ],
            ]
        );

        $this->add_control(
            'counter_description',
            [
                'label'                 => __( 'Description', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::TEXTAREA,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => __( 'Counter description', 'blank-elements-pro' ),
                'separator'             => 'before',
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Settings
         */
        $this->start_controls_section(
            'section_counter_settings',
            [
                'label'                 => __( 'Settings', 'blank-elements-pro' ),
            ]
        );
        
        $this->add_responsive_control(
            'counter_speed',
            [
                'label'                 => __( 'Counting Speed', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => 1500 ],
                'range'                 => [
                    'px' => [
                        'min'   => 100,
                        'max'   => 2000,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Style Tab: Counter
         */
        $this->start_controls_section(
            'section_style',
            [
                'label'                 => __( 'Counter', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'counter_align',
			[
				'label'                 => __( 'Alignment', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left' 	=> [
                        'title' 	=> __( 'Left', 'blank-elements-pro' ),
                        'icon' 		=> 'eicon-h-align-left',
                    ],
                    'center' 		=> [
                        'title' 	=> __( 'Center', 'blank-elements-pro' ),
                        'icon' 		=> 'eicon-h-align-center',
                    ],
                    'right' 		=> [
                        'title' 	=> __( 'Right', 'blank-elements-pro' ),
                        'icon' 		=> 'eicon-h-align-right',
                    ],
				],
				'default'               => 'center',
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'right'    => 'flex-end',
					'center'   => 'center',
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-counter'   => 'justify-content: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Icon
         */
        $this->start_controls_section(
            'section_counter_icon_style',
            [
                'label'                 => __( 'Icon', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'icon_type!' => 'none',
                ],
            ]
        );
        
        $this->add_control(
			'icon_vertical_align',
			[
				'label'                 => __( 'Vertical Align', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
				'default'               => 'top',
				'options'               => [
					'top'          => [
						'title'    => __( 'Top', 'power-pack' ),
						'icon'     => 'eicon-v-align-top',
					],
					'middle'       => [
						'title'    => __( 'Center', 'power-pack' ),
						'icon'     => 'eicon-v-align-middle',
					],
					'bottom'       => [
						'title'    => __( 'Bottom', 'power-pack' ),
						'icon'     => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary'  => [
					'top'          => 'flex-start',
					'middle'       => 'center',
					'bottom'       => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-counter-icon-wrap'   => 'align-items: {{VALUE}};',
				],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
			]
		);
        
        $this->add_responsive_control(
            'counter_icon_spacing',
            [
                'label'                 => __( 'Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' => 20,
                    'unit' => 'px'
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-icon-wrap' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'counter_icon_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-icon' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'icon_type'  => 'icon',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'counter_icon_size',
            [
                'label'                 => __( 'Size', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 5,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', 'em' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'icon_type'  => 'icon',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'counter_icon_img_width',
            [
                'label'                 => __( 'Image Width', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 10,
                        'max'   => 500,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => ['px', '%'],
                'condition'             => [
                    'icon_type'  => 'image',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'counter_icon_rotation',
            [
                'label'                 => __( 'Rotation', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 360,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'condition'             => [
                    'icon_type!' => 'none',
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-icon .fa, {{WRAPPER}} .blank-counter-icon img' => 'transform: rotate( {{SIZE}}deg );',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'counter_icon_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-counter-icon',
                'condition'             => [
                    'icon_type!' => 'none',
                ],
			]
		);

		$this->add_control(
			'counter_icon_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .blank-counter-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
			]
		);

		$this->add_responsive_control(
			'counter_icon_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements-pro' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'           => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .blank-counter-icon' => 'padding-top: {{TOP}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
				],
                'condition'             => [
                    'icon_type!' => 'none',
                ],
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Number
         */
        $this->start_controls_section(
            'section_counter_num_style',
            [
                'label'                 => __( 'Number', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'counter_num_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'counter_num_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-counter-number',
            ]
        );
        
        $this->add_responsive_control(
            'counter_number_spacing',
            [
                'label'                 => __( 'Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' => 5,
                    'unit' => 'px'
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-number-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->end_controls_section();
        
        $this->end_controls_section();

        /**
         * Style Tab: Title
         */
        $this->start_controls_section(
            'section_counter_title_style',
            [
                'label'                 => __( 'Title', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'counter_title!' => '',
                ],
            ]
        );

        $this->add_control(
            'counter_title_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-title' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'counter_title!' => '',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'counter_title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-counter-title',
                'condition'             => [
                    'counter_title!' => '',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'counter_title_spacing',
            [
                'label'                 => __( 'Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' => 5,
                    'unit' => 'px'
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'counter_title!' => '',
                ],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Description
         */
        $this->start_controls_section(
            'section_counter_description_style',
            [
                'label'                 => __( 'Description', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'counter_description!' => '',
                ],
            ]
        );

        $this->add_control(
            'counter_description_color',
            [
                'label'                 => __( 'Text Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-counter-description' => 'color: {{VALUE}};',
                ],
                'condition'             => [
                    'counter_description!' => '',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'counter_description_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-counter-description',
                'condition'             => [
                    'counter_description!' => '',
                ],
            ]
        );
        
        $this->end_controls_section();

    }

    /**
	 * Render counter widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'counter', 'class', 'blank-counter blank-counter-'.esc_attr( $this->get_id() ) );
        
        $this->add_render_attribute( 'counter', 'data-target', '.blank-counter-number-'.esc_attr( $this->get_id() ) );
        
        $this->add_render_attribute( 'counter-number', 'class', 'blank-counter-number blank-counter-number-'.esc_attr( $this->get_id() ) );
        
        if ( $settings['number'] != '' ) {
            $this->add_render_attribute( 'counter-number', 'data-to', $settings['number'] );
        }
        
        if ( $settings['counter_speed']['size'] != '' ) {
            $this->add_render_attribute( 'counter-number', 'data-speed', $settings['counter_speed']['size'] );
        }
        
        $this->add_inline_editing_attributes( 'counter_title', 'none' );
        $this->add_render_attribute( 'counter_title', 'class', 'blank-counter-title' );
        $this->add_inline_editing_attributes( 'counter_description', 'none' );
        $this->add_render_attribute( 'counter_description', 'class', 'blank-counter-description' );
        ?>
        <div class="blank-counter-container">
            <div <?php echo $this->get_render_attribute_string( 'counter' ); ?>>
                <?php
                    // Counter Icon
                    $this->render_icon();
                ?>

                <div class="blank-counter-number-title-wrap">
                    <div class="blank-counter-number-wrap">
                        <div <?php echo $this->get_render_attribute_string( 'counter-number' ); ?>>
                            0
                        </div>
                    </div>

                    <?php
                        if ( !empty( $settings['counter_title'] ) ) {
                            printf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_html_tag'], $this->get_render_attribute_string( 'counter_title' ), $settings['counter_title'] );
                        }
        
                        if ( !empty( $settings['counter_description'] ) ) {
                            printf( '<div %1$s>%2$s</div>', $this->get_render_attribute_string( 'counter_description' ), $settings['counter_description'] );
                        }
                    ?>
                </div>
            </div>
        </div><!-- .blank-counter-container -->
        <?php
    }
    
    /**
	 * Render counter icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    private function render_icon() {
        $settings = $this->get_settings_for_display();
        
        if ( $settings['icon_type'] == 'icon' ) {
            if ( !empty( $settings['counter_icon'] ) ) { ?>
                <div class="blank-counter-icon-wrap">
                    <span class="blank-counter-icon">
                        <span class="<?php echo $settings['counter_icon'] ?>" aria-hidden="true"></span>
                    </span>
                </div>
            <?php }
        } elseif ( $settings['icon_type'] == 'image' ) {
            $image = $settings['icon_image'];
            if ( $image['url'] ) { ?>
                <div class="blank-counter-icon-wrap">
                    <span class="blank-counter-icon blank-counter-icon-img">
                        <img src="<?php echo esc_url( $image['url'] ); ?>">
                    </span>
                </div>
            <?php }
        }
    }

    /**
	 * Render counter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}
}