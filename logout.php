<?php
include_once('lib/constant.php');
unset($_SESSION['tmobi']);

$Go = SITEPATH."/index.html";
header("location:$Go");
?>