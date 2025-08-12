<?php

$email = $_SESSION['email'];

$to = $email;
$subject = 'Techvent Event Booking Confirmation';
$content = 'Your techvent event booking has been confirmed, thank you for using our service';
$headers = "From: josh050507@gmail.com\r\n";

if (mail($to, $subject, $content, $headers)) {
	echo '<script>alert("A notification email has been sent to you. Please check your spam mail if you did not see it")</script>';
} else {
	echo '<script>alert("Error, failed to send email")</script>';
}
?>