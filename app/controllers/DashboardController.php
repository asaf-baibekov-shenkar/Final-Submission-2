<?php

class DashboardController extends Controller {

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			session_destroy();
			header('Location: ' . BASE_URL);
			return;
		}
		try {
			$this->view('dashboard/index', [
				'css'						=> CSS_PATH . 'dashboard/dashboard.css',
				'css_header'				=> CSS_PATH . 'dashboard/header.css',
				'css_sidebar'				=> CSS_PATH . 'dashboard/sidebar.css',
				'css_main'  				=> CSS_PATH . 'dashboard/main.css',
				'css_project_button'		=> CSS_PATH . 'dashboard/project_button.css',
				'css_new_project_button' 	=> CSS_PATH . 'dashboard/new_project_button.css',
				'js'						=> JS_PATH  . 'dashboard/dashboard.js',
				'js_header'					=> JS_PATH  . 'dashboard/header.js',
				'js_project_button'			=> JS_PATH  . 'dashboard/project_button.js',
				'js_new_project_button'		=> JS_PATH  . 'dashboard/new_project_button.js'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}