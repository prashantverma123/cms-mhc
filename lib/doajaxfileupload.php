<?php
include_once('constant.php');
$msg = '';
$status = '';
$orgFileName = '';
$newFileName = '';
$moduleName = strtolower($_POST['moduleName']);
if($moduleName != ''){
	$uploaddir = UPLOAD_DIR.'/'.$moduleName;
}else{
	$uploaddir = UPLOAD_DIR;
}
$fileElementName = $_POST['name'];
$msgArr = Util::uploadFile($fileElementName,$uploaddir);
echo json_encode($msgArr);
?>