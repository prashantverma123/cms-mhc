<?php

if($pricelist_id > 0){
$returned_data = (array)json_decode($modelObj->getEditData($pricelist_id));
$data = (array)$returned_data[0];
}
/*if($memcacheConn):
$leadsources = $memcache->get('leadsource');
$categories = $memcache->get('category');
$varianttype = $memcache->get('varianttype');
$cities = $memcache->get('city');
else:
$leadsources = $dashObj->leadsource();
$categories = $dashObj->category();
$varianttype =  $dashObj->varianttype();
$cities =  $dashObj->city();
endif;*/
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>PriceList</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_about_pricelist" id="frm_about_pricelist">
		 <input type="hidden" name="action" value="savePrice"/>
		 <input type="hidden" name="pricelist_id" value="<?php print $pricelist_id;?>"/>
			   <h3 class="form-section">Price Details </h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Source </label>
						<div class="controls">
						 <select tabindex="1" class="large m-wrap" id="lead_source" name="lead_source">
						 <?php 
						 if($leadsources)
						 echo optionsGeneratorNew($leadsources,$data['lead_source']); 
						 else
						 echo $modelObj->optionsGenerator('leadsource', 'name', 'id',$data['lead_source'], " where status='0'"); ?>
						</select>
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
				  <div class="span6 ">
					 <div class="control-group">
					   <label class="control-label"> Name <span class="required">*</span></label>
						 <div class="controls">
								<input tabindex="2" type="text" placeholder="Please Enter Service Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="name" name="name" class="m-wrap span12">
								<span class="help-block" id="service_name_error"> </span>
						 </div>
					</div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Category <span class="required">*</span></label>
							<select tabindex="3" class="large m-wrap" id="category_type" name="category_type">
							 <?php 
							 if($categories)
							 echo optionsGeneratorNew($categories,$data['category_type']);
							 else
							 echo $modelObj->optionsGenerator('category', 'name', 'id',$data['category_type'], " where status='0'"); ?>
							</select>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

 				 <div class="row-fluid">
 					 <div class="span6 ">
 						<div class="control-group">
 						 <label class="control-label">Variant <span class="required">*</span></label>
 						 <div class="controls">
 							 <!-- <input type="text" id="city" name="city" value="<?php //echo isset($data)?$data['city']:''; ?>" class="m-wrap span12">
 							 <span class="help-block" id="efburl_error"> </span> -->
 						 <select tabindex="4" class="large m-wrap" id="varianttype" name="varianttype">
 							<?php 
 							if($varianttype)
 							echo optionsGeneratorNew($varianttype,$data['varianttype']);
 							else
 							echo $modelObj->optionsGenerator('variantmaster', 'varianttype', 'id',$data['varianttype'], " where status='0'"); ?>
 						 </select>
 						 </div>
 						</div>
 					 </div>

					 <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">City <span class="required">*</span></label>
						<div class="controls">
							<!-- <input type="text" id="city" name="city" value="<?php //echo isset($data)?$data['city']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span> -->
						<select tabindex="5" class="large m-wrap" id="city" name="city">
						 <?php 
						 if($cities)
						 echo optionsGeneratorNew($cities,$data['city']); 
						 else
						 echo $modelObj->optionsGenerator('city', 'name', 'id',$data['city'], " where status='0'"); ?>
						</select>
						</div>
					 </div>
					</div>
 				 </div>
 				  <div class="row-fluid">
				  <div class="span4 ">
					 <div class="control-group">
					   <label class="control-label"> Team Leader <span class="required">*</span></label>
						 <div class="controls">
								<input type="text" tabindex="6" placeholder="Please Enter Service Name" value="<?php echo isset($data)?$data['teamleader_deployment']:'0'; ?>" id="teamleader_deployment" name="teamleader_deployment" class="m-wrap span12">
								<span class="help-block" id="service_name_error"> </span>
						 </div>
					</div>
				  </div>
				  <div class="span4 ">
					 <div class="control-group">
					   <label class="control-label"> Janitor <span class="required">*</span></label>
						 <div class="controls">
								<input type="text" tabindex="7" placeholder="Please Enter Service Name" value="<?php echo isset($data)?$data['janitor_deployment']:'0'; ?>" id="janitor_deployment" name="janitor_deployment" class="m-wrap span12">
								<span class="help-block" id="service_name_error"> </span>
						 </div>
					</div>
				  </div>
				  <div class="span4 ">
					 <div class="control-group">
					   <label class="control-label"> Supervisor <span class="required">*</span></label>
						 <div class="controls">
								<input type="text" tabindex="8" placeholder="Please Enter Service Name" value="<?php echo isset($data)?$data['supervisor_deployment']:'0'; ?>" id="supervisor_deployment" name="supervisor_deployment" class="m-wrap span12">
								<span class="help-block" id="service_name_error"> </span>
						 </div>
					</div>
				  </div>
				</div>

				 <div class="row-fluid">
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Price <span class="required">*</span></label>
							<div class="controls">
							   <input type="text" tabindex="9" id="price" name="price" value="<?php echo isset($data)?$data['price']:''; ?>" class="m-wrap span7">
							</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>


				

			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Taxed Cost</label>
						<div class="controls">
							<input type="text" tabindex="10" id="taxed_cost" name="taxed_cost" value="<?php echo isset($data)?$data['taxed_cost']:''; ?>" class="m-wrap span12">
 						<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->

				  <!--/span-->
			   </div>

			   <div class="row-fluid">
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Commission</label>
						<div class="controls">
						   <input type="text" tabindex="11" id="commission" name="commission" value="<?php echo isset($data)?$data['commission']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" tabindex="12" type="submit" onClick="return saveData('frm_about_pricelist','savePrice');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/pricelist/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" tabindex="13" onclick="window.location.href='<?php print SITEPATH;?>/pricelist/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>

$(document).ready(function(){
	var total_tax = "<?php echo $total_tax; ?>";
	$('#taxed_cost').change(function(){
		var price = Math.floor(parseFloat($(this).val())/(1+parseFloat(total_tax)/100));
		$('#price').val(price);
	})
	
})

<?php if($pricelist_id != '' && $flag != 'new'){ ?>
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
				$('#frm_about_pricelist').validate({
				rules:{
					name:"required",
					//lead_source: "required",
					city:"required",
					varianttype:"required",
					price:"required",
					category_type:"required",

				},

				submitHandler: function() {
        $('.error').hide();
        var flag=0;
        var service_name = $('#name').val();
		if(service_name=="")
            {
                //$('#service_name_error').show();
                $('#name').attr('placeholder' ,'Please Enter Service Name');
                $('#name').addClass('alert-error');
                $('#name').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/pricelist/category2db.php",
                data: datastring,
                success: function(data){
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
			});
    }

    function getData(success){ //alert('Jmd................');
        var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_pricelist_id=jObj.pricelist_id; //alert('AA'+res_pricelist_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($pricelist_id =='' || $pricelist_id == 0){ ?>
		window.location.href = "<?php echo SITEPATH;?>/pricelist/display.php";
		<?php } ?>
    }

</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
