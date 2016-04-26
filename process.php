<?php
/**
 * Created by PhpStorm.
 * User: derekwhittom
 * Date: 4/26/16
 * Time: 1:08 PM
 */

require_once 'vendor/autoload.php';
$path = $argv[1];

$data = file_get_contents($path);
$items = json_decode($data, true);
$finalItems = array();
foreach($items as $url => $count) {

   $file = file_get_contents($url);
   if(empty($file)) {
      $url = str_replace(array('.min', 'minified/'), array('', ''), $url);
      $file = file_get_contents($url);
   }
   echo "Working: $url => $file\n";

   if(empty($finalItems[$file])) {
      $finalItems[$file] = $count;
   } else {
      $finalItems[$file] += $count;
   }
}