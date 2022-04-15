<?php
namespace BlankElementsPro\Modules\Posts\Widgets;

use BlankElementsPro\Classes\Blank_Posts_Helper;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts Grid Widget
 */
class Posts extends Widget_Base {
    
    /**
	 * Retrieve posts grid widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'blank-posts';
    }

    /**
	 * Retrieve posts grid widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Posts', 'blank-elements-pro' );
    }

    /**
	 * Retrieve the list of categories the posts grid widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'configurator-template-kits-blocks-widgets' ];
    }

    /**
	 * Retrieve posts grid widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'eicon-posts-group';
    }

	public function get_script_depends() {
		return [
			'isotope',
			'imagesLoaded',
			'selectFx',
            'blank-posts-js',
			'blank-js',
		];
	}

    /**
	 * Register posts grid widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    public function register_query_section_controls() {

        /**
         * Content Tab: Query
         */
        $this->start_controls_section(
            'section_query',
            [
                'label'             	=> __( 'Query', 'blank-elements-pro' ),
            ]
        );

		$post_types = Blank_Posts_Helper::get_post_types();
		$this->add_control(
            'post_type',
            [
				'label'					=> __( 'Post Type', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SELECT,
				'options'				=> $post_types,
				'default'				=> 'post',
				'label_block'			=> false,
				'multiple'				=> false,
			]
        );
        
        $this->add_control(
            'posts_per_page',
            [
                'label'                 => __( 'Posts Per Page', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::NUMBER,
                'default'               => 12,
            ]
        );

		$this->add_control(
            'select_date',
            [
				'label'					=> __( 'Date', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SELECT,
				'options'				=> [
					'anytime'	=> __( 'All', 'blank-elements-pro' ),
					'today'		=> __( 'Past Day', 'blank-elements-pro' ),
					'week'		=> __( 'Past Week', 'blank-elements-pro' ),
					'month'		=> __( 'Past Month', 'blank-elements-pro' ),
					'quarter'	=> __( 'Past Quarter', 'blank-elements-pro' ),
					'year'		=> __( 'Past Year', 'blank-elements-pro' ),
					'exact'		=> __( 'Custom', 'blank-elements-pro' ),
				],
				'default'				=> 'anytime',
				'label_block'			=> false,
				'multiple'				=> false,
				'separator'				=> 'before',
			]
        );

		$this->add_control(
            'date_before',
            [
				'label'					=> __( 'Before', 'blank-elements-pro' ),
				'description'			=> __( 'Setting a ‘Before’ date will show all the posts published until the chosen date (inclusive).', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::DATE_TIME,
				'label_block'			=> false,
				'multiple'				=> false,
				'placeholder'			=> __( 'Choose', 'blank-elements-pro' ),
				'condition'				=> [
					'select_date' => 'exact',
				],
			]
        );


		$this->add_control(
            'date_after',
            [
				'label'					=> __( 'After', 'blank-elements-pro' ),
				'description'			=> __( 'Setting an ‘After’ date will show all the posts published since the chosen date (inclusive).', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::DATE_TIME,
				'label_block'			=> false,
				'multiple'				=> false,
				'placeholder'			=> __( 'Choose', 'blank-elements-pro' ),
				'condition'				=> [
					'select_date' => 'exact',
				],
			]
        );

        $this->add_control(
            'order',
            [
                'label'					=> __( 'Order', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SELECT,
                'options'				=> [
                   'DESC'		=> __( 'Descending', 'blank-elements-pro' ),
                   'ASC'		=> __( 'Ascending', 'blank-elements-pro' ),
                ],
                'default'				=> 'DESC',
                'separator'				=> 'before',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'					=> __( 'Order By', 'blank-elements-pro' ),
                'type'					=> Controls_Manager::SELECT,
                'options'				=> [
                   'date'           => __( 'Date', 'blank-elements-pro' ),
                   'modified'       => __( 'Last Modified Date', 'blank-elements-pro' ),
                   'rand'           => __( 'Random', 'blank-elements-pro' ),
                   'comment_count'  => __( 'Comment Count', 'blank-elements-pro' ),
                   'title'          => __( 'Title', 'blank-elements-pro' ),
                   'ID'             => __( 'Post ID', 'blank-elements-pro' ),
                   'author'         => __( 'Post Author', 'blank-elements-pro' ),
                ],
                'default'				=> 'date',
            ]
        );

        $this->end_controls_section();
    }
	
	protected function register_layout_content_controls() {
        /**
         * Content Tab: Layout
         */
        $this->start_controls_section(
            'section_layout',
            [
                'label'                 => __( 'Layout', 'blank-elements-pro' ),
            ]
        );
		
        $this->add_responsive_control(
            'post_style',
            [
                'label'                 => __( 'Layout Style', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'default',
                'options'               => [
                    'default' => 'Default',
                    'style-1' => 'Style 1',
                    'style-2' => 'Style 2',
                    'style-3' => 'Style 3',
                ],
                'prefix_class'          => 'blank-posts%s-',
                'frontend_available'    => true,
            ]
        );
		
        $this->add_responsive_control(
            'columns',
            [
                'label'                 => __( 'Columns', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => '3',
                'tablet_default'        => '3',
                'mobile_default'        => '2',
                'options'               => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                ],
                'prefix_class'          => 'elementor-grid%s-',
                'frontend_available'    => true,
                'condition'				=> [
					'post_style!'	=> 'style-3',
                ]
            ]
        );
		
        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'thumbnail',
				'label'                 => __( 'Image Size', 'blank-elements-pro' ),
				'default'               => 'large',
				'exclude'           => [ 'custom' ],
			]
		);
        
        $this->add_control(
            'post_excerpt',
            [
                'label'             => __( 'Post Excerpt', 'bycycle-elementor-addons' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => '',
                'label_on'          => __( 'Show', 'bycycle-elementor-addons' ),
                'label_off'         => __( 'Hide', 'bycycle-elementor-addons' ),
                'return_value'      => 'yes',
                'condition'				=> [
					'post_style'	=> 'style-3',
                ]
            ]
        );
        
        $this->add_control(
            'excerpt_length',
            [
                'label'             => __( 'Excerpt Length', 'bycycle-elementor-addons' ),
                'type'              => Controls_Manager::NUMBER,
                'default'           => 15,
                'min'               => 0,
                'max'               => 58,
                'step'              => 1,
                'condition'         => [
                    'post_excerpt'  => 'yes',
                    'post_style'  => 'style-3'
                ]
            ]
        );
		
		$this->end_controls_section();
	}

	protected function register_filter_section_controls() {

		$this->start_controls_section(
			'section_filters',
			[
				'label'					=> __( 'Filters', 'blank-elements-pro' ),
				'tab'					=> Controls_Manager::TAB_CONTENT,
			]
		);
        
        $this->add_control(
			'show_post_count',
			[
				'label'					=> __( 'Show Post Count', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
				'label_off'				=> __( 'No', 'blank-elements-pro' ),
				'return_value'			=> 'yes',
				'default'				=> 'no',
			]
		);

		$this->add_control(
			'filters_1_heading',
			[
				'label'					=> __( 'Category Filter', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'show_filters_1',
			[
				'label'					=> __( 'Show Filters', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SWITCHER,
				'label_on'				=> __( 'Yes', 'blank-elements-pro' ),
				'label_off'				=> __( 'No', 'blank-elements-pro' ),
				'return_value'			=> 'yes',
				'default'				=> 'no',
			]
		);

		$filter_taxonomies = Blank_Posts_Helper::get_taxonomies_options();
		$this->add_control(
            'filter_1_taxonomy',
            [
				'label'					=> __( 'Taxonomy', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SELECT,
				'options'				=> $filter_taxonomies,
				'default'				=> '',
				'label_block'			=> false,
				'multiple'				=> false,
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
			]
        );
		
		$this->end_controls_section();
	}

	public function register_pagination_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SELECT,
				'default'				=> 'none',
				'options'				=> [
					'none'					=> __( 'None', 'blank-elements-pro' ),
					'numbers'				=> __( 'Numbers', 'blank-elements-pro' ),
					'numbers_and_prev_next'	=> __( 'Numbers and Next/Prev', 'blank-elements-pro' ),
					'load_more'             => __( 'Load More', 'blank-elements-pro' ),
					'infinite'				=> __( 'Infinite', 'blank-elements-pro' ),
				],
			]
		);

		$this->end_controls_section();
	}
    
	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Style Tab: Layout
	 */
	protected function register_style_layout_controls() {
		
        $this->start_controls_section(
            'section_layout_style',
            [
                'label'                 => __( 'Layout', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'posts_horizontal_spacing',
            [
                'label'                 => __( 'Column Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> 30,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-elementor-grid .blank-grid-item-wrap' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .blank-elementor-grid'  => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'posts_vertical_spacing',
            [
                'label'                 => __( 'Row Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' 	=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'               => [
                    'size' 	=> 50,
                ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-elementor-grid .blank-grid-item-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
	}
	
	/**
	 * Style Tab: Box
	 */
	protected function register_style_box_controls() {
        $this->start_controls_section(
            'section_post_box_style',
            [
                'label'                 => __( 'Box', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_box_bg',
            [
                'label'                 => __( 'Background Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-grid-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'post_box_border',
				'label'                 => __( 'Border', 'blank-elements-pro' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .blank-grid-item',
			]
		);

		$this->add_control(
			'post_box_padding',
			[
				'label'					=> __( 'Padding', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::DIMENSIONS,
				'size_units'			=> [ 'px', 'em', '%' ],
				'selectors'				=> [
					'{{WRAPPER}} .blank-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'              => 'post_box_shadow',
				'selector'          => '{{WRAPPER}} .blank-grid-item',
			]
		);
        
        $this->end_controls_section();
	}
	
    public function register_style_filter_controls() {    
        /**
         * Style Tab: Filters
         */
        $this->start_controls_section(
            'section_filter_style',
            [
                'label'                 => __( 'Filters', 'blank-elements-pro' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );

		$this->add_control(
			'filter_title_heading',
			[
				'label'					=> __( 'Filter Title', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::HEADING,
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'filter_title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-filter-title',
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'filter_title_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-filter-title' => 'color: {{VALUE}};',
                ],
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );

		$this->add_control(
			'selected_filter_heading',
			[
				'label'					=> __( 'Selected Filter', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::HEADING,
				'separator'			=> 'before',
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'selected_filter_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-selected-filter',
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );

        $this->add_control(
            'selected_filter_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-selected-filter' => 'color: {{VALUE}};',
                ],
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'filters_margin_bottom',
            [
                'label'                 => __( 'Filters Bottom Spacing', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 80,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .blank-post-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
				'separator'			=> 'before',
                'condition'				=> [
					'show_filters_1'	=> 'yes',
                ]
            ]
        );
        
        $this->end_controls_section();
    }
	
	/**
	 * Style Tab: Title
	 */
	protected function register_style_title_controls() {
        $this->start_controls_section(
            'section_title_style',
            [
                'label'					=> __( 'Title', 'blank-elements-pro' ),
                'tab'					=> Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'post_content_align',
			[
				'label'					=> __( 'Alignment', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::CHOOSE,
				'label_block'			=> false,
				'options'			=> [
					'left'		=> [
						'title'	=> __( 'Left', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-left',
					],
					'center'	=> [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-center',
					],
					'right'		=> [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-right',
					],
				],
				'default'				=> '',
				'selectors'			=> [
					'{{WRAPPER}} .blank-post-content' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '#000',
                'selectors'             => [
                    '{{WRAPPER}} .blank-post-title a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'                 => __( 'Hover Color', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .blank-post-title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'first_title_typography',
                'label'                 => __( 'First Post Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-grid-item-wrap:first-child .blank-post-title a',
                'condition'				=> [
					'post_style'        => 'style-2',
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'blank-elements-pro' ),
                'selector'              => '{{WRAPPER}} .blank-post-title a',
            ]
        );
        
        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'                 => __( 'Margin Bottom', 'blank-elements-pro' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'default'               => [
                    'size' 	=> 10,
                ],
                'size_units'            => [ 'px' ],
                'selectors'             => [
                    '{{WRAPPER}} .blank-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	public function register_style_excerpt_controls() {
        
        $this->start_controls_section(
            'section_excerpt_style',
            [
                'label'             => __( 'Post Excerpt', 'bycycle-elementor-addons' ),
                'tab'               => Controls_Manager::TAB_STYLE,
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );

        $this->add_control(
            'excerpt_text_color',
            [
                'label'             => __( 'Text Color', 'bycycle-elementor-addons' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .blank-post-excerpt' => 'color: {{VALUE}}',
                ],
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'excerpt_typography',
                'label'             => __( 'Typography', 'bycycle-elementor-addons' ),
                'selector'          => '{{WRAPPER}} .blank-post-excerpt',
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'excerpt_margin_bottom',
            [
                'label'             => __( 'Margin Bottom', 'bycycle-elementor-addons' ),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [ 'size' => 10 ],
                'range'             => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'        => [ 'px' ],
                'selectors'         => [
                    '{{WRAPPER}} .blank-post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'post_excerpt'  => 'yes'
                ]
            ]
        );
        
        $this->end_controls_section();
        
    }
    
	public function register_style_pagination_controls() {
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label'					=> __( 'Pagination', 'blank-elements-pro' ),
				'tab'					=> Controls_Manager::TAB_STYLE,
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);
        
        $this->add_responsive_control(
			'pagination_align',
			[
				'label'					=> __( 'Alignment', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::CHOOSE,
				'label_block'			=> false,
				'options'			=> [
					'left'		=> [
						'title'	=> __( 'Left', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-left',
					],
					'center'	=> [
						'title' => __( 'Center', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-center',
					],
					'right'		=> [
						'title' => __( 'Right', 'blank-elements-pro' ),
						'icon'	=> 'fa fa-align-right',
					],
				],
				'default'				=> '',
				'selectors'			=> [
					'{{WRAPPER}} .blank-posts-pagination-wrap' => 'text-align: {{VALUE}};',
				],
                'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'				=> 'pagination_typography',
				'selector'			=> '{{WRAPPER}} .elementor-pagination',
				//'scheme'			=> Scheme_Typography::TYPOGRAPHY_2,
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_color_heading',
			[
				'label'					=> __( 'Colors', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::HEADING,
				'separator'			=> 'before',
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->start_controls_tabs( 'pagination_colors' );

		$this->start_controls_tab(
			'pagination_color_normal',
			[
				'label'					=> __( 'Normal', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_hover',
			[
				'label'					=> __( 'Hover', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_color_active',
			[
				'label'					=> __( 'Active', 'blank-elements-pro' ),
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[
				'label'					=> __( 'Color', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::COLOR,
				'selectors'			=> [
					'{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'					=> __( 'Space Between', 'blank-elements-pro' ),
				'type'					=> Controls_Manager::SLIDER,
				'separator'			=> 'before',
				'default'				=> [
					'size' => 10,
				],
				'range'				=> [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'			=> [
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
					'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
				'condition'				=> [
					'pagination_type!' => 'none',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function _register_controls() {
		$this->register_layout_content_controls();
		$this->register_query_section_controls();
		$this->register_filter_section_controls();
		$this->register_pagination_controls();

		$this->register_style_layout_controls();
		$this->register_style_box_controls();
		$this->register_style_filter_controls();
		$this->register_style_title_controls();
		$this->register_style_excerpt_controls();
		$this->register_style_pagination_controls();
	}

    /**
	 * Get post query arguments.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function query_posts_args( $filter_1_tax = 'category', $filter_1 = '' ) {
        $settings = $this->get_settings();
        $paged = $this->get_paged();
        $tax_count = 0;
        $last_char = '';
        $post_type = $settings['post_type'];

		// Query Arguments
		$args = array(
			'post_status'           => array( 'publish' ),
			'post_type'             => $post_type,
			'orderby'               => $settings['orderby'],
			'order'                 => $settings['order'],
			'ignore_sticky_posts'   => 1,
			'showposts'             => $settings['posts_per_page'],
			'paged'					=> $paged,
		);
        
        if ( '' != $filter_1 && '*' != $filter_1 ) {
			$args['tax_query'][0]['taxonomy'] = $filter_1_tax;
			$args['tax_query'][0]['field'] = 'slug';
			$args['tax_query'][0]['terms'] = $filter_1;
			$args['tax_query'][0]['operator'] = 'IN';
		}
        
        //print_r($args);
		return $args;

        
	}

	public function query_posts( $filter_1_tax = 'category', $filter_1 = '' ) {
		
		$query_args  = $this->query_posts_args( $filter_1_tax, $filter_1 );
		
		return new \WP_Query( $query_args );
	}

	/**
	 * Returns the paged number for the query.
	 *
	 * @since 1.7.0
	 * @return int
	 */
	static public function get_paged() {

		global $wp_the_query, $paged;

		if ( isset( $_POST['page_number'] ) && '' != $_POST['page_number'] ) {
			return $_POST['page_number'];
		}

		// Check the 'paged' query var.
		$paged_qv = $wp_the_query->get( 'paged' );

		if ( is_numeric( $paged_qv ) ) {
			if ( ! $paged_qv ) {
				$paged_qv = 1;
			}
			return $paged_qv;
		}

		// Check the 'page' query var.
		$page_qv = $wp_the_query->get( 'page' );

		if ( is_numeric( $page_qv ) ) {
			return $page_qv;
		}

		// Check the $paged global?
		if ( is_numeric( $paged ) ) {
			return $paged;
		}

		return 0;
	}

	public function get_posts_nav_link( $page_limit = null ) {
		if ( ! $page_limit ) {
			$page_limit = $this->query->max_num_pages;
		}

		$return = [];

		$paged = $this->get_paged();

		$link_template = '<a class="page-numbers %s" href="%s">%s</a>';
		$disabled_template = '<span class="page-numbers %s">%s</span>';

		if ( $paged > 1 ) {
			$next_page = intval( $paged ) - 1;
			if ( $next_page < 1 ) {
				$next_page = 1;
			}

			$return['prev'] = sprintf( $link_template, 'prev', $this->get_wp_link_page( $next_page ), '<i class="fa fa-chevron-left"></i>' );
		} else {
			$return['prev'] = sprintf( $disabled_template, 'prev', '<i class="fa fa-chevron-left"></i>' );
		}

		$next_page = intval( $paged ) + 1;

		if ( $next_page <= $page_limit ) {
			$return['next'] = sprintf( $link_template, 'next', $this->get_wp_link_page( $next_page ), '<i class="fa fa-chevron-right"></i>' );
		} else {
			$return['next'] = sprintf( $disabled_template, 'next', '<i class="fa fa-chevron-right"></i>' );
		}

		return $return;
	}

	private function get_wp_link_page( $i ) {
		if ( ! is_singular() || is_front_page() ) {
			return get_pagenum_link( $i );
		}

		// Based on wp-includes/post-template.php:957 `_wp_link_page`.
		global $wp_rewrite;
		$post = get_post();
		$query_args = [];
		$url = get_permalink();

		if ( $i > 1 ) {
			if ( '' === get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, $url );
			} elseif ( get_option( 'show_on_front' ) === 'page' && (int) get_option( 'page_on_front' ) === $post->ID ) {
				$url = trailingslashit( $url ) . user_trailingslashit( "$wp_rewrite->pagination_base/" . $i, 'single_paged' );
			} else {
				$url = trailingslashit( $url ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		if ( is_preview() ) {
			if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
				$query_args['preview_id'] = wp_unslash( $_GET['preview_id'] );
				$query_args['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
			}

			$url = get_preview_post_link( $post, $query_args, $url );
		}

		return $url;
	}

	/**
	 * Render Filters.
	 *
	 * Returns the Filter HTML.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function render_filters() {
		$settings = $this->get_settings_for_display();
		
		$show_filters_1 = $settings[ 'show_filters_1' ];

		if ( 'yes' != $show_filters_1 ) {
			return;
		}

		//$filters = $this->get_filter_values();
		$vs_filter_1 = $settings['filter_1_taxonomy'];
		
		?>
		<div class="blank-post-filters-wrap">
            <div class="blank-filters" data-filter-1-tax="<?php echo $vs_filter_1; ?>">
                <?php if ( 'yes' == $show_filters_1 ) {                     
                    $vs_filter_1_obj = get_taxonomy( $vs_filter_1 );
                    $vs_filter_1_label = $vs_filter_1_obj->label; ?> 

                    <div class="blank-filter-wrap blank-filter-1-wrap">
                        <span class="blank-filter-title" data-value="*">
                            <?php echo ucfirst($vs_filter_1_label); ?>
                        </span>
                        <ul class="blank-filter-1 blank-filter">
                            <li class="blank-filter-item blank-filter-current" data-value="*"><?php echo ucfirst($vs_filter_1_label); ?></li>
                            <?php
                                $sarpur_region_array = get_terms( $vs_filter_1 );
                                foreach ( $sarpur_region_array as $key => $value ) { ?>
                                    <li class="blank-filter-item" data-value="<?php echo $value->slug; ?>"><?php echo $value->name; ?></li>
                                    <?php
                                }
                                ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>                
		</div>
		<?php
	}

	/**
	 * Get Masonry classes array.
	 *
	 * Returns the Masonry classes array.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function get_masonry_classes() {

		$settings = $this->get_settings_for_display();

		$post_type = $settings['post_type'];

		$filter_by = $this->get_instance_value( 'tax_' . $post_type . '_filter' );

		$taxonomies = wp_get_post_terms( get_the_ID(), $filter_by );
		$class      = array();

		if ( count( $taxonomies ) > 0 ) {

			foreach ( $taxonomies as $taxonomy ) {

				if ( is_object( $taxonomy ) ) {

					$class[] = $taxonomy->slug;
				}
			}
		}

		return implode( ' ', $class );
	}
    
    /**
	 * Render post title output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_post_title() {
        ?>
		<div class="blank-post-title">
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
				<?php the_title(); ?>
			</a>
		</div>
        <?php
    }
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render_ajax_post_body( $filter_1_tax = 'category', $filter_1 = '' ) {
		ob_start();
		
		$query = $this->query_posts( $filter_1_tax, $filter_1 );
		$total_pages = $query->max_num_pages;
		
		while ($query->have_posts()) {
			$query->the_post();

			$this->render_post_body($count);

			$i++;
		}
        error_log();
		wp_reset_postdata();
		
		return ob_get_clean();
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function get_ajax_posts_count( $filter_1_tax = 'category', $filter_1 = '' ) {
		$query = $this->query_posts( $filter_1_tax, $filter_1 );
		$posts_count = $query->post_count;
		
        $ppp = $settings['posts_per_page'];
        $end = $posts_count;
        $start = $end - $ppp + 1;
        $total = $query->found_posts;
        
		wp_reset_postdata();
		
        return "Showing $start - $end of $total Results";
		//return $posts_count . ' ' . __('Results','blank-elements-pro');
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render_ajax_pagination() {
		ob_start();
		$this->render_pagination();
		return ob_get_clean();
	}

	/**
	 * Get Pagination.
	 *
	 * Returns the Pagination HTML.
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public function render_pagination() {
		$settings = $this->get_settings_for_display();

		$pagination_type = $settings[ 'pagination_type' ];
		//$page_limit = $settings[ 'pagination_page_limit' ];
		//$pagination_shorten = $settings[ 'pagination_numbers_shorten' ];
		//$load_more_label = $settings[ 'pagination_load_more_label' ];

		if ( 'none' == $pagination_type ) {
			return;
		}

		// Get current page number.
		$paged = $this->get_paged();
		
		$query = $this->query_posts();
		$total_pages = $query->max_num_pages;
		
		if ( 2 > $total_pages ) {
			return;
		}
		
		$has_numbers = in_array( $pagination_type, [ 'numbers', 'numbers_and_prev_next' ] );
		$has_prev_next = ( $pagination_type == 'numbers_and_prev_nextnumbers_and_prev_next' );
		$is_load_more = ( $pagination_type == 'load_more' );
		$is_infinite = ( $pagination_type == 'infinite' );
		
		$links = [];

		if ( $has_numbers || $is_infinite ) {
			
			$current_page = $paged;
			if ( ! $current_page ) {
				$current_page = 1;
			}
			
			$paginate_args = [
				'type'			=> 'array',
				'current'		=> $current_page,
				'total'			=> $total_pages,
				'prev_next'		=> false,
				'show_all'		=> 'yes',
			];

			if ( is_singular() && ! is_front_page() ) {
				global $wp_rewrite;
				if ( $wp_rewrite->using_permalinks() ) {
					$paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
					$paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
				} else {
					$paginate_args['format'] = '?page=%#%';
				}
			}

			$links = paginate_links( $paginate_args );
		}

		if ( $has_prev_next || $is_infinite ) {
			$prev_next = $this->get_posts_nav_link( $total_pages );
			array_unshift( $links, $prev_next['prev'] );
			$links[] = $prev_next['next'];
		}
		if ( !$is_load_more ) {
			?>
			<nav class="blank-posts-pagination elementor-pagination" role="navigation" aria-label="<?php _e( 'Pagination', 'blank-elements-pro' ); ?>">
				<?php echo implode( PHP_EOL, $links ); ?>
			</nav>
			<?php
		}
		
		if ( $is_load_more ) {
			?>
			<div class="blank-post-load-more-wrap">
				<a class="blank-post-load-more elementor-button elementor-size-sm" href="javascript:void(0);">
					<span><?php esc_html_e('Load More','blank-elements-pro') ?></span>
				</a>
			</div>
			<?php
		}
	}
	
	public function get_item_wrap_classes() {
		
		$classes[] = 'blank-grid-item-wrap';
		
		return implode( ' ', $classes );
	}
	
	public function get_item_classes() {
		
		$classes = array();
		
		$classes[] = 'blank-post';
		
		$classes[] = 'blank-grid-item';
		
		return implode( ' ', $classes );
	}
    
    /**
	 * Render post body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_post_body($count) {
        $settings = $this->get_settings_for_display(); 
        $post_style = $settings['post_style'];
        ?>
			
		<div <?php post_class( $this->get_item_wrap_classes() ); ?>>
            <div class="<?php echo $this->get_item_classes(); ?>">		
                <?php if( $post_style == 'style-2' && $count == 1 ) { 
                    if ( has_post_thumbnail() ) {
            
							$image_id = get_post_thumbnail_id( get_the_ID() );

							$setting_key = $settings['thumbnail_size'];
							$settings[ $setting_key ] = [
								'id' => $image_id,
							];
							$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );
							
							$thumbnail_html = '<a href="' . get_the_permalink() . '">' . $thumbnail_html . '</a>';
							?>
							<div class="blank-post-thumbnail">
								<?php echo $thumbnail_html; ?>
							</div>
							<?php
						}
                } if( $post_style == 'style-3' ) { 
                    if ( has_post_thumbnail() ) {
            
							$image_id = get_post_thumbnail_id( get_the_ID() );

							$setting_key = $settings['thumbnail_size'];
							$settings[ $setting_key ] = [
								'id' => $image_id,
							];
							$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, $setting_key );
							
							$thumbnail_html = '<a href="' . get_the_permalink() . '">' . $thumbnail_html . '</a>';
							?>
							<div class="blank-post-thumbnail">
								<?php echo $thumbnail_html; ?>
							</div>
							<?php
						}
                } ?>
                <?php
                    $thumbnail_url = '';
                    $css_class = '';
                    if( $post_style != 'style-3' ) {
                        if ( has_post_thumbnail() ) {

                            $setting_key = $settings['thumbnail_size'];
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), $setting_key);
                            $css_class = 'blank-post-content-bg';

                    } 
                } ?>
                <div class="blank-post-content <?php echo $css_class; ?>" style="background-image:url(<?php echo $thumbnail_url; ?>)">
                    <div class="blank-post-inner-content">
                        <div class="blank-post-cats">
                            <?php the_category(', '); ?>
                        </div>
                        <?php 
                            //post title
                            $this->render_post_title();
                        ?>
                        <?php if( $post_style == 'style-3' && $settings['post_excerpt'] == 'yes' ) { ?>
                            <div class="blank-post-excerpt">
                                <?php echo Blank_Posts_Helper::custom_excerpt( $settings['excerpt_length'] ); ?>
                                <?php //echo custom_excerpt( $settings['excerpt_length'] ); ?>
                            </div>
                        <?php } if( $post_style != 'style-3' ) { ?>
                            <div class="blank-post-author">
                                <?php esc_html_e('by ','blank-elements-pro'); ?>
                                <?php the_author_posts_link(); ?>
                            </div>
                        <?php } ?>
                        <div class="blank-read-more">
                            <?php
                                $blank_read_more_text_reader = sprintf( wp_kses(__( '%1$s<span class="screen-reader-text"> about %2$s</span>', 'blank-elements-pro' ), array( 'span' => array( 'class' => array() ) ) ), 'Read article', get_the_title() );
                            ?>
                            <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                                <?php echo $blank_read_more_text_reader; ?> <span class="read-more-icon"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <?php
    }

    /**
	 * Render posts grid widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    public function render() {
        $settings = $this->get_settings_for_display();
		
		$pagination_type = $settings['pagination_type'];
		$skin			= $this->get_id();
		$page_id		= '';
		
		if ( null != \Elementor\Plugin::$instance->documents->get_current() ) {
			$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
		}
        
        $this->add_render_attribute( 'posts-wrap', 'class', [
			'blank-posts',
			'blank-elementor-grid',
			'blank-posts-grid',
			'blank-posts-skin-' . $this->get_id(),
			]
		);
		
		if ( $pagination_type == 'infinite' ) {
			$this->add_render_attribute( 'posts-wrap', 'class', 'blank-posts-infinite-scroll' );
		}
		
		$this->add_render_attribute( 'posts-wrap', 'data-page', $page_id );
		$this->add_render_attribute( 'posts-wrap', 'data-skin', $skin );
        
        $this->add_render_attribute( 'post-categories', 'class', 'blank-post-categories' );
		?>
        <div class="blank-posts-wrap">
            <div class="blank-post-filters-container">
                <?php                
                    $query = $this->query_posts();
                    $posts_count = $query->post_count;

                if( 'yes' == $settings['show_post_count'] ) { ?>

                <div class="blank-container blank-posts-count-wrap">
                    <span class="blank-posts-count">
                        <?php //echo $posts_count . ' ' . __('Results','blank-elements-pro'); 
                        
                        $ppp = $settings['posts_per_page'];
                        $end = $posts_count;
                        $start = $end - $ppp + 1;
                        $total = $query->found_posts;
                        echo "Showing $start - $end of $total Results";
                        ?>
                    </span>
                </div>
                <?php } 
                    // Filters
                    $this->render_filters();
                ?>
            </div>
			
			<div class="blank-container blank-post-container">
				<div <?php echo $this->get_render_attribute_string( 'posts-wrap' ); ?>>
					<?php
						$count = 1;
						$total_pages = $query->max_num_pages;
                        
                        
						if ( $query->have_posts() ) :  
                        ?>
                            
                            <?php 
                            while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
        
                                $this->render_post_body($count);
                            
                            $count++; endwhile; ?>
                            
						<?php  endif; wp_reset_postdata();
        
					?>
				</div>
				<?php if ( 'load_more' == $pagination_type || 'infinite' == $pagination_type ) { ?>
				<div class="blank-posts-loader"></div>
				<?php } ?>
        	</div>
        </div>
        <?php if ( 'infinite' == $pagination_type ) { ?>
            <div class="blank-posts-pagination-wrap blank-posts-infinite-scroll" data-total="<?php echo $total_pages; ?>">
        <?php } else { ?>
            <div class="blank-posts-pagination-wrap" data-total="<?php echo $total_pages; ?>">
        <?php } ?>
			<?php
				$this->render_pagination();
			?>
		</div>
        <?php
    }
}