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
						<label class="control-label">Source <!--<span class="required">*</span>--></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter Lead Source Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="source_name" name="source_name" class="m-wrap span12">
						   <span class="help-block" id="source_name_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->

				  <!--/span-->
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
 					 <div class="control-group">
 						<label class="control-label">Source Url <!--<span class="required">*</span>--></label>
 						<div class="controls">
 						   <input type="text" placeholder="Please Enter Lead source Url" value="<?php echo isset($data)?$data['source_url']:''; ?>" id="source_url" name="source_url" class="m-wrap span12">
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
	 						<input type="text" placeholder="Please Enter Lead source Phone" value="<?php echo isset($data)?$data['source_phone']:''; ?>" id="source_phone" name="source_phone" class="m-wrap span12">
	 						<span class="help-block" id="source_phone_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				  <!--/span-->

				  <!--/span-->
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
                url: "<?php print SITEPATH;?>/leadSource/category2db.php",
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
        var res_source_id=jObj.source_id; //alert('AA'+res_source_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($source_id =='' || $source_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/leadSource/display.php?source_id="+res_source_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
