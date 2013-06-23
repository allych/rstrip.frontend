<?php
/*
 *	Parse URL like this:
 * 
 *	http://example.com/part1/part2/part3
 * 
 *	where
 *		part1 - controller name
 *		part2 - action
 *		part3 - unique id of object
 * 
 *	and calls required method of required controller or redirect to error
 */

class router {

	public function __construct() {
	}

	public function delegate() {
		$route = is_null(registry::get('route')) ? '' : registry::get('route');

		$route = trim($route, '/\\');
		$parts = explode('/', $route);
		
		if (count($parts) == 1 && $parts[0] == ''){
			$controller = 'index';
			$action = 'index';
		}
		else{
			$file = SITE_PATH . registry::get('controllers_directory') . DIRSEP . $parts[0] . '.php';
			if (file_exists($file)) {
				$controller = array_shift($parts);
				$action = array_shift($parts);
				if (empty($action)) {
					$action = 'index';
				}
				if ($parts) {
					registry::set('params', $parts);
				}
			} else {
				$controller = 'error';
				$action = 'index';
			}
		}

		$file = SITE_PATH . registry::get('controllers_directory') . DIRSEP . $controller . '.php';
		include ($file);

		$class = 'controller_' . $controller;
		$controller = new $class();

		if (is_callable(array($controller, $action)) === false) {
			$controller = 'error';
			$action = 'index';

			$file = SITE_PATH . registry::get('controllers_directory') . DIRSEP . $controller . '.php';
			include ($file);
			
			$class = 'controller_' . $controller;
			$controller = new $class();
		}

		$controller->$action(registry::get('params'));
	}

}

?>