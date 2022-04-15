<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title>
			<?php echo wp_get_document_title(); ?>
		</title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action('blankelements_pro/template/before_header'); ?>
<div class="blankelements_footer_wrapper blankelements_footer_area">
<?php
	$activate = new Pro_Connector();
	$template = $activate -> template_ids();
	echo render_pro_elementor_content($template[0]); 
?>
</div>
<?php do_action('blankelements_pro/template/after_header'); ?>
