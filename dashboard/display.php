<?php
include_once('../config.php');
include_once('variable.php');
$source_id   	= isset($_GET['source_id']) ? $_GET['source_id'] : '';
$original_source_id =  decryptdata($source_id);
$flag   		= isset($_GET['flag']) ? $_GET['flag'] : '';
$filename 		= 'addForm.php';
$titlename 		= 'Dashboard';
$modelObj->memcacheData();
$mhcclient =  $memcache->get('mhcclient');
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
            <?php $modules = getModuleByRole($_SESSION['tmobi']['role']); ?>
            <!-- BEGIN PAGE CONTENT-->
      <div class="span11" id="content" style="min-height: 420px;">
          <div class="row-fluid">
          <div ondesktop="span6" ontablet="span8" class="box yellow span6">
          <div class="box-header">
            <h2><i class="halflings-icon white list"></i><span class="break"></span>1 Day Followups</h2>
            <div class="box-icon">
              <a class="btn-minimize" href="#"><i class="halflings-icon white chevron-up"></i></a>
              <a class="btn-close" href="#"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content">
          
              <div role="grid" class="dashboard-list metro dataTables_wrapper form-inline" id="sample_3_wrapper">
                              <table class="table table-striped table-bordered table-hover" id="dashboard1">
                               <thead>

                                <tr>                                 
                                 <th class="hidden-480">Lead Owner</th>
                                  <th class="hidden-480">Name</th>
                                 <th class="hidden-480">Mobile No</th>
                                 <th class="hidden-480">Email Id</th>
                                
                                </tr>
                              </thead>
                               <tbody>
                              <?php $result_data = $modelObj->get1dayfollowups();
                                if($result_data && count($result_data) > 0):
                                foreach ($result_data as $key){
                                  $client = $mhcclient[$key['mhcclient_id']];
                                  //print_r($client);
                              ?>
                                <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
                                <td class="hidden-480"><?php print $key['lead_owner'];?></td>
                                <td class="hidden-480"><?php print $client['client_firstname'];?></td>
                                <td class="hidden-480"><?php print $client['client_mobile_no'];?></td>
                                <td class="hidden-480"><?php if($client['client_email_id']!='') print $client['client_email_id']; else echo "--"; ?></td>                                
                                </tr>
                            <?php } else: echo "<td colspan='5' style='text-align:center;'>No records found</td>"; endif; ?>
                               </tbody>
                            </table>
                              </div>
          </div>
          </div>
           <div ondesktop="span6" ontablet="span8" class="box green span6">
          <div class="box-header">
            <h2><i class="halflings-icon white list"></i><span class="break"></span>Today's Followups</h2>
            <div class="box-icon">
              <a class="btn-minimize" href="#"><i class="halflings-icon white chevron-up"></i></a>
              <a class="btn-close" href="#"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content ">
            <div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
                              <table class="table table-striped table-bordered table-hover dashboard1" id="">
                               <thead>

                                <tr>                                 
                                 <th class="hidden-480">Lead Owner</th>
                                  <th class="hidden-480">Name</th>
                                 <th class="hidden-480">Mobile No</th>
                                 <th class="hidden-480">Email Id</th>
                                
                                </tr>
                              </thead>
                               <tbody>
                              <?php $followup = $modelObj->getdayfollowups();
                                if($followup && count($followup) > 0):
                                foreach ($followup as $key1){
                                  $client = $mhcclient[$key1['mhcclient_id']];
                              ?>
                                <tr class="odd gradeX" id="row_id_<?php print $key1['id'];?>">
                                <td class="hidden-480"><?php print $key1['lead_owner'];?></td>
                                <td class="hidden-480"><?php print $client['client_firstname'];?></td>
                                <td class="hidden-480"><?php print $client['client_mobile_no'];?></td>
                                <td class="hidden-480"><?php if($client['client_email_id']!='') print $client['client_email_id']; else echo "--"; ?></td>                                
                                </tr>
                            <?php } else: echo "<td colspan='5' style='text-align:center;'>No records found</td>"; endif; ?>
                               </tbody>
                            </table>
                              </div>
           
          </div>
          </div>    
          </div>
          <div class="row-fluid">
             <div ondesktop="span6" ontablet="span8" class="box yellow span6">
          <div class="box-header">
            <h2><i class="halflings-icon white list"></i><span class="break"></span>Yesterday's Followups</h2>
            <div class="box-icon">
              <a class="btn-minimize" href="#"><i class="halflings-icon white chevron-up"></i></a>
              <a class="btn-close" href="#"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content">
          
              <div role="grid" class="dashboard-list metro dataTables_wrapper form-inline" id="sample_3_wrapper">
                              <table class="table table-striped table-bordered table-hover" id="dashboard1">
                               <thead>

                                <tr>                                 
                                 <th class="hidden-480">Lead Owner</th>
                                  <th class="hidden-480">Name</th>
                                 <th class="hidden-480">Mobile No</th>
                                 <th class="hidden-480">Email Id</th>
                                
                                </tr>
                              </thead>
                               <tbody>
                              <?php $result_data = $modelObj->getyesterdayfollowups();
                                if($result_data && count($result_data) > 0):
                                foreach ($result_data as $key){
                                  $client = $mhcclient[$key['mhcclient_id']];
                                  //print_r($client);
                              ?>
                                <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
                                <td class="hidden-480"><?php print $key['lead_owner'];?></td>
                                <td class="hidden-480"><?php print $client['client_firstname'];?></td>
                                <td class="hidden-480"><?php print $client['client_mobile_no'];?></td>
                                <td class="hidden-480"><?php if($client['client_email_id']!='') print $client['client_email_id']; else echo "--"; ?></td>                                
                                </tr>
                            <?php } else: echo "<td colspan='5' style='text-align:center;'>No records found</td>"; endif; ?>
                               </tbody>
                            </table>
                              </div>
          </div>
          </div>
          <div ondesktop="span6" ontablet="span8" class="box red span6">
          <div class="box-header">
            <h2><i class="halflings-icon white list"></i><span class="break"></span>Order Complaints</h2>
            <div class="box-icon">
              <a class="btn-minimize" href="#"><i class="halflings-icon white chevron-up"></i></a>
              <a class="btn-close" href="#"><i class="halflings-icon white remove"></i></a>
            </div>
          </div>
          <div class="box-content ">
             <div role="grid" class="dataTables_wrapper form-inline" id="sample_3_wrapper">
                <table class="table table-striped table-bordered table-hover dashboard1" id="">
                 <thead>

                  <tr>
                   <th class="hidden-480">Name</th>
                   <th class="hidden-480">Email ID</th>
                    <th class="hidden-480">Mobile No</th>
                   <th class="hidden-480">Feedback</th>
                  <th>Duration</th>
                  </tr>
                </thead>
                 <tbody>
                <?php $result_data = $modelObj->getOrderComplaint();
                  if($result_data && count($result_data) > 0):
                  foreach ($result_data as $key){
                ?>
                  <tr class="odd gradeX" id="row_id_<?php print $key['id'];?>">
                  <td class="hidden-480"><?php print $key['name'];?></td>
                  <td class="hidden-480"><?php print $key['email_id'];?></td>
                  <td class="hidden-480"><?php print $key['mobile_no'];?></td>
                  <td class="hidden-480"><?php print $key['order_feedback'];?></td>
                  <td class="hidden-480"><?php print $key['duration'];?></td>
                  </tr>
              <?php } else: echo "<tr><td colspan='5' style='text-align:center;'>No records found</td><tr>"; endif; ?>
                 </tbody>
              </table>
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
$(function () {
  $('table').on('scroll', function () {
    $("table > *").width($("table").width() + $("table").scrollLeft());
  });
});
    $("tbody").mCustomScrollbar({
    theme:"light-3",
    scrollButtons:{
      enable:false
    },
    mouseWheel:{ preventDefault: true },
    scrollbarPosition: 'inside',
    autoExpandScrollbar:true,
    theme: 'dark',
     axis:"yx",
                setWidth: "auto"
  });


 /*$("table").mCustomScrollbar({
    theme:"light-3",
    scrollButtons:{
      enable:false
    },
    mouseWheel:{ preventDefault: true },
    scrollbarPosition: 'inside',
    autoExpandHorizontalScroll:true,
    theme: 'dark',
     axis:"x",
      setWidth: "470px"
  });
*/
/*(function($){
      $(window).load(function(){
        
        $(".order-complaint").mCustomScrollbar({
          snapAmount:40,
          scrollButtons:{enable:true},
          keyboard:{scrollAmount:40},
          mouseWheel:{deltaFactor:40},
          scrollInertia:400
        });
      });
    })(jQuery);*/
</script>
