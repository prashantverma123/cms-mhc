<?php
include_once('../config.php');
include_once('variable.php');
$pricelist_id   	= isset($_GET['pricelist_id']) ? $_GET['pricelist_id'] : '';
$original_pricelist_id =  decryptdata($pricelist_id);
$flag   		= isset($_GET['flag']) ? $_GET['flag'] : '';
$filename 		= 'addForm.php';
$titlename 		= 'Add Price Details';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>T-Price List Control Panel |  <?php print $titlename;?> </title>
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
                    Price Details
                     <?php /*?><small>advance form layout samples</small><?php */?>
                  </h3>

               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <div class="tabbable tabbable-custom boxless">
                     <ul class="nav nav-tabs">
                        <li class="<?php if($pricelist_id == '' || $pricelist_id =='0'){ echo 'active'; } ?>"  id="li_pat0"><a data-toggle="tab" href="#tab_1" onClick="change_tab(0);">Price Listing</a></li>
                        <li class="<?php if($pricelist_id > 0){ echo 'active'; } ?>"  id="li_pat1"><a data-toggle="tab" href="#tab_2"  onclick="change_tab(1);">Add/Edit Price</a></li>
                     </ul>
                     <div class="tab-content">
                        <div id="tab_1" class="tab-pane <?php if($pricelist_id == '' || $pricelist_id =='0'){ echo 'active'; } ?>">
                           <?php include_once('listing.php');?>
                        </div>
                        <div id="tab_2" class="tab-pane <?php if($pricelist_id > 0){ echo 'active'; } ?>">
						<?php
							 $pricelist_id   = decryptdata($pricelist_id);
							 include_once($filename);
							 $pricelist_id   = encryptdata($pricelist_id);
						?>
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
