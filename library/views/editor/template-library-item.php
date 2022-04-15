<?php
/**
 * Template item
 */
$template_url = Configurator_Template_Kits_Blocks_URL . 'library/manager/templates/';
?>
<# var activeTab = window.BlankelementsLibData.tabs[ type ]; #>
<div class="blankelements-template-item-wrapper" data-template-id="{{ template_id }}">
	<div class="elementor-template-library-template-body">
		<# if ( 'blankelements-local' !== source ) { #>
		<div class="elementor-template-library-template-screenshot">
			<# if ( 'blankelements-local' !== source ) { #>
			<div class="elementor-template-library-template-preview">
				<i class="fa fa-search-plus"></i>
			</div>
			<# } #>
			<img src="<?php echo $template_url . 'preview/';  ?>{{ thumbnail }}" alt="">

			<# if ( 'pro' == package ) { #>
			<span class="blankelements-pro-badge">
				<?php
					esc_html_e( 'Pro', 'blank-elements-pro' );
				?>
			</span>
			<span class="pro-badge-triangle"></span>
		<# } #>

		</div>
		<# } #>
	</div>
	<div class="elementor-template-library-template-controls">
		<# if ( 'pro' != package ) { #>
		<button class="elementor-template-library-template-action blankelements-template-library-template-insert elementor-button elementor-button-success">
			<i class="eicon-file-download"></i>
			<span class="elementor-button-title"><?php esc_html_e( 'Insert Template', 'blank-elements-pro' ); ?></span>
		</button>
		<# } #>
		<# if ( 'pro' == package ) { #>
		<a  href="https://www.blankelements.com/" target="_blank" >
			<button class="elementor-template-library-template-action blankelements-preview-button-go-pro elementor-button elementor-button-success" >
				<i class="eicon-heart"></i><span class="elementor-button-title"><?php
					esc_html_e( 'Go Pro', 'blank-elements-pro' );
				?></span>
			</button>
		</a>
		<# } #>
	</div>
	<div class="elementor-template-name-sec">
	<# if ( 'blankelements-local' === source || true == activeTab.settings.show_title ) { #>
	<div class="elementor-template-library-template-name">{{{ title }}}</div>
	<# } else { #>
	<div class="elementor-template-library-template-name-holder"></div>
	<# } #>
	<span class="elementor-template-library-template-action blankelements-template-library-favorite-wrapper">
		<i class="blankelements_favourite_icon eicon-heart-o" aria-hidden="true"></i>
	</span>
	</div>
	<# if ( 'blankelements-local' === source ) { #>
	<div class="elementor-template-library-template-type">
		<?php esc_html_e( 'Type:', 'blank-elements-pro' ); ?> {{{ typeLabel }}}
	</div>
	<# } #>
</div>