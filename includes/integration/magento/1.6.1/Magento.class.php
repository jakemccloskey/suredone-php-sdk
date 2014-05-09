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
    protected $debug = True;

    public function __construct($sd_username, $sd_token, $magento_host, $magento_user, $magento_apikey) {
        $this->sd_username = $sd_username;
        $this->sd_token = $sd_token;
        $this->magento_host = $magento_host;
        $this->magento_user = $magento_user;
        $this->magento_apikey = $magento_apikey;
        $options = [];
        if ($this->debug){
            $options = array('trace' => 1);
        }
        $this->client = new SoapClient($magento_host.'api/v2_soap?wsdl=1', $options);
        $this->session = $this->client->login($this->magento_user, $this->magento_apikey);
    }

    public function sync() {
        $categories = $this->get_categories();
        var_dump($categories);
        /*
        // works!
        $this->put_category(3, array(
            'name'=>'Newopenerp',
            'is_active'=>1,
            'include_in_menu'=>1,
            'available_sort_by'=>array('price'),
            'default_sort_by'=>'price',
            'is_active'=>1,
            )
        );*/
    }

    /**
     * throw_soap_error
     *
     * Helper for handling soap errors 
     * 
     * @param SoapFault $fault
     * 
     * @return void
     */
    private function throw_soap_error($fault){
        echo 'Request : <br/><xmp>', 
        $this->client->__getLastRequest(), 
        '</xmp><br/><br/> Error Message : <br/>', 
        $fault->getMessage();
    }
    /**
     * get_categories
     * 
     * Get's category tree
     * More reading: http://www.magentocommerce.com/wiki/doc/webservices-api/catalog_category#catalog_category.tree
     * 
     * @return array
     * 
     */
    private function get_categories(){
        try{ 
            $result = $this->client->catalogCategoryTree($this->session);
            return $result;
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
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
     * @return int new category id.
     * 
     */ 
    private function put_category($parentId=0, $categoryData=[], $storeView=null){
        /**
         *  example call:   
         *  $this->put_category(3, array(
         *      'name'=>'Newopenerp',
         *      'is_active'=>1,
         *      'include_in_menu'=>1,
         *      'available_sort_by'=>array('price'),
         *      'default_sort_by'=>'price',
         *      'is_active'=>1,
         *       )
         *   );
         */
        $data = array('parentId'=>$parentId, 'categoryData' => $categoryData, 'storeView' => $storeView); //placeholder for now
        try{ 
            $result = $this->client->catalogCategoryCreate($this->session, $parentId, $categoryData, $storeView);
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
    } 
}
?>