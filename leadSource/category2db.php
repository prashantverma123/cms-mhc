<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$source_id 	= isset($_POST['source_id']) ? $_POST['source_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_src':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $source_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveLeadSource':
			if($source_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['source_name'];
				$insertArr['source_url'] 			= $_POST['source_url'];
				$insertArr['source_phone'] 		= $_POST['source_phone'];
				$insertArr['source_email_id'] 		= $_POST['source_email_id'];
				$insertArr['parent_id'] 		= $_POST['parent_id'];
				$insertArr['source_address'] 			= $_POST['source_address'];
				$insertArr['commission_type'] 			= $_POST['commission_type'];
				$insertArr['is_partner'] 			= $_POST['is_partner'];
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
				$arrReturn['source_id'] = encryptdata($returnVal);

			}else if($source_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['source_name'];
				$updateArr['source_url'] 		= $_POST['source_url'];
				$updateArr['source_phone'] 	= $_POST['source_phone'];
				$updateArr['source_email_id'] 	= $_POST['source_email_id'];
				$updateArr['source_address'] 		= $_POST['source_address'];
				$updateArr['commission_type'] 		= $_POST['commission_type'];
				$updateArr['is_partner'] 		= $_POST['is_partner'];
				$updateArr['parent_id'] 		= $_POST['parent_id'];

				$whereArr = array('id' => $source_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['source_id'] = encryptdata($source_id);

			}
			break;
}
echo json_encode($arrReturn);
