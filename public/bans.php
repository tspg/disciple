<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/common/defines.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
	include dirname(dirname(__FILE__)) . '/common/server.php';

	$db = getsql();
	$ul = UL_UNREGISTERED;

	if (is_authed())
	{
		$ul = user_info()->userlevel;
	}
?>

<?php sn_page_header('Bans'); ?>
	<?php sn_page_start_container(); ?>
		<h1>Bans</h1>
		<div id='serverboxhead'>
			<h3>Player Bans</h3>
			<div id='right'>
				<?php
					if ($ul >= UL_ADMINISTRATOR)
					{
				?>
						<input type='button' value='Add Player Ban' onclick='document.location="/ban/player"'/>
				<?php
					}
				?>
			</div>
		</div>
		<?php
			$q = $db->query("SELECT * FROM `bans`");

			if ($q->num_rows < 1)
			{
		?>
			<div id='serversbox'>
				<div style='width: 100%; text-align: center'>
					There are no player bans yet.
				</div>
			</div>
		<?php
			}
			else
			{
		?>
		<table>
			<tr>
				<th>IP</th>
				<th>Reason</th>
				<?php if ($ul >= UL_ADMINISTRATOR) { ?>Added by<?php } ?>
				<th>Added</th>
			</tr>
		<?php
			while($o = $q->fetch_object())
			{
		?>
			<tr>
				<td><?=$o->ip;?></td>
				<td><?=$o->reason;?></td>
				<?php if ($ul >= UL_ADMINISTRATOR) { echo '<td>' . user_info($o->banner)->username . '</td>'; } ?>
				<td><?=date('Y-m-d \a\t H:i:s', $o->time);?></td>
			</tr>
		<?php
			}}
		?>

		<br />

		<h3>WAD bans</h3>
		<?php
			$q = $db->query("SELECT * FROM `wadbans`");

			if ($q->num_rows < 1)
			{
		?>
			<div id='serversbox'>
				<div style='width: 100%; text-align: center'>
					There are no WAD bans yet.
				</div>
			</div>
		<?php
			}
			else
			{
		?>
		<table>
			<tr>
				<th></th>
				<th>Filename</th>
				<th>MD5</th>
				<?php if ($ul >= UL_ADMINISTRATOR) { ?><th>Added by</th><?php } ?>
				<th>Added</th>
			</tr>
		<?php
			while($o = $q->fetch_object())
			{
				$w = $db->query("SELECT `filename`,`id` FROM `wads` WHERE `md5`='" . $o->md5 . "'")->fetch_object();
		?>
			<tr>
				<td>
					<?php
						if (is_authed())
						{
							if ($ul >= UL_ADMINISTRATOR)
							{
								echo "<a href='javascript:unbanWad($w->id);' title='Unban'><img src='/images/tick.svg' alt='Unban' /></a>";
							}
						}
					?>
				</td>
				<td><?=$w->filename;?></td>
				<td><code><?=$o->md5;?></code></td>
				<?php if ($ul >= UL_ADMINISTRATOR) { echo '<td>' . user_info($o->banner)->username . '</td>'; } ?>
				<td><?=date('Y-m-d \a\t H:i:s', $o->time);?></td>
			</tr>
		<?php
			}
			echo "</table>";
		}
		?>

		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
