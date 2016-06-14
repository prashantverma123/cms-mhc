<?php
if($category_id > 0){
	$returned_data = (array)json_decode($modelObj->getEditData($category_id));
	$data = (array)$returned_data[0];
	//echo'<pre>'; print_r($data);
}
?>
	<div class="portlet box green">
	  <div class="portlet-title">
		 <div class="caption"><i class="icon-reorder"></i>About Category</div>
		 <div class="tools">
			<a class="collapse" href="javascript:;"></a>
			<!--<a class="config" data-toggle="modal" href="#portlet-config"></a>-->
			<a class="reload" href="javascript:;"></a>
			<!--<a class="remove" href="javascript:;"></a>-->
		 </div>
	  </div>
	  <div class="portlet-body form">
		 <!-- BEGIN FORM-->
		 <form class="form-horizontal" action="" name="frm_about_category" id="frm_about_category">
		 <input type="hidden" name="action" value="saveCategory"/>
		 <input type="hidden" name="category_id" value="<?php print $category_id;?>"/>
			   <h3 class="form-section">Category Info</h3>
			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Name <!--<span class="required">*</span>--></label>
						<div class="controls">
						   <input type="text" placeholder="Please Enter Category Name" value="<?php echo isset($data)?$data['name']:''; ?>" id="category_name" name="category_name" class="m-wrap span12">
						   <span class="help-block" id="category_name_error"> </span>
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
					   <label class="control-label">Select Parent Categorgy</label>
					   <div class="controls">
						  <select tabindex="1" class="large m-wrap" id="parent_id" name="parent_id">
							 <option value="0" >Is Parent</option>
							 <?php
							 $arVal = $modelObj->getParentList();
							 //echo '<pre>'; print_r($$arVal); echo '</pre>';
							 foreach($arVal as $key){
							 	if(isset($data) && $data['parent_id'] == $key["id"]){
									$sel = 'selected="selected"';
								}else{
									$sel ='';
								}
							 	echo '<option value="'.$key["id"].'" '.$sel.'>'.$key["name"].'</option>';
							 }
							 ?>
						  </select>
					   </div>
					</div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Priority</label>
							<div class="controls">
							   <input type="text" id="priority" name="priority" value="<?php echo isset($data)?$data['priority']:''; ?>" class="m-wrap span5">
							</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

				<div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Summary</label>
						<div class="controls">
						   <textarea rows="3" name="summary" id="summary" class="m-wrap span12"><?php echo isset($data)?trim($data['summary']):''; ?></textarea>
						   <!--<span class="help-block">This field has error.</span>-->
						</div>
					 </div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Meta Title</label>
						<div class="controls">
						   <input type="text" id="meta_title" name="meta_title" value="<?php echo isset($data)?$data['meta_title']:''; ?>" class="m-wrap span12">
							<span class="help-block" id="efburl_error"> </span>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Meta Keywords </label>
						<div class="controls">
							<textarea rows="3" name="meta_keyword" id="meta_keyword" class="m-wrap span12"><?php echo isset($data)?trim($data['meta_keyword']):''; ?></textarea>
						</div>
					 </div>
				  </div>
				  <!--/span-->
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Meta Description</label>
						<div class="controls">
							<textarea rows="3" name="meta_description" id="meta_description" class="m-wrap span12"><?php echo isset($data)?$data['meta_description']:''; ?></textarea>
						</div>
					 </div>
				  </div>
				  <!--/span-->
			   </div>

			   <div class="row-fluid">
				  <div class="span6 ">
					 <div class="control-group">
						<label class="control-label">Image</label>
						<div class="controls">
							<input type="file" name="category_logo" id="category_logo" onChange="ajaxFileUpload('category_logo','afterMatterUpload','<?php print $moduleName;?>')">
							<input type="hidden" name="hid_full_category_logo" id="hid_full_category_logo" value="<?php echo $data['image']; ?>"/>
							<div id="status_category_logo" class="img123" style="width: 100px; height: 100;">
							<img <?php if($data['image'] != ''){ ?> src="<?php print SITEPATH;?>/uploads/<?php echo $data['image']; ?>" <?php } ?> border="0"></div>

						</div>
					 </div>
				  </div>
				  <!--/span-->

			   </div>


			<div class="form-actions">
				<span style="color:#FF0000;margin-bottom:20px;display:none;" id="record_modified">
					Record Modified Successful ...
				</span>
			    <button class="btn blue" type="submit" onClick="return saveData('frm_about_category','saveAboutCategory');"><i class="icon-ok"></i> Save</button>
			    <?php /*?><!-- <a href="<?php print SITEPATH;?>/category/display.php" ><button class="btn" type="button">Cancel</button></a>--><?php */?>
			  	<a  href="javascript:void();" onclick="window.location.href='<?php print SITEPATH;?>/category/display.php'" ><button class="btn" type="button">Back To Listing</button></a>
			</div>
		 </form>
		 <!-- END FORM-->
	  </div>
	</div>
<script>
<?php if($category_id != '' && $flag != 'new'){ ?>
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
        var category_name = $('#category_name').val();
		if(category_name=="")
            {
                //$('#category_name_error').show();
                $('#category_name').attr('placeholder' ,'Please Enter Category Name');
                $('#category_name').addClass('alert-error');
                $('#category_name').focus();
				$('html, body').animate({
					 scrollTop: $("#li_pat1").offset().top
				 }, 700);
                flag=1;
            }

        if(flag==0){
            var datastring=$('#'+frm_id).serialize();
            $.ajax({
                type: "POST",
                url: "<?php print SITEPATH;?>/category/category2db.php",
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

    function getData(success){ //alert('Jmd................');
        var jObj=eval("("+success+")");
        var res_action=jObj.action; //alert('AAs');
        var res_category_id=jObj.category_id; alert('AA'+res_category_id);
		$('#record_modified').show();
			 setTimeout(function () {
				document.getElementById('record_modified').style.display='none';
			}, 1000);
		<?php if($category_id =='' || $category_id == 0){ ?>
		window.location.href = "<?php SITEPATH;?>/category/display.php?category_id="+res_category_id+"&flag=t";
		<?php } ?>
    }
</script>
<link type="text/css" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/css/ui-lightness/jquery-ui-1.8.11.custom.css" rel="stylesheet" />
<link rel="start" href="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script type="text/javascript" src="<?php print JSFILEPATH;?>/ajaxfileupload.js?v=1.0"></script>
