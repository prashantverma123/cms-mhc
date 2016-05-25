<?php
class Pricelist {
	protected $finalData = array();
	private $db;
	private $tableName;
	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'pricelist';
		$this -> db = Database::Instance();
		checkRole('pricelist');
	}


	/**************************** END OF CONSTRUCTOR **************************/
	public function getListingData($search='', $offset='', $recperpage='', $searchData= array(), $status = '') {

		$keyValueArray = array();
		if ($status == '-1') {
			$keyValueArray['status'] = -1;
		} else {
			$keyValueArray['notequal'] = "status != -1";
		}
	    $main_sql = '1=1';
		if(count($searchData)>0){
			if(array_key_exists('name',$searchData)) {
					$main_sql .= ' and name like \''.$searchData['event_name'].'%\'';
			}
			//print_r($searchData);
			foreach($searchData as $key=>$val){
				$keyValueArray[$key]=$val;
			}
			if(array_key_exists('parent_id',$searchData)) {
		    	$keyValueArray['parentid'] = $searchData['parent_id'];
			}
		}
		if ($search == 'byname') {
			$keyValueArray['sqlclause'] = "name like '$searchData%'";
		}else if ($search == 'integer') {
			$keyValueArray['sqlclause'] = "substring(name,1,1) between '0' AND '9'";
		}

		$keyValueArray['sqlclause'] = $main_sql;
		$limit = $offset . "," . $recperpage;

		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " name ASC ", $limit, false);

		if (count($dataArr) > 0) {
			$finalData['rowcount'] = count($dataArr);
			$i = 0;
			for ($p = 0; $p < $finalData['rowcount']; $p++) {
				$this -> finalData[] = $dataArr[$p];
			}
		}

		//echo '<pre>'; print_r($this -> finalData);
		return $this -> finalData;
	}// eof getDefault

	public function getParentList(){
		$keyValueArray = array();
		$keyValueArray['parent_id!'] = '-1';
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray,"leadsource", " id,name", " name ASC ", $limit, false);
		return $dataArr;
	}
	public function getLeadSource(){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "leadsource", " id,name,status  ", " name ASC ", $limit, false);
		echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}

	public function getServiceList(){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "product", " id,name,status  ", " name ASC ", $limit, false);
		echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}
	public function getCityList(){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "city", " id,name,city_tier,status  ", " name ASC ", $limit, false);
		echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}

	public function getPagination($search, $searchData, $status) {
		// $status=1 for display listing status=-1 for trashcan
		$keyValueArray = array();
		$keyValueArray['status'] = $status;
		if ($search == 'byname') {
			$keyValueArray['sqlclause'] = "name like '$searchData%'";
		}else if ($search == 'integer') {
			$keyValueArray['sqlclause'] = "substring(name,1,1) between '0' and '9'";
		}
		$main_sql = '1=1';
		if(array_key_exists('event_name',$searchData)) {
		    	$main_sql .= ' and name like \''.$searchData['name'].'%\'';
		}
		if(array_key_exists('parent_id',$searchData)) {
		    	$main_sql .= ' and parentid=\''.$searchData['parent_id'].'\'';
		}
		foreach($searchData as $key=>$val){
			$keyValueArray[$key]=$val;
		}
		$keyValueArray['sqlclause'] = $main_sql;
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, "count(id) as cnt");
		$sql_count = $dataArr[0]['cnt'];
		return $sql_count;
	}// eof getPaginationQuery

	public function getEditData($id) {
		if (intval($id)) {
			$keyValueArray = array();
			$keyValueArray['id'] = intval($id);
			$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, "*");
			if (count($dataArr)) {
				$json = json_encode($dataArr);
			}
		}
		return $json;
	}

	public function insertTable($values) {
		return $this -> db -> insertDataIntoTable($values, $this -> tableName);
	}// eof insertTable

	public function updateTable($values, $whereArr) {
		return $this -> db -> updateDataIntoTable($values, $whereArr, $this -> tableName);
	}// eof updatetable

	public function toggleTableStatus($val, $status) {
		$rowCount = 0;
		if (intval($val) > 0) {
			$rowCount = $this -> db -> updateDataIntoTable(array("status" => $status), array("id" => intval($val)), $this -> tableName);
		}
		return $rowCount;
	}// eof toggleStatus

}
?>
