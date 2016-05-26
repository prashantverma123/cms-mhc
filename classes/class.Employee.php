<?php
class Employee {
	protected $finalData = array();
	private $db;
	private $tableName;
	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'employee';
		$this -> tableName1 = 'attendance';
		$this -> db = Database::Instance();
		checkRole('employee');
	}


	/**************************** END OF CONSTRUCTOR **************************/
	public function getListingData($search='', $offset='', $recperpage='', $searchData= array(), $status = '') {
		$offset = $offset*$recperpage;
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

		//$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " name ASC ", $limit, true);
		$joinArray[] = array('type'=>'left','table'=>'attendance','condition'=>'attendance.employee_id=employee.id AND DATE(attendance.date)=CURRENT_DATE');
		$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, " employee.*,attendance.attendance ", " name ASC ", $limit,$joinArray, false);
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
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " id,category_id,status  ", " category_id ASC ", $limit, false);
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

	public function get_employee_attendance($emp_id,$attendance){
		$keyValueArray['employee_id'] = $emp_id;
		$keyValueArray['DATE(date)'] = date('Y-m-d');
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName1, " attendance,date ",'','',false);
		//print_r($dataArr);exit;
		if(count($dataArr) > 0){
			$updateArr['attendance'] = $attendance;
			$whereArr = array('employee_id' => $emp_id);
			return $this -> db -> updateDataIntoTable($updateArr, $whereArr, $this -> tableName1);
		}else{
			$insertArr['employee_id'] = $emp_id;
			$insertArr['attendance'] = $attendance;
			$insertArr['date'] = date('Y-m-d h:i:s');
 			return $this -> db -> insertDataIntoTable($insertArr, $this -> tableName1);	
		}
		
	}
	/**
	* pagination
	* @param int,int
	* @return void
	**/
	public function pagination($recperpage,$page){
		$page =$page+1;
		$numOfRows = $this-> db ->getCount($this -> tableName);
		$pageCount = $numOfRows/$recperpage;
			$pagecount = floor($pageCount);
		 	if($pagecount > 0){
		 		if($page==1){
		 			$prev = "";
		 			$class= "disabled";
		 		}else{
		 			$prev= SITEPATH."/".$this -> tableName."/display.php?p=".($page-1);
		 			$class= "";
		 		}
		 		if($page==($pagecount+1)){
		 			$next = "";
		 			$class1= "disabled";
		 		}else{
		 			$next= SITEPATH."/".$this -> tableName."/display.php?p=".($page+1);
		 			$class1= "";
		 		}

		 		$pagination = "<div class='pagination'><ul><li class='".$class."'><a href='".$prev."'>Prev</a></li>";
				for($c= 0; $c<=$pagecount;$c++):
					$pagination .= "<li><a href='".SITEPATH."/".$this -> tableName."/display.php?p=".($c+1)."'>" .($c+1)."</a></li>";
				endfor; 
				$pagination .= '<li class="'.$class1.'"><a href="'.$next.'">Next</a></li>';
				$pagination .="</ul></div>";
		 } 
		 return $pagination;
	}
}
?>
