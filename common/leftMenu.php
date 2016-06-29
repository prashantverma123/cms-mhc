<div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <?php $modules = getModuleByRole($_SESSION['tmobi']['role']); 
    $actions = getActionByRoleAndModule($_SESSION['tmobi']['role'],$modelObj -> className);  
    $actionArr = explode(',', $actions);?>
    <ul>
		<li>
			<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
			<div class="sidebar-toggler hidden-phone"></div>
			<!-- BEGIN SIDEBAR TOGG	LER BUTTON -->
		</li>
		<li>
			<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
			<form class="sidebar-search">
			</form>
			<!-- END RESPONSIVE QUICK SEARCH FORM -->
		</li>
    <li class="active">
      <?php if($_SESSION['tmobi']['role'] == 'admin'): ?>
      <a href="javascript:;">
        <i class="icon-table"></i>
        <span class="title"><?php echo ucfirst("admin"); ?></span>
        <span class="selected"></span>
        <span class="arrow open"></span>
      </a>
    <?php endif; ?>
      <ul class="sub-menu">
		<?php foreach ($modules as $module): ?>
      <?php if ($module["module"]!="leadmanager" && $module["module"]!="order"):?>
				<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
					<a href="<?php print SITEPATH.'/'.$module["module"].'/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/><?php echo ucfirst($module['module']); ?></a>
				</li>
				<!-- <li class="<?php //if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >
					<a href="<?php //print SITEPATH.'/'.$module["module"].'/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New <?php echo ucfirst($module['module']); ?> </a>
				</li> -->
          <?php endif; ?>
		<?php endforeach; ?>
    </ul>
    	</li>
      <li class="active">
        <a href="javascript:;">
          <i class="icon-table"></i>
          <span class="title"><?php echo ucfirst("leadmanager"); ?></span>
          <span class="selected"></span>
          <span class="arrow open"></span>
        </a>
        <ul class="sub-menu">
          <li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
  					<a href="<?php print SITEPATH.'/'."leadmanager".'/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/><?php echo ucfirst("leadmanager"); ?></a>
  				</li>
        </ul>
          </li>
          <li class="active">
            <a href="javascript:;">
              <i class="icon-table"></i>
              <span class="title"><?php echo ucfirst("orders"); ?></span>
              <span class="selected"></span>
              <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
              <li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
                <a href="<?php print SITEPATH.'/'."order".'/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/><?php echo ucfirst("orders"); ?></a>
              </li>
            </ul>
              </li>
	</ul>
</div>
