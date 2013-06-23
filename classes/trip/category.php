<?php

class category {

	private $id, $url, $name, $deleted;
	
	public function __construct($id = 0){
		if ($id){
			$rows = self::get_query_to_construct()->where(array('c.id','=',$id))->get_row();
			if ($row) {
				$this->set_id($row['id']);
				$this->set_url($row['url']);
				$this->set_name($row['name']);
				$this->set_deleted($row['deleted']);
			}
		}
	}
	
	public function construct_by_url($url){
		$row = self::get_query_to_construct()->where(array('c.url','=',$url))->get_row();
		if ($row) {
			$this->set_id($row['id']);
			$this->set_url($row['url']);
			$this->set_name($row['name']);
			$this->set_deleted($row['deleted']);
		}
	}
	
	public static function get_query_to_construct(){
		return db::init()->query(array('c.id', 'c.url', 'c.deleted', 'name' => 'lt.text'))
				->from(array('c' => 'category'))
				->inner_join(array('lt' => 'language_text'), array('c.id_ll_name', 'lt.id_label'));
	}
	
	public function set_id($value) {
		$this->id = $value;
	}
	
	public function set_url($value) {
		$this->url = $value;
	}
	
	public function set_name($value) {
		$this->name = $value;
	}
	
	public function set_deleted($value) {
		$this->deleted = ($value);
	}
	
	public function get_id(){
		return $this->id;
	}
	
	public function get_name(){
		return $this->name;
	}
	
	public function get_url(){
		return $this->url;
	}
	
	public function get_deleted(){
		return $this->deleted;
	}
	
}

?>