<?php
$session = Session::getInstance();
$session->start();
$chkLogin = $session->get('AdminLogin');
$userId = $session->get('UserId');

// echo $modelObj->sendEmail();

?>
<div class="portlet-body">
	<form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<select name="sort"><option value="asc" <?php if($_GET['sort'] == 'acs'): echo 'selected';else: ''; endif; ?>>ASC</option><option value="desc" <?php if($_GET['sort'] == 'desc'): echo 'selected';else: ''; endif; ?>>DESC</option></select>
		<input type="text" name="filter" value="<?php if($_GET['filter'] != ''): echo $_GET['filter']; else: ''; endif; ?>" placeholder="Filter" />
		<!--input type="hidden" name="p" value="<?php //echo $_GET['p']; ?>" /-->
	<button type="submit">Submit</button>
	</form>
	<div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
    	<table class="table table-striped table-bordered table-hover" id="">
		   <thead>
			  <tr>
				 <!--<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes" /></th>-->
				 <th>Client Info</th>
				 <th class="hidden-480">Lead Source</th>
				 <th class="hidden-480">Service</th>
				 <th class="hidden-480">Service Date</th>
				<!--  <th class="hidden-480">Service Time</th> --><!-- 
				 <th class="hidden-480">Contact No</th> -->
				 <!-- <th class="hidden-480">Email Id</th> -->
				 <th class="hidden-480"> Site Address</th>
				 <th class="hidden-480">Billing Amount</th>
				 <th class="hidden-480">Job Updates</th>
				 <th class="hidden-480">Generate Invoice</th>
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
				 <td><?php print ucfirst($key['name']);
				 if($key['mobile_no'] != '') echo '<br />'.$key['mobile_no'];
				 if($key['email_id']) echo '<br />'.$key['email_id'];?></td>
				 <td class="hidden-480"><?php print $key['leadsource_name'];?></td>
				 <td class="hidden-480"><?php print $key['service'];?></td>
				 <td class="hidden-480"><?php print $key['service_date'].'<br />'.$key['service_time']; ?></td>
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
						<span>Success</span>
					<?php else: ?>
					<select class="small m-wrap jobstatus" name="job_status"  id="jobstatus<?php print $key['id'];?>" onchange="saveJobStatus(<?php print $key['id'];?>)">
						<option value="">Please Select</option>
						<option value="success">Success</option>
						<option value="complaint" <?php if($key['job_status'] == 'complaint'): echo "selected"; else: ""; endif; ?>>Complaint</option>
						</select>

					<?php endif; endif; ?>
					<button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="<?php print $key['id'];?>" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick='remarkPopup(<?php print $key['id'];?>)'>Remark</button>


				</td>
				<td class="hidden-480">
					<div type="button" class="btn-info invoicebtn btn-sm" data-id="<?php print $key['id'];?>">Send Invoice</div>
				</td>
				 <td>
				 	<?php if(in_array('edit',$actionArr)): ?>
					<span class="label label-success"><a href="<?php print SITEPATH.'/order/display.php?order_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;
					<?php endif; if(in_array('delete',$actionArr)): ?>
					<span class="label label-warning"><a href="javascript:void(0);" onclick="deleteConfirm('order',<?php print $key['id'];?>,'delete_order','order_id')" class="edit" title="Delete" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>
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
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
    </div>
  </div>
<!----REMARK POPUP ENDS HERE------- -->
<!----DEPLOYMENT POPUP STARTS HERE------- -->
 <div class="modal fade" id="orderDeployment" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
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
  </div>
<!----DEPLOYMENT POPUP ENDS HERE------- -->

<script>
$(document).ready(function () {
	
	(function($) {
	    if (!$.curCSS) {
	       $.curCSS = $.css;
	    }
	})(jQuery);
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


    $('.jobstatus').change(function () {

			var x = 250;
			var y = 250;
			jQuery("#dialog-modal").dialog('option', 'position', [x,y]);
            $('#dialog-modal').dialog('open');
    });

    $('#addDeployment').click(function(){
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
     $(".invoicebtn").on('click',function(){
     	var id = $(this).attr("data-id");
     	send_invoice_email(id);
        alert(id);
    });

});

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
	function send_invoice_email(id){
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/order/category2db.php';?>",
			data: 'action=sendInvoiceMail&order_id='+id,
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
							$('.jobinfo'+id).html('<div class="checker"><span><input type="checkbox" name="job_info'+id+'" value="job_end" onchange="updateJobInfo('+id+')"></span></div>End<button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="'+id+'" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick="remarkPopup('+id+')">Remark</button>');
							$('#orderDeployment').modal('show');
							$('#deployment_orderid').val(id);
						}
						else if(job_info == 'job_end'){
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" class="small m-wrap"><option value="">Please Select</option><option value="success">Success</option><option value="complaint">Complaint</option></select><button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="'+id+'" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick="remarkPopup('+id+')">Remark</button>');
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
	function saveOrderFeedback(id){
		debugger;
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
</script>
