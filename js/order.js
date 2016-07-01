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
    $("#addBillDetails").click(function(){
    	$('#frmBilling').validate({
		rules:{
			billing_name:"required",
			billing_name2:"required",
			billing_address: "required"
		},
		submitHandler: function() {
			data = $('#frmBilling').serialize();
			$.ajax({
				type: "POST",
				url: "<?php print SITEPATH.'/order/category2db.php';?>",
				data: data,
				success: function(res){
					if(res){
						var obj = eval("("+res+")");
						v = $('#frmBilling').serializeArray();
						//console.log(v[0].value);return;
						send_invoice_email(obj.result,v[1].value,v[0].value,v[2].value);
						$('#order_id').val('');
					}
				},
				error:function(){
					alert("failure");
				}
			});
		}
		});
    })
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
 	$("#billing_name2").val($('#bill'+current).data('billingname2'));
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
				alert("Payment status updated!");
			}else{
				alert("Failed to update!");
			}
		},
		error:function(){
			alert("failure");
		}
	});
}
	function send_invoice_email(id,b_add,b_name,b_name2){
		$.ajax({
			type: "POST",
			url: "<?php print SITEPATH.'/order/category2db.php';?>",
			data: 'action=sendInvoiceMail&order_id='+id+"&b_add="+b_add+"&b_name="+b_name+"&b_name2="+b_name2,
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
							$('#orderDeployment').modal('show');
							$('#deployment_orderid').val(id);
						}
						else if(job_info == 'job_end'){
							$('.jobinfo'+id).html('<select onchange="saveJobStatus('+id+')" id="jobstatus'+id+'" name="job_status" class="small m-wrap"><option value="">Please Select</option><option value="success">Success</option><option value="complaint">Complaint</option></select><br /><button type="button" class="btn-success btn-sm" data-toggle="modal" data-orderid="'+id+'" data-target="#remark" style="padding:4px 4px!important;margin-top:10px;" onclick="remarkPopup('+id+')">Remark</button>');
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

