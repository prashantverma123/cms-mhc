<?php
$session = Session::getInstance();
$session->start();
//print_r($_SESSION);
$chkLogin = $session->get('AdminLogin');
$userId   = $session->get('UserId');
$userName = $session->get('AdminName');
?>
<div class="header navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
         <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="<?php print SITEPATH;?>/index.html" style="font-size:12px;font-weight:bold;width:500px;">
				CMS-<i>dashboard</i>
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
            <img src="<?php print IMAGEPATH;?>/menu-toggler.png" alt="" />
            </a>          
            <!-- END RESPONSIVE MENU TOGGLER -->            
            <!-- BEGIN TOP NAVIGATION MENU -->              
            <ul class="nav pull-right">
           
               <!-- END TODO DROPDOWN -->
               <!-- BEGIN USER LOGIN DROPDOWN -->
               <li class="dropdown user">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!--<img alt="" src="<?php print IMAGEPATH;?>/avatar2_small.jpg" />-->
                  <span class="username">Hi, <?php print $userName;?></span>
                  <i class="icon-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu">                  
                     <li><a href="#formPopup" data-toggle="modal"><i class="icon-user"></i> My Profile</a></li>
                     <li><a href="inbox.html"><i class="icon-envelope"></i> My Inbox(3)</a></li>
                     <li class="divider"></li>
                     <li><a href="<?php print SITEPATH?>/logout.php"><i class="icon-key"></i> Log Out</a></li>
                  </ul>
               </li>
               <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU --> 
         </div>
      </div>
      <!-- END TOP NAVIGATION BAR -->
   </div>