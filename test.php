<?php
	$to = "kdarling95@yahoo.com";
	$subject = "Test mail";
	$message = "Hello, this is a test!";
	$from = "miahhoerter1@gmail.com";
	$headers = "From:" . $from;
	mail($to,$subject,$message,$headers);
	echo "Mail sent.";
?>
