<?php
	session_start();
	require_once 'consts.php';
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	require_once '../vendor/autoload.php';
	require_once 'database.php';
	require_once 'core/App.php';
	require_once 'core/Controller.php';
?>