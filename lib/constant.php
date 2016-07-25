<?php
ob_start();
session_start();
error_reporting(E_ALL ^ E_NOTICE);
define('APPLICATION_ENV', 'dev');
define('APP_TITLE', 'Events');
define('APP_TITLE_SEPARATION', 'CMS Management');
define('DOMAIN_HOST_IP', 'http://localhost/cms');
define('SITEPATH',  DOMAIN_HOST_IP );
define('DOCUMENTROOT', $_SERVER['DOCUMENT_ROOT'] . "/cms");
define('UPLOAD_DIR', DOCUMENTROOT.'/uploads');
define('JSFILEPATH', SITEPATH . '/js');
define('CSSFILEPATH', SITEPATH . '/css');
define('IMAGEPATH', SITEPATH . '/img');
define('COMMONFILEPATH', DOCUMENTROOT . '/common');
define('SALTKEY','TMINUS_EVE_IDS');
define('PER_PAGE_ROWS',10); //(pagination) to show number of rows on a page
date_default_timezone_set('Asia/Kolkata');

/*********************Payment Gateway starts********************************/
define('INVOICE_FROM_EMAILID','trushali.webwerks@gmail.com');
define('SALT','nD57O4Xr');
define('KEY','ZowGmp');
/*********************Payment Gateway ends********************************/

$user_city = "";

$dbdetails = array(
		'tmobi'	=> array(
		'host'		=> 'localhost',
		'database'  => 'sample_db',
		'user'		=> 'root',
		'password'  => '')
);
$states  = array (
 ''=>'Please Select',
 'AP' => 'Andhra Pradesh',
 'AR' => 'Arunachal Pradesh',
 'AS' => 'Assam',
 'BR' => 'Bihar',
 'CT' => 'Chhattisgarh',
 'GA' => 'Goa',
 'GJ' => 'Gujarat',
 'HR' => 'Haryana',
 'HP' => 'Himachal Pradesh',
 'JK' => 'Jammu & Kashmir',
 'JH' => 'Jharkhand',
 'KA' => 'Karnataka',
 'KL' => 'Kerala',
 'MP' => 'Madhya Pradesh',
 'MH' => 'Maharashtra',
 'MN' => 'Manipur',
 'ML' => 'Meghalaya',
 'MZ' => 'Mizoram',
 'NL' => 'Nagaland',
 'OR' => 'Odisha',
 'PB' => 'Punjab',
 'RJ' => 'Rajasthan',
 'SK' => 'Sikkim',
 'TN' => 'Tamil Nadu',
 'TR' => 'Tripura',
 'UK' => 'Uttarakhand',
 'UP' => 'Uttar Pradesh',
 'WB' => 'West Bengal',
 'AN' => 'Andaman & Nicobar',
 'CH' => 'Chandigarh',
 'DN' => 'Dadra and Nagar Haveli',
 'DD' => 'Daman & Diu',
 'DL' => 'Delhi',
 'LD' => 'Lakshadweep',
 'PY' => 'Puducherry',
);
$memcache = new Memcache;
@$memcacheConn = $memcache->connect('localhost', 11211);

include_once(DOCUMENTROOT . '/lib/Util.class.php');
include_once(DOCUMENTROOT . '/lib/session.php');
define('FUNCTIONPATH',DOCUMENTROOT."/lib/functions.php");
?>
