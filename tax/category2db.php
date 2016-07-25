<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$tax_id 	= isset($_POST['tax_id']) ? $_POST['tax_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_tax':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $tax_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveTax':
			if($tax_id == '' ){ //add new record
				$insertArr['name'] 				= $_POST['name'];
				$insertArr['value'] 			= $_POST['value'];
				//$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
				//$insertArr['author_name']		= $_SESSION['tmobi']['AdminName'];
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				$insertArr['status']= 0;
				//$insertArr['ip']= getIP();
				$returnVal = $modelObj->insertTable($insertArr);
				//die;
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call']   = 'add';
				$arrReturn['tax_id'] = encryptdata($returnVal);

			}else if($tax_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['name'];
				$updateArr['value'] 		= $_POST['value'];
				$updateArr['update_date']	= date('Y-m-d H:i:s');
				$whereArr 					= array('id' => $tax_id );
				$returnVal 					= $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['tax_id'] = encryptdata($tax_id);

			}
			break;
}
echo json_encode($arrReturn);
