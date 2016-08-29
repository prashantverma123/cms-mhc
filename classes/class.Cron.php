<?php 
class Cron{
	public function __construct() {
		//$this -> tableName = 'leadmanager';
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
	}

	function create_tax_constant(){
		$keyValueArray = array();
		$whereArr = array();
		$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
		$file = fopen("../lib/tax_constant.php", "w")or die("Unable to open file!");
		//foreach ($taxes as $tax) {
			/*$txt = "<?php \n";
			fwrite($file, $txt);
			$txt = "define('taxes',".$taxes.");";
			fwrite($file, $txt);
			$txt = " ?>";
*/
		//}
		//$txt = "John Doe\n";
		//fwrite($file, $txt);
		//$txt = "Jane Doe\n";
		fwrite($file, $txt);
		fclose($file);
		exit;
	}

	function send_reminder(){
		$st = "INSERT INTO `city` (`id`, `name`, `city_tier`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES (NULL, 'test', '', '1', '', '', '', '', '0')";
		$this -> db ->query($st); 
		exit;
		$stmt = "SELECT leadmanager_id,name,email_id,TIMESTAMPDIFF(HOUR,concat(service_date,' ',service_time),NOW()) AS hr
FROM `order`  WHERE leadmanager_id IN (select leadmanager.id from leadmanager where is_reminder='1' and reminder_sent!='1') HAVING hr <= 20";
        	$this -> db ->query($stmt);
        	$result = $this-> db ->fetch();
        	while ($result = $this-> db ->fetch()) {
            	//$lists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
        		$lists[] = $result;
			$subject = "Mr Home Care- Service Reminder";
			//$to = $result[0]['client_email_id'].';prashant.verma@mrhomecare.in';
			//$to =$result['email_id'];
			$to ='pra0408@gmail.com;trushali.bahira@mrhomecare.in';
			$from = 'Mr Home care-'.INVOICE_FROM_EMAILID;
			$body = 'Dear '.ucfirst($result['name']).',<br /><br />This is an automated reminder for your service scheduled for tomorrow. Please reply to this email to confirm the same. We look forward to keeping your home in perfect order. In case of any concerns or queries, please feel free to reach us on 9022070070 & customercare@mrhomecare.in <br /><br /><br />Thanks!';
			$r= sendEmail($to,$from,$subject,$body);
			if($r){
				 $whereArr = array('id'=>$result['leadmanager_id']);
				 $values = array('reminder_sent'=>1);
				$response = $this -> db -> updateDataIntoTable($values, $whereArr, 'leadmanager');
			}
		}
		exit;
	}

	function send_reminder_communication(){
		
		$stmt = "SELECT leadmanager_id,name,email_id,TIMESTAMPDIFF(HOUR,concat(service_date,' ',service_time),NOW()) AS hr
FROM `order`  WHERE leadmanager_id IN (select leadmanager.id from leadmanager where is_reminder='1' and reminder_sent!='1') HAVING hr >= 180";
        	$this -> db ->query($stmt);
        	$result = $this-> db ->fetch();
        	while ($result = $this-> db ->fetch()) {
            	//$lists[] = array('display' =>$result['display'] ,'value'=>$result['value']);
        		$lists[] = $result;
			$subject = "Mr Home Care- Service Reminder";
			//$to = $result[0]['client_email_id'].';prashant.verma@mrhomecare.in';
			//$to =$result['email_id'];
			$to ='pra0408@gmail.com;trushali.bahira@mrhomecare.in';
			$from = 'Mr Home care-'.INVOICE_FROM_EMAILID;
			$body = 'Dear '.ucfirst($result['name']).',<br /><br />This is an automated reminder for your service scheduled for tomorrow. Please reply to this email to confirm the same. We look forward to keeping your home in perfect order. In case of any concerns or queries, please feel free to reach us on 9022070070 & customercare@mrhomecare.in <br /><br /><br />Thanks!';
			$r= sendEmail($to,$from,$subject,$body);
			if($r){
				 $whereArr = array('id'=>$result['leadmanager_id']);
				 $values = array('reminder_sent'=>1);
				$response = $this -> db -> updateDataIntoTable($values, $whereArr, 'leadmanager');
			}
		}
		exit;
	}

	function add_attendance_list_weekly(){
		$keyValueArray = array('status'=>'0');
		$emps = $this -> db -> getDataFromTable($keyValueArray, 'crmemployee', "id", "", '', false);
		$days = array('Mon'=>'monday','Tue'=>'tuesday','Wed'=>'wednesday','Thu'=>'thursday','Fri'=>'friday','Sat'=>'saturday','Sun'=>'sunday');
		
		$author_id			= $_SESSION['tmobi']['UserId'];
		$author_name		= $_SESSION['tmobi']['AdminName'];
		$count = count($emps);
		foreach ($days as $key => $value) {
			$stmt = "INSERT INTO `attendance` (`employee_id`, `attendance`, `date`, `insert_date`, `update_date`, `author_name`, `author_id`) VALUES ";
			$date = date( 'Y-m-d', strtotime("$value this week") );
			foreach ($emps as $k=>$emp) {
				$stmt .= "('".$emp['id']."', '0', '".$date."', '".date( 'Y-m-d h:i:s')."', NULL, '".$author_name."', '".$author_id."')";
				if($count > $k+1){
					$stmt .= ',';
				}
			}
			$this -> db ->query($stmt);
		}
		exit;
	}
}

?>