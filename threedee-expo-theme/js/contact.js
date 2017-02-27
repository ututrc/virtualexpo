/**
 * Contact JS file
 */

jQuery(document).ready(function($) {
	$('#contactbutton').click(function() {
		$('#contact-msg').html('<img src="http://mailgun.github.io/validator-demo/loading.gif" alt="Loading..."><span class="hold-on-text">Hold on, email is being sent.</span>');
		var message = $('#message').val();
		var name = $('#name').val();
		var email = $('#email').val();
		if (!message || !name || !email) {
			$('#contact-msg').html('At least one of the form fields is empty.');
			return false;
		} else {
			$.ajax({
				type: "GET",
				url: 'https://api.mailgun.net/v2/address/validate?callback=?',
				data: { address: email, api_key: 'pubkey-e88dbca885c19eb5aa293d084aa4edc5' },
				dataType: "jsonp",
				crossDomain: true,
				success: function(data, status_text) {
					if (data['is_valid']) {
						$.ajax({
							type: 'POST',
							url: ajax_object.ajax_url,
							data: $('#contactform').serialize(),
							dataType: 'json',
							success: function(response) {
								if (response.status == 'success') {
									$('#contactform')[0].reset();
								}
								$('#contact-msg').html(response.errmessage);
							}
						});
					} else {
						if (data['did_you_mean']) {
							$('#contact-msg').html('Error, did you mean <em>' +  data['did_you_mean'] + '</em>?');
						} else {
							$('#contact-msg').html('The entered mail address is invalid.');
						}
						return false;
					}
				},
				error: function(request, status_text, error) {
					$('#contact-msg').html('Error occurred, unable to validate your email address.');
					return false;
				}
			});
		}
	});
});