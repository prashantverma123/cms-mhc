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
	function get_order_details($orderId,$leadmanagerId,$oid){
		$keyValueArray = array();
		//$keyValueArray['leadmanager.id'] = decryptdata($leadmanagerId);
		if($oid != '')
			$keyValueArray['id'] = $oid;
		else
			$keyValueArray['order_id'] = decryptdata($orderId);
		$result = $this -> db -> getDataFromTable($keyValueArray, 'order', "`order`.payment_status",'','');
		return $result;
	}
	function get_service_details($l){
		$keyValueArray['leadmanager_id']= decryptdata($l);
		$result = $this -> db -> getDataFromTable($keyValueArray, 'service', "*",'','');
		return $result;
	}
	function insertTable($values){
		$tablename = 'transaction';
		$response = $this -> db -> insertDataIntoTable($values, $tablename);
		return $response;
	}

}
?>