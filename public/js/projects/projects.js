$(function() {
    $('#list').html('');
	window.projects
		.map(project => new ProjectCell(project).generateCell())
		.forEach(cell => { $('#list').append(cell); });

	$('.project .project-description, .project input').on('click', function() {
		if ($(this).is('input') && $(this).attr('readonly') != 'readonly') return;
		var id = $(this).closest('.project').attr('project_id');
		window.location.href = '/public/tasks?id=' + id;
	});
});