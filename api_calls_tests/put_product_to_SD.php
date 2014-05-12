<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// post_editor_data might be correct function
/**
 * editor actions:
 * start - add element and put in draft
 * add - add element and publishes it, if product, tries to list on all channels;
 * edit - edit element (and if product is on channel, updates channel)
 * relist - enables product (and tries to relist on all channels)
 * end - disables element (and if product, ends channel listings)
 * delete - delete element from db (and if product, deletes listings)
 */
require_once(dirname(__FILE__).'/../includes/SureDone_Startup.php');
$token = "452B9137D17FDF14482E87BB78FB1781B3A854CCF1399D43EF5983D44414FDA48162106218EF830C6J1ONVAVKW5LVCN9U8FQA023ULATCFNSRLYJGUOWA1MZON0XEX82MJDU4YXHXJPKURBP2HQBJCTGS10WTQ55OHZVFGLRQ480";
$username = 'yd';
//public static function post_editor_data($type = null, $action = null,  $params = null, $authToken = null, $user = null) {
$params = array(
    'identifier' => 'sku',
    'sku' => '456',
    'title' => 'claims to be required',
    'level' => 0,
    'name' => 'name api created test category',
    'label' => 'label api created test category',
    'navdisplay' => true,
    'description' => 'description lorem ipsum',
    'longdescription' => 'longdescription lorem ipsum',
);
$result = SureDone_Store::post_editor_data('items', 'add', $params, $token, $username);
print_r($result);
var_dump(count($result));

?>