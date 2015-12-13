<?php
	include 'config.php';

	ini_set('session.name', 'DiscipleSession');
	ini_set('session.hash_function', 'sha512');

	if (session_status() == PHP_SESSION_NONE)
	{
    	session_start();
	}

	if(!function_exists("isAuthed"))
	{
		function isAuthed()
		{
			return isset($_SESSION['user']);
		}
	}
?>
