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
        $this->client = new SoapClient($magento_host.'api/v2_soap?wsdl=1');
        $this->session = $this->client->login($this->magento_user, $this->magento_apikey);
    }

    public function sync() {
        //$this->get_categories();
        $this->put_category(3, array(
                'name'=>'Newopenerp',
                'is_active'=>1,
                'include_in_menu'=>1,
                'available_sort_by'=>'position',
                //'default_sort_by'=>'position',
            )
        );

    }

    private function get_categories(){
        //http://www.magentocommerce.com/wiki/doc/webservices-api/catalog_category#catalog_category.tree
        $result = $this->client->catalogCategoryTree($this->session);
        var_dump($result); 
    }

    /**
     * put_category
     * 
     * Creates new category in magento from given data
     * More reading: http://www.magentocommerce.com/wiki/doc/webservices-api/catalog_category#catalog_category.create
     * 
     *  @param int parentId default=0, parent category
     *  @param array categoryData  array(’attribute_code’⇒‘attribute_value’ )
     *  @param mixed $storeView - store view ID or code (optional)
     * 
     */ 
    private function put_category($parentId=0, $categoryData=[], $storeView=null){
        $result = $this->client->catalogCategoryCreate($this->session, $parentId, $categoryData, $storeView);
        var_dump($result); 
    } 
}
?>