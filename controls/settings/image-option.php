<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;
$label_name = str_replace("-", " ", $value);
//echo $value;
?>


<div class="attr-input attr-input-image-choose <?php echo esc_attr($class); ?>">

    <div class="blank-input-switch attr-body">
        <label class="blank-admin-control-label"  for="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) . $value); ?>">
            <span class="blank-admin-label-name"> 
                <?php //echo esc_html(ucwords($label_name), 'blank-elements-pro'); ?>
            </span>
            <span class="blank-admin-control-label-switch" data-active="ON" data-inactive="OFF"></span>
        </label> 
        <?php if($info=='active'){ ?>
            <input <?php echo esc_attr($value=== 'style2' ? 'checked' : ''); ?> 
                type="radio" value="<?php echo esc_attr($value); ?>" 
                class="blank-control-input" 
                style="background-image: url('<?php echo esc_attr($style); ?>');border-radius: unset;width: 120px;height: 171px;background-position: center;background-repeat:no-repeat;background-size:90%"
                name="<?php echo esc_attr($name); ?>" 
                id="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) .$value); ?>"
            >
        <?php }else{ ?>
            <input <?php echo esc_attr($options['checked']=== true ? 'checked' : ''); ?> 
                type="radio" value="<?php echo esc_attr($value); ?>" 
                class="blank-control-input" 
                style="background-image: url('<?php echo esc_attr($style); ?>');border-radius: unset;width: 120px;height: 171px;background-position: center;background-repeat:no-repeat;background-size:90%"
                name="<?php echo esc_attr($name); ?>" 
                id="blank-admin-switch__<?php echo esc_attr($widgets_class::strify($name) .$value); ?>"
            >
        <?php } ?>
      

    </div>

</div>