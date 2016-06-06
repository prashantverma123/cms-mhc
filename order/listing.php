<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
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
				 <th>Name</th>
				 <th class="hidden-480">Lead Source</th>
				 <th class="hidden-480">Service</th>
				 <th class="hidden-480">Contact No</th>
				 <th class="hidden-480">Email Id</th>
				 <th class="hidden-480">Price</th>
				 <th class="hidden-480">Commission</th>
				 <th class="hidden-480">Taxed Cost</th>
				 <th class="hidden-480">Created On</th>
				 <th class="hidden-480">Job Updates</th>
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
			 $filterData = array('city' =>$_SESSION['tmobi']['city']);
		   $recperpage=PER_PAGE_ROWS;
			$result_data = $modelObj->getListingData('lead_source,name,city', $page,$recperpage,$searchData,$filterData,$sort);


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
				 <td class="hidden-480"><?php print $key['leadsource_name'];?></td>
				 <td class="hidden-480"><?php print $key['service'];?></td>
				 <td class="hidden-480"><?php print $key['mobile_no'];?></td>
				 <td class="hidden-480"><?php print $key['email_id'];?></td>
				<td class="hidden-480"><?php print $key['price'];?></td>
				<td class="hidden-480"><?php print $key['commission'];?></td>
				<td class="hidden-480"><?php print $key['taxed_cost'];?></td>
				<td class="hidden-480"><?php print $key['insert_date'];?></td>
				<td class="hidden-480 jobinfo<?php print $key['id'];?>">
					<?php if($key['job_start'] == '' || $key['job_start'] == '000-00-00'): ?>
					<input type="checkbox" name="job_info<?php print $key['id'];?>" value="job_start" onchange="updateJobInfo(<?php print $key['id'];?>)">Start
					<?php elseif($key['job_end'] == '' || $key['job_end'] == '000-00-00'): ?>
					<input type="checkbox" name="job_info<?php print $key['id'];?>" value="job_end" onchange="updateJobInfo(<?php print $key['id'];?>)">End
					<?php else: 
						if($key['job_status'] == 'success'):
					?>
						<span>Success</span>
					<?php else: ?>
					<select class="small m-wrap" name="job_status" id="jobstatus<?php print $key['id'];?>" onchange="saveJobStatus(<?php print $key['id'];?>)"><option value="">Please Select</option><option value="success">Success</option><option value="complaint">Complaint</option></select>
					<?php endif; endif; ?>
				</td>
				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/order/display.php?order_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="dele_order(<?php print $key['id'];?>)" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
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
	function updateJobInfo(id){
		if(id!=''){
			if($('input[type="checkbox"][name="job_info'+id+'"]:checked').length == 1){
				var job_info = $('input[type="checkbox"][name="job_info'+id+'"]:checked').val();
				if(job_info){
					$.ajax({
					type: "POST",
					url: "<?php print SITEPATH.'/order/category2db.php';?>",
					data: 'action=update_jobinfo&order_id='+id+'&job_info='+job_info,
					success: function(res){
						if(job_info == 'job_start'){
						$('.jobinfo'+id).html('<div class="checker"><span><input type="checkbox" name="job_info'+id+'" value="job_end" onchange="updateJobInfo('+id+')"></span></div>End');
						}
						else if(job_info == 'job_end'){
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" class="small m-wrap"><option value="">Please Select</option><option value="success">Success</option><option value="complaint">Complaint</option></select>');
						}
					},
					error:function(){
						alert("failure");
					}
				});
				}
			}
		}
	}

	function saveJobStatus(id){
		if(id!=''){
			var job_status = $('#jobstatus'+id).val();
			if(job_status){
				$.ajax({
					type: "POST",
					url: "<?php print SITEPATH.'/order/category2db.php';?>",
					data: 'action=update_jobstatus&order_id='+id+'&job_status='+job_status,
					success: function(res){
						if(job_status == 'success'){
							$('.jobinfo'+id).html('Success');
						}
						else{
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" class="small m-wrap"><option value="">Please Select</option><option value="success">Success</option><option selected="selected" value="complaint">Complaint</option></select>');
						}
					},
					error:function(){
						alert("failure");
					}
				});
			}
		}
	}
</script>
