<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$employee_id 	= isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_employee':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $employee_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveEmployee':
			if($employee_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['name'];
				$insertArr['email'] 			= $_POST['email'];
				$insertArr['designation'] 	      	= $_POST['designation'];
				$insertArr['mobile_no'] 			= $_POST['mobile_no'];
				$insertArr['city']= $_POST['city'];
				$insertArr['gender'] 		= $_POST['gender'];
				$insertArr['experties'] 		= $_POST['experties'];
				$insertArr['gender'] 		= $_POST['gender'];
				$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
				$insertArr['author_name']		= $_SESSION['tmobi']['AdminName'];
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				
				$insertArr['status']= 0;
				$insertArr['ip']= getIP();
				$returnVal = $modelObj->insertTable($insertArr);
				//die;
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call']   = 'add';
				$arrReturn['employee_id'] = encryptdata($returnVal);

			}else if($employee_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['name'];
				$updateArr['email'] 		= $_POST['email'];
				$updateArr['designation'] 	= $_POST['designation'];
				$updateArr['mobile_no'] 		= $_POST['mobile_no'];
				$updateArr['city'] 		= $_POST['city'];
				$updateArr['gender']	 	= $_POST['gender'];
				$updateArr['experties']	 	= $_POST['experties'];
				$updateArr['update_date']		= date('Y-m-d H:i:s');

				$whereArr = array('id' => $employee_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['employee_id'] = encryptdata($employee_id);

			}
	break;
	case "save_attendance":
		$attendance 	= isset($_POST['attendance']) ? $_POST['attendance'] : '';
		$date 	= isset($_POST['date']) ? $_POST['date'] : '';
		$result = $modelObj->get_employee_attendance($employee_id,$attendance,$date);
		$arrReturn['result'] = $result;
	break;
	case "save_attendance_all":
		$attendance 	= isset($_POST['attendance']) ? $_POST['attendance'] : '';
		$dates 	= isset($_POST['date']) ? explode(',',$_POST['date']) : '';
		foreach ($dates as $date) {
			if($date!='')
			$result = $modelObj->get_employee_attendance($employee_id,$attendance,$date);
		}
		//print_r($date);
		///$result = $modelObj->get_employee_attendance($employee_id,$attendance,$date);
		$arrReturn['result'] = $result;
	break;
}
echo json_encode($arrReturn);
