$(function() {
	$( ".content-page[data-module=me] div.btn.ColeModuleTrigger[data-control=edit]" ).click(function() {
	  $('.content-page[data-module=me] .AccountHero').hide();
	});	
		
	Cole.Permissions.Boot(); // Refer to Cole Core for Permissions code	
	
	
	Cole.DataActions = {
		Save: function(Data){
			if(Data.DataActionResult.Plugin.ActiveUser.id == Data.DataActionResult.Plugin.Saved.id){
				// This user is me
				if(Data.DataActionResult.Plugin.Saved.NightMode==1){
					$('body').addClass('NightMode');
				}else{
					$('body').removeClass('NightMode');
				}
			}
		}	
	};
	
});

function PermissionSave(Module,Permission,Status){

	if(Status==true){
		Status = 1;
	}else{
		Status = 0;
	}
	
	var Save = {
		Module: Module,
		User: parseInt($('div.ColeEditToolbar[data-module=me]').attr('data-itemid'))
	};
	Save[Permission] = Status;
	
	$.post("/Cole/Permissions/Save",Save,
    function(api, status){
        console.log('Permissions saved: ',api);
    });
}

$( "body" ).off( "click", "div.content-page[data-module=me] div.ProfilePictures img");
$('body').on('click', 'div.content-page[data-module=me] div.ProfilePictures img', function() {
	if($(this).hasClass('New')){
		// Upload new image
		$('form#ColeUpload input#fileToUpload').click();
	}else{
		$('div.left.side-menu img.img-circle.img-thumbnail.img-responsive').attr('src',$(this).attr('src'));
		// Set the profile picture
		$.post("/ColeAccounts/SetProfilePicture",{
			ProfilePicture: $(this).attr('src')
		},
		function(api, status){
			console.log(api);
		});
	}
});


var files;
$( "body" ).off( "change", "form#ColeUpload input#fileToUpload");
$('body').on('change', "form#ColeUpload input#fileToUpload", prepareUpload);

function prepareUpload(event){
	$('body').addClass('Loading');
  files = event.target.files;
  $('form#ColeUpload').submit();
}

$( "body" ).off( "submit", "form#ColeUpload");
$('body').on('submit', "form#ColeUpload", uploadFiles);

function uploadFiles(event){
	$('.ColeImage.Folders,.ColeImage.Files').fadeOut('fast');
	event.stopPropagation(); // Stop stuff happening
	event.preventDefault(); // Totally stop stuff happening
	

	// Create a formdata object and add the files
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});

	$.ajax({
		url: '/api/me/profilepicture/upload?files',
		type: 'POST',
		data: data,
		cache: false,
		dataType: 'json',
		processData: false, // Don't process the files
		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		success: function(data, textStatus, jqXHR)
		{
			if(typeof data.error === 'undefined'){
				// Success so call function to process the form
				submitForm(event, data);
			}else{
				// Handle errors here
				console.log('ERRORS: ' + JSON.stringify(data));
				swal(
					'Cole',
					'Sorry, an error occurred uploading this image. Please contact support.',
					'error'
				);
				$('.ColeImage.Folders,.ColeImage.Files').fadeIn('fast');
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			$('body').removeClass('Loading');
			// Handle errors here
			console.log('ERRORS: ' + jqXHR, textStatus, errorThrown);
			swal(
				'Cole',
				'Sorry, an error occurred uploading this image. Please contact support.',
				'error'
			);
			$('.ColeImage.Folders,.ColeImage.Files').fadeIn('fast');
		}
	});
}
function submitForm(event, data){
  // Create a jQuery object from the form
	$form = $(event.target);

	// Serialize the form data
	var formData = $form.serialize();

	// You should sterilise the file names
	$.each(data.files, function(key, value)
	{
		formData = formData + '&filenames[]=' + value;
	});
	$.ajax({
		url: '/api/me/profilepicture/upload',
		type: 'POST',
		data: formData,
		cache: false,
		dataType: 'json',
		success: function(data, textStatus, jqXHR)
		{
			if(typeof data.error === 'undefined')
			{
				// Success so call function to process the form
				console.log('SUCCESS:',data);
				$('body').removeClass('Loading');
				var MyID = $('.ColeEditToolbar').data('itemid');

				$('div.left.side-menu img.img-circle.img-thumbnail.img-responsive').attr('src','Storage/ProfilePictures/' + MyID + '_ProfilePicture.jpg?rand=' + Math.random());
				// Set the profile picture
				$.post("/ColeAccounts/SetProfilePicture",{
					ProfilePicture: 'Storage/ProfilePictures/' + MyID + '_ProfilePicture.jpg'
				},
				function(api, status){
					console.log(api);
				});
								
			}
			else
			{
				// Handle errors here
				$('body').removeClass('Loading');
				console.log('ERRORS: ' + data.error);
				swal(
					'Cole',
					'Sorry, an error occurred uploading this image. Please contact support.',
					'error'
				);
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			// Handle errors here
			$('body').removeClass('Loading');
			swal(
				'Cole',
				'Sorry, an error occurred uploading this image. Please contact support.',
				'error'
			);
		},
		complete: function()
		{
			// STOP LOADING SPINNER
			$('body').removeClass('Loading');
		}
	});
}