<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';

	function human_filesize($bytes, $decimals = 2)
	{
		$sz = ' KMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f %sB", $bytes / pow(1024, $factor), @$sz[$factor]);
	}
?>

<?php sn_page_header('WADs'); ?>
	<?php sn_page_start_container(); ?>
		<script>
			function wadupload() {
				$('#clickme').click();
				$('#clickme').change(function() {
					$('#clickmetoo').click();
					$('#upload-button').text('Uploading, please wait...');
					$('#upload-button').prop('disabled', true);
				});
			}
		</script>

		<h1>WADs</h1>
		<?php
			if (is_authed())
			{
				if (isset($_GET['ok']))
				{
					echo "<div class='submit-ok-box'>Uploaded file <code>" . $_GET['ok'] . "</code> successfully.</div>";
				}
				elseif (isset($_GET['exists']))
				{
					echo "<div class='submit-err-box'>File <code>" . $_GET['exists'] . "</code> already exists on the server.</div>";
				}
				elseif (isset($_GET['iwad']))
				{
					echo "<div class='submit-err-box'>You are not allowed to upload commerical IWADs.</div>";
				}
				elseif (isset($_GET['unknownerror']))
				{
					echo "<div class='submit-err-box'>An unknown error occured while uploading <code>" . $_GET['exists'] . "</code>.</div>";
				}
		?>
			<form action='/api/wadupload.php' method='POST' id='upform' enctype='multipart/form-data'>
				<input type='hidden' name='doup' value='true' />
				<div style='width:100%;display:table'>
					<div id='upload-button' onclick='wadupload()'>Upload</div>
				</div>
				<input type='hidden' value='form' name='<?php echo ini_get('session.upload_progress.name'); ?>'>
				<input type='file' name='file' style='display: none' id='clickme' />
				<input type='submit' name='sb' style='display: none' value='Upload' id='clickmetoo' />
			</form>

			<br /><hr /><br />
		<?php
			}
		?>
		<div id='serverboxhead'>
			<h3>Most Recent WADs</h3>
			<div id='right'>
				<input type='button' value='View All' onclick='document.location="/wads/all"'/>
			</div>
		</div>
		<table>
			<tr>
				<th>File</th>
				<th>Size</th>
				<th>Uploaded by</th>
				<th>Date and time</th>
			</tr>
		<?php
			$db = getsql();
			$q = $db->query("SELECT * FROM `wads` ORDER BY `time` DESC LIMIT 20");

			while ($o = $q->fetch_object())
			{
		?>
			<tr>
				<td><a href='/wads/<?=$o->filename;?>'><?=$o->filename;?></a></td>
				<td><?=human_filesize(filesize(disciple_json()->serverdata . '/wads/' . $o->filename));?></td>
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
