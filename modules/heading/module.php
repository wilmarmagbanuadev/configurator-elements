<?php
namespace BlankElementsPro\Modules\Heading;

use BlankElementsPro\Base\Module_Base;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();

		// This is here for extensibility purposes - go to town and make things happen!
	}
	
	public function get_name() {
		return 'blank-multi-heading';
	}

	public function get_widgets() {
		return [
			'Multi_Heading', // What is it goes here. This should match the widget/element class - the file name should also match but in small caps!
		];
	}
	
}