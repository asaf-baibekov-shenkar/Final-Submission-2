<?php

class ProjectsController extends Controller {

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			session_destroy();
			header('Location: ' . BASE_URL);
			return;
		}
		try {
			$this->view('projects/index', [
				'css'						=> CSS_PATH . 'projects/projects.css',
				'css_main'  				=> CSS_PATH . 'projects/main.css',
				'css_project_component'		=> CSS_PATH . 'projects/project_component.css',
				'js'						=> JS_PATH  . 'projects/projects.js',
				'js_project_component'		=> JS_PATH  . 'projects/project_component.js',
				'js_new_project_button'		=> JS_PATH  . 'projects/new_project_button.js'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}