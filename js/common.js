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