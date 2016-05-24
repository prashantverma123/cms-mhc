<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$lead_id 	= isset($_POST['lead_id']) ? $_POST['lead_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_lead':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $lead_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveLead':
			if($lead_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['lead_stage'];
				$insertArr['lead_order'] 			= $_POST['lead_order'];
				$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
				$insertArr['author_name']			= "Prashant";
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				$insertArr['update_date']		= date('Y-m-d H:i:s');
				$insertArr['status']= 0;
				$insertArr['ip']= getIP();
				$returnVal = $modelObj->insertTable($insertArr);
				//die;
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call']   = 'add';
				$arrReturn['lead_id'] = encryptdata($returnVal);

			}else if($lead_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['lead_stage'];
				$updateArr['lead_order'] 		= $_POST['lead_order'];


				$whereArr = array('id' => $lead_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['lead_id'] = encryptdata($lead_id);

			}
			break;
}
echo json_encode($arrReturn);
