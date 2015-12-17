<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/server.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';
	include 'apishared.php';

	$call = api_checkarg_post('fn');

	$db = getsql();

	if ($call == 'create')
	{
		$binary			= $db->real_escape_string(api_checkarg_post_required('binary', 'Zandronum version'));
		$hostname		= $db->real_escape_string(api_checkarg_post_required('hostname', 'Host name'));
		$iwad			= $db->real_escape_string(api_checkarg_post_required('iwad', 'IWAD'));
		$gamemode		= $db->real_escape_string(api_checkarg_post_required('gamemode', 'Game mode'));
		$instagib		= $db->real_escape_string((api_checkarg_post_required('instagib', 'Instagib') == 'true'));
		$buckshot		= $db->real_escape_string((api_checkarg_post_required('buckshot', 'Buckshot') == 'true'));
		$stdata			= $db->real_escape_string((api_checkarg_post_required('stdata', 'Skulltag data') == 'true'));
		$skill			= intval(api_checkarg_post('skill', 0));
		$dmflags		= intval(api_checkarg_post('dmflags', 0));
		$dmflags2		= intval(api_checkarg_post('dmflags2', 0));
		$zadmflags		= intval(api_checkarg_post('zadmflags', 0));
		$compatflags	= intval(api_checkarg_post('compatflags', 0));
		$zacompatflags	= intval(api_checkarg_post('zacompatflags', 0));
		$wads			= api_checkarg_post('wads', array());
		$optwads		= api_checkarg_post('optwads', array());

		$binary = disciple_json()->main_binary;
		$iwad = data_dir('/iwads/') . $iwad . '.wad';
		echo $iwad;
		$s = new server(
			$binary, $wads, $optwads, $iwad, $hostname, false, $gamemode, '', $skill,
			$stdata, $instagib, $buckshot, $dmflags, $dmflags2, $zadmflags,
			$compatflags, $zacompatflags
		);

		$s->start();

		echo 1;
	}
?>
