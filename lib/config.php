<?php
error_reporting(E_ALL ^ E_NOTICE);

//-- constants -------------
//--- application environment--
//define('APPLICATION_ENV', 'production');
define('APPLICATION_ENV', 'dev');
//define('APPLICATION_ENV', 'development');

//-- title --
define('APP_TITLE', 'Events');
define('APP_TITLE_SEPARATION', 'Events :: occasion Management');
//------------------------------------------------------------------------------
if (APPLICATION_ENV == 'production') {
    define('DOMAIN_HOST_IP', 'sponsor.indiatimes.co.in');
    define('SITEPATH', "http://" . DOMAIN_HOST_IP . "/cms/");
    define('DOCUMENTROOT', $_SERVER['DOCUMENT_ROOT'] . "/");    
} elseif (APPLICATION_ENV == 'staging') {
    //define('DOMAIN_HOST_IP', '223.165.31.104');
    define('DOMAIN_HOST_IP', 'staging.sponsor.indiatimes.co.in');
    define('SITEPATH', "http://" . DOMAIN_HOST_IP . "/cms/");
    define('DOCUMENTROOT', $_SERVER['DOCUMENT_ROOT'] . "/");
} else {
    
    /// ---- change here if requried ------------
    
    define('DOMAIN_HOST_IP', 'http://tminus.mobi/gateway/');
    define('SITEPATH', "http://" . DOMAIN_HOST_IP . "/gateway");
    define('DOCUMENTROOT', $_SERVER['DOCUMENT_ROOT'] . "/gateway");    
}

//define('PATH_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('UPLOAD_DIR', DOCUMENTROOT.'/uploads'); /// ---- change folder name if requried.


define('JSFILEPATH', SITEPATH . '/js');
define('CSSFILEPATH', SITEPATH . '/css');
define('IMAGEPATH', SITEPATH . '/images');
//echo APPLICATION_ENV;
//-- database credentials--
      /* 
	define('DB_HOST', '69.163.142.164');
	define('DB_USER', 'letsd0');
	define('DB_PASS', 'let5d0');
	define('DB_DB', 'p911');	
      */
	define('DB_HOST', '180.179.213.92');
	define('DB_USER', 'tmobi');
	define('DB_PASS', '3v3nt5n0w');
	define('DB_DB', 'tmobi');	


include_once(DOCUMENTROOT . '/lib/Util.class.php');
include_once(DOCUMENTROOT . '/lib/session.php');
include_once(DOCUMENTROOT . '/lib/class.Database.php');
//include_once(DOCUMENTROOT . '/lib/class.Base.php');
//include_once(DOCUMENTROOT . '/lib/class.GetData.php');

////--- get settings ----
//$setting_obj = new GetData();
//$arr_setting = $setting_obj->getSettings();

//define('FROMMAIL', trim($arr_setting['from_email']));
//define('TOHR', trim($arr_setting['hr_email']));
//define('ASPIRE_HR', trim($arr_setting['aspire_hr_email']));
//define('REMINDER_DAYS', trim($arr_setting['reminder_interval']));
//
