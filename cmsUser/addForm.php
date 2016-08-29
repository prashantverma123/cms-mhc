<?php
if($cmsuser_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($cmsuser_id));
	$data = (array)$returned_data[0];
}
if($memcacheConn):
$cities=$memcache->get('city');
$role=$memcache->get('role');
else:
$cities=$dashObj->city();
$role=$dashObj->role();
endif;
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About CMS Users</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_about_cmsuser" id="frm_about_cmsuser">
		 <input type="hidden" name="action" value="saveCmsuser"/>
		 <input type="hidden" name="cmsuser_id" value="<?php print $cmsuser_id;?>"/>
			   <h3 class="form-section">CMS User Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Name <span class="required">*</span></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="name" name="name" class="m-wrap span12">
						   <span class="help-block" id="cmsuser_name_error"> </span>
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
						<label class="control-label">Email<span class="required">*</span></label>
							<div class="controls">
								<input type="text" placeholder="Please Enter Email" value="<?php echo isset($data)?$data['email']:''; ?>" id="email" name="email" class="m-wrap span12">
 						   <span class="help-block" id="cmsuser_email_error"> </span>
							</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

				<div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Username<span class="required">*</span></label>
						<div class="controls">
							<input type="text" placeholder="Please Enter Username" value="<?php echo isset($data)?$data['username']:''; ?>" id="username" name="username" class="m-wrap span12">
						 <span class="help-block" id="cmsuser_username_error"> </span>
						</div>
					 </div>
				  </div>
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Is Vendor</label>
						<div class="controls">
						   <input type="checkbox" value="1" <?php if($data['is_vendor']=='1'): echo "checked"; else: ""; endif; ?> id="is_vendor" name="is_vendor" class="m-wrap span12">
						   <span class="help-block" id="is_vendor_error"> </span>
						</div>
					 </div>
				  </div>
			   </div>
			   <div class="row-fluid">
			   		<?php if($cmsuser_id==''): ?>
			   		<div class="span6 ">
						 <div class="control-group">
							<label class="control-label">Password<span class="required">*</span></label>
							<div class="controls">
								<input type="password" placeholder="Please Enter Password" value="<?php echo isset($data)?$data['password']:''; ?>" id="password" name="password" class="m-wrap span12">
							 <span class="help-block" id="cmsuser_password_error"> </span>
							</div>
						 </div>
				 	</div>
				 	
				 	<div class="span6 ">
						 <div class="control-group">
							<label class="control-label">Confirm Password<span class="required">*</span></label>
							<div class="controls">
								<input type="password" placeholder="Please Enter Password" value="" id="confirm_password" name="confirm_password" class="m-wrap span12">
							 <span class="help-block" id="cmsuser_confirm_password_error"> </span>
							</div>
						 </div>
				 	</div>
				 <?php else: ?> 
				 <input type="hidden" placeholder="Please Enter Password" value="<?php echo isset($data)?$data['password']:''; ?>" id="password" name="password" class="m-wrap span12">
				<?php endif; ?>
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">City<span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="city" name="city">
						   <?php 
						   if($memcache)
						   echo optionsGeneratorNew($cities,$data['city']);
							else
						    echo $modelObj->optionsGenerator('city', 'name', 'id',$data['city']," where status='0'"); ?>
							</select>
						</div>
					 </div>
					</div>
					 <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Role<span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="role" name="role">
							<?php 
							if($memcache)
							echo optionsGeneratorNew($role,$data['role']); 
							else
							echo $modelObj->optionsGenerator('role', 'name', 'role',$data['role'],""); ?>
							</select>
						</div>
					 </div>
					  </div>

					</div>
					<div class="row-fluid">
						<div class="span6 ">
						<div class="control-group">
							<label class="control-label">Role Matrix</label>
							<table class="table table-striped table-bordered table-hover" id="">
								<thead>
								  <tr>
									 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
									 <th>Module</th>
									 <th>Permissions</th>
								  </tr>
								</thead>
								<tbody>
					 <?php
		  			$page = 0;
		  			$recperpage=11;
		  			$searchData= array();
					$result_data = $aclObj->getListingData('menu_name', $page,$recperpage,$searchData,'','');
					//print_r($result_data);
					$accessControls = $aclObj->getAccessControl();
					//print_r($accessControls['rows']);
				    foreach ($result_data['rows'] as $key){
						 ?>
			 		
							
				<tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td><?php print $key['name'];?></td>

				 <?php $accessControl = $accessControls['rows'][$key['name']];
				 $roles = $aclObj->getRole();
				// print_r($accessControls);

				 	 // foreach ($roles as $role) { 
				 	
				 ?>
				
				<td class="hidden-480">
					<input type='checkbox' value='add' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Add
				  	<input type='checkbox' value='edit' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Edit
				  	<input type='checkbox' value='delete' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Delete
				</td>
				 <?php  ?>
			  </tr>
		<?php } ?>	

								</tbody>

							</table>
						 </div>
						</div>	
					</div>
				  <!--/span-->

				  <!--/span-->





			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_about_cmsuser','saveCmsuser');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/cmsUser/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/cmsuser/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($cmsuser_id != '' && $flag != 'new'){ ?>
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
	 $('#frm_about_cmsuser').validate({
		rules:{
			name:"required",
			email:{
				email:true,
				required:true,
				remote: {
		        url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php?action=check_email&id=<?php echo $cmsuser_id; ?>",
		        type: "post",
		        data: {
		          email: function() {
		            return $( "#email" ).val();
		          }
		        }
		      }
			},
			username:"required",
			password:{
				required:true,
				minlength: 6
			},
			confirm_password:{
				required:true,
				minlength: 6,
				equalTo: "#password"
			},
			role:"required",
			city:"required"
		},
		messages:{
			email:{
				remote:"Email ID is already exist"
			}
		},
		submitHandler: function() {
	        $('.error').hide();
	        var flag=0;
	        var cmsuser_name = $('#name').val();
			if(cmsuser_name=="")
        	{
                //$('#category_name_error').show();
                $('#name').attr('placeholder' ,'Please Enter Name');
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
	                url: "<?php print SITEPATH;?>/<?php echo $modelObj->folderName; ?>/category2db.php",
	                data: datastring,
	                success: function(data){
	                	if(data){
							getData(data);
						}else{
							alert("Please try again!");
						}
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

    function getData(success){
        var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_cmsuser_id=jObj.cmsuser_id;
				//debugger;
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
			//console.log($cmsuser_id);
		<?php if($cmsuser_id =='' || $cmsuser_id == 0){ ?>
		window.location.href = "<?php echo SITEPATH;?>/<?php echo $modelObj->folderName; ?>/display.php?cmsuser_id="+res_cmsuser_id+"&flag=t";
		<?php } ?>
    }

    var roleMatrix = {};

    function updateACL(obj,action){
		var module = $(obj).data('module');
		var role = $(obj).data('role');
		var values = new Array();
		
		$.each($("input[name='"+module+"[]']:checked"), function() {
  			values.push($(this).val());
  		});
		roleMatrix[module] = values;
  		debugger;
		// $.ajax({
		// 	type: "POST",
		// 	url: "<?php print SITEPATH.'/'.$aclObj->folderName.'/category2db.php';?>",
		// 	data: 'action=add_update_acl&module='+module+'&role='+role+'&task='+action+'&values='+values,
		// 	success: function(res){
		// 		var obj = eval("("+res+")");
		// 		if(obj.result == 'success'){
		// 			alert("Access Control Updated!");
		// 		}else{
		// 			alert("Failed to update");
		// 		}
		// 	},
		// 	error:function(){
		// 		alert("failure");
		// 	}

		// });
	}
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
