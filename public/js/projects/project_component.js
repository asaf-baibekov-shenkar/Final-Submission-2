$(function() {
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

		let object = { 
			project: $(this).parent().find("input").val(), 
			id: $(this).parent().attr("project_id") 
		}
		console.log(object);
		// $.post("/tasks", { project: project, id: id });
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
		// let id = $(this).parent().attr("project_id");
		// $.post("/tasks", { id: id });
		$(this).parent().parent().remove();
	});
});