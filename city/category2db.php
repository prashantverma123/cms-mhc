<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$city_id 	= isset($_POST['city_id']) ? $_POST['city_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_city':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $city_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveCity':
			if($city_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['city_name'];
				$insertArr['city_tier'] 			= $_POST['city_tier'];
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
				$arrReturn['city_id'] = encryptdata($returnVal);

			}else if($city_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['city_name'];
				$updateArr['city_tier'] 		= $_POST['city_tier'];
				$whereArr = array('id' => $city_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['city_id'] = encryptdata($city_id);

			}
			break;
}
echo json_encode($arrReturn);
