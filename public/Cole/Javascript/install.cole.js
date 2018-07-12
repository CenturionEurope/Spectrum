$(function() {
	$('div.installpage[data-installpage=1]').fadeIn('fast');
	$('button.Next').click(function(){
		var nextPage = $(this).attr('data-topage');
		if($(this).attr('data-action')){
			if(nextPage==3){
				// Login test
				$.post("/api/install/db/set",
				{
					DbUsername: $('input#DbUsername').val(),
					DbPassword: $('input#DbPassword').val(),
					DbDatabase: ''
				},
				function(api, status){
					console.log('db/set:',api);
					if(api.Outcome=="Success"){
						$.get("/api/install/db/vet", function(api, status){
							console.log('db/get:',api);
							if(api.Status==0){
								// Error status
								if(api.Type==1){
									swal('Cole','It looks like that login is not correct. Please try again.','error');
								}
								if(api.Type==2){
									// MySQL is not running on localhost, proceed to server setup
									$('div.installpage').hide();
									$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');
								}
							}else{
								// Connection made
								nextPage = parseInt(nextPage);
								nextPage = nextPage + 1; // Bypass host setup
								$('div.installpage').hide();
								$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');
							}
						});
					}else{
						// Cannot set
						swal('Cole',api.Reason,'error');
					}
				});
			}
			if(nextPage==4){
				// We need to apply the connection deets
				if($('input#DbPort').val().length==0){
					$('input#DbPort').val('3306');
				}
				$.post("/api/install/db/set",
				{
					DbHost: $('input#DbHost').val(),
					DbPort: $('input#DbPort').val(),
					DbDatabase: ''
				},
				function(api, status){
					console.log('db/set:',api);
					if(api.Outcome=="Success"){
						$.get("/api/install/db/vet", function(api, status){
							console.log('db/get:',api);
							if(api.Status==0){
								// Error status
								swal('Cole','Sorry, Cole cannot reach a databaase with the provided details. Please try again.','error');
							}else{
								// Connection made
								$('div.installpage').hide();
								$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');
							}
						});
					}else{
						// Cannot set
						swal('Cole',api.Reason,'error');
					}
				});				
			}
			if(nextPage==5){
				// Check for table
				$.post("/api/install/db/set",
				{
					DbDatabase: $('input#DbDatabase').val()
				},
				function(api, status){
					console.log('db/set:',api);
					if(api.Outcome=="Success"){
						$.get("/api/install/db/vet", function(api, status){
							console.log('db/vet:',api);
							if(api.Status==0){
								// Db does not exist, we need to make it and proceed to next page
								$.post("/api/install/db/make",
								{
									DbDatabase: $('input#DbDatabase').val()
								},
								function(api, status){
									console.log('db/make',api);
									if(api.Outcome=="Success"){
										$('div.installpage').hide();
										$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');			
									}else{
										swal('Cole',api.Reason,'error');
									}							
								});
							}else if(api.Status==1){
								// Db already exists, so wipe it and proceed to next page
								swal({
									title: 'Cole',
									text: "You already have a database with that name. This is fine, but we will need to wipe the database before proceeding. You will lose any unsaved data, so it's highly important that you back up any unsaved data before proceeding.",
									type: 'warning',
									showCancelButton: true
								  }).then((result) => {
									if (result.value) {
										// User consented to db wipe
										$.post("/api/install/db/wipe",
										{
											DbDatabase: $('input#DbDatabase').val()
										},
										function(api, status){
											console.log('db/wipe',api);
											$('div.installpage').hide();
											$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');	
										});
									}
								  })
							}
						});
					}else{
						// Cannot set
						swal('Cole',api.Reason,'error');
					}
				});
			}
		}else{			
			// Standard next page
			$('div.installpage').hide();
			$('div.installpage[data-installpage=' + nextPage + ']').fadeIn('fast');		
		}
	});
});