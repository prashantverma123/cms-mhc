<?php
	//echo '<pre>'; print_r($_POST);die;
	include_once('../config.php');
	include_once('variable.php');
	$action   		= isset($_POST['action']) ? $_POST['action'] : '';
	if(!$action)
	$action   		= isset($_GET['action']) ? $_GET['action'] : '';
	$leadmanager_id = isset($_POST['leadmanager_id']) ? $_POST['leadmanager_id'] : '';
	$call 			= isset($_POST['call']) ? $_POST['call'] : '';
	$memcache_leadstage = $memcache->get('leadstage');
	if(!$memcache_leadstage)
	$memcache_leadstage = $dashboardObj->leadstage();
	$memcache_total_tax = $memcache->get('total_tax');
	if(!$memcache_total_tax)
	$memcache_total_tax = $dashboardObj->total_tax();

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
				//$insertArr['lead_stage']    = $_POST['lead_stage'];
				$insertArr['lead_stage']    = 1;
				if($_POST['reminder']!=''){
					$insertArr['reminder'] = date("Y-m-d", strtotime($_POST['reminder']));
				}else{
					$insertArr['reminder'] = null;
				}
				
				// $insertArr['additional_note'] 	= $_POST['additional_note'];
				// $insertArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				// $insertArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
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
				$insertArr['order_id'] = uniqid ('MHC'.rand(0,9));

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
						$stmt = "INSERT INTO service (`id`, `leadmanager_id`, `lead_stage`,`service_inquiry`, `service_date`, `service_time`, `contract_start_date`,`contract_end_date`,`no_of_service`,`service_price`,`client_payment_expected`,`partner_receivable`,`partner_payable`, `service_discount`, `service_booked`, `varianttype_id`, `sqft`, `frequency`,`is_amc`,`service_duration`) VALUES ";
						//$order_stmt = "INSERT INTO `order` (`id`, `leadmanager_id`, `name`, `lead_source`, `mobile_no`, `alternate_no`, `email_id`, `address`, `landmark`, `location`, `city`, `state`, `pincode`, `service`, `service_date`, `service_date2`, `service_date3`, `service_time`, `teamleader_deployment`, `supervisor_deployment`, `janitor_deployment`, `price`, `commission`, `taxed_cost`, `job_start`, `job_end`, `job_status`, `order_feedback`, `order_id`, `payment_status`, `payment_mode`, `payment_info`, `deployment`, `invoice_id`, `billing_name`, `billing_email`, `billing_address`, `billing_name2`, `billing_address2`, `billing_email2`, `billing_amount2`, `received_amount`, `invoice_sent`, `travel_cost`, `material_cost`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES ";
					
						foreach ($_POST['service_inquiry'] as $k =>$service) {
							$orderArr = array();
							if($_POST['invoice_type'] == 0){
								$invoice_id = $modelObj->generateInvoiceId($_POST['client_firstname'],$_POST['client_lastname'],$_POST['service_inquiry'],$_POST['city'],$returnVal);
							}else{
								$invoice_id = $modelObj->generateInvoiceId($_POST['client_firstname'],$_POST['client_lastname'],array($_POST['service_inquiry'][$k]),$_POST['city'],$returnVal);
							}
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
								$lead_stage = $_POST['lead_stage'][$k];
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
								$stmt .= "('','$returnVal','$lead_stage', '$service_inquiry', '$service_date', '$service_time','$contract_start','$contract_end', '$no_of_service','$service_price','$client_pay_expected','$partner_receivable','$partner_payable', '$service_discount', '$inquiry_booked', '$varianttype', '$sqft', '$frequency','$is_amc','$service_duration')";
								if(count($_POST['service_inquiry']) > $k+1){
									$stmt .= ",";
								}
								//when lead service closed ,insert into order table
								if($memcache_leadstage[$lead_stage] == 'Closed')
								{
									$orderArr = array();
									$orderArr['leadmanager_id'] = $returnVal;
									$orderArr['parent_id'] = $service_duration>1?-1:0;
									$orderArr['name'] = $_POST['client_firstname'];
									$orderArr['lead_source'] = $_POST['lead_source'];
									$orderArr['mobile_no'] = $_POST['client_mobile_no'];
									$orderArr['alternate_no'] = $_POST['alternate_no'];
									$orderArr['email_id'] = $_POST['client_email_id'];
									$orderArr['address'] = $_POST['address'];
									$orderArr['landmark'] = $_POST['landmark'];
									$orderArr['location'] = $_POST['location'];
									$orderArr['city'] = $_POST['city'];
									$orderArr['pincode'] = $_POST['pincode'];
									$orderArr['service'] = $_POST['service_inquiry'][$k];
									$orderArr['service_date'] = $service_date;
									$orderArr['service_time'] = $service_time;
									/********comes from pricelist*******/
									$orderArr['teamleader_deployment'] = 1;
									$orderArr['supervisor_deployment'] = 1;
									$orderArr['janitor_deployment'] = 1;
									$orderArr['price'] = $_POST['service_price'][$k]/1+($memcache_total_tax/100);
									$orderArr['taxed_cost'] = $_POST['service_price'][$k];
									$orderArr['billing_name'] = $_POST['client_firstname'];
									$orderArr['billing_email'] = $_POST['client_email_id'];
									$orderArr['billing_address'] = $_POST['address'];
									$orderArr['billing_name2'] = $_POST['lead_stage'][$k];
									$orderArr['billing_address2'] = '';
									$orderArr['billing_email2'] = '';
									$orderArr['billing_amount2'] = $_POST['partner_receivable'][$k];
									$orderArr['author_id']			= $_SESSION['tmobi']['UserId'];
									$orderArr['author_name']		= $_SESSION['tmobi']['AdminName'];
									$orderArr['insert_date']		= date('Y-m-d H:i:s');
									$orderArr['status']= 0;
									$orderArr['mhcclient_id'] = $mhcclientid;
									$orderArr['order_id'] = $insertArr['order_id'];
									$orderArr['invoice_id'] = $invoice_id;
									$orderArr['ip']= getIP();
								}
								//print_r($orderArr);exit();
								if($memcache_leadstage[$lead_stage] == 'Closed' && $is_amc == ''){
									$orderID = $modelObj->insert_order($orderArr);
									if ($service_duration>1) {
										for ($i=0; $i < $service_duration; $i++) {
											$orderArr['parent_id'] = $orderID;
											$orderArr['child_name'] = 'Day'.($i +1);
											$child_response = $modelObj->insert_order($orderArr);
										}
									}
								}
								elseif($memcache_leadstage[$lead_stage] == 'Closed' && $is_amc == '1'){
									$orderArr['is_amc'] = 1;
									$no_of_service_times = floor($frequency*$no_of_service);
									$diff= date_diff(date_create($contract_start),date_create($contract_end));
									$date_diff =  $diff->format("%a");
									
									$service_diff_no = floor($date_diff/$no_of_service_times);
									$start_date = $contract_start;
									$end_date = $contract_end;
									if ($frequency!='' && $no_of_service!='') {
										if($frequency == 5){
											if($start_date <= $end_date){ //for mon to fri
												$time =strtotime($start_date);
												if (date("N", $time) < 6) { // if M-F
													if(date("Y-m-d", $time) <= $end_date){
									            		$orderArr['service_date'] = date("Y-m-d", $time);
									            		$orderID = $modelObj->insert_order($orderArr);
									            	}
									            	 $j = 1;
								            	}else{
								            		 $j = 0;
								            	}
									      		while ($j < $no_of_service_times) { //loop through until reached the amount of weekdays
											            $time = strtotime("+1 day", $time); //Increase day by 1
											            if (date("N", $time) < 6) { // if M-F
											            	if(date("Y-m-d", $time) <= $end_date){
											            		$orderArr['service_date'] = date("Y-m-d", $time);
											            		$orderID = $modelObj->insert_order($orderArr);
											            	}
											                $j++;
											            }
									        	}
											}
										}elseif($frequency == 6){ //for mon to sat
											if($start_date <= $end_date){
												$time =strtotime($start_date);
												if (date("N", $time) < 7) { // if M-Sat
													if(date("Y-m-d", $time) <= $end_date){
									            		$orderArr['service_date'] = date("Y-m-d", $time);
									            		$orderID = $modelObj->insert_order($orderArr);
									            	}
									            	 $j = 1;
								            	}else{
								            		 $j = 0;
								            	} 
									      		while ($j < $no_of_service_times) { //loop through until reached the amount of weekdays
											            $time = strtotime("+1 day", $time); //Increase day by 1
											            if (date("N", $time) < 7) { //test if M-Sat
											            	if(date("Y-m-d", $time) <= $end_date){
											            		$orderArr['service_date'] = date("Y-m-d", $time);
											            		$orderID = $modelObj->insert_order($orderArr);
											            	}
											                $j++; //Increase by 1
											            }
									        	}
											}
										}
										elseif($frequency == 2){ //for sat to sun
											if($start_date <= $end_date){
												$time =strtotime($start_date);
												if (date("N", $time) < 7) { // if M-F
													if(date("Y-m-d", $time) <= $end_date){
									            		
									            	}else{
									            		$orderArr['service_date'] = date("Y-m-d", $time);
									            		$orderID = $modelObj->insert_order($orderArr);
									            	}
									            	 $j = 1;
								            	}else{
								            		 $j = 0;
								            	}
									      		while ($j < $no_of_service_times) { //loop through until reached the amount of weekdays
											            $time = strtotime("+1 day", $time); //Increase day by 1
											            if (date("N", $time) < 6) { //test if Sat-Sun
											            	
											                //Increase by 1
											            }else{
											            	if(date("Y-m-d", $time) <= $end_date){
											            		$orderArr['service_date'] = date("Y-m-d", $time);
											            		$orderID = $modelObj->insert_order($orderArr);
											            	}
											            	 $j++;
											            }
									        	}
											}
										}elseif($frequency == -1){ //for sat to sun
											$diff= date_diff(date_create($contract_start),date_create($contract_end));
											$date_diff =  $diff->format("%a");
											$service_diff_no = floor($date_diff/$no_of_service);
											for($i = 1;$i<=floor($no_of_service);$i++){
												if($start_date <= $end_date){
													$start_date = date('Y-m-d',strtotime($start_date ."+$service_diff_no days"));
													if($start_date <= $end_date){
														$orderArr['service_date'] = $start_date;
														$orderID = $modelObj->insert_order($orderArr);
													}
													else{
														$orderArr['service_date'] = $end_date;
														$orderID = $modelObj->insert_order($orderArr);
													}
												}
											}
										}else{
											$diff= date_diff(date_create($contract_start),date_create($contract_end));
											$date_diff =  $diff->format("%a");
											$service_diff_no = floor($date_diff/$no_of_service);
											for($i = 1;$i<=floor($no_of_service);$i++){
												if($start_date <= $end_date){
													$start_date = date('Y-m-d',strtotime($start_date ."+$service_diff_no days"));
													if($start_date <= $end_date){
														$orderArr['service_date'] = $start_date;
														//$start_date = $start_date +1;
														$orderID = $modelObj->insert_order($orderArr);
													}
													else{
														$orderArr['service_date'] = $end_date;
														$orderID = $modelObj->insert_order($orderArr);
													}
												}
											}
										}
									}
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
				//$updateArr['lead_stage']    = $_POST['lead_stage'];
				$updateArr['lead_stage']    = 1;
				if($_POST['reminder']!=''){
					$updateArr['reminder'] = date("Y-m-d", strtotime($_POST['reminder']));
				}else{
					$updateArr['reminder'] = null;
				}
				$updateArr['teamLeader_deployment'] 		= $_POST['teamLeader_deployment'];
				$updateArr['supervisor_deployment'] 		= $_POST['supervisor_deployment'];
				$updateArr['janitor_deployment'] 		= $_POST['janitor_deployment'];
				$updateArr['additional_note'] 	= $_POST['additional_note'];
				//$updateArr['service_duration'] = $_POST['service_duration'][$k];
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
						$stmt = "INSERT INTO service (`id`, `leadmanager_id`,`lead_stage`, `service_inquiry`, `service_date`, `service_time`, `contract_start_date`,`contract_end_date`,`no_of_service`,`service_price`,`client_payment_expected`,`partner_receivable`,`partner_payable`, `service_discount`, `service_booked`, `varianttype_id`, `sqft`, `frequency`,`is_amc`,`service_duration`) VALUES ";
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
									$serviceUpdateArr['contract_start_date'] =date("Y-m-d", strtotime($_POST['contract_start_date'][$k]));
								}else{
									$serviceUpdateArr['contract_start_date'] = null;
								}
								if($_POST['contract_end_date'][$k]!=''){
									$serviceUpdateArr['contract_start_date'] =date("Y-m-d", strtotime($_POST['contract_end_date'][$k]));
								}else{
									$serviceUpdateArr['contract_start_date'] = null;
								}
								$serviceUpdateArr['varianttype_id'] = $_POST['varianttype'][$k];
								$serviceUpdateArr['sqft'] 	= $_POST['sqft'][$k];
								$serviceUpdateArr['client_payment_expected'] = $_POST['client_payment_expected'][$k];
								$serviceUpdateArr['partner_payable'] = $_POST['partner_payable'][$k];
								$serviceUpdateArr['partner_receivable'] = $_POST['partner_receivable'][$k];
								$serviceUpdateArr['is_amc'] = $_POST['is_amc'.$k];
								$serviceUpdateArr['no_of_service'] = $_POST['no_of_service'][$k];
								$serviceUpdateArr['service_duration'] = $_POST['service_duration'][$k];
								$serviceUpdateArr['lead_stage'] = $_POST['lead_stage'][$k];
								$serviceWhereArr = array('id' => $_POST['service_id'][$k] );
								$modelObj->updateServiceTable($serviceUpdateArr,$serviceWhereArr);
								$getservice = $modelObj->getServiceById($_POST['service_id'][$k]);
								$orderArr = array();
									$orderArr['leadmanager_id'] = $returnVal;
									$orderArr['parent_id'] = $service_duration>1?-1:0;
									$orderArr['name'] = $_POST['client_firstname'];
									$orderArr['lead_source'] = $_POST['lead_source'];
									$orderArr['mobile_no'] = $_POST['client_mobile_no'];
									$orderArr['alternate_no'] = $_POST['alternate_no'];
									$orderArr['email_id'] = $_POST['client_email_id'];
									$orderArr['address'] = $_POST['address'];
									$orderArr['landmark'] = $_POST['landmark'];
									$orderArr['location'] = $_POST['location'];
									$orderArr['city'] = $_POST['city'];
									$orderArr['pincode'] = $_POST['pincode'];
									$orderArr['service'] = $_POST['service_inquiry'][$k];
									$orderArr['service_date'] = $service_date;
									$orderArr['service_time'] = $service_time;
									/********comes from pricelist*******/
									$orderArr['teamleader_deployment'] = 1;
									$orderArr['supervisor_deployment'] = 1;
									$orderArr['janitor_deployment'] = 1;
									$orderArr['price'] = $_POST['service_price'][$k]/1+($memcache_total_tax/100);
									$orderArr['taxed_cost'] = $_POST['service_price'][$k];
									$orderArr['billing_name'] = $_POST['client_firstname'];
									$orderArr['billing_email'] = $_POST['client_email_id'];
									$orderArr['billing_address'] = $_POST['address'];
									$orderArr['billing_name2'] = $_POST['lead_stage'][$k];
									$orderArr['billing_address2'] = '';
									$orderArr['billing_email2'] = '';
									$orderArr['billing_amount2'] = $_POST['partner_receivable'][$k];
									$orderArr['order_id'] = $_POST['order_id'];
									$orderArr['invoice_id'] = $_POST['invoice_id'];
									$orderArr['author_id']			= $_SESSION['tmobi']['UserId'];
									$orderArr['author_name']		= $_SESSION['tmobi']['AdminName'];
									$orderArr['insert_date']		= date('Y-m-d H:i:s');
									$orderArr['status']= 0;
									$orderArr['mhcclient_id'] = $_POST['mhcclient_id'];
									$orderArr['ip']= getIP();
								if($memcache_leadstage[$getservice[0]['lead_stage']] == 'Closed'){ //update order
									$whereUpdateOrder = array('');
								}else{ //entry into order table

								}
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
								$service_duration = $_POST['service_duration'][$k];
								$lead_stage = $_POST['lead_stage'][$k];
								$is_amc = $_POST['is_amc'][$k];
								$stmt .= "('','$leadmanager_id','$lead_stage', '$service_inquiry', '$service_date', '$service_time','$contract_start','$contract_end', '$no_of_service','$service_price','$client_pay_expected','$partner_receivable','$partner_payable', '$service_discount', '$inquiry_booked', '$varianttype', '$sqft', '$frequency','$is_amc','$service_duration')";
								if($count > $k+1){
									$stmt .= ",";
								}
								//INSERT ENTRY INTO ORDER
								if($memcache_leadstage[$lead_stage] == 'Closed'){
									$orderArr = array();
									$orderArr['leadmanager_id'] = $returnVal;
									$orderArr['parent_id'] = $service_duration>1?-1:0;
									$orderArr['name'] = $_POST['client_firstname'];
									$orderArr['lead_source'] = $_POST['lead_source'];
									$orderArr['mobile_no'] = $_POST['client_mobile_no'];
									$orderArr['alternate_no'] = $_POST['alternate_no'];
									$orderArr['email_id'] = $_POST['client_email_id'];
									$orderArr['address'] = $_POST['address'];
									$orderArr['landmark'] = $_POST['landmark'];
									$orderArr['location'] = $_POST['location'];
									$orderArr['city'] = $_POST['city'];
									$orderArr['pincode'] = $_POST['pincode'];
									$orderArr['service'] = $_POST['service_inquiry'][$k];
									$orderArr['service_date'] = $service_date;
									$orderArr['service_time'] = $service_time;
									/********comes from pricelist*******/
									$orderArr['teamleader_deployment'] = 1;
									$orderArr['supervisor_deployment'] = 1;
									$orderArr['janitor_deployment'] = 1;
									$orderArr['price'] = $_POST['service_price'][$k]/1+($memcache_total_tax/100);
									$orderArr['taxed_cost'] = $_POST['service_price'][$k];
									$orderArr['billing_name'] = $_POST['client_firstname'];
									$orderArr['billing_email'] = $_POST['client_email_id'];
									$orderArr['billing_address'] = $_POST['address'];
									$orderArr['billing_name2'] = $_POST['lead_stage'][$k];
									$orderArr['billing_address2'] = '';
									$orderArr['billing_email2'] = '';
									$orderArr['billing_amount2'] = $_POST['partner_receivable'][$k];
									$orderArr['order_id'] = $_POST['order_id'];
									$orderArr['invoice_id'] = $_POST['invoice_id'];
									$orderArr['author_id']			= $_SESSION['tmobi']['UserId'];
									$orderArr['author_name']		= $_SESSION['tmobi']['AdminName'];
									$orderArr['insert_date']		= date('Y-m-d H:i:s');
									$orderArr['status']= 0;
									$orderArr['mhcclient_id'] = $mhcclientid;
									$orderArr['ip']= getIP();
									
								}
								if($memcache_leadstage[$lead_stage] == 'Closed' && $is_amc == ''){
									$orderID = $modelObj->insert_order($orderArr);
									if ($service_duration>1) {
										for ($i=0; $i < $service_duration; $i++) {
											$orderArr['parent_id'] = $orderID;
											$orderArr['child_name'] = 'Day'.($i +1);
											$child_response = $modelObj->insert_order($orderArr);
										}

									}
								}
								elseif($memcache_leadstage[$lead_stage] == 'Closed' && $is_amc == '1'){
									$days = floor($frequency/$no_of_service);
									$diff= date_diff(date_create($contract_start),date_create($contract_end));
									$date_diff =  $diff->format("%a");
									$nos = $date_diff/$days;
									$start_date = $contract_start;
									$end_date = $contract_end;
									if ($frequency!='' && $no_of_service!='') {
										for($i = 1;$i<=floor($nos);$i++){
											if($start_date <= $end_date){
												$start_date = date('Y-m-d',strtotime($start_date ."+$days days"));
												if($start_date <= $end_date){
													$orderArr['service_date'] = $start_date;
													$orderID = $modelObj->insert_order($orderArr);
												}
												else{
													$orderArr['service_date'] = $end_date;
													$orderID = $modelObj->insert_order($orderArr);
												}
											}
										}
									}
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
		case "getServicesList":
		$row = $modelObj->getServiceDetailsforLead($_POST['leadmanager_id']);
		$arrReturn = $row;
		break;
}
echo json_encode($arrReturn);
