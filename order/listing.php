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
				 <th>Name</th>
				 <th class="hidden-480">Lead Source</th>
				 <th class="hidden-480">Service</th>
				 <th class="hidden-480">Contact No</th>
				 <th class="hidden-480">Email Id</th>
				 <th class="hidden-480">Price</th>
				 <th class="hidden-480">Commission</th>
				 <th class="hidden-480">Taxed Cost</th>
				 <th class="hidden-480">Created On</th>
				 <th class="hidden-480">Status</th>
				 <th class="hidden-480">Action</th>
			  </tr>
		   </thead>
		   <tbody>
		   <?php

			$result_data = $modelObj->getListingData('', '0', '10',$searchData);


			foreach ($result_data as $key){
				if($key['parent_id'] == 0){
					$is_parent_val = 'Yes';
				}else{
					$is_parent_val = '--';
				}
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td><?php print $key['name'];?></td>
				 <td class="hidden-480"><?php print $key['lead_source'];?></td>
				 <td class="hidden-480"><?php print $key['service'];?></td>
				 <td class="hidden-480"><?php print $key['mobile_no'];?></td>
				 <td class="hidden-480"><?php print $key['email_id'];?></td>
				<td class="hidden-480"><?php print $key['price'];?></td>
				<td class="hidden-480"><?php print $key['commission'];?></td>
				<td class="hidden-480"><?php print $key['taxed_cost'];?></td>
				<td class="hidden-480"><?php print $key['insert_date'];?></td>
				<td class="hidden-480"><?php print $key['insert_date'];?></td>
				 <td>
					<span class="label label-success"><a href="<?php print SITEPATH.'/order/display.php?order_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<span class="label label-warning"><a href="javascript:void(0);" onclick="dele_order(<?php print $key['id'];?>)" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
      </div>
   </div>
<script>
	function dele_order(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: 'action=delete_order&order_id='+d_id,
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
