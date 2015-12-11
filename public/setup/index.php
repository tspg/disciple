<?php
	include 'setup_common.php';
?>

<?php setup_header(); ?>
	<div class='centre'>
		<img src='../images/d_log1.png' />
		<h3 style='margin:0'>Welcome to Disciple</h3>
		<em onclick='slog()' style='cursor:default' id='slogan'><?php include 'randslogan.php'; ?></em>
		<br />

		<div class='card'>
			Welcome to the setup wizard for Disciple, a web-based service that allows users to host their own servers, simply
			via a simple web interface.

			<br />
			<br />

			<input type='button' value="Let's go!" onclick='document.location="../setup/step1.php"' />
		</div>
	</div>
<?php setup_footer(); ?>
