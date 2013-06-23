<?php

class controller_category extends public_controller {

	public function index($args) {
	}

	public function all($args){
		$category = new category();
		$category->construct_by_url($args[0]);
		if (!$category->get_id()){
			$this->redirect('error');
		}

		$this->template->set('category', $category);
		$this->template->show('all', 'category', 'right_sidebar_cover');
	}

	public function show($args){
		if (!isset($args[0]) || !in_array('poi', 'route', 'article', 'news', 'advert'))
		$this->template->show('show', 'category', 'right_sidebar_cover');
		die('category controller show');
	}

}

?>