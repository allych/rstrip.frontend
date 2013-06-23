<?php

class controller_error extends public_controller {

	public function index($args = array()) {
		$this->template->show('error', 'static_page', 'full_width_cover');
	}

}

?>