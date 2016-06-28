<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
$roles = $modelObj->getRole();
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>ASC</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>DESC</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">

    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th>Module</th>
				 <?php foreach ($roles as $role) { ?>
				 	<th class="hidden-480"><?php echo $role['name']; ?></th>
				 <?php } ?>
			  </tr>
		   </thead>
		   <tbody>
		   <?php
		   if(!$_GET['p']){
		   		$page = 0;
		   }else{
		   		$page = $_GET['p']-1;
		   }
		   if($_GET['filter'] || $_GET['sort']){
		   		$searchData['filter'] = $_GET['filter'];
		   		$sort = $_GET['sort'];
		   }
		   $recperpage=11;
			$result_data = $modelObj->getListingData('menu_name', $page,$recperpage,$searchData,'',$sort);
			$accessControls = $modelObj->getAccessControl();
			//print_r($accessControls['rows']);
			foreach ($result_data['rows'] as $key){
						 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td><?php print $key['name'];?></td>

				 <?php $accessControl = $accessControls['rows'][$key['name']];
				 	 foreach ($roles as $role) { 
				 	if($accessControl['role'] == $role['role']):
				 ?>
				<td class="hidden-480"><?php
				  $actions = array();
				  if($accessControl['action'] != '')
				  $actions = explode(',', $accessControl['action']);
				   ?>
				  	<input type='checkbox' value='add' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'update');" <?php if(in_array('add',$actions)): echo "checked"; else: ""; endif; ?>/>Add
				  	<input type='checkbox' value='edit' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'update');" <?php if(in_array('edit',$actions)): echo "checked"; else: ""; endif; ?> />Edit
				  	<input type='checkbox' value='delete' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'update');" <?php if(in_array('delete',$actions)): echo "checked"; else: ""; endif; ?> />Delete
				</td>
				<?php else: ?>
				<td class="hidden-480">
					<input type='checkbox' value='add' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Add
				  	<input type='checkbox' value='edit' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Edit
				  	<input type='checkbox' value='delete' name="<?php print $key['name'];?>[]" data-role="<?php print $role['role'];?>" data-module="<?php print $key['name'];?>" onchange="updateACL(this,'insert');" />Delete
				</td>
				 <?php endif; } ?>
			  </tr>
		<?php } ?>

		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>

      </div>
   </div>
<script>
	function updateACL(obj,action){
		var module = $(obj).data('module');
		var role = $(obj).data('role');
		var values = new Array();
		
		$.each($("input[name='"+module+"[]']:checked"), function() {
  			values.push($(this).val());
  		});
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
			data: 'action=add_update_acl&module='+module+'&role='+role+'&task='+action+'&values='+values,
			success: function(res){
				if(res){
					//alert("");
				}else{
					alert("Failed to update");
				}
			},
			error:function(){
				alert("failure");
			}

		});
	}
	
</script>
