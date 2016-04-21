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

foreach($iterator as $fileInfo) {
   //echo $fileInfo->getFilename() . "<br>\n";
   $lines = file($path . '/' . $fileInfo->getFilename(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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