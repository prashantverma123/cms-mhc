<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php
if($leadmanager_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($leadmanager_id));
	$data = (array)$returned_data[0];
	$mhcclient = $modelObj->get_mhcclient($data['mhcclient_id']);
	
	if(count($mhcclient) > 0)
	$data = array_merge($data,$mhcclient[0]);
}
?>
<?php 
$cities = $memcache->get('city');
$leadsources = $memcache->get('leadsource');
$leadstage = $memcache->get('leadstage');
$pricelist = $memcache->get('pricelist');
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
			   <h3 class="form-section">Lead Manager</h3>
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
							<!-- <select tabindex="1" class="large m-wrap" id="category_id" name="category_id">
						   <?php  //echo $modelObj->optionsGenerator('leadsource', 'name', 'id', $selected_value=""," where status='0'"); ?>
							</select> -->
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
						    echo optionsGenerator($leadstage,$data['lead_stage']); 
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
				<div>
					<div class="row-fluid" style="background-color:#6d6d6d;margin-bottom:15px;">
					<h3 style="padding-left:10px">Client Details</h3>
				</div>
				<div class="row-fluid">
					<div class="span4 ">
	 				<div class="control-group">
	 				 <label class="control-label"> Salutation <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<!-- <input tabindex="7" type="text" placeholder="Please Enter Salutation" value="<?php //echo isset($data)?$data['client_salutation']:''; ?>" id="client_salutation" name="client_salutation" class="m-wrap span12"> -->
	 						<select tabindex="5" id="client_salutation" name="client_salutation" class="m-wrap span12">
	 							<option>Please Select Salutation</option>
	 							<option value="Mr" <?php if($data['client_salutation'] == 'Mr'): echo "selected"; else: ""; endif; ?>>Mr.</option>
	 							<option value="Ms" <?php if($data['client_salutation'] == 'Ms'): echo "selected"; else: ""; endif; ?>>Ms.</option>
	 							<option value="Dr" <?php if($data['client_salutation'] == 'Dr'): echo "selected"; else: ""; endif; ?>>Dr.</option>
	 						</select>
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
							
							<a href="javascript::void();" onclick="addAddressField()"><img src="<?php print IMAGEPATH;?>/plus.png"></a>
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
	 				 <label class="control-label">Service Inquiry1 <span class="required">*</span></label>
	 				 <div class="controls">
							<select tabindex="17" class="large m-wrap" id="service_inquiry1" name="service_inquiry1" onchange="getVaiantType(this.value,'varianttype1')">
						   <?php 
						   if($pricelist)
						   echo optionsGenerator($pricelist,$data['service_inquiry1']);
						   else
						   echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $data['service_inquiry1']," where status='0'"); ?>
							</select>
	 						<span class="help-block" id="service_inquiry1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Variant Type 1 <span class="required">*</span></label>
				 <div class="controls">
					 <select tabindex="18" class="large m-wrap" id="varianttype1" name="varianttype1" onchange="showPrice();">
						<?php
							if($leadmanager_id != '')
							echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype1']," where status='0'"); ?>
					 </select>
				 </div>
				</div>
			 </div>
				</div>
				<div class="row-fluid serviceDateTime1">
					<div class="span6 ">
					<div class="control-group">
					 <label class="control-label">Service1 Date <span class="required">*</span></label>
					 <div class="controls">
							<input tabindex="19" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service1_date']:''; ?>" id="service1_date" name="service1_date" class="m-wrap span12 datepicker">
							<span class="help-block" id="cost1_error"> </span>
					 </div>
					</div>
				 </div>
				<div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Service1 Time  <span class="required">*</span></label>
				 <div class="controls bootstrap-timepicker timepicker">
						<input tabindex="20" type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service1_time']:''; ?>" id="service1_time" name="service1_time" class="m-wrap span12">
						<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						<span class="help-block" id="service1_time_error"> </span>
				 </div>
				</div>
			 </div>
			</div>

				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry1 Booked <span class="required">*</span></label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter service inquiry1 booked" value="<?php //echo isset($data)?$data['service_inquiry1_booked']:''; ?>" id="service_inquiry1_booked" name="service_inquiry1_booked" class="m-wrap span12"> -->
	 						<label class="checkbox-inline"><input tabindex="21" type="radio" id="inquiry11" name="service_inquiry1_booked" value="yes" <?php if($data['service_inquiry1_booked']=='yes'): echo "checked"; else: ""; endif; ?> />Yes</label>
	 						<label class="checkbox-inline"><input tabindex="22" type="radio" id="inquiry12" name="service_inquiry1_booked" value="no" <?php if($data['service_inquiry1_booked']=='no'): echo "checked"; else: ""; endif; ?> />No</label>
	 						<span class="help-block" id="service_inquiry1_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
	 			 <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Variant 1 </label>
	 				 <div class="controls">
	 						<input tabindex="23" type="text" placeholder="Please Enter Variant" value="<?php echo isset($data)?$data['sqft1']:''; ?>" id="sqft1" name="sqft1" class="m-wrap span12">
	 						<span class="help-block" id="sqft1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
	 			 
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry2 <!--<span class="required">*</span>--></label>
	 				 <div class="controls">

							<select tabindex="24" class="large m-wrap" id="service_inquiry2" name="service_inquiry2" onchange="getVaiantType(this.value,'varianttype2')" >
							 <?php  echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $data['service_inquiry2']," where status='0'"); ?>
							</select>
	 						<span class="help-block" id="service_inquiry2_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span6 ">
				 <div class="control-group">
					<label class="control-label">Variant Type 2 </label>
					<div class="controls">
						<select tabindex="25" class="large m-wrap" id="varianttype2" name="varianttype2" onchange="showPrice();">
						 <?php  if($leadmanager_id != '')  echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype2']," where status='0'"); ?>
						</select>
					</div>
				 </div>
				</div>
				</div>
				<div class="row-fluid serviceDateTime2">
					<div class="span6 ">
					<div class="control-group">
					 <label class="control-label">Service2 Date </label>
					 <div class="controls">
							<input tabindex="26" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service2_date']:''; ?>" id="service2_date" name="service2_date" class="m-wrap span12 datepicker">
							<span class="help-block" id="cost2_error"> </span>
					 </div>
					</div>
				 </div>
				<div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Service2 Time </label>
				 <div class="controls bootstrap-timepicker timepicker">
						<input tabindex="27" type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service2_time']:''; ?>" id="service2_time" name="service2_time" class="m-wrap span12">
						<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
						<span class="help-block" id="service2_time_error"> </span>
				 </div>
				</div>
			 </div>
			</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry2 Booked <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<label class="checkbox-inline"><input tabindex="28" type="radio" id="inquiry11" name="service_inquiry2_booked" value="yes" <?php if($data['service_inquiry2_booked']=='yes'): echo "checked"; else: ""; endif; ?>/>Yes</label>
	 						<label class="checkbox-inline"><input tabindex="29" type="radio" id="inquiry12" name="service_inquiry2_booked" value="no" <?php if($data['service_inquiry2_booked']=='no'): echo "checked"; else: ""; endif; ?>/>No</label>
	 						<span class="help-block" id="service_inquiry2_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
	 			  <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Variant 2 </label>
	 				 <div class="controls">
	 						<input tabindex="30" type="text" placeholder="Please Enter Variant" value="<?php echo isset($data)?$data['sqft2']:''; ?>" id="sqft2" name="sqft2" class="m-wrap span12">
	 						<span class="help-block" id="sqft1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry3 <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter service inquiry3" value="<?php echo isset($data)?$data['service_inquiry3']:''; ?>" id="service_inquiry3" name="service_inquiry3" class="m-wrap span12"> -->
							<select tabindex="31" class="large m-wrap" id="service_inquiry3" name="service_inquiry3" onchange="getVaiantType(this.value,'varianttype3')">
							 <?php  echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $data['service_inquiry3']," where status='0'"); ?>
							</select>
							<span class="help-block" id="service_inquiry3_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span6 ">
					<div class="control-group">
					 <label class="control-label">Variant Type 3 </label>
					 <div class="controls">
						 <select tabindex="32" class="large m-wrap" id="varianttype3" name="varianttype3" onchange="showPrice();">
							<?php if($leadmanager_id != '') echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype3']," where status='0'"); ?>
						 </select>
					 </div>
					</div>
				 </div>
				</div>
				<div class="row-fluid serviceDateTime3">
					<div class="span6 ">
					<div class="control-group">
						<label class="control-label">Service3 Date </label>
						 <div class="controls">
								<input tabindex="33" type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service3_date']:''; ?>" id="service3_date" name="service3_date" class="m-wrap span12 datepicker">
								<span class="help-block" id="cost2_error"> </span>
						 </div>
						</div>
				 	</div>
					<div class="span6 ">
						<div class="control-group">
							<label class="control-label">Service3 Time </label>
						 	<div class="controls bootstrap-timepicker timepicker">
								<input tabindex="34" type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service3_time']:''; ?>" id="service3_time" name="service3_time" class="m-wrap span12">
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								<span class="help-block" id="service2_time_error"> </span>
						 	</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry3 Booked <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<label class="checkbox-inline"><input tabindex="35" type="radio" id="inquiry11" name="service_inquiry3_booked" value="yes" <?php if($data['service_inquiry3_booked']=='yes'): echo "checked"; else: ""; endif; ?> />Yes</label>
	 						<label class="checkbox-inline"><input tabindex="36" type="radio" id="inquiry12" name="service_inquiry3_booked" value="no" <?php if($data['service_inquiry3_booked']=='no'): echo "checked"; else: ""; endif; ?> />No</label>
	 						<span class="help-block" id="service_inquiry3_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
	 			  <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Variant 3 </label>
	 				 <div class="controls">
	 						<input tabindex="37" type="text" placeholder="Please Enter Variant" value="<?php echo isset($data)?$data['sqft3']:''; ?>" id="sqft3" name="sqft3" class="m-wrap span12">
	 						<span class="help-block" id="sqft1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Note <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
						 <textarea tabindex="38" rows="3" name="additional_note" id="additional_note" class="m-wrap span12"><?php echo isset($data)?trim($data['additional_note']):''; ?></textarea>
	 						<!-- <input type="text" placeholder="Please Enter additional note" value="<?php echo isset($data)?$data['additional_note']:''; ?>" id="additional_note" name="additional_note" class="m-wrap span12"> -->
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
	 				 <label class="control-label">Price <span class="required">*</span></label>
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
	 				 <label class="control-label">Partner Receivable <span class="required">*</span></label>
	 				 	<div class="controls">
	 						<input tabindex="45" type="text" placeholder="Please Enter Partner Amount" value="<?php echo isset($data)?$data['partner_amount']:''; ?>" id="partner_amount" name="partner_amount" class="m-wrap span12">
	 						<span class="help-block" id="commission_error"> </span>
	 				 	</div>
	 				</div>
	 			 	</div>
				</div>

				<div class="row-fluid">
					<div class="span6" class="partner_mode_row">
	 				<div class="control-group">
	 				 <label class="control-label">Partner Payable <span class="required">*</span></label>
	 				 	<div class="controls">
	 						<input tabindex="45" type="text" placeholder="Please Enter Partner Amount" value="<?php echo isset($data)?$data['partner_payable']:''; ?>" id="partner_payable" name="partner_payable" class="m-wrap span12">
	 						<span class="help-block" id="partner_payable_error"> </span>
	 				 	</div>
	 				</div>
	 			 	</div>
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Commission <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input tabindex="46" type="text" placeholder="Please Enter Commission" value="<?php echo isset($data)?$data['commission']:''; ?>" id="commission" name="commission" class="m-wrap span12">
	 						<span class="help-block" id="commission_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Billing Amount <span class="required">*</span></label>
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
        	<div id="listaddress">
        		<ul id="listAddress">
        		<?php 

        		$addresses= $modelObj->getAddressTable($data['mhcclient_id']);
        		foreach ($addresses as $add) {
        			echo "<li>".$add['address']."</li>";
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

	$('#service1_date').datepicker({
  	format:'yyyy/mm/dd'
  });

	$('#reminder').datepicker({
  	format:'dd-mm-yyyy'
  });

	if($('#lead_stage option:selected').text()!='Closed'){
		$('.serviceDateTime1').hide();
		$('.serviceDateTime2').hide();
		$('.serviceDateTime3').hide();
	}else{
		$('.serviceDateTime1').show();
		$('.serviceDateTime2').show();
		$('.serviceDateTime3').show();
	}
	$('#lead_stage').change(function(){
		if($('#lead_stage option:selected').text()!='Closed'){
			$('.serviceDateTime1').hide();
			$('.serviceDateTime2').hide();
			$('.serviceDateTime3').hide();
		}else{
			$('.serviceDateTime1').show();
			$('.serviceDateTime2').show();
			$('.serviceDateTime3').show();
		}
	});
	$('#lead_stage').change(function(){
		if($('#lead_stage').text() == 'Closed')
   			$('#service1_time').timepicker();
	});
	

	 $('#service2_date').datepicker({
		 format:'yyyy/mm/dd'
		});
		 $('#service2_time').timepicker();

		 $('#service3_date').datepicker({
			 format:'yyyy/mm/dd'
			});

			 $('#service3_time').timepicker();
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


function saveData(frm_id, action){
        // alert('Jai Mata Di............' + frm_id);
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
    	$("#address_modal").modal('toggle');
    }

    function addAddressField(){
    	var html = '<br /><br /><textarea tabindex="11" rows="3" name="address1[]" class="m-wrap span9"></textarea>';
    	$('#addressBlock').append(html);
    }

    function showPrice(){
		var inq1 = $('#service_inquiry1 :selected').text();
    	var inq2 = $('#service_inquiry2 :selected').text();
    	var inq3 = $('#service_inquiry3 :selected').text();
    	var city = $('#city').val();
    	var varianttype1 = $('#varianttype1').val();
    	var varianttype2 = $('#varianttype2').val();
    	var varianttype3 = $('#varianttype3').val();
    	// console.log(varianttype);
    	var source = $('#lead_source').val();
    	if(inq1!='' && city!='' && varianttype1!=''){
    		$.ajax({
    			 type: "POST",
                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
                data: {city:city,inq1:inq1,inq2:inq2,inq3:inq3,varianttype1:varianttype1,varianttype2:varianttype2,varianttype3:varianttype3,action:'getPrice'},
                success:function(res){
                	var obj = eval("("+res+")");
                	//console.log(obj);
                	taxed_cost
                	$('#taxed_cost').val(obj.result);
                	var price = parseFloat(obj.result)- 0.15*parseFloat(obj.result);
                	// debugger;
                	$('#price').val(price);
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

    function getVaiantType(id,service){

	  	$.ajax({
	        type: "POST",
	        url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
	        data: {action:'getVaiantType',id:id,service:service},
	        success: function(vartypes){
	        	var jObj1=eval("("+vartypes+")");
	        	console.log(jObj1.result);
	        	var options = '<option value="">Please Select</option>';
	        	$.each(jObj1.result,function(i,e){
	        		options += '<option value="'+e.id+'">'+e.varianttype+'</option>';
	        	});
	        	$('#'+service).html(options);
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
