<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	$leadmanager_id 	= isset($_POST['leadmanager_id']) ? $_POST['leadmanager_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_leadmanager':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $leadmanager_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveLeadManager':
			if($leadmanager_id == '' ){ //add new record
				$insertArr['lead_source'] 	= $_POST['lead_source'];
				$insertArr['lead_owner'] 	= $_POST['lead_owner'];
				$insertArr['followup_by'] 	= $_POST['followup_by'];
				$insertArr['job_status']	= 'pending';
				$insertArr['lead_stage']    = $_POST['lead_stage'];
				$insertArr['reminder']    = $_POST['reminder'];
				$insertArr['service1_date'] 		=  date("Y-m-d", strtotime($_POST['service1_date']));
				$insertArr['service1_time'] 		= $_POST['service1_time'];
				$insertArr['service2_date'] 		=  date("Y-m-d", strtotime($_POST['service2_date']));
				$insertArr['service2_time'] 		= $_POST['service2_time'];
				$insertArr['service3_date'] 		=  date("Y-m-d", strtotime($_POST['service3_date']));
				$insertArr['service3_time'] 		= $_POST['service3_time'];

				$insertArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				$insertArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
				$insertArr['janitor_deployment'] 		= $_POST['janitor_deployment'];
				$insertArr['client_salutation'] 		= $_POST['client_salutation'];
				$insertArr['client_firstname'] 		= $_POST['client_firstname'];
				$insertArr['client_lastname'] 		= $_POST['client_lastname'];
				$insertArr['client_mobile_no'] 		= $_POST['client_mobile_no'];
				$insertArr['alternate_no'] 		= $_POST['alternate_no'];
				$insertArr['client_email_id'] 		= $_POST['client_email_id'];

				$insertArr['address'] 	= $_POST['address'];
				$insertArr['landmark'] 	= $_POST['landmark'];
				$insertArr['location'] 	= $_POST['location'];
				$insertArr['city'] 	= $_POST['city'];
				$insertArr['state'] 	= $_POST['state'];
				$insertArr['pincode'] 	= $_POST['pincode'];
				$insertArr['additional_note'] 	= $_POST['additional_note'];
				$insertArr['service_inquiry1'] 	= $_POST['service_inquiry1'];
				$insertArr['service_inquiry1_booked'] 	= $_POST['service_inquiry1_booked'];

				$insertArr['service_inquiry2'] 	= $_POST['service_inquiry2'];
				$insertArr['service_inquiry2_booked'] 	= $_POST['service_inquiry2_booked'];
				$insertArr['service_inquiry3'] 	= $_POST['service_inquiry3'];
				$insertArr['service_inquiry3_booked'] 	= $_POST['service_inquiry3_booked'];
				$insertArr['promo_code'] 	= $_POST['promo_code'];
				$insertArr['discount'] 	= $_POST['discount'];
				$insertArr['price'] 	= $_POST['price'];
				$insertArr['commission'] 	= $_POST['commission'];
				$insertArr['taxed_cost'] 	= $_POST['taxed_cost'];
				$insertArr['varianttype1'] = $_POST['varianttype1'];
				$insertArr['varianttype2'] = $_POST['varianttype2'];
				$insertArr['varianttype3'] = $_POST['varianttype3'];

				$insertArr['order_id'] = uniqid ('MHC'.rand(0,9));;

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
				$arrReturn['leadmanager_id'] = encryptdata($returnVal);

			}else if($leadmanager_id > 0){ // edit the record
				$updateArr['lead_source'] 	= $_POST['lead_source'];
				$updateArr['lead_owner'] 	= $_POST['lead_owner'];
				$updateArr['followup_by'] 	= $_POST['followup_by'];
				$updateArr['job_status']	= $_POST['job_status'];
				$updateArr['lead_stage']    = $_POST['lead_stage'];
				$updateArr['reminder']    = $_POST['reminder'];
				$updateArr['service1_date'] 		=  date("Y-m-d", strtotime($_POST['service1_date']));
				$updateArr['service1_time'] 		= $_POST['service1_time'];
				$updateArr['service2_date'] 		=  date("Y-m-d", strtotime($_POST['service2_date']));
				$updateArr['service2_time'] 		= $_POST['service2_time'];
				$updateArr['service3_date'] 		=  date("Y-m-d", strtotime($_POST['service3_date']));
				$updateArr['service3_time'] 		= $_POST['service3_time'];

				$updateArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				$updateArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
				$updateArr['janitor_deployment'] 		= $_POST['janitor_deployment'];
				$updateArr['client_salutation'] 		= $_POST['client_salutation'];
				$updateArr['client_firstname'] 		= $_POST['client_firstname'];
				$updateArr['client_lastname'] 		= $_POST['client_lastname'];
				$updateArr['client_mobile_no'] 		= $_POST['client_mobile_no'];
				$updateArr['alternate_no'] 		= $_POST['alternate_no'];
				$updateArr['client_email_id'] 		= $_POST['client_email_id'];

				$updateArr['address'] 	= $_POST['address'];
				$updateArr['landmark'] 	= $_POST['landmark'];
				$updateArr['location'] 	= $_POST['location'];
				$updateArr['city'] 	= $_POST['city'];
				$updateArr['state'] 	= $_POST['state'];
				$updateArr['pincode'] 	= $_POST['pincode'];
				$updateArr['additional_note'] 	= $_POST['additional_note'];
				$updateArr['service_inquiry1'] 	= $_POST['service_inquiry1'];
				$updateArr['service_inquiry1_booked'] 	= $_POST['service_inquiry1_booked'];

				$updateArr['service_inquiry2'] 	= $_POST['service_inquiry2'];
				$updateArr['service_inquiry2_booked'] 	= $_POST['service_inquiry2_booked'];
				$updateArr['service_inquiry3'] 	= $_POST['service_inquiry3'];
				$updateArr['service_inquiry3_booked'] 	= $_POST['service_inquiry3_booked'];
				$updateArr['promo_code'] 	= $_POST['promo_code'];
				$updateArr['discount'] 	= $_POST['discount'];
				$updateArr['price'] 	= $_POST['price'];
				$updateArr['commission'] 	= $_POST['commission'];
				$updateArr['taxed_cost'] 	= $_POST['taxed_cost'];
				$updateArr['varianttype1'] = $_POST['varianttype1'];
				$updateArr['varianttype2'] = $_POST['varianttype2'];
				$updateArr['varianttype3'] = $_POST['varianttype3'];

				$whereArr = array('id' => $leadmanager_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call'] = 'update';
				$arrReturn['leadmanager_id'] = encryptdata($leadmanager_id);

			}
			break;
		case "update_leadmanager_status":
		$updateArr['job_status'] 	= $_POST['status'];
		$whereArr = array('id' => $leadmanager_id );
		$returnVal = $modelObj->updateTable($updateArr,$whereArr);
		$arrReturn['result'] = 'success';
		break;
		case "set_lead_reminders":
		$updateArr['reminder'] 	= $_POST['reminder'];
		$whereArr = array('id' => $leadmanager_id );
		$returnVal = $modelObj->updateTable($updateArr,$whereArr);
		$arrReturn['result'] = 'success';
		break;
		case "saveIntoOrder":
			$id = $_POST['leadmanager_id'];
			$returnVal = $modelObj->insertIntoOrder($id);
			$arrReturn['result'] = 'success';
		break;
		case "getPrice":
		$city = $_POST['city'];
		$inq[] = $_POST['inq1'];
		$inq[] = $_POST['inq2'];
		$inq[] = $_POST['inq3'];
		$varianttype[] = $_POST['varianttype1'];
		$varianttype[] = $_POST['varianttype2'];
		$varianttype[] = $_POST['varianttype3'];
		$returnVal = $modelObj->getPriceList($city,$inq,$varianttype);
		$arrReturn['result'] = $returnVal;
		break;
		case "update_leadstage":
		$updateArr['lead_stage'] 	= $_POST['leadstage_id'];
		$whereArr = array('id' => $leadmanager_id );
		$returnVal = $modelObj->updateTable($updateArr,$whereArr);
		$arrReturn['result'] = 'success';
		break;
		case "sendInvoiceMail":
		$row = $modelObj->send_invoice_email($leadmanager_id);
		$arrReturn['result'] = $row;
		break;
		case "getVaiantType":
		$row = $modelObj->get_variant_type($_POST['id']);
		$arrReturn['result'] = $row;
		break;
}
echo json_encode($arrReturn);
