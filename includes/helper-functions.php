<?php
// Get all forms of Contact Form 7 plugin
if ( !function_exists('blank_pro_get_contact_form_7_forms') ) {
    function blank_pro_get_contact_form_7_forms() {
        if ( function_exists( 'wpcf7' ) ) {
            $options = array();

            $args = array(
                'post_type'         => 'wpcf7_contact_form',
                'posts_per_page'    => -1
            );

            $contact_forms = get_posts( $args );

            if ( ! empty( $contact_forms ) && ! is_wp_error( $contact_forms ) ) {

            $i = 0;

            foreach ( $contact_forms as $post ) {	
                if ( $i == 0 ) {
                    $options[0] = esc_html__( 'Select a Contact form', 'blank-elements-pro' );
                }
                $options[ $post->ID ] = $post->post_title;
                $i++;
            }
            }
        } else {
            $options = array();
        }

        return $options;
    }
}
?>