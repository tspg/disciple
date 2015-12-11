<?php
	include 'postcfglock.php';
	include dirname(dirname(__FILE__)) . '/api/apishared.php';

	$site_name = api_checkarg_post_required('site_name', 'Site name');
	$site_shortname = api_checkarg_post_required('site_shortname', 'Site short name');
	$main_version_binary = api_checkarg_post_required('binary', 'Zandronum server binary location');
	$serverlimit = api_checkarg_post_required('serverlimit', 'Server limit');

	$out = array(
		'site_name'			=>	$site_name,
		'site_shortname' 	=>  $site_shortname,
		'main_binary'		=>	$main_version_binary,
		'serverlimit'		=> 	$serverlimit
	);

	$file = dirname(dirname(dirname(__FILE__))) . '/config/config.json';
	$r = file_put_contents($file, json_encode($out));

	if ($r === FALSE)
	{
		api_error(SN_FAILED_FILE_WRITE, sprintf("Failed to write to file %s.", $file));
		exit();
	}

	Header("Content-Type: text/plain");
	echo 1;
?>
