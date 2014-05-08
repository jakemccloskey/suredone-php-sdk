<?php 
require_once(dirname(__FILE__).'/../../../SureDone_Startup.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Magento {
    protected $client;
    protected $sd_username;
    protected $sd_token;
    protected $magento_host;
    protected $magento_user;
    protected $magento_apikey;
    protected $session;

    public function __construct($sd_username, $sd_token, $magento_host, $magento_user, $magento_apikey) {
        $this->sd_username = $sd_username;
        $this->sd_token = $sd_token;
        $this->magento_host = $magento_host;
        $this->magento_user = $magento_user;
        $this->magento_apikey = $magento_apikey;
        $this->client = new SoapClient($magento_host.'api/soap?wsdl');
        $this->session = $this->client->login($this->magento_user, $this->magento_apikey);
        echo $this;
    }

    public function sync_orders() {
        echo "placeholder function";
    }
}
?>