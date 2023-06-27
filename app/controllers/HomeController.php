<?php

class HomeController extends Controller {

	public function index() {
		try {
			if (isset($_SESSION['user_id'])) {
				$user = User::findOrFail($_SESSION['user_id']);
				header('Location: ' . BASE_URL . 'projects');
			} else {
				$this->sendView();
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$this->sendView();
		}
	}

	public function create() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_POST['username']))
			$errors['username'] = "username is missing";
		if (!isset($_POST['password']))
			$errors['password'] = "password is missing";
		if (!isset($_POST['is_admin']))
			$errors['is_admin'] = "is_admin must be set";
		else if (!is_bool(filter_var($_POST['is_admin'], FILTER_VALIDATE_BOOLEAN)))
			$errors['is_admin'] = "is_admin must be a boolean";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$user = User::create([
				'session_id' => $_POST['username'],
				'username' => $_POST['username'],
				'password' => $_POST['password'],
				'is_admin' => filter_var($_POST['is_admin'], FILTER_VALIDATE_BOOLEAN)
			]);
			echo '{ "user": '; print($user->toJson()); echo ' }';
		} catch (Illuminate\Database\QueryException $e) {
			$errorCode = $e->errorInfo[1];
			if ($errorCode == 1062) {
				$errors['user'] = "user already exist";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
			}
		}
	}

	public function users() {
		header('Content-Type: application/json');
		echo User::all()->toJson();
	}

	public function login() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_POST['username']))
			$errors['username'] = "username is missing";
		if (!isset($_POST['password']))
			$errors['password'] = "password is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$user = User::where([
				'username' => $_POST['username'],
				'password' => $_POST['password']
			])->firstOrFail();
			$user = User::findOrFail($user['user_id']);
			$user->update(['session_id' => session_id()]);
			$_SESSION['user_id'] = $user['user_id'];
			echo '{ "success": '; echo json_encode($user); echo ' }';
			header('Location: ' . BASE_URL . 'projects');
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['user'] = "user not found";
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
		}
	}

	public function logout() {
		header('Content-Type: application/json');
		$sid = session_id();
		try {
			$user = User::where(['session_id' => $sid])->firstOrFail();
			$user->update(['session_id' => null]);
			session_destroy();
			header('Location: ' . BASE_URL);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['user'] = "user with session id " . $sid . " is not logged in";
			$errors['session_id'] = $sid;
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
		}
	}

	private function sendView() {
		$this->view('home/index', [
			'css'		 => CSS_PATH . 'home/home.css',
			'css_header' => CSS_PATH . 'home/header.css',
			'css_main'	 => CSS_PATH . 'home/main.css',
            'css_login'  => CSS_PATH . 'home/login.css',
		]);
	}
}
?>