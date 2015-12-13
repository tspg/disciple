var WIZ_ROTATE_SPEED = 1;
var stopRotate = false;

function slog() {
	$.get('../setup/randslogan.php')
	.done(function(d) {
		$('#slogan').text(d);
	});
}

var wizy = 0;

function rotateWizard() {
	do_rotateWizard();
}

function do_rotateWizard() {
	if (wizy == 360 - 1) {
		wizy = 0;
	} else {
		wizy++;
	}

	value = 'rotateY(VALUEdeg)'.replace(/(VALUE)/g, wizy);

	$('#wiz').css({
		'transform':	value
	});

	if (stopRotate) {
		if (wizy != 0) {
			setTimeout(function() {
				do_rotateWizard();
			}, WIZ_ROTATE_SPEED);
		} else return;
	} else {
		setTimeout(function() {

			do_rotateWizard();
		}, WIZ_ROTATE_SPEED);
	}
}

function errcard(head, content) {
	stopRotate = true;
	$('.card').html('<h1>' + head + '</h1>' + content + '<br/><br/><input type=\'button\' value=\'Try again\' onclick=\'location.reload()\' />');
}

function test_configs() {
	$('#mysql_status').html('...');
	$.post('test_mysql.php')
	.done(function(d) {
		if (d == '1') {
			$('#mysql_status').html(': okay.');
			pop_db();
		} else {
			errcard('MySQL Test Failed', 'The MySQL test failed.<br />' + d);
		}
	})
	.fail(function(d) {
		errcard('MySQL Test Failed', 'The MySQL test failed.<br />' + d.status + ' ' + d.statusText);
	});
}

function pop_db() {
	$('#mysql_pop_status').html('...');
	$.post('pop_mysql.php')
	.done(function(d) {
		if (d == '1') {
			$('#mysql_pop_status').html(': okay.');
			$('#alldone').slideDown();
			stopRotate = true;
			setTimeout(function() {
				document.location = 'step2.php';
			}, 2000);
		} else {
			errcard('Database Population Failed', 'Failed to populate the database.<br />' + d);
		}
	})
	.fail(function(d) {
		errcard('Database Population Failed', 'Failed to populate the database.<br />' + d.status + ' ' + d.statusText);
	});
}

function cfg_err(content) {
	$('#submit-err').html(content);
	$('#submit-err').show();
}

function reset_submit() {
	$('#sendbutton').prop('disabled', false);
	$('#sendbutton').val('Submit');
}

function post_config() {
	$('#submit-err').hide();
	$('#sendbutton').prop('disabled', true);
	$('#sendbutton').val('Submitting...');

	$.post('do_cfg.php', {
		'site_name':		$('#site_name').val(),
		'site_shortname': 	$('#site_shortname').val(),
		'binary':			$('#binary').val(),
		'serverlimit':		$('#serverlimit').val(),
		'rootuser':			$('#rootuser').val(),
		'rootpass':			$('#rootpass').val(),
		'serverdata':		$('#serverdata').val()
	})
	.done(function(d) {
		if (d == '1') {
			$('#sendbutton').val('Done.');
			document.location = 'step3.php';
		} else {
			cfg_err('Failed to write the configuration.');
		}
	})
	.fail(function(d) {
		if (d.status == 400) {
			var msg = d.responseText.split(' ');
			var code = msg.shift();
			msg = msg.join(' ');
			cfg_err('<strong>API Error ' + code + '</strong><br/>' + msg);
			reset_submit();
		} else {
			cfg_err('Failed to write configuration.<br />' + d.status + ' ' + d.statusText);
			reset_submit();
		}

		reset_submit();
	})
}

function reset_bb() {
	$('#import_button').prop('disabled', false);
	$('#skip_button').prop('disabled', false);
	$('#import_button').val('Import');
}

function import_bestbot() {
	$('#submit-err').show();
	$('#submit-err').text('Importing from BestBot.<br/>This can take a while, depending on the size of your database.');
	$('#import_button').prop('disabled', true);
	$('#skip_button').prop('disabled', true);
	$('#import_button').val('Importing...');

	$.post('import_bestbot.php', {
		'db_host':	$('#db_host').val(),
		'db_port':	$('#db_port').val(),
		'db_name':	$('#db_name').val(),
		'db_user':	$('#db_user').val(),
		'db_pass':	$('#db_pass').val()
	})
	.done(function(d) {
		if (d == '1') {
			$('#sendbutton').val('Done.');
			document.location = 'step4.php';
		} else {
			cfg_err('Failed to import.');
			reset_bb();
		}
	})
	.fail(function(d) {
		reset_bb();
		if (d.status == 400) {
			var msg = d.responseText.split(' ');
			var code = msg.shift();
			msg = msg.join(' ');
			cfg_err('<strong>API Error ' + code + '</strong><br/>' + msg);
		} else {
			cfg_err('Failed import.<br />' + d.status + ' ' + d.statusText);
		}

		reset_submit();
	})
}
