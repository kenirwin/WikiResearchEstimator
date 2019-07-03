#!/usr/bin/env php 
<?php

error_reporting(E_ALL); 
ini_set('display_errors', 1);
require_once dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
require_once dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR . '/config.php';
getConfig();

use WikiResearch\Estimator;
use WikiResearch\Harvester;

$times_per_minute = 6; 

for ($i=0; $i<$times_per_minute; $i++) {
$eds = new Estimator;
$db = new Harvester;
$batch = $db->getBatch();
$next = $db->getNext($batch);
$filename = $eds->getFilename($next['name']);

switch($batch) {
case 1: 
  $query = $next['name'];
  break;
case 2: 
  $query = '"' . $next['name'] . '"'; //quoted string
  break;
case 3: 
  $query = $next['name'] . ' and (danc* or choreogr*)'; //quoted string
  break;
case 4:
  $query = '"' . $next['name'] . '" and (danc* or choreogr*)'; //quoted string
  break;
}
print "<li><b>$query</b></li>";
$eds->query($query);
$uri = EDS_GATEWAY . $eds->queryString;
$eds->fetch($uri); //creates $eds->response
$eds->loadXmlObject();
$eds->getFacets();
if (sizeof($eds->facets) < 1) {
  $eds->facets = array('No Results'=>0);
}
$response = $db->recordResults($next['id'],$batch,$query,$eds->facets);
print_r($response);

print "<li>$uri</li>".PHP_EOL;

$db->saveXML($next['id'],$batch,$query,$eds->raw_xml);
/*
$fp = fopen (dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR .'/data' . DIRECTORY_SEPARATOR . $filename, 'w');
if (fwrite($fp, $eds->raw_xml)) {
  $db->updateTable($next['id'], $eds->raw_xml);
}
fclose($fp);
*/
unset($eds);
unset($db);
sleep(5);
}
?>
