$(function() {
	$(".project > .edit").click(function() {
		$(this).parent()
			.find("input")
			.attr("readonly", false)
			.css("text-decoration", "underline");
		$(this).addClass("d-none");
		$(this).parent()
			.find(".done")
			.removeClass("d-none");
	});
	$(".project > .done").click(function() {
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
		// $.post("/dashboard", { project: project, id: id });
	});

	// when clicking the input tag, if it's disabled, then it will trigger an event
	$(".project > input").click(function() {
		if (!$(this).attr("readonly")) return;
	});

	const maxLength = $(".project > input").attr('maxlength');
	$(".project > input").on('input', function() {
		const minFontSize = 14;
		const maxFontSize = 22;
		const charRange = maxLength - $(this).val().length;
		let fontSize = minFontSize + ((charRange / maxLength) * (maxFontSize - minFontSize));
		fontSize = Math.max(minFontSize, fontSize);
		fontSize = Math.min(maxFontSize, fontSize);
		console.log(fontSize);
		$(this).css('font-size', fontSize + 'px');
	});
	$(".project > input").attr('maxlength', maxLength).trigger('input');
	
	$(".project > .delete").click(function() {
		// let id = $(this).parent().attr("project_id");
		// $.post("/dashboard", { id: id });
		$(this).parent().remove();
	});
});