<?php
if($order_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($order_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>Order</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_about_order" id="frm_about_order">
		 <input type="hidden" name="action" value="saveOrder"/>
		 <input type="hidden" name="order_id" value="<?php print $order_id;?>"/>
			   <h3 class="form-section">Order Details </h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Lead Source <span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap lead_source" id="lead_source" name="lead_source">
									<?php echo $modelObj->optionsGenerator('leadsource', 'name', 'id',$data['lead_source'], " where status='0'"); ?>
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
					   <label class="control-label"> Name<span class="required">*</span></label>
						 <div class="controls">
								<input type="text" placeholder="Please Enter order Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="name" name="name" class="m-wrap span12 form-group.required" required>
								<span class="help-block" id="order_name_error"> </span>
								<div id="name_error"class=" alert alert-danger" style="display:none" >
								Please Enter Name
						 </div>
						 </div>
					</div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label" >Mobile No<span class="required">*</span></label>
							<div class="controls">
							   <input type="tel" maxlength="10" pattern="[0-9]{10}" id="mobile_no" name="mobile_no" value="<?php echo isset($data)?$data['mobile_no']:''; ?>" class="m-wrap span5 form-group.required" required>
								 <div id="mobile_no_error"class=" alert alert-danger" style="display:none" >
								 Please Enter Correct Mobile No
							</div>
							</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

				 <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						 <label class="control-label">Alternate No</label>
 							<div class="controls">
 							   <input type="text" id="alternate_no" name="alternate_no" value="<?php echo isset($data)?$data['alternate_no']:''; ?>" class="m-wrap span12">
 							</div>
					</div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Email Id<span class="required">*</span></label>
							<div class="controls">
							   <input type="email" id="email_id" name="email_id" value="<?php echo isset($data)?$data['email_id']:''; ?>" class="m-wrap span7">
								 <div id="email_error"class=" alert alert-danger" style="display:none" >
	 						   Please Enter Correct Email Id
	 						</div>
							</div>

					 </div>
				  </div>
				  <!--/span-->
			   </div>



				<div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Address<span class="required">*</span></label>
						<div class="controls">
						   <textarea rows="3" name="address" id="address" class="m-wrap span12"><?php echo isset($data)?trim($data['address']):''; ?></textarea>
						   <!--<span class="help-block">This field has error.</span>-->
						</div>
					 </div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Landmark</label>
						<div class="controls">
						   <input type="text" id="landmark" name="landmark" value="<?php echo isset($data)?$data['landmark']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Location</label>
						<div class="controls">
							<input type="text" id="location" name="location" value="<?php echo isset($data)?$data['location']:''; ?>" class="m-wrap span12">
 						<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">City<span class="required">*</span></label>
						<div class="controls">

						<select tabindex="1" class="large m-wrap" id="city" name="city">
								<?php echo $modelObj->optionsGenerator('city', 'name', 'id',$data['city'], " where status='0'"); ?>
						</select>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>
				 <div class="row-fluid">
				 <div class="span6 ">
					<div class="control-group">
					 <label class="control-label">State </label>
					 <div class="controls">
						 <input type="text" id="state" name="state" value="<?php echo isset($data)?$data['state']:''; ?>" class="m-wrap span12">
						 <span class="help-block" id="efburl_error"> </span>
					 </div>
					</div>
				 </div>
				 <!--/span-->
				 <div class="span6 ">
					<div class="control-group">
					 <label class="control-label">Pin Code</label>
					 <div class="controls">
						 <input type="text" id="pincode" name="pincode" value="<?php echo isset($data)?$data['pincode']:''; ?>" class="m-wrap span12">
						 <span class="help-block" id="efburl_error"> </span>
					 </div>
					</div>
				 </div>
				 <!--/span-->
				</div>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Service<span class="required">*</span></label>
						<div class="controls">
							<!-- <input type="text" id="service" name="service" value="<?php echo isset($data)?$data['service']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span> -->
							<?php //print_r(unserialize($data['service'])); ?>
							<select tabindex="1" class="large m-wrap" id="service" name="service[]" multiple>
							<?php echo $modelObj->multipleOptionsGenerator('pricelist', 'name', 'id',unserialize($data['service']), " where status='0'"); ?>
							</select>
						</div>
					 </div>
				  </div>
					<div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Price<span class="required">*</span></label>
						<div class="controls">
							<input type="text" id="price" name="price" value="<?php
							$id = $_GET['lead_source_id'];
							$arVal = $modelObj->getPrice();
							//echo '<pre>'; print_r($arVal[0]['price']); echo '</pre>';
							$data['price']=$arVal[0]['price'];
							 echo isset($data)?$data['price']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span>

						</div>
					 </div>
				  </div>
				  <!--/span-->

			   </div>
				 <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Commission</label>
						<div class="controls">
							<input type="text" id="commission" name="commission" value="<?php
							$arVal = $modelObj->getPrice();
							//echo '<pre>'; print_r($arVal[0]['commission']); echo '</pre>';
							$data['commission']=$arVal[0]['commission'];
							echo isset($data)?$data['commission']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
					<div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Inclusive of Tax</label>
						<div class="controls">
							<input type="text" id="taxed_cost" name="taxed_cost" value="<?php echo isset($data)?$data['taxed_cost']=$data['price']+$data['price']*0.145 + $data['price']*0.1 :''; ?>" class="m-wrap span12">
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
			    <button class="btn blue" type="submit" onClick="return saveData('frm_about_order','saveOrder');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/order/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/order/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
	<script>

/*function validate(data){
	console.log(data);
}*/

	$("#lead_source").change(function() {
	    var parent = $(this).val();
			$("#price").val('0');
			$("#commission").val('0');
			$("#taxed_cost").val('0');
			$.ajax({
	         type: "GET",
	         url: "change.php",
	         data: "lead_source_id="+parent,
	         success: function(html) {
							 var obj = JSON.parse(html);
							 console.log(obj);
							 var str = '<option value="0" >Select Service</option>';
							 for(var i=0;i<obj.length;i++){
								 str += '<option value="'+ obj[i].id+'" >'+ obj[i].name+'</option>';
							 }
							  $("#service").html(str);

	         }
	     });

	});
	$("#service").change(function() {
			var parent = $(this).val();
			$.ajax({
					 type: "GET",
					 url: "change.php",
					 data: "service_id="+parent,
					 success: function(html) {
							 var obj = JSON.parse(html);
							 console.log(obj[0].price);
								$("#price").val(obj[0].price);
								var price =parseInt($("#price").val());
								var comm = parseInt($("#commission").val());
								var calc_value = price + price*(comm)/100 + price*0.145;
								$('#taxed_cost').val(calc_value);

								debugger;

					 }
			 });

	});

	</script>
<script>
<?php if($order_id != '' && $flag != 'new'){ ?>
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


				$('#frm_about_order').validate({
	    	rules:{
	    		lead_source:"required",
	    		city: "required",
	    		service:"required",
	    		price:"required",
	    		name:"required",
	    		address:"required",
	    		mobile_no:{
	    			required:true
	    		},
					email_id:{
						required:true
					}
	    	},
	    	submitHandler: function() {

				var data = $('#frm_about_order').serializeArray().reduce(function(obj, item) {
							    obj[item.name] = item.value;
							    return obj;
					}, {});

				if (data.name===""){
						$('#name_error').css('display', 'block');
						$('#mobile_no_error').css('display', 'block');
						$('#email_error').css('display', 'block');
					return false;
				}
				if(data.mobile_no.length!==10 || data.mobile_no===""){
					$('#mobile_no_error').css('display', 'block');
						$('#email_error').css('display', 'block');
						return false;
				}
				if(data.email_id.indexOf('@') === -1 || data.email_id===""){
						$('#email_error').css('display', 'block');
						return false;
				}
				//debugger;
        $('.error').hide();
        var flag=0;
        var order_name = $('#order_name').val();

		if(order_name=="")
            {
                //$('#order_name_error').show();
                $('#order_name').attr('placeholder' ,'Please Enter order Name');
                $('#order_name').addClass('alert-error');
                $('#order_name').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/order/category2db.php",
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
				debugger;
        var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_order_id=jObj.order_id;
				//  alert('AA'+res_order_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($order_id =='' || $order_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/cms/order/display.php";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
