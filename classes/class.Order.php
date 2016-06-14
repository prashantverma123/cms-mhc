<?php
class Order {
	protected $finalData = array();
	private $db;
	private $tableName;
	private $logs;
	public $className;

	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'order';
		$this -> folderName = "order";
		$this -> className = "order";
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
		checkRole('order');
	}


	/**************************** END OF CONSTRUCTOR **************************/
	public function getListingData($search='', $offset='', $recperpage='', $searchData= array(),$filterData= array(), $status = '',$sort='') {
		$offset = $offset * $recperpage;
		$keyValueArray = array();
		if ($status == '-1') {
			$keyValueArray['`'.$this -> tableName.'`.status'] = -1;
		} else {
			$keyValueArray['notequal'] = '`'.$this -> tableName."`.status != -1";
		}
	    $main_sql = '1=1';

			if (count($filterData)>0) {
					$main_sql .= ' and ';
				foreach ($filterData as $key => $value) {

					$main_sql .= '`order`.'.$key." like '%".$value."%'";
				}

			}
		if(count($searchData)>0){
			/*if(array_key_exists('name',$searchData)) {
					$main_sql .= ' and name like \''.$searchData['event_name'].'%\'';
			}
			//print_r($searchData);
			foreach($searchData as $key=>$val){
				$keyValueArray[$key]=$val;
			}*/
			if($search){
				$main_sql .= ' and ';
				$fields = explode(',',$search);

				$j = 1;
				foreach ($fields as $field) {
					$main_sql .= '`order`.'.$field." like '%".$searchData['filter']."%'";
					if($j < count($fields)){
						$main_sql .= " OR ";
					}
					$j++;
				}
			}
			if(array_key_exists('parent_id',$searchData)) {
		    	$keyValueArray['parentid'] = $searchData['parent_id'];
			}
		}
		if ($search == 'byname') {
			$keyValueArray['sqlclause'] = "`order`.name like '$searchData%'";
		}else if ($search == 'integer') {
			$keyValueArray['sqlclause'] = "substring(name,1,1) between '0' AND '9'";
		}

		$keyValueArray['sqlclause'] = $main_sql;
		$limit = $offset . "," . $recperpage;
		if($sort != '') {
			$sort = '`'.$this -> tableName.'`.insert_date '.$sort;
		}else{
			$sort =  '`'.$this -> tableName.'`.insert_date DESC';
		}
		$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=order.lead_source');
		//$joinArray[] = array('type'=>'left','table'=>'pricelist','condition'=>"pricelist.id = SUBSTRING_INDEX(SUBSTRING_INDEX(`order`.service, ',', FIND_IN_SET(pricelist.id,`order`.service)), ',', -1)");
		//$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, "`order`.*,leadsource.name as leadsource_name,GROUP_CONCAT(pricelist.name ORDER BY pricelist.id SEPARATOR '|') as 'services'", $sort, $limit,$joinArray, true);
		$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, "`order`.*,leadsource.name as leadsource_name", $sort, $limit,$joinArray, false);

		if (count($dataArr) > 0) {
			$finalData['rowcount'] = count($dataArr);
			$i = 0;
			for ($p = 0; $p < $finalData['rowcount']; $p++) {
				$this -> finalData[] = $dataArr[$p];
			}
		}
		$countAll = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " name ASC ", '', false);
		$result['rows'] = $this -> finalData;
		$result['count'] = count($countAll);
		//echo '<pre>'; print_r($this -> finalData);
		$this->logs->writelogs($this->folderName,"database returned: ". count($countAll));
		return $result;
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
		// echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}

	public function getServiceList(){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "product", " id,category_id,status  ", " category_id ASC ", $limit, false);
	//	echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}
	public function getCityList(){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "city", " id,name,city_tier,status  ", " name ASC ", $limit, false);
		// echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}

	public function getDynamicCityList($id){
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		$keyValueArray['lead_source'] = $id;
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "pricelist", " id,name,city,status,price  ", " name ASC ", $limit, false);
		// echo "<script type='text/javascript'>console.log($keyValueArray);alert('$keyValueArray');</script>";
		return $dataArr;
	}


	public function getPrice(){
	//echo "<script type='text/javascript'>console.log($id);alert('$id');</script>";
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		$keyValueArray['lead_source'] = '1';
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "pricelist", " id,name,price,commission,status  ", " name ASC ", $limit, false);
		//echo "<script type='text/javascript'>console.log($dataArr);alert('$dataArr');</script>";
		return $dataArr;
	}

	public function getFilterData($field,$value){
	//echo "<script type='text/javascript'>console.log($id);alert('$id');</script>";
		$keyValueArray = array();
		$keyValueArray['id!'] = '-1';
		$keyValueArray[$field] = $value;
		// echo scrjson_encode($keyValueArray);
		//SELECT DATEDIFF(end_date,start_date) AS days FROM events_events WHERE  id='$event_id'
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, "orders", " * ", " name ASC ", $limit, false);
		//echo "<script type='text/javascript'>console.log($dataArr);alert('$dataArr');</script>";
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
		 	if($pagecount > 0 && $page!=$pagecount){
		 		if($page==1){
		 			$prev = "";
		 			$class= "disabled";
		 		}else{
		 			$prev= SITEPATH."/".$this -> folderName."/display.php?p=".($page-1);
		 			$class= "";
		 		}
		 		if($page==($pagecount+1)){
		 			$next = "";
		 			$class1= "disabled";
		 		}else{
		 			$next= SITEPATH."/".$this -> folderName."/display.php?p=".($page+1);
		 			$class1= "";
		 		}

		 		$pagination = "<div class='pagination'><ul><li class='".$class."'><a href='".$prev."'>Prev</a></li>";
				for($c= 0; $c<=$pagecount;$c++):
					if($page-1 == $c): $selcted= 'current'; else: $selcted= ''; endif;
					$pagination .= "<li><a class='$selcted' href='".SITEPATH."/".$this -> folderName."/display.php?p=".($c+1)."'>" .($c+1)."</a></li>";
				endfor;
				$pagination .= '<li class="'.$class1.'"><a href="'.$next.'">Next</a></li>';
				$pagination .="</ul></div>";
		 }
		 return $pagination;
	}

	public function optionsGenerator($table, $display_field, $value_field, $selected_value="", $conditions="") {
        $options_str = "";
       $stmt = "select " . $display_field . " as display," . $value_field . " as value from " . $table . " " . $conditions . " group by ".$display_field." order by " . $display_field;
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

    public function multipleOptionsGenerator($table, $display_field, $value_field, $selected_value="", $conditions="") {
	
	$options_str = "";
       $stmt = "select " . $display_field . " as display," . $value_field . " as value from " . $table . " " . $conditions . " group by ".$display_field." order by " . $display_field;
        $this -> db ->query($stmt);
        $options_str = "<option value=''>Please Select</option>";
        while ($result = $this-> db ->fetch()) {
            $options_str.='<option value="' . $result['value'] . '"';
            if(is_array($selected_value) && $selected_value != ""){
            	if (in_array($result['value'], $selected_value)){
                	$options_str.=' selected ';
                }
            }
            elseif ($selected_value == $result['value']){
            	$options_str.=' selected ';
            }
            $options_str.='>' . $result['display'] . '</option>';
        }
        return $options_str;
    }
}
?>
