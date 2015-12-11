<?php
	include 'setup_common.php';

	touch(dirname(dirname(dirname(__FILE__))) . '/config/.gen');
?>

<?php setup_header('Configuration'); ?>
	<div class='centre'>
		<img src='../images/d_log1.png' id='wiz' />
		<h3 style='margin:0'>All done!</h3>
		<br />

		<div class='card'>
			Disciple has been set up on your server successfully!
			<br />
			<br />
			<input type='button' value='Go to your Disciple installation' onclick='document.location="../";' />
		</div>
	</div>
<?php setup_footer(); ?>
