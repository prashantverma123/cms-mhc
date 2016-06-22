<?php
include_once('config.php');
include_once('cmsuser/variable.php');
$cmsuser_id = '';
if($cmsuser_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($cmsuser_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>T- Register Control Panel |  <?php print $titlename;?> </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php
	include_once(COMMONFILEPATH.'/headerScripts.php');
?>
</head>
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
 	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i> Register</div>
		<!--  <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<a class="reload" href="javascript:;"></a>
		 </div> -->
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_about_cmsuser" id="frm_about_cmsuser">
		 <input type="hidden" name="action" value="saveCmsuser"/>
		 <input type="hidden" name="status" value="3"/>
		 <input type="hidden" name="cmsuser_id" value="<?php print $cmsuser_id;?>"/>
			   <?php if($_GET['m'] == 'nh04g'): echo '<div class="alert alert-success">
				 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a> <strong>Success!</strong> Regitered Successfully.
				</div>';?>
				<script>setTimeout(function () {
											window.location.href = "<?php echo SITEPATH;?>/register.php";
										}, 3000); </script>
				 <?php elseif($_GET['m'] == 'cv06uj'): echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
				  <strong>Error!</strong> Failed to register.
				</div>';?> <script>setTimeout(function () {
											window.location.href = "<?php echo SITEPATH;?>/register.php";
										}, 3000);</script> <?php endif; ?>
			   <h3 class="form-section">Register User Info</h3>
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
				  <!--/span-->

				  <!--/span-->
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
				 <?php endif; ?>
			   </div>
			   <div class="row-fluid">
					 <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">City<span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="city" name="city">
						   <?php  echo $modelObj->optionsGenerator('city', 'name', 'id',$data['city']," where status='0'"); ?>
							</select>
						</div>
					 </div>
					</div>
					 <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Role<span class="required">*</span></label>
						<div class="controls">
							<select tabindex="1" class="large m-wrap" id="role" name="role">
							<?php  echo $modelObj->optionsGenerator('role', 'name', 'role',$data['role'],""); ?>
							</select>
						</div>
					 </div>
					  </div>

					</div>
			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_about_cmsuser','saveCmsuser');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/cmsUser/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/cmsUser/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>

  <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <?php include_once(COMMONFILEPATH.'/footer.php'); ?>
</body>
<!-- END BODY -->
</html>
<script>
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
							if(data){
		                		window.location.href = "<?php echo SITEPATH;?>/register.php?m=nh04g";
		                	}else{
		                		window.location.href = "<?php echo SITEPATH;?>/register.php?m=cv06uj";
		                	}
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
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
