<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Task extends Eloquent {
    protected $primaryKey = 'task_id';
    public $incrementing = true;
    public $task_id;
    public $project_id;
    public $title;
    public $description;
	public $priority;
    public $created_at;
    public $updated_at;
    protected $fillable = ['project_id', 'title', 'description', 'priority'];
}

?>