<?php

require_once('libphp-phpmailer/class.phpmailer.php');

$to = '';
if(count($argv) > 1) {
  $to = $argv[1];
  echo "DEBUG: Set to to $to\n";
}
else {
   echo "Usage: {$argv[0]} <to>\n";
   exit;
}

$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = file_get_contents('newsletter-v6i1.html');
$body             = eregi_replace("[\]",'',$body);

$mail->SetFrom('rubin@afternet.org', 'Alex Schumann');
$mail->AddAddress("$to");
$mail->Subject = "Holt Quick News";
$mail->MsgHTML($body);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
echo "\n";
    
