<?php
	include 'setup_common.php';

/*
$desc = array(
	0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
	1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
	2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
);

$r = proc_open('/usr/bin/zandronum-server -iwad "/run/media/sean/Games & Stuff/Doom/IWADs/doom2.wad"', $desc, $pipes);
$pid = proc_get_status($r)['pid'];
printf("STarted server with pid %d", $pid);
echo 'after';
//proc_close($r);
*/
?>

<?php setup_header('Configuration'); ?>
	<div class='centre'>
		<img src='../images/d_log1.png' id='wiz' />
		<h3 style='margin:0'>I need some info</h3>
		<br />

		<div class='card'>
			First of all, what's the name of this site?
			<br />
			<input type='text' id='site_name' required />

			What's a short name for this site? Maximum 5 characters.
			<br />
			<input type='text' id='site_shortname' required maxlength='5' />

			<br />
			Where is Zandronum located on this server?
			<br />
			<input type='text' id='binary' placeholder='/usr/bin/zandronum-server' required />

			<br />
			What's the default server limit for users?
			<br />
			<input type='number' id='serverlimit' value='4' required />

			<br />
			What should the username and password for the "root" user (the user that can do basically anything) be?
			<br />
			<input type='text' id='rootuser' placeholder='Username' required />
			<input type='password' id='rootpass' placeholder='Password' required />

			<br /> <br />
			<input type='button' value='Submit' id='sendbutton' onclick='post_config();'/>
			<div id='submit-err'></div>
		</div>
	</div>
<?php setup_footer(); ?>
