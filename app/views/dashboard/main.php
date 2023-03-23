<main class="d-flex flex-column">
	<div class="main-title my-3 text-center">Work</div>
	<button id="new_task_button" class="rounded mx-5 mb-3 d-flex align-items-center justify-content-center">
		<span>New Task</span>
	</button>
	<div class="tasks d-flex align-content-start flex-wrap gap-3 h-100 mx-5 pt-3 pb-5 overflow-auto">
		<?php for ($i = 1; $i <= 10; $i++): ?>
		<div class="task rounded">
			<div class="task-title rounded-top d-flex align-items-center justify-content-between">
				<span class="ms-3">Task <?php echo $i ?></span>
				<img class="me-2" src="<?php echo IMAGES_PATH . "task/task_completed_icon.png" ?>" alt="">
			</div>
			<div class="task-description rounded-bottom h-100 p-2 overflow-auto">
				Lorem, ipsum dolor sit osdhvaoisdfjg pijsdoivajdsiopjv lksajndfoviajdiov lskdjhvoidjvn sldivji amet consectetur adipisicing elit. Dicta dolorum consectetur odio? Repellat corporis, minus nostrum impedit nam incidunt, architecto iste hic rem porro quibusdam aspernatur nulla. Ex, eaque minima!
			</div>
		</div>
		<?php endfor; ?>
	</div>
</main>