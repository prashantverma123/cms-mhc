<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<!-- <select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php //if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select> -->
	<label class="checkbox-inline" style="float:left;width:94px;margin-top:6px;"><input tabindex="1" type="radio" name="sort" value="asc" <?php if($_GET['sort'] == 'asc'): echo "checked"; else: ""; endif; ?>>Ascending</label>
	<label class="checkbox-inline" style="float:left;width:104px;margin-top:6px;"><input tabindex="1" type="radio" name="sort" value="desc" <?php if($_GET['sort'] == 'desc'): echo "checked"; else: ""; endif; ?>>Descending</label>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" >
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th class="hidden-480">Name</th>
				 <th>Value</th>
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
			$result_data = $modelObj->getListingData('name', $page,$recperpage,$searchData,$sort);
			foreach ($result_data['rows'] as $key){
				// if($key['parent_id'] == 0){
				// 	$is_parent_val = 'Yes';
				// }else{
				// 	$is_parent_val = '--';
				// }
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td class="hidden-480"><?php print $key['name'];?></td>
				 <td><?php print $key['value'];?></td>				
				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/'.$modelObj->folderName.'/display.php?tax_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('tax',<?php print $key['id'];?>,'delete_tax','tax_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
					<?php endif; ?>
				</td>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>
      </div>
   </div>
<script>
	/*function dele_lead(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=delete_lead&lead_id='+d_id,
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
	}
*/</script>
