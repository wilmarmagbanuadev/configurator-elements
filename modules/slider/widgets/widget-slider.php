<?php
namespace BlankElementsPro\Modules\Slider\Widgets;

// You can add to or remove from this list - it's not conclusive! Chop & change to fit your needs.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Slider extends Widget_Base {

	/* Uncomment the line below if you do not wish to use the function _content_template() - leave that section empty if this is uncommented! */
	//protected $_has_template_content = false; 
	
	public function get_name() {
		return 'blank-slider';
	}

	public function get_title() {
		return __( 'Widget Slider', 'blank-elements-pro' );
	}

	public function get_icon() {
		return ' eicon-slideshow';
	}

	public function get_categories() {
		return [ 'configurator-template-kits-blocks-widgets'];
	}
	
	public function get_script_depends() {
		return [ 'imagesloaded', 'blank-slick', 'blank-js' ];
	}

    /**
	 * Register dual heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
    protected function _register_controls() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => __( 'Slides', 'blank-elements-pro' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );
        
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
			'heading',
			[
				'label' => __( 'Title', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slide Heading', 'blank-elements-pro' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'Description', 'blank-elements-pro' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'I am slide description. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'blank-elements-pro' ),
			]
		);

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'blank-elements-pro' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'heading' => __( 'Slide 1 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
					[
						'heading' => __( 'Slide 2 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
					[
						'heading' => __( 'Slide 3 Heading', 'blank-elements-pro' ),
						'description' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'blank-elements-pro' ),
					],
				],
				'title_field' => '{{{ heading }}}',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'image_height',
			[
				'label' => __( 'Height', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-image img' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);
        
        $this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => __( 'Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-slide-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				//'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .blank-slide-title',
			]
		);

		$this->end_controls_section();
        
        $this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Description', 'blank-elements-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'blank-elements-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .blank-slide-content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Text Color', 'blank-elements-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .blank-slide-content,{{WRAPPER}} .blank-slide-content' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				//'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .blank-slide-content,{{WRAPPER}} .blank-slide-content',
			]
		);

		$this->end_controls_section();
	}
    
    protected function render() {
		$settings = $this->get_settings();
        
        $this->add_render_attribute( 'list_carousel', 'class', 'blank-slider' );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'list_carousel' ); ?>>
            <?php foreach ( $settings['slides'] as $index => $slide ) : ?>
                <?php
                    $slide_number = $index + 1;
                ?>
                <div>
                    <div class="blank-slider-wrapper blank-slide-<?php echo $slide_number; ?>">
                        <div class="blank-slide-col blank-col-1">
                            <?php
                                if ( ! empty( $slide['image']['url'] ) ) { ?>
                                    <div class="blank-slide-image"><?php echo Group_Control_Image_Size::get_attachment_image_html( $slide ); ?>
                                    </div>
                                <?php }
                            ?>
                        </div>
                        <div class="blank-slide-col blank-col-2">
                            <div class="container">
                                <div class="blank-slide-title">
                                    <?php echo $slide['heading']; ?>
                                </div>
                                <div class="blank-slide-content">
                                    <?php echo $slide['description']; ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
	}
    
    protected function _content_template() {
        
    }
}