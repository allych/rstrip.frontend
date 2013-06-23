<?php

class controller_index extends public_controller {

	public function index($args) {
		$this->template->add_script('jquery.nivo.slider.pack');
		$this->template->add_script('superfish');

		$this->template->show('home', 'static_page', 'full_width_cover');
	}

}

?>