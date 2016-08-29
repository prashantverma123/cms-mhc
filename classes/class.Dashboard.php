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
		$todaysDate = date('Y-m-d',strtotime("+1 days"));
		$keyValueArray['reminder'] = $todaysDate;

		

		//$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,name,email_id,mobile_no,order_feedback,TIMESTAMPDIFF(HOUR,job_start, job_end) as duration", "", '', false);
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,mhcclient_id,lead_owner", "", '', false);
		return $dataArr;
	}

	public function getyesterdayfollowups(){
		$table = 'leadmanager';
		$keyValueArray['status'] = '0';
		$todaysDate = date('Y-m-d',strtotime("-1 days"));
		$keyValueArray['reminder'] = $todaysDate;
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,mhcclient_id,lead_owner", "", '', false);
		return $dataArr;
	}

	public function getdayfollowups(){
		$table = 'leadmanager';
		/*if($_SESSION['tmobi']['city'] != '')
			$keyValueArray['city'] = $_SESSION['tmobi']['city'];*/
		$keyValueArray['status'] = '0';
		$keyValueArray['reminder'] = date('Y-m-d');

		//$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,name,email_id,mobile_no,order_feedback,TIMESTAMPDIFF(HOUR,job_start, job_end) as duration", "", '', false);
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $table, "id,mhcclient_id,lead_owner", "", '', false);
		return $dataArr;
	}

	public function memcacheData(){
		$memcache = new Memcache;
		@$memcache->connect('localhost', 11211);
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
		if(!$memcache->get('leadstage')){
			$leadstages = $this -> db -> getDataFromTable($keyValueArray, 'leadstage', "distinct name as display, id as value", '', '');
			foreach ($leadstages as $leadstage) {
				$stagearr[$leadstage['value']] =  $leadstage['display'];
			}
			$memcache->set('leadstage',$stagearr);
		}
		if(!$memcache->get('pricelist')){
			//$pricelists = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "name as display, id as value", '', '',true);
			$stmt = "select distinct name as display,id as value from pricelist where status!='-1'
			group by name";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = $result['display'];
        	}	
			$memcache->set('pricelist',$pricelists);
		}
		if(!$memcache->get('pricelist_dropdown')){
			$stmt = "select distinct name as display,id as value from pricelist where status!='-1'";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = $result['display'];
        	}	
			$memcache->set('pricelist_dropdown',$pricelists);
		}
		if(!$memcache->get('manpower')){
			$stmt = "select name as display,id as value,teamleader_deployment,supervisor_deployment,janitor_deployment from pricelist where status!='-1'";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = array('name'=>$result['display'],'teamlead'=>$result['teamleader_deployment'],'janitor'=>$result['janitor_deployment'],'supervisor'=>$result['supervisor_deployment']);
        	}	
			$memcache->set('manpower',$pricelists);
		}
		if(!$memcache->get('designation')){
			$keyValueArray['status'] = '0';
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
		if(!$memcache->get('category')){
			$categories = $this -> db -> getDataFromTable(array(), 'category', "distinct name as display, id as value", '', '');
			foreach ($categories as $category) {
				$categoryarr[$category['value']] =  $category['display'];
			}
			$memcache->set('category',$categoryarr);
		}
		if(!$memcache->get('varianttype')){
			$varianttype = $this -> db -> getDataFromTable(array(), 'variantmaster', "distinct varianttype as display, id as value", '', '');
			foreach ($varianttype as $value) {
				$arr[$value['value']] =  $value['display'];
			}
			$memcache->set('varianttype',$arr);
		}

		if(!$memcache->get('taxes')){
			$whereArr = array();
			$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
			$memcache->set('taxes',$taxes);
		}

		if(!$memcache->get('total_tax')){
			$whereArr = array('status'=>'0');
			$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
			$alltax = 0;
			foreach ($taxes as $tax) {
				 $alltax = $alltax + (float)$tax['value'];
			}
			$memcache->set('total_tax',$alltax);
		}

		if(!$memcache->get('mhcclient')){
			$whereArr = array();
			$mhcclients = $this -> db -> getDataFromTable($whereArr, 'mhcclient', "*", "", '', false);
			foreach ($mhcclients as $mhcclient) {
				$mhcclientarr[$mhcclient['id']] =  array('client_firstname'=>$mhcclient['client_firstname'],'client_lastname'=>$mhcclient['client_lastname'],'client_mobile_no'=>$mhcclient['client_mobile_no'],'address'=>$mhcclient['address'],'city'=>$mhcclient['city'],'client_email_id'=>$mhcclient['client_email_id'],'pincode'=>$mhcclient['pincode'],'landmark'=>$mhcclient['landmark'],'location'=>$mhcclient['location']);
			}
			$memcache->set('mhcclient',$mhcclientarr);
		}

		if(!$memcache->get('vendor')){
			//$memcache->delete('vendor');
			$whereArr = array('is_partner'=>'0');
			$vendor = $this -> db -> getDataFromTable($whereArr, 'leadsource', "id as value,name as display", "", '', false);
			foreach ($vendor as $value) {
				$vendorarr[$value['value']] =  $value['display'];
			}

			
			$memcache->set('vendor',$vendorarr);
		}

		if(!$memcache->get('partneremails')){
			$whereArr = array();
			$varianttype = $this -> db -> getDataFromTable($whereArr, 'partner_emails', "source_id", "", '', false);
			foreach ($varianttype as $value) {
				$whereArr1 = array('source_id'=>$value['source_id']);
				$emails = $this -> db -> getDataFromTable($whereArr1, 'partner_emails', "city,email_id", "", '', false);
				foreach ($emails as $email) {
					$arr[$value['source_id']][$email['city']] = $email['email_id'];
				}
			}
			$memcache->set('partneremails',$arr);
		}

		
	}

	function city(){
		$keyValueArray['status'] = '0';
		$cities = $this -> db -> getDataFromTable($keyValueArray, 'city', "distinct name as display, id as value", '', '');
		foreach ($cities as $city) {
			$cityarr[$city['value']] =  $city['display'];
		}
		return $cityarr;
	}

	function leadstage(){
		$keyValueArray['status'] = '0';
		$leadstages = $this -> db -> getDataFromTable($keyValueArray, 'leadstage', "distinct name as display, id as value", '', '');
		foreach ($leadstages as $leadstage) {
			$stagearr[$leadstage['value']] =  $leadstage['display'];
		}
		return $stagearr;
	}

	function leadsource(){
		$keyValueArray['status'] = '0';
		$leadsources = $this -> db -> getDataFromTable($keyValueArray, 'leadsource', "distinct name as display, id as value", 'name ASC', '');
			foreach ($leadsources as $leadsource) {
				$sourcearr[$leadsource['value']] =  $leadsource['display'];
			}
			return $sourcearr;
	}

	function mhcclient(){
		$whereArr = array();
		$mhcclients = $this -> db -> getDataFromTable($whereArr, 'mhcclient', "*", "", '', false);
			foreach ($mhcclients as $mhcclient) {
				$mhcclientarr[$mhcclient['id']] =  array('client_firstname'=>$mhcclient['client_firstname'],'client_lastname'=>$mhcclient['client_lastname'],'client_mobile_no'=>$mhcclient['client_mobile_no'],'address'=>$mhcclient['address'],'city'=>$mhcclient['city'],'client_email_id'=>$mhcclient['client_email_id'],'pincode'=>$mhcclient['pincode'],'landmark'=>$mhcclient['landmark'],'location'=>$mhcclient['location']);
			}
		return $mhcclientarr;	
	}

	function pricelist(){
		$stmt = "select distinct name as display,id as value from pricelist where status!='-1' group by name";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = $result['display'];
        	}	
        	return $pricelists;
	}

	function varianttype(){
		$varianttype = $this -> db -> getDataFromTable(array(), 'variantmaster', "distinct varianttype as display, id as value", '', '');
		foreach ($varianttype as $value) {
			$arr[$value['value']] =  $value['display'];
		}
		return $arr;
	}

	function pricelistAll(){
			$stmt = "select distinct name as display,id as value from pricelist where status!='-1'";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = $result['display'];
        	}	
        	return $pricelists;
	}
	function category(){
			$categories = $this -> db -> getDataFromTable(array(), 'category', "distinct name as display, id as value", '', '');
			foreach ($categories as $category) {
				$categoryarr[$category['value']] =  $category['display'];
			}
			return $categoryarr;
	}

	function designation(){
		$keyValueArray['status'] = '0';
		$designations = $this -> db -> getDataFromTable($keyValueArray, 'designation', "distinct name as display, id as value", '', '');
		foreach ($designations as $designation) {
			$designationarr[$designation['value']] =  $designation['display'];
		}
		return $designationarr;
	}
	function taxes(){
		$whereArr = array();
		$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
		return $taxes;
	}

	function total_tax(){
		$whereArr = array();
		$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
		$alltax = 0;
		if(count($taxes) > 0):
		foreach ($taxes as $tax) {
			$alltax = $alltax + $tax['value'];
		}
		endif;
		return $alltax;
	}

	function manpower(){
		$stmt = "select name as display,id as value,teamleader_deployment,supervisor_deployment,janitor_deployment from pricelist where status!='-1'";
        	$this -> db ->query($stmt);
        	while ($result = $this-> db ->fetch()) {
            	//$pricelists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
            	$pricelists[$result['value']] = array('name'=>$result['display'],'teamlead'=>$result['teamleader_deployment'],'janitor'=>$result['janitor_deployment'],'supervisor'=>$result['supervisor_deployment']);
        	}	
			return $pricelists;
	}

	function vendor(){
		$whereArr = array('is_partner'=>'0');
		$vendors = $this -> db -> getDataFromTable($whereArr, 'leadsource', "id as value,name as display", "", '', false);
		foreach ($vendors as $value) {
			$arr[$value['value']] =  $value['display'];
		}
		return $arr;
	}

	function role() {

		$roles = $this -> db -> getDataFromTable(array(), 'role', "distinct name as display, role as value", '', '');
			foreach ($roles as $role) {
				$rolearr[$role['value']] =  $role['display'];
			}
		
		return $rolearr;

	}

}
?>