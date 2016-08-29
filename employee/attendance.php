<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
$days = array('Mon'=>'monday','Tue'=>'tuesday','Wed'=>'wednesday','Thu'=>'thursday','Fri'=>'friday','Sat'=>'saturday','Sun'=>'sunday');
?>
<div class="portlet-body">
		<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
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
			//$result_data1= $modelObj->getListingData('name,email', $page,$recperpage,$searchData,$filterData,'',$sort); 
	?>
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<table class="table table-striped table-bordered table-hover" >
			<tr>
				<th>Employee Name</th>
			<?php foreach ($days as $day=>$d) { ?>
			<th><?php echo $day; ?></th>
			<?php 	} ?>
			<th>All</th>
			</tr>
			<?php
			foreach ($result_data['rows'] as $j=>$key)
			{ 
				$t = $modelObj->get_attendance_by_id($key['id']);
				$i = 0;
				$checked = 0;
				$unchecked = '';
			 ?>
			<tr id="att<?php echo $j; ?>">
				<td><?php print $key['name'];?><br /><?php print '( '.$memcache_designation[$key['designation']].' )'; ?></td>
				<?php foreach ($days as $d=>$day) {   ?>
				<td><span class="label"><input type="checkbox" name="attendance<?php echo $key['id'].$j.$d; ?>" value="1" title="Attendance" data-date="<?php echo date( 'Y-m-d', strtotime( "$d this week" ) ); ?>" data-empid="<?php print $key['id'];?>" onchange="attendance(<?php print $key['id'];?>,'<?php echo $key['id'].$j.$d; ?>','<?php echo date( 'Y-m-d', strtotime( "$d this week" ) ); ?>')" <?php if($t[$i]['attendance']=='0' && (date('D',strtotime($t[$i]['date']))==$d)): echo "checked"; $checked=$checked+1; else: echo ""; endif; ?> /></span> &nbsp;
				</td>
				<?php $i++;	} ?>
				<td><span class="label"><input type="checkbox" name="attendance<?php echo $key['id'].$j.$d.'all'; ?>" value="1" title="Attendance" onchange="attendanceAll(<?php print $key['id'];?>,'<?php echo $key['id'].$j.$d.'all'; ?>',<?php echo $j; ?>)" <?php if($checked>=7): echo "checked"; else: echo ""; endif; ?> /></span> &nbsp;</td>
			</tr>
			<?php } ?>
		</table>
	</form>

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
	function attendance(d_id,val,date){
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
				data: 'action=save_attendance&employee_id='+d_id+'&attendance='+attendance+'&date='+date,
				success: function(res){
					//$('#row_id_'+d_id).hide('slow');
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

function attendanceAll(d_id,val,id){
	//$('#att'+unchecked input[type='checkbox']:checked).
	//var arr = Array();
	var date = Array();

	$('#att'+id+' input[type="checkbox"]').each(function(i,e){
            //$(this).prop('checked', true);
            if(!$(e).is(':checked')){
            	//arr.push($(e).data('empid'));
            	date.push($(e).data('date'));
            }else{
            	//arr.push($(e).data('empid'));
            	date.push($(e).data('date'));
            }

    });
	//console.log(arr);
	//console.log(date);
	if(d_id !=''){
		if($("input[type='checkbox'][name='attendance"+val+"']:checked").length == 1){
			$('#att'+id+' input[type="checkbox"]').each(function(i,e1){
				$(e1).prop('checked',true);
	          	$(e1).closest('span').addClass('checked');
		    });
			var attendance = '0';
		}else{
			$('#att'+id+' input[type="checkbox"]').each(function(i,e2){
		        $(e2).prop('checked',false);
		        $(e2).closest('span').removeClass('checked');
		    });
			var attendance = '-1';
		}
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/employee/category2db.php';?>",
			data: 'action=save_attendance_all&employee_id='+d_id+'&attendance='+attendance+'&date='+date,
			success: function(res){
				//$('#row_id_'+d_id).hide('slow');
				/*if($("input[type='checkbox'][name='attendance"+val+"']:checked").length == 1){
					console.log("checked");
					$('#att'+id+' input[type="checkbox"]').each(function(i,e1){
				          	$(e1).attr('checked');
				          	$(e1).prev().addClass('checked');
				    });
				}else{
					console.log("unchecked");
					$('#att'+id+' input[type="checkbox"]').each(function(i,e2){
				        $(e2).prop('checked',false);
				        $(e2).prev().removeClass('checked');
				    });
				}*/
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
