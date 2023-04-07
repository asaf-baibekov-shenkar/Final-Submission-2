$(function() {
	presentTasks();
	$('#new_task_button').click(function() {
		
	});
});

function presentTasks() {
	$('#list').html('');
	window.tasks
		.map(task => new TaskCell(task).generateCell())
		.forEach(cell => { $('#list').append(cell); });
}
$(document).on('DOMNodeInserted', '.task', function () {
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