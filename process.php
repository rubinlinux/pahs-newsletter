#!/usr/bin/php
<?php

$MAX_LEVELS = 5;

function usage() {
   global $argv;
   echo "Usage: {$argv[0]} --source=file.txt --template=file.php[--es]\n";
}

$opts = getopt("", array("es", "source:", 'template:'));

if(!array_key_exists("source", $opts) || !array_key_exists("template", $opts)) {
   usage();
   exit;
}

function parse($level) {
   global $MAX_LEVELS;
   global $wikitext;
   //echo "\n\n$level)DEBUG: Parse called ($level)\n";
   $nodes = array();
   $nodeIndex = 0;
   while(1) {
      $line = array_shift($wikitext);
      if($line === NULL) {
         //echo "$line)DEBUG: End of wikitext\n";
         break;
      }
      $line = rtrim($line);
      $type = '';
      $content = '';
      $children = Array();

      //echo "$level)DEBUG: parsing line: $line\n";
      $matches = array();
      if(preg_match('/^(=+) (.+) =+/', $line, $matches)) {
         $content = $matches[2];
         $newLevel = $MAX_LEVELS+1 - strlen($matches[1]);
         //echo "$level)DEBUG: Found a level $newLevel header: $matches[2]\n";
         if($newLevel <= $level) {
             // We moved up, put it back on the stack and return for the parent to find
             //echo "$level)DEBUG: new level $newLevel is less or equal to $level so pushing it back\n";
             array_unshift($wikitext, $line);
             return($nodes);
         }
         $type = 'header';
         $children = parse($newLevel);
         //echo "\n$level)DEBUG: Adding new header node: $content\n";
         $nodes[$nodeIndex++] = array('type'=>$type, 'level'=>$newLevel, 'content'=>$content, 'children'=>$children);
      }
      elseif(preg_match('/^\{\{(.+)\}\}/', $line, $matches)) {
         //echo "$level)DEBUG: Found an image: $matches[1]\n";
         $nodes[$nodeIndex++] = array('type' => 'image', 'content'=>$matches[1]);
      }
      elseif(preg_match('/^  \* (.+)/', $line, $matches)) {
         //echo "$level)DEBUG: Found a bullet point\n";
         $nodes[$nodeIndex++] = array('type'=>'listitem', 'content'=>$matches[1]);
      }
      elseif($line === '') {
         //echo "$level)DEBUG: adding empty node\n";
         $nodes[$nodeIndex++] = array('type' => 'empty', 'level'=>$level);
      }
      elseif($line !== '') {
         if($nodeIndex > 0 && $nodes[$nodeIndex-1]['type'] === 'general') {
            //echo "$level)DEBUG: Appending to last general node: $line\n";
            $nodes[$nodeIndex-1]['content'] .= $line;
         }
         else {
            //echo "$level)DEBUG: Adding a new general node: $line\n";
            $nodes[$nodeIndex++] = array('type'=>'general', 'level'=>$level, 'content'=>$line, 'children'=>$children);
         }
      }
   }
   return $nodes;
}

function to_xml(SimpleXMLElement &$object, array $data)
{   
    foreach ($data as $key => $value)
    {   
        if(is_numeric($key)) {
           $key = 'node';
        }
        if (is_array($value))
        {   
            $new_object = $object->addChild($key);
            to_xml($new_object, $value);
        }   
        else
        {   
            $object->addChild($key, $value);
        }   
    }   
}   

//$dom['children'] = parse(0);

//$xml = new SimpleXMLElement('<rootTag/>');
//to_xml($xml, $dom);
////print_r($xml);
//$foo = $xml->xpath('//node[type="header"]');
//print_r($foo);
//exit;

//print_r($dom);
//var_dump($dom);
function find_elements($dom, $type, $content = null, $recurse = False) {
   $ary = Array();
   foreach($dom as $value) {
      if(is_array($value)) {
         if( array_key_exists('type', $value) && $value['type'] === $type
             && ($content === null || $value['content'] === $content)) {
               $ary[] = $value;
         }
         if($recurse && is_array($value)) {
            array_append($ary, find_header($value, $content));
         }
      }

   }
   return($ary);
}

function find_element($dom, $type, $content = null, $recurse = False) {
   //echo "DEBUG: Finding element type=$type, content=$content...";

   foreach($dom as $value) {
      if( $value['type'] === $type
          && ($content === null || $value['content'] === $content)) {
            //echo "Found!\n";
            return($value);
      }
      if($recurse && is_array($value)) {
         return(find_header($value, $content));
      }
   }
   //echo "Not found :(\n";
}

function wiki2html($wikitext) {
   $ret = htmlspecialchars($wikitext);
   $ret = preg_replace('/\[\[(http.+)\|(.+)\]\]/', '<a href="$1">$2</a>', $ret);
   $ret = preg_replace('/\[\[(http.+)\]\]/', '<a href="$1">$1</a>', $ret);
   $ret = preg_replace('/\*\*(.+)\*\*/', '<b>$1</b>', $ret);
   $ret = preg_replace('/\/\/(.+)\/\//', '<i>$1</i>', $ret);
   return $ret;
}


$filename = $opts['source'];
$template = $opts['template'];

//echo "<!--";
$wikitext = file($filename);
$wikitext =& $wikitext;
$dom = parse(0);
//echo "-->";
include($template);

