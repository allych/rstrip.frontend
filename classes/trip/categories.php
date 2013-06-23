<?php

class categories {

	protected $count_all_list;
	protected $all_list;
	protected $list_by_pages;
	private static $init;
	private $id_parent;

	protected function __construct() {
		
	}

	public function init() {
		if (is_null(self::$init)) {
			self::$init = new self;
		}
		return self::$init;
	}

	public function set_id_parent($id_parent) {
		if ($this->id_parent !== $id_parent) {
			$this->all_list = null;
			$this->count_all_list = null;
			$this->list_by_pages = null;
			$this->id_parent = $id_parent;
		}
	}

	public function get_all_list() {
		$this->load_all_list();
		return $this->all_list;
	}

	protected function load_all_list() {
		if (is_null($this->all_list)) {
			$this->all_list = array();
			$rows = category::get_query_to_construct()->where(array('c.deleted','=','0'))->order('name')
					->left_join(array('cc' => 'category_category'), array('c.id', 'cc.id_child'));
			if ($this->id_parent) {
				$rows->where(array('cc.id_parent', '=', $this->id_parent));
			}
			else{
				$rows->where(array('cc.id_parent', 'ISNULL'));
			}
			$rows = $rows->get_all();
			if ($rows)
				foreach ($rows as $row) {
					$category = new category();
					$category->set_id($row['id']);
					$category->set_url($row['url']);
					$category->set_name($row['name']);
					$category->set_deleted($row['deleted']);
					$this->all_list[] = $category;
				}
		}
	}

	public function get_page_of_list($page) {
		$show_count = user::init()->get_show_count();
		$all_count = $this->get_all_count();
		$count_pages = ceil($all_count / $show_count);
		if ($page < 1) {
			$page = 1;
		} elseif ($page > $count_pages) {
			$page = $count_pages;
		}

		if ($page == 0) {
			$page = 1;
		}

		$this->load_page_of_list($page, $show_count);
		return $this->list_by_pages[$page];
	}

	protected function load_page_of_list($page, $show_count) {
		if (is_null($this->list_by_pages[$page])) {
			$this->list_by_pages[$page] = array();
			$rows = category::get_query_to_construct()->where(array('c.deleted','=','0'))->order('name')->limit($show_count, ($page - 1) * $show_count)
					->left_join(array('cc' => 'category_category'), array('c.id', 'cc.id_child'));
			if ($this->id_parent) {
				$rows->where(array('cc.id_parent', '=', $this->id_parent));
			}
			else{
				$rows->where(array('cc.id_parent', 'ISNULL'));
			}
			$rows = $rows->get_all();
			if ($rows)
				foreach ($rows as $row) {
					$category = new category();
					$category->set_id($row['id']);
					$category->set_url($row['url']);
					$category->set_name($row['name']);
					$category->set_deleted($row['deleted']);
					$this->list_by_pages[$page][] = $category;
				}
		}
	}

	public function get_all_count() {
		$this->load_all_count();
		return $this->count_all_list;
	}

	protected function load_all_count() {
		if (is_null($this->count_all_list)) {
			$this->count_all_list = 0;
			$row = db::init()->query(array('cnt' => 'COUNT(*)'))->from('category')->where(array('deleted', '=', '0'))
					->left_join(array('cc' => 'category_category'), array('c.id', 'cc.id_child'));
			if ($this->id_parent) {
				$row->where(array('cc.id_parent', '=', $this->id_parent));
			}
			else{
				$rows->where(array('cc.id_parent', 'ISNULL'));
			}
			$row = $row->get_row();
			if ($row) {
				$this->count_all_list = $row['cnt'];
			}
		}
	}

}

?>
