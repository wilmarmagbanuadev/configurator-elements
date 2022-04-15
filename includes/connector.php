<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Pro_Connector {
    public static $instance = null;

    protected $templates;
    public $header_template;
    public $footer_template;

    protected $current_theme;
    protected $current_template;

    protected $post_type = 'blank_elements';

    public function __construct() {
        add_action( 'wp', array( $this, 'hooks' ) );
    }

    public function hooks(){
        $this->current_template = basename(get_page_template_slug());
        if($this->current_template == 'elementor_canvas'){
            return;
        }
        require_once Configurator_Template_Kits_Blocks_INCLUDES_PATH . 'front-editor.php';
        $this->current_theme = new Front_Editor_Pro(self::template_ids());
        
    }

    public static function template_ids(){
        $cached = wp_cache_get( 'blankelements_template_ids' );
        if ( false !== $cached ) {
            return $cached;
        }
        
        $instance = self::instance();
        $instance->the_filter();

        $ids = [
            $instance->header_template,
            $instance->footer_template,
        ];


        wp_cache_set( 'blankelements_template_ids', $ids );
        return $ids;
    }


    protected function the_filter(){
        $arg = [
            'posts_per_page'   => -1,
            'orderby'          => 'id',
            'order'            => 'DESC',
            'post_status'      => 'publish',
            'post_type'        => $this->post_type,
            'meta_query' => [
                [
                    'key'     => 'blankelements_template_activation',
                    'value'   => 'yes',
                    'compare' => '=',
                ],
            ],
        ];
        $this->templates = get_posts($arg);

        // entire site
        if(!is_admin()){
            $filters = [[
                'key'     => 'condition_a',
                'value'   => 'entire_site',
            ]];
            $this->get_header_footer($filters);
        }

        // all archive
        if(is_archive()){
            $filters = [[
                'key'     => 'condition_a',
                'value'   => 'archive',
            ]];
            $this->get_header_footer($filters);
        }

        // all singular
        if(is_page() || is_single() || is_404()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'singular',
                ]
            ];
            $this->get_header_footer($filters);
        }
        
        // all pages, all posts, 404 page
        if(is_page()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'allpage',
                ]
            ];
            $this->get_header_footer($filters);
        }elseif(is_single()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'singular',
                ]
            ];
            $this->get_header_footer($filters);
        }elseif(is_404()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'error-page',
                ]
            ];
            $this->get_header_footer($filters);
        }

        // singular selective
        if(is_page() || is_single()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'singular',
                ]
            ];
            $this->get_header_footer($filters);
        }

        // homepage
        if(is_home() || is_front_page()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'homepage',
                ]
            ];
            $this->get_header_footer($filters);
        }

        // homepage
        if(is_home() || !is_front_page()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'postpage',
                ]
            ];
            $this->get_header_footer($filters);
        }

        if(is_search()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'searchpage',
                ]
            ];
            $this->get_header_footer($filters);
        }
        
        if($this->is_custom_post_type()){
            $filters = [
                [
                    'key'     => 'condition_a',
                    'value'   => 'c-postpage',
                ]
            ];
            $this->get_header_footer($filters);
        }
    }

    protected function get_header_footer($filters){
        $template_id = array();

        if($this->templates != null){
            foreach($this->templates as $template){
                $template = $this->get_full_data($template);
                $match_found = true;

                // WPML Language Check
                if ( defined( 'ICL_LANGUAGE_CODE' ) ):
                    $current_lang = apply_filters( 'wpml_post_language_details', NULL, $template['ID'] );

                    if ( !empty($current_lang) && !$current_lang['different_language'] && ($current_lang['language_code'] == ICL_LANGUAGE_CODE) ):
                        $template_id[ $template['type'] ] = $template['ID'];
                    endif;
                endif;
                
                foreach($filters as $filter){
                    if($filter['key'] == 'condition_singular_id'){
                        $ids = explode(',', $template[$filter['key']]);
                        if(!in_array($filter['value'], $ids)){
                            $match_found = false;
                        }
                    }elseif($template[$filter['key']] != $filter['value']){
                        $match_found = false;
                    }
                    if( $filter['key'] == 'condition_a' && $template[$filter['key']] == 'singular' && count($filters) < 2){
                        $match_found = false;
                    }
                }

                if($match_found == true){
                    if($template['type'] == 'header'){
                        $this->header_template = isset( $template_id['header'] ) ? $template_id['header'] : $template['ID'];
                    }
                    if($template['type'] == 'footer'){
                        $this->footer_template = isset( $template_id['footer'] ) ? $template_id['footer'] : $template['ID'];
                    }
                }
            }
        }
    }

    protected function get_full_data($post){
        if($post != null){
            return array_merge((array)$post, [
                'type' => get_post_meta($post->ID, 'blankelements_template_type', true),
                'condition_a' => get_post_meta($post->ID, 'blankelements_template_condition_a', true),
                'condition_singular' => get_post_meta($post->ID, 'blankelements_template_condition_singular', true),
                'condition_singular_id' => get_post_meta($post->ID, 'blankelements_template_condition_singular_id', true),
            ]);
        }
    }

    public function is_custom_post_type( $post = NULL ) {
        $all_custom_post_types = get_post_types( array ( '_builtin' => FALSE ) );

        // there are no custom post types
        if ( empty ( $all_custom_post_types ) )
            return FALSE;

        $custom_types      = array_keys( $all_custom_post_types );
        $current_post_type = get_post_type( $post );

        // could not detect current type
        if ( ! $current_post_type )
            return FALSE;

        return in_array( $current_post_type, $custom_types );
    }

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
