<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(dirname(__FILE__).'/../includes/SureDone_Startup.php');
$token = "452B9137D17FDF14482E87BB78FB1781B3A854CCF1399D43EF5983D44414FDA48162106218EF830C6J1ONVAVKW5LVCN9U8FQA023ULATCFNSRLYJGUOWA1MZON0XEX82MJDU4YXHXJPKURBP2HQBJCTGS10WTQ55OHZVFGLRQ480";
$username = 'yd';
//this gets all categories. Null is important. No nesting.
//$result = SureDone_Store::get_editor_single_object_by_id('categories', null, $token, $username);
//this also gets all categories. w/o nesting
/**
 * this gets categories, probably paginated 50 per page as products. nulls important.
 */
try{
    $page = null;
    $result = (array)json_decode(SureDone_Store::editor_objects('categories', $page, null, $token, $username));
    echo '<pre>';
    var_dump($result);
    var_dump(count($result));
}catch(SoapFault $fault){ 
    echo 'Request : <br/><xmp>', 
    $this->client->__getLastRequest(), 
    '</xmp><br/><br/> Error Message : <br/>', 
    $fault->getMessage();
}

?>