<?php
	include 'setup_common.php';
		include dirname(dirname(__DIR__)) . '/config/config.php';

	$db_host = $disciple_config['mysql_hostname'];
	$db_port = $disciple_config['mysql_port'];
?>

<?php setup_header('Configuration'); ?>
	<div class='centre'>
		<img src='../images/d_log1.png' id='wiz' onclick='rotateWizard();stopRotate = true'/>
		<h3 style='margin:0'>Don't forget your stuff</h3>
		<br />

		<div class='card'>
			<h3>Import your data from BestBot</h3>
			If you used to use BestBot, you can import your data.
			<br /> <br />

			Database hostname
			<input type='text' id='db_host' value='<?php echo $db_host; ?>' />
			<br />

			Database port
			<input type='number' id='db_port' value='<?php echo $db_port; ?>' min='0' max='65536' />
			<br />

			Database name
			<input type='text' id='db_name' />
			<br />

			Database username
			<input type='text' id='db_user' />
			<br />

			Database password
			<input type='text' id='db_pass' />
			<br />

			<input type='button' value='Import' onclick='import_bestbot();' id='import_button' />
			<input type='button' value='Skip' onclick='document.location="step4.php";' id='skip_button' />
			<div id='submit-err'></div>
		</div>
	</div>
<?php setup_footer(); ?>
