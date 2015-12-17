<?php
	if (isset($_COOKIE['okcookie']))
	{
		exit();
	}

	setcookie('okcookie', '1', pow(2, 31), '/');
?>
