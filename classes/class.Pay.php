<?php
class Pay {
	protected $finalData = array();
	private $db;
	private $tableName;
	private $logs;
	public $className;
	private $orderId;

	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'leadmanager';
		$this -> folderName  = "payment";
		$this -> className = "Pay";
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
		$this -> orderId = isset($_GET['m'])?$_GET['m']:"";
		//checkValid($this -> orderId);
	}
	function get_order_details($orderId,$leadmanagerId){
		$keyValueArray = array();
		$keyValueArray['leadmanager.id'] = decryptdata($leadmanagerId);
		$keyValueArray['leadmanager.order_id'] = decryptdata($orderId);
		$joinArray[] = array('type'=>'left','table'=>'`order`','condition'=>'`order`.order_id=leadmanager.order_id');
		$joinArray[] = array('type'=>'left','table'=>'`city`','condition'=>'`city`.id=leadmanager.city');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p1','condition'=>'p1.id=leadmanager.service_inquiry1');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p2','condition'=>'p2.id=leadmanager.service_inquiry2');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p3','condition'=>'p3.id=leadmanager.service_inquiry3');
		$result = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, "leadmanager.client_firstname,leadmanager.client_lastname,leadmanager.taxed_cost,leadmanager.order_id,leadmanager.client_email_id,p1.name as service1,p2.name as service2,p3.name as service3,`order`.payment_status,city.name as cityname",'','',$joinArray,false);
		return $result;
	}

	function insertTable($values){
		$tablename = 'transaction';
		$response = $this -> db -> insertDataIntoTable($values, $tablename);
		return $response;
	}

}
?>