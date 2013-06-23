<?php

class admin_menu {

    private static $init;
    private $all_items;
    private $hash;

    private function __construct() {
	$items = array();
	if (user::init()->is_authorized()) {
	    $items = array('bookings' => 'Заказы', 'pages' => 'Страницы', 'settings' => 'Настройки', 'brands' => 'Бренды', 'dolls' => 'Куклы', 'uploads' => 'Загрузки');
	}
	if ($items) {
	    $i = 1;
	    foreach ($items as $name => $title) {
		$menu_item = new menu_item();
		$menu_item->set_id($i);
		$menu_item->set_name($name);
		$menu_item->set_title($title);
		$menu_item->set_deleted(false);
		$menu_item->set_active(true);
		if ($i == 1) {
		    $menu_item->set_is_default(true);
		    $this->hash['default_menu_item'] = $menu_item;
		} else {
		    $menu_item->set_is_default(false);
		}
		$this->all_items[] = $menu_item;
		$this->hash[$name] = $menu_item;
		$i++;
	    }
	}
    }

    public static function init() {
	if (self::$init === null) {
	    self::$init = new self();
	}
	return self::$init;
    }

    public function get_menu($name) {
	if (isset($this->hash[$name])) {
	    return $this->hash[$name];
	}
	return false;
    }

    public function get_default_item() {
	if (isset($this->hash['default_menu_item']) && $this->hash['default_menu_item']->is_init()) {
	    return $this->hash['default_menu_item'];
	}
	return false;
    }

    public function get_all_items() {
	return $this->all_items;
    }

}

?>