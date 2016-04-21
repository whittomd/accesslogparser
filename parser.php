<?php
/**
 * Created by PhpStorm.
 * User: derekwhittom
 * Date: 4/21/16
 * Time: 12:18 PM
 */
require_once 'vendor/autoload.php';
$path = $argv[1];
$pattern = $argv[2];
echo $pattern . PHP_EOL;
$iterator = new GlobIterator($path . '/' . $pattern);
$parser = new \Kassner\LogParser\LogParser();
$parser->setFormat('%V\t%h\t%l\t%u\t%t\t"%r"\t%>s\t%b\t%D\t"%{Referer}i"\t"%{User-Agent}i"\t"%{PHPSESSID}C"');
foreach($iterator as $fileInfo) {
   //echo $fileInfo->getFilename() . "<br>\n";
   $fileName = $path . '/' . $fileInfo->getFilename();
   echo "$fileName: " . file_exists($fileName) . PHP_EOL;
   $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

   foreach ($lines as $line) {
      $entry = $parser->parse($line);
      print_r($entry);
   }
}
//
//
//foreach ($lines as $line) {
  // $entry = $parser->parse($line);
//}