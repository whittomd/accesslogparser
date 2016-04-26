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
$parser->setFormat("%V\t%h\t%l\t%u\t%t\t\"%r\"\t%>s\t%b\t%D\t\"%{Referer}i\"\t\"%{User-Agent}i\"\t\"%{PHPSESSID}i\"");
echo $parser->getPCRE();
$items = array();
foreach($iterator as $fileInfo) {
   //echo $fileInfo->getFilename() . "<br>\n";
   $fileName = $path . '/' . $fileInfo->getFilename();
   echo "$fileName: " . file_exists($fileName) . PHP_EOL;
   if($fileInfo->getExtension() === 'gz') {
      $lines = gzfile($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
   } else {
      $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
   }

   foreach ($lines as $line) {
      try {
         $entry = $parser->parse($line);
         if (!empty($entry->request)) {
            if (preg_match("/(.*) (.*) (.*)/U", $entry->request, $output)) {
               $uri = $output[2];
               $url = "http://www.talentwise.com" . $uri;
               $urlComponents = parse_url($url);
               $file = $urlComponents['path'];
               if (preg_match("/^.*\.(jpg|jpeg|png|gif|css|woff|woff2|eot|js)$/i", $file, $outputData)) {
                  if (!empty($outputData[0])) {
                     $assetName = $outputData[0];
                     $assetNameParts = explode('/', $assetName);
                     if(in_array($assetNameParts[2], array('templates', 'javascript'))) {
                        array_shift($assetNameParts);
                        $assetName = implode('/', $assetNameParts);
                     }
                     if (!isset($items[$assetName])) {
                        $items[$assetName] = 0;
                     }
                     $items[$assetName]++;
                  }
               }
            }
         }
      } catch (\Exception $e) {

      }
   }
}

print_r($items);
//
//
//foreach ($lines as $line) {
  // $entry = $parser->parse($line);
//}