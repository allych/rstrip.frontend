<?php

class user {

	private static $init;
	private $session;
	private $error;
	private $id, $login, $show_count, $forename, $middlename, $lastname, $email, $phone;

	private function __clone() {
	}

	private function __construct() {
		$this->session = new session();
		$this->session->start();
		$this->show_count = settings::init()->get('show_count');

		$this->init_default_user();
		$this->set_map_settings();
	}

	private function init_default_user() {
		$this->id = 1;
		$this->login = 'alla';
		$this->show_count = 15;
		$this->forename = 'Alla';
		$this->middlename = '';
		$this->lastname = 'Mamontova';
		$this->email = 'allasergeevna@list.ru';
		$this->phone = '+79643438478';
	}

	private function set_map_settings(){
		if ($this->session->get('map_latitude') === false)
			$this->session->set('map_latitude', '59.896');
		if ($this->session->get('map_longitude') === false)
			$this->session->set('map_longitude', '30.318');
		if ($this->session->get('map_zoom') === false)
			$this->session->set('map_zoom', '12');
	}

	public static function init() {
		if (self::$init === null) {
			self::$init = new self();
		}
		return self::$init;
	}

	public final function check_captcha($captcha) {
		$user_captcha = $this->get_session_param('captcha');
		return strnatcmp($user_captcha, $captcha) == 0 ? true : false;
	}

	public function set_error($error) {
		$this->error = $error;
	}

	public function has_error() {
		if (is_null($this->error)) {
			return false;
		}
		return true;
	}

	public function get_error_message() {
		return $this->error;
	}

	private function encrypt($password, $salt) {
		return md5(md5($password . md5($salt)));
	}

	public function check_password($password) {
		/* TODO: */
		return false;
	}

	public function authorize($login, $password) {
		/* TODO: */
	}

	public function is_authorized() {
		/* TODO: */
		return true;
	}

	public function logout() {
		/* TODO: */
	}

	public function set_session_param($name, $value) {
		$this->session->set($name, $value);
	}

	public function get_session_param($name) {
		return $this->session->get($name);
	}

	public function get_session_id() {
		return $this->session->get_id();
	}

	public function get_id() {
		return $this->id;
	}

	public function get_login() {
		return $this->login;
	}

	public function get_forename() {
		return $this->forename;
	}

	public function get_middlename() {
		return $this->middlename;
	}

	public function get_lastname() {
		return $this->lastname;
	}

	public function get_email() {
		return $this->email;
	}

	public function get_phone() {
		return $this->phone;
	}

	public function get_show_count() {
		return $this->show_count;
	}

}

?>