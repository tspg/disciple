<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/common/wads.php';
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
		<script src='/assets/wadshared.js'></script>
		<script>
			function err(e) {
				$('#ss-err-box').hide();
				$('#ss-err-box').html('');
				$('#js-err-box').hide();
				$('#js-err-box').show();
				$('#js-err-box').html(e);
			}

			function derr() {
				$('#ss-err-box').hide();
				$('#ss-err-box').html('');
				$('#js-err-box').hide();
				$('#js-err-box').html('');
			}

			function wadupload() {
				$('#clickme').click();
				$('#clickme').change(function() {
					derr();
					$('#clickmetoo').click();
					$('#upload-button').text('Uploading, please wait...');
					$('#upload-button').prop('disabled', true);

					// update_progress();
				});
			}

			function update_progress() {
				$.post('/api/wads.php',
				{
					'fn':		'upload_progress',
					'formname':	$('#__form_name').val()
				})
				.done(function(d) {
					var split = d.split(' ');
					if (split.length == 1) {
						$('#upload-button').text('Uploading &mdash; ' + d + '%');
						setTimeout(function() {
							update_progress();
						}, 100);
					} else {
						var code = split.shift();
						var l = split.join(' ');
						$('#upload-button').text(code + ' ' + l);
					}
				})
				.fail(function(d) {
					if (d.status == 400) {
						var msg = d.responseText.split(' ');
						var code = msg.shift();
						msg = msg.join(' ');
						err('<strong>API Error ' + code + '</strong><br/>' + msg);
					} else {
						err('Failed import.<br />' + d.status + ' ' + d.statusText);
					}
				});
			}
		</script>

		<h1>WADs</h1>
		<?php
			if (is_authed())
			{
				$type = (isset($_GET['ok']) ? 'ok' : 'err');
				$c = '';

				if (isset($_GET['ok']))
				{
					$c = "Uploaded file <code>" . $_GET['ok'] . "</code> successfully.";
				}
				elseif (isset($_GET['exists']))
				{
					$c = "File <code>" . $_GET['exists'] . "</code> already exists on the server.";
				}
				elseif (isset($_GET['iwad']))
				{
					$c = "You are not allowed to upload commerical IWADs.";
				}
				elseif (isset($_GET['unknownerror']))
				{
					$c = "An unknown error occured while uploading <code>" . $_GET['exists'] . "</code>.";
				}
				elseif (isset($_GET['badext']))
				{
					$c = "The file type <code>" . $_GET['badext'] . "</code> is not supported..";
				}
				else
				{
					$c = null;
				}

				$h = '';
				if ($c == null)
				{
					$h = "<div class='submit-$type-box' id='ss-err-box' style='display:none'>";
				}
				else
				{
					$h = "<div class='submit-$type-box' id='ss-err-box'>";
				}

				echo $h;
				echo $c;
				echo "</div>";
		?>
			<div class='submit-err-box' id='js-err-box' style='display:none'></div>
			<form action='/api/wads.php' method='POST' id='upform' enctype='multipart/form-data'>
				<input type='hidden' name='doup' value='true' />
				<input type='hidden' name='fn' value='upload' />
				<div style='width:100%;display:table'>
					<div id='upload-button' onclick='wadupload()'>Upload</div>
				</div>
				<input type='hidden' id='__form_name' value='form<?=mt_rand() + time();?>' name='<?php echo ini_get('session.upload_progress.name'); ?>'>
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
		<?php display_wad_table(20); ?>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
