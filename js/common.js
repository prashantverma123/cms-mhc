var HOST_IP_ADDRESS = window.location.host;
var CMSROOTPATH = "http://"+HOST_IP_ADDRESS+'/cms/';

function ajaxFileUpload(fieldId, callbackF, moduleName)
{ 
	$.ajaxFileUpload({
		url:CMSROOTPATH+'lib/doajaxfileupload.php',
		secureuri:false,
		fileElementId:fieldId,
		dataType: 'json',
		data:{name:fieldId,moduleName:moduleName},
		success: function (data, status) {  
		  	if(moduleName != ''){
				moduleName = moduleName+'/';
			}
			if(typeof(data.status) != 'undefined') {
				if(data.status == 'error') {
					alert(data.msg);
				} else {
				    var fieldId = data.fieldId;
					var newFileName = data.final_name;
					var orgFileName = data.original_name;
					$("#hid_full_"+fieldId).val(moduleName+newFileName);
					var imgPath = '<img src="'+CMSROOTPATH+'uploads/'+moduleName+newFileName+'" border="0" style="cursor: pointer;vertical-align:middle;padding-left:15px;">';
					$("#status_"+fieldId).html(imgPath);
			   
				}
			} else {
				alert('Problem uploading file. Please contact Administrator.');
			}
		
			$("#loading_"+fieldId).hide();
		},
		error: function (data, status, e) {
			alert(e);
			$("#loading_"+fieldId).hide();
		}
	});
	return false;
}

function deleteConfirm(module,d_id,action,id_var){
	var r = confirm("Do you really want to delete this record?");
	if(r == true){
		$.ajax({
			type: "POST",
			url: CMSROOTPATH+"/"+module+"/category2db.php",
			data: 'action='+action+'&'+id_var+'='+d_id,
			success: function(res){
				$('#row_id_'+d_id).hide('slow');
			},
			error:function(){
				alert("failure");
			}

		});
	}
}