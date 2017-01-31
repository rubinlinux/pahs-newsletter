#!/usr/bin/php
<?php

require_once('libphp-phpmailer/class.phpmailer.php');
require_once("class.html2text.inc");

$to = '';
$file = '';
#if(count($argv) > 2) {
#  $file = $argv[1];
#  $to = $argv[2];
#}
#else {

function usage() {
   global $argv;
   echo "Usage: {$argv[0]} --file=file.html [--send=to@address] [--text]\n";
}

$opts = getopt("", array("text", "send:", "file:"));

if(!array_key_exists("file", $opts)) {
   usage();
   exit;
}
$file = $opts['file'];

if(array_key_exists("send", $opts)) {
   $to = $opts['send'];
}

$mail;

$body             = file_get_contents($file);
if(!$body) {
   echo "ERROR: file $file doesn't seem to contain anything\n";
}

# Protect the email from harmful char - this could be a problem.. 
$body             = eregi_replace("[\]",'',$body);

$h2t = new html2text($body);
$text = $h2t->get_text();

if($to) {
   $mail             = new PHPMailer(); // defaults to using php "mail()"
   $mail->CharSet = 'utf-8';

   $mail->SetFrom('rubin@afternet.org', 'Alex Schumann');
   $mail->AddAddress("$to");
   $mail->Subject = "Holt Quick News";
   $mail->MsgHTML($body);
   $mail->AltBody = $text;

   if(!$mail->Send()) {
     echo "Mailer Error: " . $mail->ErrorInfo;
   } else {
     echo "Message sent!";
   }
}
else {
   if(array_key_exists('text', $opts)) {
      echo $text;
   }
   else {
      echo $body;
   }
}
echo "\n";


    
