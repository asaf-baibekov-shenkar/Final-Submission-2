<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
	protected $primaryKey = 'user_id';
	public $incrementing = true;
	protected $nullable = ['session_id'];
	public $user_id;
	public $session_id;
	public $username;
	public $email;
	public $password;
	public $is_admin;
	public $timestamps = true;
	protected $fillable = ['session_id', 'username', 'email', 'password', 'is_admin'];
	protected $hidden = ['session_id', 'password'];
}

?>