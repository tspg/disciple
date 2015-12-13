<?php
	include dirname(dirname(__FILE__)) . '/common/pages.php';
	include dirname(dirname(__FILE__)) . '/config/config.php';
?>

<?php sn_page_header('Register'); ?>
	<?php sn_page_start_container(); ?>
		<script>
			function err(v) {
				$('.submit-err').html(v);
			}

			function enable_button() {
				$('#gobutt').prop('disabled', false);
				$('#gobutt').val('Register');
			}

			function disable_button() {
				$('#gobutt').prop('disabled', true);
				$('#gobutt').val('Registering...');
			}

			function do_register() {
				disable_button();
				$.post('/api/user.php',
				{
					'fn':		'register',
					'username':	$('#user').val(),
					'password':	$('#pass').val(),
					'email':	$('#email').val()
				})
				.done(function(d) {
					if (d == '1') {
						$('#gobutt').val('Done.');
						document.location = '/login?fromreg=' + $('#user').val();
					} else {
						err('Failed to sign up.');
						enable_button();
					}
				})
				.fail(function(d) {
					enable_button();
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

		<h1>Register</h1>
		<div style='text-align: center;'>
			<div class='card'>
				<div class='submit-err'></div>

				<input type='text' placeholder='Username' id='user' />
				<br />
				<input type='password' placeholder='Password' id='pass' />
				<br />
				<input type='email' placeholder='E-mail' id='email' />
				<br />
				<input type='button' value='Register' onclick='do_register()' id='gobutt' />
				<br />
			</div>
		</div>
		<br />
		<?php sn_page_cfooter(); ?>
	<?php sn_page_end_container(); ?>
<?php sn_page_footer(); ?>
