<?php
/**
* Synchronize data with Magento.
*
* Usage: php MagentoSync.php --sd-username=demo --sd-token=xyz --magento-host==http://..
* magento-host - Magento url 
* sd-username - SureDone username
* sd-token - SureDone token
**/

require_once(dirname(__FILE__).'/Magento.class.php');

if (strpos($_SERVER["SCRIPT_FILENAME"], 'Magento.php') !== false) {
    $required = array(
        'sd-username',
        'sd-token',
        'magento-host',
    );
    $longopts  = array();
    foreach($required as $field) {
        $longopts[] = $field . ':';
    }
    $options = getopt('', $longopts);
    $kill = false;
    foreach ($required as $field) {
        if (empty($options[$field])) {
            echo 'Option ' . $field . " is required! \n\r";
            $kill = true;
        }
    }
    if ($kill){
        die();
    }

    $suite = new Magento($options['sd-username'],$options['sd-token'], $options['magento-host']);
    $suite->sync();
}
?>