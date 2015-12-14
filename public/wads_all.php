<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
?>

<?php sn_page_header('All WADs'); ?>
	<?php sn_page_start_container(); ?>
		<script src='/assets/wadshared.js'></script>
		<h3>All WADs</h3>
		<table>
			<tr>
				<th>File</th>
				<th>Uploaded by</th>
				<th>Date and time</th>
			</tr>
		<?php
			$db = getsql();
			$q = $db->query("SELECT * FROM `wads` ORDER BY `time` DESC");

			while ($o = $q->fetch_object())
			{
		?>
			<tr id='wadrow-<?=$o->id;?>'>
				<td><?=$o->filename;?></td>
				<td><?=user_info($o->uploader)->username;?></td>
				<td><?=date('Y-m-d \a\t H:i:s', $o->time);?></td>
			</tr>
		<?php
			}
		?>
		</table>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
