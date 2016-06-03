<?php
class LeadManager {
	protected $finalData = array();
	private $db;
	private $tableName;
	private $logs;
	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'leadmanager';
		$this -> folderName  = "leadManager";
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
		checkRole('leadmanager');
	}


	/**************************** END OF CONSTRUCTOR **************************/
	public function getListingData($search='', $offset='', $recperpage='', $searchData= array(),$filterData= array(), $status = '',$sort='') {
		$offset = $offset * $recperpage;
		$keyValueArray = array();
		if ($status == '-1') {
			$keyValueArray['status'] = -1;
		} else {
			$keyValueArray['notequal'] = $this -> tableName.".status != -1";
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
					$main_sql .= $field." like '%".$searchData['filter']."%'";
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
			$keyValueArray['sqlclause'] = "client_firstname like '$searchData%'";
		}else if ($search == 'integer') {
			$keyValueArray['sqlclause'] = "substring(name,1,1) between '0' AND '9'";
		}

		$keyValueArray['sqlclause'] = $main_sql;
		$limit = $offset . "," . $recperpage;
		if($sort != '') {
			$sort = 'client_firstname '.$sort;
		}else{
			$sort = 'client_firstname ASC';
		}
		/*$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", $sort, $limit, false);*/

		$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
		$joinArray[] = array('type'=>'left','table'=>'leadstage','condition'=>'leadstage.id=leadmanager.lead_stage');
		$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, " leadmanager.*,leadsource.name as leadsource_name,leadstage.name as leadstage_name ", $sort, $limit,$joinArray, false);

		if (count($dataArr) > 0) {
			$finalData['rowcount'] = count($dataArr);
			$i = 0;
			for ($p = 0; $p < $finalData['rowcount']; $p++) {
				$this -> finalData[] = $dataArr[$p];
			}
		}
		$countAll = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " client_firstname ASC ", '', false);
		$result['rows'] = $this -> finalData;
		$result['count'] = count($countAll);
		//echo '<pre>'; print_r($result);
		$this->logs->writelogs($this->folderName,"database returned: ". count($countAll));
		return $result;
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
			$keyValueArray['leadmanager.id'] = intval($id);
			$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
			$joinArray[] = array('type'=>'left','table'=>'leadstage','condition'=>'leadstage.id=leadmanager.lead_stage');

			/*$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, " leadmanager.*,leadsource.name as leadsource_name ", $sort, $limit,$joinArray, true);*/

			$dataArr = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, "leadmanager.*,leadsource.name as leadsource_name,leadstage.name as leadstage_name",'','',$joinArray,false);
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
		 	if($pagecount > 0){
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
					$pagination .= "<li><a href='".SITEPATH."/".$this -> folderName."/display.php?p=".($c+1)."'>" .($c+1)."</a></li>";
				endfor;
				$pagination .= '<li class="'.$class1.'"><a href="'.$next.'">Next</a></li>';
				$pagination .="</ul></div>";
		 }
		 return $pagination;
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

		public function optionsGeneratorByIndex($endIndex) {
	        $options_str = "";

	        $options_str = "<option value=''>Please Select</option>";
					for ($i=1; $i <=$endIndex ; $i++) {
						$options_str.='<option value="' . $i . '"';
						if ($selected_value != "" && $selected_value ==$i)
								$options_str.=' selected ';
						$options_str.='>' . $i . '</option>';
					}

	        return $options_str;
	    }

    function insertIntoOrder($id){
    	if(intval($id)){
    		$keyValueArray = array();
			$keyValueArray['leadmanager.id'] = intval($id);
			$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
			$dataArr = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, "leadmanager.*,leadsource.name as lead_source",'','',$joinArray,true);
			$this->logs->writelogs($this->folderName,"Lead Converted to Order: ".$id);
			foreach ($dataArr as $k=>$value) {
				$values['name'] = $value['client_firstname'];
				$values['lead_source'] = $value['lead_source'];
				$values['mobile_no'] = $value['client_mobile_no'];
				$values['alternate_no'] = $value['alternate_no'];
				$values['email_id'] = $value['client_email_id'];
				$values['address'] = $value['address'];
				$values['landmark'] = $value['landmark'];
				$values['location'] = $value['location'];
				$values['city'] = $value['city'];
				$values['state'] = $value['state'];
				$values['pincode'] = $value['pincode'];
				$values['service'] = $value['service_inquiry1_booked'].' '.$value['service_inquiry2_booked'].' '.$value['service_inquiry3_booked'];
				$values['price'] = $value['price'];
				$values['commission'] = $value['commission'];
				$values['taxed_cost'] = $value['taxed_cost'];
				$values['author_id'] = "";
				$values['author_name'] = "";
				$values['insert_date']		= date('Y-m-d H:i:s');
				$values['update_date']		= date('Y-m-d H:i:s');
				$values['status']= 0;
				$values['ip']= getIP();
			}
			return $this -> db -> insertDataIntoTable($values, 'orders');
    	}

    }

    function getPriceList($city,$inqs,$lead_source){
    	$keyValueArray['city'] = $city;
    	$keyValueArray['lead_source'] = $lead_source;
    	$total = 0;
    	foreach ($inqs as $inq) {
    		if($inq != ''){
    			$keyValueArray['id'] = $inq;
    			$dataArr = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "price", '', '', false);
    			$total =$total+$dataArr[0]['price'];
    		}
    	}
    	return $total;
    }
}
?>
