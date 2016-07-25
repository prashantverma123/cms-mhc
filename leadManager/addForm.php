<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
if($leadmanager_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($leadmanager_id));
	$data = (array)$returned_data[0];
	$mhcclient = $modelObj->get_mhcclient($data['mhcclient_id']);
	$services = $modelObj->getServiceTable($leadmanager_id);
	if(count($mhcclient) > 0)
	$data = array_merge($data,$mhcclient[0]);
}
?>
<?php 
if($memcacheConn):
$cities = $memcache->get('city');
$leadsources = $memcache->get('leadsource');
$lead_dropdown = $memcache->get('pricelist_dropdown');
$leadstage = $memcache->get('leadstage');
$pricelist = $memcache->get('pricelist');
$varianttype = $memcache->get('varianttype');
$taxes = $memcache->get('taxes');
$total_tax = $memcache->get('total_tax');
else:
$cities = $dashboardObj->city();
$leadsources = $dashboardObj->leadsource();
$lead_dropdown = $dashboardObj->pricelistAll();
$leadstage = $dashboardObj->leadstage();
$pricelist = $dashboardObj->pricelist();
$varianttype = $dashboardObj->varianttype();
$taxes = $dashboardObj->taxes();
$total_tax = $dashboardObj->total_tax();
endif;
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>Lead Manager</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_lead_manager" id="frm_lead_manager">
		 <input type="hidden" name="action" value="saveLeadManager"/>
		 <input type="hidden" name="leadmanager_id" value="<?php print $leadmanager_id;?>"/>
			  <!--  <h3 class="form-section">Lead Manager</h3> -->
			
				<div>
					<div class="row-fluid" style="background-color:#6d6d6d;margin-bottom:15px;">
					<h3 style="padding-left:10px">Client Details</h3>
				</div>
				<div class="row-fluid">
					<div class="span4 ">
	 				<div class="control-group">
	 				 <label class="control-label"> Salutation <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<label class="checkbox-inline" style="float:left;width:50px"><input type="radio" name="client_salutation" value="Mr" <?php if($data['client_salutation'] == 'Mr'): echo "checked"; else: ""; endif; ?>>Mr.</label>
	 						<label class="checkbox-inline" style="float:left;width:50px"><input type="radio" name="client_salutation" value="Mr" <?php if($data['client_salutation'] == 'Ms'): echo "checked"; else: ""; endif; ?>>Ms.</label>
	 						<label class="checkbox-inline" style="float:left;width:50px"><input type="radio" name="client_salutation" value="Mr" <?php if($data['client_salutation'] == 'Dr'): echo "checked"; else: ""; endif; ?>>Dr.</label>
	 						<span class="help-block" id="client_salutation_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span4 ">
				 <div class="control-group">
					<label class="control-label">Firstname <span class="required">*</span></label>
					<div class="controls">
						<div class="ui-widget">
						 <input tabindex="6" type="text" placeholder="Please Enter Firstname" value="<?php echo isset($data)?$data['client_firstname']:''; ?>" id="client_firstname" name="client_firstname" class="m-wrap span12">
						</div>
						 <span class="help-block" id="client_firstname_error"> </span>
					</div>
				 </div>
				</div>


				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">Lastname <span class="required">*</span></label>
				 <div class="controls">
						<input tabindex="7" type="text" placeholder="Please Enter Lastname" value="<?php echo isset($data)?$data['client_lastname']:''; ?>" id="client_lastname" name="client_lastname" class="m-wrap span12">
						<span class="help-block" id="client_lastname_error"> </span>
				 </div>
				</div>
			 </div>
				</div>


			  <div class="row-fluid">
					<div class="span4 ">
	 				<div class="control-group">
	 				 <label class="control-label">Contact No. </label>
	 				 <div class="controls">
	 						<input tabindex="8" type="text" placeholder="Please Enter Contact No" value="<?php echo isset($data)?$data['client_mobile_no']:''; ?>" id="client_mobile_no" name="client_mobile_no" class="m-wrap span12">
	 						<span class="help-block" id="client_mobile_no_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>

				 <div class="span4 ">
				 <div class="control-group">
					<label class="control-label">Alternate no <!--<span class="required">*</span>--></label>
					<div class="controls">
						 <input tabindex="9" type="text" placeholder="Please Enter Alternate No" value="<?php echo isset($data)?$data['alternate_no']:''; ?>" id="alternate_no" name="alternate_no" class="m-wrap span12">
						 <span class="help-block" id="alternate_no_error"> </span>
					</div>
				 </div>
				</div>

				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">client email id </label>
				 <div class="controls">
						<input tabindex="10" type="text" placeholder="Please Enter client email id" value="<?php echo isset($data)?$data['client_email_id']:''; ?>" id="client_email_id" name="client_email_id" class="m-wrap span12">
						<span class="help-block" id="client_email_id_error"> </span>
				 </div>
				</div>
			 </div>
				</div>


				<div class="row-fluid">
					<div class="span6">
	 				<div class="control-group">
		 				<label class="control-label">Address <span class="required">*</span></label>
		 				<div class="controls">
		 					<!-- <div style="clear:both" class="span12"> -->
			 				 	<div id="addressBlock" class="span9">
								  <textarea tabindex="11" rows="3" name="address" id="address" class="m-wrap span9"><?php echo isset($data)?trim($data['address']):''; ?></textarea> 
								</div>
							  	<!-- <div class="span9" style="margin-top:10px"><input type="button"  value="Submit" onclick="saveAddress();" /></div> -->
							<!-- </div> -->
							
							<a href="javascript:;" onclick="addAddressField();"><img src="<?php print IMAGEPATH;?>/plus.png"></a>
							<a href="javascript:;" onclick="getAdress();">View</a>
		 					<span class="help-block" id="address_error"> </span>
		 				</div>
	 				</div>
	 			 </div>


				</div>

				<div class="row-fluid">
					<div class="span6 ">
					<div class="control-group">
					 <label class="control-label">Landmark <!--<span class="required">*</span>--></label>
					 <div class="controls">
							<input tabindex="12" type="text" placeholder="Please Enter landmark" value="<?php echo isset($data)?$data['landmark']:''; ?>" id="landmark" name="landmark" class="m-wrap span12">
							<span class="help-block" id="landmark_error"> </span>
					 </div>
					</div>
				 </div>
					<div class="span6 ">
	 				<div class="control-group">

	 				 <label class="control-label">location <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input tabindex="13" type="text" placeholder="Please Enter Location" value="<?php echo isset($data)?$data['location']:''; ?>" id="location" name="location" class="m-wrap span12">
	 						<span class="help-block" id="location_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span4 ">
	 				<div class="control-group">
	 				 <label class="control-label">City <span class="required">*</span></label>
	 				 <div class="controls">
	 				 	
							<select tabindex="14" class="medium m-wrap" id="city" name="city">
						   <?php 
						   if($cities)
						   echo optionsGeneratorNew($cities,$data['city']); 
						   else
						   echo $modelObj->optionsGenerator('city', 'name', 'id', $data['city']," where status='0'"); ?>
							</select>
							<span class="help-block" id="city_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>


				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">State <!-- <span class="required">*</span> --></label>
	 				 <div class="controls">
	 				 	
