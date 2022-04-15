<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Checks if Header is enabled from Blankelements.
 *
 * @since  1.0.2
 * @return bool True if header is enabled. False if header is not enabled
 */
function blankelements_pro_header_enabled() {
	$header_id = Blank_Elements_Admin::get_settings( 'type_header', '' );
	$status    = false;

	if ( '' !== $header_id ) {
		$status = true;
	}

	return apply_filters( 'blankelements_pro_header_enabled', $status );
}

/**
 * Checks if Footer is enabled from HFE.
 *
 * @since  1.0.2
 * @return bool True if header is enabled. False if header is not enabled.
 */
function blankelements_pro_footer_enabled() {
	$footer_id = Blank_Elements_Admin::get_settings( 'type_footer', '' );
	$status    = false;

	if ( '' !== $footer_id ) {
		$status = true;
	}

	return apply_filters( 'blankelements_pro_footer_enabled', $status );
}

/**
 * Get Header ID
 *
 * @since  1.0.0
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_blankelements_pro_header_id() {
	$header_id = Blank_Elements_Admin::get_settings( 'type_header', '' );

	if ( '' === $header_id ) {
		$header_id = false;
	}

	return apply_filters( 'get_blankelements_pro_header_id', $header_id );
}

/**
 * Get Footer ID
 *
 * @since  1.0.0
 * @return (String|boolean) header id if it is set else returns false.
 */
function get_blankelements_pro_footer_id() {
	$footer_id = Blank_Elements_Admin::get_settings( 'type_footer', '' );

	if ( '' === $footer_id ) {
		$footer_id = false;
	}

	return apply_filters( 'get_blankelements_pro_footer_id', $footer_id );
}

/**
 * Display header markup.
 *
 * @since  1.0.2
 */
function blankelements_pro_render_header() {

	if ( false == apply_filters( 'enable_blankelements_pro_render_header', true ) ) {
		return;
	}

	?>
		<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
			<p class="main-title blankelements-hidden" itemprop="headline"><a href="<?php echo bloginfo( 'url' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php Blank_Elements_Admin::get_header_content(); ?>
		</header>

	<?php

}

/**
 * Display footer markup.
 *
 * @since  1.0.2
 */
function blankelements_pro_render_footer() {

	if ( false == apply_filters( 'enable_blankelements_pro_render_footer', true ) ) {
		return;
	}

	?>
		<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
			<?php Blank_Elements_Admin::get_footer_content(); ?>
		</footer>
	<?php

}


function render_pro_elementor_content($content_id){
		$elementor_instance = \Elementor\Plugin::instance();
		return $elementor_instance->frontend->get_builder_content_for_display( $content_id , true);
	}

function render_pro_elementor_content_css($content_id){

	$css_file = '';
	if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
		$css_file = new \Elementor\Core\Files\CSS\Post( $content_id );
	} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
		$css_file = new \Elementor\Post_CSS_File( $content_id );
	}

    if(!empty($css_file)) {
    	$css_file->enqueue();
	}

}

