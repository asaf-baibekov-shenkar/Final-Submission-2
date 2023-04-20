<?php

class ProjectsController extends Controller {

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			session_destroy();
			header('Location: ' . BASE_URL);
			return;
		}
		try {
			$user = User::findOrFail($_SESSION['user_id']);
			$projects = Project::where('user_id', $user['user_id'])->get();
			foreach ($projects as $project) {
				$project['high_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '0')->count();
				$project['medium_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '1')->count();
				$project['low_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '2')->count();
				$project['remaining_tasks'] = Task::where('project_id', $project['project_id'])->where('is_done', '0')->count();
				$project['total_tasks'] = Task::where('project_id', $project['project_id'])->count();
			}
			$this->view('projects/index', [
				'css'						=> CSS_PATH . 'projects/projects.css',
				'css_main'  				=> CSS_PATH . 'projects/main.css',
				'css_project_component'		=> CSS_PATH . 'projects/project_component.css',
				'js'						=> JS_PATH  . 'projects/projects.js',
				'js_project_cell'			=> JS_PATH  . 'projects/project_cell.js',
				'user'						=> '{ "user": ' . $user->toJson() . ' }',
				'projects'					=> '{ "projects": ' . $projects->toJson() . ' }'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}

	public function create() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_POST['title']))
			$errors['title'] = "title is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}

		try {
			$user = User::findOrFail($_SESSION['user_id']);
			echo '{ "project": ';
			echo Project::create([
				'user_id' => $user['user_id'],
				'title' => $_POST['title']
			]);
			echo '}';
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}

	public function projectById() {
		header('Content-Type: application/json');
		try {
			$user = User::findOrFail($_SESSION['user_id']);
			try {
				$project = Project::where('user_id', $user['user_id'])->findOrFail($_GET['id']);
				echo '{ "project": ' . $project->toJson() . ' }';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['id'] = "project id not exist";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}

	public function projectsList() {
		header('Content-Type: application/json');
		$errors = [];
		try {
			$user = User::findOrFail($_SESSION['user_id']);
			$projects = Project::where('user_id', $user['user_id'])->get();
			foreach ($projects as $project) {
				$project['high_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '0')->count();
				$project['medium_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '1')->count();
				$project['low_priority_tasks'] = Task::where('project_id', $project['project_id'])->where('priority', '2')->count();
				$project['remaining_tasks'] = Task::where('project_id', $project['project_id'])->where('is_done', '0')->count();
				$project['total_tasks'] = Task::where('project_id', $project['project_id'])->count();
			}
			echo '{ "projects": ' . $projects->toJson() . ' }';
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}

	public function update() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_POST['id']))
			$errors['id'] = "id is missing";
		if (!isset($_POST['title']))
			$errors['title'] = "title is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$user = User::findOrFail($_SESSION['user_id']);
			try {
				$project = Project::where('user_id', $user['user_id'])->findOrFail($_POST['id']);
				$project->update(['title' => $_POST['title']]);
				echo '{ "project": '; print_r($project->toJson()); echo ' }';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['id'] = "id not exist";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}

	public function remove() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_POST['id']))
			$errors['id'] = "id is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}

		try {
			$user = User::findOrFail($_SESSION['user_id']);
			try {
				$project = Project::where('user_id', $user['user_id'])->findOrFail($_POST['id']);
				$tasks = Task::where('project_id', $_POST['id'])->get();
				foreach ($tasks as $task) {
					$task->delete();
				}
				$project->delete();
				echo '{ "project": '; print_r($project->toJson()); echo ' }';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['id'] = "project id not exist";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			session_destroy();
			header('Location: ' . BASE_URL);
		}
	}
}