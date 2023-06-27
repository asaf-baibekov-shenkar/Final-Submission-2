<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection([
	'driver' => 'mysql',
	'host' => '148.66.138.145',
	'username' => 'dbusrShnkr23',
	'password' => 'studDBpwWeb2!',
	'database' => 'dbShnkr23stud2',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => 'tbl_233_'
]);
$capsule->bootEloquent();