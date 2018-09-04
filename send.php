#!/usr/bin/php
<?php

require_once('libphp-phpmailer/class.phpmailer.php');
require_once("class.html2text.inc");
require_once("process.php");

$to = '';
$file = '';
#if(count($argv) > 2) {
#  $file = $argv[1];
#  $to = $argv[2];
#}
#else {

function usage() {
   global $argv;
   echo "Usage: {$argv[0]} --issue=vXiY [--send=to@address] [--text]\n";
}

$opts = getopt("", array("text", "send:", "issue:"));

if(!array_key_exists("issue", $opts)) {
   usage();
   exit;
}

// TODO: read the directory and just find all language files instead of hardcoding english & spanish
$files = [ 
      "newsletter-v8iXX_en.php" => "newsletter-{$opts['issue']}_en.txt",
      #"newsletter-v7iXX_es.php" => "newsletter-{$opts['issue']}_es.txt"
];

if(array_key_exists("send", $opts)) {
   $to = $opts['send'];
}

$mail;

foreach($files as $template=>$file) {
    //$body             = file_get_contents($file);
    $body = makenewsletter($file, $template);
    if(!$body) {
       die("ERROR: file $file didnt produce a newsletter");
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
          echo "\n========== $file ===========\n";
          echo $text;
          echo "\n============================\n";
       }
       else {
          echo "\n========== $file ===========\n";
          echo $body;
          echo "\n============================\n";
       }
    }
    echo "\n";
}