<select tabindex="15" id="state" name="state" class="m-wrap span12">
<?php foreach ($states as $k=>$state) { ?>
	<option value="<?php echo $k; ?>" <?php if($data['state'] == $k): echo "selected"; else: ""; endif; ?>><?php echo $state; ?></option>
<?php } ?>
<?php ?>
</select>	 						<!-- <input tabindex="17" type="text" placeholder="Please Enter state" value="<?php //echo isset($data)?$data['state']:''; ?>" > -->
	 						<span class="help-block" id="state_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>


				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">Pincode <!--<span class="required">*</span>--></label>
				 <div class="controls">
						<input tabindex="16" type="text" placeholder="Please Enter pincode" value="<?php echo isset($data)?$data['pincode']:''; ?>" id="pincode" name="pincode" class="m-wrap span12">
						<span class="help-block" id="pincode_error"> </span>
				 </div>
				</div>
			 </div>
				</div>

				</div>

			<div class="row-fluid" style="background-color:#6d6d6d;margin-bottom:15px;">
				<h3 style="padding-left:10px">Service Details</h3>
			</div>
			<div class="row-fluid">
				<div class="span6 ">
					<div class="control-group">
						<label class="control-label">Lead Source <span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="lead_source" name="lead_source">
						   <?php if($leadsources)
						   		echo optionsGeneratorNew($leadsources,$data['lead_source']);
						   		else
						   		echo $modelObj->optionsGenerator('leadsource', 'name', 'id', $data['lead_source']," where status='0'"); ?>
							</select>
						</div>
					</div>
				</div>

					<div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Owner<span class="required">*</span></label>
						<div class="controls">
							<input tabindex="2" type="text" placeholder="Please Enter Lead Owner" value="<?php echo isset($data)?$data['lead_owner']:''; ?>" id="lead_owner" name="lead_owner" class="m-wrap span12">
 						   <span class="help-block" id="validity_error"> </span>
						</div>
					 </div>
				  </div>
			   </div>

			    <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Stage <span class="required">*</span></label>
						<div class="controls">
							<select tabindex="3" class="large m-wrap" id="lead_stage" name="lead_stage">
						   <?php 
						   if($leadstage)
						    echo optionsGeneratorNew($leadstage,$data['lead_stage']); 
							else
							echo $modelObj->optionsGenerator('leadstage', 'name', 'id',$data['lead_stage']," where status='0'"); ?>
							</select>
						</div>
					 </div>
				  </div>

				  <div class="span6 ">
					<div class="control-group">
						<label class="control-label">Reminder</label>
						 <div class="controls">
								<input tabindex="4" type="text" placeholder="Please Set Reminder" value="<?php echo isset($data)?$data['reminder']:''; ?>" id="reminder" name="reminder" class="m-wrap span12 datepicker">
								<span class="help-block" id="reminder_error"> </span>
						 </div>
						</div>
				 	</div>

			   </div>
			   
			<div class="servicess">
				<?php 
				if($leadmanager_id!=''){ //To edit new lead
					if(count($services) > 0)
						foreach ($services as $k=> $service) {
				?>
				<input type="hidden" value="<?php echo $service['id']; ?>" name="service_id[]">
			   	<div class="servicesss">
			   	<hr />
			   	<span style="padding:10px;background-color:#35aa47;color:#FFFFFF;font-weight:bold">
			   		<?php if($leadmanager_id!=''): echo $k+1; else: echo "1"; endif; ?>
			   	</span>
			   	<div class="row-fluid">
					<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Inquiry <span class="required">*</span></label>
		 				 <div class="controls">
								<select tabindex="17" class="medium m-wrap service_inquiry" id="service_inquiry" name="service_inquiry[]" onchange="getVaiantType(this,'varianttype','service_inquiry')">
							   <?php 
							   if($pricelist)
							   echo optionsGeneratorNew($pricelist,$service['service_inquiry']);
							   else
							   echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $service['service_inquiry']," where status='0'"); ?>
								</select>
		 						<span class="help-block" id="service_inquiry_error"> </span>
		 				</div>
	 					</div>
		 			</div>
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Variant Type  <span class="required">*</span></label>
						 <div class="controls">
							 <select tabindex="18" class="medium m-wrap varianttype" id="varianttype" name="varianttype[]" onchange="showPrice('varianttype','service_inquiry','service_price<?php echo $k ?>');">
								<?php
									if($leadmanager_id != '' && !$varianttype):
									echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$service['varianttype_id']," where status='0'");
									elseif($leadmanager_id != '' && $varianttype):
										echo optionsGeneratorNew($varianttype,$service['varianttype_id']);
									endif;
								 ?>
							 </select>
						 </div>
						</div>
				 	</div>
			 		<div class="span4">
		 				<div class="control-group">
			 				<label class="control-label">Additional Variant </label>
			 				 <div class="controls">
			 					<input tabindex="23" type="text" placeholder="Please Enter Variant" value="<?php echo isset($service)?$service['sqft']:''; ?>" name="sqft[]" class="m-wrap span12">
			 					<span class="help-block"> </span>
			 				</div>
		 				</div>
		 			</div>
				</div>
				<div class="row-fluid">
		 			<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Base Rate <span class="required">*</span></label>
		 				 <div class="controls">
							<input type="text" tabindex="38" id="service_price<?php echo $k ?>" name="service_price[]" class="m-wrap span12 service_price" value="<?php echo isset($service)?trim($service['service_price']):''; ?>">
		 					<span class="help-block" id="service_price_error"> </span>
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Discount </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Please Enter Discount" value="<?php echo isset($service)?$service['service_discount']:''; ?>" onchange="get_service_discount(<?php echo $k ?>)" id="service_discount<?php echo $k ?>" name="service_discount[]" class="m-wrap span12 service_discount">
		 						<span class="help-block" id="discount_error"> </span>
		 				 </div>
		 				</div>
	 			 	</div>
		 			<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Duration </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Please Enter Duration" value="<?php echo isset($service)?$service['service_duration']:''; ?>" name="service_duration[]" class="m-wrap span12 service_duration">
		 				 </div>
		 				</div>
	 			 	</div>
				</div>
				<div class="row-fluid">
		 			<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Client Payment Expected<span class="required">*</span></label>
		 				 <div class="controls">
							<input type="text" tabindex="38" name="client_payment_expected[]" value="<?php echo isset($service)?$service['client_payment_expected']:''; ?>" class="m-wrap span12 client_pay_expetcted" value="">
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Partner Receivable </label>
		 				 <div class="controls">
		 					<input tabindex="48" type="text" placeholder="Partner Receivable" value="<?php echo isset($service)?$service['partner_receivable']:''; ?>" name="partner_receivable[]" class="m-wrap span12 partner_receivable">
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Partner Payable </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Partner Payable" value="<?php echo isset($service)?$service['partner_payable']:''; ?>" name="partner_payable[]" class="m-wrap span12 partner_payable">
		 				 </div>
		 				</div>
	 			 	</div>
				</div>
				<div class="row-fluid">
					<div class="span4 ">
						<div class="control-group">
		 				 <label class="control-label">Service Booked <span class="required">*</span></label>
		 				 <div class="controls">
		 						<label class="checkbox-inline" style="float:left;width:50px"><input tabindex="21" type="radio" name="service_inquiry_booked<?php echo $k; ?>" value="yes" <?php if($service['service_booked']=='yes'): echo "checked"; else: ""; endif; ?> />Yes</label>
		 						<label class="checkbox-inline" style="float:left;width:50px"><input tabindex="22" type="radio" name="service_inquiry_booked<?php echo $k; ?>" value="no" <?php if($service['service_booked']=='no'): echo "checked"; else: ""; endif; ?> />No</label>
		 						<span class="help-block" id="service_inquiry_booked_error"> </span>
		 				 </div>
		 				</div>
		 			</div>
				
					<div class="span4 ">
		 				<div class="control-group">
			 				 <div class="controls">
			 				 	<input type="checkbox" onclick="is_amc(<?php echo $k ?>)" class="is_amc<?php echo $k ?>" name="is_amc<?php echo $k; ?>" <?php if($service['is_amc'] == '1'): echo "checked"; else: echo ""; endif; ?> value="1">Is Contract
			 				 </div>
			 			</div>
			 		</div>
		 			<div class="span4  frequency<?php echo $k ?>" style="<?php if($service['is_amc'] == '1'): echo "display:block"; else: echo "display:none"; endif; ?>">
		 				<div class="control-group">
			 				<label class="control-label">Frequency </label>
			 				 <div class="controls">
			 					<select name="frequency[]" class="small m-wrap">
			 						<option value="onetime" <?php if($service['frequency']== 'onetime'): echo "selected";else: ""; endif; ?> >One Time</option>
			 						<option value="mon_to_fri" <?php if($service['frequency']== 'mon_to_fri'): echo "selected";else: ""; endif; ?>>Mon to Fri</option>
			 						<option value="sat_to_sun" <?php if($service['frequency']== 'sat_to_sun'): echo "selected";else: ""; endif; ?>>Sat to Sun</option>
			 						<option value="daily" <?php if($service['frequency']== 'daily'): echo "selected";else: ""; endif; ?>>Daily</option>
			 						<option value="weekly" <?php if($service['frequency']== 'weekly'): echo "selected";else: ""; endif; ?>>Weekly</option>
			 						<option value="fortnightly" <?php if($service['frequency']== 'fortnightly'): echo "selected";else: ""; endif; ?>>Fortnightly</option>
			 						<option value="monthly" <?php if($service['frequency']== 'monthly'): echo "selected";else: ""; endif; ?>>Monthly</option>
			 						<option value="quarterly" <?php if($service['frequency']== 'quarterly'): echo "selected";else: ""; endif; ?>>Quarterly</option>
			 					</select>
			 					<span class="help-block"> </span>
			 				</div>
		 				</div>
		 			</div>
		 		</div>	
				<div class="row-fluid serviceDateTime1">
					<div class="span6 ">
						<div class="control-group">
						 <label class="control-label">Service Date <span class="required">*</span></label>
						 <div class="controls">
								<input tabindex="19" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($service)?$service['service_date']:''; ?>" name="service_date[]" class="m-wrap span12 datepicker service_date">
								<span class="help-block" id="cost1_error"> </span>
						 </div>
						</div>
				 	</div>
					<div class="span6 ">
						<div class="control-group">
						 <label class="control-label">Service Time  <span class="required">*</span></label>
						 <div class="controls bootstrap-timepicker timepicker">
								<input tabindex="20" type="text" placeholder="Please Enter Service Time" value="<?php echo isset($service)?$service['service_time']:''; ?>" name="service_time[]" class="m-wrap span12 service_time">
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								<span class="help-block" id="service1_time_error"> </span>
						 </div>
						</div>
			 		</div>
				</div>
				<div class="row-fluid contract<?php echo $k ?>" style="<?php if($service['is_amc'] == '1'): echo "display:block"; else: echo "display:none"; endif; ?>" >
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Contract Start Date</label>
						 <div class="controls">
								<input tabindex="19" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($service)?$service['contract_start_date']:''; ?>" name="contract_start_date[]" class="m-wrap span12 datepicker contract_start_date">
						 </div>
						</div>
				 	</div>
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Contract End Date</label>
						 <div class="controls bootstrap-timepicker timepicker">
								<input tabindex="19" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($service)?$service['contract_end_date']:''; ?>" name="contract_end_date[]" class="m-wrap span12 datepicker contract_end_date" />
						 </div>
						</div>
			 		</div>
			 		<div class="span4 "><div class="control-group"><label class="control-label">No. of service </label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter No. Of Service" value="<?php echo isset($service)?$service['no_of_service']:''; ?>" name="no_of_service[]" class="m-wrap span12"></div></div>
					</div>
				</div>
				</div><!-- End service -->
				<?php } } else{ //To add new lead ?> 
				<div class="servicesss">
			   	<hr />
			   	<span style="padding:10px;background-color:#35aa47;color:#FFFFFF;font-weight:bold">1</span>
			   	<div class="row-fluid">
					<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Inquiry <span class="required">*</span></label>
		 				 <div class="controls">
								<select tabindex="17" class="medium m-wrap service_inquiry" id="service_inquiry" name="service_inquiry[]" onchange="getVaiantType(this,'varianttype','service_inquiry')">
							   <?php 
							   if($pricelist)
							   echo optionsGeneratorNew($pricelist,$service['service_inquiry']);
							   else
							   echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $service['service_inquiry']," where status='0'"); ?>
								</select>
		 						<span class="help-block" id="service_inquiry_error"> </span>
		 				</div>
	 					</div>
		 			</div>
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Variant Type  <span class="required">*</span></label>
						 <div class="controls">
							 <select tabindex="18" class="medium m-wrap varianttype" id="varianttype" name="varianttype[]" onchange="showPrice('varianttype','service_inquiry','service_price0');">
								<?php
									if($leadmanager_id != '' && !$varianttype):
									echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype_id']," where status='0'");
									elseif($leadmanager_id != '' && $varianttype):
										echo optionsGeneratorNew($varianttype,$data['varianttype_id']);
									endif;
								 ?>
							 </select>
						 </div>
						</div>
				 	</div>
			 		<div class="span4">
		 				<div class="control-group">
			 				<label class="control-label">Additional Variant </label>
			 				 <div class="controls">
			 					<input tabindex="23" type="text" placeholder="Please Enter Variant" value="" name="sqft[]" class="m-wrap span12">
			 					<span class="help-block"> </span>
			 				</div>
		 				</div>
		 			</div>
				</div>
				<div class="row-fluid">
		 			<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Base Rate <span class="required">*</span></label>
		 				 <div class="controls">
							<input type="text" tabindex="38" id="service_price0" name="service_price[]" class="m-wrap span12 service_price" value="">
		 					<span class="help-block" id="service_price_error"> </span>
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Discount </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Please Enter Discount" value="" onchange="get_service_discount(0)" id="service_discount0" name="service_discount[]" class="m-wrap span12 service_discount">
		 						<span class="help-block" id="discount_error"> </span>
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Service Duration </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Please Enter Duration" value="1" name="service_duration[]" class="m-wrap span12 service_duration">
		 				 </div>
		 				</div>
	 			 	</div>
				</div>
				<div class="row-fluid">
		 			<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Client Payment Expected<span class="required">*</span></label>
		 				 <div class="controls">
							<input type="text" tabindex="38" name="client_payment_expected[]" class="m-wrap span12 client_payment_expected" value="">
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Partner Receivable </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Partner Receivable" value="" name="partner_receivable[]" class="m-wrap span12 partner_receivable" >
		 				 </div>
		 				</div>
	 			 	</div>
	 			 	<div class="span4 ">
		 				<div class="control-group">
		 				 <label class="control-label">Partner Payable </label>
		 				 <div class="controls">
		 						<input tabindex="48" type="text" placeholder="Partner Payable" value="" name="partner_payable[]" class="m-wrap span12 partner_payable">
		 				 </div>
		 				</div>
	 			 	</div>
				</div>
				<div class="row-fluid">
					<div class="span4 ">
						<div class="control-group">
		 				 <label class="control-label">Service Booked <span class="required">*</span></label>
		 				 <div class="controls">
		 						<label class="checkbox-inline" style="float:left;width:50px"><input tabindex="21" type="radio" name="service_inquiry_booked0" value="yes" />Yes</label>
		 						<label class="checkbox-inline" style="float:left;width:50px"><input tabindex="22" type="radio" name="service_inquiry_booked0" value="no" />No</label>
		 						<span class="help-block" id="service_inquiry_booked_error"> </span>
		 				 </div>
		 				</div>
		 			</div>
					<div class="span4 ">
		 				<div class="control-group">
		 					<label class="control-label">Is Contract</label>
			 				 <div class="controls">
			 				 	<input type="checkbox" onclick="is_amc(0)" class="is_amc0" name="is_amc0" value="1">
			 				 </div>
			 			</div>
			 		</div>
		 			<div class="span4 frequency0" style="display:none">
		 				<div class="control-group">
			 				<label class="control-label">Frequency </label>
			 				 <div class="controls">
			 					<select name="frequency[]" class="small m-wrap">
			 						<option value="onetime">One Time</option>
			 						<option value="mon_to_fri">Mon to Fri</option>
			 						<option value="sat_to_sun">Sat to Sun</option>
			 						<option value="daily">Daily</option>
			 						<option value="weekly">Weekly</option>
			 						<option value="fortnightly">Fortnightly</option>
			 						<option value="monthly">Monthly</option>
			 						<option value="quarterly">Quarterly</option>
			 					</select>
			 					<span class="help-block"> </span>
			 				</div>
		 				</div>
		 			</div>
		 			
				</div>

				<div class="row-fluid serviceDateTime1">
					<div class="span6 ">
						<div class="control-group">
						 <label class="control-label">Service Date <span class="required">*</span></label>
						 <div class="controls">
								<input tabindex="19" type="text" placeholder="Please Enter Service Date" value="" name="service_date[]" class="m-wrap span12 datepicker service_date">
								<span class="help-block" id="cost1_error"> </span>
						 </div>
						</div>
				 	</div>
					<div class="span6 ">
						<div class="control-group">
						 <label class="control-label">Service Time  <span class="required">*</span></label>
						 <div class="controls bootstrap-timepicker timepicker">
								<input tabindex="20" type="text" placeholder="Please Enter Service Time" value="" name="service_time[]" class="m-wrap span12 service_time">
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								<span class="help-block" id="service1_time_error"> </span>
						 </div>
						</div>
			 		</div>
				</div>
				<div class="row-fluid contract0" style="display:none;">
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Contract Start Date <span class="required">*</span></label>
						 <div class="controls">
								<input tabindex="19" type="text" placeholder="Please Enter Contract Start Date" value="" name="contract_start_date[]" class="m-wrap span12 datepicker contract_start_date" />
						 </div>
						</div>
				 	</div>
					<div class="span4 ">
						<div class="control-group">
						 <label class="control-label">Contract End Date  <span class="required">*</span></label>
						 <div class="controls bootstrap-timepicker timepicker">
								<input tabindex="19" type="text" placeholder="Please Contract End Date" value="" name="contract_end_date[]" class="m-wrap span12 datepicker contract_end_date" />
						 </div>
						</div>
			 		</div>
			 		<div class="span4 "><div class="control-group"><label class="control-label">No. of service </label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter No. Of Service" value="" name="no_of_service[]" class="m-wrap span12"></div></div>
				</div>
				</div>
				</div><!-- End service -->
				<?php } ?>
			</div>
				<div>
				<a href="javascript:;" onclick="addServices()"><img src="<?php print IMAGEPATH;?>/plus.png"></a>
				</div>
				<hr />
				<div class="row-fluid">
					
					<div class="span6 ">
		 				<div class="control-group">
		 				 <label class="control-label">Additional Note <!--<span class="required">*</span>--></label>
		 				 <div class="controls">
							<textarea tabindex="38" rows="3" name="additional_note" id="additional_note" class="m-wrap span12"><?php echo isset($data)?trim($data['additional_note']):''; ?></textarea>
		 					<span class="help-block" id="additional_note_error"> </span>
		 				 </div>
		 				</div>
	 			 	</div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label"> 	Team Leader </label>
	 				 <div class="controls">
						 <select tabindex="39" class="medium m-wrap" id="teamLeader_deployment" name="teamLeader_deployment">
							<?php  echo $modelObj->optionsGeneratorByIndex(5); ?>
						 </select>

	 						<span class="help-block" id="teamLeader_deployment_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span6 ">
				 <div class="control-group">
					<label class="control-label"> Supervisor  </label>
					<div class="controls">
						<select tabindex="40" class="medium m-wrap" id="supervisor_deployment" name="supervisor_deployment">
						<?php  echo $modelObj->optionsGeneratorByIndex(5); ?>
					 </select>
						 <span class="help-block" id="supervisor_deployment_error"> </span>
					</div>
				 </div>
				</div>
				<div class="span6 ">
				<div class="control-group">
				 <label class="control-label"> 	Janitor/Technician </label>
				 <div class="controls">
					 <select tabindex="41" class="medium m-wrap" id="janitor_deployment" name="janitor_deployment">
						<?php  echo $modelObj->optionsGeneratorByIndex(10); ?>
					 </select>
						<span class="help-block" id="janitor_deployment_error"> </span>
				 </div>
				</div>
			 </div>
				</div>

				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Promo Code <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input tabindex="42" type="text" placeholder="Please Enter Promo Code" value="<?php echo isset($data)?$data['promo_code']:''; ?>" id="promo_code" name="promo_code" class="m-wrap span12">
	 						<span class="help-block" id="promo_code_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Invoice Amount (Pre Tax) <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input tabindex="43" type="text" placeholder="Please Enter Price" value="<?php echo isset($data)?$data['price']:''; ?>" id="price" name="price" class="m-wrap span12">
	 						<span class="help-block" id="price_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Invoice Mode <span class="required">*</span></label>
	 				 	<div class="controls">
	 				 		<select tabindex="44" name="invoice_mode" id="invoice_mode" onchange="showPartnerInfo(this.value)">
	 				 			<option value=''>Please Select</option>
	 				 			<option value='C' <?php if($data['invoice_mode'] == 'C'): echo "selected"; else: ""; endif; ?>>Client</option>
	 				 			<option value='P' <?php if($data['invoice_mode'] == 'P'): echo "selected"; else: ""; endif; ?>>Partner</option>
	 				 		</select>
	 						<span class="help-block" id="commission_error"> </span>
	 				 	</div>
	 				</div>
	 			 	</div>
	 			 	<div class="span6" id="partner_mode_row">
	 				<div class="control-group">
	 				 <label class="control-label">Partner Receivable </label>
	 				 	<div class="controls">
	 						<input tabindex="45" type="text" placeholder="Partner Receivable" value="<?php echo isset($data)?$data['lead_partner_receivable']:''; ?>" id="lead_partner_receivable" name="lead_partner_receivable" class="m-wrap span12">
	 						<span class="help-block" > </span>
	 				 	</div>
	 				</div>
	 			 	</div>
				</div>

				<div class="row-fluid">
					<div class="span6" class="partner_mode_row">
	 				<div class="control-group">
	 				 <label class="control-label">Partner Payable </label>
	 				 	<div class="controls">
	 						<input tabindex="45" type="text" placeholder="Please Enter Partner Amount" value="<?php echo isset($data)?$data['lead_partner_payable']:''; ?>" id="lead_partner_payable" name="lead_partner_payable" class="m-wrap span12">
	 						<span class="help-block" id="partner_payable_error"> </span>
	 				 	</div>
	 				</div>
	 			 	</div>
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Client Payment Expected <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input tabindex="46" type="text" placeholder="Client Payment Expected" value="<?php echo isset($data)?$data['lead_client_payment']:''; ?>" id="lead_client_payment" name="lead_client_payment" class="m-wrap span12">
	 						<span class="help-block" id="commission_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Invoice Amount (Post Tax) <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input tabindex="47" type="text" placeholder="Please Enter taxed cost" value="<?php echo isset($data)?$data['taxed_cost']:''; ?>" id="taxed_cost" name="taxed_cost" class="m-wrap span12">
	 						<span class="help-block" id="taxed_cost_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Discount <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input tabindex="48" type="text" placeholder="Please Enter Discount" value="<?php echo isset($data)?$data['discount']:''; ?>" id="discount" name="discount" class="m-wrap span12">
	 						<span class="help-block" id="discount_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Invoice Type<span class="required">*</span></label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter service inquiry1 booked" value="<?php //echo isset($data)?$data['service_inquiry1_booked']:''; ?>" id="service_inquiry1_booked" name="service_inquiry1_booked" class="m-wrap span12"> -->
	 						<label class="checkbox-inline"><input tabindex="49" type="radio" id="invoice_type11" name="invoice_type" value="0" <?php if($data['invoice_type']=='0'): echo "checked"; else: ""; endif; ?> />Single</label>
	 						<label class="checkbox-inline"><input tabindex="50" type="radio" id="invoice_type12" name="invoice_type" value="1" <?php if($data['invoice_type']=='1'): echo "checked"; else: ""; endif; ?> />Multiple</label>
	 						<span class="help-block" id="service_inquiry1_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Send Reminder</label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter service inquiry1 booked" value="<?php //echo isset($data)?$data['service_inquiry1_booked']:''; ?>" id="service_inquiry1_booked" name="service_inquiry1_booked" class="m-wrap span12"> -->
	 						<label class="checkbox-inline"><input tabindex="49" type="checkbox" id="is_reminder" name="is_reminder" value="1" <?php if($data['is_reminder']=='1'): echo "checked"; else: ""; endif; ?> /></label>
	 						<span class="help-block" id="is_reminder_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
			<div class="form-actions">
				<input type="hidden" name="mhcclient_id" id="mhcclient_id" value="<?php echo isset($data['mhcclient_id'])?$data['mhcclient_id']:''; ?>" />
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_lead_manager','saveLeadManager');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/leadmanager/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <span id="no_of_row" style="display:none;"><?php if($leadmanager_id!="") echo count($services); else echo '1'; ?></span>
		 <!-- END FORM-->
	  </div>
	</div>
