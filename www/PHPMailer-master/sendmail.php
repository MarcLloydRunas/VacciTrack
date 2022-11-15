<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';
require '../src/Exception.php';
require '/src/SMTP.php';
require '/src/PHPMailer';

$mail = new PHPMailer(true);

try {
	$mail->SMTPDebug = 2;									
	$mail->isSMTP(true);											
	$mail->Host	 = 'smtp.gmail.com;';					
	$mail->SMTPAuth = true;							
	$mail->Username = 'marcsahoy477';				
	$mail->Password = 'dipiGrupam420';						
	$mail->SMTPSecure = 'tls';							
	$mail->Port	 = 587;

	$mail->setFrom('marcsahoy477@gmail.com', 'Name');		
	//$mail->addAddress('marcsahoy@gmail.com');
	//$mail->addAddress('receiver2@gfg.com', 'Name');
	
	$mail->isHTML(true);								
	$mail->Subject = 'Subject';
	$mail->Body = 'HTML message body in <b>bold</b> ';
	$mail->AltBody = 'Body in plain text for non-HTML mail clients';
	$mail->send();
	echo "Mail has been sent successfully!";
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>

