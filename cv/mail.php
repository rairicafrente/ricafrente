<?php
if(isset($_POST['submit'])) {

	require_once('recaptchalib.php');
	$privatekey = "6Lf1uu8SAAAAAMCAYnbracNWxTEup_Kjhigp8gxY";
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
		// Your code here to handle a successful verification
		$to = "cv@ricafrente.com";
		$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
		 
		//sumbission data
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$date = date('d/m/Y');
		$time = date('H:i:s');
		 
		// data the visitor provided
		$name_field = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$email_field = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		$comment = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
		$headers = "From: $name_field" . "\r\n" .
			"Reply-To: $email_field" . "\r\n" .
			'X-Mailer: PHP/' ;
		 
		//constructing the message
		$body = "Subject: $subject\nIP: $ipaddress\nDate Submitted: $date, $time\n\nFrom: $name_field\n\n E-Mail: $email_field\n\n Message:\n\n $comment";
		 
		// ...and away we go!
		mail("$to", "$subject", "$body", "$headers");
		 
		// redirect to confirmation
		header('Location: http://ricafrente.com/#arigato');
		//header('Location: index.html/#arigato');
	}
} else {
		// handle the error somehow
}
?>
