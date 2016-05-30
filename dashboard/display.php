<?php
include_once('../config.php');
include_once('variable.php');
$source_id   	= isset($_GET['source_id']) ? $_GET['source_id'] : '';
$original_source_id =  decryptdata($source_id);
$flag   		= isset($_GET['flag']) ? $_GET['flag'] : '';
$filename 		= 'addForm.php';
$titlename 		= 'Dashboard';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>T- Lead Source Control Panel |  <?php print $titlename;?> </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
<?php
	include_once(COMMONFILEPATH.'/headerScripts.php');
?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <?php include_once(COMMONFILEPATH.'/topHeader.php');?>
   <!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="page-container row-fluid">
      <!-- BEGIN SIDEBAR -->
      <?php include_once(COMMONFILEPATH.'/leftMenu.php'); ?>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div class="page-content">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>portlet Settings</h3>
            </div>
            <div class="modal-body ">
               <p>Here will be a configuration form</p>
            </div>
         </div>
         <div id="formPopup" class="modal hide">
            <?php include_once('popEvents.php');?>
         </div>
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->

                  <!-- END BEGIN STYLE CUSTOMIZER -->
                  <h3 class="page-title">
                    Dashboard
                     <?php /*?><small>advance form layout samples</small><?php */?>
                  </h3>

               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <div class="tabbable tabbable-custom boxless">

                     <!-- <div class="tab-content">
                        <h4>Lead Source</h4>
                        <?php echo $modelObj->get_statistics('leadsource'); ?>
                         <h4>Category</h4>
                        <?php echo $modelObj->get_statistics('category'); ?>
                         <h4>City</h4>
                        <?php echo $modelObj->get_statistics('city'); ?>
                         <h4>Order</h4>
                        <?php echo $modelObj->get_statistics('orders'); ?>
                        <h4>Employees</h4>
                       <?php echo $modelObj->get_statistics('employee'); ?>
                      </div> -->
                        <div class="tab-content">
                          <div class="header-stats-container" style="width:100%;height:100px;" >
                         <div class="boxContainer" style="border-style: solid ;border-width: 2px;height: 80px;width:175px;float:left;margin-left:3%;margin-top:1%;color: #a94442;background-color: #f2dede;border-color: #ebccd1;">
                           <h4 style="text-align:center;">Lead Source</h4>
                           <p style="text-align:center;"><?php echo $modelObj->get_statistics('leadsource'); ?></p>
                         </div>
                         <div class="boxContainer" style="border-style: solid ;border-width: 2px;height: 80px;width:175px;float:left;margin-left:3%;margin-top:1%;color: #3c763d;background-color: #dff0d8;border-color: #d6e9c6;">
                           <h4 style="text-align:center;">City</h4>
                          <p style="text-align:center;"><?php echo $modelObj->get_statistics('city'); ?></p>
                         </div>
                         <div class="boxContainer" style="border-style: solid ;border-width: 2px;height: 80px;width:175px;float:left;margin-left:3%;margin-top:1%;color: #31708f;background-color: #d9edf7;border-color: #bce8f1;">
                           <h4 style="text-align:center;">Order</h4>
                          <p style="text-align:center;"><?php echo $modelObj->get_statistics('orders'); ?></p>
                         </div>
                         <div class="boxContainer" style="border-style: solid ;border-width: 2px;height: 80px;width:175px;float:left;margin-left:3%;margin-top:1%;color: #8a6d3b;background-color: #fcf8e3;border-color: #faebcc;">
                           <h4 style="text-align:center;">Employees</h4>
                          <p style="text-align:center;"><?php echo $modelObj->get_statistics('employee'); ?></p>
                         </div>
                         <div class="boxContainer" style="border-style: solid ;border-width: 2px;height: 80px;width:175px;float:left;margin-left:3%;margin-top:1%;background-color: #acf8e3;border-color: #aaebcc;">
                           <h4 style="text-align:center;">Category</h4>
                          <p style="text-align:center;"><?php echo $modelObj->get_statistics('category'); ?></p>
                         </div>

                       </div>
                       </div>


                  </div>
               </div>
            </div>
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <?php include_once(COMMONFILEPATH.'/footer.php'); ?>

</body>
<!-- END BODY -->
</html>
<script>
function change_tab(id){ //alert(id);
	var li_value = 'li_'+id;

		if(id =='new'){ //alert('ss');
			$('#li_pat1').addClass('active');
			$('#li_pat0').removeClass('active');
			$('#tab_2').addClass('active');
			$('#tab_1').removeClass('active');
			$('#'+li_value).attr('class', 'active');
		}else{ //alert('ssss');

			for(var i=0;i<10;i++){
				$('#li_'+i).attr('class', '');
			}
			$('#li_new').attr('class', ''); //alert(id);
			$('#'+li_value).attr('class', 'active');
			if(id == 0){
				$('#li_new').removeClass('active');
				$('#tab_1').addClass('active');
				$('#tab_2').removeClass('active');
				$('#li_pat0').addClass('active');
				$('#li_pat1').removeClass('active');
			}else if(id=1 ){//alert(id);
				$('#tab_2').addClass('active');
				$('#tab_1').removeClass('active');
				$('#li_pat1').addClass('active');
				$('#li_pat0').removeClass('active');
			}
	}
}

function isValidURL(url)
{
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/ ;
    if(RegExp.test(url))
	{
        return true;
    }
	else
	{
        return false;
    }
}
function isValidEmail(emailid) {
	var RegexpRule = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
	return RegexpRule.test(emailid);
};
function shw_hd_sposr(div_name)
{

if($('#'+div_name).is(':visible')) {
        $('#'+div_name).slideUp('400');
		$('#sponsor_image').attr('src', '<?php print IMAGEPATH;?>/add_blck.png');

    } else {
        $('#'+div_name).slideDown('400');
		$('#sponsor_image').attr('src', '<?php print IMAGEPATH;?>/min_blck.png');
    }
}
</script>
