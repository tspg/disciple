<?php
	include 'setup_common.php';
?>

<?php setup_header('Tests'); ?>
	<div class='centre'>
		<img src='../images/d_log1.png' id='wiz' />
		<h3 style='margin:0'>Testing your configuration, one second...</h3>
		<br />
		<script>
			rotateWizard();
			test_configs();
		</script>

		<div class='card'>
			Testing MySQL configuration<div id='mysql_status' class='stat'></div>
			<br />
			Populating database<div id='mysql_pop_status' class='stat'></div>

			<div id='alldone' style='display:none'>All done!</div>
		</div>
	</div>
<?php setup_footer(); ?>
