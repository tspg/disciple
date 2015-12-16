<?php
	include dirname(dirname(dirname(__FILE__))) . '/common/config.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/server.php';
	include dirname(dirname(dirname(__FILE__))) . '/common/session.php';
	include 'apishared.php';

	$call = api_checkarg_post('fn');

	if ($call == 'create')
	{
		$binary			= api_checkarg_post_required('binary', 'Zandronum version');
		$hostname		= api_checkarg_post_required('hostname', 'Host name');
		$iwad			= api_checkarg_post_required('iwad', 'IWAD');
		$gamemode		= api_checkarg_post_required('gamemode', 'Game mode');
		$instagib		= (api_checkarg_post_required('instagib', 'Instagib') == 'true');
		$buckshot		= (api_checkarg_post_required('buckshot', 'Buckshot') == 'true');
		$stdata		= (api_checkarg_post_required('stdata', 'Skulltag data') == 'true');
		$skill			= intval(api_checkarg_post_required('skill', 'Skill'));
		$dmflags		= intval(api_checkarg_post_required('dmflags', 'DMFlags'));
		$dmflags2		= intval(api_checkarg_post_required('dmflags2', 'DMFlags 2'));
		$zadmflags		= intval(api_checkarg_post_required('zadmflags', 'Zandronum DMFlags'));
		$compatflags	= intval(api_checkarg_post_required('compatflags', 'Compatibility flags'));
		$zacompatflags	= intval(api_checkarg_post_required('zacompatflags', 'Zandronum compatibility flags'));
		$wads			= explode(' ', api_checkarg_post('wads'));
		$optwads		= explode(' ', api_checkarg_post('optwads'));

		$s = new server(
			$binary, $wads, $optwads, $hostname, false, $gamemode, '', $skill,
			$stdata, $instagib, $buckshot, $dmflags, $dmflags2, $zadmflags,
			$compatflags, $zacompatflags
		);
	}
?>
