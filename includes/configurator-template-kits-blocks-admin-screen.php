<?php
$woo    = is_plugin_active( 'woocommerce/woocommerce.php' );
$sections = [
    'dashboard' => [
        'title' => esc_html__('Dashboard', 'blank-elements-pro'),
        'sub-title' => esc_html__('General info', 'blank-elements-pro'),
        'icon' => '',
    ],
    'elements' => [
        'title' => esc_html__('Elements', 'blank-elements-pro'),
        'sub-title' => esc_html__('Enable & Disable widgets', 'blank-elements-pro'),
        'icon' => '',
    ],
    'modules' => [
        'title' => esc_html__('Theme Builder', 'blank-elements-pro'),
        'sub-title' => esc_html__('Enable & Disable Theme Builder Elements', 'blank-elements-pro'),
        'icon' => '',
    ],
    /**'userdata' => [
        'title' => esc_html__('User Data', 'blank-elements-pro'),
        'sub-title' => esc_html__('Data for fb, mailchimp etc', 'blank-elements-pro'),
        'icon' => '',
    ],**/
    'shoplayout' => [
        'title' => esc_html__('Shop', 'blank-elements-pro'),
        'sub-title' => esc_html__('Shop Single Page,Shop Page Style', 'blank-elements-pro'),
        'icon' => '',
    ],

];
if(!$woo ){
    unset($sections["shoplayout"]); 
}


$blank_elements_options = get_option( 'blank-elements-pro', array() );

?>
<div class="blankelements_wrapper">
    <div class="settings_container">
        <form action="options.php" method="post" id="settings-page-form">
            <?php
                settings_fields('blank-elements-pro-options');
            ?>
            <div class="attr-row primary_area">
                <div class="attr-col-md-4">
                    <div class="blankelements_logo">
                        <<img src="<?php echo Configurator_Template_Kits_Blocks_URL . '/assets/images/official-logo-white.png'; ?>" />
                        <!-- <h1 style="color:#fff;">Configurator Elements</h1> -->
                    </div>
                    <div class="blank_vertical_tabs" id="blankelements_vertical_tabs" role="tablist" aria-orientation="vertical">
                        <ul class="attr-nav attr-nav-tabs">
                            <?php foreach($sections as $section_key => $section): reset($sections);?>
                            <li role="presentation" class="<?php echo ($section_key !== key($sections)) ? : 'attr-active'; ?>">
                                <a class="blank_tab_link" id="blankelements-<?php echo esc_attr($section_key); ?>-tab" data-attr-toggle="pill" href="#blankelements-<?php echo esc_attr($section_key); ?>" role="tab"
                                    aria-controls="blankelements-<?php echo esc_attr($section_key); ?>" data-attr-toggle="tab" role="tab">
                                    <div class="blank-tab-content">
                                        <span class="blank-admin-title"><?php echo esc_html($section['title']); ?></span>
                                        <span class="blank-admin-subtitle"><?php echo esc_html($section['sub-title']); ?></span>
                                    </div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="attr-col-md-8">
                    <div class="attr-tab-content" id="blankelements-tab-contents">
                        <?php foreach($sections as $section_key => $section): ?>
                            <div class="attr-tab-pane <?php echo ($section_key !== key($sections)) ? : 'attr-active'; ?>" id="blankelements-<?php echo esc_attr($section_key); ?>" role="tabpanel" aria-labelledby="#blankelements-<?php echo esc_attr($section_key); ?>">
                                <div class="blankelements-content-head">
                                    <div class="tab_titles">
                                    <h2 class="head_title">
                                        <?php echo esc_html($section['title']); ?>
                                    </h2>                
                                    <h4 class="head_subtitle">
                                        <?php echo esc_html($section['sub-title']); ?>
                                    </h4>
                                    </div>
                                    <div class="blank-input-switch">
                                        <button type="submit" class="attr-btn-primary attr-btn settings-form-submit-btn"><div class="loader"></div>
                                            <i class="eicon eicon-save-o"></i>
                                            <?php esc_html_e('Save Changes', 'blank-elements-pro'); ?>
                                        </button>
                                    </div>
                                    <div class="settings_message">
                                        <?php esc_html_e('Settings saved successfully', 'blank-elements-pro'); ?>
                                    </div>
									
                                </div>
                                <?php include Configurator_Template_Kits_Blocks_INCLUDES_PATH . '/views/settings-' . $section_key . '.php'; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>