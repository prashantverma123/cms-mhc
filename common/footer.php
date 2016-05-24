<div class="footer">
      2013 &copy; tminus.mobi
      <div class="span pull-right">
         <span class="go-top"><i class="icon-angle-up"></i></span>
      </div>
   </div>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->  
   <?php /*?><script src="<?php print JSFILEPATH;?>/jquery-ui-1.10.1.custom.min.css" type="text/javascript"></script> <?php */?>     
   <script src="<?php print JSFILEPATH;?>/bootstrap.min.js" type="text/javascript"></script>
   <!--[if lt IE 9]>
   <script src="assets/plugins/excanvas.js"></script>
   <script src="assets/plugins/respond.js"></script>  
   <![endif]-->   
   <script src="<?php print JSFILEPATH;?>/breakpoints.js" type="text/javascript"></script>  
   <!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js --> 
   <script src="<?php print JSFILEPATH;?>/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="<?php print JSFILEPATH;?>/jquery.blockui.js" type="text/javascript"></script>  
   <script src="<?php print JSFILEPATH;?>/jquery.cookie.js" type="text/javascript"></script>
   <script src="<?php print JSFILEPATH;?>/jquery.uniform.min.js" type="text/javascript" ></script> 
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="<?php print JSFILEPATH;?>/data-tables/jquery.dataTables.js"></script>
   <script type="text/javascript" src="<?php print JSFILEPATH;?>/data-tables/DT_bootstrap.js"></script>
   <script type="text/javascript" src="<?php print JSFILEPATH;?>/select2/select2.min.js"></script>
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="<?php print JSFILEPATH;?>/app.js"></script>
   <script src="<?php print JSFILEPATH;?>/table-managed.js"></script> 
   <script src="<?php print JSFILEPATH;?>/form-samples.js"></script>   
      
   <!-- END PAGE LEVEL SCRIPTS -->
   <script>
      jQuery(document).ready(function() {    
         // initiate layout and plugins
         App.init();
		 TableManaged.init();
         FormSamples.init();
		 
      });
   </script>
   <!-- END JAVASCRIPTS -->