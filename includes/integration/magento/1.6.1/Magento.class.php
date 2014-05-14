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
        echo '1';
        $this->session = $this->client->login($this->magento_user, $this->magento_apikey);
        echo '2';
    }

    public function sync() {
        // works!
        //$categories = $this->get_categories();
        //var_dump($categories);
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
        // works!
        //$products = $this->get_all_products();
        // var_dump($products);

        // works!
        /*
        $ProductData = array(
            'name'              => 'name of product',
             // websites - Array of website ids to which you want to assign a new product
            'websites'          => array(1), // array(1,2,3,...)
            'short_description' => 'short description',
            'description'       => 'description',
            'status'            => 1,
            'weight'            => 0,
            'tax_class_id'      => 1,
            'categories'    => array(3),    //3 is the category id   
            'price'             => 12.05
        );
        $product = $this->put_product('simple', 38, 'name of prod sku arabella'.time(), $ProductData);
        var_dump($product);
        */
        /**
         * works!
         *
         * $orders = $this->get_all_orders();
         * var_dump($orders);
        */
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
        //$data = array('parentId'=>$parentId, 'categoryData' => $categoryData, 'storeView' => $storeView); //placeholder for now
        try{ 
            $result = $this->client->catalogCategoryCreate($this->session, $parentId, $categoryData, $storeView);
            return result;
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
    }

    /**
     * get_products
     * 
     * Get all products. 
     * More reading: http://www.magentocommerce.com/wiki/doc/webservices-api/api/catalog_product#catalog_product.list
     * 
     * @param void
     * 
     * @return array
     * 
     */
    private function get_all_products(){
        try{ 
            $results = [];
            $products = $this->client->catalogProductList($this->session); //gets all products
            foreach ($products as $p){
                $product = $this->client->catalogProductInfo($this->session, $p->product_id); //gets single product
                $results[] = $product;
            }
            return $results;
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
    }

    /**
     * put_product
     * 
     * put single product (not update!)
     * 
     * More reading: http://www.magentocommerce.com/wiki/doc/webservices-api/api/catalog_product#catalog_product.create
     * 
     * @param string product_type http://www.magentocommerce.com/wiki/modules_reference/english/mage_adminhtml/catalog_product/producttype
     * @param int set - product attribute set ID - whatever it is, causes problems. Products has set's, it has to exists prior to creating product.
     * @param string sku - unique
     * @param array productData
     * 
     * @return int newly created product id
     * 
     */
    private function put_product($productType='simple', $id, $sku, $productData){
        //var_dump($productData);
        try{
            $result = $this->client->catalogProductCreate($this->session, $productType, $id, $sku, $productData); //gets all products
            return $result;
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
    }

    /**
     * 
     * get_all_orders
     * 
     * More reading: http://www.magentocommerce.com/wiki/doc/webservices-api/api/sales_order#sales_order.list
     * 
     * @param array filters - filters for order list (optional)
     * 
     * @return array
     * 
     */
    private function get_all_orders($filters = array()){
        //var_dump($productData);
        try{
            $result = $this->client->salesOrderList($this->session, $filters); //gets all orders
            return $result;
        }catch(SoapFault $fault){ 
            $this->throw_soap_error($fault);
        }
    }
}
?>