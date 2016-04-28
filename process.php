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
$totalItems = count($items);
echo "Starting to process $totalItems items\n";
$index = 0;
foreach($items as $url => $count) {
   $index++;
   $file = file_get_contents($url);
   if(empty($file)) {
      $url = str_replace(array('.min', 'minified/'), array('', ''), $url);
      $file = file_get_contents($url);
   }
   echo "Item $index/$totalItems: Working: $url => $file\n";

   $finalItems[$file]['urls'][$url] = $count;
}

$finalItemsJson = json_encode($finalItems);
file_put_contents('finaloutput.json', $finalItemsJson);