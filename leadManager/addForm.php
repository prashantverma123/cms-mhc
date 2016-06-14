<?php
if($leadmanager_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($leadmanager_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
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
						   <?php  echo $modelObj->optionsGenerator('leadsource', 'name', 'id', $data['lead_source']," where status='0'"); ?>
							</select>
						</div>
					 </div>
				  </div>

					<div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Owner<span class="required">*</span></label>
						<div class="controls">
							<!-- <select tabindex="1" class="large m-wrap" id="category_id" name="category_id">
						   <?php  echo $modelObj->optionsGenerator('leadsource', 'name', 'id', $selected_value=""," where status='0'"); ?>
							</select> -->
							<input type="text" placeholder="Please Enter Lead Owner" value="<?php echo isset($data)?$data['lead_owner']:''; ?>" id="lead_owner" name="lead_owner" class="m-wrap span12">
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
							<select tabindex="1" class="large m-wrap" id="lead_stage" name="lead_stage">
						   <?php  echo $modelObj->optionsGenerator('leadstage', 'name', 'id',$data['lead_stage']," where status='0'"); ?>
							</select>
						</div>
					 </div>
				  </div>

			   </div>



				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label"> 	Team Leader </label>
	 				 <div class="controls">
						 <select tabindex="1" class="medium m-wrap" id="teamLeader_deployment" name="teamLeader_deployment">
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
						<select tabindex="1" class="medium m-wrap" id="supervisor_deployment" name="supervisor_deployment">
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
					 <select tabindex="1" class="medium m-wrap" id="janitor_deployment" name="janitor_deployment">
						<?php  echo $modelObj->optionsGeneratorByIndex(10); ?>
					 </select>
						<span class="help-block" id="janitor_deployment_error"> </span>
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
	 						<input type="text" placeholder="Please Enter Salutation" value="<?php echo isset($data)?$data['client_salutation']:''; ?>" id="client_salutation" name="client_salutation" class="m-wrap span12">
	 						<span class="help-block" id="client_salutation_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span4 ">
				 <div class="control-group">
					<label class="control-label">Firstname <span class="required">*</span></label>
					<div class="controls">
						 <input type="text" placeholder="Please Enter Firstname" value="<?php echo isset($data)?$data['client_firstname']:''; ?>" id="client_firstname" name="client_firstname" class="m-wrap span12">
						 <span class="help-block" id="client_firstname_error"> </span>
					</div>
				 </div>
				</div>


				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">Lastname <span class="required">*</span></label>
				 <div class="controls">
						<input type="text" placeholder="Please Enter Lastname" value="<?php echo isset($data)?$data['client_lastname']:''; ?>" id="client_lastname" name="client_lastname" class="m-wrap span12">
						<span class="help-block" id="client_lastname_error"> </span>
				 </div>
				</div>
			 </div>
				</div>


			  <div class="row-fluid">
					<div class="span4 ">
	 				<div class="control-group">
	 				 <label class="control-label">Mobile No <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Mobile No" value="<?php echo isset($data)?$data['client_mobile_no']:''; ?>" id="client_mobile_no" name="client_mobile_no" class="m-wrap span12">
	 						<span class="help-block" id="client_mobile_no_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>

				 <div class="span4 ">
				 <div class="control-group">
					<label class="control-label">Alternate no <!--<span class="required">*</span>--></label>
					<div class="controls">
						 <input type="text" placeholder="Please Enter Alternate No" value="<?php echo isset($data)?$data['alternate_no']:''; ?>" id="alternate_no" name="alternate_no" class="m-wrap span12">
						 <span class="help-block" id="alternate_no_error"> </span>
					</div>
				 </div>
				</div>

				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">client email id <!--<span class="required">*</span>--></label>
				 <div class="controls">
						<input type="text" placeholder="Please Enter client email id" value="<?php echo isset($data)?$data['client_email_id']:''; ?>" id="client_email_id" name="client_email_id" class="m-wrap span12">
						<span class="help-block" id="client_email_id_error"> </span>
				 </div>
				</div>
			 </div>
				</div>


				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">

	 				 <label class="control-label">Address <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
						  <textarea rows="3" name="address" id="address" class="m-wrap span12"><?php echo isset($data)?trim($data['address']):''; ?></textarea>
	 						<!-- <input type="text" placeholder="Please Enter address" value="<?php echo isset($data)?$data['address']:''; ?>" id="address" name="address" class="m-wrap span12"> -->
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
							<input type="text" placeholder="Please Enter landmark" value="<?php echo isset($data)?$data['landmark']:''; ?>" id="landmark" name="landmark" class="m-wrap span12">
							<span class="help-block" id="landmark_error"> </span>
					 </div>
					</div>
				 </div>
					<div class="span6 ">
	 				<div class="control-group">

	 				 <label class="control-label">location <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Location" value="<?php echo isset($data)?$data['location']:''; ?>" id="location" name="location" class="m-wrap span12">
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
							<select tabindex="1" class="medium m-wrap" id="city" name="city">
						   <?php  echo $modelObj->optionsGenerator('city', 'name', 'id', $data['city']," where status='0'"); ?>
							</select>
							<span class="help-block" id="city_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>


				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">State <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter state" value="<?php echo isset($data)?$data['state']:''; ?>" id="state" name="state" class="m-wrap span12">
	 						<span class="help-block" id="state_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>


				<div class="span4 ">
				<div class="control-group">
				 <label class="control-label">Pincode <!--<span class="required">*</span>--></label>
				 <div class="controls">
						<input type="text" placeholder="Please Enter pincode" value="<?php echo isset($data)?$data['pincode']:''; ?>" id="pincode" name="pincode" class="m-wrap span12">
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
	 						<!-- <input type="text" placeholder="Please Enter service inquiry" value="<?php echo isset($data)?$data['service_inquiry1']:''; ?>" id="service_inquiry1" name="service_inquiry1" class="m-wrap span12"> -->
							<select tabindex="1" class="large m-wrap" id="service_inquiry1" name="service_inquiry1">
						   <?php  echo $modelObj->optionsGenerator('pricelist', 'name', 'id', $data['service_inquiry1']," where status='0'"); ?>
							</select>
	 						<span class="help-block" id="service_inquiry1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				 <div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Variant Type 1 <span class="required">*</span></label>
				 <div class="controls">
					 <select tabindex="1" class="large m-wrap" id="varianttype1" name="varianttype1" onchange="showPrice();">
						<?php  echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype1']," where status='0'"); ?>
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
							<input type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service1_date']:''; ?>" id="service1_date" name="service1_date" class="m-wrap span12 datepicker">
							<span class="help-block" id="cost1_error"> </span>
					 </div>
					</div>
				 </div>
				<div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Service1 Time  <span class="required">*</span></label>
				 <div class="controls bootstrap-timepicker timepicker">
						<input type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service1_time']:''; ?>" id="service1_time" name="service1_time" class="m-wrap span12">
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
	 						<label class="checkbox-inline"><input type="radio" id="inquiry11" name="service_inquiry1_booked" value="yes" <?php if($data['service_inquiry1_booked']=='yes'): echo "checked"; else: ""; endif; ?> />Yes</label>
	 						<label class="checkbox-inline"><input type="radio" id="inquiry12" name="service_inquiry1_booked" value="no" <?php if($data['service_inquiry1_booked']=='no'): echo "checked"; else: ""; endif; ?> />No</label>
	 						<span class="help-block" id="service_inquiry1_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry2 <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter service inquiry2" value="<?php echo isset($data)?$data['service_inquiry2']:''; ?>" id="service_inquiry2" name="service_inquiry2" class="m-wrap span12"> -->
							<select tabindex="1" class="large m-wrap" id="service_inquiry2" name="service_inquiry2">
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
						<select tabindex="1" class="large m-wrap" id="varianttype2" name="varianttype2" onchange="showPrice();">
						 <?php  echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype2']," where status='0'"); ?>
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
							<input type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service2_date']:''; ?>" id="service2_date" name="service2_date" class="m-wrap span12 datepicker">
							<span class="help-block" id="cost2_error"> </span>
					 </div>
					</div>
				 </div>
				<div class="span6 ">
				<div class="control-group">
				 <label class="control-label">Service2 Time </label>
				 <div class="controls bootstrap-timepicker timepicker">
						<input type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service2_time']:''; ?>" id="service2_time" name="service2_time" class="m-wrap span12">
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
	 						<label class="checkbox-inline"><input type="radio" id="inquiry11" name="service_inquiry2_booked" value="yes" <?php if($data['service_inquiry2_booked']=='yes'): echo "checked"; else: ""; endif; ?>/>Yes</label>
	 						<label class="checkbox-inline"><input type="radio" id="inquiry12" name="service_inquiry2_booked" value="no" <?php if($data['service_inquiry2_booked']=='no'): echo "checked"; else: ""; endif; ?>/>No</label>
	 						<span class="help-block" id="service_inquiry2_booked_error"> </span>
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
							<select tabindex="1" class="large m-wrap" id="service_inquiry3" name="service_inquiry3">
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
						 <select tabindex="1" class="large m-wrap" id="varianttype3" name="varianttype3" onchange="showPrice();">
							<?php  echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype3']," where status='0'"); ?>
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
								<input type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service3_date']:''; ?>" id="service3_date" name="service3_date" class="m-wrap span12 datepicker">
								<span class="help-block" id="cost2_error"> </span>
						 </div>
						</div>
				 	</div>
					<div class="span6 ">
						<div class="control-group">
							<label class="control-label">Service3 Time </label>
						 	<div class="controls bootstrap-timepicker timepicker">
								<input type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service3_time']:''; ?>" id="service3_time" name="service3_time" class="m-wrap span12">
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
	 						<label class="checkbox-inline"><input type="radio" id="inquiry11" name="service_inquiry3_booked" value="yes" <?php if($data['service_inquiry3_booked']=='yes'): echo "checked"; else: ""; endif; ?> />Yes</label>
	 						<label class="checkbox-inline"><input type="radio" id="inquiry12" name="service_inquiry3_booked" value="no" <?php if($data['service_inquiry3_booked']=='no'): echo "checked"; else: ""; endif; ?> />No</label>
	 						<span class="help-block" id="service_inquiry3_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Note <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
						 <textarea rows="3" name="additional_note" id="additional_note" class="m-wrap span12"><?php echo isset($data)?trim($data['additional_note']):''; ?></textarea>
	 						<!-- <input type="text" placeholder="Please Enter additional note" value="<?php echo isset($data)?$data['additional_note']:''; ?>" id="additional_note" name="additional_note" class="m-wrap span12"> -->
	 						<span class="help-block" id="additional_note_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>

				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Promo Code <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Promo Code" value="<?php echo isset($data)?$data['promo_code']:''; ?>" id="promo_code" name="promo_code" class="m-wrap span12">
	 						<span class="help-block" id="promo_code_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Discount <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Discount" value="<?php echo isset($data)?$data['discount']:''; ?>" id="discount" name="discount" class="m-wrap span12">
	 						<span class="help-block" id="discount_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Price <span class="required">*</span></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Price" value="<?php echo isset($data)?$data['price']:''; ?>" id="price" name="price" class="m-wrap span12">
	 						<span class="help-block" id="price_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Commission <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Commission" value="<?php echo isset($data)?$data['commission']:''; ?>" id="commission" name="commission" class="m-wrap span12">
	 						<span class="help-block" id="commission_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Taxed Cost <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter taxed cost" value="<?php echo isset($data)?$data['taxed_cost']:''; ?>" id="taxed_cost" name="taxed_cost" class="m-wrap span12">
	 						<span class="help-block" id="taxed_cost_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				</div>

			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_lead_manager','saveLeadManager');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/cms/leadManager/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
$(document).ready(function(){
	$('#service1_date').datepicker({
  	format:'yyyy/mm/dd'
  });

	if($('#lead_stage').val()!='closed'){
		$('.serviceDateTime1').hide();
		$('.serviceDateTime2').hide();
		$('.serviceDateTime3').hide();
	}else{
		$('.serviceDateTime1').show();
		$('.serviceDateTime2').show();
		$('.serviceDateTime3').show();
	}
	$('#lead_stage').change(function(){
		if($('#lead_stage').val()!='closed'){
			$('.serviceDateTime1').hide();
			$('.serviceDateTime2').hide();
			$('.serviceDateTime3').hide();
		}else{
			$('.serviceDateTime1').show();
			$('.serviceDateTime2').show();
			$('.serviceDateTime3').show();
		}
	});
   $('#service1_time').timepicker();

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
	                    //$("#result").html('there is error while submit');
	                }

	            });
	        }

        	return false;
			}
    	});


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
                	console.log(obj);
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
		window.location.href = "<?php SITEPATH;?>/cms/<?php echo $modelObj->folderName; ?>/display.php?leadmanager_id="+res_product_id+"&flag=t";
		<?php } ?>
    }

</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
