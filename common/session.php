<?php
	include 'config.php';

	$uinf = null;

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

	if(!function_exists("is_authed"))
	{
		function is_authed()
		{
			return isset($_SESSION['user']);
		}
	}

	if (!function_exists('user_info'))
	{
		function user_info($_id = 0)
		{
			$id = $_id;

			if ($_id == 0 && is_authed())
			{
				$id = $_SESSION['id'];
			}

			if (!is_authed() && $id == 0)
			{
				return null;
			}

			$uinfq = getsql()->query("SELECT * FROM `users` WHERE `id`=" . $_SESSION['id']);

			// Make sure to destroy our session if this user doesn't exist anymore.
			if ($uinfq->num_rows == 0 && $id == $_SESSION['id'])
			{
				Header("Location: /logout?accdel");
			}

			return $uinfq->fetch_object();
		}
	}

	if (is_authed())
	{
		$uinf = user_info();
	}
?>
