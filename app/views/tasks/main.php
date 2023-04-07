<main class="d-flex flex-column gap-3 mx-auto pt-3">
	<div class="main-title text-center">
		<?php echo $data['project_name']; ?>
	</div>
	<button id="new_task_button" class="rounded d-flex align-items-center justify-content-center">
		<span>New Task</span>
	</button>
	<div class="tasks d-flex align-content-start flex-wrap gap-3 h-100 pt-2 pb-5 overflow-auto">
		<div id="list" class="tasks d-flex align-content-start flex-wrap gap-2 h-100 pt-2 pb-5 overflow-auto">
		
		</div>
	</div>
</main>