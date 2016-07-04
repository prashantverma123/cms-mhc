<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bpricelisted table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th>Service Name</th>
				 <th class="hidden-480">Lead Source</th>
				 <th class="hidden-480">Category</th>
				 <th class="hidden-480">City</th>
				 <th class="hidden-480">Price</th>
				 <th class="hidden-480">Commission</th>
				 <th class="hidden-480">Taxed Price</th>
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
			 $filterData = array('city' =>$_SESSION['tmobi']['city']);
			$result_data = $modelObj->getListingData('name,category_type,lead_source', $page,$recperpage,$searchData,$filterData,$sort);


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
				 <td class="hidden-480"><?php print $key['leadsourceName'];?></td>
				 <td class="hidden-480"><?php print $key['categoryName'];?></td>
				 <td class="hidden-480"><?php print $key['cityName'];?></td>
				 <td class="hidden-480"><?php print $key['price'];?></td>
				 <td class="hidden-480"><?php print $key['commission'];?></td>
				 <td class="hidden-480"><?php print $key['taxed_cost'];?></td>
				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/pricelist/display.php?pricelist_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('pricelist',<?php print $key['id'];?>,'delete_pricelist','pricelist_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
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
	/*function dele_pricelist(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/pricelist/category2db.php';?>",
				data: 'action=delete_pricelist&pricelist_id='+d_id,
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
