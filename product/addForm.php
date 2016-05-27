<?php
if($product_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($product_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About Product Source</div>
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
		 <input type="hidden" name="action" value="saveProduct"/>
		 <input type="hidden" name="product_id" value="<?php print $product_id;?>"/>
			   <h3 class="form-section">Product Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Category <!--<span class="required">*</span>--></label>
						<div class="controls">
						   <!-- <input type="text" placeholder="Please Enter Category Id" value="<?php echo isset($data)?$data['product_id']:''; ?>" id="product_id" name="product_id" class="m-wrap span12">
						   <span class="help-block" id="product_id_error"> </span> -->
							 <select tabindex="1" class="large m-wrap" id="category_id" name="category_id">
							 <?php echo $modelObj->optionsGenerator('category', 'name', 'id',$data['category_id'], " where status='0'"); ?>
							</select>
							
						</div>
					 </div>
				  </div>
				  <!--/span-->

				  <!--/span-->
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
 					 <div class="control-group">
 						<label class="control-label">Validity <!--<span class="required">*</span>--></label>
 						<div class="controls">
 						   <input type="text" placeholder="Please Enter Product Validity" value="<?php echo isset($data)?$data['validity']:''; ?>" id="validity" name="validity" class="m-wrap span12">
 						   <span class="help-block" id="validity_error"> </span>
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
	 				 <label class="control-label">Cost <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<input type="text" placeholder="Please Enter Product Cost" value="<?php echo isset($data)?$data['cost']:''; ?>" id="cost" name="cost" class="m-wrap span12">
	 						<span class="help-block" id="cost_error"> </span>
	 				 </div>
	 				</div>
	 			 </div>
				  <!--/span-->

				  <!--/span-->
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
 					<div class="control-group">
 					 <label class="control-label">City Id <!--<span class="required">*</span>--></label>
 					 <div class="controls">
 							<!-- <input type="text" placeholder="Please Enter City Id" value="<?php echo isset($data)?$data['city_id']:''; ?>" id="city_id" name="city_id" class="m-wrap span12">
 							<span class="help-block" id="city_id_error"> </span> -->
							<select tabindex="1" class="large m-wrap" id="city_id" name="city_id">
								<?php echo $modelObj->optionsGenerator('city', 'name', 'id',$data['city_id'], " where status='0'"); ?>
							</select>
							<!-- <option value="" >Select the City</option>
							<option value="0" >Mumbai</option>
							<option value="1" >Delhi</option>
							<option value="2" >Bangalore</option>
						 </select> -->
 					 </div>
 					</div>
 				 </div>

				  <!--/span-->
			   </div>

			   <div class="row-fluid">

					 <div class="span6 ">
	 				<div class="control-group">
	 				 <label class="control-label">Lead Source  <!--<span class="required">*</span>--></label>
	 				 <div class="controls">
	 						<!-- <input type="text" placeholder="Please Enter Lead Source" value="<?php echo isset($data)?$data['lead_source_id']:''; ?>" id="lead_source_id" name="lead_source_id" class="m-wrap span12">
	 						<span class="help-block" id="lead_source_id"> </span> -->
							<select tabindex="1" class="large m-wrap" id="lead_source_id" name="lead_source_id">
							<?php echo $modelObj->optionsGenerator('leadsource', 'name', 'id',$data['lead_source_id'], " where status='0'"); ?>
							</select>
	 				 </div>
	 				</div>
	 			 </div>

			   </div>

				 <div class="row-fluid">

					<div class="span6 ">
				 <div class="control-group">
					<label class="control-label">Comission <!--<span class="required">*</span>--></label>
					<div class="controls">
						 <input type="text" placeholder="Please Enter Comission" value="<?php echo isset($data)?$data['comission']:''; ?>" id="comission" name="comission" class="m-wrap span12">
						 <span class="help-block" id="comission"> </span>
					</div>
				 </div>
				</div>

				</div>


			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_lead_source','saveProduct');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/product/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($product_id != '' && $flag != 'new'){ ?>
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
        var product_id = $('#product_id').val();
		if(product_id=="")
            {
                //$('#product_id_error').show();
                $('#product_id').attr('placeholder' ,'Please Enter Categry Id');
                $('#product_id').addClass('alert-error');
                $('#product_id').focus();
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
                url: "<?php print SITEPATH;?>/product/category2db.php",
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
        var res_product_id=jObj.product_id; //alert('AA'+res_product_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($product_id =='' || $product_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/product/display.php?product_id="+res_product_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
