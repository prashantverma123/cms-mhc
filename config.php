<?php
ob_start();
//Here all the files which can be needed are included
include_once('lib/constant.php');
//include_once('login/authchk.php');
include_once(FUNCTIONPATH);
//include_once(IMAGEFUNCTIONPATH);
if(!isset($_SESSION['tmobi']['UserId']) || !isset($_SESSION['tmobi']['AdminName']) || !isset($_SESSION['tmobi']['AdminEmail'])) {
	//$_SESSION['REDIRECT'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$Go = SITEPATH."/index.html/cms/";
	header("Location: $Go");
	exit;
}
?>
