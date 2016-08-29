<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	if(!$action){
		$action   		= isset($_GET['action']) ? $_GET['action'] : '';
	}
	$cmsuser_id 	= isset($_POST['cmsuser_id']) ? $_POST['cmsuser_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_cmsuser':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $cmsuser_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveCmsuser':
			if($cmsuser_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['name'];
				$insertArr['email'] 		= $_POST['email'];
				$insertArr['username'] 		= $_POST['username'];
				$insertArr['password'] 			= md5($_POST['password']);
				$insertArr['city'] 			= $_POST['city'];
				$insertArr['role'] 			= $_POST['role'];
				$insertArr['is_vendor'] 	= $_POST['is_vendor'];
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				//$insertArr['update_date']		= date('Y-m-d H:i:s');
				$insertArr['status']= 0;
				$insertArr['ip']= getIP();
				$returnVal = $modelObj->insertTable($insertArr);
				if($returnVal){
					$arrReturn['result'] = 'success';
					$arrReturn['action'] = 'saveEventName';
					$arrReturn['call']   = 'add';
					$arrReturn['cmsuser_id'] = encryptdata($returnVal);
				}else{
					return false;
				}

			}else if($cmsuser_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['name'];
				$updateArr['email'] 		= $_POST['email'];
				$updateArr['username'] 	= $_POST['username'];
				$updateArr['password'] 		= $_POST['password'];
				$updateArr['city'] 		= $_POST['city'];
				$updateArr['role'] 		= $_POST['role'];
				$updateArr['is_vendor'] 	= $_POST['is_vendor'];
				$updateArr['update_date']	= date('Y-m-d H:i:s');
				$updateArr['ip']= getIP();



				$whereArr = array('id' => $cmsuser_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['cmsuser_id'] = encryptdata($cmsuser_id);

			}
			break;
			case "check_email":
			if($_GET['id'] == ''){
				$returnVal = $modelObj->checkEmail($_POST['email']);
				if($returnVal){
					$arrReturn = false;
				}else{
					$arrReturn = true;
				}
			}else{
				$arrReturn = true;
			}
			break;
			case "update_status":
				$whereArr = array('id' => $cmsuser_id );
				$updateArr = array('status'=>$_POST['status']);
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				if($returnVal):
				$arrReturn['result'] = true;
				else:
				$arrReturn['result'] = false;
				endif;
			break;
}
echo json_encode($arrReturn);
