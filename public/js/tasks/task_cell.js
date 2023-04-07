class TaskCell {
	constructor(task) {
		this.task = task;
	}

	generateCell() {
		return `
		<div class="task rounded">
			<div class="task-title rounded-top d-flex align-items-center justify-content-between">
				<div class="ms-2 me-1 flex-grow-1">${this.task.title}</div>
				<img class="me-2 ms-1" src="${IMAGES_PATH + 'task/task_completed_icon.png'}" alt="task completed">
			</div>
			<div class="task-description rounded-bottom h-100 p-2 overflow-hidden">
				${this.task.description}
			</div>
		</div>
		`
	}
}