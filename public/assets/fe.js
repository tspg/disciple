$(function() {
	$(document).tooltip();
});

function acceptCookies() {
	$('#shittyeucookienoticebar').slideUp();
	$.post('/api/acceptcookiebanner.php');
}

$(window).on('load', function() {
	setTimeout(function() {
		$('#shittyeucookienoticebar').slideDown();
	}, 400);
});
