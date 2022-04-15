<?php do_action('blankelements_pro/template/before_footer'); ?>
<div class="blankelements_footer_wrapper blankelements_footer_area">
<?php
	$activate = new Pro_Connector();
	$template = $activate -> template_ids();
	echo render_pro_elementor_content($template[1]); 
?>
</div>
<?php do_action('blankelements_pro/template/after_footer'); ?>
<?php wp_footer(); ?>

</body>
</html>
