<?php

/**
 * READY STEADY TRIP
 *
 * Inspiring travel portal (Frontend)
 *
 * @author Alla Mamontova <allasergeevna@list.ru>
 *
 * @version 0.2 09.05.2013
 */

error_reporting(E_ALL);

define('DIRSEP', DIRECTORY_SEPARATOR);
$site_path = realpath(dirname(__FILE__) . DIRSEP . '.' . DIRSEP) . DIRSEP;
define('SITE_PATH', $site_path);

function __autoload($class_name) {
	$filename = strtolower($class_name) . '.php';
	$file = SITE_PATH . 'classes' . DIRSEP . $filename;
	$file_exists = file_exists($file);
	$folders = get_subfolders(SITE_PATH . 'classes', array());
	foreach ($folders as $folder) {
		if (!$file_exists) {
			$file = $folder . DIRSEP . $filename;
			$file_exists = file_exists($file);
		}
	}

	if ($file_exists === false) {
		return false;
	}
	include ($file);
}

function get_subfolders($folder, $folders) {
	if ($objs = glob($folder . DIRSEP . '*')) {
		foreach ($objs as $obj) {
			if (is_dir($obj)) {
				$folders = get_subfolders($obj, $folders);
				$folders[] = $obj;
			}
		}
	}
	return $folders;
}

require_once(SITE_PATH . 'config.php');

if ($_SERVER['HTTP_HOST'] == WWW . SITE_HOST) {
	registry::init();
	registry::set('css_directory', 'css');
	registry::set('scripts_directory', 'js');
	registry::set('controllers_directory', 'controllers' . DIRSEP . 'client');
	registry::set('templates_directory', 'templates' . DIRSEP . 'client');
	registry::set('personal_area_controller', 'personal_area');

	db::init();

	$url = parse_url($_SERVER['REQUEST_URI']);
	registry::set('route', $url['path']);

	user::init();

	$router = new router();
	$router->delegate();
} else {
	header("Location: http://" . WWW . SITE_HOST . $_SERVER['REQUEST_URI']);
	die();
}

?>