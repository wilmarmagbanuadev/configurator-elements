<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Pro_Lib_Handler {
    private $dir;
    private $url;
    private $server_url;
    private $sources;

    public function __construct() {
        $this->sources = [ 'blankelements_api', ];
        $this->server_url = $this->api_url() . '/library/templates';
        $this->dir = dirname(__FILE__) . '/';
        $this->url = trailingslashit(plugin_dir_url( __FILE__ )) . 'templates/';

        add_action('wp_ajax_blankelements_get_templates', array(
            $this,
            'get_templates'
        ));

        add_action('wp_ajax_blankelements_core_clone_template', array(
            $this,
            'clone_template'
        ));
        add_action('wp_ajax_blankelements_get_layouts', [$this, 'get_layouts']);
        if (defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, '2.2.8', '>'))
        {

            add_action('elementor/ajax/register_actions', array(
                $this,
                'register_ajax_actions'
            ) , 20);
        }
        else
        {
            add_action('wp_ajax_elementor_get_template_data', array(
                $this,
                'get_template_data'
            ) , -1);
        }
    }

	public function api_url(){
			return Configurator_Template_Kits_Blocks_URL;
    }
    
    public function get_license()
    {
        return ['key' => null, 'oppai' => '' , 'package_type' => 'free' ];
    }

  	public static function kses( $raw ) {

		$allowed_tags = array(
			'a'								 => array(
				'class'	 => array(),
				'href'	 => array(),
				'rel'	 => array(),
				'title'	 => array(),
			),
			'abbr'							 => array(
				'title' => array(),
			),
			'b'								 => array(),
			'blockquote'					 => array(
				'cite' => array(),
			),
			'cite'							 => array(
				'title' => array(),
			),
			'code'							 => array(),
			'del'							 => array(
				'datetime'	 => array(),
				'title'		 => array(),
			),
			'dd'							 => array(),
			'div'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'dl'							 => array(),
			'dt'							 => array(),
			'em'							 => array(),
			'h1'							 => array(
				'class' => array(),
			),
			'h2'							 => array(
				'class' => array(),
			),
			'h3'							 => array(
				'class' => array(),
			),
			'h4'							 => array(
				'class' => array(),
			),
			'h5'							 => array(
				'class' => array(),
			),
			'h6'							 => array(
				'class' => array(),
			),
			'i'								 => array(
				'class' => array(),
			),
			'img'							 => array(
				'alt'	 => array(),
				'class'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'width'	 => array(),
			),
			'li'							 => array(
				'class' => array(),
			),
			'ol'							 => array(
				'class' => array(),
			),
			'p'								 => array(
				'class' => array(),
			),
			'q'								 => array(
				'cite'	 => array(),
				'title'	 => array(),
			),
			'span'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'iframe'						 => array(
				'width'			 => array(),
				'height'		 => array(),
				'scrolling'		 => array(),
				'frameborder'	 => array(),
				'allow'			 => array(),
				'src'			 => array(),
			),
			'strike'						 => array(),
			'br'							 => array(),
			'strong'						 => array(),
			'data-wow-duration'				 => array(),
			'data-wow-delay'				 => array(),
			'data-wallpaper-options'		 => array(),
			'data-stellar-background-ratio'	 => array(),
			'ul'							 => array(
				'class' => array(),
			),
		);

		if ( function_exists( 'wp_kses' ) ) { // WP is here
			return wp_kses( $raw, $allowed_tags );
		} else {
			return $raw;
		}
	}	

	public function get_layouts(){
		isset($_GET['tab'])||exit();
        $query=array_merge(['action'=>'get_layouts','tab'=>(empty($_GET['tab'])?'blankelements_page':$_GET['tab']),],$this->get_license());
        $request_url=$this->server_url.'?'.http_build_query($query);
        $tab = empty($_GET['tab']) ? 'blankelements_page' : $_GET['tab'];
        $tab_api_url = $this->url . 'template-' . $tab . '.json'; 
        $response_json = file_get_contents( $tab_api_url );
        $response = json_decode( $response_json, true );
		if($response){
			echo $this::kses(wp_json_encode($response));exit;
		}
	}

    public function get_layout_data() {
        $actions = !isset($_POST['actions']) ? '' : $_POST['actions'];
        $actions = json_decode(stripslashes($actions) , true);
        $template_data = reset($actions);
        // $query = ['action' => 'get_layout_data', 'id' => $template_data['data']['template_id'], ];
        // $request_url = $this->server_url . '?' . http_build_query($query);
        // $response = wp_remote_get($request_url, array(
        //     'timeout' => 120,
        //     'httpversion' => '1.1',
        // ));
        // $response_body = $response['body'];
        $template_api_url = $this->url . 'template-' . $template_data['data']['template_id'] . '.json';
        $response_json = file_get_contents( $template_api_url );
        $content = json_decode($response_json, true);
        @$content = $this->process_import_ids($content);
        @$content = $this->process_import_content($content, 'on_import');
        return $content;
    }

    public function register_ajax_actions($ajax) {
        if (!isset($_POST['actions']))
        {
            return;
        }
        $actions = json_decode(stripslashes($_REQUEST['actions']) , true);
        $data = false;
        foreach ($actions as $id => $action_data)
        {
            if (!isset($action_data['get_template_data']))
            {
                $data = $action_data;
            }
        }
        
        if (!$data)
        {
            return;
        }
        if (!isset($data['data']))
        {
            return;
        }
        if (!isset($data['data']['source']))
        {
            return;
        }
        $source = $data['data']['source'];
        if (!in_array($source, $this->sources))
        {
            return;
        }

        $ajax->register_ajax_action('get_template_data', function ($data)
        {
            return $this->get_layout_data();
        });
    }

    protected function process_import_ids($content) {
        return \Elementor\Plugin::$instance
            ->db->iterate_data($content, function ($element)
        {
            $element['id'] = \Elementor\Utils::generate_random_string();
            return $element;
        });
    }

    protected function process_import_content($content, $method)
    {
        return \Elementor\Plugin::$instance
            ->db->iterate_data($content, function ($element_data) use ($method)
        {
            $element = \Elementor\Plugin::$instance
                ->elements_manager
                ->create_element_instance($element_data);
            if (!$element)
            {
                return null;
            }
            $r = $this->process_import_element($element, $method);
            return $r;
        });
    }
    protected function process_import_element($element, $method)
    {
        $element_data = $element->get_data();
        if (method_exists($element, $method))
        {
            $element_data = $element->{$method}($element_data);
        }
        foreach ($element->get_controls() as $control)
        {
            $control_class = \ELementor\Plugin::$instance
                ->controls_manager
                ->get_control($control['type']);
            if (!$control_class)
            {
                return $element_data;
            }
            if (method_exists($control_class, $method))
            {
                $element_data['settings'][$control['name']] = $control_class->{$method}($element->get_settings($control['name']) , $control);
            }
        }
        return $element_data;
    }
}

new Pro_Lib_Handler();