/*
	Cole Core
	(c) Peter Day 2018	
*/

// Create Base64 Object
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

var PermissionsSubsystemLoaded = false;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

Cole = {
	Boot: function(){
		$("video[autoplay]").each(function(){
			this.play();
		});
		$('.right-bar-toggle').on('click', function(e){
			$('#wrapper').toggleClass('right-bar-enabled');
			$('.notification-box .noti-dot').remove();
			$.get("/api/notifications/read");
		});
		$( "ul.Modules li a" ).click(function() {
			$.get("/api/server/check/", function(api, status){
				if(api.Outcome=="Failure"){
					swal({
						title: 'Cole',
						type: 'error',
						text: api.Reason,
						allowOutsideClick: false,
					}).then((result) => {
						$('body').addClass('Loading');
						$.get("/ColeAccounts/Logout", function(api, status){
							location.reload();
						});
					});	
				}
			});
			if($(this).parent().attr('data-custom')=='true'){
				var CustomModule = true;
			}else{
				var CustomModule = false;				
			}
			
			if(Cookies.get('ColeUser') === undefined){
				Cole.Account.Reauth();
				return;
			}
			
			$('body').addClass('Loading');
			var ModuleTitle = $(this).find('span').text();
			var ModuleName = $(this).data('module');

			// Read notifications
			$(this).find('span.label').remove();
			$.get("/api/notifications/read/" + ModuleName);
			
			$('ul.Modules li a').removeClass('active');
			$(this).addClass('active');
			
			$.get("/Module/" + $(this).data('module'), function(module, status){
				$('body').removeClass('Loading');
				
				// Affect content-page to instruct where we are for bg loading
				$('.content-page').attr('data-module',ModuleName);
		        if(status=="success"){
			        $('div.content-page').html(module);
			        $('h4.ModuleName').html(ModuleTitle);
			        // Wipe stored dataactions
			        Cole.DataActions = {};
			        // Now load the script
			        if(CustomModule){
				        $.getScript("/Cole/Javascript/Modules/Custom/" + ModuleName + ".cole.js?rand=" + Math.random()).done(function(){ 
							console.log('Cole: ' + ModuleName + ' javascript loaded');  
						});				        
			        }else{
				        $.getScript("/Cole/Javascript/Modules/" + ModuleName + ".cole.js?rand=" + Math.random()).done(function(){ 
							console.log('Cole: ' + ModuleName + ' javascript loaded');  
						});
					}
					
					// If Datatable class exists, Load the init
					if($('.Datatable').length){
						if($('.Datatable').hasClass('NoContent')){
							console.log('Cole: Did not initialise datatable owing to no data');
						}else{
							console.log('Cole: DataTable Booted');
							$('.Datatable').dataTable();    
						}
				    }			
		        }
		    }).fail(function(e) {
				var ErrorTest = e.responseJSON.message;
				if(ErrorTest.includes("$Secret") || ErrorTest.includes("$FullName") || ErrorTest.includes("stdClass::$id")){
					// Secret has altered
					swal({
						title: 'Cole',
						text: "You've logged on at another location or your session has expired. Therefore your session at this location has been terminated. To continue using Cole you will need to login.",
						type: 'warning',
						allowOutsideClick: false,
						showCancelButton: false
						}).then((result) => {
							if (result.value) {
								$('body').addClass('Loading');
								location.reload();
							}
						})
						return;
				}else{
					Cole.Exception(e);
				}
			});
		    
		    
	    
	    });
	   	$( "ul.Modules li a[data-module=today]" ).click(); // Default to Dashboard
	   	$('body').removeClass('Loading');
	   	if($('body[data-pagereference=Login]').length){
		   	$( "button.Login" ).click(function() {
				Cole.Account.Login($('input#Email').val(),$('input#Password').val(),true);
	
			});
		   	$('input').keypress(function (e) {
		   	   	if (e.which == 13) {
					$("button.Login").click();   
				}
			});
		}
		if($('body[data-pagereference=install]').length){
			$( "button.Install" ).click(function(){
				Cole.Install.Install();
			});
		}
	   	$( "a#Logout" ).click(function() {
	   		swal({
				title: "Log out",
				text: "Are you sure you want to logout? You will lose any unsaved changes.",
				type: "question",
				showCancelButton: true,
				allowOutsideClick: false,
			}).then((result) => {
				if (result.value){
					$('body').addClass('Loading');
					$.get("/ColeAccounts/Logout", function(api, status){
						location.reload();
					});
				}
			});
		});
	   	$('div#sidebar-menu').height(parseInt($(window).height())-278);
	},
	Exception: function(e){
		$.get("/Error/500", function(module, status){
			$('body').removeClass('Loading');
			$('body .content-page').attr('data-module','error');
			$('div.content-page').html(module);
			$('h4.ModuleName').html('Oops!');
			$('pre.ErrorTxt').html(e.responseJSON.exception + '<br/>' + e.responseJSON.message + '<br/>Line ' + e.responseJSON.line + '<br/>' + e.responseJSON.file);
			
		});
		$.post("/api/cer/report",{
			Exception: e.responseJSON.message + ' - Line ' + e.responseJSON.line + ' - File: ' + e.responseJSON.file
		});
	},
	"Handlers": {
		Create: function (api,status,module) {
			$('body').removeClass('Loading');
	        if(status=="success"){
		        console.log('Cole: Create Handler executed',api,status);
		        if(api.Outcome=="Success"){
			        
					if(api.DataActionResult.Outcome=="Success"){
				    
			        swal({
						title: "Changes saved",
						text: "The item has been created successfully.",
						type: "success",
						allowOutsideClick: false,
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});
			        
			        }else{
				        swal(
						  'Cole',
						  api.DataActionResult.Reason,
						  'error'
						);
			        }
		        }else if(api.Outcome=="Failure"){
		        	swal(
					  'Cole',
					  api.Reason,
					  'error'
					);
			    }else{
			       swal({
						title: "Oops!",
						text: "An unknown error occured. Please try again.",
						type: "error",
						allowOutsideClick: false,
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});			    
			    }
	        }else{
				swal({
					title: "Oops!",
					text: "An unknown error occured. Please try again.",
					type: "error",
					allowOutsideClick: false,
					showCancelButton: false,
				}).then((result) => {
					if (result.value){
						$('ul.Modules li a[data-module=' + module + ']').click();
					}
				});
	        }
		},
		Delete: function (api,status,module) {
			$('body').removeClass('Loading');
	        if(status=="success"){
		        console.log('Cole: Delete Handler executed',api);
		        if(api.Outcome=="Success"){
					
					if(api.DataActionResult.Outcome=="Success"){
				        
			        swal({
						title: "Item Deleted",
						text: "The item has been deleted successfully.",
						type: "success",
						allowOutsideClick: false,
						showCancelButton: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});
			        
			        }else{				        
				        swal(
						  'Cole',
						  api.DataActionResult.Reason,
						  'error'
						);
			        }
			        
		        }else if(api.Outcome=="Failure"){		        
			        swal(
					  'Cole',
					  api.Reason,
					  'error'
					);			        
			    }else{
			       swal({
						title: "Oops!",
						text: "An unknown error occured. Please try again.",
						type: "error",
						showCancelButton: false,
						allowOutsideClick: false,
					}).then((result) => {
						if (result.value){						
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});			    
			    }
	        }else{
				swal({
					title: "Oops!",
					text: "An unknown error occured. Please try again.",
					type: "error",
					allowOutsideClick: false,
					showCancelButton: false,
				}).then((result) => {
					if (result.value){					
						$('ul.Modules li a[data-module=' + module + ']').click();
					}
				});
	        }
		},
		Save: function (api,status,module) {
			$('body').removeClass('Loading');
	        if(status=="success"){
		        console.log('Cole: Save Handler executed',api);
		        if(api.Outcome=="Success"){
					
					if(api.DataActionResult.Outcome=="Success"){
				    
				    // Item saved OK, Check and run JS Followup
				    if ($.isFunction(Cole.DataActions.Save)) {
					   Cole.DataActions.Save(api);
					}
				    
			        swal({
						title: "Item Saved",
						text: "The item has been saved successfully.",
						type: "success",
						showCancelButton: false,
						allowOutsideClick: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});
			        
			        }else{
				        swal(
						  'Cole',
						  api.DataActionResult.Reason,
						  'error'
						);				        
			        }
			        
		        }else if(api.Outcome=="Failure"){
			        swal(
					  'Cole',
					  api.Reason,
					  'error'
					);			        
			    }else{
			       swal({
						title: "Oops!",
						text: "An unknown error occured. Please try again.",
						type: "error",
						showCancelButton: false,
						allowOutsideClick: false,
					}).then((result) => {
						if (result.value){
							$('ul.Modules li a[data-module=' + module + ']').click();
						}
					});			    
			    }
	        }else{
				swal({
					title: "Oops!",
					text: "An unknown error occured. Please try again.",
					type: "error",
					showCancelButton: false,
					allowOutsideClick: false,
				}).then((result) => {
					if (result.value){
						$('ul.Modules li a[data-module=' + module + ']').click();
					}
				});
	        }
		}
	},
	"Permissions":{
		Boot: function(){
			if(!PermissionsSubsystemLoaded){
				$('body').on('click', '.content-page[data-module=me] table.permissions tbody i', function() {
				$(this).toggleClass('Active');
				if($(this).hasClass('Active')){
					$(this).parent().find('input[type=checkbox]').prop('checked',true);
					PermissionSave($(this).parent().parent().data('module'),$(this).parent().data('permission'),true);			
				}else{
					$(this).parent().find('input[type=checkbox]').prop('checked',false);			
					PermissionSave($(this).parent().parent().data('module'),$(this).parent().data('permission'),false);
					
				}
			});	
				$('body').on('click', '.content-page[data-module=me] table.permissions tbody tr td.Module', function() {
					// Horizontal toggle all
					
					// Discover the status of things to change
					var PermissionStatus = [];
					$(this).parent().find('td:not(.Module) input[type=checkbox]').each(function(){
						var value = $(this).prop('checked');
						PermissionStatus.push(value);						
					});

					if (jQuery.inArray(true, PermissionStatus)!='-1') {
						// Some or all items are true, toggle off
						$(this).parent().find('td[data-permission=get] i').removeClass('Active');
						$(this).parent().find('td[data-permission=get] input[type=checkbox]').prop('checked',false);
						PermissionSave($(this).parent().data('module'),'get',false);
						
						$(this).parent().find('td[data-permission=create] i').removeClass('Active');
						$(this).parent().find('td[data-permission=create] input[type=checkbox]').prop('checked',false);
						PermissionSave($(this).parent().data('module'),'create',false);
						
						$(this).parent().find('td[data-permission=save] i').removeClass('Active');
						$(this).parent().find('td[data-permission=save] input[type=checkbox]').prop('checked',false);
						PermissionSave($(this).parent().data('module'),'save',false);
						
						$(this).parent().find('td[data-permission=delete] i').removeClass('Active');
						$(this).parent().find('td[data-permission=delete] input[type=checkbox]').prop('checked',false);
						PermissionSave($(this).parent().data('module'),'delete',false);
					}else{
						// All items are off, toggle on
						$(this).parent().find('td[data-permission=get] i').addClass('Active');
						$(this).parent().find('td[data-permission=get] input[type=checkbox]').prop('checked',true);
						PermissionSave($(this).parent().data('module'),'get',true);
						
						$(this).parent().find('td[data-permission=create] i').addClass('Active');
						$(this).parent().find('td[data-permission=create] input[type=checkbox]').prop('checked',true);
						PermissionSave($(this).parent().data('module'),'create',true);
						
						$(this).parent().find('td[data-permission=save] i').addClass('Active');
						$(this).parent().find('td[data-permission=save] input[type=checkbox]').prop('checked',true);
						PermissionSave($(this).parent().data('module'),'save',true);
						
						$(this).parent().find('td[data-permission=delete] i').addClass('Active');
						$(this).parent().find('td[data-permission=delete] input[type=checkbox]').prop('checked',true);
						PermissionSave($(this).parent().data('module'),'delete',true);
					}
					
					
				

				
			});
			$('body').on('click', '.content-page[data-module=me] table.permissions thead tr td:not(.Corner)', function() {
				var thisPermission = $(this).attr('data-permission');
				
				var PermissionStatus = [];
				$('.content-page[data-module=me] table.permissions tbody tr td[data-permission=' + thisPermission + '] input').each(function(){
					var value = $(this).prop('checked');
					PermissionStatus.push(value);						
				});

				console.log(PermissionStatus);

				if (jQuery.inArray(true, PermissionStatus)!='-1') {
					// Some or all items are true, toggle off

					$( ".content-page[data-module=me] table.permissions tbody tr td[data-permission=" + thisPermission + "]" ).each(function( index ) {
						$(this).find('i').removeClass('Active');
						$(this).find('input').prop('checked',false);
						PermissionSave($(this).parent().data('module'),thisPermission,false);
					});

				}else{
					// All items are off, toggle on

					$( ".content-page[data-module=me] table.permissions tbody tr td[data-permission=" + thisPermission + "]" ).each(function( index ) {
						$(this).find('i').addClass('Active');
						$(this).find('input').prop('checked',true);
						PermissionSave($(this).parent().data('module'),thisPermission,true);
					});

				}

				
				
			});
				console.log('Cole: Permissions subsystem loaded');
				PermissionsSubsystemLoaded = true;
			}
		}
	},
	"Install": {
		Install: function(){
			swal({
				title: 'Cole',
				text: "We will now install Cole. Are you sure your details are correct?",
				type: 'warning',
				showCancelButton: true,
				allowOutsideClick: false,
			}).then((result) => {
				if (result.value) {
					$('body').addClass('Loading');
					// POST To Install script
				    Cole.Install.Process();
				}
			})
		},
		Process: function(){
			if($('input#Email').val().length==0){
				$('body').removeClass('Loading');
				swal('Cole','Please complete all fields before progressing.','error');
				return;
			}
			if($('input#Password').val().length==0){
				$('body').removeClass('Loading');
				swal('Cole','Please complete all fields before progressing.','error');
				return;
			}
			if($('input#Password2').val().length==0){
				$('body').removeClass('Loading');
				swal('Cole','Please complete all fields before progressing.','error');
				return;
			}
			if($('input#FullName').val().length==0){
				$('body').removeClass('Loading');				
				swal('Cole','Please complete all fields before progressing.','error');
				return;
			}
			if($('input#Password').val()!=$('input#Password2').val()){
				$('body').removeClass('Loading');
				swal('Cole','Sorry, your passwords do not match. Try typing them again.','error');
				return;				
			}
			$('body').addClass('Loading');
			$.post("/Cole/Install",{
		        Email: $('input#Email').val(),
		        Password:  $('input#Password').val(),
		        Password2:  $('input#Password2').val(),
		        FullName:  $('input#FullName').val(),
		    },function(api, status){
		        if(api.Outcome=="Success"){
					$('body').removeClass('Loading');
			        swal({
					  title: 'Cole',
					  text: "Cole has been installed successfully",
					  type: 'success',
					  showCancelButton: false,
					  allowOutsideClick: false
					}).then((result) => {
					  if (result.value) {
					  	document.location = '/';
					  }
					});
		        }else if(api.Outcome=="MidInstall"){
			       // ENV Files are set, now process the database stuff
			       // We need to do this because env is loaded at init
			       console.log('Cole: ENV Set, Now setting up database');
			       Cole.Install.Process();
			    }else{
					// An error occurred
					$('body').removeClass('Loading');
					swal({
					  title: 'Cole',
					  text: api.Reason,
					  type: 'error',
					  showCancelButton: false,
					  allowOutsideClick: false
					});	        
		        }
		     }).fail(function(e) {
				var exception = e.responseJSON.exception;
				$('body').removeClass('Loading');		
				
				
				swal({
				  title: 'Cole',
				  html: 'Sorry, a critical error occurred whilst installing Cole:<br/><br/>' + exception + '<br/><br/>Cole will now reset this installation. You may need to drop all tables on the database',
				  type: 'error',
				  showCancelButton: false,
				  allowOutsideClick: false
				}).then((result) => {
				  if (result.value) {
				  	$('body').addClass('Loading');		
	 				$.get("/Cole/Install/Reset");
				  	setTimeout(function(){
					  	swal({
						  title: 'Cole',
						  text: 'Cole has been reset, You may need to drop all tables on the database. You will need to run install.sh to setup Cole anew.',
						  type: 'info',
						  showCancelButton: false,
						  allowOutsideClick: false
						 }).then((result) => {
							document.location = '/'; 
						 });						
				  	}, 5000);
				  }
				});				
				
								
			});
			
		}
	},
	"EditPane": {
		Boot: function(api){
			// isURL
			$("input.isURL").keyup(function() {
				$(this).val($(this).val().replace(" ","-"));
			});
			// Maxlength
			$( "input[maxlength]" ).each(function() {
				$(this).keyup(function() {
					var thisInput = $(this);
					thisInput.parent().find('span.MaxLength').html(parseInt(thisInput.attr('maxlength'))-thisInput.val().length);
					
					// Work out 20% for amber
					// Work out 10% for red
					var percentage = 100 - (thisInput.val().length / parseInt(thisInput.attr('maxlength'))) * 100;
					
					thisInput.parent().find('span.MaxLength').removeClass('warning');
					thisInput.parent().find('span.MaxLength').removeClass('danger');
					
					if(percentage<=20){
						// amber
						thisInput.parent().find('span.MaxLength').addClass('warning');
						thisInput.parent().find('span.MaxLength').removeClass('danger');
					}
					if(percentage<=10){
						// red
						thisInput.parent().find('span.MaxLength').removeClass('warning');
						thisInput.parent().find('span.MaxLength').addClass('danger');
					}
					
					
					
				});
				$(this).keyup(); // do a simulated keyup to update counter
			});
			// Pull the images from the FE Site
			if($('.TreeContainer').length!=0){
				$("#ajaxTree").jstree("destroy");
				$('#ajaxTree').jstree({
					'core' : {
						'check_callback' : true,
						'themes' : {
							'responsive': false
						},
						'data' : {
							'url' : function (node,cb) {
								console.log('url',node,cb);
								if(node.id==='#'){
									// Top
									return $('.Cole.FEUrl').val() + '/Cole/Pages/ImgBrowse';
								}else{
									// Child
									return $('.Cole.FEUrl').val() + '/Cole/Pages/ImgBrowse/' + node.text + '';
								}
							},
							'data' : function (node,cb) {
								console.log('data',node,cb);
								return { 'id' : node.name };
							}
						}
					},
					"types" : {
						'default' : {
							'icon' : 'fa fa-folder'
						},
						'file' : {
							'icon' : 'fa fa-file'
						}
					},
					"plugins" : ["dnd", "search", "state", "types", "wholerow" ]
				});
				$('#ajaxTree').on('changed.jstree', function (e, data) {
					try{
					var path = data.instance.get_path(data.node,'/');
					console.log('Selected: ' + path); 
					// Now save this to the hidden field nearby and upadte the preview image
					if (path.indexOf(".") >= 0){
						$(this).parent().parent().find('input[type=hidden].Url').val(path);
						$(this).parent().parent().find('img').attr('src', $('.Cole.FEUrl').val() + '/Cole/Images/' + path);
					}
					}catch(err){
						console.log('Cole: Assuming parent');
					}
				});
				$('#ajaxTree img').attr('src', $('.Cole.FEUrl').val() + $('input[type=hidden].Url').val());
			}
			if ($.isFunction(Cole.DataActions.Get)) {
				Cole.DataActions.Get(api);
			 }
		},
	},
	"DataActions": {
		// Prep this space for dataactions to be added
	},
	"Modules": {
		// Prep this space for modules to be added
	},
	"Account": {
		Reauth: function(){
			swal({
				title: 'Cole',
				type: 'warning',
				text: 'Sorry, Your user session has expired and you will need to type your Cole password in order to proceed.',
				allowOutsideClick: false,
				input: 'password',
				inputPlaceholder: 'Enter your password',
				inputAttributes: {
					'maxlength': 10,
					'autocapitalize': 'off',
					'autocorrect': 'off'
				}
			}).then((result) => {
				console.log(result.value);
				Cole.Account.Login($('input.Cole#ColeUserEmail').val(),result.value,false)
			});
		},
		Login: function(Email,Password,LoginPage){
			$('body').addClass('Loading');
				$.post("/ColeAccounts/Login",{
			        Email: Email,
			        Password: Password
			    },
			    function(api, status){
					if(status=="success"){
					// API ran ok
					if(api.Outcome=="Success"){
						if(LoginPage){
							location.reload(); // refresh because login went ok
						}else{
							// Return back to user session
							$('body').removeClass('Loading');
						}
					}else if(api.Outcome=="Failure"){
						$('body').removeClass('Loading');
						swal({
							title: 'Cole',
							type: 'error',
							text: api.Reason,
							allowOutsideClick: false,
						}).then((result) => {
							if(!LoginPage){
								// Reprompt for auth
								Cole.Account.Reauth();
							}
						});						
					}else{
						$('body').removeClass('Loading');
						swal({
							title: 'Cole',
							type: 'error',
							text: 'Sorry, an unknown error occured. Please try again',
							allowOutsideClick: false,
						}).then((result) => {
							if(!LoginPage){
								// Reprompt for auth
								Cole.Account.Reauth();
							}
						});							
					}
				}else{
					// Unknown error logging in
					$('body').removeClass('Loading');
					swal({
						title: 'Cole',
						type: 'error',
						text: 'Sorry, an unknown error occured. Please try again',
						allowOutsideClick: false,
					}).then((result) => {
						if(!LoginPage){
							// Reprompt for auth
							Cole.Account.Reauth();
						}
					});							
				}
			}).fail(function(e) {
				var exception = e.responseJSON.exception;
				$('body').removeClass('Loading');
				swal({
					title: 'Cole',
					type: 'error',
					text: 'Sorry, a system error occurred. You can find details below:\n\n' + exception,
					allowOutsideClick: false,
				}).then((result) => {
					if(!LoginPage){
						// Reprompt for auth
						Cole.Account.Reauth();
					}
				});									
			});
		}
	},
};

$(function() {
	Cole.Boot(); // init cole
});

// TRIGGERS
$('body').on('click', 'table tbody tr td .ColeModuleTrigger', function() {
	// Get Module information
	var Module = $(this).parent().data('module');
	var ItemID = $(this).parent().data('itemid');
	$.get("/api/server/check/", function(api, status){
		if(api.Outcome=="Failure"){
			swal({
				title: 'Cole',
				type: 'error',
				text: api.Reason,
				allowOutsideClick: false,
			}).then((result) => {
				$('body').addClass('Loading');
				$.get("/ColeAccounts/Logout", function(api, status){
					location.reload();
				});
			});	
		}
	});
	if($(this).data('control')=="edit"){
		$('body').addClass('Loading');
		$('.TableList').hide();
		
		$.get("/DataAction/" + Module + "/get/" + ItemID, function(api, status){
			console.log('Cole: DataAction executed:',api);
			if(status=="success"){
				$('.EditControls').show();
				
				// Setup EditConstructor
				$.post("/Construct/EditPane",{
			        Data: api.DataActionResult
			    },function(response, status){
				    var Output = '<div class="ModuleFields">';
				    Output += response;
			        Output += '</div>';
					
					
					
					// Now make button controls
					Output += '<div class="ColeEditToolbar">';
						Output += '<div class="btn btn-success ColeSaveTrigger"><i class="zmdi zmdi-check"></i> Save changes</div>';
						Output += '<div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Cancel</div>';
						Output += '<div class="btn btn-danger ColeDeleteTrigger"><i class="zmdi zmdi-delete"></i> Delete</div>';
					Output += '</div>';
					
					$('.EditControls .EditModule').html(Output);
					
					
					// Rich text listener
					if($('.EditControls .EditModule .ModuleFields .ColeRichText').length!=0){
						var thisID = $('.ColeRichText').attr('id');
						console.log('Cole: Booted RichText Editor');
						$('textarea.ColeRichText').trumbowyg();
						$('textarea.ColeRichText').on('tbwinit', function(){
							$('.trumbowyg-editor').attr('id',thisID);
						});
						
					}
					
					// Set up the edit toolbar
					$('.EditControls .ColeEditToolbar').attr('data-module',Module);
					$('.EditControls .ColeEditToolbar').attr('data-itemid',ItemID);
					
					
					$('body').removeClass('Loading');
					
					Cole.EditPane.Boot(api);
				
			    }).fail(function(e) {Cole.Exception(e);});
			    
			
			}else{
				$('body').removeClass('Loading');
				$('.TableList').show();				
		        swal(
				  'Cole',
				  'An unknown error occurred. Please try again',
				  'error'
				);				
			}
		}).fail(function(e) {Cole.Exception(e);});
		
	}else if($(this).data('control')=="delete"){

		swal({
			title: "Delete Item",
			text: "Are you sure you want to delete this item? You will not be able to undo this action.",
			type: "warning",
			showCancelButton: true,
			allowOutsideClick: false,
		}).then((result) => {
			if (result.value){
				$.get("/DataAction/" + Module + "/delete/" + ItemID + "", function(api, status){
					Cole.Handlers.Delete(api,status,Module);
				}).fail(function(e) {Cole.Exception(e);});
			}
		});
		

	}
	
	
});
$('body').on('click', 'ul.dropdown-menu li a.CreateItem', function() {
	
	var Module = $(this).data('module');
	$('body').addClass('Loading');
	$('.TableList').hide();
	
	$.get("/DataAction/" + Module + "/get/ColumnValues", function(api, status){
		
		// Send a notice that this is a new item
		console.log('Cole: ColumnValues loaded: ',api);
		if(status=="success"){
			$('.EditControls').show();
			

			// Setup EditConstructor
			$.post("/Construct/EditPane/New",{
		        Data: api.DataActionResult
		    },
		    function(response, status){
			    var Output = '<div class="ModuleFields">';
			    Output += response;
		        Output += '</div>';
			
				
				// Now make button controls
				Output += '<div class="ColeEditToolbar">';
					Output += '<div class="btn btn-success ColeCreateTrigger"><i class="zmdi zmdi-file-plus"></i> Create</div>';
					Output += '<div class="btn btn-warning ColeCancelTrigger"><i class="zmdi zmdi-close"></i> Cancel</div>';
				Output += '</div>';
				
				$('.EditControls .EditModule').html(Output);

				// Rich text listener
				if($('.EditControls .EditModule .ModuleFields .ColeRichText').length!=0){
					var thisID = $('.ColeRichText').attr('id');
					console.log('Cole: Booted RichText Editor');
					$('textarea.ColeRichText').trumbowyg();
					$('textarea.ColeRichText').on('tbwinit', function(){
						$('.trumbowyg-editor').attr('id',thisID);
					});
					
				}
				
				
				// Set up the edit toolbar
				$('.EditControls .ColeEditToolbar').attr('data-module',Module);
				$('body').removeClass('Loading');
				
				Cole.EditPane.Boot();
			
		    });
		    
		
		}else{
			$('body').removeClass('Loading');
			$('.TableList').show();
	        swal(
			  'Cole',
			  'An unknown error occurred. Please try again',
			  'error'
			);				
		}
	});
	
	
	
	

});

// Cole EditToolbar Module controls
$('body').on('click', 'div.EditModule .ColeEditToolbar .ColeCancelTrigger', function() {
	var Module = $(this).parent().data('module');	
	swal({
		title: "Cancel",
		text: "Are you sure you want to cancel? You will lose any unsaved changes.",
		type: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
	}).then((result) => {
		if (result.value){
			$('ul.Modules li a[data-module=' + Module + ']').click();
		}
	});	
	
	
	
});
$('body').on('click', 'div.EditModule .ColeEditToolbar .ColeDeleteTrigger', function() {
	var Module = $(this).parent().data('module');
	var ItemID = $(this).parent().data('itemid');

	swal({
		title: "Delete Item",
		text: "Are you sure you want to delete this item? You will not be able to undo this action.",
		type: "warning",
		showCancelButton: true,
		allowOutsideClick: false,
	}).then((result) => {
		if (result.value){
			$.get("/DataAction/" + Module + "/delete/" + ItemID + "", function(api, status){
				Cole.Handlers.Delete(api,status,Module);
			});
		}
	});	

});
$('body').on('click', 'div.EditModule .ColeEditToolbar .ColeSaveTrigger', function() {
	var Module = $(this).parent().data('module');
	var ItemID = $(this).parent().data('itemid');
	console.log('Cole: SaveTrigger clicked',Module,ItemID);
	swal({
		title: "Save Changes",
		text: "Are you sure you want to save your changes?",
		type: "question",
		showCancelButton: true,
		allowOutsideClick: false,
	}).then((result) => {
		if (result.value){
			// Package fields
			var Fields = {};
					
			
			$( ".ModuleFields .form-group input,.ModuleFields .form-group select,.ModuleFields .form-group textarea" ).each(function() {
				var Key = $(this).attr('id');
				var Value = $(this).val();
				Fields[Key] = Value;
			});
	
			console.log('Cole: SaveTrigger Fields',Fields);
	
			
			$.post("/DataAction/" + Module + "/save/" + ItemID + "",Fields,
		    function(api, status){
			    Cole.Handlers.Save(api,status,Module);
			}).fail(function(e) {
				Cole.Exception(e);
			});
		}
	});	

});
$('body').on('click', 'div.EditModule .ColeEditToolbar .ColeCreateTrigger', function() {
	var Module = $(this).parent().data('module');

	swal({
		title: "Create Item",
		text: "Are you sure you want to create this item?",
		type: "question",
		showCancelButton: true,
		allowOutsideClick: false,
	}).then((result) => {
		if (result.value){
			// Package fields
			var Fields = {};
					
			
			$( ".ModuleFields .form-group input,.ModuleFields .form-group textarea,.ModuleFields .form-group select" ).each(function() {
				var Key = $(this).attr('id');
				var Value = $(this).val();
				Fields[Key] = Value;
			});
	
			console.log('Cole: CreateTrigger Fields',Fields);
	
			
			$.post("/DataAction/" + Module + "/create",Fields,
		    function(api, status){
			    Cole.Handlers.Create(api,status,Module);
			}).fail(function(e) {
				Cole.Exception(e);
			});
		}
	});	

});


// CONSTRUCTORS
function ColeArrayFormatter(){
	// ColeArrayFormatter
	// Formats a given array / object
	// Add to this by means of plugins from module javascripts
	// Cole will call ColeArrayFormatter.Codename(fieldKey,value,MasterData)
}

function DateFormat(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}