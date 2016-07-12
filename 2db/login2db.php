<?php
ob_start();
//Here all the files which can be needed are included
include_once('../lib/constant.php');
include_once('../lib/mail_functions.php');
//include_once('login/authchk.php');

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

include_once(FUNCTIONPATH);
$db = Database::Instance();
$action = $_POST['action'];
switch($action) {
	case 'login':
			$email = addslashes($_POST['username']);
			$passWord = addslashes(md5($_POST['password']));
			$keyValueArray['sqlclause'] = " email = '$email' OR username='$email' AND password ='$passWord' AND status=1 ";
			$dataArr = $db->getDataFromTable($keyValueArray, 'cmsuser', " * ", " name asc",'',false);
			//echo "<script type='text/javascript'>alert('$dataArr');</script>";

			if(count($dataArr) > 0){
				foreach($dataArr as $key){
					$dbary[]= $key['name'];
					  $_SESSION['tmobi'] = array();
					  $_SESSION['tmobi']['AdminLogin'] 	= '1';
					  $_SESSION['tmobi']['AdminName'] 	= $key['name'];
					  $_SESSION['tmobi']['AdminEmail'] 	= $key['email'];
					  $_SESSION['tmobi']['UserId'] 		= $key['id'];
						$_SESSION['tmobi']['role'] 		= $key['role'];
						//$_SESSION['tmobi']['city'] 		= $key['role']=="admin"?'':$key['city'];
						$_SESSION['tmobi']['city'] 		= $key['city'];
						$user_city = $key['city'];
					  //echo json_encode($_SESSION);
							echo '1';
				}
			}else {
				//$msg = "Either email or password does not match";
				echo '2';
			}
	break;
	case 'resetpassword':
			//$db = Database:: getConnection();
			$email = addslashes($_POST['email']);
			$keyValueArray['sqlclause'] = " email = '$email' AND status=1 ";
			$dataArr = $db->getDataFromTable($keyValueArray, 'cmsuser', " * ", "",'',false);
			if(count($dataArr) > 0){
				$name = $dataArr[0]['name'];
						//write  mail function.
						$userid		= encryptdata($dataArr[0]['id']);
						$username  	= $dataArr[0]['username'];
						$name  		= $dataArr[0]['name'];
						$email		= $dataArr[0]['email'];
						$subject	= 'Tminus: Password Reset';
						$Lurl  		= DOMAIN_HOST_IP.'/reset-password.php?auth='.$userid;
						$body = 'Greetings '.$name.',<br/>

								Your account details are as follows:-<br><br>

								Username: ' . $username. '<br>

								To reset your account password, please click on the below link:
								<br>
								<br>
								<a href="' . $Lurl . '">' . $Lurl . '</a>
								<br>

								<br>
								Regards,
								<br>
								Team  Tminus.
								<br><br>
								';
						//forgetPasswordMail($userid, $res[0]['email'], $name, $username);
						$fromEmail = MAILFROM;
						sendHTMLMail($email, $subject, $body, $fromEmail);
				echo '1';
			}
		   /* $chkLogin = "SELECT * FROM cmsuser WHERE email = '$email' AND status=1";
			$db->query($chkLogin, 1);
			if ($db->getRowCount()) {
				$row = $db->fetch();
				$name = $row['name'];
				//write  mail function.
				echo '1';
			} */
			else {
				//$msg = "Either email or password does not match";
				echo '2';
			}
	break;

	case 'newuser':
			//$db = Database:: getConnection();
			//echo '<pre>'; print_r($_POST);
			$username = addslashes($_POST['username']);
			$email 	  = addslashes($_POST['email']);
			$passWord = addslashes(md5($_POST['password']));
			$keyValueArray['sqlclause'] = " email = '".$email."' AND password ='".$passWord."' AND status=1 ";
			$dataArr = $db->getDataFromTable($keyValueArray, 'cmsuser', " * ", "",'',false);
			if(count($dataArr) > 0){
				echo '0';
			}else{
				$arrInsert['name']= $username;
				$arrInsert['username']= $username;
				$arrInsert['email']= $email;
				$arrInsert['password']= $passWord;
				$arrInsert['status']= '1';
				$ret = $db->insertDataIntoTable($arrInsert, 'cmsuser');
				if($ret > 0){
					echo '1';
				}else{
					echo '2';
				}
			}
	break;
}

?>
