<?php
	if (file_exists(dirname(dirname(dirname(__FILE__))) . '/config/.gen'))
	{
		Header("Content-Type: text/plain");

		echo 'Can not proceed, you are attempting to access a';
		echo "\n";
		echo 'setup file and Disciple has already been set up.';
		echo "\n";

		exit();
	}
?>
