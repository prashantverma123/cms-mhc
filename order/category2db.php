<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$order_id 	= isset($_POST['order_id']) ? $_POST['order_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_order':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $order_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveOrder':
			if($order_id == '' ){ //add new record
				$insertArr['name'] 	= $_POST['name'];
				$insertArr['lead_source'] 			= $_POST['lead_source'];
				$insertArr['mobile_no'] 		= $_POST['mobile_no'];
				$insertArr['alternate_no'] 			= $_POST['alternate_no'];
				$insertArr['email_id'] 			= $_POST['email_id'];
				$insertArr['address'] 		= $_POST['address'];
				$insertArr['landmark'] 		= $_POST['landmark'];
				$insertArr['location'] 	= $_POST['location'];
				$insertArr['city'] 			= $_POST['city'];
				$insertArr['state'] 			= $_POST['state'];
				$insertArr['pincode'] 			= $_POST['pincode'];
				$insertArr['service'] 			= $_POST['service'];
				$insertArr['price'] 			= $_POST['price'];
				$insertArr['commission'] 			= $_POST['commission'];
				$insertArr['taxed_cost'] 			= $_POST['taxed_cost'];
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
				$arrReturn['order_id'] = encryptdata($returnVal);

			}else if($order_id > 0){ // edit the record
				$updateArr['name'] 			= $_POST['name'];
				$updateArr['lead_source'] 		= $_POST['lead_source'];
				$updateArr['mobile_no'] 	= $_POST['mobile_no'];
				$updateArr['alternate_no'] 		= $_POST['alternate_no'];
				$updateArr['email_id'] 		= $_POST['email_id'];
				$updateArr['address'] 		= $_POST['address'];
				$updateArr['landmark']	 	= $_POST['landmark'];
				$updateArr['location'] 	= $_POST['location'];
				$updateArr['city'] 	= $_POST['city'];
				$updateArr['state'] 	= $_POST['state'];
				$updateArr['pincode'] 	= $_POST['pincode'];
				$updateArr['service'] 	= $_POST['service'];
				$updateArr['price'] 	= $_POST['price'];
				$updateArr['commission'] 	= $_POST['commission'];
				$updateArr['taxed_cost'] 	= $_POST['taxed_cost'];

				$whereArr = array('id' => $order_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['order_id'] = encryptdata($order_id);

			}
			break;
			case "update_jobinfo":
			if($_POST['job_info'] == 'job_start'):
				$updateArr['job_start'] = date('Y-m-d h:i:s');
			elseif($_POST['job_info'] == 'job_end'):
				$updateArr['job_end'] = date('Y-m-d h:i:s');
			endif;
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			$arrReturn['result'] = 'success';
			$arrReturn['action'] = 'updateJobInfo';
			$arrReturn['call'] = 'update';
			$arrReturn['order_id'] = encryptdata($order_id);
			break;
			case "update_jobstatus":
			$updateArr['job_status'] = $_POST['job_status'];
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			$arrReturn['result'] = 'success';
			$arrReturn['action'] = 'updateJobInfo';
			$arrReturn['call'] = 'update';
			$arrReturn['order_id'] = encryptdata($order_id);
			break;
}
echo json_encode($arrReturn);
