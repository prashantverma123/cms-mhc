<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$product_id 	= isset($_POST['product_id']) ? $_POST['product_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_product':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $product_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveProduct':
			if($product_id == '' ){ //add new record
				$insertArr['category_id'] 	= $_POST['category_id'];
				$insertArr['validity'] 			= $_POST['validity'];
				$insertArr['cost'] 	      	= $_POST['cost'];
				$insertArr['city_id'] 			= $_POST['city_id'];
				$insertArr['lead_source_id']= $_POST['lead_source_id'];
				$insertArr['comission'] 		= $_POST['comission'];
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
				$arrReturn['product_id'] = encryptdata($returnVal);

			}else if($product_id > 0){ // edit the record
				$updateArr['category_id'] 			= $_POST['category_id'];
				$updateArr['validity'] 		= $_POST['validity'];
				$updateArr['cost'] 	= $_POST['cost'];
				$updateArr['city_id'] 		= $_POST['city_id'];
				$updateArr['lead_source_id'] 		= $_POST['lead_source_id'];
				$updateArr['comission']	 	= $_POST['comission'];

				$whereArr = array('id' => $product_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['product_id'] = encryptdata($product_id);

			}
			break;
}
echo json_encode($arrReturn);
