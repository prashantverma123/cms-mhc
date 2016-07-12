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
				$insertArr['author_name']			= $_SESSION['tmobi']['AdminName'];
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				
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
				$updateArr['update_date']		= date('Y-m-d H:i:s');
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
			case "sendInvoiceMail":
			$arr = $_POST;
			$row = $modelObj->send_invoice_email($arr);
			$arrReturn['result'] = $row;
			break;
			case "add_order_feedback":
			$updateArr['order_feedback '] = $_POST['order_feedback'];
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			$arrReturn['result'] = 'success';
			break;
			case "getRemark":
			 $result = $modelObj->get_remark($_POST['order_id']);
			 $arrReturn['result'] = $result;
			break;
			case "addRemark":
			if($_POST['remark_entry'] == 'insert'):
				$insertArr = array();
				$insertArr['order_id'] = $_POST['orderId'];
				$insertArr['remark'] = $_POST['remark'];
				$insertArr['insert_date'] = date('Y-m-d h:i:s');
				$insertArr['inserted_by'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->insert_remark($insertArr);
				$arrReturn['result'] = $result;
			else:
				$whereArr = array('order_id'=>$_POST['orderId']);
				$remarks = $modelObj->get_remark($_POST['orderId']);
				$updateArr['remark'] = $remarks.'<br />'.$_POST['remark'];
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['updated_by'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->update_remark($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			endif;
			break;
			case 'addDeployment':
			$order_id =$_POST['deployment_orderid'];
			$updateArr['deploymentsendInvoiceMail'] = $_POST['deployment'];
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			if($returnVal):
			$arrReturn['result'] = 'success';
			else:
			$arrReturn['result'] = 'failed';
			endif;
			break;
			case 'updatePaymentMode':
			$order_id =$_POST['order_id'];
			$updateArr['payment_mode'] = $_POST['payment_mode'];
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			if($returnVal):
			$arrReturn['result'] = 'success';
			else:
			$arrReturn['result'] = 'failed';
			endif;
			break;
			case 'updatePaymentStatus':
			$order_id =$_POST['order_id'];
			$updateArr['payment_status'] = $_POST['payment_status'];
			$whereArr = array('id' => $order_id );
			$returnVal = $modelObj->updateTable($updateArr,$whereArr);
			if($returnVal):
			$arrReturn['result'] = 'success';
			else:
			$arrReturn['result'] = 'failed';
			endif;
			break;
			case "cancel_order":
				$whereArr = array('id'=>$_POST['id']);
				$updateArr['status'] = '1';
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['author_id'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->updateTable($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			break;
			case "reschedule_order":
				$whereArr = array('id'=>$_POST['order_id']);
				$updateArr['service_date'] = $_POST['service_date'];
				$updateArr['status'] = '0';
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['author_id'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->updateTable($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			break;
			case "addBillingDetails":
				$whereArr = array('id'=>$_POST['order_id']);
				$updateArr['billing_address'] = $_POST['billing_address'];
				$updateArr['billing_name'] = $_POST['billing_name'];
				$updateArr['billing_name2'] = $_POST['billing_name2'];
				$updateArr['billing_address2'] = $_POST['billing_address2'];
				$updateArr['billing_amount2'] = $_POST['billing_amount2'];
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['author_id'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->updateTable($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			break;
			case "updatePaymentReceived":
				$whereArr = array('id'=>$_POST['payment_orderid']);
				$updateArr['received_amount'] = $_POST['received_amount'];
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['author_id'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->updateTable($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			break;
			case "addPaymentInfo":
				$whereArr = array('id'=>$_POST['paymodeorderid']);
				$updateArr['payment_info'] = $_POST['payment_info'];
				$updateArr['update_date'] = date('Y-m-d h:i:s');
				$updateArr['author_id'] = $_SESSION['tmobi']['UserId'];
				$result = $modelObj->updateTable($updateArr,$whereArr);
			 	$arrReturn['result'] = $result;
			break;
}
echo json_encode($arrReturn);
