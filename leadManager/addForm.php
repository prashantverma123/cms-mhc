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
						<label class="control-label">Lead Source <!--<span class="required">*</span>--></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="lead_source" name="lead_source">
						   <?php  echo $modelObj->optionsGenerator('leadsource', 'name', 'id', $data['lead_source']," where status='0'"); ?>
							</select>
						</div>
					 </div>
				  </div>
			   </div>
			      <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Owner<!--<span class="required">*</span>--></label>
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
<!-- 			   <div class="row-fluid">
					 <div class="span6 ">
 					 <div class="control-group">
 						<label class="control-label">Job Status</label>
 						<div class="controls">
 						   	<select id="job_status" name="job_status" tabindex="1" class="large m-wrap">
 						   		<option value="pending" <?php if($data['job_status']=='pending'): echo "selected";else: echo "";endif; ?>>Pending</option>
 						   		<option value="proccessed" <?php if($data['job_status']=='in_process'): echo "selected";else: echo "";endif; ?>>In Process</option>
 						   		<option value="done" <?php if($data['job_status']=='confirmed'): echo "selected";else: echo "";endif; ?>>Confirmed</option>
 						   	</select>
 						</div>
 					 </div>
 				  </div>
				  <div class="span6 ">
				  </div>
			   </div> -->
			    <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Stage <!--<span class="required">*</span>--></label>
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
	 				 <label class="control-label">Service Date  <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Service Date" value="<?php echo isset($data)?$data['service_date']:''; ?>" id="service_date" name="service_date" class="m-wrap span12 datepicker">
	 						<span class="help-block" id="cost_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				  <div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Time  <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Service Time" value="<?php echo isset($data)?$data['service_time']:''; ?>" id="service_time" name="service_time" class="m-wrap span12">
	 						<span class="help-block" id="service_time_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label"> 	Manpower Deployment  <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Manpower Deployment" value="<?php echo isset($data)?$data['manpower_deployment']:''; ?>" id="manpower_deployment" name="manpower_deployment" class="m-wrap span12">
	 						<span class="help-block" id="manpower_deployment_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label"> 	Client Salutation <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter client_salutation" value="<?php echo isset($data)?$data['client_salutation']:''; ?>" id="client_salutation" name="client_salutation" class="m-wrap span12">
	 						<span class="help-block" id="client_salutation_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">client firstname <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter client_firstname" value="<?php echo isset($data)?$data['client_firstname']:''; ?>" id="client_firstname" name="client_firstname" class="m-wrap span12">
	 						<span class="help-block" id="client_firstname_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">client lasttname <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter client_lasttname" value="<?php echo isset($data)?$data['client_lasttname']:''; ?>" id="client_lasttname" name="client_lasttname" class="m-wrap span12">
	 						<span class="help-block" id="client_lasttname_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
			  <div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">client mobile no <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter client_mobile_no" value="<?php echo isset($data)?$data['client_mobile_no']:''; ?>" id="client_mobile_no" name="client_mobile_no" class="m-wrap span12">
	 						<span class="help-block" id="client_mobile_no_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">alternate no <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter alternate_no" value="<?php echo isset($data)?$data['alternate_no']:''; ?>" id="alternate_no" name="alternate_no" class="m-wrap span12">
	 						<span class="help-block" id="alternate_no_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">client email id <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter client_email_id" value="<?php echo isset($data)?$data['client_email_id']:''; ?>" id="client_email_id" name="client_email_id" class="m-wrap span12">
	 						<span class="help-block" id="client_email_id_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">address <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter address" value="<?php echo isset($data)?$data['address']:''; ?>" id="address" name="address" class="m-wrap span12">
	 						<span class="help-block" id="address_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">landmark <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter landmark" value="<?php echo isset($data)?$data['landmark']:''; ?>" id="landmark" name="landmark" class="m-wrap span12">
	 						<span class="help-block" id="landmark_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">location <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter location" value="<?php echo isset($data)?$data['location']:''; ?>" id="location" name="location" class="m-wrap span12">
	 						<span class="help-block" id="location_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">City <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter city" value="<?php echo isset($data)?$data['city']:''; ?>" id="city" name="city" class="m-wrap span12">
	 						<span class="help-block" id="city_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">State <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter state" value="<?php echo isset($data)?$data['state']:''; ?>" id="state" name="state" class="m-wrap span12">
	 						<span class="help-block" id="state_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Pincode <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter pincode" value="<?php echo isset($data)?$data['pincode']:''; ?>" id="pincode" name="pincode" class="m-wrap span12">
	 						<span class="help-block" id="pincode_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Additional Note <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter additional note" value="<?php echo isset($data)?$data['additional_note']:''; ?>" id="additional_note" name="additional_note" class="m-wrap span12">
	 						<span class="help-block" id="additional_note_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Service Inquiry <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service inquiry" value="<?php echo isset($data)?$data['service_inquiry1']:''; ?>" id="service_inquiry1" name="service_inquiry1" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry1_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">service inquiry1 booked <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service_inquiry1_booked" value="<?php echo isset($data)?$data['service_inquiry1_booked']:''; ?>" id="service_inquiry1_booked" name="service_inquiry1_booked" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry1_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">service inquiry2 <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service_inquiry2" value="<?php echo isset($data)?$data['service_inquiry2']:''; ?>" id="service_inquiry2" name="service_inquiry2" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry2_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">service inquiry2 booked <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service_inquiry2_booked" value="<?php echo isset($data)?$data['service_inquiry2_booked']:''; ?>" id="service_inquiry2_booked" name="service_inquiry2_booked" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry2_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">service inquiry3 <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service_inquiry3" value="<?php echo isset($data)?$data['service_inquiry3']:''; ?>" id="service_inquiry3" name="service_inquiry3" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry3_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">service inquiry3 booked <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter service_inquiry3_booked" value="<?php echo isset($data)?$data['service_inquiry3_booked']:''; ?>" id="service_inquiry3_booked" name="service_inquiry3_booked" class="m-wrap span12">
	 						<span class="help-block" id="service_inquiry3_booked_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">promo code <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter promo_code" value="<?php echo isset($data)?$data['promo_code']:''; ?>" id="promo_code" name="promo_code" class="m-wrap span12">
	 						<span class="help-block" id="promo_code_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">discount <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter discount" value="<?php echo isset($data)?$data['discount']:''; ?>" id="discount" name="discount" class="m-wrap span12">
	 						<span class="help-block" id="discount_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">price <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter price" value="<?php echo isset($data)?$data['price']:''; ?>" id="price" name="price" class="m-wrap span12">
	 						<span class="help-block" id="price_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">commission <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter commission" value="<?php echo isset($data)?$data['commission']:''; ?>" id="commission" name="commission" class="m-wrap span12">
	 						<span class="help-block" id="commission_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				</div>
				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">taxed cost <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter taxed_cost" value="<?php echo isset($data)?$data['taxed_cost']:''; ?>" id="taxed_cost" name="taxed_cost" class="m-wrap span12">
	 						<span class="help-block" id="taxed_cost_error"> </span>
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
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/leadManager/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
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
        $('.error').hide();
        var flag=0;
        var leadmanager_id = $('#leadmanager_id').val();
		if(leadmanager_id=="")
            {
                //$('#product_id_error').show();
                $('#leadmanager_idleadmanager_id').attr('placeholder' ,'Please Enter Categry Id');
                $('#leadmanager_id').addClass('alert-error');
                $('#leadmanager_id').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
						// alert('Jai Mata Di............' + datastring);
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/leadManager/category2db.php",
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

    function getData(success){ //alert('Jmd................');
    	
    	var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_product_id=jObj.leadmanager_id; //alert('AA'+res_product_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($leadmanager_id =='' || $leadmanager_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/leadManager/display.php?leadmanager_id="+res_product_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
