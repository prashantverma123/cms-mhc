<?php
if($employee_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($employee_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About Employee Details</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_employee_data" id="frm_employee_data">
		 <input type="hidden" name="action" value="saveEmployee"/>
		 <input type="hidden" name="employee_id" value="<?php print $employee_id;?>"/>
			   <h3 class="form-section">Employee Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Name <!--<span class="required">*</span>--></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="name" name="name" class="m-wrap span12">
						   <span class="help-block" id="name_error"> </span>

						</div>
					 </div>
				  </div>
				  <!--/span-->

				  <!--/span-->
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
 					 <div class="control-group">
 						<label class="control-label">Email Id <!--<span class="required">*</span>--></label>
 						<div class="controls">
 						   <input type="text" placeholder="Please Enter Email Id" value="<?php echo isset($data)?$data['email']:''; ?>" id="email" name="email" class="m-wrap span12">
 						   <span class="help-block" id="email_error"> </span>
 						</div>
 					 </div>
 				  </div>
				  <!--/span-->
				  <div class="span6 ">

				  </div>
				  <!--/span-->
			   </div>

				<div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Contact No <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Contact No" value="<?php echo isset($data)?$data['mobile_no']:''; ?>" id="mobile_no" name="mobile_no" class="m-wrap span12">
	 						<span class="help-block" id="mobile_no_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				  <!--/span-->

				  <!--/span-->
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
 					<div class="control-group">
 					 <label class="control-label">City <!--<span class="required">*</span>--></label>
 					 <div class="controls">
 							<input type="text" placeholder="Please Enter City" value="<?php echo isset($data)?$data['city']:''; ?>" id="city" name="city" class="m-wrap span12">
 							<span class="help-block" id="city_error"> </span>

 					 </div>
 					</div>
 				 </div>

				  <!--/span-->
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Designation  <!--<span class="required">*</span>--></label>
	 				 <div class="controls">

							<select tabindex="1" class="large m-wrap" id="designation" name="designation">
							<option value="" >Select the Designation</option>
							<option value="Janitor" >Janitor</option>
							<option value="Supervisor" >Supervisor</option>
							<option value="Team Leader" >Team Leader</option>
							<option value="Pest Control Technician" >Pest Control Technician</option>
							<option value="AC Servicing Technician" >AC Servicing Technician</option>
							<option value="Inspection Officer" >Inspection Officer</option>

						</select>
	 				 </div>
	 				</div>
	 			 </div>

			   </div>

				 <div class="row-fluid">

					<div class="span6 ">
				 <div class="control-group">
					<label class="control-label">Gender <!--<span class="required">*</span>--></label>
					<div class="controls">
						<select tabindex="1" class="large m-wrap" id="gender" name="gender">
						<option value="" >Select the Gender</option>
						<option value="M" >Male</option>
						<option value="F" >Female</option>
						</select>
					</div>
				 </div>
				</div>

				</div>


			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_employee_data','saveEmployee');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/employee/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($employee_id != '' && $flag != 'new'){ ?>
$(document).ready(function() {
  change_tab(1);
});
<?php }else if($flag=='new'){ ?>
$(document).ready(function() {
  change_tab('new');
});
<?php } ?>
function saveData(frm_id, action){
        alert('Jai Mata Di............' + frm_id);
        $('.error').hide();
        var flag=0;
        var employee_id = $('#employee_id').val();
		if(employee_id=="")
            {
                //$('#employee_id_error').show();
                $('#employee_id').attr('placeholder' ,'Please Enter Categry Id');
                $('#employee_id').addClass('alert-error');
                $('#employee_id').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }
							console.log("flagvalue.............");
	console.log(flag);
        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
						console.log(datastring);
						alert('Jai Mata Di............' + datastring);
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/employee/category2db.php",
                data: datastring,
                success: function(data){getData(data);},
                error:function(){
                    alert("failure");
                    //$("#result").html('there is error while submit');
                }

            });
        }

        return false;
    }

    function getData(success){ alert('Jmd................');
        var jObj=eval("("+success+")");
				console.log("Test",jObj);
        var res_action=jObj.action; //alert('AAs');
        var res_employee_id=jObj.employee_id; alert('AA'+res_employee_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($employee_id =='' || $employee_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/employee/display.php?employee_id="+res_employee_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
