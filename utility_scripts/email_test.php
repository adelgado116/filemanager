<?php

// Include the phpmailer class
require 'ThirdParty/phpmailer/class.phpmailer.php';
// Instantiate it
$mail = new phpmailer();

// Define who the message is from
$mail->From = 'auto@hss-panama.com';
$mail->FromName = 'HSS System';

// Set the subject of the message
$mail->Subject = 'Test Message';

// Add the body of the message
$body = 'This is a test from HSS intenal system';

$mail->Body = $body;

// Add a recipient address
$mail->AddAddress('ade@hss-panama.com', 'Alberto Delgado');

$mail->AddAttachment("blank_report.pdf", "blank_report.pdf");


// Send the message
if (!$mail->Send()) {
	echo 'Mail sending failed at '.date('h:i:s').' on '.date('d.m.Y');
} else {
	echo 'Mail has been passed on to SMTP server at '.date('h:i:s').' on '.date('d.m.Y');
}

// Clear all addresses and attachments for next loop
$mail->ClearAddresses();
$mail->ClearAttachments();

?>
