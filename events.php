<?php
include_once('lib/config.php');
$session = Session::getInstance();
$session->start();
echo'<pre>';
print_r($_SESSION);
?>