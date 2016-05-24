<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$pricelist_id 	= isset($_POST['pricelist_id']) ? $_POST['pricelist_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_pricelist':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $pricelist_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'savePrice':
			if($pricelist_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['name'];
				$insertArr['category_type'] 		= $_POST['category_type'];
				$insertArr['lead_source'] 			= $_POST['lead_source'];
				$insertArr['city'] 			= $_POST['city'];
				$insertArr['price'] 			= $_POST['price'];
				$insertArr['commission'] 		= $_POST['commission'];
				$insertArr['taxed_cost'] 		= $_POST['taxed_cost'];
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
				$arrReturn['pricelist_id'] = encryptdata($returnVal);

			}else if($pricelist_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['name'];
				$updateArr['category_type'] 		= $_POST['category_type'];
				$updateArr['lead_source'] 	= $_POST['lead_source'];
				$updateArr['city'] 		= $_POST['city'];
				$updateArr['price'] 		= $_POST['price'];
				$updateArr['commission'] 		= $_POST['commission'];
				$updateArr['taxed_cost']	 	= $_POST['taxed_cost'];
				$whereArr = array('id' => $pricelist_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['pricelist_id'] = encryptdata($pricelist_id);

			}
			break;
}
echo json_encode($arrReturn);
