<?php
/**
 * Created by PhpStorm.
 * User: derekwhittom
 * Date: 4/27/16
 * Time: 9:43 AM
 */

use MatthiasMullie\Minify;

require_once 'vendor/autoload.php';
$path = $argv[1];

$data = file_get_contents($path);
$items = json_decode($data, true);

foreach($items as $file => $data) {
   $total = 0;
   foreach($data['urls'] as $url => $count) {
      $total += $count;
   }
   if(!empty($file) && file_exists($file)) {
      $pathData = pathinfo($file);
      $fileSize = filesize($file);
      $totalFileSize = $total * $fileSize;
      echo sprintf("%-255s\t%d\t%d\t%d\t", $file, $fileSize, $total, $totalFileSize) . PHP_EOL;
      /**if ($pathData['extension'] === 'css') {
       * $minifier = new Minify\CSS($file);
       * $outputFile = '/tmp/' . $file;
       * $minifier->minify($outputFile);
       * } elseif ($pathData['extension'] === 'js') {
       *
       * } else {
       *
       * }*/
   }
}