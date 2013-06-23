<?php

abstract class private_controller {

    private $template;

    public function __construct() {
	if (user::init()->is_authorized()) {
	    $this->template = new template();
	    $this->set('controller_name', $this->get_controller_name());
	    $this->load_css_files();
	    $this->load_script_files();
	} else {
	    $this->redirect('authorization');
	}
    }

    protected function get_controller_name() {
	return str_replace('controller_', '', get_class($this));
    }

    private function load_css_files() {
	$this->template->add_css('common');
	$this->template->add_css('style');
	$this->template->add_css('slider');
	$this->template->add_css('wpsc-default', 'all');
	$this->template->add_css('prettyPhoto');
	$this->template->add_css('index');
    }

    private function load_script_files() {
	$this->template->add_script('jquery');
	$this->template->add_script('slider');
	$this->template->add_script('hoverIntent');
	$this->template->add_script('jcarousel');
	$this->template->add_script('jquery.tweetable');
	$this->template->add_script('easySlider');
	$this->template->add_script('theme');
	$this->template->add_script('jquery.prettyPhoto');
	$this->template->add_script('index');
    }

    protected function set($name, $value) {
	$this->template->set($name, $value);
    }

    protected function add_css($name) {
	$this->template->add_css($name);
    }

    protected function add_script($name) {
	$this->template->add_script($name);
    }

    protected function show_template($path = '') {
	if ($path == '') {
	    $this->template->show(registry::get('path'));
	} else {
	    $this->template->show($path);
	}
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

    abstract public function index($args = array());

    public function is_right_url($url) {
	$menu_item = menu::init()->get_menu($url);
	return !$menu_item ? false : true;
    }

}

?>