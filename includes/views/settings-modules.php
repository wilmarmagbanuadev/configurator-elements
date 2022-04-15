<?php

$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$modules_all = $widgets_class -> default_modules();

$active_module_list = ! empty( $blank_elements_options['module-list'] ) ? $blank_elements_options['module-list'] : array(); 
?>
<div class="blank_tab_content_head">
    <h2 class="content_head_title">
        <?php esc_html_e('Active Modules List', 'blank-elements-pro'); ?>
    </h2>
    <h4 class="content_head_description">
        <?php esc_html_e('You can disable the modules you are not using on your site. That will disable all associated assets of those modules to improve your site loading.', 'blank-elements-pro'); ?>
    </h4>
</div>
<div class="elements-list-container">
    <div class="elements-list-section">
        <div class="attr-row">
            <?php foreach($modules_all as $module): ?>
            <div class="attr-col-md-6 attr-col-lg-4">
                <?php
                    $pro = ($module && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                    $widgets_class->input([
                        'type' => 'switch',
                        'name' => 'blank-elements-pro[module-list][]',
                        'value' => $module,
                        'class' => (($pro == false ) ? 'blank-free-element' : 'blank-pro-element'),
                        'attributes' => (($pro == false ) ? [] : [
                            'data-attr-toggle' => 'modal',
                            'data-target' => '#blank_pro_modal'
                        ]),
                        'options' => [
                            'checked' => (( in_array( $module, $active_module_list ) && $pro == false) ? true : false),
                        ]
                    ]);
                ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

