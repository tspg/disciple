<?php
	include dirname(dirname(__FILE__)) . '/config/config.php';
	if (!function_exists('disciple_json'))
	{
		function disciple_json()
		{
			return json_decode(file_get_contents(dirname(dirname(__FILE__)) . '/config/config.json'));
		}
	}
?>
