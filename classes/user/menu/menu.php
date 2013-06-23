<?php
class menu
{
  protected static $init;

  protected function __construct(){
  }

  public static function init(){
    if (self::$init === null) {
      switch(registry::get('subdomain')){
        case 'admin': self::$init = admin_menu::init(); break;
        default: self::$init = client_menu::init(); break;
      }
    }
    return self::$init;
  }
}

?>