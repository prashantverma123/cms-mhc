<?php
if($city_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($city_id));
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
		 <form class="form-horizontal" action="" name="frm_city_master" id="frm_city_master">
		 <input type="hidden" name="action" value="saveCity"/>
		 <input type="hidden" name="city_id" value="<?php print $city_id;?>"/>
			   <h3 class="form-section">City Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Name <!--<span class="required">*</span>--></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter City Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="city_name" name="city_name" class="m-wrap span12">
						   <span class="help-block" id="city_name_error"> </span>
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
						<label class="control-label">City Tier</label>
						<div class="controls">
							 <input type="text" placeholder="Please Enter City Tier" value="<?php echo isset($data)?$data['city_tier']:''; ?>" id="city_tier" name="city_tier" class="m-wrap span12">
							 <span class="help-block" id="city_name_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>



			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_city_master','saveCity');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/cityMaster/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($city_id != '' && $flag != 'new'){ ?>
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
        var city_name = $('#city_name').val();
				//alert('Jai Mata Di............' + city_name);
		if(city_name=="")
            {
                //$('#category_name_error').show();
                $('#city_name').attr('placeholder' ,'Please Enter City Name');
                $('#city_name').addClass('alert-error');
                $('#city_name').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
				//	alert('Jai Mata Di............' + flag);
            var datastring=$('#'+frm_id).serialize();
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/cityMaster/category2db.php",
                data: datastring,
                success: function(data)
				         {
				            getData(data);
				         },
                error:function(){
                    alert("failure");
                    //$("#result").html('there is error while submit');
                }

            });
        }

        return false;
    }

    function getData(success){

        var jObj=eval("("+success+")");
					//console.log(success);
					//alert('Jmd................',jObj);
        var res_action=jObj.action; //alert('AAs');
        var res_city_id=jObj.city_id; //alert('AA'+res_city_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($city_id =='' || $city_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/cityMaster/display.php?city_id="+res_city_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
