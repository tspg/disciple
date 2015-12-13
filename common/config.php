<?php
	include dirname(dirname(__FILE__)) . '/config/config.php';

	if (!function_exists('disciple_json'))
	{
		function disciple_json()
		{
			return json_decode(file_get_contents(dirname(dirname(__FILE__)) . '/config/config.json'));
		}
	}

	if (!function_exists('getsql'))
	{
		function getsql()
		{
			include dirname(dirname(__FILE__)) . '/config/config.php';
			return new mysqli($disciple_config['mysql_hostname'], $disciple_config['mysql_user'], $disciple_config['mysql_pass'], $disciple_config['mysql_database']);
		}
	}

	if (!function_exists('data_dir'))
	{
		function data_dir($name)
		{
			$d = disciple_json()->serverdata . $name;

			if (!is_dir($d))
			{
				mkdir($d, 0777, true);
			}
			
			return $d;
		}
	}
?>
