<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
$cities = $memcache->get('city');
$designation = $memcache->get('designation');

?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->

				 <th class="hidden-480">Name</th>
				 <th class="hidden-480">Email ID</th>
				 <th class="hidden-480">Mobile No</th>
				 <th class="hidden-480">City</th>
				 <th class="hidden-480">Designation</th>
				 <th class="hidden-480">Expertise</th>
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
			$result_data = $modelObj->getListingData('name,email', $page,$recperpage,$searchData,$filterData,'',$sort);

			foreach ($result_data['rows'] as $j=>$key){
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
				<td class="hidden-480"><?php print $cities[$key['city']];?></td>
				<td class="hidden-480"><?php print $designation[$key['designation']];?></td>
				<td class="hidden-480"><?php print $key['experties'];?></td>
				<!-- <td class="hidden-480"><?php //print $key['experties'];?></td> -->
				 <td>
				 	<!--a href="javascript:void(0);" onclick="attendance(<?php //print $key['id'];?>)" class="" title="Edit" style="color:#FFFFFF"><img src="../img/attendance.png"/> </a-->
				 	<!-- <span class="label"><input type="checkbox" name="attendance<?php //echo $j; ?>" value="1" title="Attendance" onchange="attendance(<?php //print $key['id'];?>,<?php //echo $j; ?>)" <?php //if($key['attendance']=='0'): echo "checked"; else: echo ""; endif; ?> /></span> &nbsp; -->
					<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/employee/display.php?employee_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; 
					if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('employee',<?php print $key['id'];?>,'delete_employee','employee_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
			  		<?php endif; ?>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>
      </div>
   </div>
<script>
	/*function dele_employee(d_id){ //alert(d_id);
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
	}*/
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
