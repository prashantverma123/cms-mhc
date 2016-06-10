<?php 
include_once('../config.php');
include_once('variable.php');
if($_GET['m']!='' && $_GET['l'] != ''){
	$m = isset($_GET['m'])?$_GET['m']:"";
	$l = $_GET['l']?$_GET['l']:"";
	$orderId = decryptdata($m);
	$leadmanagerId = decryptdata($l);
	$row = $modelObj->get_order_details($orderId,$leadmanagerId); 
	if(count($row) > 0 && $row[0]['payment_status'] == 'success'):
		echo "<h1>Congratulations !! The Payment is successful</h1>";
	else:
		echo "<h1>Sorry! Transaction Failed</h1>";
	endif;
}else{
	echo "<h1>Invalid URL</h1>";
}

?>