<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');
if( $memcache){
	//$leadstage = $memcache->get('leadstage');
	$mhcclient = $memcache->get('mhcclient');
	$leadsources = $memcache->get('leadsource');
	$pricelist = $memcache->get('pricelist');
	$lead_dropdown = $memcache->get('pricelist_dropdown');
	$cities = $memcache->get('city');
}else{
	$cities = $dashboardObj->city();
	$leadsources = $dashboardObj->leadsource();
	$pricelist = $dashboardObj->pricelist();
}
?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>Ascending</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>Descending</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<input type="text" name="filter_date" id="filter_date" value="<?php if($_GET['filter_date'] != ''): echo $_GET['filter_date']; else: ''; endif; ?>" placeholder="Select a Order Date" />
		<!--input type="hidden" name="p" value="<?php //echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" style="width:96%;height:80%;overflow: auto" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" id="" style="width:100%">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th class="hidden-480">Client Info</th>
				 <th class="hidden-480">Source</th>
				 <th class="hidden-480">Service</th>
				 <th class="hidden-480">Service Date</th>
				<!--  <th class="hidden-480">Service Time</th> --><!-- 
				 <th class="hidden-480">Contact No</th> -->
				 <!-- <th class="hidden-480">Email Id</th> -->
				 <th class="hidden-480"> Site Address</th>
				 <th class="hidden-480">Billing Amount</th>
				 <th class="hidden-480">Job Updates</th>
				 <th class="hidden-480">Team Leader</th>
				 <th class="hidden-480">Supervisor</th>
				 <th class="hidden-480">Janitor</th>
				 <th class="hidden-480">Invoice</th>
				 <th class="hidden-480">Payment Mode</th>
				 <th class="hidden-480">Payment Status</th>
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

		   if(isset($_GET['filter_date'])){
		   		//$filter_date = $_GET['filter_date'];
		   		$filterData['service_date'] = $_GET['filter_date'];
 		   }
 		   //$filterData['service_date']
 		   if($_SESSION['tmobi']['city'] != '')
 			$filterData['city'] = $_SESSION['tmobi']['city'];

		   $recperpage=PER_PAGE_ROWS;
			$result_data = $modelObj->getListingData('lead_source,name,city', $page,$recperpage,$searchData,$filterData,0,$sort);

			foreach ($result_data['rows'] as $key){
				if($key['parent_id'] == 0){
					$is_parent_val = 'Yes';
				}else{
					$is_parent_val = '--';
				}
				if($key['city']){
					$key['cityname'] = $cities[$key['city']];
				}
		 ?>
			  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
				<!-- <td><input type="checkbox" class="checkboxes" value="1" /></td>-->
				 <td><?php print ucfirst($key['name']);
				 if($key['mobile_no'] != '') echo '<br />'.$key['mobile_no'];
				 if($key['email_id']) echo '<br />'.$key['email_id'];?></td>
				 <td class="hidden-480"><?php print $leadsources[$key['lead_source']];?></td>
				 <td class="hidden-480">
				 	<?php 
				 		//print_r($key['service']);
				 		$services = explode(',', $key['service']);
				 		foreach ($services as $service) {
				 			print $lead_dropdown[$service];
				 		}
				 		
				 	?>
				 </td>
				 <td class="hidden-480" width="20%"><span><?php if($key['service_date'] !='0000-00-00 00:00:00') print date('d M Y h:i A',strtotime($key['service_date'])); ?></span>
					<a href="javascript:void(0);" data-orderid="<?php print $key['id'];?>" onclick="getDatePickerId('reschedule_order<?php print $key['id'];?>',this);" id="reschedule_order<?php print $key['id'];?>" class="edit reschedule_order" title="Reschedule Order" style="color:#FFFFFF"><img src="../img/calendar.png" /> </a>
					<!-- <input type="text" name="reschedule_order" id="reschedule_order" value="" />  -->
				 </td>
				<!-- <td class="hidden-480"><?php //print $key['service_time'];?></td> -->
				<!--  <td class="hidden-480"><?php //print $key['mobile_no'];?></td>
				 <td class="hidden-480"><?php //print $key['email_id'];?></td> -->
				<td class="hidden-480"><?php print $key['address'];?></td>
				<td class="hidden-480"><?php print $key['taxed_cost'];?></td>

				<td class="hidden-480 jobinfo<?php print $key['id'];?>">

					<?php if($key['job_start'] == '' || $key['job_start'] == '000-00-00'): ?>
					<input type="checkbox" name="job_info<?php print $key['id'];?>" value="job_start" onchange="updateJobInfo(<?php print $key['id'];?>)">Start
					<?php elseif($key['job_end'] == '' || $key['job_end'] == '000-00-00'): ?>
					<input type="checkbox" name="job_info<?php print $key['id'];?>" value="job_end" onchange="updateJobInfo(<?php print $key['id'];?>)">End
					<?php else:
						if($key['job_status'] == 'success'):
					?>
						<select class="small m-wrap jobstatus" name="job_status" style="width:94px !important" id="jobstatus<?php print $key['id'];?>" onchange="saveJobStatus(<?php print $key['id'];?>)">
						<option value="">Please Select</option>
						<option value="success" <?php if($key['job_status'] == 'success'): echo "selected"; else: ""; endif; ?>>Success</option>
						<option value="complaint">Complaint</option>
					</select>
					<?php else: ?>
					<select class="small m-wrap jobstatus" name="job_status" style="width:94px !important" id="jobstatus<?php print $key['id'];?>" onchange="saveJobStatus(<?php print $key['id'];?>)">
						<option value="">Please Select</option>
						<option value="success">Success</option>
						<option value="complaint" <?php if($key['job_status'] == 'complaint'): echo "selected"; else: ""; endif; ?>>Complaint</option>
					</select>
					<?php endif; endif; ?>
					<br /><button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="<?php print $key['id'];?>" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick='remarkPopup(<?php print $key['id'];?>)'>Remark</button>
				</td>
				<td><input type="textbox" onchange="change_deployment(<?php print $key['id'];?>,'teamleader',this)" style="border-color:gray;width:97%;text-align:center" placeholder="Team Leader" value="<?php echo $key['teamleader_deployment']; ?>" name="teamleader_deployment"></td>
				<td><input type="textbox" onchange="change_deployment(<?php print $key['id'];?>,'supervisor',this)" style="border-color:gray;width:97%;text-align:center" placeholder="Supervisor" value="<?php echo $key['supervisor_deployment']; ?>" name="supervisor_deployment"></td>
				<td><input type="textbox" onchange="change_deployment(<?php print $key['id'];?>,'janitor',this)" style="border-color:gray;width:97%;text-align:center" placeholder="Janitor" value="<?php echo $key['janitor_deployment'] ?>" name="janitor_deployment"></td>
				<td class="hidden-480">
					<button type="button" class="btn-info invoicebtn btn-sm" id="bill<?php print $key['id'];?>" onclick="generateInvoice('<?php print $key['id'];?>')" data-toggle="modal" data-target="#billing" data-id="<?php print $key['id'];?>" data-billingname="<?php print $key['billing_name'];?>" data-billingname2="<?php print $key['leadsource_name'];?>" data-billingemail="<?php print $key['email_id'];?>" data-billingemail2="<?php print $key['billing_email2'];?>" data-billingaddress="<?php print $key['billing_address'];?>" data-billingaddress2="<?php print $key['billing_address2'];?>" data-billingamount="<?php print $key['taxed_cost'];?>" data-billingamount2="<?php print $key['billing_amount2'];?>">Send</button>
				</td>
				<td>
					<select class="small m-wrap payment_mode" name="payment_mode" style="width:120px !important" id="paymentMode<?php print $key['id'];?>" onchange="changePaymentMode(<?php print $key['id'];?>,this.value)">
						<option value="">Payment Mode</option>
						<option value="online" <?php if($key['payment_mode'] == 'instamojo'): echo "selected"; else: ""; endif; ?>>Instamojo</option>
						<option value="online" <?php if($key['payment_mode'] == 'hdfc'): echo "selected"; else: ""; endif; ?>>HDFC</option>
						<option value="cheque" <?php if($key['payment_mode'] == 'cheque'): echo "selected"; else: ""; endif; ?>>Cheque</option>
						<option value="cash" <?php if($key['payment_mode'] == 'cash'): echo "selected"; else: ""; endif; ?>>Cash</option>
					</select>
					
				</td>
				<td>
					<select class="small m-wrap payment_status" name="payment_status" style="width:122px !important" id="paymentStatus<?php print $key['id'];?>" onchange="changePaymentStatus(<?php print $key['id'];?>,this.value)">
						<option value="">Payment Status</option>
						<option value="pending" <?php if($key['payment_status'] == 'pending'): echo "selected"; else: ""; endif; ?>>Pending</option>
						<option value="part_received" <?php if($key['payment_status'] == 'part_received'): echo "selected"; else: ""; endif; ?>>Part Received</option>
						<option value="success" <?php if($key['payment_status'] == 'success'): echo "selected"; else: ""; endif; ?>>Success</option>
						<option value="cancelled" <?php if($key['payment_status'] == 'cancelled'): echo "selected"; else: ""; endif; ?>>Cancelled</option>
						<option value="failed" <?php if($key['payment_status'] == 'failed'): echo "selected"; else: ""; endif; ?>>Failed</option>
					</select>
				</td>

				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/order/display.php?order_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> 
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning" style="margin-top:5px"><a href="javascript:void(0);" onclick="deleteConfirm('order',<?php print $key['id'];?>,'delete_order','order_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
					<?php endif; ?>
					<span class="label" style="margin-top:5px"><a href="javascript:void(0);" class="edit" onclick="printWorkOrder('<?php echo htmlspecialchars(json_encode($key)); ?>');" title="Print Work Order" style="color:#FFFFFF"><img src="../img/print.png"/> </a></span><br />
					<?php if($key['status'] != '1'): ?>
					<span class="label label-warning" style="margin-top:5px"><a href="javascript:void(0);" onclick="cancelOrder(<?php print $key['id'];?>)" class="edit" title="Cancel Order" style="color:#FFFFFF"><img src="../img/icon-color-close.png" /> </a></span>
					<?php elseif($key['status'] == '1'): ?>
					 <span style="margin-top:5px">Order Cancelled</span>
					<?php endif; ?>

				</td>
			  </tr>
		<?php } ?>
		   </tbody>
		</table>
		<?php echo $modelObj->pagination($recperpage,$page,$result_data['count']); ?>
		<div id="dialog-modal">
			<label for="">Order Feedback:</label>
			 <textarea rows="3" name="order_feedback" id="order_feedback" class="m-wrap span8"><?php echo isset($data)?trim($data['order_feedback']):''; ?></textarea>
			 <button class="btn blue" name="button" onclick="saveOrderFeedback(<?php print $key['id'];?>)">Submit</button>
		</div>
      </div>
   </div>
<!----BILLING POPUP STARTS HERE------- -->
 <div class="modal fade" id="billing" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Billing Details</h4>
        </div>
        <div class="modal-body">
        	<form name="frmBilling" id="frmBilling">
          		<p>Billing Name <input type="text" name="billing_name" id="billing_name"></p>
          		<p>Email ID <input type="text" name="billing_email" id="billing_email"></p>
          		<p>Billing Address <textarea name="billing_address" id="billing_address" ></textarea></p>
          		<p>Billing Amount <input type="text" name="billing_amount" id="billing_amount" readonly></p>
          		<input type="checkbox" name="isPartner" value="1" id="isPartner" >Is Partner 
          		<div id="partnerBill">
          			<p>Partner Name <input type="text" name="billing_name2" id="billing_name2"></p>
          			<p>Partner Email ID <input type="text" name="billing_email2" id="billing_email2"></p>
          			<p>Partner Address <textarea name="billing_address2" id="billing_address2" ></textarea></p>
          			<p>Partner Bill Amount <input type="text" name="billing_amount2" id="billing_amount2" readonly></p>
          		</div>
          		<input type="hidden" name="order_id" id="order_id" />
          		<input type="hidden" name="action" value="addBillingDetails" /> 
          		<button type="submit" class="btn btn-default" id="addBillDetails">Submit</button>
        	</form>
        </div>
       </div>
    </div>
</div>
<!----BILLING POPUP ENDS HERE------- -->

<!----REMARK POPUP STARTS HERE------- -->
 <div class="modal fade" id="remark" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Remark</h4>
        </div>
        <div class="modal-body">
        	<div id="listRemarks"></div>
        	<form name="frmOrderRemark" id="frmOrderRemark">
          		<p>Add Remark: <textarea rows="3" cols="30" name="remark" id="remarkText"></textarea></p>
          		<input type="hidden" name="orderId" id="orderId" /> 
          		<input type="hidden" name="remark_entry" id="remarkEntry" /> 
          		<input type="hidden" name="action" value="addRemark" /> 
          		<button type="submit" class="btn btn-default" id="addRemark">Submit</button>
        	</form>
        </div>
      </div>
    </div>
  </div>
<!----REMARK POPUP ENDS HERE------- -->
<!----PAYMENT MODE POPUP STARTS HERE------- -->
 <div class="modal fade" id="pay_mode" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Payment Info</h4>
        </div>
        <div class="modal-body">
        	<form name="frmPaymentInfo" id="frmPaymentInfo">
          		<p>Payment Info: <textarea rows="3" cols="30" name="payment_info" id="payment_info"></textarea></p>
          		<input type="hidden" name="action" value="addPaymentInfo" /> 
          		<input type="hidden" name="paymodeorderid" id="paymodeorderid" />
          		<button type="submit" class="btn btn-default" id="addPaymentInfo">Submit</button>
        	</form>
        </div>
      </div>
    </div>
  </div>
<!----PAYMENT MODE POPUP ENDS HERE------- -->
<!----DEPLOYMENT POPUP STARTS HERE------- -->
 <!-- <div class="modal fade" id="orderDeployment" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Deployment</h4>
        </div>
        <div class="modal-body">
        	<form name="frmOrderDeployment" id="frmOrderDeployment">
          		<p>Add No. Of Deployment <input type="text" name="deployment" id="deployment"></p>
          		<input type="hidden" name="deployment_orderid" id="deployment_orderid" />
          		 <input type="hidden" name="action" value="addDeployment" /> 
          		<button type="submit" class="btn btn-default" id="addDeployment">Submit</button>
        	</form>
        </div>
       </div>
    </div>
  </div> -->
<!----DEPLOYMENT POPUP ENDS HERE------- -->

<!----PAYMENT RECEIVED POPUP STARTS HERE------- -->
 <div class="modal fade" id="paymentReceived" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">Payment Received</h4>
        </div>
        <div class="modal-body">
        	<form name="frmPaymentReceived" id="frmPaymentReceived">
          		<p>Received Amount: <input type="text" name="received_amount" id="received_amount"></p>
          		<input type="hidden" name="payment_orderid" id="payment_orderid" />
          		 <input type="hidden" name="action" value="updatePaymentReceived" /> 
          		<button type="submit" class="btn btn-default" id="updatePaymentReceived">Submit</button>
        	</form>
        </div>
       </div>
    </div>
  </div>
<!----PAYMENT RECEIVED POPUP ENDS HERE------- -->
<script>
$(document).ready(function () {
	
	(function($) {
	    if (!$.curCSS) {
	       $.curCSS = $.css;
	    }
	})(jQuery);
	$("#partnerBill").hide();
    $('#dialog-modal').dialog({
        modal: true,
        autoOpen: false,
				open: function(){
      jQuery('.ui-widget-overlay').bind('click',function(){
         dialogopen.dialog('close');
      });
   },
   width: "80%",
   maxWidth: "768px"

    });
   $("#filter_date").datepicker({
   	dateFormat:"yy/mm/dd"
   });

    $('.jobstatus').change(function () {

			var x = 250;
			var y = 250;
			jQuery("#dialog-modal").dialog('option', 'position', [x,y]);
            $('#dialog-modal').dialog('open');
    });
     $("#isPartner").change(function(){
    	if($("#isPartner").is(":checked"))
    	{
    		$('#partnerBill').show();
    	}else{
    		$('#partnerBill').hide();
    	}
    });
    $("#addBillDetails").click(function(){
    	$('#frmBilling').validate({
		rules:{
			billing_name:"required",
			billing_address: "required",
			billing_email:"required"
		},
		submitHandler: function() {
			formdata = $('#frmBilling').serialize();

			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: formdata,
				success: function(res){
					if(res){
						var obj = eval("("+res+")");
						v = $('#frmBilling').serializeArray();
/*						v = $('#frmBilling').serializeArray();
						console.log(v);return;
*/						arr = [];
						arr['billing_email'] = v[1].value;
						arr['billing_name'] = v[0].value;
						arr['billing_address']=v[2].value;
						arr['billing_amount']=v[3].value;
						arr['isPartner']=v[4].value;
						arr['billing_name2']= v[5].value;
						arr['billing_email2']=v[6].value;
						arr['billing_address2']=v[7].value;
						arr['billing_amount2']=v[8].value;
						//console.log(arr);
						send_invoice_email(formdata);
						$('#order_id').val('');
						$('#billing').modal('toggle');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});
    })
   /* $('#addDeployment').click(function(){
	    $('#frmOrderDeployment').validate({
		rules:{
			deployment:"required"
		},
		submitHandler: function() {
			//var orderId = $(this).data('orderid');
			var formDate = $('#frmOrderDeployment').serialize();
			$('#deployment_orderid').val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: formDate,
				success: function(res){
					if(res){
						$('#deployment').val('');
						$('#orderDeployment').modal('toggle');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});
	});*/
    $("#updatePaymentReceived").click(function(){
    	 $('#frmPaymentReceived').validate({
		rules:{
			received_amount:"required"
		},
		submitHandler: function() {
			//var orderId = $(this).data('orderid');
			var formDate = $('#frmPaymentReceived').serialize();
			$('#payment_orderid').val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: formDate,
				success: function(res){
					if(res){
						$('#received_amount').val('');
						$('#paymentReceived').modal('toggle');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});

    });
    $('#addRemark').click(function(){
	    $('#frmOrderRemark').validate({
		rules:{
			remark:"required"
		},
		submitHandler: function() {
			//var orderId = $(this).data('orderid');
			var formDate = $('#frmOrderRemark').serialize();
			$('#orderId').val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: formDate,
				success: function(res){
					if(res){
						$('#remarkText').val('');
						$('#remark').modal('toggle');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});
	});
	$("#addPaymentInfo").click(function(){
		 $('#frmPaymentInfo').validate({
		rules:{
			payment_info:"required"
		},
		submitHandler: function() {
			//var orderId = $(this).data('orderid');
			var formDate = $('#frmPaymentInfo').serialize();
			//$('#orderId').val();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: formDate,
				success: function(res){
					if(res){
						$('#payment_info').val('');
						$('#pay_mode').modal('toggle');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});
	});
    /* $(".invoicebtn").on('click',function(){
     	/*var id = $(this).attr("data-id");
     	send_invoice_email(id);
     	//$('#billing').modal('toggle');
     	console.log($(this).data('billingaddress'));
     	$("#billing_address").val($(this).data('billingaddress'));
     	$("#billing_name").val($(this).data('billingname'));
     	$("#billing_name2").val($(this).data('billingname2'));
    });*/
   
   
});
function generateInvoice(current){
	$("#order_id").val(current);
 	$("#billing_address").val($('#bill'+current).data('billingaddress'));
 	$("#billing_name").val($('#bill'+current).data('billingname'));
 	$("#billing_email").val($('#bill'+current).data('billingemail'));
 	$("#billing_amount").val($('#bill'+current).data('billingamount'));
 	$("#billing_name2").val($('#bill'+current).data('billingname2'));
 	$("#billing_address2").val($('#bill'+current).data('billingaddress2'));
 	$("#billing_email2").val($('#bill'+current).data('billingemail2'));
 	$("#billing_amount2").val($('#bill'+current).data('billingamount2'));
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
    			rescheduleOrder(orderId,tt,id,dateText);
    		}
    	},
    	onSelectTime: function(t){
    		//currentObj = $('.reschedule_order').attr('id');
    		orderId = $(".reschedule_order").data('orderid');
    		month = t.getMonth() + 1
    	 	datetime = t.getFullYear()+'/'+(month)+ '/'+t.getDate()+' '+t.getHours()+':'+t.getMinutes();
    		r = confirm("Are you sure you want to reschedule order?");
    		if(r){
    			rescheduleOrder(orderId,datetime,id,t);
    		}
    	}
    });
	
}
function rescheduleOrder(orderId,datetime,currentObj,dateObj){
	$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/order/category2db.php';?>",
			data: 'action=reschedule_order&order_id='+orderId+"&service_date="+datetime,
			success: function(res){
				var obj = eval("("+res+")");
				if(obj.result){
					displayDate = moment(datetime).format('MMM Do YYYY h:mm a');
					//console.log(currentObj);	
					//console.log($("#"+currentObj).parent());
					alert("Order rescheduled!")
				}else{
					alert("Failed to rescheduled!")
				}
			},
			error:function(){
				alert("failure");
			}
		});
}
function remarkPopup(orderId){
		$('#orderId').val(orderId);
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/order/category2db.php';?>",
			data: 'action=getRemark&order_id='+orderId,
			success: function(res){
				var obj = eval("("+res+")");
				if(obj.result){
					$('#listRemarks').html(obj.result);
					$('#remarkEntry').val('update');
				}else{
					$('#listRemarks').html('');
					$('#remarkEntry').val('insert');
				}
			},
			error:function(){
				alert("failure");
			}
		});
}

function changePaymentMode(id,value){
	$.ajax({
		type: "POST",
		url: "<?php print SITEPATH.'/order/category2db.php';?>",
		data: 'action=updatePaymentMode&order_id='+id+'&payment_mode='+value,
		success: function(res){
			var obj = eval("("+res+")");
			if(value=="cheque"){
				$("#paymodeorderid").val(id);
				$('#pay_mode').modal('toggle');
			}
			if(obj.result == 'success'){
				alert("Payment mode updated!");
			}else{
				alert("Failed to update!");
			}
		},
		error:function(){
			alert("failure");
		}
	});
}
function changePaymentStatus(id,value){
	$.ajax({
		type: "POST",
		url: "<?php print SITEPATH.'/order/category2db.php';?>",
		data: 'action=updatePaymentStatus&order_id='+id+'&payment_status='+value,
		success: function(res){
			var obj = eval("("+res+")");
			if(obj.result == 'success'){
				if(value == 'part_received'){
					$('#payment_orderid').val(id);
					$('#paymentReceived').modal('toggle');
				}else{
					alert("Payment status updated!")
				}
			}else{
				alert("Failed to update!");
			}
		},
		error:function(){
			alert("failure");
		}
	});
}
	function send_invoice_email(b_details){
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/order/category2db.php';?>",
			data: b_details+"&action=sendInvoiceMail",
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
							$('.jobinfo'+id).html('<div class="checker"><span><input type="checkbox" name="job_info'+id+'" value="job_end" onchange="updateJobInfo('+id+')"></span></div>End<br /><button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="'+id+'" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick="remarkPopup('+id+')">Remark</button>');
							//$('#orderDeployment').modal('show');
							//$('#deployment_orderid').val(id);
						}
						else if(job_info == 'job_end'){
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" style="width:94px !important" class="small m-wrap"><option value="">Please Select</option><option value="success">Success</option><option value="complaint">Complaint</option></select><br /><button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="'+id+'" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick="remarkPopup('+id+')">Remark</button>');
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
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" class="small m-wrap"><option value="">Please Select</option><option value="success" selected="selected">Success</option><option value="complaint">Complaint</option></select>');
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
	function saveOrderFeedback(id){
		//debugger;
		if(id!=''){
			var order_feedback = $('#order_feedback').val();
			if(order_feedback){
				$.ajax({
					type: "POST",
					url: "<?php print SITEPATH.'/order/category2db.php';?>",
					data: 'action=add_order_feedback&order_id='+id+'&order_feedback='+order_feedback,
					success: function(res){
						alert("Feedback Submitted !!!")
					},
					error:function(){
						alert("failure");
					}
				});
			}
		}
	}
	function cancelOrder(id){
		var r = confirm("Are you sure you want to cancel this order?");
		if(r == true){
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: 'action=cancel_order&id='+id,
				success: function(res){
					var obj = eval("("+res+")");
					if(obj.result){
						alert("Order Cancelled!");
					}else{
						alert("Failed to cancel");
					}
				},
				error:function(){
					alert("failure");
				}

			});
		}
	}
	
	function change_deployment(id,deployment_type,current){
		d = $(current).val();
			if(id){
				$.ajax({
					type: "POST",
					url: "<?php print SITEPATH.'/order/category2db.php';?>",
					data: 'action=change_deployment&order_id='+id+'&deployment_type='+deployment_type+'&deployment='+d,
					success: function(res){
						//alert("C!")
					},
					error:function(){
						alert("failure");
					}
				});
			}
		}
    function printWorkOrder(work_order) {  
    	//console.log(work_order);  
    	wo = JSON.parse(work_order);
    	var html = "<div><table>";
    	html += "<tr><td>name: </td><td>"+wo.name+"</td></tr>";
    	html += "<tr><td>Address: </td><td>"+wo.address+"</td></tr>";
    	html += "<tr><td>Landmark: </td><td>"+wo.landmark+"</td></tr>";
    	html += "<tr><td>Location: </td><td>"+wo.location+"</td></tr>";
    	html += "<tr><td>City: </td><td>"+wo.cityname+"</td></tr>";
    	html += "<tr><td>Pincode: </td><td>"+wo.pincode+"</td></tr>";
    	html += "<tr><td>Service: </td><td>"+wo.service+"</td></tr>";
    	html += "<tr><td>Service Date: </td><td>"+moment(wo.service_date).format('MMM Do YYYY h:mm a')+"</td></tr>";
    	html += "<tr><td>Lead Source: </td><td>"+wo.leadsource_name+"</td></tr>";
    	html += "<tr><td>Remark: </td><td>"+wo.remark+"</td></tr>";
    	html += "</table></div>";
       var divToPrint = html;//document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=300,height=400');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint + '</html>');
       popupWin.document.close();
    }
</script>
<!--script src="<?php //print JSFILEPATH;?>/order.js" type="text/javascript"></script-->  