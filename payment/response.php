<?php 
include_once('../lib/constant.php');
include_once(FUNCTIONPATH);
include_once('variable.php');
if($_GET['m']!='' && $_GET['l'] != ''){
	$m = isset($_GET['m'])?urldecode($_GET['m']):"";
	$l = isset($_GET['l'])?urldecode($_GET['l']):"";
	//$orderId = decryptdata($m);
	//$leadmanagerId = decryptdata($l);
	$row = $modelObj->get_order_details($m,$l); 
	//print_r($row);
	if(count($row) > 0 && $row[0]['payment_status'] == 'success' && $_GET['r'] == 's'):
		echo "<h1>Congratulations !! The Payment is successful</h1>";
	else:
		echo "<h1>Sorry! Transaction Failed</h1>";
	endif;
}else{
	echo "<h1>Invalid URL</h1>";
}

?>