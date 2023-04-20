$(function() {
	presentTasks();
	$('#new_task_button').click(function() {
		showModal(-1);
	});
	setupModal();
});

function presentTasks() {
	$('#list').html('');
	window.tasks
		.map(task => new TaskCell(task).generateCell())
		.forEach(cell => { $('#list').append(cell); });
}
$(document).on('DOMNodeInserted', '.task', function () {
	let priority = $(this).attr('priority');
	$(this).find('.task-title').css('background-color', function () {
		switch (priority) {
			case '0': return 'var(--task-title-high-priority-background-color)';
			case '1': return 'var(--task-title-medium-priority-background-color)';
			case '2': return 'var(--task-title-low-priority-background-color)';
		}
	});
	
	$(".task .task-title div").on('input', function () {
		const containerWidth = $(this).width();
		const text = $(this).text();
		const minFontSize = 14;
		const maxFontSize = 20;
		const fontSize = calculateFontSize(text, containerWidth, minFontSize, maxFontSize);
		$(this).css('font-size', `${fontSize}px`);
	});

	$(".task .task-title > img").one("load", function () {
		$(".task .task-title div").trigger('input');
	});

	$(".task .task-title div").trigger('input');

	$(this).click(function () {
		let index = $(this).attr('task_id');
		let task = tasks.filter(task => task.task_id == index)[0]
		let taskTitle = task.title;
		let taskDescription = task.description;
		let taskPriority = task.priority;
		let taskIsDone = task.is_done;
		showModal(index, taskTitle, taskDescription, taskPriority, taskIsDone);
	});
});

function calculateFontSize(text, containerWidth, minFontSize, maxFontSize) {
	const testElement = $('<span/>').css({
		'font-size': `${maxFontSize}px`,
		'position': 'absolute',
		'visibility': 'hidden',
		'white-space': 'nowrap'
	}).text(text);
	$('body').append(testElement);

	let fontSize = maxFontSize;
	while (testElement.outerWidth() > containerWidth - 7 && fontSize > minFontSize) {
		fontSize -= 0.5;
		testElement.css('font-size', `${fontSize}px`);
	}

	testElement.remove();
	return fontSize;
}

function fetchTasks() { 
	return fetch(window.location.href + '/tasksList?project_id=' + window.project_id)
		.then(response => response.text())
		.then(data => {
			window.projects = JSON.parse(data).projects;
			presentProjects($('#list'));
		});
}

function showModal(task_id, taskName, taskDescription, taskPriority, taskIsDone) {
	$('#task-modal').attr('index', task_id);
	$('#task-modal').on('show.bs.modal', () => {
		$('#task-modal-title').html(task_id > 0 ? "Edit Task" : "New Task");
		$(`input[name="id"]`).val(task_id);
		$('#InputTaskTitle').val(task_id > 0 ? taskName : "");
		$('#InputDescription').val(task_id > 0 ? taskDescription : "");
		$('#InputPriority').val(task_id > 0 ? taskPriority : "0");
		$('#create_save_btn').html(task_id > 0 ? "Save" : "Create");
		$('#mark_btn').toggleClass('d-none', task_id < 0);
		$('#mark_btn').html(!taskIsDone ? "Mark Done" : "Mark Not Done");
		$('#delete_btn').toggleClass('d-none', task_id < 0);
		setupModal();
	});
	$('#task-modal').modal('show');
} 

function setupModal() {
	$('#InputPriority').change(function() {
		switch ($(this).val()) {
			case '0': $('#InputPriority').css('background-color', 'var(--task-title-high-priority-background-color)');	 break;
			case '1': $('#InputPriority').css('background-color', 'var(--task-title-medium-priority-background-color)'); break;
			case '2': $('#InputPriority').css('background-color', 'var(--task-title-low-priority-background-color)'); 	 break;
		}
	});
	$('#InputPriority').trigger('change');
}
