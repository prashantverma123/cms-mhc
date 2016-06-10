<?php
include_once('../config.php');
include_once('variable.php');
require_once 'payu.php';

$m = isset($_GET['m'])?$_GET['m']:"";
$l = $_GET['l']?$_GET['l']:"";
$row = $modelObj->get_order_details($m,$l); 
function payment_success() {
	$m = isset($_GET['m'])?$_GET['m']:"";
	$l = $_GET['l']?$_GET['l']:"";
	/* Payment success logic goes here. */
	//header('Location: '.SITEPATH.'/payment/response.php?m='.$m.'&l='.$l.'&r=s');
	//echo "Congratulations !! The Payment is successful.";
}

function payment_failure() {
	$m = isset($_GET['m'])?$_GET['m']:"";
$l = $_GET['l']?$_GET['l']:"";
	/* Payment failure logic goes here. */
	//header('Location: '.SITEPATH.'/payment/response.php?m='.$m.'&l='.$l.'&r=f');
	//echo "We are sorry. The Payment has failed";
}



/* Payments made easy. */

if ( count( $_POST ) ){ 
	pay_page( array ('key' => $_POST['key'], 'txnid' => $_POST['txnid'], 'amount' => $_POST['amount'],'firstname' => $_POST['firstname'], 'email' => $_POST['email'], 'phone' => $_POST['phone'],'productinfo' => $_POST['productinfo'], 'surl' => SITEPATH.'/payment/response.php?m='.$m.'&l='.$l.'&r=s', 'furl' => SITEPATH.'/payment/response.php?m='.$m.'&l='.$l.'&r=f','udf1'=>$m,'udf2'=>$l), 
			SALT );



/* Merchant Page. ( All the html code ) */

}elseif($row[0]['payment_status'] == 'success') {
	echo "<h1>Payment url has been expired!</h1>";
}else{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>MHC- Payments</title>
	</head>
	
	<body>
		<h2> Mister Homecare Services Private Limited </h2> <hr />
		<form method='POST'>
			<table border='0'>
				<input name='key' type='hidden' value="<?php echo KEY; ?>"> 
				<input name='txnid' type='hidden' value='<?php echo isset($row[0]["order_id"])?$row[0]["order_id"]:"";?>'> 
				<tr> <td> Amount : </td> <td> <input name='amount' type='text' value='<?php echo isset($row[0]["taxed_cost"])?$row[0]["taxed_cost"]:"";?>' readonly >
				 </td>
				<tr> <td> Firstname : </td> <td> <input name='firstname' type='text' value='<?php echo isset($row[0]["client_firstname"])?$row[0]["client_firstname"]:"";?>'> </td>
				<tr> <td> Lastname : </td> <td> <input name='lastname' type='text' value='<?php echo isset($row[0]["client_lastname"])?$row[0]["client_lastname"]:"";?>'> </td>
				<tr> <td> City : </td> <td> <input name='city' type='text' value='<?php echo isset($row[0]["cityname"])?$row[0]["cityname"]:"";?>'> </td>
				<tr> <td> Zipcode : </td> <td> <input name='zipcode' type='text' value='<?php echo isset($row[0]["pincode"])?$row[0]["pincode"]:"";?>'> </td>
				<tr> <td> Email : </td> <td> <input name='email' type='text' value='<?php echo isset($row[0]["client_email_id"])?$row[0]["client_email_id"]:"";?>'> </td>
				<tr> <td> Phone : </td> <td> <input name='phone' type='text' value='<?php echo isset($row[0]["client_mobile_no"])?$row[0]["client_mobile_no"]:"";?>'> </td>
				<tr> <td> Product Info : </td> <td> <input name='productinfo' type='text' value='<?php echo isset($row[0]["service1"])?$row[0]["service1"]:""." ".isset($row[0]["service2"])?$row[0]["service2"]:""." ".isset($row[0]["service3"])?$row[0]["service3"]:"";?>'> </td>
			</table>
			
			<input type="submit" value="Submit">
		</form>
	</body>
</html>

<?php }

/* And we are done. */
