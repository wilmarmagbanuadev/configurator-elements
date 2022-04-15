<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;
$label_name = str_replace("-", " ", $value);

?>

<div class="attr-input attr-input-show-hide <?php echo esc_attr($class); ?>">

        <label class="blank-admin-control-label"  for="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) . $value); ?>" style="padding-bottom:5px;">
                <span class="blank-admin-label-name" style="color:#fff;"> 
                <?php echo esc_html(ucwords($label_name), 'blank-elements-pro'); ?>
                </span>
                <span class="blank-admin-control-label-switch" data-active="ON" data-inactive="OFF"></span>
            </label> 
        <?php
        if($info=='hide' && $value =='hide'){?>
            <input checked 
                type="radio" value="<?php echo esc_attr($value); ?>" 
                class="blank-control-input <?php echo esc_attr($value); ?>" 
                name="<?php echo esc_attr($name); ?>" 
                id="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) .$value); ?>"
                value="<?php echo esc_attr($value); ?>"
            >
       <?php }else{ ?>
            <input <?php echo esc_attr($options['checked']=== true ? 'checked' : ''); ?> 
                type="radio" value="<?php echo esc_attr($value); ?>" 
                class="blank-control-input <?php echo esc_attr($value); ?>" 
                name="<?php echo esc_attr($name); ?>" 
                id="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) .$value); ?>"
                value="<?php echo esc_attr($value); ?>"
            >
       <?php } ?>
        
</div>