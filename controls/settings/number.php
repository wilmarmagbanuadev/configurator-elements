<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;

$label_name = str_replace("-", " ", $label);
?>

<div class="form-group blank-input-number blank-input-number-<?php echo esc_attr($widgets_class::strify($name)); ?>">
    <label for="blank-admin-option-number<?php echo esc_attr($widgets_class::strify($name)); ?>">
        <span class="blank-admin-label-name"> 
            <?php echo esc_html(ucwords($label_name), 'blank-elements-pro'); ?>
        </span>
    </label>
    <input
        type="number"
        class="attr-form-control"
        id="blank-admin-option-number<?php echo esc_attr($widgets_class::strify($name)); ?>"
        aria-describedby="blank-admin-option-number-help<?php echo esc_attr($widgets_class::strify($name)); ?>"
        placeholder="<?php echo esc_attr($placeholder); ?>"
        name="<?php echo esc_attr($name); ?>"
        value="<?php echo esc_attr($value); ?>"
    >
    <small id="blank-admin-option-number-help<?php echo esc_attr($widgets_class::strify($name)); ?>" class="form-number text-muted"><?php echo esc_html($info); ?></small>
</div>