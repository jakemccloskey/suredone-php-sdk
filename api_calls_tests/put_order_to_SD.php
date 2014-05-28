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
/** code below nicely adds product to SD. The same should work for category but somehow does not */
$params = array(
    'identifier' 	=> 'order',
    'order' 		=> 'M00002',
    'total' 		=> '100.00',
    'email' 		=> 'michal@arabel.la',
    'bcountry' 		=> 'US',
    'blastname' 	=> 'Michal M.',
    'items' =>	[
        [
        'title'=>'iphone 4','price'=>99.99,'quantity'=>1,
        'image'=>'http://assets.suredone.com/1019/media-pics/md382lla-apple-iphone-4s-with-64gb-memory-mobile-phone-white.jpg',
        'url'=>'http://demo.suredone.com/iphone-4-md382lla','weight'=>1,'boxlength'=>1,'boxheight'=>0.5,'boxlength'=>3
        ]
    ]
);
try{
    $result = SureDone_Store::post_editor_data('orders', 'add', $params, $token, $username);
    echo '<pre>';
    var_dump(json_decode($result));
}catch(SoapFault $fault){
    echo 'Request : <br/><xmp>',
    $this->client->__getLastRequest(),
    '</xmp><br/><br/> Error Message : <br/>',
    $fault->getMessage();
}


?>
