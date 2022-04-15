<?php
namespace BlankElementsPro\Modules\Breadcrumbs\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Breadcrumbs Widget
 */
class Breadcrumbs extends Widget_Base {
    
    public function get_name() {
		return 'blank-breadcrumbs';
	}

	public function get_title() {
		return __( 'Breadcrumbs', 'blank-elements' );
	}

	public function get_icon() {
		return 'eicon-ellipsis-h';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}

    public function get_script_depends() {
        return [
			'blank-js'
        ];
    }

    /**
	 * Register breadcrumbs widget controls.
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
         * Content Tab: Breadcrumbs
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_breadcrumbs',
            [
                'label'                 => __( 'Breadcrumbs', 'blank-elements' ),
            ]
        );

        $this->add_control(
            'breadcrumbs_type',
            [
                'label'                 => __( 'Select Type', 'blank-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'blank-elements',
                'frontend_available'    => true,
                'options'               => [
                    'blank-elements'		=> __( 'Configurator Block', 'blank-elements' ),
                    'yoast'			=> __( 'Yoast', 'blank-elements' ),
                    'rankmath'		=> __( 'Rank Math SEO', 'blank-elements' ),
                    'navxt'			=> __( 'Breadcrumb NavXT', 'blank-elements' ),
                    'seopress'		=> __( 'SEOPress', 'blank-elements' ),
                ],
            ]
        );
        
        $this->add_control(
            'show_home',
            [
                'label'                 => __( 'Show Home', 'blank-elements' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'On', 'blank-elements' ),
                'label_off'             => __( 'Off', 'blank-elements' ),
                'return_value'          => 'yes',
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'home_text',
            [
                'label'                 => __( 'Home Text', 'blank-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'Home', 'blank-elements' ),
                'dynamic'               => [
                    'active'        => true,
                    'categories'    => [ TagsModule::POST_META_CATEGORY ]
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements',
                    'show_home'			=> 'yes'
                ],
            ]
        );
		
		$this->add_control(
			'select_home_icon',
			[
				'label'					=> __( 'Home Icon', 'blank-elements' ),
				'type'					=> Controls_Manager::ICONS,
				'label_block'			=> false,
				'skin'					=> 'inline',
				'fa4compatibility'		=> 'home_icon',
				'default'				=> [
					'value'		=> 'fas fa-home',
					'library'	=> 'fa-solid',
				],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements',
                    'show_home'			=> 'yes'
                ],
			]
		);

        $this->add_control(
            'blog_text',
            [
                'label'                 => __( 'Blog Text', 'blank-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( 'Blog', 'blank-elements' ),
                'dynamic'               => [
                    'active'        => true,
                    'categories'    => [ TagsModule::POST_META_CATEGORY ]
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );
        
        $this->add_responsive_control(
			'align',
			[
				'label'                 => __( 'Alignment', 'blank-elements' ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => '',
				'options'               => [
                    'left'      => [
                        'title' => __( 'Left', 'blank-elements' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'blank-elements' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'blank-elements' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
				],
				'selectors_dictionary'  => [
					'left'      => 'flex-start',
					'center'    => 'center',
					'right'     => 'flex-end',
				],
                'separator'             => 'before',
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs'   => 'justify-content: {{VALUE}};',
				],
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Content Tab: Separator
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_separator',
            [
                'label'                 => __( 'Separator', 'blank-elements' ),
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'separator_type',
            [
                'label'                 => __( 'Separator Type', 'blank-elements' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'icon',
                'options'               => [
                    'text'          => __( 'Text', 'blank-elements' ),
                    'icon'          => __( 'Icon', 'blank-elements' ),
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'separator_text',
            [
                'label'                 => __( 'Separator', 'blank-elements' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => __( '>', 'blank-elements' ),
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements',
                    'separator_type'    => 'text'
                ],
            ]
        );
		
		$this->add_control(
			'select_separator_icon',
			[
				'label'					=> __( 'Separator', 'blank-elements' ),
				'type'					=> Controls_Manager::ICONS,
				'label_block'			=> false,
				'skin'					=> 'inline',
				'fa4compatibility'		=> 'separator_icon',
				'default'				=> [
					'value'		=> 'fas fa-angle-right',
					'library'	=> 'fa-solid',
				],
				'recommended'			=> [
					'fa-regular' => [
						'circle',
						'square',
						'window-minimize',
					],
					'fa-solid' => [
						'angle-right',
						'angle-double-right',
						'caret-right',
						'chevron-right',
						'bullseye',
						'circle',
						'dot-circle',
						'genderless',
						'greater-than',
						'grip-lines',
						'grip-lines-vertical',
						'minus',
					],
				],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements',
                    'separator_type'    => 'icon'
                ],
			]
		);
        
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Items
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_breadcrumbs_style',
            [
                'label'                 => __( 'Items', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'breadcrumbs_items_spacing',
            [
                'label'                 => __( 'Spacing', 'blank-elements' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'	=> 10
                ],
                'range'                 => [
                    'px' 	=> [
                        'max' => 50,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs.be-breadcrumbs-powerpack > li' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_breadcrumbs_style' );

        $this->start_controls_tab(
            'tab_breadcrumbs_normal',
            [
                'label'                 => __( 'Normal', 'blank-elements' ),
            ]
        );

        $this->add_control(
            'breadcrumbs_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .be-breadcrumbs-crumb .be-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_background_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'breadcrumbs_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'breadcrumbs_border',
				'label'                 => __( 'Border', 'blank-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)',
			]
		);

		$this->add_control(
			'breadcrumbs_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_breadcrumbs_hover',
            [
                'label'                 => __( 'Hover', 'blank-elements' ),
            ]
        );

        $this->add_control(
            'breadcrumbs_color_hover',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb-link:hover, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .be-breadcrumbs-crumb-link:hover .be-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_background_color_hover',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb-link:hover, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'breadcrumbs_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb-link:hover, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_responsive_control(
			'breadcrumbs_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
                'separator'             => 'before',
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs-crumb, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) a, {{WRAPPER}} .be-breadcrumbs:not(.be-breadcrumbs-powerpack) span:not(.separator)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        /**
         * Style Tab: Separators
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_separators_style',
            [
                'label'                 => __( 'Separators', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'separators_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-separator' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .be-breadcrumbs-separator svg' => 'fill: {{VALUE}}',
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'separators_background_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-separator' => 'background-color: {{VALUE}}',
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'separators_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-breadcrumbs-separator',
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'separators_border',
				'label'                 => __( 'Border', 'blank-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .be-breadcrumbs-separator',
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
			]
		);

		$this->add_control(
			'separators_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs-separator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
			]
		);

		$this->add_responsive_control(
			'separators_padding',
			[
				'label'                 => __( 'Padding', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs-separator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
			]
		);
        
        $this->end_controls_section();

        /**
         * Style Tab: Current
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_current_style',
            [
                'label'                 => __( 'Current', 'blank-elements' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'current_color',
            [
                'label'                 => __( 'Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb-current' => 'color: {{VALUE}}',
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

        $this->add_control(
            'current_background_color',
            [
                'label'                 => __( 'Background Color', 'blank-elements' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .be-breadcrumbs-crumb-current' => 'background-color: {{VALUE}}',
                ],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'current_typography',
                'label'                 => __( 'Typography', 'blank-elements' ),
                'selector'              => '{{WRAPPER}} .be-breadcrumbs-crumb-current',
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'current_border',
				'label'                 => __( 'Border', 'blank-elements' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .be-breadcrumbs-crumb-current',
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
			]
		);

		$this->add_control(
			'current_border_radius',
			[
				'label'                 => __( 'Border Radius', 'blank-elements' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .be-breadcrumbs-crumb-current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'breadcrumbs_type'	=> 'blank-elements'
                ],
			]
		);

        $this->end_controls_section();
        

    }

    /**
	 * Render breadcrumbs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
		if ( $settings['breadcrumbs_type'] == 'blank-elements' ) {
			$query = $this->get_query();

			if ( $query ) {
				if ( $query->have_posts() ) {

					$this->render_breadcrumbs( $query );

					wp_reset_postdata();
					wp_reset_query();
				}
			} else {
				$this->render_breadcrumbs();
			}
        } else {
			if ( ( 'yoast' === $settings['breadcrumbs_type'] && function_exists( 'yoast_breadcrumb' ) ) || ( 'rankmath' === $settings['breadcrumbs_type'] && function_exists( 'rank_math_the_breadcrumbs' ) ) || ( 'navxt' == $settings['breadcrumbs_type'] && function_exists( 'bcn_display' ) ) || ( 'seopress' == $settings['breadcrumbs_type'] && function_exists( 'seopress_display_breadcrumbs' ) ) ) { ?>
			<div class="be-breadcrumbs be-breadcrumbs-<?php echo $settings['breadcrumbs_type']; ?>">
				<?php
				if ( 'yoast' === $settings['breadcrumbs_type'] && function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
				} elseif ( 'rankmath' === $settings['breadcrumbs_type'] && function_exists( 'rank_math_the_breadcrumbs' ) ) {
					rank_math_the_breadcrumbs();
				} elseif ( 'navxt' == $settings['breadcrumbs_type'] && function_exists( 'bcn_display' ) ) {
					bcn_display();
				} elseif ( 'seopress' == $settings['breadcrumbs_type'] && function_exists( 'seopress_display_breadcrumbs' ) ) {
					seopress_display_breadcrumbs();
				}
				?>
			</div>
			<?php }
		}
    }
    
    protected function get_query() {
		$settings 	= $this->get_settings_for_display();
        
        global $post;

        $post_type = 'any';

        $args = array(
            'post_type' => $post_type,
        );

        // Posts Query
        $post_query = new \WP_Query( $args );

        //return $post_query;
        
        return false;
    }
    
    protected function render_breadcrumbs( $query = false ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'breadcrumbs', 'class', ['be-breadcrumbs', 'be-breadcrumbs-powerpack'] );
		$this->add_render_attribute( 'breadcrumbs-item', 'class', 'be-breadcrumbs-item' );

        // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
        $custom_taxonomy = 'product_cat';

        // Get the query & post information
        global $post, $wp_query;

		if ( $query === false ) {
			// Reset post data to parent query
			$wp_query->reset_postdata();

			// Set active query to native query
			$query = $wp_query;
		}

        // Do not display on the homepage
        if ( !$query->is_front_page() ) {

            // Build the breadcrums
            echo '<ul ' . $this->get_render_attribute_string( 'breadcrumbs' ) . '>';
            
            // Home page
            if ( $settings['show_home'] == 'yes' ) {
                $this->render_home_link();
            }

            if ( $query->is_archive() && !$query->is_tax() && !$query->is_category() && !$query->is_tag() ) {
                
                $this->add_render_attribute( 'breadcrumbs-item-archive', 'class', [
                    'be-breadcrumbs-item',
                    'be-breadcrumbs-item-current',
                    'be-breadcrumbs-item-archive'
                ] );
                
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-archive' ) . '><strong class="bread-current bread-archive">' . post_type_archive_title( $prefix, false ) . '</strong></li>';
                
            } else if ( $query->is_archive() && $query->is_tax() && !$query->is_category() && !$query->is_tag() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ( $post_type != 'post' ) {

                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                
                    $this->add_render_attribute( [
                        'breadcrumbs-item-cpt' => [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-cat',
                                'be-breadcrumbs-item-custom-post-type-' . $post_type
                            ]
                        ],
                        'breadcrumbs-item-cpt-crumb' => [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-link',
                                'be-breadcrumbs-crumb-cat',
                                'be-breadcrumbs-crumb-custom-post-type-' . $post_type
                            ],
                            'href'  => $post_type_archive,
                            'title' => $post_type_object->labels->name,
                        ]
                    ] );

                    echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-cpt' ) . '><a ' . $this->get_render_attribute_string( 'breadcrumbs-item-cpt-crumb' ) . '>' . $post_type_object->labels->name . '</a></li>';
                    
                    $this->render_separator();

                }
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-tax' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-archive'
                        ]
                    ],
                    'breadcrumbs-item-tax-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                        ],
                    ]
                ] );

                $custom_tax_name = get_queried_object()->name;
                
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-tax' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-tax-crumb' ) . '>' . $custom_tax_name . '</strong></li>';

            } else if ( $query->is_single() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ( $post_type != 'post' ) {

                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                
                    $this->add_render_attribute( [
                        'breadcrumbs-item-cpt' => [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-cat',
                                'be-breadcrumbs-item-custom-post-type-' . $post_type
                            ]
                        ],
                        'breadcrumbs-item-cpt-crumb' => [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-link',
                                'be-breadcrumbs-crumb-cat',
                                'be-breadcrumbs-crumb-custom-post-type-' . $post_type
                            ],
                            'href'  => $post_type_archive,
                            'title' => $post_type_object->labels->name,
                        ]
                    ] );
                    
                    echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-cpt' ) . '><a ' . $this->get_render_attribute_string( 'breadcrumbs-item-cpt-crumb' ) . '>' . $post_type_object->labels->name . '</a></li>';
                    
                    $this->render_separator();

                }

                // Get post category info
                $category = get_the_category();

                if ( !empty( $category ) ) {

                    // Get last category post is in
                    $values = array_values( $category );
					
					$last_category = reset( $values );
					
					$categories = [];
					$get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
                    $cat_parents = explode( ',', $get_cat_parents );
					foreach($cat_parents as $parent){
						$categories[] = get_term_by('name', $parent, 'category');
					}

                    // Loop through parent categories and store in variable $cat_display
                    $cat_display = '';
					
					foreach( $categories as $parent ) {
                        if ( !is_wp_error(get_term_link( $parent )) ) {
						    $cat_display .= '<li class="be-breadcrumbs-item be-breadcrumbs-item-cat"><a class="be-breadcrumbs-crumb be-breadcrumbs-crumb-link be-breadcrumbs-crumb-cat" href="'. get_term_link( $parent ) .'">' . $parent->name . '</a></li>';
                            $cat_display .= $this->render_separator( false );
                        }
					}

                }

                // If it's a custom post type within a custom taxonomy
                $taxonomy_exists = taxonomy_exists( $custom_taxonomy );
                
                if( empty( $last_category ) && !empty( $custom_taxonomy ) && $taxonomy_exists ) {
                    $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                }

                // Check if the post is in a category
                if( !empty( $last_category ) ) {
                    echo $cat_display;
                
                    $this->add_render_attribute( [
                        'breadcrumbs-item-post-cat' => [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-current',
                                'be-breadcrumbs-item-' . $post->ID
                            ]
                        ],
                        'breadcrumbs-item-post-cat-bread' => [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-current',
                                'be-breadcrumbs-crumb-' . $post->ID
                            ],
                            'title' => get_the_title(),
                        ]
                    ] );
                    
                    echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-cat' ) . '"><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-cat-bread' ) . '">' . get_the_title() . '</strong></li>';

                // Else if post is in a custom taxonomy
                } else if ( $taxonomy_terms ) {

					foreach ( $taxonomy_terms as $index => $taxonomy ) {
                        $cat_id         = $taxonomy->term_id;
                        $cat_nicename   = $taxonomy->slug;
                        $cat_link		= get_term_link($taxonomy->term_id, $custom_taxonomy);
                        $cat_name		= $taxonomy->name;
                
						$this->add_render_attribute( [
							'breadcrumbs-item-post-cpt' => [
								'class' => [
									'be-breadcrumbs-item',
									'be-breadcrumbs-item-cat',
									'be-breadcrumbs-item-cat-' . $cat_id,
									'be-breadcrumbs-item-cat-' . $cat_nicename
								]
							],
							'breadcrumbs-item-post-cpt-crumb' => [
								'class' => [
									'be-breadcrumbs-crumb',
									'be-breadcrumbs-crumb-link',
									'be-breadcrumbs-crumb-cat',
									'be-breadcrumbs-crumb-cat-' . $cat_id,
									'be-breadcrumbs-crumb-cat-' . $cat_nicename,
								],
								'href'  => $cat_link,
								'title' => $cat_name,
							]
						] );

						echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-cpt' ) . '"><a ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-cpt-crumb' ) . '>' . $cat_name . '</a></li>';

						$this->render_separator();
					}
                
                    $this->add_render_attribute( [
                        'breadcrumbs-item-post' => [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-current',
                                'be-breadcrumbs-item-' . $post->ID,
                            ]
                        ],
                        'breadcrumbs-item-post-crumb' => [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-current',
                                'be-breadcrumbs-crumb-' . $post->ID,
                            ],
                            'title' => get_the_title(),
                        ]
                    ] );
                    
                    echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-post' ) . '"><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-crumb' ) . '">' . get_the_title() . '</strong></li>';

                } else {
                
                    $this->add_render_attribute( [
                        'breadcrumbs-item-post' => [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-current',
                                'be-breadcrumbs-item-' . $post->ID,
                            ]
                        ],
                        'breadcrumbs-item-post-crumb' => [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-current',
                                'be-breadcrumbs-crumb-' . $post->ID,
                            ],
                            'title' => get_the_title(),
                        ]
                    ] );

                    echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-post' ) . '"><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-post-crumb' ) . '">' . get_the_title() . '</strong></li>';

                }

            } else if ( $query->is_category() ) {
                
                    $this->add_render_attribute([
                        'breadcrumbs-item-cat' =>  [
                            'class' => [
                                'be-breadcrumbs-item',
                                'be-breadcrumbs-item-current',
                                'be-breadcrumbs-item-cat'
                            ]
                        ],
                        'breadcrumbs-item-cat-bread' =>  [
                            'class' => [
                                'be-breadcrumbs-crumb',
                                'be-breadcrumbs-crumb-current',
                                'be-breadcrumbs-crumb-cat'
                            ]
                        ]
                    ]);

                // Category page
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-cat' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-cat-bread' ) . '>' . single_cat_title('', false) . '</strong></li>';

            } else if ( $query->is_page() ) {

                // Standard page
                if ( $post->post_parent ) {

                    // If child page, get parents 
                    $anc = get_post_ancestors( $post->ID );

                    // Get parents in the right order
                    $anc = array_reverse( $anc );

                    // Parent page loop
                    if ( !isset( $parents ) ) $parents = null;
                    foreach ( $anc as $ancestor ) {
                        $parents .= '<li class="be-breadcrumbs-item be-breadcrumbs-item-parent be-breadcrumbs-item-parent-' . $ancestor . '"><a class="be-breadcrumbs-crumb be-breadcrumbs-crumb-link be-breadcrumbs-crumb-parent be-breadcrumbs-crumb-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';

                        $parents .= $this->render_separator( false );
                    }

                    // Display parent pages
                    echo $parents;

                }
                
                $this->add_render_attribute([
                    'breadcrumbs-item-page' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-' . $post->ID
                        ]
                    ],
                    'breadcrumbs-item-page-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-' . $post->ID
                        ],
                        'title' => get_the_title()
                    ]
                ]);

                // Just display current page if not parents
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-page' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-page-crumb' ) . '>' . get_the_title() . '</strong></li>';

            } else if ( $query->is_tag() ) {

                // Tag page

                // Get tag information
                $term_id        = get_query_var('tag_id');
                $taxonomy       = 'post_tag';
                $args           = 'include=' . $term_id;
                $terms          = get_terms( $taxonomy, $args );
                $get_term_id    = $terms[0]->term_id;
                $get_term_slug  = $terms[0]->slug;
                $get_term_name  = $terms[0]->name;
                
                $this->add_render_attribute([
                    'breadcrumbs-item-tag' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-tag-' . $get_term_id,
                            'be-breadcrumbs-item-tag-' . $get_term_slug
                        ]
                    ],
                    'breadcrumbs-item-tag-bread' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-tag-' . $get_term_id,
                            'be-breadcrumbs-crumb-tag-' . $get_term_slug
                        ],
                        'title' => get_the_title()
                    ]
                ]);

                // Display the tag name
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-tag' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-tag-bread' ) . '>' . $get_term_name . '</strong></li>';

            } elseif ( $query->is_day() ) {
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-year' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-year',
                            'be-breadcrumbs-item-year-' . get_the_time('Y')
                        ]
                    ],
                    'breadcrumbs-item-year-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-link',
                            'be-breadcrumbs-crumb-year',
                            'be-breadcrumbs-crumb-year-' . get_the_time('Y')
                        ],
                        'href'  => get_year_link( get_the_time('Y') ),
                        'title' => get_the_time('Y'),
                    ],
                    'breadcrumbs-item-month' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-month',
                            'be-breadcrumbs-item-month-' . get_the_time('m')
                        ]
                    ],
                    'breadcrumbs-item-month-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-link',
                            'be-breadcrumbs-crumb-month',
                            'be-breadcrumbs-crumb-month-' . get_the_time('m')
                        ],
                        'href'  => get_month_link( get_the_time('Y'), get_the_time('m') ),
                        'title' => get_the_time('M')
                    ],
                    'breadcrumbs-item-day' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-' . get_the_time('j')
                        ]
                    ],
                    'breadcrumbs-item-day-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-' . get_the_time('j')
                        ],
                    ]
                ] );

                // Year link
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-year' ) . '><a ' . $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) . '>' . get_the_time('Y') . ' ' . __( 'Archives', 'blank-elements') . '</a></li>';
                
                $this->render_separator();

                // Month link
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-month' ) . '><a ' . $this->get_render_attribute_string( 'breadcrumbs-item-month-crumb' ) . '>' . get_the_time('M') . ' ' . __( 'Archives', 'blank-elements') . '</a></li>';
                
                $this->render_separator();

                // Day display
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-day' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-day-crumb' ) . '> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' ' . __( 'Archives', 'blank-elements') . '</strong></li>';

            } else if ( $query->is_month() ) {
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-year' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-year',
                            'be-breadcrumbs-item-year-' . get_the_time('Y')
                        ]
                    ],
                    'breadcrumbs-item-year-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-year',
                            'be-breadcrumbs-crumb-year-' . get_the_time('Y')
                        ],
                        'href'  => get_year_link( get_the_time('Y') ),
                        'title' => get_the_time('Y'),
                    ],
                    'breadcrumbs-item-month' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-month',
                            'be-breadcrumbs-item-month-' . get_the_time('m')
                        ]
                    ],
                    'breadcrumbs-item-month-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-month',
                            'be-breadcrumbs-crumb-month-' . get_the_time('m')
                        ],
                        'title' => get_the_time('M')
                    ]
                ] );

                // Year link
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-year' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) . '>' . get_the_time('Y') . ' ' . __( 'Archives', 'blank-elements' ) . '</strong></li>';
                
                $this->render_separator();

                // Month display
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-month' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-month-crumb' ) . '>' . get_the_time('M') . ' ' . __( 'Archives', 'blank-elements' ) . '</strong></li>';

            } else if ( $query->is_year() ) {
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-year' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-current-' . get_the_time('Y')
                        ]
                    ],
                    'breadcrumbs-item-year-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-current-' . get_the_time('Y')
                        ],
                        'title' => get_the_time('Y'),
                    ]
                ] );

                // Display year archive
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-year' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) . '>' . get_the_time('Y') . ' ' . __( 'Archives', 'blank-elements' ) . '</strong></li>';

            } else if ( $query->is_author() ) {

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-author' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-current-' . $userdata->user_nicename
                        ]
                    ],
                    'breadcrumbs-item-author-bread' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-current-' . $userdata->user_nicename
                        ],
                        'title' => $userdata->display_name
                    ]
                ] );

                // Display author name
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-author' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-author-bread' ) . '>' . __( 'Author:', 'blank-elements' ) . ' ' . $userdata->display_name . '</strong></li>';

            } else if ( get_query_var('paged') ) {
                
                $this->add_render_attribute( [
                    'breadcrumbs-item-paged' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-current-' . get_query_var('paged')
                        ]
                    ],
                    'breadcrumbs-item-paged-bread' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-current-' . get_query_var('paged'),
                        ],
                        'title' => __( 'Page', 'blank-elements' ) . ' ' . get_query_var('paged'),
                    ]
                ] );

                // Paginated archives
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-paged' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-paged-bread' ) . '>' . __('Page', 'blank-elements') . ' ' . get_query_var('paged') . '</strong></li>';

            } else if ( $query->is_search() ) {
                
                // Search results page
                $this->add_render_attribute( [
                    'breadcrumbs-item-search' => [
                        'class' => [
                            'be-breadcrumbs-item',
                            'be-breadcrumbs-item-current',
                            'be-breadcrumbs-item-current-' . get_search_query()
                        ]
                    ],
                    'breadcrumbs-item-search-crumb' => [
                        'class' => [
                            'be-breadcrumbs-crumb',
                            'be-breadcrumbs-crumb-current',
                            'be-breadcrumbs-crumb-current-' . get_search_query(),
                        ],
                        'title' => __( 'Search results for:', 'blank-elements' ) . ' '  . get_search_query()
                    ]
                ] );

                // Search results page
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-search' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-search-crumb' ) . '>' . __( 'Search results for:', 'blank-elements' ) . ' '  . get_search_query() . '</strong></li>';

            } else if ( $query->is_home() ) {
				
				$blog_label = $settings['blog_text'];
                
				if ( $blog_label ) {
					$this->add_render_attribute([
						'breadcrumbs-item-blog' => [
							'class' => [
								'be-breadcrumbs-item',
								'be-breadcrumbs-item-current'
							]
						],
						'breadcrumbs-item-blog-crumb' => [
							'class' => [
								'be-breadcrumbs-crumb',
								'be-breadcrumbs-crumb-current',
							],
							'title' => $blog_label
						]
					]);

					// Just display current page if not parents
					echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-blog' ) . '><strong ' . $this->get_render_attribute_string( 'breadcrumbs-item-blog-crumb' ) . '>' . $blog_label . '</strong></li>';
				}

            } elseif ( $query->is_404() ) {
				$this->add_render_attribute([
					'breadcrumbs-item-error' => [
						'class' => [
							'be-breadcrumbs-item',
							'be-breadcrumbs-item-current'
						]
					]
				]);

                // 404 page
                echo '<li ' . $this->get_render_attribute_string( 'breadcrumbs-item-error' ) . '>' . __( 'Error 404', 'blank-elements' ) . '</li>';
            }

            echo '</ul>';

        }

    }

	protected function get_separator() {
		$settings = $this->get_settings_for_display();

		ob_start();
        if ( $settings['separator_type'] == 'icon' ) {
		
			if ( ! isset( $settings['separator_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// add old default
				$settings['separator_icon'] = 'fa fa-angle-right';
			}

			$has_icon = ! empty( $settings['separator_icon'] );

			if ( $has_icon ) {
				$this->add_render_attribute( 'separator-icon', 'class', $settings['separator_icon'] );
				$this->add_render_attribute( 'separator-icon', 'aria-hidden', 'true' );
			}

			if ( ! $has_icon && ! empty( $settings['select_separator_icon']['value'] ) ) {
				$has_icon = true;
			}
			$migrated = isset( $settings['__fa4_migrated']['select_separator_icon'] );
			$is_new = ! isset( $settings['separator_icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $has_icon ) { ?>
				<span class='be-separator-icon be-icon'>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings['select_separator_icon'], [ 'aria-hidden' => 'true' ] );
					} elseif ( ! empty( $settings['separator_icon'] ) ) {
						?><i <?php echo $this->get_render_attribute_string( 'separator-icon' ); ?>></i><?php
					}
					?>
				</span>
			<?php }

        } else {

            $this->add_inline_editing_attributes( 'separator_text' );
            $this->add_render_attribute( 'separator_text', 'class', 'be-breadcrumbs-separator-text' );

            echo '<span ' . $this->get_render_attribute_string( 'separator_text' ) . '>' . $settings['separator_text'] . '</span>';

        }
		$separator = ob_get_contents();
		ob_end_clean();
        
        return $separator;
	}

	protected function render_separator( $output = true ) {
		$settings = $this->get_settings_for_display();
        
		$html = '<li class="be-breadcrumbs-separator">';
        $html .= $this->get_separator();
		$html .= '</li>';

		if ( $output === true ) {
			echo $html;
			return;
		}

		return $html;
	}

	protected function render_home_link() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( [
            'home_item' => [
                'class' => [
                    'be-breadcrumbs-item',
                    'be-breadcrumbs-item-home',
                ],
            ],
            'home_link' => [
                'class' => [
                    'be-breadcrumbs-crumb',
                    'be-breadcrumbs-crumb-link',
                    'be-breadcrumbs-crumb-home'
                ],
                'href' 	=> get_home_url(),
                'title' => $settings['home_text']
            ],
            'home_text' => [
                'class' => [
                    'be-breadcrumbs-text',
                ],
            ]
		] );
		
		if ( ! isset( $settings['home_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['home_icon'] = 'fa fa-home';
		}

		$has_home_icon = ! empty( $settings['home_icon'] );
		
		if ( $has_home_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['home_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}
		
		if ( ! $has_home_icon && ! empty( $settings['select_home_icon']['value'] ) ) {
			$has_home_icon = true;
		}
		$migrated_home_icon = isset( $settings['__fa4_migrated']['select_home_icon'] );
		$is_new_home_icon = ! isset( $settings['home_icon'] ) && Icons_Manager::is_migration_allowed();
		?>
		<li <?php echo $this->get_render_attribute_string( 'home_item' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'home_link' ); ?>>
                <span <?php echo $this->get_render_attribute_string( 'home_text' ); ?>>
                    <?php if ( ! empty( $settings['home_icon'] ) || ( ! empty( $settings['select_home_icon']['value'] ) && $is_new_home_icon ) ) { ?>
						<span class="be-icon">
							<?php
							if ( $is_new_home_icon || $migrated_home_icon ) {
								Icons_Manager::render_icon( $settings['select_home_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( ! empty( $settings['home_icon'] ) ) {
								?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
							}
							?>
						</span>
                    <?php } ?>
                    <?php echo $settings['home_text']; ?>
                </span>
			</a>
		</li>
		<?php

		$this->render_separator();

	}

    /**
	 * Render breadcrumbs widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {
    }

}