<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<!-- <select name="sort"><option value="asc" <?php //if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php //if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select> -->
	<label class="checkbox-inline" style="float:left;width:94px;margin-top:8px;"><input tabindex="1" type="radio" name="sort" value="asc" <?php if($_GET['sort'] == 'asc'): echo "checked"; else: ""; endif; ?>>Ascending</label>
	<label class="checkbox-inline" style="float:left;width:104px;margin-top:8px;"><input tabindex="1" type="radio" name="sort" value="desc" <?php if($_GET['sort'] == 'desc'): echo "checked"; else: ""; endif; ?>>Descending</label>
	<select name="filterby">
		<option value="leadsource.name" <?php if($_GET['filterby'] == 'leadsource.name'): echo 'selected';else: ''; endif; ?>>Lead Source</option>
		<option value="leadstage.name" <?php if($_GET['filterby'] == 'leadstage.name'): echo 'selected';else: ''; endif; ?>>Lead Stage</option>
		<option value="lead_owner" <?php if($_GET['filterby'] == 'lead_owner'): echo 'selected';else: ''; endif; ?>>Lead Owner</option>
		<option value="client_firstname" <?php if($_GET['filterby'] == 'client_firstname'): echo 'selected';else: ''; endif; ?>>Client Name</option>
		<option value="client_mobile_no" <?php if($_GET['filterby'] == 'client_mobile_no'): echo 'selected';else: ''; endif; ?>>Client Mobile No.</option>
	</select>

		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<input type="text" name="filter_date" id="filter_date" value="<?php if($_GET['filter_date'] != ''): echo $_GET['filter_date']; else: ''; endif; ?>" placeholder="Select a Lead Date" />
		<!--input type="hidden" name="p" value="<?php //echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline " id="sample_3_wrapper" style="width:96%;height:80%;overflow: auto">
    	<table class="table table-striped table-bordered table-hover leadmanagergrid" id="leadmanagergrid" style="width:100%" >
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th class="hidden-480" width="5%">Job Id</th>
				 <th class="hidden-480" width="8%">Lead Source</th>
				 <th class="hidden-480" width="8%">Lead Owner</th>
				 <!--  <th class="hidden-480">Lead Stage</th> -->
				 <th class="hidden-480" width="13%">Client Details</th>
				  <!-- <th class="hidden-480">Client Mobile No</th> -->
				 <th class="hidden-480" width="30%">Service Details</th>
				 <!-- <th class="hidden-480" width="10%">Service Date/Time</th> -->
				 <th class="hidden-480" width="10%">Order Status</th>
				 <th class="hidden-480" width="10%">Inquiry Date/Time</th>
				 <th class="hidden-480" width="13%">Comments/ Remarks</th>
				 <th class="hidden-480" width="5%">Action</th>
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
			//$filterData = array('city' =>$_SESSION['tmobi']['city']);
			// if ($_GET['filterby']) {
		 //     $filterData = array('city' =>$_SESSION['tmobi']['city'],'lead_source' =>$_SESSION['tmobi']['city']);
			// }
		    if($_SESSION['tmobi']['city'] != '')
 			$filterData['city'] = $_SESSION['tmobi']['city'];

			if(isset($_GET['filter_date'])){
		   		//$filter_date = $_GET['filter_date'];
		   		$filterData['service_date'] = $_GET['filter_date'];
		   		//$filterData['service_date'] = $_GET['filter_date'];
		   		//$filterData['service_date'] = $_GET['filter_date'];
 		    }
			$result_data = $modelObj->getListingData($_GET['filterby'], $page,$recperpage,$searchData,$filterData,'',$sort);

			//echo "<pre>";print_r($result_data);
			if(count($result_data['rows']) > 0):
			foreach ($result_data['rows'] as $key){
				$mhcclientInfo = "";
				$mhcclientInfo = $mhcclient[$key['mhcclient_id']];
				//print_r($mhcclientInfo);
				// if($key['parent_id'] == 0){
				// 	$is_parent_val = 'Yes';
				// }else{
				// 	$is_parent_val = '--';
				// }
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				<!-- <td><?php //print $key['category_id'];?></td> -->
				<td class="hidden-480"><?php print 'J'.$key['id'];?></td>
				<td class="hidden-480"><?php print $leadsources[$key['lead_source']];?></td>
				<td class="hidden-480"><?php print $key['lead_owner'];?></td>
				<!-- <td class="hidden-480">
					<select class="small m-wrap lead_stage" style="width:94px !important" name="lead_stage" id="leadstage<?php print $key['id'];?>" onchange="changeLeadStage(<?php print $key['id'];?>);">
					<?php 
					if($leadstage)
						echo optionsGeneratorNew($leadstage,$key['lead_stage']); 
					else
						echo $modelObj->optionsGenerator('leadstage', 'name', 'id', $key['lead_stage'], "where  status='0'"); ?>
					</select>
					<div id="dialog-modal_<?php echo $key['id']; ?>" class="dialog-modal">
						<label for="">Reminder:</label>
						<input id="datePicker<?php echo $key['id']; ?>" class="datePicker" type="date" />
						<input type="button" class="test" value="Set" data-id="<?php echo $key['id']; ?>"/>
				
					</div>
				</td> -->

				<td class="hidden-480"><b style='color:#008080'><?php print $mhcclientInfo['client_firstname'].' ' .$mhcclientInfo['client_lastname'].'</b></br>'.$mhcclientInfo['client_mobile_no'].'</br>'.$mhcclientInfo['address'];?><?php echo !empty($mhcclientInfo['landmark']) ? ', '.$mhcclientInfo['landmark'] : ''.!empty($mhcclientInfo['location']) ? ', '.$mhcclientInfo['location'] : ''; ?></td>
				<!-- <td class="hidden-480"><?php //print $key['client_mobile_no'];?></td> -->
				<td class="hidden-480">
					<?php /*if($pricelist[$key['service_inquiry1']] != '')
						echo $pricelist[$key['service_inquiry1']].':'.$variant[$key['varianttype1']]."<br />";
						if($pricelist[$key['service_inquiry2']] != '')
						echo $pricelist[$key['service_inquiry2']].':'.$variant[$key['varianttype2']]."<br />";
						if($pricelist[$key['service_inquiry3']] != '')
						echo $pricelist[$key['service_inquiry3']].':'.$variant[$key['varianttype3']]."<br />";*/
					?>
					<table>
					<?php 
						$services = $modelObj->getServiceDetailsforLead1($key['id']);

						foreach ($services as $key1 => $value) {
							if(($key1+1) <= 6){
							echo "<tr><td style='width:50%;border:0px;padding:8px 0px 0px 0px;'><b>".$pricelist[$services[$key1]['service_inquiry']].'</b>:'.$variant[$services[$key1]['varianttype_id']]."</td>";
							echo "<td style='width:50%;border:0px;padding:8px 0px 0px 0px;text-align:center'>";
							if($services[$key1]['service_date'] != "0000-00-00" && $services[$key1]['service_date']!='')
								print "  <span style='color:#008080'>".date('d M Y',strtotime($services[$key1]['service_date'])). ' '.date('h:i A',strtotime($services[$key1]['service_time']));
							else
								echo " --";
							echo ' </td>';
							echo "</tr>";
							}
						}
						
					?>
					</table>
					<?php
					if(count($services) >= 6){
							echo "<a href='javascript::void();' onclick='showServices(".$key["id"].")' data-toggle='modal' data-target='#servicelisting' style='color:#3c948b'>view more...</a>";
						}
					?>
					</td>
				<!-- <td class="hiddenen-480"><?php //print date('d M Y',strtotime($key['service1_date']));?></td> -->
				<!-- <td class="hidden-480">
					<?php 
					foreach ($services as $key1 => $value) {
					if($services[$key1]['service_date'] != "0000-00-00" && $services[$key1]['service_date']!='')
						print date('d M Y',strtotime($services[$key1]['service_date'])). ' '.date('h:i A',strtotime($services[$key1]['service_time'])).' <br />';
					else
						echo "-";
					}
					?>
				</td> -->
				 <td id="confirmed<?php echo $key['id']; ?>">
				 	<?php if($key['job_status']=='confirmed'): ?>
				 	<select name="job_status<?php echo $key['id']; ?>" style="width:94px !important" id="job_status<?php echo $key['id']; ?>" tabindex="1" class="small m-wrap " onchange="update_status('<?php echo $key['id']; ?>');">
				 		<option value="pending">Pending</option>
				 		<option value='in_process'>In Process</option>
				 		<option value='confirmed' selected='selected'>Confirmed</option>
				 	</select>
				<?php  else: ?>
				 	<select name="job_status<?php echo $key['id']; ?>" style="width:94px !important" id="job_status<?php echo $key['id']; ?>" tabindex="1" class="small m-wrap " onchange="update_status('<?php echo $key['id']; ?>');">
				 		<option value="pending" <?php if($key['job_status']=='pending'): echo "selected"; else: echo "";endif; ?>>Pending</option>
				 		<option value='in_process' <?php if($key['job_status']=='in_process'): echo "selected"; else: echo "";endif; ?>>In Process</option>
				 		<option value='confirmed' <?php if($key['job_status']=='confirmed'): echo "selected"; else: echo "";endif; ?>>Confirmed</option>
				 	</select>
				 <?php endif; ?>
				</td>
				<td><?php echo date('d M Y h:i A',strtotime($key['insert_date'])); ?></td>
				<td class="hidden-480"><?php print $key['additional_note'];?></td>
				<td>
					<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success" style="margin-top:6px;"><a href="<?php print SITEPATH.'/'.$modelObj->folderName.'/display.php?leadmanager_id='.encryptdata($key['id']); ?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning" style="margin-top:6px;"><a href="javascript:void(0);" onclick="deleteConfirm('leadmanager',<?php print $key['id'];?>,'delete_leadmanager','leadmanager_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>&nbsp;
			  		<?php endif; ?>
			  		<span class="label" style="margin-top:6px; background-color:#67BCDB;"><a href="javascript:void(0);" onclick="displayservice(<?php print $key['id']; ?>)" class="edit" title="View Service Details" style="color:#FFFFFF;padding:6px;" data-toggle="modal" data-target="#servicelisting"><i class="fa fa-eye" aria-hidden="true" style="padding:4px 0px"></i></a></span>
			  	</td>
			  </tr>
		<?php } else: ?>
			<tr class="odd gradeX"><td colspan='9' style='text-align:center'>No records found</td><tr>
		<?php endif; ?>
		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>
      </div>
   </div>
<!----SERVICE LISTING POPUP STARTS HERE------- -->
 	<div class="modal fade" id="servicelisting" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Services</h4>
        </div>
        <div class="modal-body" id="showsevices">
          		
        </div>
       </div>
    </div>
  </div>

<!----SERVICE LISTING POPUP ENDS HERE------- -->
<table>

</table>
 <script src="<?php print JSFILEPATH;?>/jquery.mCustomScrollbar.js" type="text/javascript"></script> 
<script>
var x = 450;var y = 250;
$(document).ready(function () {
	
	var topOffset = parseInt($(".leadmanagergrid table thead").css('top'));

(function($){
      $(window).load(function(){
        
        $(".leadmanagergrid").mCustomScrollbar({
          snapAmount:40,
          scrollButtons:{enable:true},
          keyboard:{scrollAmount:40},
          mouseWheel:{deltaFactor:40},
          scrollInertia:400,
           advanced:{
     autoScrollOnFocus: false,
     updateOnContentResize: true
   }      	
        });
      });
    })(jQuery);


	
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

  $("#filter_date").datepicker({
   	dateFormat:"yy/mm/dd"
   });
  $("#leadmanager-count").html("<?php echo $result_data['count']; ?>");

});
function showServices(id){
	$.ajax({
		type: "POST",
		url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
		data: 'action=getServicesList&leadmanager_id='+id,
		success: function(r){
			var obj = eval("("+r+")");
			variant = <?php echo json_encode($variant); ?>;
			pricelist = <?php echo json_encode($pricelist); ?>;
			html = '<table>';
			//html += "<li>";
			$.each(obj,function(i,e){

				html += "<tr><td style='width:50%;border:0px;padding:8px 0px 0px 0px;'><b>"+pricelist[e.service_inquiry]+"</b> :"+variant[e.varianttype_id]+"</td><td style='width:50%;border:0px;padding:8px 0px 0px 0px;text-align:center'><span style='color:#008080'> ";
				if((e.service_date)=='0000-00-00'){
					datetime = 	'--';
				}else{
					datetime = 	moment(e.service_date+" "+e.service_time).format('MMM Do YYYY h:mm a');
				}
				html += datetime+"<span></td></tr>";
			});
			html +='</table>';
			$('#showsevices').html(html);
			//send_invoice_email(id);
		},
		error:function(){
		alert("failure");
		//$("#result").html('there is error while submit');
		}
	});
}

function displayservice(id){

	$.ajax({
		type: "POST",
		url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
		data: 'action=getServicesList&leadmanager_id='+id,
		success: function(r){
			var obj = eval("("+r+")");
			variant = <?php echo json_encode($variant); ?>;
			pricelist = <?php echo json_encode($pricelist); ?>;
			html = '<table class="table table-striped table-bordered table-hover">';
			html += "<tr><th>Service Name</th><th>Variant</th><th>Sqft</th><th>Service Date/time</th><th>Service Price</th><th>Service Discount</th><th>Client payment expected</th><th>Partner receivable</th><th>Partner Payable</th><th>Service Duration</th><th>Contract Start Date</th><th>Contract end date</th><th>Freaquency</th><th>No. of service</th></tr>";
			$.each(obj,function(i,e){
				html += "<tr><td>"+pricelist[e.service_inquiry]+"</td><td>"+variant[e.varianttype_id]+"</td><td>"+e.sqft+"</td><td>"+e.service_date+" "+e.service_time+"</td><td>"+e.service_price+"</td><td>"+e.service_discount+"</td><td>"+e.client_payment_expected+"</td><td>"+e.partner_receivable+"</td><td>"+e.partner_payable+"</td><td>"+e.service_duration+"</td><td>"+e.contract_start_date+"</td><td>"+e.contract_end_date+"</td><td>"+e.frequency+"</td><td>"+e.no_of_service+"</td></tr>";
			});
			html +='</table>';
			$('#showsevices').html(html);
			//send_invoice_email(id);
		},
		error:function(){
		alert("failure");
		//$("#result").html('there is error while submit');
		}
	});
			
		
}

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
			/*			if(status == "confirmed"){
							$.ajax({
								type: "POST",
								url: "<?php print SITEPATH.'/'.$modelObj->folderName.'/category2db.php';?>",
								data: 'action=saveIntoOrder&leadmanager_id='+id,
								success: function(r){
									var html = '<select name="job_status'+id+'" id="job_status'+id+'" tabindex="1" class="small m-wrap " onchange="update_status('+id+');">';

				 					html +='<option value="pending">Pending</option>';
						 		html +="<option value='in_process'>In Process</option>";
						 		html +="<option value='confirmed' selected='selected'>Confirmed</option>";
				 				html +='</select>';
									$('#confirmed'+id).html(html);
									//send_invoice_email(id);
								}
							});
						}*/
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
			//var reminder = $('#reminder'+id).val();
			var reminder =  $('#datePicker'+id).val();
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

	function getDatePickerId(id,current){
$(current).datetimepicker({
    	 onSelectDate: function(dateText) {
    	 	//currentObj = $('.reschedule_order').attr('id');
    	 	orderId = $(".reschedule_order").data('orderid');
    	 	month = dateText.getMonth() + 1
    	 	tt = dateText.getFullYear()+'/'+(month)+ '/'+dateText.getDate()+' '+dateText.getHours()+':'+dateText.getMinutes();
    		r = confirm("Are you sure you want to reschedule order?");
    		if(r){
    			set_reminder(id);
    		}
    	},
    	onSelectTime: function(t){
    		//currentObj = $('.reschedule_order').attr('id');
    		orderId = $(".reschedule_order").data('orderid');
    		month = t.getMonth() + 1
    	 	datetime = t.getFullYear()+'/'+(month)+ '/'+t.getDate()+' '+t.getHours()+':'+t.getMinutes();
    		r = confirm("Are you sure you want to reschedule order?");
    		if(r){
    			set_reminder(id);
    		}
    	}
    });
	
}

$(document).ready( function() {
    var now = new Date();
 
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;


   $('.datePicker').val(today);
    
    $('.test').click(function(){
    	var dataId = $(this).attr('data-id');
    	debugger;
        
        set_reminder(dataId);
        
    });
});


</script>
