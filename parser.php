<?php
/**
 * Created by PhpStorm.
 * User: derekwhittom
 * Date: 4/21/16
 * Time: 12:18 PM
 */
require_once 'vendor/autoload.php';
$pattern = argv(2);
$iterator = new GlobIterator($pattern);
foreach($iterator as $fileInfo) {
   echo $fileInfo->getFilename() . "<br>\n";
}
//$parser = new \Kassner\LogParser\LogParser();
//$lines = file('/var/log/apache2/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//foreach ($lines as $line) {
  // $entry = $parser->parse($line);
//}