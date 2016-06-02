<div class="page-sidebar nav-collapse collapse">
         <!-- BEGIN SIDEBAR MENU -->

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
				<?php switch($_SESSION['tmobi']['role']){
				 case 'admin': ?>
        		<li class="active">
        			<a href="javascript:;">
					<i class="icon-table"></i>
					<span class="title">Category</span>

										<span class="selected"></span>

										<span class="arrow open"></span>
										</a>

						<ul class="sub-menu">
							<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
								<a href="<?php print SITEPATH.'/category/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Category</a>
							</li>
							<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

									<a href="<?php print SITEPATH.'/category/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Category </a>
							</li>
						</ul>
					</li>

          <li class="active">
            <a href="javascript:;">
        <i class="icon-table"></i>
        <span class="title">CMS User</span>

                  <span class="selected"></span>

                  <span class="arrow open"></span>
                  </a>

          <ul class="sub-menu">
            <li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
              <a href="<?php print SITEPATH.'/cmsUser/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Users</a>
            </li>
            <li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

                <a href="<?php print SITEPATH.'/cmsUser/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New CMS User </a>
            </li>
          </ul>
        </li>

					<li class="active ">
						<a href="javascript:;">
				<i class="icon-table"></i>
				<span class="title">City</span>

									<span class="selected"></span>

									<span class="arrow open"></span>
									</a>

					<ul class="sub-menu">
						<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
							<a href="<?php print SITEPATH.'/cityMaster/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Cities</a>
						</li>
						<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

								<a href="<?php print SITEPATH.'/cityMaster/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New City </a>
						</li>
					</ul>
				</li>

				<li class="active ">
					<a href="javascript:;">
			<i class="icon-table"></i>
			<span class="title">Lead Source</span>

								<span class="selected"></span>

								<span class="arrow open"></span>
								</a>

				<ul class="sub-menu">
					<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
						<a href="<?php print SITEPATH.'/leadSource/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Source</a>
					</li>
					<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

							<a href="<?php print SITEPATH.'/leadSource/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Source </a>
					</li>
				</ul>
			</li>
			<li class="active ">
				<a href="javascript:;">
		<i class="icon-table"></i>
		<span class="title">Lead Stage</span>

							<span class="selected"></span>

							<span class="arrow open"></span>
							</a>

			<ul class="sub-menu">
				<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
					<a href="<?php print SITEPATH.'/leadStage/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Lead Stage</a>
				</li>
				<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

						<a href="<?php print SITEPATH.'/leadStage/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Lead Stage </a>
				</li>
			</ul>
		</li>
		<li class="active ">
				<a href="javascript:;">
		<i class="icon-table"></i>
		<span class="title">Lead Manager</span>

							<span class="selected"></span>

							<span class="arrow open"></span>
							</a>

			<ul class="sub-menu">
				<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
					<a href="<?php print SITEPATH.'/leadManager/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Lead Manager</a>
				</li>
				<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

						<a href="<?php print SITEPATH.'/leadManager/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Lead Manager </a>
				</li>
			</ul>
		</li>
		<li class="active ">
			<a href="javascript:;">
	<i class="icon-table"></i>
	<span class="title">Product</span>

						<span class="selected"></span>

						<span class="arrow open"></span>
						</a>

		<ul class="sub-menu">
			<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
				<a href="<?php print SITEPATH.'/product/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Product</a>
			</li>
			<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

					<a href="<?php print SITEPATH.'/product/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Product </a>
			</li>
		</ul>
	</li>
	<li class="active ">
		<a href="javascript:;">
<i class="icon-table"></i>
	<span class="title">Employee</span>

						<span class="selected"></span>

						<span class="arrow open"></span>
						</a>

		<ul class="sub-menu">
			<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
				<a href="<?php print SITEPATH.'/employee/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Employee</a>
			</li>
			<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

					<a href="<?php print SITEPATH.'/employee/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Employee </a>
			</li>

		</ul>
	</li>
	<li class="active ">
		<a href="javascript:;">
<i class="icon-table"></i>
<span class="title">Order</span>

					<span class="selected"></span>

					<span class="arrow open"></span>
					</a>

	<ul class="sub-menu">
		<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
			<a href="<?php print SITEPATH.'/order/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Orders</a>
		</li>
		<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

				<a href="<?php print SITEPATH.'/order/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Place Order </a>
		</li>
	</ul>
</li>
<li class="active ">
	<a href="javascript:;">
<i class="icon-table"></i>
<span class="title">Price List</span>

				<!-- <span class="selected"></span> -->

				<span class="arrow open"></span>
				</a>

<ul class="sub-menu">
	<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
		<a href="<?php print SITEPATH.'/pricelist/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Price List</a>
	</li>
	<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

			<a href="<?php print SITEPATH.'/priceist/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Edit Price List </a>
	</li>
</ul>
</li>
<?php break; ?>
<?php case "customer_care": ?>
		<li class="active ">
			<a href="javascript:;">
			<i class="icon-table"></i>
			<span class="title">Lead Source</span>

								<span class="selected"></span>

								<span class="arrow open"></span>
								</a>

				<ul class="sub-menu">
					<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
						<a href="<?php print SITEPATH.'/leadSource/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Source</a>
					</li>
					<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

							<a href="<?php print SITEPATH.'/leadSource/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Source </a>
					</li>
				</ul>
		</li>
		<li class="active ">
				<a href="javascript:;">
		<i class="icon-table"></i>
		<span class="title">Lead Manager</span>

							<span class="selected"></span>

							<span class="arrow open"></span>
							</a>

			<ul class="sub-menu">
				<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
					<a href="<?php print SITEPATH.'/leadManager/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Lead Manager</a>
				</li>
				<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

						<a href="<?php print SITEPATH.'/leadManager/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Add New Lead Manager </a>
				</li>
			</ul>
		</li>
    <li class="active ">
    	<a href="javascript:;">
    <i class="icon-table"></i>
    <span class="title">Price List</span>

    				<!-- <span class="selected"></span> -->

    				<span class="arrow open"></span>
    				</a>

    <ul class="sub-menu">
    	<li class="<?php if($flag == ''){ echo 'active'; } ?>" id="li_0" onclick="change_tab(0);">
    		<a href="<?php print SITEPATH.'/pricelist/display.php';?>"><img src="../img/list_bullets.png" style="padding-right:15px;" height="16" width="16"/>Price List</a>
    	</li>
    	<li class="<?php if($flag == 'new'){ echo 'active'; } ?>" id="li_new" >

    			<a href="<?php print SITEPATH.'/priceist/display.php?flag=new';?>"><img src="../img/add.png" style="padding-right:10px;"/> Edit Price List </a>
    	</li>
    </ul>
    </li>
<?php break; ?>
<?php } ?>
        		<li class=""></li>


					</ul>

		<!-- END SIDEBAR MENU -->
      </div>
