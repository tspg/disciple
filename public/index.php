<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
	include dirname(dirname(__FILE__)) . '/common/server.php';
?>

<?php sn_page_header('Main'); ?>
	<?php sn_page_start_container(); ?>
		<h1>Welcome to <?=disciple_json()->site_name;?></h1>

		<?php
			if(is_authed())
			{
		?>
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
					else
					{
?>
						<table>
							<tr>
								<th></th>
								<th>Hostname</th>
							</tr>
<?php						foreach ($userv as $v)
							{
?>								<tr>
									<td><a href='/server/<?=$v->id;?>'><i class='material-icons'>edit</i></a></td>
									<td><?=$v->hostname;?></td>
								</tr>
<?php
							}
?>
						</table>
<?php
					}
?>
			</div>
		<?php
			}
			else
			{
		?>
			<?=disciple_json()->site_name;?> is a semi-automatic server hosting service for Zandronum. It allows users to host their own servers
			using a web-based interface, without any of the hassle that is port forwarding, seeing if other people can see your server, etc.
			<br/>
			<br/>
			To use <?=disciple_json()->site_name;?>, simply <a href='/register'>register</a>. You can then host a maximum of
			<?=disciple_json()->serverlimit;?> servers for free.

		<?php
			}
		?>
		<br />
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
