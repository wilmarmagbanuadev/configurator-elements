<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$label_name = str_replace("-", " ", $value);

?>

<div class="attr-input attr-input-switch <?php echo esc_attr($class); ?>">

    <div class="blank-input-switch attr-body">
        <label class="blank-admin-control-label"  for="blank-admin-switch_<?php echo esc_attr($widgets_class::strify($name) . $value); ?>">
            <span class="blank-admin-label-name"> 
                <?php echo esc_html(ucwords($label_name), 'blank-elements-pro'); ?>
            </span>
            <span class="blank-admin-control-label-switch" data-active="ON" data-inactive="OFF"></span>
        </label>
        <input <?php echo esc_attr($options['checked'] === true ? 'checked' : ''); ?> 
            type="checkbox" value="<?php echo esc_attr($value); ?>" 
            class="blank-admin-control-input" 
            name="<?php echo esc_attr($name); ?>" 
            id="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) . $value); ?>"
        >
    </div>

</div>