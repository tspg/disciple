<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/common/controls.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
	include dirname(dirname(__FILE__)) . '/common/server.php';

	if (!is_authed())
	{
		Header("Location: /");
		exit();
	}
?>

<?php sn_page_header('Create Server'); ?>
	<?php sn_page_start_container(); ?>
		<h1>Create Server</h1>

		<style type='text/css'>
			td { padding: 5px 10px; vertical-align: top; }
		</style>

		<script>
			function nv(n) {
				return $('[name="' + n + '"]').val();
			}

			function getPostArguments() {
				return {
					'binary':		nv('binary'),
					'hostname':		nv('hostname'),
					'iwad':			nv('iwad'),
					'gamemode':		nv('gamemode'),
					'instagib':		$('[name="instagib"]').checked(),
					'buckshot':		$('[name="buckshot"]').checked(),
					'skill':		nv('skill'),
					'dmflags':		nv('dmflags'),
					'dmflags2':		nv('dmflags2'),
					'zadmflags':	nv('zadmflags'),
					'compatflags':	nv('compatflags'),
					'zacompatflags':nv('zacompatflags')
				}
			}
		</script>
		<!-- tables for formatting like it's pre-html5 baby -->
		<table style='width:100%;background:none'>
			<tr>
				<td style='width:25%'>
					<strong>Zandronum version</strong>
					<select name='binary'>
						<option value='main'>Main binary</option>
					</select>

					<br/><br/>
					<strong>Hostname</strong>
					<input type='text' name='hostname' />

					<br/><br/>
					<strong>IWAD</strong>
					<select name='iwad'>
						<option value='doom'>Doom</option>
						<option value='doom2'>Doom II</option>
						<option value='plutonia'>Final Doom: Plutonia</option>
						<option value='tnt'>Final Doom: TNT</option>
						<option value='heretic'>Heretic</option>
						<option value='hexen'>Hexen</option>
						<option value='hexdd'>Hexen: Deathkings of the Dark Citadel</option>
					</select>

					<br/><br/>
					<strong>Game mode</strong>
					<select name='gamemode'>
						<option value='cooperative'>Co-operative</option>
						<option value='survival'>Survival</option>
						<option value='invasion'>Invasion</option>
						<option value='deathmatch'>Deathmatch</option>
						<option value='teamdm'>Team deathmatch</option>
						<option value='terminator'>Terminator</option>
						<option value='possession'>Possession</option>
						<option value='teampossession'>Team possession</option>
						<option value='skulltag'>Skulltag</option>
						<option value='duel'>Duel</option>
						<option value='domination'>Domination</option>
						<option value='ctf'>Capture the Flag</option>
						<option value='oneflag'>One-Flag Capture the Flag</option>
						<option value='teamgame'>ACS team game</option>
					</select>

					<br/><br/>
					<strong>Modifiers:</strong>
					<label>
						<input type='checkbox' name='instagib' />
						Instagib
					</label>

					<label>
						<input type='checkbox' name='buckshot' />
						Buckshot
					</label>

					<br/><br/>
					<strong>Skill level</strong>
					<input type='number' name='skill' value='0' min='0' />

					<br/><br/>
					<strong>DMFlags</strong>
					<input type='number' name='dmflags' value='0' min='0' />

					<br/><br/>
					<strong>DMFlags 2</strong>
					<input type='number' name='dmflags2' value='0' min='0' />

					<br/><br/>
					<strong>Zandronum DMFlags</strong>
					<input type='number' name='zadmflags' value='0' min='0' />

					<br/><br/>
					<strong>Compatibility flags</strong>
					<input type='number' name='compatflags' value='0' min='0' />

					<br/><br/>
					<strong>Zandronum compatibility flags</strong>
					<input type='number' name='zacompatflags' value='0' min='0' />
				</td>
				<td style='width:25%'>
					<strong>WADs</strong>
					<?php wad_selection_box('addWad'); ?>

					<br/>
					<strong>Optional WADs</strong>
					<?php wad_selection_box('addOptwad'); ?>

					<label>
						<input type='checkbox' name='stdata' />
						Load Skulltag data
					</label>
				</td>
			</tr>
			<tr>
				<td></td>
				<td style='text-align:right'>
					<input type='button' value='Save' />
					<input type='button' value='Create and Start Server' />
				</td>
			</tr>
		</table>
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
