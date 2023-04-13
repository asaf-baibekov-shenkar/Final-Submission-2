<div class="modal fade" id="task-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
	<form id="form-create-task" class="modal-dialog modal-dialog-centered" action="" method="get">
		<div class="modal-content">
			<div class="modal-header position-relative align-items-center justify-content-center">
				<h5 class="modal-title" id="task-modal-title"></h5>
				<button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="input-group">
					<input type="text" class="form-control" id="InputTaskName" placeholder="Task Title" name="title" required>
				</div>
				<div class="input-group my-3">
					<select class="form-control form-select" id="InputPriority">
						<option value="0" selected>High Priority</option>
						<option value="1">Medium Priority</option>
						<option value="2">Low Priority</option>
					</select>
				</div>
				<div class="input-group">
					<textarea class="form-control" id="InputDescription" name="description" placeholder="Description"></textarea>
				</div>
				<div id="map_form" class="w-100"></div>
				<input type="hidden" name="id" value="">
			</div>
			<div class="modal-footer flex-column">
				<button type="submit" class="btn btn-success col-12" id="create_btn">Create</button>
			</div>
		</div>
	</form>
</div>