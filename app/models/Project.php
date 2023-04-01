<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Project extends Eloquent {
    protected $primaryKey = 'project_id';
    public $incrementing = true;
    public $project_id;
    public $user_id;
    public $title;
    public $created_at;
    public $updated_at;
    protected $fillable = ['user_id', 'title', 'description'];
    protected $hidden = ['user_id'];
}

?>