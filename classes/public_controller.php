<?php

abstract class public_controller {

	private $xml;
	protected $template;

	public function __construct() {
		$this->reset_xml();
		$this->template = new template();
		$this->template->set('controller_name', $this->get_controller_name());
		$this->load_css_files();
		$this->load_script_files();
	}

	protected function get_controller_name() {
		return str_replace('controller_', '', get_class($this));
	}

	private function reset_xml() {
		$this->xml = new DOMDocument("1.0", "utf-8");
		$this->root = $this->xml->createElement('list');
		$this->xml->appendChild($this->root);
	}

	protected function send_xml() {
		if (user::init()->has_error()) {
			$this->reset_xml();
			$item = $this->root->appendChild(new DOMElement('error'));
			$item->setAttribute('text', user::init()->get_error_message());
		}
		header('Content-Type: text/xml');
		echo $this->xml->saveXML();
	}

	private function load_css_files() {
		$this->template->add_css('bootstrap');
		$this->template->add_css('content');
		$this->template->add_css('index');
	}

	private function load_script_files() {
		$this->template->add_script('jquery');
		$this->template->add_script('index');
	}

	protected function redirect($controller = '') {
		$subdomain = '';
		if (registry::get('subdomain') == 'admin') {
			$subdomain = 'admin.';
		}
		if ($controller == '') {
			header::set_location('http://' . WWW . $subdomain . SITE_HOST . '/' . registry::get('default_controller'));
			die();
		}
		header::set_location('http://' . WWW . $subdomain . SITE_HOST . '/' . $controller);
		die();
	}

	abstract public function index($arg);

	public function is_right_url($url) {
		$menu_item = menu::init()->get_menu($url);
		return !$menu_item ? false : true;
	}

}

?>