<!----ADDRESS POPUP STARTS HERE------- -->
 <div class="modal fade" id="address_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
        	<div>
        		<ul id="listAddress">
        		<?php 

        		$addresses= $modelObj->getAddressTable($data['mhcclient_id']);
        		if($addresses > 0){
	        		foreach ($addresses as $add) {
	        			echo "<li>".$add['address']."</li>";
	        		}
        		}
        		 ?>
        		</ul>
        	</div>
        	
        </div>
      </div>
    </div>
  </div>
<!----REMARK POPUP ENDS HERE------- -->
<script>
$(document).ready(function(){

	$( "#client_firstname" ).autocomplete({
        source: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php?action=getClientFirstname"
    });

	$( "#client_lastname" ).autocomplete({
        source: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php?action=getClientLastname"
    });

    $("#client_mobile_no").on('change',function(){
    	if($(this).val() != ''){
    	  $.ajax({
	                type: "POST",
	                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
	                data: {action:'getClientMobile',mobile_no:$(this).val()},
	                success: function(res){
	                	var obj = eval("("+res+")");
	                	if(obj[0]){
	                	$('#client_firstname').val(obj[0].client_firstname);
	                	$('#client_lastname').val(obj[0].client_lastname);
	                	$('#alternate_no').val(obj[0].alternate_no);
	                	$('#client_email_id').val(obj[0].client_email_id);
	                	$('#address').val(obj[0].address);
	                	$('#landmark').val(obj[0].landmark);
	                	$('#location').val(obj[0].location);
	                	$('#state').val(obj[0].state);
	                	$('#city').val(obj[0].city);
	                	$('#pincode').val(obj[0].pincode);
	                	$('#client_salutation').val(obj[0].client_salutation);
	                	$('#mhcclient_id').val(obj[0].id);
	                	  $.ajax({
			                type: "POST",
			                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
			                data: {action:'getAddress',mhcclient_id:obj[0].id},
			                success: function(res){
			                	var obj = eval("("+res+")");
			                	var html= "";
			                	$.each(obj,function(e,d){
			                		html += "<li>"+d.address+"</li>";
			                	});
			                	$("#listAddress").html(html);
			               }
			           });
	                	
	                	}else{
	                	$('#client_firstname').val('');
	                	$('#client_lastname').val('');
	                	$('#alternate_no').val('');
	                	$('#client_email_id').val('');
	                	$('#address').val('');
	                	$('#landmark').val('');
	                	$('#location').val('');
	                	$('#state').val('');
	                	$('#city').val('');
	                	$('#pincode').val('');
	                	$('#client_salutation').val('');
	                	$('#mhcclient_id').val('');
	                	}
	                },
	                error:function(){
	                    alert("failure");
	                }

	            });
		}
    })
	
	
	$('#taxed_cost').change(function() {
		var val = parseFloat($('#taxed_cost').val());
		var price = val -0.15*val;
		if (val!=''|| val!=0) {
			 $('#price').val(price.toFixed(2));
		}
  	
	});

	$('#discount').change(function(){

		var discount = $('#discount').val();
		if (discount.search('%')!=-1) {
			// debugger;
			var discInPerc = parseFloat(discount.replace('%',''));
			var totalAmt = parseFloat($('#taxed_cost').val());	

			var discAmt = totalAmt - (discInPerc*totalAmt)/100;
			var withoutTaxAmt = $('#price').val()- (discInPerc*totalAmt)/100;  
			 $('#taxed_cost').val(discAmt.toFixed(2));
			  $('#price').val(withoutTaxAmt.toFixed(2));
		}
		else {
			// debugger;
			var discInRs = parseFloat(discount);
			var totalAmt = parseFloat($('#taxed_cost').val());	

			var discAmt = totalAmt - discInRs;
			var withoutTaxAmt = $('#price').val()- discInRs;  
			 $('#taxed_cost').val(discAmt.toFixed(2));
			  $('#price').val(withoutTaxAmt.toFixed(2));
		}

	})

	if($('#invoice_mode').val() == 'P'){
    		$('#partner_mode_row').show();
    	}else{
    		$('#partner_mode_row').hide();
    	}

	$('.service_date').datepicker({
  	format:'yyyy/mm/dd'
  });

	$('.contract_start_date').datepicker({
  	format:'yyyy/mm/dd'
  });

	$('.contract_end_date').datepicker({
  	format:'yyyy/mm/dd'
  });

	$('#reminder').datepicker({
  	format:'dd-mm-yyyy'
  });

	if($('#lead_stage option:selected').text()!='Closed'){
		$('.serviceDateTime1').hide();
	}else{
		$('.serviceDateTime1').show();
	}
	$('#lead_stage').change(function(){
		if($('#lead_stage option:selected').text()!='Closed'){
			$('.serviceDateTime1').hide();
		}else{
			$('.serviceDateTime1').show();
		}
	});
	$('#lead_stage').change(function(){
		if($('#lead_stage').text() == 'Closed')
   			$('#service1_time').timepicker();
	});
	
	$('.service_time').timepicker();
	$('.service_price').on('change',function(){
		cost = 0;
		taxed_cost = 0;
		total_tax = "<?php echo $total_tax; ?>";
		$(".service_price").each(function (i,sel) {
    	   var price = Math.floor(parseFloat($(sel).val())/(1+parseFloat(total_tax)/100));
		   cost = cost + price;
		   taxed_cost = taxed_cost+parseFloat($(sel).val());
		 });
    	$('#price').val(cost);
    	$('#taxed_cost').val(taxed_cost);
	});

	$('.client_payment_expected').on('change',function(){
		client_cost = 0;
		$(".client_payment_expected").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
    	   if(price != ''){
    	   		client_cost = client_cost + price;
    	   }
		 });
    	$('#lead_client_payment').val(client_cost);
	});
		$('.partner_receivable').on('change',function(){
		client_cost = 0;
		$(".partner_receivable").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
		   if(price != ''){
    	   		client_cost = client_cost + price;
    	   }
		 });
    	$('#lead_partner_receivable').val(client_cost);
	});
	$('.partner_payable').on('change',function(){
		client_cost = 0;
		$(".partner_payable").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
		   if(price != ''){
    	   		client_cost = client_cost + price;
    	   }
		 });
    	$('#lead_partner_payable').val(client_cost);
	});
	/*$('.service_discount').on('change',function(){
		
	});*/
});
<?php if($leadmanager_id != '' && $flag != 'new'){ ?>
$(document).ready(function() {
  change_tab(1);
});
<?php }else if($flag=='new'){ ?>
$(document).ready(function() {
  change_tab('new');
});
<?php } ?>

