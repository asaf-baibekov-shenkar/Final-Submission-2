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
				'css'                 => CSS_PATH . 'dashboard.css',
				'css_project_button' => CSS_PATH . 'project_button.css',
				'js'                  => JS_PATH  . 'dashboard.js',
				'js_project_button'  => JS_PATH  . 'project_button.js'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}