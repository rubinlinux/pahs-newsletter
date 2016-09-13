<?php

require_once('libphp-phpmailer/class.phpmailer.php');
require_once("class.html2text.inc");

$to = '';
$file = '';
if(count($argv) > 2) {
  $file = $argv[1];
  $to = $argv[2];
}
else {
   echo "Usage: {$argv[0]} <file.html> <to>\n";
   exit;
}

$mail             = new PHPMailer(); // defaults to using php "mail()"
$mail->CharSet = 'utf-8';

$body             = file_get_contents($file);
if(!$body) {
   echo "ERROR: file $file doesn't seem to contain anything\n";
}

# Protect the email from harmful char - this could be a problem.. 
$body             = eregi_replace("[\]",'',$body);

$mail->SetFrom('rubin@afternet.org', 'Alex Schumann');
$mail->AddAddress("$to");
$mail->Subject = "Holt Quick News";
$mail->MsgHTML($body);

$h2t = &new html2text($body);
$text = $h2t->get_text();

$mail->AltBody = $text;

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
echo "\n";


    
