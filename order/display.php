<?php
include_once('../config.php');
include_once('variable.php');
$order_id   	= isset($_GET['order_id']) ? $_GET['order_id'] : '';
$original_order_id =  decryptdata($order_id);
$flag   		= isset($_GET['flag']) ? $_GET['flag'] : '';
$filename 		= 'addForm.php';
$titlename 		= 'Add Order Details';
  //$leadstage = $memcache->get('leadstage');
  $mhcclient = $memcache->get('mhcclient');

  if(!$mhcclient)
  $mhcclient = $dashboardObj->mhcclient();
  $leadsources = $memcache->get('leadsource');
  if(!$leadsources)
  $leadsources = $dashboardObj->leadsource();
  $pricelist = $memcache->get('pricelist');
  if(!$pricelist)
  $pricelist = $dashboardObj->pricelist();
  $lead_dropdown = $memcache->get('pricelist_dropdown');
  if(!$lead_dropdown)
  $lead_dropdown = $dashboardObj->pricelistAll();
  $cities = $memcache->get('city');
   if(!$cities)
  $cities = $dashboardObj->city();
  $memcache_vendor = $memcache->get('vendor');
  if(!$memcache_vendor)
  $memcache_vendor = $dashboardObj->vendor();

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>T- Orders Control Panel |  <?php print $titlename;?> </title>
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
                    Order Details
                     <?php /*?><small>advance form layout samples</small><?php */?>
                  </h3>

               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <!-- <div class="span12" >
              <button type="button" name="button" style="float:right;margin-right:40px;" onclick="refreshData()"> Refresh</button>
              <div class="form-group" style="float:right;margin-right:40px;">
                <label for="usr" style="float:left">Filter By:</label>
                <input type="text" class="form-control" id="fltr">
              </div>
              <div class="" style="clear:both">

              </div>

            </div> -->
            <div class="row-fluid">

               <div class="span12">
                <div style="float:right"><span>Total Orders:</span><span class="orderscount" id="orderscount">0</span></div>

                  <div class="tabbable tabbable-custom boxless">
                     <ul class="nav nav-tabs">
                       <!--  <li id="li_pat2"><a data-toggle="tab" href="#tab_3" onClick="change_tab(2);">AMC Listing</a></li> -->
                        <li class="<?php if($order_id == '' || $order_id =='0'){ echo 'active'; } ?>"  id="li_pat0"><a data-toggle="tab" href="#tab_1" onClick="change_tab(0);">Orders Listing</a></li>
                        <?php if(in_array('add',$actionArr)): ?>
                        <li class="<?php if($order_id > 0){ echo 'active'; } ?>"  id="li_pat1"><a data-toggle="tab" href="#tab_2"  onclick="change_tab(1);">Add/Edit Orders</a></li>
                        <?php endif; ?>
                        
                     </ul>
                     <div class="tab-content">
                      <!--  <div id="tab_3" class="tab-pane">
                         <?php //$is_amc='1'; include_once('listing.php');?>
                        </div> -->
                        <div id="tab_1" class="tab-pane <?php if($order_id == '' || $order_id =='0'){ echo 'active'; } ?>">
                           <?php $is_amc='0'; include('listing.php');?>
                        </div>
                        <div id="tab_2" class="tab-pane <?php if($order_id > 0){ echo 'active'; } ?>">
            						<?php
            							 $order_id   = decryptdata($order_id);
            							 include_once($filename);
            							 $order_id   = encryptdata($order_id);
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
function refreshData(){
  	window.location.href = "<?php SITEPATH;?>/order/display.php";
}
function filter(name){
  $.ajax({
       type: "GET",
       url: "change.php",
       data: "name="+name,
       success: function(html) {
           var obj = JSON.parse(html);
           var str = '';
           for(var i =0;i<obj.length;i++){
             str += '<tr class="odd gradeX" id="row_id_'+i +'">'+
     				 '<td>'+ obj[i].name +'</td>'+
     				 '<td class="hidden-480">'+obj[i].lead_source+'</td>'+
     				 '<td class="hidden-480">'+obj[i].service+'</td>'+
     				 '<td class="hidden-480">'+obj[i].mobile_no+'</td>'+
             '<td class="hidden-480">'+obj[i].email_id+'</td>'+
             '<td class="hidden-480">'+obj[i].price+'</td>'+
             '<td class="hidden-480">'+obj[i].commission+'</td>'+
             '<td class="hidden-480">'+obj[i].taxed_cost+'</td>'+
             '<td class="hidden-480">'+obj[i].insert_date+'</td>'+
     				 '<td>'+
     					'<span class="label label-success"><a href="<?php print SITEPATH.'/order/display.php?order_id='.encryptdata($key['id']);?>" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/edit.png"/> </a></span> &nbsp;'+
     					'<span class="label label-warning"><a href="javascript:void(0);" onclick="dele_order(<?php print $key['id'];?>)" class="edit" title="Edit" style="color:#FFFFFF"><img src="../img/delete.png" /> </a></span>'+
     			  '</tr>'
           }

             $("tbody").html(str);
           console.log(str);
           debugger;

       }
   });
}

  $("#fltr").keypress(function(event) {
    if (event.which == 13) {
        console.log(event,$("#fltr").val());
        filter($("#fltr").val());

        //alert("You pressed enter");
     }
});

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
        $('#tab_3').removeClass('active');
				$('#li_pat0').addClass('active');
				$('#li_pat1').removeClass('active');
        $('#li_pat2').removeClass('active');
			}else if(id=1 ){//alert(id);
				$('#tab_2').addClass('active');
				$('#tab_1').removeClass('active');
        $('#tab_3').removeClass('active');
				$('#li_pat1').addClass('active');
				$('#li_pat0').removeClass('active');
        $('#li_pat2').removeClass('active');
			}else if(id=2 ){//alert(id);
        $('#tab_3').addClass('active');
        $('#tab_1').removeClass('active');
         $('#tab_2').removeClass('active');
        $('#li_pat2').addClass('active');
        $('#li_pat0').removeClass('active');
        $('#li_pat1').removeClass('active');
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
