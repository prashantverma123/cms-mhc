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
		$joinArray[] = array('type'=>'left','table'=>'pricelist','condition'=>'pricelist.id=order.service');
		//$joinArray[] = array('type'=>'left','table'=>'pricelist','condition'=>"pricelist.id = SUBSTRING_INDEX(SUBSTRING_INDEX(`order`.service, ',', FIND_IN_SET(pricelist.id,`order`.service)), ',', -1)");
		//$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, "`order`.*,leadsource.name as leadsource_name,GROUP_CONCAT(pricelist.name ORDER BY pricelist.id SEPARATOR '|') as 'services'", $sort, $limit,$joinArray, true);
		$dataArr = $this -> db ->getAssociatedDataFromTable($keyValueArray, $this -> tableName, "`order`.*,leadsource.name as leadsource_name,pricelist.name as service", $sort, $limit,$joinArray, false);

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

    	function send_invoice_email($id){
		$keyValueArray = array();
		//$keyValueArray['leadmanager.order_id'] = $id;
		$keyValueArray['order.id'] = $id;
		$joinArray[] = array('type'=>'left','table'=>'`leadmanager`','condition'=>'`leadmanager`.order_id=`order`.order_id');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p1','condition'=>'p1.id=leadmanager.service_inquiry1');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p2','condition'=>'p2.id=leadmanager.service_inquiry2');
		$joinArray[] = array('type'=>'left','table'=>'pricelist as p3','condition'=>'p3.id=leadmanager.service_inquiry3');

		//$result = $this -> db -> getAssociatedDataFromTable($keyValueArray, 'leadmanager', "leadmanager.id,leadmanager.client_firstname,leadmanager.address,leadmanager.client_lastname,leadmanager.taxed_cost,leadmanager.order_id,leadmanager.client_email_id,p1.name as service1,p2.name as service2,p3.name as service3,`order`.invoice_id",'','',$joinArray,false);
		$result = $this -> db -> getAssociatedDataFromTable($keyValueArray, 'order', "`order`.order_id,leadmanager.id,leadmanager.client_firstname,leadmanager.address,leadmanager.client_lastname,leadmanager.taxed_cost,leadmanager.order_id,leadmanager.client_email_id,leadmanager.client_mobile_no,p1.name as service1,p2.name as service2,p3.name as service3,`order`.invoice_id",'','',$joinArray,false);

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
			// $to = $result[0]['client_email_id'].';prashant.verma@mrhomecare.in';
			$to ='pra0408@gmail.com'.';prashant.verma@mrhomecare.in';
			$from = 'Mr Home care-'.INVOICE_FROM_EMAILID;
			$body  = '<div bgcolor="#f6f8f1"><table cellspacing="0" cellpadding="0" border="1" align="center" style="width:80%">
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
<td style="padding:0 0 0px 5px;font-family:"Neris Light",arial;font-size:18px;min-height:auto;width:50px"></td>
<td>';
$body .= 'Hello <span style="padding:0px 0 0 0px;font-family:"Neris Semibold",arial;font-size:18px;width:50px;min-height:0px">
'.ucfirst($result[0]['client_firstname']).'
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
<table border="0" style="width:50%;max-width:100%;">
<tbody>
<tr>
<td valign="top" align="left" style="padding:0px 0 0px 10px;font-family:"Roboto",sans-serif;font-size:14px;font-weight:700;line-height:1em">
Bill to:
</td>
</tr>
</tbody>
</table>
<table border="0" style="" align="right" valign="top">
<tbody>
<tr>
<td style="padding:0 0 0px 0px">
<p align="left" style="padding:0px 0 0px 0px;border:none;overflow:hidden;font-family:"Roboto",sans-serif;font-size:13px;width:200px;min-height:120px">
<b>'.ucfirst($result[0]['client_firstname']).'</b>
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
<td align="center" style="font-weight:700;font-size:14px;padding-top:1%;padding-bottom:1%" colspan="1">

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
<td colspan="2"></td>
<td align="right" colspan="3">
<a target="_blank" style="padding:1%;border:1px solid #fec11f;color:white;background-color:#fec11f;text-decoration:none" href="'.SITEPATH."/payment/paynow.php?m=".$m."&l=".$l.'">
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
</table><div class="yj6qo"></div><div class="adL">
</div></div>';

			$r = sendEmail($to,$from,$subject,$body);
			if($r)
				return true;
			else
				return false;
		}else{
			return false;
		}
	}

}
?>
