<?php
ob_start();
include_once('../lib/constant.php');
include_once(FUNCTIONPATH);
//include_once('../config.php');
include_once('variable.php');
require_once 'payu.php';
//echo "hello";exit();
$m = isset($_GET['m'])?$_GET['m']:"";
$l = $_GET['l']?$_GET['l']:"";
if($memcache){
$cities = $memcache->get('city');
$mhcclient = $memcache->get('mhcclient');
$pricelist = $memcache->get('pricelist_dropdown');
}else{
  $cities = $dashboardObj->city();
  $mhcclient = $dashboardObj->mhcclient();
  $pricelist = $dashboardObj->pricelist();
}
$row = $modelObj->get_order_details($m,$l);
$client = $mhcclient[$row[0]['mhcclient_id']];
/* Payments made easy. */
if ( count( $_POST ) ){ 
  pay_page( array ('key' => $_POST['key'], 'txnid' => $_POST['txnid'], 'amount' => $_POST['amount'],'firstname' => $_POST['firstname'], 'email' => $_POST['email'], 'phone' => $_POST['phone'],'productinfo' => $_POST['productinfo'], 'surl' => SITEPATH.'/payment/response.php?m='.urlencode($m).'&l='.urlencode($l).'&r=s', 'furl' => SITEPATH.'/payment/response.php?m='.urlencode($m).'&l='.urlencode($l).'&r=f','udf1'=>decryptdata($m),'udf2'=>decryptdata($l)), 
      SALT );
}
elseif($row[0]['payment_status'] == 'success') {
	echo "<h1>Payment url has been expired!</h1>";
}else{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>MHC- Payments</title>
		<style media="screen">
form {
display: block;
margin: 30px;
overflow: hidden;
background: #fff;
border: 1px solid #e4e4e4;
border-radius: 5px;
font-size: 0;
}

form > div > label {
display: block;
padding: 20px 20px 10px;
vertical-align: top;
font-size: 13px;
font-weight: bold;
text-transform: uppercase;
color: #939393;
cursor: pointer;
}
form > div.switch > label {
padding: 16px 20px 13px;
}

.col-2, .col-3, .col-4 {
border-bottom: 1px solid #e4e4e4;
}

form > div > .col-4 {
height: 86px;
}

label > input {
display: inline-block;
position: relative;
width: 100%;
height: 27px;
line-height: 27px;
margin: 5px -5px 0;
padding: 7px 5px 3px;
border: none;
outline: none;
color: #555;
font-family: 'Helvetica Neue', Arial, sans-serif;
font-weight: bold;
font-size: 14px;
opacity: .6;
transition: all linear .3s;
}

.col-submit {
text-align: center;
padding: 20px;
}

label > select {
display: block;
width: 100%;
padding: 0;
color: #555;
margin: 16px 0 6px;
font-weight: 500;
background: transparent;
border: none;
outline: none;
font-family: 'Helvetica Neue', Arial, sans-serif;
font-size: 14px;
opacity: .4;
transition: all linear .3s;
}

label > input:focus, label > select:focus {
opacity: 1;
}

@media(min-width: 850px){
  form > div { display: inline-block; }
  .col-submit { display: block; }

  .col-2, .col-3, .col-4 { box-shadow: 1px 1px #e4e4e4; border: none; }

  .col-2 { width: 50% }
  .col-3 { width: 33.3333333333% }
  .col-4 { width: 25% }

  .col-submit button { width: 30%; margin: 0 auto; }
}
.error{color:red;}
</style>
<script src="<?php print JSFILEPATH;?>/jquery-1.8.3.min.js" type="text/javascript"></script>  
<script type="text/javascript" src="<?php print JSFILEPATH;?>/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('#frmMrHomeCarePayment').validate({
    rules:{
      firstname:"required",
      lastname:"required",
      city:"required",
      phone:{
        required:true,
        number:true
      },
      productinfo:"required",
      email:{
        required:true,
        email:true
      },
      zipcode:{
        required:true,
        number:true
      }
    },
    submitHandler: function() {
      $("#frmMrHomeCarePayment").submit();
      return false;
     } 
});
})
</script>
	</head>
	
	<body style="background-color: rgb(226, 238, 244);">
		<div class="topbar" style="background:#ededed">
  <a href="https://www.mrhomecare.in" rel="home" title="Mr.Homecare - Home"><img src="https://www.mrhomecare.in/wp-content/themes/mrhomecare/mhc-lib/img/logo.png" alt="logo"></a>
</div>
<div class="formwrapper" style="">
	<div style="text-align:center"><h3> Payment Form</h3></div>
<div class="formcontainer">
  <form method='POST' id="frmMrHomeCarePayment" name="frmMrHomeCarePayment">
    <input name='key' type='hidden' value="<?php echo KEY; ?>"> 
        <input name='txnid' type='hidden' value='<?php echo isset($row[0]["order_id"])?$row[0]["order_id"]:"";?>'> 
  	  <div class="col-2">
    <label>
      Firstname
      <input name='firstname' id="firstname" type='text' value='<?php echo isset($client["client_firstname"])?$client["client_firstname"]:"";?>' tabindex="1">
    </label>
  </div>
    <div class="col-2">
    <label>
      Lastname
      <input name='lastname' id="lastname" type='text' value='<?php echo isset($client["client_lastname"])?$client["client_lastname"]:"";?>' tabindex="2">
    </label>
  </div>


  
  <div class="col-3">
    <label>
      Email
      <input name='email' id="email" type='text' value='<?php echo isset($client["client_email_id"])?$client["client_email_id"]:"";?>' tabindex="3">
    </label>
  </div>
  <div class="col-3">
    <label>
      Phone
      <input name='phone' id="phone" type='text' value='<?php echo isset($client["client_mobile_no"])?$client["client_mobile_no"]:"";?>' tabindex="4">
    </label>
  </div>

  <div class="col-3">
    <label>
      City
      <input name='city' id="city" type='text' value='<?php echo isset($cities[$client["city"]])?$cities[$client["city"]]:"";?>' tabindex="5">
    </label>
  </div>
  <div class="col-3">
    <label>
      Pincode
      <input name='zipcode' id="zipdoc" type='text' value='<?php echo isset($client["pincode"])?$client["pincode"]:"";?>' tabindex="6">
    </label>
  </div>
  <div class="col-3">
    <label>
      Product Info
      <input name='productinfo' id="productinfo" type='text' value='<?php echo isset($pricelist[$row[0]["service_inquiry1"]])?$pricelist[$row[0]["service_inquiry1"]]:""; echo " ";  echo isset($pricelist[$row[0]["service_inquiry2"]])?$pricelist[$row[0]["service_inquiry2"]]:""; echo " ";  echo isset($pricelist[$row[0]["service_inquiry3"]])?$pricelist[$row[0]["service_inquiry3"]]:""; ?>' tabindex="7">
    </label>
  </div>
  <div class="col-3">
  	<label>
      Amount
      <input name='amount' type='text' value='<?php echo isset($row[0]["taxed_cost"])?$row[0]["taxed_cost"]:"";?>' readonly tabindex="8">
    </label>
    
  </div>
  


  <div class="col-submit">
    <input type="submit" value="Submit">
  </div>
  </form>

</div>
</div>

	</body>
</html>

<?php }

/* And we are done. */
