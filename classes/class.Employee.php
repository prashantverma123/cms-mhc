<?php
class Employee {
	protected $finalData = array();
	private $db;
	private $tableName;
	private $logs;
	public $className;

	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'crmemployee';
		$this -> tableName1 = 'attendance';
		$this -> folderName = "employee";
		$this -> className = "employee";

		$this -> db = Database::Instance();
		$this -> logs = new Logging();
		checkRole('employee');
	}


	/**************************** END OF CONSTRUCTOR **************************/
	public function getListingData($search='', $offset='', $recperpage='', $searchData= array(),$filterData= array(), $status = '',$sort='') {
		$offset = $offset*$recperpage;
		$keyValueArray = array();
		if ($status == '-1') {
			$keyValueArray['crmemployee

.status'] = -1;
		} else {
			$keyValueArray['notequal'] = "crmemployee

.status != -1";
		}
	    $main_sql = '1=1';

			if (count($filterData)>0) {
					$main_sql .= ' and ';
				foreach ($filterData as $key => $value) {

					$main_sql .= $key." like '%".$value."%'";
				}

			}
		if(count($searchData)>0){
			/*if(array_key_exists('name',$searchData)) {
					$main_sql .= ' and name like \''.$searchData['event_name'].'%\'';
			}*/
			if($search){
				$main_sql .= ' and ';
				$fields = explode(',',$search);

				$j = 1;
				foreach ($fields as $field) {
					$main_sql .= $field." like '%".$searchData['filter']."%'";
					if($j < count($fields)){
						$main_sql .= " OR ";
					}
					$j++;
				}
			}
			//print_r($searchData);
			/*foreach($searchData as $key=>$val){
				$keyValueArray[$key]=$val;
			}*/
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
		if($sort != '') {
			$sort = 'crmemployee

.name '.$sort;
		}else{
			$sort = 'crmemployee

.name ASC';
		}
		//$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " name ASC ", $limit, true);
		//$joinArray[] = array('type'=>'left','table'=>'attendance','condition'=>'attendance.employee_id=crmemployee.id AND DATE(attendance.date)=CURRENT_DATE');
/*$joinArray[] = array('type'=>'left','table'=>'city','condition'=>'city.id=crmemployee.city');
$joinArray[] = array('type'=>'left','table'=>'designation','condition'=>'designation.id=crmemployee.designation');*/
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, $this -> tableName, " crmemployee.*", $sort, $limit,false);
		if (count($dataArr) > 0) {
			$finalData['rowcount'] = count($dataArr);
			$i = 0;
			for ($p = 0; $p < $finalData['rowcount']; $p++) {
				$this -> finalData[] = $dataArr[$p];
			}
		}
		$countAll = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " name ", " name ASC ", '', false);
		$result['rows'] = $this -> finalData;
		$result['count'] = count($countAll);
		//echo '<pre>'; print_r($this -> finalData);
		//$this->logs->writelogs($this->folderName,"database returned: ". count($countAll));
		return $result;
	}// eof getDefault

	public function getParentList(){
		$keyValueArray = array();
		$keyValueArray['parent_id!'] = '-1';
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " id,category_id,status  ", " category_id ASC ", $limit, false);
		return $dataArr;
	}

	public function optionsGenerator($table, $display_field, $value_field, $selected_value="", $conditions="") {
        $options_str = "";
       $stmt = "select distinct " . $display_field . " as display," . $value_field . " as value from " . $table . " " . $conditions . " order by " . $display_field;
        $this -> db ->query($stmt);
        $options_str = "<option value=''>Please Select</option>";
        while ($result = $this-> db ->fetch()) {
            $options_str.='<option value="' . $result['value'] . '"';
            if ($selected_value != "" && $selected_value == $result['value'])
                $options_str.=' selected ';
            $options_str.='>' . $result['display'] . '</option>';
        }
        return $options_str;
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
		$this->logs->writelogs($this->folderName,"Edited data: ".$json);
		return $json;
	}

	public function insertTable($values) {
		$response =  $this -> db -> insertDataIntoTable($values, $this -> tableName);
		$this->logs->writelogs($this->folderName,"Insertion: ".json_encode($response));
		return $response;

	}// eof insertTable

	public function updateTable($values, $whereArr) {
		$response = $this -> db -> updateDataIntoTable($values, $whereArr, $this -> tableName);
		$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;

	}// eof updatetable

	public function toggleTableStatus($val, $status) {
		$rowCount = 0;
		if (intval($val) > 0) {
			$rowCount = $this -> db -> updateDataIntoTable(array("status" => $status), array("id" => intval($val)), $this -> tableName);
		}
		$this->logs->writelogs($this->folderName,"ToggleTableStatus: ".$rowCount);
		return $rowCount;
	}// eof toggleStatus

	public function get_employee_attendance($emp_id,$attendance,$date){
		$keyValueArray['employee_id'] = $emp_id;
		$keyValueArray['date'] = $date;
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName1, " attendance,date ",'','',false);
		if(count($dataArr) > 0){
			$updateArr['attendance'] = $attendance;
			$updateArr['update_date'] = date('Y-m-d h:i:s');
			$updateArr['author_id']			= $_SESSION['tmobi']['UserId'];
			$updateArr['author_name']		= $_SESSION['tmobi']['AdminName'];
			$whereArr = array('employee_id' => $emp_id,'date'=>$date);
			return $this -> db -> updateDataIntoTable($updateArr, $whereArr, $this -> tableName1);
		}else{
			$insertArr['employee_id'] = $emp_id;
			$insertArr['attendance'] = $attendance;
			$insertArr['date'] = $date;
			$insertArr['insert_date'] = date('Y-m-d h:i:s');
			$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
			$insertArr['author_name']		= $_SESSION['tmobi']['AdminName'];
 			return $this -> db -> insertDataIntoTable($insertArr, $this -> tableName1);
		}

	}

	public function get_attendance_by_id($id){
		$keyValueArray['sqlclause'] = 'WEEKOFYEAR(date)=WEEKOFYEAR(NOW())';
		$keyValueArray['employee_id'] = $id;
		//SELECT * FROM attendance WHERE WEEKOFYEAR(date)=WEEKOFYEAR(NOW()) AND employee_id='1' 
		return $dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName1, " attendance,date ",'date ASC','',false);
	}
	/**
	* pagination
	* @param int,int
	* @return void
	**/
	public function pagination($recperpage,$page,$numOfRows){
		$page =$page+1;
		//$numOfRows = $this-> db ->getCount($this -> tableName);
		$pageCount = $numOfRows/$recperpage;
			$pagecount = floor($pageCount);
		 	if($pagecount > 0 && $numOfRows > $recperpage){
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
					if($page-1 == $c): $selcted= 'current'; else: $selcted= ''; endif;
					$pagination .= "<li><a class='$selcted' href='".SITEPATH."/".$this -> tableName."/display.php?p=".($c+1)."'>" .($c+1)."</a></li>";
				endfor;
				$pagination .= '<li class="'.$class1.'"><a href="'.$next.'">Next</a></li>';
				$pagination .="</ul></div>";
		 }
		 return $pagination;
	}
}
?>
