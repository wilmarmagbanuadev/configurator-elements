<?php

$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$modules_all = $widgets_class -> advanced_f();

$active_advanced_f = ! empty( $blank_elements_options['advanced_f'] ) ? $blank_elements_options['advanced_f'] : array(); 

// /echo var_dump($active_advanced_f );

// check if in array

// if(in_array("a m p", $active_advanced_f)){
//     echo 'amp exist!';
// }elseif(in_array("g s a p", $active_advanced_f)){
//     echo 'gsap exist!';
// }else{
//     echo 'no active!';
// }
?>
<div class="blank_tab_content_head">
    <h2 class="content_head_title">
        <?php //esc_html_e('Active Advanced List', 'blank-elements-pro'); ?>
    </h2>
    <h4 class="content_head_description">
        <?php //esc_html_e('You can disable the advance function if you are not using on your site.', 'blank-elements-pro'); ?>
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
                        'name' => 'blank-elements-pro[advanced_f][]',
                        'value' => $module,
                        'class' => (($pro == false ) ? 'blank-free-element' : 'blank-pro-element'),
                        'attributes' => (($pro == false ) ? [] : [
                            'data-attr-toggle' => 'modal',
                            'data-target' => '#blank_pro_modal'
                        ]),
                        'options' => [
                            'checked' => (( in_array( $module, $active_advanced_f ) && $pro == false) ? true : false),
                        ]
                    ]);
                ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

