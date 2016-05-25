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

				 <th class="hidden-480">Name</th>
				 <th class="hidden-480">Email Id</th>
				 <th class="hidden-480">Mobile No</th>
				 <th class="hidden-480">City</th>
				 <th class="hidden-480">Designation</th>
				 <th class="hidden-480">Experties</th>
				 <th class="hidden-480">Action</th>
			  </tr>
		   </thead>
		   <tbody>
		   <?php
			$result_data = $modelObj->getListingData('', '0', '10',$searchData);

			foreach ($result_data as $j=>$key){
				// if($key['parent_id'] == 0){
				// 	$is_parent_val = 'Yes';
				// }else{
				// 	$is_parent_val = '--';
				// }
		 ?>
		 <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
		 <!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->

				<td class="hidden-480"><?php print $key['name'];?></td>
				<td class="hidden-480"><?php print $key['email'];?></td>
				<td class="hidden-480"><?php print $key['mobile_no'];?></td>
				<td class="hidden-480"><?php print $key['city'];?></td>
				<td class="hidden-480"><?php print $key['designation'];?></td>
				<td class="hidden-480"><?php print $key['experties'];?></td>
				<!-- <td class="hidden-480"><?php print $key['experties'];?></td> -->
				 <td>
				 	<!--a href="javascript:void(0);" onclick="attendance(<?php print $key['id'];?>)" class="" title="Edit" style="color:#FFFFFF"><img src="../img/attendance.png"/> </a-->
				 	<span class="label"><input type="checkbox" name="attendance<?php echo $j; ?>" value="1" title="Attendance" onchange="attendance(<?php print $key['id'];?>,<?php echo $j; ?>)" <?php if($key['attendance']=='0'): echo "checked"; else: echo ""; endif; ?> /></span> &nbsp;
					<span class="label label-success"><a href="<?php print SITEPATH.'/employee/display.php?employee_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<span class="label label-warning"><a href="javascript:void(0);" onclick="dele_employee(<?php print $key['id'];?>)" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
      </div>
   </div>
<script>
	function dele_employee(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/employee/category2db.php';?>",
				data: 'action=delete_employee&employee_id='+d_id,
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
	function attendance(d_id,val){
		if(d_id !=''){
			if($("input[type='checkbox'][name='attendance"+val+"']:checked").length == 1){
				var attendance = '0';
			}else{
				var attendance = '-1';
			}
			//alert($(this).val());
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/employee/category2db.php';?>",
				data: 'action=save_attendance&employee_id='+d_id+'&attendance='+attendance,
				success: function(res){
					//$('#row_id_'+d_id).hide('slow');
					console.log(res);
					if(res == true){
						if(attendance == '0')
							alert('Attendance marked as present');
						else
							alert('Attendance marked as absent');
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
</script>