//To hide and show amc/contract fields
function is_amc(id){
	var test = $('.is_amc'+id).attr('checked');
	if(test == 'checked'){
		$(".frequency"+id).show();
		$(".contract"+id).show();
	}else{
		$(".frequency"+id).hide();
		$(".contract"+id).hide();
	}
}
function sum( obj ) {
  var sum = 0;
  for( var el in obj ) {
    if( obj.hasOwnProperty( el ) ) {
      sum += parseFloat( obj[el] );
    }
  }
  return sum;
}

var discobj = {};
function get_service_discount(id){
	//debugger;
	var totaldiscount =0;
	var discount = $('#service_discount'+id).val();
	if (discount.search('%')!=-1) {
		// debugger;
		var discInPerc = parseFloat(discount.replace('%',''));
		var totalAmt = parseFloat($('#service_price'+id).val());	

		var discAmt = totalAmt - (discInPerc*totalAmt)/100;
		discobj['discAmt'+id] = (discInPerc*totalAmt)/100;
		
		//var withoutTaxAmt = $('#price').val()- (discInPerc*totalAmt)/100;  
		 $('#service_price'+id).val(discAmt.toFixed(2));
		 // $('#price').val(withoutTaxAmt.toFixed(2));
	}
	else {
		// debugger;
		var discInRs = parseFloat(discount);
		var totalAmt = parseFloat($('#service_price'+id).val());	

		var discAmt = totalAmt - discInRs;
		discobj['discAmt'+id] = discInRs;
		//var withoutTaxAmt = $('#price').val()- discInRs;  
		 $('#service_price'+id).val(discAmt.toFixed(2));
		 // $('#price').val(withoutTaxAmt.toFixed(2));
	}
	/*client_cost = 0;
	$(".service_discount").each(function (i,sel) {
	   var price = parseFloat($(sel).val());
	   if(price != ''){
	   		client_cost = client_cost + price;
	   }
	 });*/
	totaldiscount =sum(discobj);
	$('#discount').val(totaldiscount);
}


