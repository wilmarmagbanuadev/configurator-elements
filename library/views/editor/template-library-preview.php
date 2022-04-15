<div id="blankelements-back-to-template">
    <button type="button" class="blankelements-template-library-back">
        <i class="dashicons dashicons-arrow-left-alt2"></i>
        <?php echo esc_html('Back to templates', 'blank-elements-pro' ); ?>
    </button>
</div>
<div class="blankelements-template-info">
    <div class="blankelements-col-md-7">
            <span class="blankelements-pro-badge"></span>
            <span class="pro-badge-triangle"></span>
        <img class="blankelements-template-preview-img" src="<?php echo $template_url . 'preview/';  ?>">
    </div>
    <div class="blankelements-col-md-5">
        <h2 class="blankelements-template-title"></h2>
        <div class="blankelements-template-description">
        </div>
        <button class="elementor-template-library-template-action blankelements-template-library-template-insert elementor-button elementor-button-success">
            <i class="eicon-file-download"></i><span class="elementor-button-title"><?php
                esc_html_e( 'Insert Template', 'blank-elements-pro' );
            ?></span>
        </button>
        <div class="blankelements-add-to-favourite-wrapper">
            <span class="elementor-template-library-template-action blankelements-template-library-favorite-wrapper">
                <b>
                <?php
                    echo esc_html( 'Add to favourite', 'blank-elements-pro' ); 
                ?>
                </b>
                <i class="blankelements_favourite_icon eicon-heart-o" aria-hidden="true"></i>
            </span>
        </div>
    </div>
</div>