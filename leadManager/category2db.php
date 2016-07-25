<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	if(!$action)
	$action   		= isset($_GET['action']) ? $_GET['action'] : '';
	$leadmanager_id = isset($_POST['leadmanager_id']) ? $_POST['leadmanager_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
switch($action){
	case 'delete_leadmanager':
				$updateArr['status'] = '-1';
				$whereArr = array('id' => $leadmanager_id );
				$returnVal = $modelObj->updateTable($updateArr,$whereArr);

	break;
	case 'saveLeadManager':
			//print_r($_POST);exit;
			if($_POST['mhcclient_id'] == ''){
				$clientArr['client_salutation'] 	= $_POST['client_salutation'];
				$clientArr['client_firstname'] 		= $_POST['client_firstname'];
				$clientArr['client_lastname'] 		= $_POST['client_lastname'];
				$clientArr['client_mobile_no'] 		= $_POST['client_mobile_no'];
				$clientArr['alternate_no'] 			= $_POST['alternate_no'];
				$clientArr['client_email_id'] 		= $_POST['client_email_id'];
				$clientArr['address'] 				= $_POST['address'];
				$clientArr['landmark'] 				= $_POST['landmark'];
				$clientArr['location'] 				= $_POST['location'];
				$clientArr['city'] 					= $_POST['city'];
				$clientArr['state'] 				= $_POST['state'];
				$clientArr['pincode'] 				= $_POST['pincode'];
				$mhcclientid = $modelObj->insertClientTable($clientArr);
	
			}else{
				$clientArr['client_salutation'] = $_POST['client_salutation'];
				$clientArr['client_firstname'] 	= $_POST['client_firstname'];
				$clientArr['client_lastname'] 	= $_POST['client_lastname'];
				$clientArr['client_mobile_no'] 	= $_POST['client_mobile_no'];
				$clientArr['alternate_no'] 		= $_POST['alternate_no'];
				$clientArr['client_email_id'] 	= $_POST['client_email_id'];
				$clientArr['address'] 			= $_POST['address'];
				$clientArr['landmark'] 			= $_POST['landmark'];
				$clientArr['location'] 			= $_POST['location'];
				$clientArr['city'] 				= $_POST['city'];
				$clientArr['state'] 			= $_POST['state'];
				$clientArr['pincode'] 			= $_POST['pincode'];
				$where 							= array('id'=>$_POST['mhcclient_id']);
				$mhcclientid	= $modelObj->updateClientTable($clientArr,$where);
			}
			if($mhcclientid){
				//$deletewhere = array('mhcclient_id'=>$mhcclientid);
				//$modelObj->deleteAddressTable($deletewhere);
				if(count($_POST['address1']) > 0){
					foreach ($_POST['address1'] as $address) {
						if($address != ''){
							$addressArr = array('mhcclient_id'=>$mhcclientid,'address'=>$address);
							$mhcclientid = $modelObj->insertAddressTable($addressArr);
						}
					}
				}
			}

		if($leadmanager_id == '' ){ //add new record
				$insertArr['lead_source'] 	= $_POST['lead_source'];
				$insertArr['lead_owner'] 	= $_POST['lead_owner'];
				$insertArr['followup_by'] 	= $_POST['followup_by'];
				$insertArr['job_status']	= 'pending';
				$insertArr['lead_stage']    = $_POST['lead_stage'];
				if($_POST['reminder']!=''){
					$insertArr['reminder'] = date("Y-m-d", strtotime($_POST['reminder']));
				}else{
					$insertArr['reminder'] = null;
				}
				
				$insertArr['additional_note'] 	= $_POST['additional_note'];
				$insertArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				$insertArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
				$insertArr['janitor_deployment'] 		= $_POST['janitor_deployment'];
				$insertArr['promo_code'] 	= $_POST['promo_code'];
				$insertArr['discount'] 	= $_POST['discount'];
				$insertArr['price'] 	= $_POST['price'];
				$insertArr['invoice_mode'] 	= $_POST['invoice_mode'];

				if($_POST['invoice_mode'] == 'P')
				$insertArr['lead_partner_receivable'] 	= $_POST['lead_partner_receivable'];
				
				$insertArr['lead_partner_payable'] 	= $_POST['lead_partner_payable'];
				$insertArr['lead_client_payment'] 	= $_POST['lead_client_payment'];
				
				//$insertArr['commission'] 	= $_POST['commission'];
				$insertArr['taxed_cost'] 	= $_POST['taxed_cost'];
				$insertArr['invoice_type'] 	= $_POST['invoice_type'];
				$insertArr['is_reminder']    = $_POST['is_reminder'];
				$insertArr['order_id'] = uniqid ('MHC'.rand(0,9));;

				$insertArr['author_id']			= $_SESSION['tmobi']['UserId'];
				$insertArr['author_name']		= $_SESSION['tmobi']['AdminName'];
				$insertArr['insert_date']		= date('Y-m-d H:i:s');
				$insertArr['status']= 0;
				$insertArr['ip']= getIP();
				$insertArr['mhcclient_id'] = $mhcclientid;
				//print_r($insertArr);exit;
				$returnVal = $modelObj->insertTable($insertArr);

				/***SERVICE STARTS HERE***/
				if(count($_POST['service_inquiry']) > 0):
						$stmt = "INSERT INTO service (`id`, `leadmanager_id`, `service_inquiry`, `service_date`, `service_time`, `contract_start_date`,`contract_end_date`,`no_of_service`,`service_price`,`client_payment_expected`,`partner_receivable`,`partner_payable`, `service_discount`, `service_booked`, `varianttype_id`, `sqft`, `frequency`,`is_amc`,`service_duration`) VALUES ";
						foreach ($_POST['service_inquiry'] as $k =>$service) {
							if($_POST['service_inquiry'][$k] != '' && $_POST['varianttype'][$k]!=''):
								$service_inquiry 	= $_POST['service_inquiry'][$k];
								$service_price	= $_POST['service_price'][$k];
								$service_discount 	= $_POST['service_discount'][$k];
								$frequency	= $_POST['frequency'][$k];
								$inquiry_booked 	= $_POST['service_inquiry_booked'.$k];
								$client_pay_expected = $_POST['client_payment_expected'][$k];
								$partner_payable = $_POST['partner_payable'][$k];
								$no_of_service = $_POST['no_of_service'][$k];
								$service_duration = $_POST['service_duration'][$k];
								$partner_receivable = $_POST['partner_receivable'][$k];
								if($_POST['contract_start_date'][$k]!=''){
									$contract_start =date("Y-m-d", strtotime($_POST['contract_start_date'][$k]));
								}else{
									$contract_start = null;
								}
								if($_POST['contract_end_date'][$k]!=''){
									$contract_end =date("Y-m-d", strtotime($_POST['contract_end_date'][$k]));
								}else{
									$contract_end = null;
								}
								$is_amc = $_POST['is_amc'.$k];
								if($_POST['service_date'][$k]!=''){
									$service_date = date("Y-m-d", strtotime($_POST['service_date'][$k]));
									$service_time		= $_POST['service_time'][$k];
								}
								else{
									$service_date= null;
									$service_time = null;
								}
								$varianttype = $_POST['varianttype'][$k];
								$sqft 	= $_POST['sqft'][$k];
								$stmt .= "('','$returnVal', '$service_inquiry', '$service_date', '$service_time','$contract_start','$contract_end', '$no_of_service','$service_price','$client_pay_expected','$partner_receivable','$partner_payable', '$service_discount', '$inquiry_booked', '$varianttype', '$sqft', '$frequency','$is_amc','$service_duration')";
								if(count($_POST['service_inquiry']) > $k+1){
									$stmt .= ",";
								}
							endif;
						}
						//echo $stmt;exit;
						$services = $modelObj->insertServiceTable($stmt);
				endif;
				/***SERVICE ENDS HERE***/
				//die;
				$arrReturn['result'] = 'success';
				$arrReturn['action'] = 'saveEventName';
				$arrReturn['call']   = 'add';
				$arrReturn['leadmanager_id'] = encryptdata($returnVal);

			}else if($leadmanager_id > 0){ // edit the record
				$updateArr['mhcclient_id'] = $mhcclientid;
				$updateArr['lead_source'] 	= $_POST['lead_source'];
				$updateArr['lead_owner'] 	= $_POST['lead_owner'];
				$updateArr['followup_by'] 	= $_POST['followup_by'];
				//$updateArr['job_status']	= $_POST['job_status'];
				$updateArr['lead_stage']    = $_POST['lead_stage'];
				if($_POST['reminder']!=''){
					$updateArr['reminder'] = date("Y-m-d", strtotime($_POST['reminder']));
				}else{
					$updateArr['reminder'] = null;
				}
				$updateArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				$updateArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
				$updateArr['janitor_deployment'] 		= $_POST['janitor_deployment'];
				$updateArr['additional_note'] 	= $_POST['additional_note'];
				$updateArr['service_duration'] = $_POST['service_duration'][$k];
				if(count($_POST['service_inquiry']) > 0):
						$count =count($_POST['service_inquiry']);
						if(in_array(null, $_POST['service_inquiry'])){
							$count =0;
							foreach ($_POST['service_inquiry'] as $tt){
								if($tt!=''){
									$count = $count+1;
								}
							}
						}
						$stmt = "INSERT INTO service (`id`, `leadmanager_id`, `service_inquiry`, `service_date`, `service_time`, `contract_start_date`,`contract_end_date`,`no_of_service`,`service_price`,`client_payment_expected`,`partner_receivable`,`partner_payable`, `service_discount`, `service_booked`, `varianttype_id`, `sqft`, `frequency`,`is_amc`,`service_duration`) VALUES ";
						//$count = count($_POST['service_inquiry']);

						foreach ($_POST['service_inquiry'] as $k =>$service) {
							
							$serviceUpdateArr = array();
							if($_POST['service_id'][$k]!=''){
								$serviceUpdateArr['service_inquiry'] 	= $_POST['service_inquiry'][$k];
								$serviceUpdateArr['service_price']	= $_POST['service_price'][$k];
								$serviceUpdateArr['service_discount'] 	= $_POST['service_discount'][$k];
								$serviceUpdateArr['frequency']	= $_POST['frequency'][$k];
								$serviceUpdateArr['service_booked'] 	= $_POST['service_inquiry_booked'.$k];

								if($_POST['service_date'][$k]!=''){
									$serviceUpdateArr['service_date'] = date("Y-m-d", strtotime($_POST['service_date'][$k]));
									$serviceUpdateArr['service_time']		= $_POST['service_time'][$k];
								}
								else{
									$serviceUpdateArr['service_date']= null;
									$serviceUpdateArr['service_time'] = null;
								}
								if($_POST['contract_start_date'][$k]!=''){
									$serviceUpdateArr['contract_start'] =date("Y-m-d", strtotime($_POST['contract_start_date'][$k]));
								}else{
									$serviceUpdateArr['contract_start'] = null;
								}
								if($_POST['contract_end_date'][$k]!=''){
									$serviceUpdateArr['contract_end'] =date("Y-m-d", strtotime($_POST['contract_end_date'][$k]));
								}else{
									$serviceUpdateArr['contract_end'] = null;
								}
								$serviceUpdateArr['varianttype_id'] = $_POST['varianttype'][$k];
								$serviceUpdateArr['sqft'] 	= $_POST['sqft'][$k];
								$serviceUpdateArr['client_payment_expected'] = $_POST['client_payment_expected'][$k];
								$serviceUpdateArr['partner_payable'] = $_POST['partner_payable'][$k];
								$serviceUpdateArr['partner_receivable'] = $_POST['partner_receivable'][$k];
								$serviceUpdateArr['is_amc'] = $_POST['is_amc'.$k];
								$serviceUpdateArr['no_of_service'] = $_POST['no_of_service'][$k];
								$serviceWhereArr = array('id' => $_POST['service_id'][$k] );
								$modelObj->updateServiceTable($serviceUpdateArr,$serviceWhereArr);
							}else{	
							if($_POST['service_inquiry'][$k] != '' && $_POST['varianttype'][$k]!=''):
								$service_inquiry 	= $_POST['service_inquiry'][$k];
								$service_price	= $_POST['service_price'][$k];
								$service_discount 	= $_POST['service_discount'][$k];
								$frequency	= $_POST['frequency'][$k];
								$inquiry_booked 	= $_POST['service_inquiry_booked'.$k];
								if($_POST['service_date'][$k]!=''){
									$service_date = date("Y-m-d", strtotime($_POST['service_date'][$k]));
									$service_time		= $_POST['service_time'][$k];
								}
								else{
									$service_date= null;
									$service_time = null;
								}
								if($_POST['contract_start_date'][$k]!=''){
									$contract_start =date("Y-m-d", strtotime($_POST['contract_start_date'][$k]));
								}else{
									$contract_start = null;
								}
								if($_POST['contract_end_date'][$k]!=''){
									$contract_end =date("Y-m-d", strtotime($_POST['contract_end_date'][$k]));
								}else{
									$contract_end = null;
								}
								$varianttype = $_POST['varianttype'][$k];
								$sqft 	= $_POST['sqft'][$k];
								$client_pay_expected = $_POST['client_payment_expected'][$k];
								$no_of_service = $_POST['no_of_service'];
								$partner_payable = $_POST['partner_payable'][$k];
								$partner_receivable = $_POST['partner_receivable'][$k];
								$is_amc = $_POST['is_amc'.$k];
								$stmt .= "('','$leadmanager_id', '$service_inquiry', '$service_date', '$service_time','$contract_start','$contract_end', '$no_of_service','$service_price','$client_pay_expected','$partner_receivable','$partner_payable', '$service_discount', '$inquiry_booked', '$varianttype', '$sqft', '$frequency','$is_amc','$service_duration')";
								if($count > $k+1){
									$stmt .= ",";
								}
							endif;
							}
						}
						$services = $modelObj->insertServiceTable($stmt);
				endif;
				/***SERVICE ENDS HERE***/
				$updateArr['promo_code'] 	= $_POST['promo_code'];
				$updateArr['discount'] 	= $_POST['discount'];
				$updateArr['price'] 	= $_POST['price'];
				$updateArr['invoice_mode'] 	= $_POST['invoice_mode'];
				if($_POST['invoice_mode'] == 'P')
				$updateArr['lead_partner_receivable'] 	= $_POST['lead_partner_receivable'];

				$updateArr['lead_partner_payable'] 	= $_POST['lead_partner_payable'];
				$updateArr['lead_client_payment'] 	= $_POST['lead_client_payment'];
				//$updateArr['commission'] 	= $_POST['commission'];
				$updateArr['taxed_cost'] 	= $_POST['taxed_cost'];
				$updateArr['invoice_type'] 	= $_POST['invoice_type'];
				/*$updateArr['varianttype1'] = $_POST['varianttype1'];
				$updateArr['varianttype2'] = $_POST['varianttype2'];
				$updateArr['varianttype3'] = $_POST['varianttype3'];*/
				$updateArr['is_reminder']    = $_POST['is_reminder'];
				$updateArr['update_date']		= date('Y-m-d H:i:s');
				//print_r($updateArr);exit;
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
		if($_POST['reminder']!=''){
			$updateArr['reminder'] = date("Y-m-d", strtotime($_POST['reminder']));
		}else{
			$updateArr['reminder'] = null;
		}
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
		$varianttype[] = $_POST['varianttype1'];
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
		$row = $modelObj->get_variant_type($_POST['id'],$_POST['service']);
		$arrReturn['result'] = $row;
		break;
		case "getClientFirstname":
		$row = $modelObj->get_client_firstname($_GET['term']);
		$arrReturn = $row;
		break;
		case "getClientLastname":
		$row = $modelObj->get_client_lastname($_GET['term']);
		$arrReturn = $row;
		break;
		case "getClientMobile":
		$row = $modelObj->get_mhcclient_mobile($_POST['mobile_no']);
		$arrReturn = $row;
		break;
		case "getAddress":
		$row = $modelObj->getAddressTable($_POST['mhcclient_id']);
		$arrReturn = $row;
		break;
}
echo json_encode($arrReturn);
