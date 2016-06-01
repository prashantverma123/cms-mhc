<?php
if($lead_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($lead_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About Cities</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_lead_stage" id="frm_lead_stage">
		 <input type="hidden" name="action" value="saveLead"/>
		 <input type="hidden" name="lead_id" value="<?php print $lead_id;?>"/>
			   <h3 class="form-section">Lead Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Name <span class="required">*</span></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter Lead Stage" value="<?php echo isset($data)?$data['name']:''; ?>" id="lead_stage" name="lead_stage" class="m-wrap span12">
						   <span class="help-block" id="lead_stage_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group error">

					 </div>
				  </div>
				  <!--/span-->
			   </div>

				<div class="row-fluid">
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Order<span class="required">*</span></label>
						<div class="controls">
							 <input type="text" placeholder="Please Enter Lead Order" value="<?php echo isset($data)?$data['lead_order']:''; ?>" id="lead_order" name="lead_order" class="m-wrap span12">
							 <span class="help-block" id="lead_order_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>



			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_lead_stage','saveLeadStage');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/lead/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/leadStage/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($lead_id != '' && $flag != 'new'){ ?>
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
        $('#frm_lead_stage').validate({
		rules:{
			lead_stage:"required",
			lead_order:{
				required:true,
				number:true
			}
		},
		submitHandler: function() {
        $('.error').hide();
        var flag=0;
        var lead_stage = $('#lead_stage').val();
		if(lead_stage=="")
            {
                //$('#lead_stage_error').show();
                $('#lead_stage').attr('placeholder' ,'Please Enter Lead Stage');
                $('#lead_stage').addClass('alert-error');
                $('#lead_stage').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/leadStage/category2db.php",
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
        var res_lead_id=jObj.lead_id; //alert('AA'+res_lead_stage_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($lead_id =='' || $lead_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/leadStage/display.php?lead_id="+res_lead_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
