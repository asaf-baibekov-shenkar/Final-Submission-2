$(function() {
	presentProjects();
    $('#new_project_button').click(function() {
        if ($('#list').find('.project[project_id=""]').length > 0) return;
        $('#list').append(ProjectCell.generateEmptyCell());
	});
});

function presentProjects() {
	$('#list').html('');
	window.projects
		.map(project => new ProjectCell(project).generateCell())
		.forEach(cell => { $('#list').append(cell); });
}

$(document).on('DOMNodeInserted', '.project', function () {
	$(".project_component > .edit").click(function() {
		$(this).parent()
			.find("input")
			.attr("readonly", false)
			.css("text-decoration", "underline");
		$(this).addClass("d-none");
		$(this).parent()
			.find(".done")
			.removeClass("d-none");
	});
    
	$(".project_component > .done").click(function() {
		$(this).parent()
			.find("input")
			.attr("readonly", true)
			.css("text-decoration", "none");
		$(this).addClass("d-none");
		$(this).parent()
			.find(".edit")
			.removeClass("d-none");

        let project_id = $(this).closest('.project').attr("project_id");
        if (project_id == '') {
            let formData = new FormData();
            formData.append('title', $(this).parent().find("input").val());
            fetch(window.location.href + '/create', { method: 'POST', body: formData })
                .then(() => fetchProjects());
        } else {
            let formData = new FormData();
            formData.append('id', project_id);
            formData.append('title', $(this).parent().find("input").val());
            fetch(window.location.href + '/update', { method: 'POST', body: formData })
                .then(() => fetchProjects());
        }
	});

	$(".project_component > input").click(function() {
		if (!$(this).attr("readonly")) return;
	});

	const maxLength = $(".project_component > input").attr('maxlength');
	
    $(".project_component > input").on('input', function() {
		const minFontSize = 14;
		const maxFontSize = 22;
		const charRange = maxLength - $(this).val().length;
		let fontSize = minFontSize + ((charRange / maxLength) * (maxFontSize - minFontSize));
		fontSize = Math.max(minFontSize, fontSize);
		fontSize = Math.min(maxFontSize, fontSize);
		$(this).css('font-size', fontSize + 'px');
	});

	$(".project_component > input").attr('maxlength', maxLength).trigger('input');
	
	$(".project_component > .delete").click(function() {
		let formData = new FormData();
		formData.append('id', $(this).closest('.project').attr("project_id"));
		fetch(window.location.href + '/remove', { method: 'POST', body: formData })
			.then(() => fetchProjects())
	});

	$('.project .project-description, .project input').on('click', function() {
		if ($(this).is('input') && $(this).attr('readonly') != 'readonly') return;
		let project_id = $(this).closest('.project').attr('project_id');
        if (project_id == '') return;
		window.location.href = '/public/tasks?project_id=' + project_id;
	});
})

function fetchProjects() { 
	return fetch(window.location.href + '/projectsList')
		.then(response => response.text())
		.then(data => {
			window.projects = JSON.parse(data).projects;
			presentProjects($('#list'));
		});
}