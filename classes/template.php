<?php

class template {

	private $css = array();
	private $scripts = array();
	private $vars = array();

	private $content = '';

	public function __construct() {
		$this->vars['title'] = '';
	}

	public function add_css($path, $media = '') {
		if (!in_array($path, $this->css)) {
			$css = new css($media);
			$css->set_path($path);
			$this->css[] = $css;
		}
	}

	public function add_script($path, $defer = '') {
		if (!in_array($path, $this->scripts)) {
			$script = new script();
			$script->set_path($path);
			if (strnatcmp($defer, '') != 0) {
				$script->set_defer();
			}
			$this->scripts[] = $script;
		}
	}

	public function set($varname, $value, $overwrite = false) {
		$this->vars[$varname] = $value;
	}

	public function remove($varname) {
		unset($this->vars[$varname]);
	}

	public function show($name, $group = '', $cover = '') {
		$path = registry::get('templates_directory') . DIRSEP . ( $group != '' ? $group . DIRSEP : '') . $name . '.php';
		if (file_exists($path) == false) {
			die('No template');
		}

		foreach ($this->vars as $key => $value) {
			$$key = $value;
		};

		if ($cover != '') {
			$cover_path = registry::get('templates_directory') . DIRSEP . $cover . '.php';
			if (file_exists($cover_path) == false) {
				die('No template cover');
			}

			ob_start();
			include ($path);
			$this->content = ob_get_contents();
			ob_end_clean();

			include ($cover_path);
		}
		else{
			include($path);
		}
	}

	private function get_content() {
		return $this->content;
	}

	private function get_css_files() {
		$css_files = '';
		if ($this->css) {
			foreach ($this->css as $css) {
				$css_files .= $css->get_html_include();
			}
		}
		return $css_files;
	}

	private function get_script_files() {
		$script_files = '';
		if ($this->scripts) {
			foreach ($this->scripts as $script) {
				if (!$script->is_defer()) {
					$script_files .= $script->get_html_include();
				}
			}
		}
		return $script_files;
	}

	private function get_defer_script_files() {
		$script_files = '';
		if ($this->scripts) {
			foreach ($this->scripts as $script) {
				if ($script->is_defer()) {
					$script_files .= $script->get_html_include();
				}
			}
		}
		return $script_files;
	}

	private function get_keywords() {
		return 'keywords';
	}


}

?>