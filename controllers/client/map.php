<?php

class controller_map extends public_controller {

	public function index($args) {
		$this->template->add_script('map');
		$this->template->add_script('bootstrap.file-input');
		$this->template->add_script('jquery.form');
		$this->template->add_script('jquery.dotdotdot.min');

		$this->template->show('map');
	}
	
	public function load_image_poi() {
		$path = "img".DIRSEP."poi".DIRSEP;

		$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
		$max_size = 2;
		
		$result = array ('status' => 'error');

		if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
			$id = $_POST['id'];
			$name = $_FILES['img']['name'];
			$size = $_FILES['img']['size'];
			if (strlen($name)) {
				list($txt, $ext) = explode(".", $name);
				if (in_array(strtolower($ext), $valid_formats)) {
					if ($size < ($max_size * 1024 * 1024)) {
						$actual_image_name = time() . '_' . user::init()->get_id() . "." . strtolower($ext);
						$tmp = $_FILES['img']['tmp_name'];
						if (move_uploaded_file($tmp, SITE_PATH . $path . $actual_image_name)) {
							$result['status'] = 'ok';
							$result['poi'] = array ('id' => $id, 'img' => '/' . str_replace(DIRSEP, '/', $path) . $actual_image_name);
						}
						else {
							$result['error'] = 'Error copying file';
						}
					}
					else {
						$result['error'] = 'Too large file (allowed < '.$max_size.'MB)';
					}
				}
				else {
					$result['error'] = 'Invalid file format (expected extensions: '.implode(', ',$valid_formats).')';
				}
			}
			else {
				$result['error'] = 'Not enough data';
			}
		}
		
		die(json_encode($result));
	}

}

?>