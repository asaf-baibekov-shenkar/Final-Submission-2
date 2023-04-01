<?php

class TasksController extends Controller {

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			session_destroy();
			header('Location: ' . BASE_URL);
			return;
		}
		try {
			$this->view('tasks/index', [
				'css'						=> CSS_PATH . 'tasks/tasks.css',
				'css_header'				=> CSS_PATH . 'tasks/header.css',
				'css_sidebar'				=> CSS_PATH . 'tasks/sidebar.css',
				'css_main'  				=> CSS_PATH . 'tasks/main.css',
				'css_project_button'		=> CSS_PATH . 'tasks/project_button.css',
				'css_new_project_button' 	=> CSS_PATH . 'tasks/new_project_button.css',
				'js'						=> JS_PATH  . 'tasks/tasks.js',
				'js_header'					=> JS_PATH  . 'tasks/header.js',
				'js_project_button'			=> JS_PATH  . 'tasks/project_button.js',
				'js_new_project_button'		=> JS_PATH  . 'tasks/new_project_button.js'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}