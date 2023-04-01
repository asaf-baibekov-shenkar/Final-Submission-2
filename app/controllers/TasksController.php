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
				'css_main'  				=> CSS_PATH . 'tasks/main.css',
				'js'						=> JS_PATH  . 'tasks/tasks.js'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}