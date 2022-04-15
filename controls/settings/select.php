<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;
?>
<option <?php echo esc_attr($options['selected']=== true ? 'selected' : ''); ?> value="<?php echo esc_attr($value); ?>" >
        <?php echo esc_attr($value);?>
        <?php echo ($suffix)?$suffix:null;?>
</option>