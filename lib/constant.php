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
$dbdetails = array(
		'tmobi'	=> array(
		'host'		=> 'localhost',
		'database'  => 'sample_db',
		'user'		=> 'root',
		'password'  => '')
);
include_once(DOCUMENTROOT . '/lib/Util.class.php');
include_once(DOCUMENTROOT . '/lib/session.php');
define('FUNCTIONPATH',DOCUMENTROOT."/lib/functions.php");
?>
