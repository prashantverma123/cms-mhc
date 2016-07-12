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

	public function get1dayfollowups(){
		$table = 'leadmanager';
		/*if($_SESSION['tmobi']['city'] != '')
			$keyValueArray['city'] = $_SESSION['tmobi']['city'];*/
		$keyValueArray['status'] = '0';
		$keyValueArray['reminder'] = date('Y-m-d strtotime("+1 day")');

		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,name,email_id,mobile_no,order_feedback,TIMESTAMPDIFF(HOUR,job_start, job_end) as duration", "", '', false);
		return $dataArr;
	}

	public function memcacheData(){
		$memcache = new Memcache;
		$memcache->connect('localhost', 11211) or die ("Could not connect");
		$keyValueArray['status'] = '0';
		if(!$memcache->get('city')){
			$cities = $this -> db -> getDataFromTable($keyValueArray, 'city', "distinct name as display, id as value", '', '');
			foreach ($cities as $city) {
				$cityarr[$city['value']] =  $city['display'];
			}
			//$cityarr = $this->city();
			$memcache->set('city',$cityarr);
		}
		
		if(!$memcache->get('leadsource')){
			$leadsources = $this -> db -> getDataFromTable($keyValueArray, 'leadsource', "distinct name as display, id as value", 'name ASC', '');
			foreach ($leadsources as $leadsource) {
				$sourcearr[$leadsource['value']] =  $leadsource['display'];
			}
			$memcache->set('leadsource',$sourcearr);
		}
		//if(!$memcache->get('leadstage')){
			$leadstages = $this -> db -> getDataFromTable($keyValueArray, 'leadstage', "distinct name as display, id as value", '', '');
			foreach ($leadstages as $leadstage) {
				$stagearr[$leadstage['value']] =  $leadstage['display'];
			}
			$memcache->set('leadstage',$stagearr);
		//}
		//if(!$memcache->get('pricelist')){
			//$pricelists = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "name as display, id as value", '', '',true);
			$stmt = "select distinct name as display,id as value from pricelist where status!='-1' group by name";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = $result['display'];
        	}	
			$memcache->set('pricelist',$pricelists);
		//}
		if(!$memcache->get('designation')){
			$designations = $this -> db -> getDataFromTable($keyValueArray, 'designation', "distinct name as display, id as value", '', '');
			foreach ($designations as $designation) {
				$designationarr[$designation['value']] =  $designation['display'];
			}
			$memcache->set('designation',$designationarr);
		}
		if(!$memcache->get('role')){
			$roles = $this -> db -> getDataFromTable(array(), 'role', "distinct name as display, role as value", '', '');
			foreach ($roles as $role) {
				$rolearr[$role['value']] =  $role['display'];
			}
			$memcache->set('role',$rolearr);
		}
		//if(!$memcache->get('category')){
			$categories = $this -> db -> getDataFromTable(array(), 'category', "distinct name as display, id as value", '', '');
			foreach ($categories as $category) {
				$categoryarr[$category['value']] =  $category['display'];
			}
			$memcache->set('category',$categoryarr);
		//}
		if(!$memcache->get('varianttype')){
			$varianttype = $this -> db -> getDataFromTable(array(), 'variantmaster', "distinct varianttype as display, id as value", '', '');
			foreach ($varianttype as $value) {
				$arr[$value['value']] =  $value['display'];
			}
			$memcache->set('varianttype',$arr);
		}

		if(!$memcache->get('taxes')){
			$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
			$memcache->set('taxes',$taxes);
		}

		//if(!$memcache->get('mhcclient')){
			$mhcclients = $this -> db -> getDataFromTable($whereArr, 'mhcclient', "*", "", '', false);
			foreach ($mhcclients as $mhcclient) {
				$mhcclientarr[$mhcclient['id']] =  array('client_firstname'=>$mhcclient['client_firstname'],'client_lastname'=>$mhcclient['client_lastname'],'client_mobile_no'=>$mhcclient['client_mobile_no'],'address'=>$mhcclient['address']);
			}
			$memcache->set('mhcclient',$mhcclientarr);
		//}
		
	}

	function city(){
		$cities = $this -> db -> getDataFromTable($keyValueArray, 'city', "distinct name as display, id as value", '', '');
		foreach ($cities as $city) {
			$cityarr[$city['value']] =  $city['display'];
		}
		return $cityarr;
	}
}
?>