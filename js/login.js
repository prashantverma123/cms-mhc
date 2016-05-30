var Login = function () {
	var HOST_IP_ADDRESS = window.location.host;
    var CMSROOTPATH = "http://"+HOST_IP_ADDRESS+'/cms/';
    return {
        //main function to initiate the module
        init: function () {

           $('.login-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                username: {
	                    required: "Username is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit
	                $('.alert-error', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) { //alert('jjj');
					$('#login_div').hide();
					$('#loader_div').show(); //alert('jjj');
					$('#succes_msg').hide();
	                loginForm()
				}
	        });

			var loginForm = function(){
				//alert('hhh');

				var username = $('#username').val();
				var password = $('#password').val();
				var datastring	   = "username="+username+"&password="+password+"&action=login";
						$.ajax({
							type: "post",
							url: CMSROOTPATH+"2db/login2db.php",
							data: datastring,
							success: function(data){// alert(data);
								if(data.substring(data.length - 1,data.length)=='1'){
									window.location.href = CMSROOTPATH+'dashboard/display.php';
								}
								else{//failure
									//alert('here');
									//$('#alert-error').val('Invalid entry');
									$('#invalid_entry').show();
									$('#username').val('');
									$('#password').val('');
									$('#login_div').show();
									$('#loader_div').hide();
									$('#username').focus();
									setInterval(function(){ $('#invalid_entry').hide();}, 2000);
								}
							}
						});
				return false;
			};

			/*$('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    window.location.href = "2db/login2db.php";
	                }
	                return false;
	            }
	        });*/

	        $('.forget-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	               // window.location.href = "index.html";
				   $('#submit_rest_bt').hide();
				   $('#loader_reset_div').show();
				   forgot_password_form()
	            }
	        });

			var forgot_password_form = function(){
				//alert('hhh');

				var email = $('#email').val();
				var datastring	   = "email="+email+"&action=resetpassword";
						$.ajax({
							type: "post",
							url: CMSROOTPATH+"2db/login2db.php",
							data: datastring,
							success: function(data){ //alert(data);
								if($.trim(data)=='1'){
									//window.location.href = CMSROOTPATH+'category/display.php';
									$('#successsmsg').html(' <font color="#FF0000"> Reset password link sent successfully at you email-id </font>');
									$('#successsmsg').show();
									$('#email').focus();
									setInterval(function(){ $('#successsmsg').hide();}, 4000);
									$('#submit_rest_bt').show();
				   					$('#loader_reset_div').hide();
								}
								else{//failure

									$('#successsmsg').html(' <font color="#FF0000">This email-id is not registered with us !!</font>');
									$('#successsmsg').show();
									$('#email').focus();
									setInterval(function(){ $('#successsmsg').hide();}, 4000);
									$('#submit_rest_bt').show();
				   					$('#loader_reset_div').hide();
								}
							}
						});
				return false;
			};

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    window.location.href = "index.html";
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.forget-form').hide();
	        });

	        $('.register-form').validate({
	            errorElement: 'label', //default input error message container
	            errorClass: 'help-inline', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.control-group').addClass('error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.control-group').removeClass('error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container
	                    error.addClass('help-small no-left-padding').insertAfter($('#register_tnc_error'));
	                } else {
	                    error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
	                }
	            },

	            submitHandler: function (form) {
	               // window.location.href = "index.html";
				   $('#register-submit-btn').hide();
				   $('#loader_acc_div').show();
				   newUserForm();
	            }
	        });

			var newUserForm = function(){
				//alert('hhh');

				var username = $('#cusername').val();
				var password = $('#register_password').val();
				var email = $('#cemail').val();
				//var password = $('#password').val();

				var datastring	   = "username="+username+"&password="+password+"&action=newuser&email="+email;
						$.ajax({
							type: "post",
							url: CMSROOTPATH+"2db/login2db.php",
							data: datastring,
							success: function(data){ //alert(data);
								if($.trim(data)=='1'){
									$('#cusername').val('');
									$('#register_password').val('');
									$('#cemail').val('');
									$('#crpassword').val('');
									//$('#acc_created_msg').html('<font color="#FF0000"> Account created successfully </font>');
									$('#username').val(email);
									jQuery('.login-form').show();
	            					jQuery('.register-form').hide();
									$('#succes_msg').html('<font color="#FF0000"> Account created successfully </font>');
								}else if($.trim(data)=='0'){
									$('#acc_created_errormsg').html('<font color="#FF0000"> Username/Email-Id allready present </font>');
								}else if($.trim(data)=='2'){//failure
									$('#acc_created_errormsg').html('<font color="#FF0000"> Something went worng !! </font>');
								}
								setInterval(function(){ $('#acc_created_msg').hide();}, 2000);
								setInterval(function(){ $('#acc_created_errormsg').hide();}, 2000);
								$('#register-submit-btn').show();
				   				$('#loader_acc_div').hide();
							}
						});
				return false;
			};

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
        }

    };

}();
