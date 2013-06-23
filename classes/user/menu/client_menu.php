<?php
class client_menu{
  private static $init;
  private $all_items;

  private function __construct(){
  }

  public static function init(){
    if (self::$init === null) {
      self::$init = new self();
    }
    return self::$init;
  }

  public function get_menu($name){
    $menu_item = new menu_item();
    $menu_item->init_by_name($name);
    if ($menu_item->is_init()){
      return $menu_item;
    }
    return false;
  }

  public function get_default_item(){
    $menu_item = new menu_item();
    $menu_item->init_default_item();
    if ($menu_item->is_init()){
      return $menu_item;
    }
    return false;
  }

  public function get_all_items(){
    if (!isset($this->all_items)){
      $this->all_items = array();
      $rows = db::init()->query(array('m.id','m.name','m.title','m.content','m.is_default','m.deleted','m.active','m.order'))
        ->from(array('m' => 'menu'))
        ->where(array('m.deleted','=','0'))
        ->where(array('m.active','=','1'))
        ->distinct()
        ->order('m.order')->get_all();
      if ($rows) foreach ($rows as $row){
        $item = new menu_item($row);
        $this->all_items[] = $item;
      }
    }
    return $this->all_items;
  }

}

?>