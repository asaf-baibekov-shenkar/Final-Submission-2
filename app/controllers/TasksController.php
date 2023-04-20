<?php

class TasksController extends Controller {

	public function index() {
		if (!isset($_SESSION['user_id'])) {
			session_destroy();
			header('Location: ' . BASE_URL);
			return;
		}
		$project_id = $_GET['project_id'];
		if (!isset($project_id)) {
			header('Location: ' . BASE_URL . 'projects');
			return;
		}
		try {
			$project = Project::findOrFail($project_id);
			if ($project['user_id'] != $_SESSION['user_id']) {
				header('Location: ' . BASE_URL . 'projects');
				return;
			}
			$tasks = Task::where('project_id', $project_id)->get();
			$this->view('tasks/index', [
				'css'						=> CSS_PATH . 'tasks/tasks.css',
				'css_main'  				=> CSS_PATH . 'tasks/main.css',
				'css_modal'  				=> CSS_PATH . 'tasks/modal.css',
				'js'						=> JS_PATH  . 'tasks/tasks.js',
				'js_task_cell'				=> JS_PATH  . 'tasks/task_cell.js',
				'consts'					=> JS_PATH  . 'consts.js',
				'project_name'				=> $project['title'],
				'tasks'						=> '{ "tasks": ' . $tasks->toJson() . ' }'
			]);
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			header('Location: ' . BASE_URL . 'projects');
			return;
		}
	}

	public function create() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_SESSION['user_id']))
			$errors['user'] = "user not logged in";
		if (!isset($_POST['title']))
			$errors['title'] = "title is missing";
		if (!isset($_POST['description']))
			$errors['description'] = "description is missing";
		if (!isset($_POST['priority']))
			$errors['priority'] = "priority is missing";
		else if ($_POST['priority'] < 0 || $_POST['priority'] > 2)
			$errors['priority'] = "priority must be between 0 and 2";
		if (!isset($_POST['project_id']))
			$errors['project_id'] = "project_id is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$project = Project::findOrFail($_POST['project_id']);
			if ($project['user_id'] != $_SESSION['user_id']) {
				$errors['user'] = "user not permitted to view tasks for this project";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
				return;
			}
			try {
				$project = Project::where('user_id', $_SESSION['user_id'])->findOrFail($_POST['project_id']);
				echo '{ "task": ';
				echo Task::create([
					'project_id' => $project['project_id'],
					'title' => $_POST['title'],
					'description' => $_POST['description']
				]);
				echo '}';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['user'] = "user not permitted to create task for this project";
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['user'] = "user not found";
		}
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
	}

	public function taskById() {
		header('Content-Type: application/json');
		$error = [];
		if (!isset($_SESSION['user_id']))
			$errors['user'] = "user not logged in";
		if (!isset($_GET['task_id']))
			$errors['task_id'] = "task_id is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$task = Task::findOrFail($_GET['task_id']);
			$project = Project::findOrFail($task['project_id']);
			if ($project['user_id'] != $_SESSION['user_id']) {
				$errors['user'] = "user not permitted to view this task";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
				return;
			}
			echo '{ "task": '; echo $task; echo ' }';
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['task'] = "task not found";
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
	}

	public function tasksList() {
		header('Content-Type: application/json');
		$error = [];
		if (!isset($_SESSION['user_id']))
			$errors['user'] = "user not logged in";
		if (!isset($_GET['project_id']))
			$errors['project_id'] = "project_id is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$project = Project::findOrFail($_GET['project_id']);
			if ($project['user_id'] != $_SESSION['user_id']) {
				$errors['user'] = "user not permitted to view tasks for this project";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
				return;
			}
			$tasks = Task::where('project_id', $project['project_id'])->get();
			echo '{ "tasks": '; echo $tasks; echo ' }';
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['project'] = "project not found";
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
	}

	public function update() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_SESSION['user_id']))
			$errors['user'] = "user not logged in";
		if (!isset($_POST['task_id']))
			$errors['task_id'] = "task_id is missing";
		if (!isset($_POST['title']))
			$errors['title'] = "title is missing";
		if (!isset($_POST['description']))
			$errors['description'] = "description is missing";
		if (!isset($_POST['priority']))
			$errors['priority'] = "priority is missing";
		else if ($_POST['priority'] < 0 || $_POST['priority'] > 2)
			$errors['priority'] = "priority must be between 0 and 2";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$task = Task::findOrFail($_POST['task_id']);
			try {
				$project = Project::findOrFail($task['project_id']);
				if ($project['user_id'] != $_SESSION['user_id']) {
					$errors['user'] = "user not permitted to update this task";
					echo '{ "errors": '; echo json_encode($errors); echo ' }';
					return;
				}
				$task->update([
					'title' => $_POST['title'],
					'description' => $_POST['description']
				]);
				echo '{ "task": '; echo $task; echo ' }';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['project'] = "project not found";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
				return;
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['task'] = "task not found";
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}	
	}

	public function remove() {
		header('Content-Type: application/json');
		$errors = [];
		if (!isset($_SESSION['user_id']))
			$errors['user'] = "user not logged in";
		if (!isset($_POST['task_id']))
			$errors['task_id'] = "task_id is missing";
		if (!empty($errors)) {
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
			return;
		}
		try {
			$task = Task::findOrFail($_POST['task_id']);
			try {
				$project = Project::findOrFail($task['project_id']);
				if ($project['user_id'] != $_SESSION['user_id']) {
					$errors['user'] = "user not permitted to update this task";
					echo '{ "errors": '; echo json_encode($errors); echo ' }';
					return;
				}
				$task->delete();
				echo '{ "task": '; echo $task; echo ' }';
			} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
				$errors['project'] = "project not found";
				echo '{ "errors": '; echo json_encode($errors); echo ' }';
				return;
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
			$errors['task'] = "task not found";
			echo '{ "errors": '; echo json_encode($errors); echo ' }';
		}
	}
}