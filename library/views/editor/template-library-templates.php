<?php
/**
 * Templates list view
 */
$template_url = Configurator_Template_Kits_Blocks_URL . 'library/assets/images/favourites.png';
?>
<div id="blankelements-template-library-templates-container"></div>
<div id="blankelements-template-library-no-favorite-templates" style="display:none;">
	<div class="elementor-template-library-blank-icon">
        <img src="<?php echo esc_url($template_url); ?>" class="elementor-template-library-no-results">
    </div>
    <div>
        <div class="blankelements-template-library-blank-title"><?php echo __( 'No Favorite Templates', 'blank-elements-pro' ); ?></div>
        <div class="blankelements-template-library-blank-message"><?php echo __( 'You can mark any pre-designed template as a favorite.', 'blank-elements-pro' ); ?></div>
    </div>
</div>