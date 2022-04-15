<div class="attr-modal attr-fade" id="blankelements_head-foot_modal" tabindex="-1" role="dialog"
	aria-labelledby="blankelements_head-foot_label">
	<div class="attr-modal-dialog attr-modal-dialog-centered" role="document">
		<div class="dialog_content_area">
			<div class="header-dialog blankelements-lightbox-header">
				<div class="blankelements_modal_logo header_logo">
					<span class="header_logo_icon-wrapper">    
						<img src="<?php echo Configurator_Template_Kits_Blocks_URL; ?>/assets/images/official-logo-white.png" alt="<?php echo esc_attr_e('Configurator Template Kits Blocks','blank-elements-pro'); ?>">
					</span>
				</div>
				<div class="blankelements_modal_close modal_close_btn">
				<i class="eicon-close" data-dismiss="modal" aria-hidden="true" title="<?php echo esc_attr_e('Close','blank-elements-pro'); ?>"></i>
				<span class="elementor-screen-only">
					<?php esc_html_e( 'Close', 'blank-elements-pro' );?></span>
				</div>
				<div class="blankelements_modal_title header_title"> 
					<h3>
					<?php esc_html_e( 'New Template', 'blank-elements-pro' );?>
					</h3>
				</div>	
			</div>	
			<div class="message-dialog blankelements-lightbox-message">
				<div class="content-dialog blankelements-lightbox-content">
					<div class="lightbox-content-title">
						<div class="icon">
							<img src="<?php echo Configurator_Template_Kits_Blocks_URL; ?>/assets/images/msg-icon.png" alt="<?php echo esc_attr_e('Message Icon','blank-elements-pro'); ?>">
						</div>
						<?php esc_html_e( 'Build Headers & Footers Easily', 'blank-elements-pro' );?>
					</div>
				</div>
				<div class="form-dialog blankelements-lightbox-form">
					<form action="" method="get" id="blankelements-template-modalinput-form" data-open-editor="0"
						data-editor-url="<?php echo get_admin_url(); ?>" data-nonce="<?php echo wp_create_nonce('wp_rest');?>">
						<!-- <input type="hidden" name="post_author" value ="<?php echo get_current_user_id(); ?>"> -->
						<div class="attr-modal-content">
							<div class="attr-modal-body" id="blankelements_headerfooter_modal_body">
								<div class="blankelements-input-group">
									<label class="attr-input-label"><?php esc_html_e('Title of the template:', 'blank-elements-pro'); ?></label>
									<input required type="text" name="title" placeholder="<?php esc_attr_e('Template Title', 'blank-elements-pro'); ?>" class="blankelements-template-modalinput-title attr-form-control">
								</div>

								<div class="blankelements-input-group">
									<label class="attr-input-label"><?php esc_html_e('Select the type of the template:', 'blank-elements-pro'); ?></label>
									<select name="type" class="blankelements-template-modalinput-type attr-form-control">
										<option value="header"><?php esc_html_e('Header', 'blank-elements-pro'); ?></option>
										<option value="footer"><?php esc_html_e('Footer', 'blank-elements-pro'); ?></option>
									</select>
								</div>

								<div class="blankelements-template-headerfooter-option-container">
									<div class="blankelements-input-group">
										<label class="attr-input-label"><?php esc_html_e('Select where to display the template:', 'blank-elements-pro'); ?></label>
										<select name="condition_a" class="blankelements-template-modalinput-condition_a attr-form-control">
											<option value="entire_site"><?php esc_html_e('Entire Site', 'blank-elements-pro'); ?></option>
											<option value="singular"><?php esc_html_e('All Singlular', 'blank-elements-pro'); ?></option>
											<option value="archive"><?php esc_html_e('All Archives', 'blank-elements-pro'); ?></option>
											<option value="homepage"><?php esc_html_e('Home Page', 'blank-elements-pro'); ?></option>
											<option value="allpage"><?php esc_html_e('All Pages', 'blank-elements-pro'); ?></option>
											<option value="postpage"><?php esc_html_e('Post Page', 'blank-elements-pro'); ?></option>
											<option value="c-postpage"><?php esc_html_e('Custom Post Page', 'blank-elements-pro'); ?></option>
											<option value="searchpage"><?php esc_html_e('Search Page', 'blank-elements-pro'); ?></option>
											<option value="error-page"><?php esc_html_e('404 Error Page', 'blank-elements-pro'); ?></option>
										</select>
									</div>
									<div class="blankelements-template-modalinput-condition_singular-container">
										<div class="blankelements-input-group">
											<label class="attr-input-label"></label>
											<select name="condition_singular"
												class="blankelements-template-modalinput-condition_singular attr-form-control">
											</select>
										</div>
										<div class="blankelements-template-modalinput-condition_singular_id-container blankelements_multipile_ajax_search_filed">
											<div class="blankelements-input-group">
												<label class="attr-input-label"></label>
												<select multiple name="condition_singular_id" class="blankelements-template-modalinput-condition_singular_id"></select>
											</div>
										</div>
									</div>


									<div class="blankelements-switch-group">
										<label class="attr-input-label"><?php esc_html_e('Activate the template:', 'blank-elements-pro'); ?></label>
										<div class="blankelements-admin-input-switch">
											<input checked="" type="checkbox" value="yes"
												class="blankelements-admin-control-input blankelements-template-modalinput-activition"
												name="activation" id="blankelements_activation_modal_input">
											<label class="blankelements-admin-control-label" for="blankelements_activation_modal_input">
												<span class="blankelements-admin-control-label-switch" data-active="YES "
													data-inactive="NO "></span>
											</label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="attr-modal-footer">
								<button type="submit" class="attr-btn attr-btn-primary blankelements-template-save-btn"><?php esc_html_e('Save Changes', 'blank-elements-pro'); ?></button>
								<button type="button" class="attr-btn attr-btn-default blankelements-template-save-btn-editor"><?php esc_html_e('Edit Template', 'blank-elements-pro'); ?></button>
							</div>
							<div class="blankelements-spinner"></div>
							<div class="blankelements-form-overlay"></div>
							<div class="modal_message">
								<?php esc_html_e('Settings saved successfully', 'blank-elements-pro'); ?>
							</div>
							<div class="nodata_message">
								<?php esc_html_e('No changes detected!', 'blank-elements-pro'); ?>
							</div>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>
</div>
