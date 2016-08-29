<?php
if($source_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($source_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About Lead Source</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_lead_source" id="frm_lead_source">
		 <input type="hidden" name="action" value="saveLeadSource"/>
		 <input type="hidden" name="source_id" value="<?php print $source_id;?>"/>
			   <h3 class="form-section">Lead Source Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Source Name<span class="required">*</span></label>
						<div class="controls">
						   <input type="text" placeholder="Please enter lead source name" value="<?php echo isset($data)?$data['name']:''; ?>" id="source_name" name="source_name" class="m-wrap span12">
						   <span class="help-block" id="source_name_error"> </span>
						</div>
					 </div>
				  </div>

				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Is Vendor</label>
						<div class="controls">
						   <input type="checkbox" <?php echo (isset($_POST['is_partner'])?"value='1'":"value='0'")?> <?php if($data['is_partner']=='0'): echo "checked"; else: ""; endif; ?> id="is_partner" name="is_partner" class="m-wrap span12">
						   <span class="help-block" id="is_partner_error"> </span>
						</div>
					 </div>
				  </div>


				  <!--/span-->

				  <!--/span-->
			   </div>
			   <div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Parent Source<!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 				 	<select class="medium m-wrap" id="parent_id" name="parent_id">				   
						   <?php echo $modelObj->optionsGenerator('leadsource', 'name', 'id', ""," where parent_id='-1'"); ?>
						</select>
	 						<!-- <input type="checkbox" <?php echo (isset($_POST['parent_id'])?"value='1'":"value='0'")?> <?php if($data['parent_id']=='0'): echo "checked"; else: ""; endif; ?> id="is_partner" name="is_partner" class="m-wrap span12"> -->
	 						<span class="help-block" id="parent_id_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
 					 <div class="control-group">
 						<label class="control-label">Source URL <span class="required">*</span></label>
 						<div class="controls">
 						   <input type="text" placeholder="Please enter lead source URL" value="<?php echo isset($data)?$data['source_url']:''; ?>" id="source_url" name="source_url" class="m-wrap span12">
 						   <span class="help-block" id="source_url_error"> </span>
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
	 						<input type="text" placeholder="Please enter lead source phone" value="<?php echo isset($data)?$data['source_phone']:''; ?>" id="source_phone" name="source_phone" class="m-wrap span12">
	 						<span class="help-block" id="source_phone_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
			   </div>
			   <div class="row-fluid">
					<div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Contact Email ID<!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please enter contact Email ID" value="<?php echo isset($data)?$data['source_email_id']:''; ?>" id="source_email_id" name="source_email_id" class="m-wrap span12">
	 						<span class="help-block" id="source_email_id_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
 					<div class="control-group">
 					 <label class="control-label">Address <!--<span class="required">*</span>--></label>
 					 <div class="controls">
 						
									<textarea rows="3" name="source_address" id="source_address" class="m-wrap span12"><?php echo isset($data)?$data['source_address']:''; ?></textarea>
 							<span class="help-block" id="source_address_error"> </span>
 					 </div>
 					</div>
 				 </div>

				  <!--/span-->
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Commission <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Commission Type" value="<?php echo isset($data)?$data['commission_type']:''; ?>" id="commission_type" name="commission_type" class="m-wrap span12">
	 						<span class="help-block" id="commission_type_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>

			   </div>


			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_lead_source','saveLeadSource');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/leadSource/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($source_id != '' && $flag != 'new'){ ?>
$(document).ready(function() {
  change_tab(1);
});
<?php }else if($flag=='new'){ ?>
$(document).ready(function() {
  change_tab('new');
});
<?php } ?>
function saveData(frm_id, action){
        //alert('Jai Mata Di............' + frm_id);
         $('#frm_lead_source').validate({
		rules:{
			source_name:"required",
			/*source_email_id:"email",*/
			source_url:{
				required:true,
				url:true
			},
			commission_type:{
				number:true	
			}
		},
		submitHandler: function() {
        $('.error').hide();
        var flag=0;
        var source_name = $('#source_name').val();
		if(source_name=="")
            {
                //$('#source_name_error').show();
                $('#source_name').attr('placeholder' ,'Please Enter source Name');
                $('#source_name').addClass('alert-error');
                $('#source_name').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
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

    function getData(success){ //alert('Jmd................');
        var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_source_id=jObj.source_id; //alert('AA'+res_source_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($source_id =='' || $source_id == 0){ ?>
		window.location.href = "<?php echo SITEPATH;?>/<?php echo $modelObj->folderName; ?>/display.php";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
