<?php

class App {

	protected $controller = 'HomeController';

	protected $method = 'index';

	protected $params = [];

	public function __construct() {
		$url = $this->parseUrl();
		if (isset($url[0]) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller' . '.php')) {
			$this->controller = ucfirst($url[0]) . 'Controller';
			unset($url[0]);
		}
		require_once '../app/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;
		if (isset($url[1]) && method_exists($this->controller, $url[1])) {
			$this->method = $url[1];
			unset($url[1]);
		}
		$this->param = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->method], $this->param);
	}

	public function parseUrl() {
		if (!isset($_GET['url'])) return [];
		return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
	}

}