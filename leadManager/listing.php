<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>ASC</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>DESC</option></select>
	<select name="filterby">
		<option value="leadsource.name" <?php if($_GET['filterby'] == 'leadsource.name'): echo 'selected';else: ''; endif; ?>>Lead Source</option>
		<option value="leadstage.name" <?php if($_GET['filterby'] == 'leadstage.name'): echo 'selected';else: ''; endif; ?>>Lead Stage</option>
		<option value="lead_owner" <?php if($_GET['filterby'] == 'lead_owner'): echo 'selected';else: ''; endif; ?>>Lead Owner</option>

	</select>

		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<!-- <form name="export" method="post">
    	<input type="submit" value="Click Me!" name="export2excel">
</form> -->

<!-- <?php

if(isset($_POST["export2excel"]))
{
	$modelObj->ExportExcel("leadmanager");
}

?> -->
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th class="hidden-480">Lead Source</th>
				 <th class="hidden-480">Lead Owner</th>
				  <th class="hidden-480">Lead Stage</th>
				 <th class="hidden-480">Client Name</th>
				  <th class="hidden-480">Client Mobile No</th>
				 <th class="hidden-480">Service Date</th>
				 <th class="hidden-480">Service Time</th>
				 <th class="hidden-480">Job Status</th>
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
			// if ($_GET['filterby']) {
		 //     $filterData = array('city' =>$_SESSION['tmobi']['city'],'lead_source' =>$_SESSION['tmobi']['city']);
			// }

			$result_data = $modelObj->getListingData($_GET['filterby'], $page,$recperpage,$searchData,$filterData,'',$sort);

			//print_r($result_data);
			foreach ($result_data['rows'] as $key){
				// if($key['parent_id'] == 0){
				// 	$is_parent_val = 'Yes';
				// }else{
				// 	$is_parent_val = '--';
				// }
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				<!-- <td><?php print $key['category_id'];?></td> -->
				<td class="hidden-480"><?php print $key['leadsource_name'];?></td>
				<td class="hidden-480"><?php print $key['lead_owner'];?></td>
				<td class="hidden-480">
					<select class="small m-wrap lead_stage" name="lead_stage" id="leadstage<?php print $key['id'];?>" onchange="changeLeadStage(<?php print $key['id'];?>);">
					<?php echo $modelObj->optionsGenerator('leadstage', 'name', 'id', $key['leadstage_id'], "where  status='0'"); ?>
					</select>
					<div id="dialog-modal_<?php echo $key['id']; ?>" class="dialog-modal">
						<label for="">Reminder:</label>
						<select name="reminder<?php echo $key['id']; ?>" id="reminder<?php echo $key['id']; ?>" tabindex="1" class="medium m-wrap leadstage" onchange="" data-id="<?php echo $key['id']; ?>">
							<option value="1D" <?php if($key['reminder']=='1D'): echo "selected"; else: echo "";endif; ?>>1D</option>
							<option value='3D' <?php if($key['reminder']=='3D'): echo "selected"; else: echo "";endif; ?>>3D</option>
							<option value='5D' <?php if($key['reminder']=='5D'): echo "selected"; else: echo "";endif; ?>>5D</option>
							<option value='1W' <?php if($key['reminder']=='1W'): echo "selected"; else: echo "";endif; ?>>1W</option>
							<option value='2W' <?php if($key['reminder']=='2W'): echo "selected"; else: echo "";endif; ?>>2W</option>
							<option value='3W' <?php if($key['reminder']=='3W'): echo "selected"; else: echo "";endif; ?>>3W</option>
							<option value='1M' <?php if($key['reminder']=='1M'): echo "selected"; else: echo "";endif; ?>>1M</option>
						</select>
					</div>
				</td>
				<td class="hidden-480"><?php print $key['client_firstname'];?></td>
				<td class="hidden-480"><?php print $key['client_mobile_no'];?></td>
				<td class="hidden-480"><?php print $key['service1_date'];?></td>
				<td class="hidden-480"><?php print $key['service1_time'];?></td>
				 <td id="confirmed<?php echo $key['id']; ?>">
				 	<?php if($key['job_status']=='confirmed'):
				 	echo "Confirmed";
				 else: ?>
				 	<select name="job_status<?php echo $key['id']; ?>" id="job_status<?php echo $key['id']; ?>" tabindex="1" class="small m-wrap " onchange="update_status('<?php echo $key['id']; ?>');">
				 		<option value="pending" <?php if($key['job_status']=='pending'): echo "selected"; else: echo "";endif; ?>>Pending</option>
				 		<option value='in_process' <?php if($key['job_status']=='in_process'): echo "selected"; else: echo "";endif; ?>>In Process</option>
				 		<option value='confirmed' <?php if($key['job_status']=='confirmed'): echo "selected"; else: echo "";endif; ?>>Confirmed</option>
				 	</select>
				 <?php endif; ?>
				</td>
				<td>
					<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/'.$modelObj->folderName.'/display.php?leadmanager_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('leadmanager',<?php print $key['id'];?>,'delete_leadmanager','leadmanager_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
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
var x = 450;var y = 250;
$(document).ready(function () {
	(function($) {
	    if (!$.curCSS) {
	       $.curCSS = $.css;
	    }
	})(jQuery);

    $('.dialog-modal').dialog({
        modal: true,
        autoOpen: false,

    });
    jQuery(".dialog-modal").dialog('option', 'position', [x,y]);

   $( ".leadstage" ).on('change',function() {
  var myid =  $(this).attr("data-id");
 	 set_reminder(myid);
	});

});

	function createDialog(id){
	$('#dialog-modal_'+id).dialog({
        modal: true,
        autoOpen: false,

    });
     jQuery('#dialog-modal_'+id).dialog('option', 'position', [x,y]);
	}

/*	function dele_leadmanager(d_id){ //alert(d_id);
		if(d_id !=''){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=delete_leadmanager&leadmanager_id='+d_id,
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
	function changeLeadStage(id){
		var current= $('#leadstage'+id).val();

		$.ajax({
			type:"POST",
			url:"<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
			data: 'action=update_leadstage&leadmanager_id='+id+'&leadstage_id='+current,
			success: function(res){
				// alert("lead stage updated");
				$('#dialog-modal_'+id).dialog('open');
			},
			//success: getData,
			error:function(){
				// alert("failure");
				//$("#result").html('there is error while submit');
			}
		})
	}
	function update_status(id){
		if(id !=''){
			var status = $('#job_status'+id).val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=update_leadmanager_status&leadmanager_id='+id+'&status='+status,
				success: function(res){
					//if(res.result == 'success'){
						if(status == "confirmed"){
							$.ajax({
								type: "POST",
								url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
								data: 'action=saveIntoOrder&leadmanager_id='+id,
								success: function(r){
									$('#confirmed'+id).html('Confirmed');
									send_invoice_email(id);
								}
							});
						}
					//}
					alert("Status updated!");
				},
				//success: getData,
				error:function(){
					alert("failure");
					//$("#result").html('there is error while submit');
				}

			});
		}
	}
	function send_invoice_email(id){
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
			data: 'action=sendInvoiceMail&leadmanager_id='+id,
			success: function(res){
				if(res){
					console.log(res);
				}
				alert("Invoice sent!");
			},
			error:function(){
				alert("failure");
			}
		});
	}

	function set_reminder(id){

		if(id !=''){
			var reminder = $('#reminder'+id).val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
				data: 'action=set_lead_reminders&leadmanager_id='+id+'&reminder='+reminder,
				success: function(res){
					alert("Reminder Set !!!");
					$('#dialog-modal_'+id).dialog('destroy');
					createDialog(id);

				},
				error:function(){
					alert("failure");

				}

			});
		}
	}

</script>
