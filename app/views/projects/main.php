<main class="d-flex flex-column gap-3 pt-3">
	<div class="main-title text-center">Projects</div>
	<button id="new_project_button" class="rounded mx-5 d-flex align-items-center justify-content-center">
		<span>New Project</span>
	</button>
	<div class="projects d-flex align-content-start flex-wrap gap-2 h-100 mx-5 pt-2 pb-5 overflow-auto">
		<?php for ($i = 1; $i <= 10; $i++): ?>
		<div class="project rounded">
			<?php include "project_component.php" ?>
			<div class="project-description rounded-bottom h-100 p-3 d-flex flex-column align-items-center justify-content-between">
				<div class="d-flex flex-column align-items-center">
					<span>High Priority</span>
					<span>3</span>
				</div>
				<div class="d-flex flex-column align-items-center">
					<span>Medium Priority</span>
					<span>4</span>
				</div>
				<div class="d-flex flex-column align-items-center">
					<span>Low Priority</span>
					<span>3</span>
				</div>
				<div class="d-flex flex-column align-items-center">
					<span>Remaining</span>
					<span>7</span>
				</div>
				<div class="d-flex flex-column align-items-center">
					<span>Total</span>
					<span>10</span>
				</div>
			</div>
		</div>
		<?php endfor; ?>
	</div>
</main>