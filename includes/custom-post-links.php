<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Pro_Custom_Post_links {
    public static $instance = null;

    public function __construct() {

        add_action( 'admin_init', [ $this, 'add_author_support_to_column' ], 10 );
        add_filter( 'manage_blank_elements_posts_columns', [ $this, 'set_columns' ] );
        add_action( 'manage_blank_elements_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
        add_filter( 'parse_query', [ $this, 'query_filter' ] );
    }

    public function add_author_support_to_column() {
        add_post_type_support( 'blank_elements', 'author' ); 
    }

    /**
     * Set custom column for template list.
     */
    public function set_columns( $columns ) {

        $date_column = $columns['date'];
        $author_column = $columns['author'];

        unset( $columns['date'] );
        unset( $columns['author'] );

        $columns['type'] = esc_html__( 'Type', 'blank-elements-pro' );
        $columns['status'] = esc_html__( 'Status', 'blank-elements-pro' );
        $columns['condition'] = esc_html__( 'Conditions', 'blank-elements-pro' );
        $columns['date']      = $date_column;
        $columns['author']      = $author_column;

        return $columns;
    }

    /**
     * Render Column
     *
     * Enqueue js and css to frontend.
     *
     * @since 1.0.0
     * @access public
     */
    public function render_column( $column, $post_id ) {
        switch ( $column ) {
            case 'type':
            
                $type = get_post_meta( $post_id, 'blankelements_template_type', true );

                echo ucwords($type);

                break;

                case 'status':
            
                $active = get_post_meta( $post_id, 'blankelements_template_activation', true );
                
                echo (($active == 'yes') 
                ? ( '<span class="blankelements-headerfooter-status blankelements-headerfooter-status-active">'. esc_html__('Active', 'blank-elements-pro') .'</span>' ) 
                : ( '<span class="blankelements-headerfooter-status blankelements-headerfooter-status-inactive">'. esc_html__('Inactive', 'blank-elements-pro') .'</span>' ));

                break;
    
            case 'condition':

                $cond = [
                    'condition_a' => get_post_meta($post_id, 'blankelements_template_condition_a', true),
                ];

                echo ucwords( str_replace('_', ' ',
                    $cond['condition_a']  
                    . (($cond['condition_a'] == 'singular')
                        ? (($cond['condition_singular'] != '' )
                            ? (' > ' . $cond['condition_singular'] 
                            . (($cond['condition_singular_id'] != '')
                                ? ' > ' . $cond['condition_singular_id']
                                : ''))
                            : '')
                        : '')
                ));

                break;
        }
    }
    

    public function  query_filter($query) {
        global $pagenow;
        $current_page = isset( $_GET['post_type'] ) ? sanitize_key($_GET['post_type']) : '';

        if ( 
            is_admin() 
            && 'blank_elements' == $current_page 
            && 'edit.php' == $pagenow   
            && isset( $_GET['blankelements_type_filter'] ) 
            && $_GET['blankelements_type_filter'] != ''
            && $_GET['blankelements_type_filter'] != 'all'
        ){
            $type = sanitize_key($_GET['blankelements_type_filter']);
            $query->query_vars['meta_key'] = 'blankelements_template_type';
            $query->query_vars['meta_value'] = $type;
            $query->query_vars['meta_compare'] = '=';
        }
    }


    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}