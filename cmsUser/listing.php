<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
$cities=$memcache->get('city');
$role=$memcache->get('role');
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php //echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">

    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th>Name</th>
				 <th class="hidden-480">Email</th>
				 <th class="hidden-480">Username</th>
				 <th class="hidden-480">City</th>
				 <th class="hidden-480">Role</th>
				 <th class="hidden-480">Status</th>
				 <th class="hidden-480">Action</th>
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
		   $recperpage=PER_PAGE_ROWS;
			$result_data = $modelObj->getListingData('name,summary', $page,$recperpage,$searchData,'',$sort);

			foreach ($result_data['rows'] as $key){
				if($key['parent_id'] == 0){
					$is_parent_val = 'Yes';
				}else{
					$is_parent_val = '--';
				}
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td><?php print $key['name'];?></td>
				  <td class="hidden-480"><?php print $key['email'];?></td>
				 <td class="hidden-480"><?php print $key['username'];?></td>
				 <td class="hidden-480"><?php print $cities[$key['city']];?></td>
				  <td class="hidden-480"><?php print $role[$key['role']];?></td>
				  <td class="hidden-480">
				  	<select name="status" class="small" onchange="updateStatus(this.value,<?php print $key['id'];?>);">
				  		<option value='1' <?php if($key['status'] == '1'): echo "selected"; else: ""; endif; ?>>Approved</option>
				  		<option value='2' <?php if($key['status'] == '2'): echo "selected"; else: ""; endif; ?>>Unapproved</option>
				  	</select>
				  </td>
				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/'.$modelObj->folderName.'/display.php?cmsuser_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; 
					if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('cmsuser',<?php print $key['id'];?>,'delete_cmsuser','cmsuser_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
				<?php endif; ?>
			  </tr>
		<?php } ?>

		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>

      </div>
   </div>
<script>
	function updateStatus(value,d_id){
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=update_status&cmsuser_id='+d_id+'&status='+value,
				success: function(res){
					if(res){
						alert("Status Updated");
					}else{
						alert("Failed to update");
					}
				},
				//success: getData,
				error:function(){
					alert("failure");
					//$("#result").html('there is error while submit');
				}

			});
		}
	}
	/*function dele_cmsuser(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=delete_cmsuser&cmsuser_id='+d_id,
				success: function(res){
					$('#row_id_'+d_id).hide('slow');
				},
				//success: getData,
				error:function(){
					alert("failure");
					//$("#result").html('there is error while submit');
				}

			});
		}
	}*/
</script>
