<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
?>
<div class="portlet-body">
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th>Product Category</th>
				 <th class="hidden-480">Product Validity</th>
				 <th class="hidden-480">Cost</th>
				 <th class="hidden-480">City</th>
				 <th class="hidden-480">Lead Source</th>
			  </tr>
		   </thead>
		   <tbody>
		   <?php
		   if(!$_GET['p']){
		   		$page = 0;
		   }else{
		   		$page = $_GET['p']-1;
		   }
		   $recperpage=PER_PAGE_ROWS;
			$result_data = $modelObj->getListingData('', $page,$recperpage,$searchData);

			foreach ($result_data as $key){
				// if($key['parent_id'] == 0){
				// 	$is_parent_val = 'Yes';
				// }else{
				// 	$is_parent_val = '--';
				// }
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				<!-- <td><?php print $key['category_id'];?></td> -->
				<td class="hidden-480"><?php print $key['validity'];?></td>
				<td class="hidden-480"><?php print $key['cost'];?></td>
				<td class="hidden-480"><?php print $key['city_id'];?></td>
				<td class="hidden-480"><?php print $key['lead_source_id'];?></td>
				 <td>
					<span class="label label-success"><a href="<?php print SITEPATH.'/product/display.php?product_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<span class="label label-warning"><a href="javascript:void(0);" onclick="dele_product(<?php print $key['id'];?>)" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page); ?>
      </div>
   </div>
<script>
	function dele_product(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/product/category2db.php';?>",
				data: 'action=delete_product&product_id='+d_id,
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
</script>
