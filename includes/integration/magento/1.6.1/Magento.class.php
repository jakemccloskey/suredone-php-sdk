<?php 
require_once(dirname(__FILE__).'/../SureDone_Startup.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Magento {
    protected $client;
    protected $sd_username;
    protected $sd_token;

    public function __construct($sd_username, $sd_token, $magento-host) {
        $this->client = new SoapClient($magento-host.'api/soap?wsdl');
    }

    public function sync_orders() {
        echo "placeholder function";
    }
}
?>