<?php
	// Get sendGrid library from composer autoload file.
	require 'vendor/autoload.php';
	/**
	* Args: string recipientEmail (email address of intended recpient), string subject (the email subject) &
	* & string message (the email content).
	* 
	* Sends email to address indicated with $recipientEmail argument, with a subject of $subject and a message of $message.
	*/
	function sendNotification($recipientEmail, $subject, $message) 
	{
		$from = new SendGrid\Email(null, "notifications@onthespot.com");
		$to = new SendGrid\Email(null, $recipientEmail);
		$content = new SendGrid\Content("text/html", $message);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);

		//This should be set to a heroku variable, however to allow local versions to work correctly it has been hardcoded.
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
		echo $response->statusCode();
		echo $response->headers();
		echo $response->body();
	}

	/**
	* Args: string recipientEmail (email address of intended recpient), string firstName (the firstname of the recipient).
	* 
	* Sends email to address indicated notifying them there account has been created.
	*/
	function sendConfirmAccount($recipientEmail, $firstName) {
		$message = '
			<html>
			<head></head>
			<body>
				<h3>Hello '.$firstName.'!</h3>
				<p>
					You have successfully created an On the Spot Account!
				</p>
				<p>
					Log in <a href="https://ifb299-group52.herokuapp.com/login.php">here</a> to begin ordering today!
				</p>
				<p>
					Regards, <br>
					-<a href="https://ifb299-group52.herokuapp.com">The On the Spot team.</a>
				</p>
			</body>
			</html>';
			//Send email
			sendNotification($recipientEmail, 'On the Spot account created.', $message);
	}

		/**
	* Args: string recipientEmail (email address of intended recpient), string firstName (the firstname of the recipient).
	* 
	* Sends email to address indicated notifying them there account has been created.
	*/
	function sendConfirmOrder($recipientEmail, $firstName, $pickAddress, $pickState, $pickPost, 
		$pickTime, $recpAddress, $recpState, $recpPost, $recpName, $recpPhone, $recpTime) {
		$message = '
			<html>
			<head></head>
				<body>
					<h3>Hello '.$firstName.'</h3>
					<p>
						You have successfully made an order with the following details:
					</p>
					<p style = "padding-left: 30px">
						Pickup Address: '.$pickAddress.' <br>
						Pickup State: '.$pickState.' <br>
						Pickup Postcode: '.$pickPost.' <br>
						Preferred Pickup Time: '.$pickTime.' (Note that this is not guaranteed) <br>
						<br>
						Recipient Address: '.$recpAddress.' <br>
						Recipient State: '.$recpState.' <br>
						Recipient Postcode: '.$recpPost.' <br>
						Recipient Name: '.$recpName.' <br>
						Recipient Phone: '.$recpPhone.' <br>
						Preferred Delivery Time: '.$recpTime.' (Note that this is not guaranteed) <br>
					</p>
					<p>
						To view your order please click here (link to be added).
					</p>
					<p>
						Regards, <br>
						-<a href="https://ifb299-group52.herokuapp.com">The On the Spot team.</a>
					</p>
				</body>
			</html>';
			//Send email
			sendNotification($recipientEmail, 'Your order has been processed.', $message);
	}
?>