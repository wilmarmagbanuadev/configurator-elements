<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$widgets_all = $widgets_class -> default_widgets();

$widget_dir = Configurator_Template_Kits_Blocks_PATH . '/modules/';

$active_widget_list = ! empty( $blank_elements_options['widgets-list'] ) ? $blank_elements_options['widgets-list'] : array();
?>
<div class="blank_tab_content_head">
    <h2 class="content_head_title">
        <?php esc_html_e('Active Elements List', 'blank-elements-pro'); ?>
    </h2>
    <h4 class="content_head_description">
        <?php esc_html_e('You can disable the elements you are not using on your site. That will disable all associated assets of those widgets to improve your site loading.', 'blank-elements-pro'); ?>
    </h4>
</div>
<div class="elements-list-container">
    <div class="elements-list-section">
        <div class="attr-row">
            <?php foreach($widgets_all as $widget): ?>
            <div class="attr-col-md-6 attr-col-lg-4">
                <?php
                    $pro = ($widget && $widgets_class::PACKAGE_TYPE == 'free') ? false : true;
                    $widgets_class->input([
                        'type' => 'switch',
                        'name' => 'blank-elements-pro[widgets-list][]',
                        'value' => $widget,
                        'class' => (($pro == false ) ? 'blank-free-element' : 'blank-pro-element'),
                        'attributes' => (($pro == false ) ? [] : [
                            'data-attr-toggle' => 'modal',
                            'data-target' => '#blank_pro_modal'
                        ]),
                        'options' => [
                            'checked' => ((in_array( $widget, $active_widget_list ) && $pro == false) ? true : false),
                        ]
                    ]);
                ?>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