function addServices(){
	$('#no_of_row').text( parseInt($('#no_of_row').text()) + 1 );
	var i = $('#no_of_row').text();
	var t = '<div class="servicesss"><hr /><span style="padding:10px;background-color:#35aa47;color:#FFFFFF;font-weight:bold">'+i+'</span>';
	t += '<div class="row-fluid"><div class="span4 "><div class="control-group"><label class="control-label">Service Inquiry <span class="required">*</span></label>';
	t +='<div class="controls"><select tabindex="17" class="medium m-wrap service_inquiry" id="service_inquiry'+i+'" name="service_inquiry[]" onchange="getVaiantType(this,\''+'varianttype'+i+''+'\',\''+'service_inquiry'+'\')">';
	t += "<?php 
	   if($pricelist)
	   echo optionsGeneratorNew($pricelist,$data['service_inquiry']);
	   else
	   echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $data['service_inquiry'],' where status="0"'); ?>";

	t +='</select><span class="help-block" id="service_inquiry_error"></span></div></div></div>';
	t +='<div class="span4 "><div class="control-group"><label class="control-label">Variant Type  <span class="required">*</span></label>';
	t +='<div class="controls"><select tabindex="18" class="medium m-wrap varianttype" id="varianttype'+i+'" name="varianttype[]" onchange="showPrice(\''+'varianttype'+i+'\',\''+'service_inquiry'+i+'\',\''+'service_price'+i+'\');">';
	t +="<?php
		if($leadmanager_id != '')
		echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype'],' where status="0"'); ?>";
	t +='</select></div></div></div><div class="span4">';
		t +='<div class="control-group"><label class="control-label">Additional Variant </label><div class="controls"><input tabindex="23" type="text" placeholder="Please Enter Variant" value="<?php echo isset($data)?$data["sqft"]:""; ?>" name="sqft[]" class="m-wrap span12"><span class="help-block" id="sqft1_error"> </span></div>';
	t +='</div></div>';

	t +='<div class="row-fluid"><div class="span4 "><div class="control-group"><label class="control-label">Base Rate<span class="required">*</span></label>';
	t +='<div class="controls"><input type="text" tabindex="38" id="service_price'+i+'" name="service_price[]" class="m-wrap span12 service_price"><?php echo isset($data)?trim($data["service_price"]):""; ?></textarea>';
	t +='<span class="help-block"> </span></div></div></div>';
	t +='<div class="span4"><div class="control-group"><label class="control-label">Service Discount </label><div class="controls"><input tabindex="48" type="text" placeholder="Please Enter Discount" value="<?php echo isset($data)?$data["service_discount"]:""; ?>" onchange="get_service_discount('+i+')" id="service_discount'+i+'" name="service_discount[]" class="m-wrap span12 service_discount"><span class="help-block" id="discount_error"> </span></div></div></div>'
	t +='<div class="span4 "><div class="control-group"><label class="control-label">Service Duration </label><div class="controls"><input tabindex="48" type="text" placeholder="Please Enter Duration" value="1" name="service_duration[]" class="m-wrap span12 service_duration"></div></div></div></div></div>';
	t +='<div class="row-fluid">';
	t +='<div class="span4 "><div class="control-group"><label class="control-label">Client Payment Expected<span class="required">*</span></label><div class="controls"><input type="text" tabindex="38" name="client_payment_expected[]" class="m-wrap span12 client_payment_expected" value=""></div></div></div>';
	t +='<div class="span4 "><div class="control-group"><label class="control-label">Partner Receivable </label><div class="controls"><input tabindex="48" type="text" placeholder="Partner Receivable" value="" name="partner_receivable[]" class="m-wrap span12 partner_receivable"></div></div></div><div class="span4 "><div class="control-group"><label class="control-label">Partner Payable </label><div class="controls"><input tabindex="48" type="text" placeholder="Partner Payable" value="" name="partner_payable[]" class="m-wrap span12 partner_payable"></div></div></div></div>';
	t +='<div class="row-fluid"><div class="span4 "><div class="control-group"><label class="control-label">Service Booked <span class="required">*</span></label><div class="controls"><label class="checkbox-inline" style="float:left;width:50px"><input tabindex="21" type="radio" name="service_inquiry_booked'+(i-1)+'" value="yes" />Yes</label><label class="checkbox-inline" style="float:left;width:50px"><input tabindex="22" type="radio" name="service_inquiry_booked'+(i-1)+'" value="no" />No</label><span class="help-block" > </span></div></div></div><div class="span4 "><div class="control-group"><label class="control-label">Is Contract </label><div class="controls"><input type="checkbox" name="is_amc'+(i-1)+'" value="1" onClick="is_amc('+(i-1)+')" class="is_amc'+(i-1)+'"></div></div></div>';
	t+='<div class="span4 frequency'+(i-1)+'" style="display:none"><div class="control-group"><label class="control-label">Frequency </label><div class="controls"><select name="frequency[]" class="small m-wrap"><option value="onetime">One Time</option><option value="mon_to_fri">Mon to Fri</option><option value="sat_to_sun">Sat to Sun</option><option value="daily">Daily</option><option value="weekly">Weekly</option><option value="fortnightly">Fortnightly</option><option value="monthly">Monthly</option><option value="quarterly">Quarterly</option></select><span class="help-block"> </span></div></div></div></div>';
	t +='<div class="row-fluid serviceDateTime1"><div class="span6 "><div class="control-group">';
	t +='<label class="control-label">Service Date <span class="required">*</span></label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter Service Date" value="" name="service_date[]" class="m-wrap span12 datepicker service_date">';
	t +='<span class="help-block" id="cost1_error"> </span></div></div></div>';
	t +='<div class="span6 "><div class="control-group"><label class="control-label">Service Time  <span class="required">*</span></label><div class="controls bootstrap-timepicker timepicker">';
	t +='<input tabindex="20" type="text" placeholder="Please Enter Service Time" value="" name="service_time[]" class="m-wrap span12 service_time">';
	t +='<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span><span class="help-block" id="service1_time_error"> </span></div></div></div></div></div>';
	t +='<div class="row-fluid contract'+(i-1)+'" style="display:none"><div class="span4 "><div class="control-group"><label class="control-label">Contract Start Date </label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter Service Date" value="" name="contract_start_date[]" class="m-wrap span12 datepicker contract_start_date"></div></div></div>';
	t+='<div class="span4 "><div class="control-group"><label class="control-label">Contract End Date </label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter Service Date" value="" name="contract_end_date[]" class="m-wrap span12 datepicker contract_end_date"></div></div></div>';
	t +='<div class="span4 "><div class="control-group"><label class="control-label">No. of service </label><div class="controls"><input tabindex="19" type="text" placeholder="Please Enter No. Of Service" value="" name="no_of_service[]" class="m-wrap span12"></div></div>';
	t +='</div></div>';
	$(".servicess").append(t);
	$('.service_date').datepicker({
	  	format:'yyyy/mm/dd'
	  });
	$('.service_time').timepicker();
		if($('#lead_stage option:selected').text()!='Closed'){
		$('.serviceDateTime1').hide();
		$('.serviceDateTime2').hide();
		$('.serviceDateTime3').hide();
	}else{
		$('.serviceDateTime1').show();
		$('.serviceDateTime2').show();
		$('.serviceDateTime3').show();
	}
	$('.service_price').on('change',function(){
		cost = 0;
		taxed_cost = 0;
		total_tax = "<?php echo $total_tax; ?>";
		$(".service_price").each(function (i,sel) {
    	   var price = Math.floor(parseFloat($(sel).val())/(1+parseFloat(total_tax)/100));
		   cost = cost + price;
		   taxed_cost = taxed_cost+parseFloat($(sel).val());
		 });
    	$('#price').val(cost);
    	$('#taxed_cost').val(taxed_cost);
	});
		$('.contract_start_date').datepicker({
	  	format:'yyyy/mm/dd'
	  });

		$('.contract_end_date').datepicker({
	  	format:'yyyy/mm/dd'
	  });
		$('.client_payment_expected').on('change',function(){
		client_cost = 0;
		$(".client_payment_expected").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
		   client_cost = client_cost + price;
		 });
    	$('#lead_client_payment').val(client_cost);
	});
		$('.partner_receivable').on('change',function(){
		client_cost = 0;
		$(".partner_receivable").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
		   client_cost = client_cost + price;
		 });
    	$('#lead_partner_receivable').val(client_cost);
	});
	$('.partner_payable').on('change',function(){
		client_cost = 0;
		$(".partner_payable").each(function (i,sel) {
    	   var price = parseFloat($(sel).val());
		   client_cost = client_cost + price;
		 });
    	$('#lead_partner_payable').val(client_cost);
	});

	function is_amc(id){
		var test = $('.is_amc'+id).attr('checked');
		if(test == 'checked'){
			$(".frequency"+id).show();
			$(".contract"+id).show();
		}else{
			$(".frequency"+id).hide();
			$(".contract"+id).hide();
		}
	}
}
function saveData(frm_id, action){
         //alert('Jai Mata Di............' + frm_id);
        $('#frm_lead_manager').validate({
	    	rules:{
	    		lead_source:"required",
	    		service_date: "required",
	    		lead_stage:"required",
	    		service_time:"required",
	    		lead_owner:"required",
	    		manpower_deployment:"required",
	    		client_firstname:"required",
	    		client_lastname:"required",
	    		client_mobile_no:{
	    			number:true
	    		}/*,
	    		client_email_id:{
	    			email:true
	    		}*/,
	    		address:{
	    			required:true
	    		},
	    		taxed_cost:{
	    			required:true
	    		},
	    		service_inquiry1_booked:{
	    			required:true
	    		},
	    		service_inquiry1:"required"
	    	},
	    	submitHandler: function() {

	        $('.error').hide();
	        var flag=0;
	        var leadmanager_id = $('#leadmanager_id').val();
			if(leadmanager_id=="")
	        {
	            //$('#product_id_error').show();
	            $('#leadmanager_id').attr('placeholder' ,'Please Enter Categry Id');
	            $('#leadmanager_id').addClass('alert-error');
	            $('#leadmanager_id').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
	            flag=1;
	        }

	        if(flag==0){
	            var datastring=$('#'+frm_id).serialize();
							 //alert('Jai Mata Di............' + datastring);
	            $.ajax({
	                type: "POST",
	                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
	                data: datastring,
	                success: getData,
	                error:function(){
	                    alert("failure");
	                }
	            });
	        }
        	return false;
			}
    	});
    }

    function getAdress(){
    	if($.trim($('#listAddress').html()) == ''){
    		alert("No record found!");
    	}else{
    		$("#address_modal").modal('toggle');
    	}
    }

    function addAddressField(){
    	var html = '<br /><br /><textarea tabindex="11" rows="3" name="address1[]" class="m-wrap span9"></textarea>';
    	$('#addressBlock').append(html);
    }

    function showPrice(variant,service,priceid){
    	var inq1 = $('#'+service).find('option:selected').text();
    	var varianttype1 = $('#'+variant).find('option:selected').text();
      	var city = $('#city').val();
     	var source = $('#lead_source').val();

    	if(inq1!='' && city!='' && varianttype1!=''){
    		$.ajax({
    			 type: "POST",
                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
                data: {city:city,inq1:inq1,varianttype1:varianttype1,action:'getPrice'},
                success:function(res){
                	var obj = eval("("+res+")");
                	taxed_cost = 0;

                	cost = 0;
                	$('#'+priceid).val(obj.result);
                	total_tax = "<?php echo $total_tax; ?>";
                	// debugger;
                	$(".service_price").each(function (i,sel) {
                	   var price = Math.floor(parseFloat($(sel).val())/(1+parseFloat(total_tax)/100));
                	   //console.log(price);
					   cost = cost + price;
					   taxed_cost = taxed_cost+parseFloat($(sel).val());
					 });
                	$('#price').val(cost);
                	$('#taxed_cost').val(taxed_cost);
                },
                error:function(){
                    alert("failure");
                    //$("#result").html('there is error while submit');
                }
    		});
    	}
    }
    function getData(success){ //alert('Jmd................');

    	var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        //alert(success);
        var res_product_id=jObj.leadmanager_id; //alert('AA'+res_product_id);

		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($leadmanager_id =='' || $leadmanager_id == 0){ ?>
		window.location.href = "<?php echo SITEPATH;?>/<?php echo $modelObj->folderName; ?>/display.php";
		<?php } ?>
    }

    function getVaiantType(id,varianttype,service){

	  	$.ajax({
	        type: "POST",
	        url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
	        data: {action:'getVaiantType',id:$(id).find("option:selected").text(),service:service},
	        success: function(vartypes){
	        	var jObj1=eval("("+vartypes+")");
	        	tt = <?php echo json_encode($varianttype); ?>;
	        	//console.log(jObj1.result);
	        	var options = '<option value="">Please Select</option>';
	        	$.each(jObj1.result,function(i,e){
	        		options += '<option value="'+e.varianttype+'">'+tt[e.varianttype]+'</option>';
	        	});
	        	$('#'+varianttype).html(options);
	        },
	        error:function(){
	            alert("failure");
	            //$("#result").html('there is error while submit');
	        }

	    });
    }
    function showPartnerInfo(current){
    	if(current == 'P'){
    		$('#partner_mode_row').show();
    	}else{
    		$('#partner_mode_row').hide();
    	}
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
