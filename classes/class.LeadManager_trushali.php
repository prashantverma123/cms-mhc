<?php
class LeadManager {
	protected $finalData = array();
	private $db;
	private $tableName;
	private $logs;
	public $className;

	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		$this -> tableName = 'leadmanager';
		$this -> folderName  = "leadmanager";
		$this -> className = "leadmanager";
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
		$this -> dashObj = new Dashboard();
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
				if($_SESSION['tmobi']['role'] !="admin")
					$main_sql .= ' and ';
					$k =1;
				foreach ($filterData as $key => $value) {
					if($_SESSION['tmobi']['role'] =="admin")
					{
						if($key == 'city'){ //to skip the city 
							$k++;
							continue;	
						}
					}
					if($value != ''){
					if($key == 'service_date'){
						$keyValueArray['DATE(service1_date)'] = $value;
						//$keyValueArray['DATE(service2_date)'] = $value;
						//$keyValueArray['DATE(service3_date)'] = $value;
					}else{
						$main_sql .= 'leadmanager.'.$key." like '%".$value."%' ";
					}
					}
					if($k < count($filterData)){
						$main_sql .= " OR ";
					}
					$k++;
					
				}

			}

		if(count($searchData)>0){
			if($search){
				//if($searchData['filter']!='')
				//$main_sql .= ' and ';

				$fields = explode(',',$search);

				$j = 1;
				/*foreach ($fields as $field) {
					if($searchData['filter']!=''){
						if($field == 'client_firstname'){
							$name = explode(' ',$searchData['filter']);
							//print_r($name);
							if($name[0]){
							$main_sql .= 'client_firstname'." like '%".$name[0]."%' ";
							}
							if(count($name) > 2){
							$main_sql .= 'client_lastname'." like '%".$name[1]."%' ";
							}
						}else
						$main_sql .= $field." like '%".$searchData['filter']."%'";
						
						if($j < count($fields)){
							$main_sql .= " OR ";
						}
						$j++;
					}
				}*/
				foreach ($fields as $field) {
					if($searchData['filter']!=''){
						if($field == 'client_firstname'){
							$name = explode(' ',$searchData['filter']);
							$mhcclient_sql = "";
							if($name[0]){
								$mhcclient_sql = 'client_firstname'." like '%".$name[0]."%' ";
							}
							if(count($name) > 2){
								$mhcclient_sql .= 'client_lastname'." like '%".$name[1]."%' ";
							}
							$mhcclientArr['sqlclause'] = $mhcclient_sql;
							$clientsArr = $this -> db -> getDataFromTable($mhcclientArr,'mhcclient', " id ", '', '', false);
							//$m = 1;
							if(count($clientsArr) > 0){
								foreach ($clientsArr as $client) {
									$keyValueArray['mhcclient_id'] = $client['id'];
								}
							}
						}else if($field == 'client_mobile_no'){
							$mhcclient_sql = 'client_mobile_no'." like '%".$searchData['filter']."%' ";
							$mhcclientArr['sqlclause'] = $mhcclient_sql;
							$clientsArr = $this -> db -> getDataFromTable($mhcclientArr,'mhcclient', " id ", '', '', false);
							if(count($clientsArr) > 0){
								foreach ($clientsArr as $client) {
									$keyValueArray['mhcclient_id'] = $client['id'];
								}
							}
						}
						//else
							//$main_sql .= $field." like '%".$searchData['filter']."%'";
						
						if($j < count($fields)){
							$mhcclient_sql .= " OR ";
						}
						$j++;
					}
				}
			}
			if(array_key_exists('parent_id',$searchData)) {
		    	$keyValueArray['parentid'] = $searchData['parent_id'];
			}
		}

	/*	if ($search == 'byname') {
			$keyValueArray['sqlclause'] = "client_firstname like '$searchData%'";
		}else if ($search == 'integer') {
			$keyValueArray['sqlclause'] = "substring(name,1,1) between '0' AND '9'";
		}*/

		$keyValueArray['sqlclause'] = $main_sql;
		$limit = $offset . "," . $recperpage;
		if($sort != '') {
			$sort = 'leadmanager.insert_date '.$sort;
		}else{
			$sort = 'leadmanager.insert_date DESC';
		}
		//$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", $sort, $limit, false);
		//$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
		//$joinArray[] = array('type'=>'left','table'=>'leadstage','condition'=>'leadstage.id=leadmanager.lead_stage');
		//$joinArray[] = array('type'=>'left','table'=>'pricelist as p1','condition'=>'p1.id=leadmanager.service_inquiry1');
		//$joinArray[] = array('type'=>'left','table'=>'pricelist as p2','condition'=>'p2.id=leadmanager.service_inquiry2');
		//$joinArray[] = array('type'=>'left','table'=>'service','condition'=>'service.leadmanager_id=leadmanager.id');
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, $this -> tableName, " leadmanager.*", $sort, $limit);

		if (count($dataArr) > 0) {
			$finalData['rowcount'] = count($dataArr);
			$i = 0;
			for ($p = 0; $p < $finalData['rowcount']; $p++) {
				$this -> finalData[] = $dataArr[$p];
			}
		}
		//$countAll = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", " client_firstname ASC ", '', false);
		$countAll = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, " * ", "", '');
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
		$dataArr = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, " * ", " client_firstname ASC ", '',$joinArray, false);
		$sql_count = $dataArr[0]['cnt'];
		return $sql_count;
	}// eof getPaginationQuery

	public function getEditData($id) {
		if (intval($id)) {
			$keyValueArray = array();
			$keyValueArray['leadmanager.id'] = intval($id);
			/*$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
			$joinArray[] = array('type'=>'left','table'=>'leadstage','condition'=>'leadstage.id=leadmanager.lead_stage');
*/
			$dataArr = $this -> db ->getDataFromTable($keyValueArray, $this -> tableName, " leadmanager.*", $sort, $limit,false);

			//$dataArr = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, "leadmanager.*,leadsource.name as leadsource_name,leadstage.name as leadstage_name",'','',$joinArray,false);
			if (count($dataArr)) {
				$json = json_encode($dataArr);
			}
		}
		//$this->logs->writelogs($this->folderName,"Edited data: ".$json);
		return $json;
	}

	public function insertTable($values) {
		$response =  $this -> db -> insertDataIntoTable($values, $this -> tableName,false);
		$this->logs->writelogs($this->folderName,"Insertion: ".json_encode($response));
		return $response;

	}// eof insertTable

	public function updateTable($values, $whereArr) {
		$response = $this -> db -> updateDataIntoTable($values, $whereArr, $this -> tableName);
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
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
		 	if($pagecount > 0 && $numOfRows > $recperpage){
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
            $options_str.="<option value='" . $result['value'] . "'";
            if ($selected_value != '' && $selected_value == $result['value'])
                $options_str.=' selected ';
            $options_str.='>' . $result['display'] . '</option>';
        }
        return $options_str;
    }

	public function optionsGeneratorByIndex($endIndex) {
	        $options_str = "";

	        $options_str = "<option value=''>Please Select</option>";
					for ($i=1; $i <=$endIndex ; $i++) {
						$options_str.="<option value='" . $i . "'";
						if ($selected_value != '' && $selected_value ==$i)
								$options_str.=' selected ';
						$options_str.='>' . $i . '</option>';
					}

	        return $options_str;
	    }
	    function generateInvoiceId($firstname,$lastname,$serviceArr,$city,$id){
				//echo "Hi generating invoice"; exit();
			$service = "";
				for ($i=0; $i < count($serviceArr); $i++) {
					$words = explode(" ", $serviceArr[$i]);
					$acronym = "";
					for($j = 0; $j<count($words); $j++){
									$t = array();
									$t = $words[$j];
									if(!empty($t))
									$acronym .= $t{0};
					}
					$service .= strtoupper($acronym);

					
						if (strtoupper($acronym)!='') {
						$service .=',';
						}
					
					


				}

				$formattedservice = rtrim($service, ",");

				$invoiceId = strtoupper($firstname[0]) .strtoupper($lastname[0]) . '/'.$formattedservice.'/2016-17'. '/'.strtoupper($city[0]). '/'.$id ;
				//echo $invoiceId;
				return $invoiceId;
			}

	function getcategoryforServiceId($serviceId){
		$keyValueArray['id'] = $serviceId;

		$category = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "category_type", '', '', false);

		return $category;
	}	

	function getServiceDetailsforLead($leadId){

		$keyValueArray['leadmanager_id'] = $leadId;

		$servicedetails = $this -> db -> getDataFromTable($keyValueArray, 'service', "service_inquiry,varianttype_id", '', '', false);

		return $servicedetails;
	}	

    function insertIntoOrder($id){
    	$memcache = new Memcache;
		$memcache->connect('localhost', 11211) or die ("Could not connect");
    	if(intval($id)){
    		$keyValueArray = array();
    		$response = '';
			$keyValueArray['leadmanager.id'] = intval($id);
			//$joinArray[] = array('type'=>'left','table'=>'leadsource','condition'=>'leadsource.id=leadmanager.lead_source');
			//$joinArray[] = array('type'=>'left','table'=>'city','condition'=>'city.id=leadmanager.city');
			//$joinArray[] = array('type'=>'left','table'=>'pricelist as p1','condition'=>'p1.id=leadmanager.service_inquiry1');
			//$joinArray[] = array('type'=>'left','table'=>'pricelist as p2','condition'=>'p2.id=leadmanager.service_inquiry2');
			//$joinArray[] = array('type'=>'left','table'=>'pricelist as p3','condition'=>'p3.id=leadmanager.service_inquiry3');
			//$joinArray[] = array('type'=>'left','table'=>'mhcclient as client','condition'=>'client.id=leadmanager.mhcclient_id');
			$dataArr = $this -> db -> getDataFromTable($keyValueArray, $this -> tableName, "leadmanager.*",'','',false);
				if($memcache){
				$pricelist = $memcache->get('pricelist_dropdown');
				$mhcclient = $memcache->get('mhcclient');
				$leadsource = $memcache->get('leadsource');
			}else{
				$pricelist = $dashboard->pricelistAll();
				$mhcclient = $dashboard->mhcclient();
				$leadsource =$dashboard->leadsource();
			}

			foreach ($dataArr as $k=>$value) {
				$client = $mhcclient[$value['mhcclient_id']];
				$serviceArr[] = $value['service_inquiry1'];
				$serviceArr[] = $value['service_inquiry2'];
				$serviceArr[] = $value['service_inquiry3'];
				$katgory1 = $this->getcategoryforServiceId($value['service_inquiry1']);
				$katgory2 = $this->getcategoryforServiceId($value['service_inquiry2']);
				$katgory3 = $this->getcategoryforServiceId($value['service_inquiry3']);
				
				$values['leadmanager_id'] = $value['id'];
				$values['name'] = $client['client_firstname'];
				$values['lead_source'] = $value['lead_source'];
				$values['mobile_no'] = $client['client_mobile_no'];
				$values['alternate_no'] = $client['alternate_no'];
				$values['email_id'] = $client['client_email_id'];
				$values['address'] = $client['address'];
				$values['landmark'] = $client['landmark'];
				$values['location'] = $client['location'];
				$values['city'] = $client['city'];
				$values['state'] = $client['state'];
				$values['pincode'] = $client['pincode'];
				$values['price'] = $value['price'];
				$values['commission'] = $value['commission'];
				$values['billing_name'] = $client['client_firstname'].' '.$client['client_lastname'];
				$values['billing_email'] = $client['client_email_id'];
				$values['billing_address'] = $client['address'];
				$values['billing_name2'] = $leadsource[$value['lead_source']];
				$values['taxed_cost'] = $value['taxed_cost'];
				$values['billing_amount2'] = $value['partner_amount'];
				$values['order_id'] = $value['order_id'];
				$values['author_id'] = $_SESSION['tmobi']['UserId'];
				$values['author_name'] = "";
				$values['insert_date']		= date('Y-m-d H:i:s');
				$values['update_date']		= date('Y-m-d H:i:s');
				$values['status']= 0;
				$values['ip']= getIP();
				
				if ($katgory1==$katgory2 && $katgory2==$katgory3 && $katgory3==$katgory1) {
					$serviceArr = array();
					$serviceArr[] = $value['service_inquiry1'];
					$serviceArr[] = $value['service_inquiry2'];
					$serviceArr[] = $value['service_inquiry3'];
					$values['service'] = implode(',',$serviceArr);				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']],$pricelist[$value['service_inquiry2']],$pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');
				}

				if ($katgory1!=$katgory2 && $katgory2!=$katgory3 && $katgory3!=$katgory1) {
					$serviceArr = array();
					$values['service'] = $value['service_inquiry1'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

					$values['service'] = $value['service_inquiry2'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry2']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

					$values['service'] = $value['service_inquiry3'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');
				}

				if ($katgory1==$katgory2&&$katgory2!=$katgory3) {
					$serviceArr = array();
					$serviceArr[] = $value['service_inquiry1'];
					$serviceArr[] = $value['service_inquiry2'];
					$values['service'] = implode(',',$serviceArr);				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']],$pricelist[$value['service_inquiry1']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

					$values['service'] = $value['service_inquiry3'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

				}

				if ($katgory1==$katgory3 && $katgory2!=$katgory3) {
					$serviceArr = array();
					$serviceArr[] = $value['service_inquiry1'];
					$serviceArr[] = $value['service_inquiry3'];
					$values['service'] = implode(',',$serviceArr);				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']],$pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

					$values['service'] = $value['service_inquiry2'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry2']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');
				}

				if ($katgory1!=$katgory2 && $katgory2==$katgory3) {
					$serviceArr = array();
					$serviceArr[] = $value['service_inquiry2'];
					$serviceArr[] = $value['service_inquiry3'];
					$values['service'] = implode(',',$serviceArr);				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry2']],$pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');

					$values['service'] = $value['service_inquiry1'];				
					$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']]),$value['city_name'],$id);
					$response =  $this -> db -> insertDataIntoTable($values, 'order');
				}

				// if ($katgory1!=$katgory3 && $katgory2==$katgory3) {
				// 	$serviceArr = array();
				// 	$serviceArr[] = $value['service_inquiry2'];
				// 	$serviceArr[] = $value['service_inquiry3'];
				// 	$values['service'] = implode(',',$serviceArr);				
				// 	$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry2']],$pricelist[$value['service_inquiry3']]),$value['city_name'],$id);
				// 	$response =  $this -> db -> insertDataIntoTable($values, 'order');

				// 	$values['service'] = $value['service_inquiry1'];				
				// 	$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($pricelist[$value['service_inquiry1']]),$value['city_name'],$id);
				// 	$response =  $this -> db -> insertDataIntoTable($values, 'order');
				// }
				// if ($value['invoice_type']==-1) {
				
				
				
				
 				
				
				
				// }

				// else {
				// 	$indx = 0;
					// foreach ($serviceArr as $key => $service) {


					// 	if($service != ''){
					// 	$katgory = $this->getcategoryforServiceId($service)
					// 	switch ($katgory) {
					// 	case 'value':
					// 		# code...
					// 		break;
						
					// 	default:
					// 		# code...
					// 		break;
					// 	}
					// 	$indx = $indx +1;
					// 	$variant = array($value['varianttype'.$indx]);
					// 	$servicename = 'service'.$indx;
					// 	$values = array();
					// 	$values['leadmanager_id'] = $value['id'];
					// 	$values['name'] = $value['client_firstname'];
					// 	$values['lead_source'] = $value['lead_source'];
					// 	$values['mobile_no'] = $value['client_mobile_no'];
					// 	$values['alternate_no'] = $value['alternate_no'];
					// 	$values['email_id'] = $value['client_email_id'];
					// 	$values['address'] = $value['address'];
					// 	$values['landmark'] = $value['landmark'];
					// 	$values['location'] = $value['location'];
					// 	$values['city'] = $value['city'];
					// 	$values['state'] = $value['state'];
					// 	$values['pincode'] = $value['pincode'];
					// 	$values['service'] = $service;
					// 	$values['service_date'] = $value['service'.$indx.'_date'];
					// 	$values['service_time'] = $value['service'.$indx.'_time'];
					// 	$values['price'] = $this->getPriceList($value['city'],array($value[$servicename]),$variant)-(0.15*$this->getPriceList($value['city'],array($value[$servicename]),$variant));
					// 	$values['commission'] = $value['commission'];
					// 	$values['taxed_cost'] = $this->getPriceList($value['city'],array($value[$servicename]),$variant);
					// 	$values['order_id'] = $value['order_id'];
					// 	$values['invoice_id'] = $this->generateInvoiceId($value['client_firstname'],$value['client_lastname'],array($value[$servicename]),$value['city_name'],$id);
		 		// 		$values['author_id'] = $_SESSION['tmobi']['UserId'];
					// 	$values['author_name'] = "";
					// 	$values['insert_date']		= date('Y-m-d H:i:s');
					// 	$values['update_date']		= date('Y-m-d H:i:s');
					// 	$values['status']= 0;
					// 	$values['ip']= getIP();

					// 	$response =  $this -> db -> insertDataIntoTable($values, 'order',true);
					// 	}
					// }
				// 	//print_r($values);
				// 		// exit();
				// }
				
			}

			//$this->logs->writelogs($this->folderName,"Lead Converted to Order: ".$id);
			return $response;
    	}

    }

	function getPriceList($city,$inqs,$varianttype){
		 $keyValueArray['city'] = $city;
		 // $keyValueArray['varianttype'] = $varianttype;
		 $total = 0;
		 $indx = 0;
		 // $this->logs->writelogs($this->folderName,"Prices f the services: ".json_encode($inqs) );
		 foreach ($inqs as $inq) {
		 	$keyValueArray = array();
			 if($inq != ""){
				 $keyValueArray['name'] = $inq;
				 $keyValueArray['varianttype'] = $varianttype[$indx];
				 $dataArr = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "taxed_cost", '', '',false);
				 // print_r($dataArr);
				 // print_r($varianttype[$indx]);
				 $this->logs->writelogs($this->folderName,"Prices of the services: ".json_encode($dataArr) );
				 $total =$total+$dataArr[0]['taxed_cost'];
				 // $this->logs->writelogs($this->folderName,"Prices of the services: ".json_encode($dataArr) );
			 }
			 $indx = $indx +1;
		 }
		 // $this->logs->writelogs($this->folderName,"Prices f the services: ".json_encode($inqs) );
		 return $total;
	 }

	 // function getindividualPrice($city,$inqs,$varianttype){
		// $keyValueArray = array();
		//  $keyValueArray['city'] = $city;
		//  // $keyValueArray['varianttype'] = $varianttype;
		//  $total = 0;
		//  $indx = 0;
		// 	 if($inq != ""){
		// 		 $keyValueArray['name'] = $inq;
		// 		 $keyValueArray['varianttype'] = $varianttype[$indx];
		// 		 $dataArr = $this -> db -> getDataFromTable($keyValueArray, 'pricelist', "taxed_cost", '', '', false);
		// 		 $this->logs->writelogs($this->folderName,"Prices of the services: ".json_encode($dataArr) );
		// 		 $total =$total+$dataArr[0]['taxed_cost'];
		// 		 // $this->logs->writelogs($this->folderName,"Prices of the services: ".json_encode($dataArr) );
		// 	 }
		// 	 $indx = $indx +1;
		//  // $this->logs->writelogs($this->folderName,"Prices f the services: ".json_encode($inqs) );
		//  return $total;
	 // }

	 public function optionsGeneratorforLeadsource($table, $display_field, $value_field, $selected_value="", $conditions="") {
			       
			       $res = $this -> db ->multiquery("SELECT id,name,parent_id FROM leadsource");  // add WHERE clauses if needed
					$names = array();
					$parents = array();
					$children = array();
					
					while ( $row = mysqli_fetch_object( $res ) ) {
						
					    $names[ $row->id ] = $row->name;
					    if ( $row->parent_id == -1 ||$row->parent_id == 0 ) {
					        $parents[] = $row->id;
					    } else {
					        if ( !array_key_exists( $row->parent_id, $children ) )
					            $children[ $row->parent_id ] = array();
					        $children[ $row->parent_id ][] = $row->id;
					    }
					}

				   $options_str = "";			       
			       $options_str = "<option value=''>Please Select</option>";
					foreach ( $parents as $parent_id ) {
					    //print_r($names[$parent_id]);

					    if ( array_key_exists( $parent_id, $children ) ) {
					    	$options_str.='<optgroup label="'. $names[$parent_id] .'">';
					        foreach ( $children[ $parent_id ] as $child_id ) {

							    $options_str.="<option value='" . $child_id . "'";
					           
					           if ($selected_value != '' && $selected_value == $child_id) $options_str.=' selected ';
					           
					           $options_str.='>' . $names[$child_id] . '</option>';
					           // print_r($names[$child_id]);
					        }
					        $options_str.='</optgroup>';
					    }
					    else {
				       		$options_str.="<option value='" . $parent_id . "'";
				           if ($selected_value != '' && $selected_value == $parent_id)
				               $options_str.=' selected ';
				           $options_str.='>' . $names[$parent_id] . '</option>';
				       	}
					}
				
		       
		       return $options_str;
	    }

	function send_invoice_email($id){
		$keyValueArray = array();
		$keyValueArray['leadmanager.id'] = $id;
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p1','condition'=>'p1.id=leadmanager.service_inquiry1');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p2','condition'=>'p2.id=leadmanager.service_inquiry2');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p3','condition'=>'p3.id=leadmanager.service_inquiry3');
		$joinArray[] = array('type'=>'left','table'=>'`order`','condition'=>'`order`.order_id=leadmanager.order_id');
		$result = $this -> db -> getAssociatedDataFromTable($keyValueArray, $this -> tableName, "leadmanager.client_firstname,leadmanager.address,leadmanager.client_lastname,leadmanager.taxed_cost,leadmanager.order_id,leadmanager.client_email_id,p1.name as service1,p2.name as service2,p3.name as service3,`order`.invoice_id",'','',$joinArray,false);
		$whereArr = array();
		$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
		$total_tax = 0;
		$total_tax_amount = 0;
		$taxHtml = '';
		if($taxes):
			foreach ($taxes as $tax) {
				$tax_breakup = '';
				
				$tax_breakup = $tax['name']. ' @ '.$tax['value'].' % '.date('Y').'-'.(date('y')+ 1).'<br />';
				$tax_amount = ($result[0]['taxed_cost']*$tax['value'])/100;
				$total_tax_amount = $total_tax_amount + $tax_amount;
				$taxHtml .= '<tr>
				<td align="center">
				</td>
				<td align="left">'.$tax_breakup.'
				</td>
				<td></td><td></td>
				<td align="center">'.$tax_amount.'</td>
				</tr>';
				
			}
		endif;
		$total_amount = $result[0]['taxed_cost'] - $total_tax_amount;

		$l = encryptdata($id);
		$m = encryptdata($result[0]['order_id']);
		if($result && $result[0]['client_email_id']!=''){
			$subject = "Mr Home Care- Invoice";
			$to = $result[0]['client_email_id'];
			$from = 'Mr Home care-'.INVOICE_FROM_EMAILID;
			$body  = '<table cellspacing="0" cellpadding="0" border="1" align="center" style="width:80%">
<tbody>
<tr>
<td bgcolor="white" style="padding:20px 30px 80px 30px">
<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="margin-top:10px;width:100%;max-width:600px;padding:50px 0 0px 0px">
<tbody>
<tr>
<td>
<table cellspacing="0" cellpadding="0" border="0" align="left" style="width:40%;padding:0px 0 0 0">
<tbody>
<tr>
<td style="padding:0 0 0px 10px;font-family:"Neris Light",arial;font-size:18px;min-height:auto;width:50px">Hello</td>
<td>';
$body .= '<span style="padding:0px 0 0 0px;font-family:"Neris Semibold",arial;font-size:18px;width:50px;min-height:0px">
'.$result[0]['client_firstname'].'
</span>
</td>
</tr>
</tbody>
</table>
<table border="0" align="right" style="width:50%;max-width:100%;float:right">
<tbody>
<tr>
<td align="right" style="padding:0px 0 0px 0px;font-family:"Neris Light",arial;font-size:12px">
INVOICE NO.
<span style="padding:0px 0 0px 0px;border:none;border-collapse:collapse;font-family:"Roboto",sans-serif;font-size:12px;font-weight:700;width:80px;text-align:right">
'.$result[0]['invoice_id'].'
</span>
<p align="right" valign="top" style="padding:0px 0 0px 0px;border:none;font-family:"Roboto",sans-serif;font-size:12px;width:100px;text-align:right"></p>
'.date('d M, Y',strtotime(date('Y-m-d'))).'
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="padding:10px 0 10px 0">
<hr width="100%" size="1" color="#fec11f">
<a target="_blank" href="http://www.mrhomecare.in">
<img width="30%" alt="Mr Home Care logo" src="https://www.mrhomecare.in/wp-content/themes/mrhomecare/mhc-lib/img/logo.png" class="CToWUd">
</a>
<table border="0" align="right" style="padding:0 65px 10px 20px;width:50%;max-width:50%">
<tbody><tr>
<td>
<table border="0" style="width:50%;max-width:100%">
<tbody>
<tr>
<td valign="top" align="left" style="padding:0px 0 0px 0px;font-family:"Roboto",sans-serif;font-size:14px;font-weight:700;line-height:1em">
Bill to
</td>
</tr>
</tbody>
</table>
<table border="0" style="margin-right:30%" align="right" valign="top">
<tbody>
<tr>
<td style="padding:0 0 0px 0px">
<p align="left" style="padding:0px 0 0px 0px;border:none;overflow:hidden;font-family:"Roboto",sans-serif;font-size:13px;width:200px;min-height:120px">
<b>'.$result[0]['client_firstname'].'</b>
<br>
<br>
'.$result[0]['address'].'
<br>
Phone - <a target="_blank" value="'.$result[0]['client_mobile_no'].'" href="tel:'.$result[0]['client_mobile_no'].'">'.$result[0]['client_mobile_no'].'</a>
<br>
</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody></table>

<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0 0px 0">
<tbody><tr>
<td style="width:100px">
<hr width="100%" size="1px" color="#fec11f" align="left" style="display:inline-block">
</td>
<td style="width:50px !important;text-align:center !important;">
<h6 style="display:inline;color:#fec11f;font-size:18px;padding:0 0px 0 0px">Booking Details</h6>
</td>
<td style="width:100px">
<hr width="100%" size="1px" color="#fec11f" align="right" style="display:inline-block">
</td>
</tr>
</tbody></table>
<span style="font-family:"Neris Thin",arial;font-size:15px;font-weight:400;padding:0px 0 20px 20px">
<table border="0" style="color:black;font-size:14px;font-family:"Neris Thin",arial">
<tbody><tr>
<td>Service:</td>
<td>
<b>'.$result[0]['service1'].'</b>
</td>
</tr>
<tr>
<td>Date:</td>
<td>
<b>'.date('d M, Y',strtotime(date('Y-m-d'))).'</b>
</td>
</tr>
<tr>
</tr>
</tbody></table>
</span>
<table width="100%" border="0" style="border-collapse:collapse;font-family:"Roboto",sans-serif;color:black;font-size:12px">
<tbody><tr width="100%" style="font-weight:500;font-size:14px;background:#fec11f;color:white;height:30px">
<td align="center" style="width:10px">
<strong>Sr.No.</strong>
</td>
<td align="center">
<strong>Service Breakup</strong>
</td>
<td align="center">
<strong>Quantity</strong>
</td>
<td align="center">
<strong>Rate</strong>
</td>
<td align="center">
<strong>Amount</strong>
</td>
</tr>
<tr cellpadding="1">
<td></td>
<td align="center" style="font-weight:700;font-size:14px;padding-top:5px;padding-bottom:5px" colspan="1">

</td>
</tr>
<tr>
<td align="center">
1
</td>
<td align="left">
'.$result[0]['service1'].'<br />'.$result[0]['service2'].'<br />'.'
</td>
<td align="center">
1
</td>
<td align="center">
'.$total_amount.'
</td>
<td align="center">
'.$total_amount.'
</td>
</tr>'.$taxHtml.'<tr>
<td style="width:50px"></td>
<td></td>
</tr>
<tr style="border-bottom:1px solid #fec11f">
<td></td>
<td></td>
<td align="right" style="padding:0 10px 0 0" colspan="2">
</td>
<td>
<strong>
<p style="border:none;float:center;text-align:center">

</p>
</strong>
</td>
</tr>
<tr style="border-bottom:1px solid #fec11f">
<td></td>
<td></td>
<td></td>
<td align="right" style="padding:0 10px 0 0">
<strong>Net Payable</strong>
</td>
<td>
<p style="border:none;float:center;font-weight:700;text-align:center">
'.$result[0]['taxed_cost'].'
</p>
</td>
</tr>
<tr>
<td colspan="2">CIN:</td>
<td></td>
<td align="right" style="font-size:14px;padding:0 10px 0 0"></td>
<td>
<strong>
<p type="text" style="border:none;float:center;text-align:center;font-weight:700">
</p>
</strong>
</td>
</tr>
<tr>
<td colspan="3"></td>
<td align="right" colspan="2">
<a target="_blank" style="padding:5px;border:1px solid #fec11f;color:white;background-color:#fec11f;text-decoration:none" href="'.SITEPATH."/payment/paynow.php?m=".$m."&l=".$l.'">
Click to pay online
</a>
</td>
</tr>
<tr>
<td colspan="4"></td>
<td>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
<table width="60%" border="0" align="center">
<tbody><tr>
<td style="padding:20px 0 0px 0"></td>
<td>
</td>
</tr>
</tbody></table>
<table width="100%" border="0" align="center">
<tbody><tr>
<td>
<h2 align="center" width="100%" style="border-collapse:collapse;font-family:"Roboto",sans-serif;color:black;font-weight:300;font-size:14px" border="0">
</h2>
<table align="center">
<tbody><tr>
<td>
<a target="_blank" href="https://twitter.com/iammrhomecare">
<img alt="Twitter" src="'.SITEPATH.'/images/twitter.png" style="width:20px;padding:2px 0 0 0;border:0;display:inline" class="CToWUd">
</a>
<a target="_blank" href="https://www.facebook.com/MisterHomecare/">
<img alt="Facebook" src="'.SITEPATH.'/images/facebook.png" style="width:20px;padding:2px 0 0 0;border:0;display:inline" class="CToWUd">
</a>
</td>
</tr>
</tbody></table>
<p align="center" style="font-family:"Roboto",sans-serif;color:black;font-weight:300;font-size:15px">
<i>Thanks for using our service!</i>
</p>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>';

			$r = sendEmail($to,$from,$subject,$body);
			if($r)
				return true;
			else
				return false;
		}else{
			return false;
		}
	}

	function get_variant_type(){
		$keyValueArray['sqlclause'] = 'name="'.$_POST['id'].'" group by pricelist.varianttype';
		//$joinArray[] = array('type'=>'left','table'=>'variantmaster','condition'=>'variantmaster.id=pricelist.varianttype');
		$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, 'pricelist', "pricelist.varianttype", '', '',$joinArray, false);
		return $dataArr;
	}

	function get_client_firstname($client_firstname){
		$keyValueArray['sqlclause'] = 'client_firstname like "%'.$client_firstname.'%"';
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, 'mhcclient', " client_firstname", '', '', false);
		foreach ($dataArr as $value) {
			$t[] = $value['client_firstname'];
		}
		return $t;
	}

	function get_client_lastname($client_lastname){
		$keyValueArray['sqlclause'] = 'client_lastname like "%'.$client_firstname.'%"';
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, 'mhcclient', " client_lastname", '', '', false);
		foreach ($dataArr as $value) {
			$t[] = $value['client_lastname'];
		}
		return $t;
	}
	function get_mhcclient($id){
		$keyValueArray['id'] = $id;
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, 'mhcclient', "*", '', '', false);
		return $dataArr;
	}
	function get_mhcclient_mobile($mobile){
		$keyValueArray['client_mobile_no'] = $mobile;
		$dataArr = $this -> db ->getDataFromTable($keyValueArray, 'mhcclient', "*", '', '', false);
		return $dataArr;
	}

	public function insertClientTable($values) {
		$tablename = 'mhcclient';
		$response =  $this -> db -> insertDataIntoTable($values, $tablename);
		if($response){
			$memcache = new Memcache;
			$memcache->connect('localhost', 11211);

			$mhcclientarr = $memcache->get('mhcclient');
			$mhcclientarr[$response] =  array('client_firstname'=>$values['client_firstname'],'client_lastname'=>$values['client_lastname'],'client_mobile_no'=>$values['client_mobile_no'],'address'=>$values['address']);
			$memcache->set('mhcclient',$mhcclientarr);
		}
		//$this->logs->writelogs($this->folderName,"Insertion: ".json_encode($response));
		return $response;
	}

	public function updateClientTable($values, $whereArr) {
		$tablename = "mhcclient";
		$response = $this -> db -> updateDataIntoTable($values, $whereArr, $tablename);

		if($response){
			$memcache = new Memcache;
			@$memcacheConn = $memcache->connect('localhost', 11211);
			if($memcacheConn):
				$mhcclientarr = $memcache->get('mhcclient');
		    else:
		    	$mhcclientarr = $this -> dashObj->mhcclient();
		    endif;
			foreach ($mhcclientarr as $key =>$client) {
				if($key == $response){
					unset($mhcclientarr[$key]);
				}
			}
			if($values['client_firstname'] != '')
				$mhcclientarr[$response] =  array('client_firstname'=>$values['client_firstname'],'client_lastname'=>$values['client_lastname'],'client_mobile_no'=>$values['client_mobile_no'],'address'=>$values['address']);

			if($values['status']){
				unset($mhcclientarr[$response]);
			}
			$memcache->set('mhcclient',$mhcclientarr);
		}
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;
	}

	public function insertAddressTable($values) {
		$tablename = 'addressmaster';
		$response =  $this -> db -> insertDataIntoTable($values, $tablename);
		//$this->logs->writelogs($this->folderName,"Insertion: ".json_encode($response));
		return $response;
	}

	public function updateAddressTable($values, $whereArr) {
		$tablename = "addressmaster";
		$response = $this -> db -> updateDataIntoTable($values, $whereArr, $tablename);
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;
	}

	public function deleteAddressTable($whereArr) {
		$tablename = "addressmaster";
		$response = $this -> db -> deleteDataFromTable($whereArr, $tablename);
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;
	}

	public function getAddressTable($id) {
		$tablename = "addressmaster";
		$whereArr = array('mhcclient_id'=>$id);
		$response = $this -> db -> getDataFromTable($whereArr, $tablename,"address");
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;
	}

	public function insertServiceTable($query){
		return $this -> db ->query($query);
	}

	public function updateServiceTable($values,$whereArr){
		$tablename = "service";
		$response = $this -> db -> updateDataIntoTable($values, $whereArr, $tablename);
		return $response;
	}

	public function getServiceTable($id) {
		$tablename = "service";
		$whereArr = array('leadmanager_id'=>$id);
		$response = $this -> db -> getDataFromTable($whereArr, $tablename,"*");
		//$this->logs->writelogs($this->folderName,"Update: ".json_encode($response));
		return $response;
	}

	public function deleteServiceTable($query){
		return $this -> db ->query($query);
	}
}
?>
