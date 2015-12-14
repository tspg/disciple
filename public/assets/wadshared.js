function wadMd5(id) {
	var sel = '#wadmd5-' + id;
	var old = $(sel).html();
	$(sel).html('Getting MD5, please wait');

	$.post('/api/wads.php',
	{
		'fn':		'md5',
		'id':		id
	})
	.done(function(d) {
		var split = d.split(' ');
		if (split[0] == 'MD5OK') {
			$(sel).html('<code>' + split[1] + '</code>');
		} else {
			$(sel).html('Failed! &mdash; ' + old);
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

function deleteWad(id) {
	$.post('/api/wads.php',
	{
		'fn':		'delete',
		'id':		id
	})
	.done(function(d) {
		if (d == 1) {
			$('#wadrow-' + id).slideUp();
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
