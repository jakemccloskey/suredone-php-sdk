<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// post_editor_data might be correct function

require_once(dirname(__FILE__).'/../includes/SureDone_Startup.php');
$token = "452B9137D17FDF14482E87BB78FB1781B3A854CCF1399D43EF5983D44414FDA48162106218EF830C6J1ONVAVKW5LVCN9U8FQA023ULATCFNSRLYJGUOWA1MZON0XEX82MJDU4YXHXJPKURBP2HQBJCTGS10WTQ55OHZVFGLRQ480";
$username = 'yd';
//this gets all categories. Null is important. No nesting.
//$result = SureDone_Store::get_editor_single_object_by_id('categories', null, $token, $username);
//this also gets all categories. w/o nesting
$result = SureDone_Store::editor_objects('categories', null, null, $token, $username);
print_r($result);
var_dump(count($result));

?>