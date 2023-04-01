$(function() {
    $('#list').html('');
	window.projects
		.map(project => new ProjectCell(project).generateCell())
		.forEach(cell => { $('#list').append(cell); });
});