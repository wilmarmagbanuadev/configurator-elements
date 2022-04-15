<?php
$widgets_class = new Blank_Elements_Pro_Admin_Settings;
?>

<div class="blank_tab_content_head">
    <h2 class="content_head_title">
        <?php esc_html_e('User Data', 'blank-elements-pro'); ?>
    </h2>
    <h4 class="content_head_description">
        <?php esc_html_e('You can disable the modules you are not using on your site. That will disable all associated assets of those modules to improve your site loading.', 'blank-elements-pro'); ?>
    </h4>
</div>

<div class="elements-list-container">
    <div class="elements-list-section">
        <div class="panel-group attr-accordion" id="accordion" role="tablist" aria-multiselectable="true">
            <!-- Mailchimp Data -->
            <div class="attr-panel blank-accordian-panel">
                <div class="attr-panel-heading" role="tab" id="mail_chimp_heading">
                    <a class="attr-btn attr-collapsed" role="button" data-attr-toggle="collapse" data-parent="#accordion"
                        href="#mail_chimp_data_control" aria-expanded="true"
                        aria-controls="mail_chimp_data_control">
                        <?php esc_html_e('Mail Chimp Data', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="mail_chimp_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="mail_chimp_heading">
                    <div class="attr-panel-body">
                        <?php
                              $widgets_class->input([
                                  'type' => 'text',
                                  'name' => 'blank-elements[mail-chimp]',
                                  'label' => esc_html__('Mailchimp Token', 'blank-elements-pro'),
                                  'placeholder' => '24550c8cb06076751a80274a52878-us20',
                                  'value' => '',
                              ]);
                          ?>
                    </div>
                </div>
            </div>
            <!-- Facebook Data -->
            <div class="attr-panel blank-accordian-panel">
                <div class="attr-panel-heading" role="tab" id="facebook_heading">
                    <a class="attr-btn attr-collapsed" role="button"  data-attr-toggle="collapse" data-parent="#accordion"
                        href="#facebook_data_control" aria-expanded="true"
                        aria-controls="facebook_data_control">
                        <?php esc_html_e('Facebook User Data', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="facebook_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="facebook_heading">
                    <div class="attr-panel-body">
                        <?php
                              $widgets_class->input([
                                  'type' => 'text',
                                  'name' => 'blank-elements[face_book]',
                                  'label' => esc_html__('Facebook Token', 'blank-elements-pro'),
                                  'placeholder' => '24550c8cb06076751a80274a52878-us20',
                                  'value' => '',
                              ]);
                          ?>
                    </div>
                </div>
            </div>
            <!-- Twitter Data -->
            <div class="attr-panel blank-accordian-panel">
                <div class="attr-panel-heading" role="tab" id="twitter_heading">
                    <a class="attr-btn attr-collapsed" role="button"  data-attr-toggle="collapse" data-parent="#accordion"
                        href="#twitter_data_control" aria-expanded="true"
                        aria-controls="twitter_data_control">
                        <?php esc_html_e('Twitter User Data', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="twitter_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="twitter_heading">
                    <div class="attr-panel-body">
                        <?php
                              $widgets_class->input([
                                  'type' => 'text',
                                  'name' => 'blank-elements[twit_ter]',
                                  'label' => esc_html__('Twitter Token', 'blank-elements-pro'),
                                  'placeholder' => '24550c8cb06076751a80274a52878-us20',
                                  'value' => '',
                              ]);
                          ?>
                    </div>
                </div>
            </div>    

            <!-- Instagram Data -->
            <div class="attr-panel blank-accordian-panel">
                <div class="attr-panel-heading" role="tab" id="instagram_heading">
                    <a class="attr-btn attr-collapsed" role="button"  data-attr-toggle="collapse" data-parent="#accordion"
                        href="#instagram_data_control" aria-expanded="true"
                        aria-controls="instagram_data_control">
                        <?php esc_html_e('Instagram User Data', 'blank-elements-pro'); ?>
                    </a>
                </div>
                <div id="instagram_data_control" class="attr-panel-collapse attr-collapse" role="tabpanel" aria-labelledby="instagram_heading">
                    <div class="attr-panel-body">
                        <?php
                         $widgets_class->input([
                                  'type' => 'text',
                                  'name' => 'blank-elements[insta_gram]',
                                  'label' => esc_html__('Instagram Token', 'blank-elements-pro'),
                                  'placeholder' => '24550c8cb06076751a80274a52878-us20',
                                  'value' => '',
                              ]);
                          ?>
                    </div>
                </div>
            </div>               
        </div>
    </div>
</div>
