<?php

class controller_map extends public_controller {

	public function index($args) {
		$this->template->add_script('map');

		$this->template->show('map');
	}

}

?>