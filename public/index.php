<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
	include dirname(dirname(__FILE__)) . '/common/server.php';
?>

<?php sn_page_header('Main'); ?>
	<?php sn_page_start_container(); ?>
		<h1>Welcome to <?=disciple_json()->site_name;?></h1>

		<div id='serverboxhead'>
			<h3>Your Servers</h3>
			<div id='right'>
				<input type='button' value='Create Server' onclick='document.location="/server/new"'/>
			</div>
		</div>

		<div id='serversbox'>
			<?php
				$userv = server::get_user_servers($_SESSION['id']);

				if (count($userv) < 1)
				{
					echo "<div style='width: 100%; text-align: center'>You don't have any running servers.<br />Use the <em>Create Server</em> button above to start one.</div>";
				}
			?>
		</div>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
