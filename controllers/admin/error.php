<?php
class controller_error extends public_controller
{
  public function index($args = array()){
  }

  public function show_error($code, $error){
    $this->set('code',$code);
    $this->set('error',$error);
    $this->show_template();
  }
}

?>