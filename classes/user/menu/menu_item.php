<?php

class menu_item {

    private $id, $name, $title, $content, $deleted, $active, $order, $is_default;
    private $is_init = false;
    private $submenu, $menu_parent, $id_menu_parent;

    public function __construct($values = array()) {
	if (!is_array($values)) {
	    $values = db::init()->query()->from('menu')->where(array('id', '=', $values))->where(array('deleted', '=', '0'))->where(array('active', '=', '1'))->get_row();
	}
	$this->init_by_array($values);
    }

    public function init_by_name($name) {
	$values = db::init()->query()->from('menu')->where(array('name', '=', $name))->where(array('deleted', '=', '0'))->where(array('active', '=', '1'))->get_row();
	$this->init_by_array($values);
    }

    public function init_default_item() {
	$values = db::init()->query()->from('menu')->where(array('is_default', '=', '1'))->where(array('deleted', '=', '0'))->where(array('active', '=', '1'))->get_row();
	$this->init_by_array($values);
    }

    private function init_by_array($values) {
	if ($values)
	    foreach ($values as $name => $value) {
		$method = 'set_' . $name;
		if (is_callable(array($this, $method)) !== false) {
		    $this->$method($value);
		}
		$this->is_init = true;
	    }
    }

    public function remember() {
	if ($this->id) {
	    db::init()->exec('menu')->values(array(
		'name' => $this->name
		, 'title' => $this->title
		, 'content' => $this->content
		, 'deleted' => $this->deleted ? 1 : '0'
		, 'active' => $this->active ? 1 : '0'
		, 'order' => $this->order
		, 'is_default' => $this->is_default ? 1 : '0'
	    ))->where(array('id', '=', $this->id))->update();
	}
	else{
	    $this->order = 0;
	    $row = db::init()->query('order')->from('menu')->order('order','desc')->get_row();
	    if ($row){
		$this->order = $row['order'] + 1;
	    }

	    $this->id = db::init()->exec('menu')->values(array(
		'name' => $this->name
		, 'title' => $this->title
		, 'content' => $this->content
		, 'order' => $this->order
	    ))->return_id('id')->insert();
	}
    }

    public function is_init() {
	return $this->is_init;
    }

    public function set_id($id) {
	$this->id = $id;
    }

    public function set_name($name) {
	$this->name = $name;
    }

    public function set_title($title) {
	$this->title = $title;
    }

    public function set_content($content) {
	$this->content = str_replace('`', "'", str_replace('``', '"', $content));
    }

    public function set_is_default($is_default) {
	$this->is_default = $is_default ? true : false;
    }

    public function set_order($order) {
	$this->order = $order;
    }

    public function set_deleted($deleted) {
	$this->deleted = $deleted ? true : false;
    }

    public function set_active($active) {
	$this->active = $active ? true : false;
    }

    public function get_id() {
	return $this->id;
    }

    public function get_name() {
	return $this->name;
    }

    public function get_title() {
	return $this->title;
    }

    public function get_content() {
	$content = str_replace('SITE_HOST', SITE_HOST, $this->content);
	$content = str_replace('EMAIL', settings::init()->get('email'), $content);
	$content = str_replace('PHONE', settings::init()->get('phone'), $content);
	return $content;
    }

    public function is_default() {
	return $this->is_default;
    }

    public function get_order() {
	return $this->order;
    }

    public function is_deleted() {
	return $this->deleted;
    }

    public function is_active() {
	return $this->active;
    }

    private function init_submenu() {
	if (is_null($this->submenu)) {
	    $this->init_menu_parent();
	    if ($this->id_menu_parent) {
		$this->submenu = $this->menu_parent->get_submenu();
	    } else {
		$this->submenu = array();
		$rows = db::init()->query(array('m.id', 'm.name', 'm.title', 'm.content', 'm.is_default', 'm.deleted', 'm.active', 'm.order'))
			->from(array('m' => 'menu'))
			->left_join(array('ms' => 'menu_submenu'), array('m.id', 'ms.id_menu_child'))
			->where(array('m.deleted', '=', '0'))
			->where(array('m.active', '=', '1'))
			->where(array('ms.id', '!isnull'))
			->where(array('ms.id_menu_parent', '=', $this->id))
			->distinct()
			->order('m.order', 'desc');
		if (!user::init()->is_authorized()) {
		    $rows->where(array('is_private', '=', '0'));
		}
		$rows = $rows->get_all();
		if ($rows)
		    foreach ($rows as $row) {
			$item = new menu_item($row);
			$this->submenu[] = $item;
		    }
	    }
	}
    }

    public function get_submenu() {
	$this->init_submenu();
	return $this->submenu;
    }

    private function init_menu_parent() {
	if (is_null($this->id_menu_parent)) {
	    $this->id_menu_parent = 0;
	    $row = db::init()->query('id_menu_parent')->from('menu_submenu')->where(array('id_menu_child', '=', $this->id))->get_row();
	    if ($row) {
		$this->id_menu_parent = $row['id_menu_parent'];
		$this->menu_parent = new menu_item($this->id_menu_parent);
	    }
	}
    }

    public function get_menu_parent() {
	$this->init_menu_parent();
	return $this->menu_parent;
    }

    public function get_id_menu_parent() {
	$this->init_menu_parent();
	return $this->id_menu_parent;
    }

}

?>