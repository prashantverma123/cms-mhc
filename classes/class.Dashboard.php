<?php
class Dashboard {
	protected $finalData = array();
	private $db;
	private $tableName;
	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		//$this -> tableName = 'leadsource';
		$this -> db = Database::Instance();
	}

	public function get_statistics($tableName){
		$keyValueArray['status'] = 0;
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $tableName, "count(id) as cnt");
		$sql_count = $dataArr[0]['cnt'];
		return $sql_count;
	}

	public function getOrderComplaint(){
		$table = 'order';
		if($_SESSION['tmobi']['city'] != '')
			$keyValueArray['city'] = $_SESSION['tmobi']['city'];
		$keyValueArray['status'] = '0';
		$keyValueArray['job_status'] = 'complaint';

		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,name,email_id,mobile_no,order_feedback,TIMESTAMPDIFF(HOUR,job_start, job_end) as duration", "", '', false);
		return $dataArr;
	}

	public function memcacheData(){
		$memcache = new Memcache;
		$memcache->connect('localhost', 11211) or die ("Could not connect");
		$keyValueArray['status'] = '0';
		if(!$memcache->get('city')){
			$cities = $this -> db -> getDataFromTable($keyValueArray, 'city', "distinct name as display, id as value", '', '');
			$memcache->set('city',$cities);
		}
		if(!$memcache->get('leadsource')){
			$leadsources = $this -> db -> getDataFromTable($keyValueArray, 'leadsource', "distinct name as display, id as value", '', '');
			$memcache->set('leadsource',$leadsources);
		}
		if(!$memcache->get('leadstage')){
			$leadsources = $this -> db -> getDataFromTable($keyValueArray, 'leadstage', "distinct name as display, id as value", '', '');
			$memcache->set('leadstage',$leadsources);
		}
		if(!$memcache->get('pricelist')){
			$pricelists = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "distinct name as display, id as value", '', '');
			$memcache->set('pricelist',$pricelists);
		}
		if(!$memcache->get('designation')){
			$designation = $this -> db -> getDataFromTable($keyValueArray, 'designation', "distinct name as display, id as value", '', '');
			$memcache->set('designation',$designation);
		}
		if(!$memcache->get('role')){
			$role = $this -> db -> getDataFromTable(array(), 'role', "distinct name as display, role as value", '', '');
			$memcache->set('role',$role);
		}
		if(!$memcache->get('category')){
			$category = $this -> db -> getDataFromTable(array(), 'category', "distinct name as display, id as value", '', '');
			$memcache->set('category',$category);
		}
		if(!$memcache->get('varianttype')){
			$varianttype = $this -> db -> getDataFromTable(array(), 'variantmaster', "distinct varianttype as display, id as value", '', '');
			$memcache->set('varianttype',$varianttype);
		}
	}
}
?>